<?php
header('Content-Type: application/json');

// Giới hạn dung lượng (3MB)
$maxSize = 3 * 1024 * 1024;

// Thư mục lưu ảnh
$uploadDir = _DOMAIN_ROOT_PATH . "/temp/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // Kiểm tra lỗi upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["status" => "error", "message" => "Upload lỗi: " . $file['error']]);
        exit;
    }

    // Kiểm tra dung lượng
    if ($file['size'] > $maxSize) {
        echo json_encode(["status" => "error", "message" => "File quá lớn, tối đa 3MB"]);
        exit;
    }

    // Định dạng cho phép
    $allowedExt = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) {
        echo json_encode(["status" => "error", "message" => "Định dạng không hợp lệ"]);
        exit;
    }

    // Kiểm tra MIME thực sự
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowedMime = ['image/jpeg','image/png','image/gif','image/webp'];
    if (!in_array($mime, $allowedMime)) {
        echo json_encode(["status" => "error", "message" => "File không phải ảnh hợp lệ"]);
        exit;
    }

    // Tạo tên file duy nhất
    $newName = uniqid("img_", true) . "." . $ext;
    $target = $uploadDir . $newName;

    if (move_uploaded_file($file['tmp_name'], $target)) {
        @chmod($target, 0644);
        echo json_encode(["status" => "success", "fileName" => $newName]);
    } else {
        echo json_encode(["status" => "error", "message" => "Không thể lưu file"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Không có file tải lên"]);
}
