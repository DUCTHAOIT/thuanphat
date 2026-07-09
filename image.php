<?php 
if (!isset($_GET['image'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Error: no image was specified';
    exit();
}

define('MEMORY_TO_ALLOCATE', '100M');
define('DEFAULT_QUALITY', 90);
define('CURRENT_DIR', dirname(__FILE__));
define('CACHE_DIR_NAME', '/imagecache/');
define('CACHE_DIR', CURRENT_DIR . CACHE_DIR_NAME);
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

$imagePath = $_GET['image'];

// Check if the image is from an external URL
$isExternal = filter_var($imagePath, FILTER_VALIDATE_URL);
if ($isExternal) {
    // Fetch external image using cURL
    $tempFile = tempnam(sys_get_temp_dir(), 'img_'); // Create a temporary file
    $ch = curl_init($imagePath);
    $fp = fopen($tempFile, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification if needed
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    // Check if the image was downloaded successfully
    if (!file_exists($tempFile) || filesize($tempFile) == 0) {
        header('HTTP/1.1 404 Not Found');
        echo 'Error: unable to fetch image';
        unlink($tempFile);
        exit();
    }
    $image = $tempFile;
} else {
    // Local image
    $image = DOCUMENT_ROOT . '/' . ltrim($imagePath, '/');
}

// Check if the image exists locally
if (!file_exists($image)) {
    header('HTTP/1.1 404 Not Found');
    echo 'Error: image does not exist: ' . $image;
    exit();
}

$size = getimagesize($image);
$mime = $size['mime'];

if (substr($mime, 0, 6) != 'image/') {
    header('HTTP/1.1 400 Bad Request');
    echo 'Error: requested file is not an accepted type: ' . $image;
    exit();
}

$width = $size[0];
$height = $size[1];
$maxWidth = isset($_GET['width']) ? (int) $_GET['width'] : 0;
$maxHeight = isset($_GET['height']) ? (int) $_GET['height'] : 0;

// Resize logic here as needed (same as original code)

// Output the resized image
header("Content-type: $mime");
readfile($image);

// Cleanup temporary file if fetched via cURL
if ($isExternal && file_exists($tempFile)) {
    unlink($tempFile);
}
?>
