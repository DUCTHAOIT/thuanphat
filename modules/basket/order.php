<?php
include_once("header.php");
include('phpmailer/class.smtp.php');
include "phpmailer/class.phpmailer.php";
include_once("phpmailer/config.php");
require_once dirname(__FILE__) . '/../../admin80/include/order_commission.php';
global $db;

$user_id = (int) getParamPost("user_id");

// Lấy danh sách sản phẩm từ session
$products = [];
foreach ($_SESSION["basket"] as $product_id => $item) {
    $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;
    $products[$product_id] = $quantity;
}

// Tính tổng tiền và lưu vào mảng sản phẩm
$total_amount = 0;
$order_items = [];
$product_lines = [];

foreach ($products as $product_id => $quantity) {
    $result = $mysqli->query("SELECT name, price FROM sys_product WHERE id = $product_id");
    $product = $result->fetch_assoc();
    $name = $product['name'];
    $price = (int)$product['price'];
    $total = $price * $quantity;
    $total_amount += $total;

    $order_items[] = [
        'product_id' => $product_id,
        'quantity' => $quantity,
        'price' => $price
    ];
}

// Thông tin người mua
$name = getParamPost("name");
$mobile = trim(getParamPost("mobile"));
$address = getParamPost("address");
$email = trim(getParamPost("email"));
$note = getParamPost("otherinfo");

// Upload ảnh
if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = _DOMAIN_ROOT_PATH . '/images/order/';
    $ext = strtolower(pathinfo($_FILES['imageUpload']['name'], PATHINFO_EXTENSION));
    $filename = time() . '_' . uniqid() . '.' . $ext;
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        move_uploaded_file($_FILES['imageUpload']['tmp_name'], $uploadDir . $filename);
        $fileName = $filename;
    } else {
        $fileName = '';
    }
} else {
    $fileName = $_POST['fileName'] ?? '';
}
$img = $fileName;

// Chuỗi sản phẩm lưu vào DB
$products_text = "";
foreach ($products as $product_id => $quantity) {
    $result = $mysqli->query("SELECT name, price FROM sys_product WHERE id = $product_id");
    $product = $result->fetch_assoc();
    $line_total = $product['price'] * $quantity;
    $products_text .= $product['name'] . ": " . number_format($product['price'], 0, ',', '.') . "đ x $quantity = " . number_format($line_total, 0, ',', '.') . "đ\n";
}

// Tạo đơn hàng + trừ điểm thẻ/ví thanh toán (mục 3 BUSINESS_RULES.md, cập nhật 2026-07-11) trong cùng 1
// transaction (mục 8.2). Khách tự chọn nguồn muốn dùng bằng checkbox trên trang giỏ hàng; trong các nguồn
// đã chọn, hệ thống vẫn áp đúng thứ tự ưu tiên: điểm thẻ tiêu dùng -> ví tiêu dùng -> ví khả dụng -> còn
// lại chuyển khoản (luồng upload ảnh chứng từ có sẵn, không đổi). Trừ ngay lúc đặt đơn (trước khi admin
// duyệt) - nếu đơn bị admin từ chối sau đó thì được hoàn lại (processOrderRejection() trong
// order_commission.php).
// Kiểm tra lại ở server nguồn nào được TẤT CẢ sản phẩm trong giỏ chấp nhận (mục 3, cập nhật 2026-07-11) -
// không tin trực tiếp lựa chọn từ client vì checkbox có thể bị ẩn/khoá sai qua sửa HTML.
$acceptedSources = getAcceptedPaymentSources();
$useCard = (getParamPost("use_card") ? true : false) && $acceptedSources['accept_card'];
$useTieuDung = (getParamPost("use_tieu_dung") ? true : false) && $acceptedSources['accept_tieu_dung'];
$useKhaDung = (getParamPost("use_kha_dung") ? true : false) && $acceptedSources['accept_kha_dung'];

$mysqli->begin_transaction();
try {
    $sql_order = "INSERT INTO orders (user_id, amount, img, products, name, email, mobile, address, note, status)
    VALUES (
        $user_id,
        $total_amount,
        '$img',
        '" . $mysqli->real_escape_string($products_text) . "',
        '$name',
        '$email',
        '$mobile',
        '$address',
        '$note',
        'pending'
    )";

    if (!$mysqli->query($sql_order)) {
        $mysqli->rollback();
        exit;
    }

    $order_id = $mysqli->insert_id;

    // Lưu từng sản phẩm vào order_items
    foreach ($order_items as $item) {
        $mysqli->query("INSERT INTO order_items (order_id, product_id, quantity, price)
                        VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})");
    }

    $cardAmount = 0;
    $tieuDungAmount = 0;
    $khaDungAmount = 0;
    $remaining = $total_amount;

    if ($useCard && $remaining > 0) {
        $stmt = $mysqli->prepare("SELECT value FROM sys_config WHERE name = 'card_payment_percent' AND lang = 'vn'");
        $stmt->execute();
        $cardPaymentPercent = (float) ($stmt->get_result()->fetch_assoc()['value'] ?? 100);
        $stmt->close();

        $maxCardByPercent = $total_amount * ($cardPaymentPercent / 100);
        $cardAmount = debitConsumptionCardUpTo($mysqli, $user_id, min($remaining, $maxCardByPercent));
        $remaining -= $cardAmount;
    }

    if ($useTieuDung && $remaining > 0) {
        $tieuDungAmount = debitWalletUpTo($mysqli, $user_id, 'tieu_dung', $remaining, 'order', $order_id);
        $remaining -= $tieuDungAmount;
    }

    if ($useKhaDung && $remaining > 0) {
        $khaDungAmount = debitWalletUpTo($mysqli, $user_id, 'kha_dung', $remaining, 'order', $order_id);
        $remaining -= $khaDungAmount;
    }

    $cashAmount = $remaining;
    $commissionBaseAmount = $total_amount - $cardAmount;

    $stmt = $mysqli->prepare("INSERT INTO order_payments (order_id, card_amount, tieu_dung_amount, kha_dung_amount, cash_amount, commission_base_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iddddd", $order_id, $cardAmount, $tieuDungAmount, $khaDungAmount, $cashAmount, $commissionBaseAmount);
    $stmt->execute();
    $stmt->close();

    $mysqli->commit();
} catch (Throwable $e) {
    $mysqli->rollback();
    error_log("modules/basket/order.php user_id={$user_id}: " . $e->getMessage());
    exit;
}

// Thông báo Telegram cho admin biết có đơn hàng mới cần duyệt (mục 12 BUSINESS_RULES.md)
sendTelegramNotify(
    "🛒 <b>Đơn hàng mới #{$order_id}</b>\n" .
    "Khách hàng: " . htmlspecialchars($name) . "\n" .
    "SĐT: " . htmlspecialchars($mobile) . "\n" .
    "Tổng tiền: " . number_format($total_amount, 0, ',', '.') . "đ\n" .
    "- Điểm thẻ tiêu dùng: " . number_format($cardAmount, 0, ',', '.') . "đ\n" .
    "- Ví tiêu dùng: " . number_format($tieuDungAmount, 0, ',', '.') . "đ\n" .
    "- Ví khả dụng: " . number_format($khaDungAmount, 0, ',', '.') . "đ\n" .
    "- Còn lại chuyển khoản: " . number_format($cashAmount, 0, ',', '.') . "đ\n" .
    "Sản phẩm:\n" . htmlspecialchars($products_text),
    TELEGRAM_CHAT_ID_ORDER
);

// Hoa hồng KHÔNG được sinh ở đây nữa. Theo BUSINESS_RULES.md mục 3:
// "Hoa hồng chỉ sinh sau khi đơn được duyệt" - việc sinh hoa hồng 9 tầng
// đã được xử lý tại admin80/include/order_commission.php khi admin duyệt đơn.

// Gửi email xác nhận
$emailFrom = $email;
$nameFrom = $name;
$emailTo = getSession("email");
$nameTo = getSession("email");
$subject = "Đơn đặt hàng";

$HTML = "<br><b>Thông tin vận chuyển:</b>";
$HTML .= "<br>Họ tên: " . $name;
$HTML .= "<br>Điện thoại: " . $mobile;
$HTML .= "<br>Địa chỉ: " . $address;
$HTML .= "<br>Lưu ý: " . $note;
$HTML .= "<br><br><b>Thông tin đơn hàng:</b>";
$HTML .= "<br>" . nl2br($products_text);
$HTML .= "<br>Tổng Tiền: " . number_format($total_amount, 0, ',', '.') . "đ";
$HTML .= "<br>- Điểm thẻ tiêu dùng: " . number_format($cardAmount, 0, ',', '.') . "đ";
$HTML .= "<br>- Ví tiêu dùng: " . number_format($tieuDungAmount, 0, ',', '.') . "đ";
$HTML .= "<br>- Ví khả dụng: " . number_format($khaDungAmount, 0, ',', '.') . "đ";
$HTML .= "<br>- Còn lại chuyển khoản: " . number_format($cashAmount, 0, ',', '.') . "đ";

$mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc = '', $emailFrom, $nameFrom);
if ($mail == 1) {
    sendMailer($subject, $HTML, $nameFrom, $emailFrom, $diachicc = '', $emailTo, $nameTo);
    echo "<div style=\"padding-top:160px; padding-bottom:160px;\" align=\"center\">
        <strong>Đơn hàng của quý khách đã được đặt thành công, chúng tôi sẽ liên hệ lại ngay với quý khách</strong></div>";
} else {
    echo "<div style=\"padding-top:160px; padding-bottom:160px;\" align=\"center\">
        <strong>" . $lable->_("Có lỗi xảy ra, xin cấu hình lại mail trên server") . "</strong>
        </div>";
}

unset($_SESSION["basket"]);
include_once("footer.php");
