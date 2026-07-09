<?php
include_once("header.php");
include('phpmailer/class.smtp.php');
include "phpmailer/class.phpmailer.php";
include_once("phpmailer/config.php");
global $db;

$user_id = getParamPost("user_id");

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

// Tạo đơn hàng
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
    exit;
}

$order_id = $mysqli->insert_id;

// Lưu từng sản phẩm vào order_items
foreach ($order_items as $item) {
    $mysqli->query("INSERT INTO order_items (order_id, product_id, quantity, price)
                    VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})");
}

// Hoa hồng KHÔNG được sinh ở đây nữa. Theo BUSINESS_RULES.md mục 2:
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
