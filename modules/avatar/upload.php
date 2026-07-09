<?php

global $db, $lable,$lang;

$username=getSession("username");

define("IMAGE_DIR", dirname(__FILE__) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR);

define("BASE_URL", ""._DOMAIN_ROOT_URL."/modules/avatar/");

if (!is_dir(IMAGE_DIR))

    mkdir(IMAGE_DIR);



if (!function_exists('getImageUrl')) {

    function getImageUrl($name) {

        return rtrim(trim(BASE_URL), '/') . "/images/$name";

    }

}



$response = ['status' => 'failed'];



if (isset($_FILES['uploadAvatar'])) {

    $fileUpload = $_FILES['uploadAvatar'];

    $fileName = hash("md5", uniqid()) . "." . pathinfo($fileUpload['name'], PATHINFO_EXTENSION);

    $targetFile = rtrim(trim(IMAGE_DIR), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName;

    move_uploaded_file($fileUpload['tmp_name'], $targetFile);



    $sql="UPDATE `user` SET avata='".$fileName."' WHERE (`email`='$username')";

    $db->Execute($sql);



    $response['status'] = 'ok';

    $response['uploaded_url'] = getImageUrl($fileName);

} else {

    $response['message'] = "The uploaded file not found.";

}



echo json_encode($response);

