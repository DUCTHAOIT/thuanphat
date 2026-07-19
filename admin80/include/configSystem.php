<?php
ini_set("session.gc_maxlifetime","8640000");
ini_set("session.use_trans_sid","on");
session_start();

// Cau hinh path

$serverName = strtolower($_SERVER['SERVER_NAME']);

// _DOMAIN_ROOT_PATH tu nhan dien theo vi tri file dang chay (khong hardcode nua,
// tranh phai sua tay moi lan doi hosting). File nay nam o admin80/include/,
// nen thu muc goc web = lui len 2 cap.
define('_DOMAIN_ROOT_PATH', str_replace('\\', '/', dirname(__DIR__, 2)));

if (
    $serverName == 'localhost' ||
    $serverName == 'thuanphatitc.local'
) {

    // define('_DOMAIN_ROOT_PATH','C:/xampp/htdocs/thuanphatitc.vn'); // cu, da thay bang dong tu nhan dien o tren
    define('_DOMAIN_ROOT_URL','http://'.$serverName);

} else {

    // define('_DOMAIN_ROOT_PATH','/www/wwwroot/thuanphatitc.vn'); // cu (host cu), da thay bang dong tu nhan dien o tren
    define('_DOMAIN_ROOT_URL','https://'.$serverName);

}

define('KEYMAPS' , 'AIzaSyDLadkw1p1dBOqRVpItGGbgx-zyKjkOsWw');
define('_PREFIX' , "dmonline_");
define('_MARK' , 'tab');
define('_ID_PRODUCT' , 'dichvu');
define('_ID_ARTICLE' , 'maa');
define('_CHARSET' , "utf-8");
define("UPLOADTYPE",".zip,.rar,.pdf,.doc,.bmp,.jpg,.jpeg,.gif,.png,.swf,.xls,.flv");

?>