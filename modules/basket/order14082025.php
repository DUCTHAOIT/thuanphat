<?php
include_once("header.php");
include('phpmailer/class.smtp.php');
include "phpmailer/class.phpmailer.php";
include_once("phpmailer/config.php");
global $db;
// lay % cac f
$sql="SELECT * FROM sys_config WHERE (name='f1') AND (lang='$lang')";
$rs=$db->Execute($sql);
$f1=$rs->fields('value');

$sql="SELECT * FROM sys_config WHERE (name='f2') AND (lang='$lang')";
$rs=$db->Execute($sql);
$f2=$rs->fields('value');

$sql="SELECT * FROM sys_config WHERE (name='f3') AND (lang='$lang')";
$rs=$db->Execute($sql);
$f3=$rs->fields('value');

$user_id = getParamPost("user_id");

// Lấy danh sách sản phẩm từ session
$products = [];
foreach ($_SESSION["basket"] as $product_id => $item) {
    $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;
    $products[$product_id] = $quantity;
}

// Tính tổng tiền và tạo nội dung mô tả đơn hàng
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

    // Định dạng tiền tệ: 1 000 đ
    /*$line = "{$name}: " . number_format($price, 0, ',', ' ') . "đ x $quantity = " . number_format($total, 0, ',', ' ') . "đ <br>";
    $product_lines[] = $line;*/

    $order_items[] = [
        'product_id' => $product_id,
        'quantity' => $quantity,
        'price' => $price
    ];
}

// Ghép thành chuỗi lưu vào DB
$product_details = implode("\n", $product_lines);

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

// Tạo đơn hàng và lưu sản phẩm dạng text vào trường "products"
$products_text = ""; // Chuỗi sản phẩm để lưu vào trường products
foreach ($products as $product_id => $quantity) {
    $result = $mysqli->query("SELECT name, price FROM sys_product WHERE id = $product_id");
    $product = $result->fetch_assoc();
    $line_total = $product['price'] * $quantity;
    $products_text .= $product['name'] . ": " . number_format($product['price'], 0, ',', '.') . "đ x $quantity = " . number_format($line_total, 0, ',', '.') . "đ\n";
}

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

//echo "<pre>$sql_order</pre>"; // In ra câu SQL

if (!$mysqli->query($sql_order)) {
    //echo "❌ Lỗi khi thêm đơn hàng: " . $mysqli->error;
    exit;
}

$order_id = $mysqli->insert_id;

/*$stmt = $mysqli->prepare("INSERT INTO orders (user_id, amount, img, name, mobile, email, address, note, products, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("iissssssss", $user_id, $total_amount, $img, $name, $mobile, $email, $address, $note, $product_details);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();*/

// Lưu từng sản phẩm
foreach ($order_items as $item) {
    $mysqli->query("INSERT INTO order_items (order_id, product_id, quantity, price)
                    VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})");
}

// Hoa hồng cho F2
$mysqli->query("INSERT INTO commissions (order_id, user_id, level, amount)
                VALUES ($order_id, $user_id, 0, $total_amount * $f1)");

// F1
$result = $mysqli->query("SELECT ref_by FROM user WHERE id = $user_id");
$f1_id = $result->fetch_assoc()['ref_by'];
if ($f1_id) {
    $mysqli->query("INSERT INTO commissions (order_id, user_id, level, amount)
                    VALUES ($order_id, $f1_id, 1, $total_amount * $f2)");
    $result = $mysqli->query("SELECT ref_by FROM user WHERE id = $f1_id");
    $f0_id = $result->fetch_assoc()['ref_by'];
    if ($f0_id) {
        $mysqli->query("INSERT INTO commissions (order_id, user_id, level, amount)
                        VALUES ($order_id, $f0_id, 2, $total_amount * $f3)");
    }
}

// Gửi email
$emailFrom = $email;
$nameFrom = $name;
$emailTo = getSession("email");
$nameTo = getSession("email");
$subject = "Đơn đặt hàng";

$HTML="<br><b>Thông tin vận chuyển:</b>";
$HTML .= "<br>Họ tên: ".$name;
$HTML .= "<br>Điện thoại: ".$mobile;
$HTML .= "<br>Địa chỉ: ".$address;
$HTML .= "<br>Lưu ý: ".$note;
$HTML .="<br><br><b>Thông tin đơn hàng:</b>";
$HTML .= "<br>".nl2br($products_text); // Nội dung hiển thị trong email
$HTML .= "<br>Tổng Tiền: ".number_format($total_amount, 0, ',', '.') . "đ";


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
//session_destroy();
include_once("footer.php");
?>
