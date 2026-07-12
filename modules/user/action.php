<?php
function createRegister_()
{
    include_once("header.php");
    global $db, $lable;
    include_once(_DOMAIN_ROOT_PATH . "/phpmailer/class.smtp.php");
    include_once(_DOMAIN_ROOT_PATH . "/phpmailer/class.phpmailer.php");
    include_once(_DOMAIN_ROOT_PATH . "/phpmailer/config.php");
    require(_DOMAIN_ROOT_PATH . "/modules/newsletter/functions.php");

    //$txtUsername=getParamPost("txtUsername");
    $txtUsername = getParamPost("txtEmail");
    $txtEmail = getParamPost("txtEmail");
    $txtPassword = md5(getParamPost("txtPassword"));
    $name = getParamPost("name");
    $mobile = getParamPost("mobile");
    $random_key = random_string('alnum', 32);
    $gioithieu = getParamPost("gioithieu");

    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    if (!$captcha) {
        echo 'Please check the the captcha form.';
        exit;
    }
    $secretKey = "6LcI2mYkAAAAAEQvS2qBRVlBSeoSwWQ_vFIE3irt";
    $ip = $_SERVER['REMOTE_ADDR'];
    // post request to server
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"]) {

        $record = array();
        $record["username"] = $txtUsername;
        $record["email"] = $txtEmail;
        $record["password"] = $txtPassword;
        $record["name"] = $name;
        $record["mobile"] = $mobile;
        $record["gioithieu"] = $gioithieu;
        $record["random_key"] = $random_key;

        $sql = "SELECT * FROM user WHERE 0 = -1";
        $rs = $db->Execute($sql);
        $sql = $db->GetInsertSQL($rs, $record);
        $return = $db->Execute($sql);
        $idNew = $db->Insert_ID();

        $to = $txtEmail;

        $subject = "Xác nhận đăng ký tài khoản trên " . _DOMAIN_ROOT_URL . ".<br><br>";
        //$message = "Xin chào! cảm ơn bạn đã đăng ký tài khoản trên website "._DOMAIN_ROOT_URL.". Bạn hãy click vào link bên dưới để xác nhận việc đăng ký:"._DOMAIN_ROOT_URL."/?m=user&f=confirm&id=".mysql_insert_id()."&key=".$random_key."<br><br>";
        $message = "<b>Kính gửi quý khách hàng " . $name . "</b><br><br>";
        $message .= "Cảm ơn bạn đã đăng ký tài khoản trên website " . _DOMAIN_ROOT_URL . ". <br><br>";
        $message .= "Tên đăng nhập: " . $txtEmail . " hoặc " . $mobile . " <br><br>";
        $message .= "Mật khẩu: quý khách đã đăng ký online <br><br>";

        $message .= "Để kích hoạt tài khoản, quý khách vui lòng click vào link:" . _DOMAIN_ROOT_URL . "/?m=user&f=confirm&id=" . $idNew . "&key=" . $random_key . "<br><br>";

        //
        $emailFrom        = getSession("email");
        $nameFrom        = _DOMAIN_ROOT_URL;
        $emailTo          = $to;
        $nameTo            = $name;
        $subject         = $subject;
        $content        = $message;

        $TEXT = "";
        $HTML = "<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #154491;\">";
        $HTML .= $content;
        $HTML .= "</span>";

        $mail = sendMailer($subject, $message, $name, $txtEmail, $diachicc = '', $emailFrom, $nameFrom);
        if ($mail == 1) {
            echo "<div style=\"padding-top:60px; padding-bottom:160px; padding-left:20px; padding-right:20px\" align=\"center\">
				<strong>Đăng ký thành công! mời bạn kiểm tra mail để kích hoạt tài khoản</a>.
				</div>";
        } else {
            echo "<div style=\"padding-top:60px; padding-bottom:160px; padding-bottom:100px; padding-left:20px; padding-right:20px\" align=\"center\">
				<strong>" . $lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever") . " </strong>
				</div>";
        }
    } else {
        echo 'You are spammer ! Get the @$%K out';
    }
    include_once("footer.php");
}
function createRegister()
{
    include_once("header.php");
    $username = getSession("username");
    if ($username) {
        include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
        $ret_page = "../";
        $a = new msgBox("Bạn cần đăng xuất tài khoản hiện có", "OKOnly", "Message", array($ret_page), 5);
        $a->showMsg();
        return;
    }

    include('phpmailer/class.smtp.php');
    include "phpmailer/class.phpmailer.php";
    include_once("phpmailer/config.php");

    global $db, $lable;
    require(_DOMAIN_ROOT_PATH . "/modules/newsletter/functions.php");
    $txtUsername = trim(getParamPost("txtEmail"));
    $txtEmail = trim(getParamPost("txtEmail"));
    $txtPassword = md5(getParamPost("txtPassword"));
    $name = getParamPost("name");
    //$mobile=trim(getParamPost("mobile"));
    //$mobile = preg_replace('/\s+/', '', trim(getParamPost("mobile")));
    $mobile = preg_replace('/[^0-9+]/', '', trim(getParamPost("mobile")));

    if (!preg_match('/^(0[3|5|7|8|9][0-9]{8}|84[3|5|7|8|9][0-9]{8}|\+84[3|5|7|8|9][0-9]{8})$/', $mobile)) {
        echo '<div style="padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px; font-size:14px" align="center">
				<strong>Số điện thoại không hợp lệ.</strong>
			  </div>';
        include_once("footer.php");
        return;
    }

    $address = getParamPost("address");
    $cmnd = getParamPost("cmnd");
    //$gioithieu=trim(getParamPost("gioithieu"));
    $gioithieu = preg_replace('/\s+/', '', trim(getParamPost("gioithieu")));

    $ref_by = getUsersID($gioithieu, "id");
    $random_key = random_string('alnum', 32);


    /*if(isset($_POST['g-recaptcha-response'])){
      $captcha=$_POST['g-recaptcha-response'];
    }
    if(!$captcha){
      echo 'Please check the the captcha form.';
      exit;
    }
    $secretKey = "6LcI2mYkAAAAAEQvS2qBRVlBSeoSwWQ_vFIE3irt";
    $ip = $_SERVER['REMOTE_ADDR'];
    // post request to server
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);

    if($responseKeys["success"]) {*/

    $sql = "SELECT * FROM user WHERE email = '$txtEmail'";
    $rs = $db->Execute($sql);
    if (!$rs->fields("email")) {

        $record = array();
        $record["username"] = $txtUsername;
        $record["email"] = $txtEmail;
        $record["password"] = $txtPassword;
        $record["name"] = $name;
        $record["mobile"] = $mobile;
        $record["address"] = $address;
        $record["cmnd"] = $cmnd;
        $record["gioithieu"] = $gioithieu;
        $record["ref_by"] = $ref_by;

        $record["img"] = $img;
        $record["rand_key"] = $random_key;

        $sql = "SELECT * FROM user WHERE 0 = -1";
        $rs = $db->Execute($sql);
        $sql = $db->GetInsertSQL($rs, $record);

        $return = $db->Execute($sql);
        $idNew = $db->Insert_ID();

        $subject = "Xác nhận đăng ký tài khoản trên " . _DOMAIN_ROOT_URL . ".<br><br>";
        $message = "<b>Kính gửi quý khách hàng " . $name . "</b><br><br>";
        $message .= "Cảm ơn bạn đã đăng ký tài khoản trên website " . _DOMAIN_ROOT_URL . ". <br><br>";
        $message .= "Tên đăng nhập: " . $txtEmail . " hoặc " . $mobile . " <br><br>";
        $message .= "Mật khẩu: quý khách đã đăng ký online <br><br>";
        $message .= "Để kích hoạt tài khoản, quý khách vui lòng click vào link:" . _DOMAIN_ROOT_URL . "/?m=user&f=confirm&id=" . $idNew . "&key=" . $random_key . "<br><br>";


        //
        $emailFrom        = getSession("email");
        $nameFrom        = getSession("email");
        //$emailTo      	= "vnhomestay.com.vn@gmail.com";
        $emailTo          = $txtEmail;
        $nameTo            = $name;
        $subject         = "Xác nhận đăng ký tài khoản";
        $content        = $message;



        $TEXT = "";
        $HTML = "<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
        $HTML .= $message;
        $HTML .= "</span>";

        $HTML2 = "<span style=\"font-family: Arial, Helvetica, sans-serif;font-size: 12px;\">";
        $HTML2 .= "Có tài khoản tạo mới.<br />--------------------------------<br />";
        $HTML2 .= "</span>";
        $HTML2 .= $HTML;


        $mail = sendMailer($subject, $HTML, $nameTo, $emailTo, $diachicc = '', $emailFrom, $nameFrom);
        if ($mail == 1) {
            $mail = sendMailer($subject, $HTML2, $nameFrom, $emailFrom, $diachicc = '', $emailTo, $nameTo);
            echo '<div style="padding-top:160px; padding-bottom:160px; line-height:30px; font-size:14px" class="title" align="center">					
						Quý khách đã đăng ký thành viên thành công, xin kiểm tra mail và kích hoạt tài khoản.</div>';
        } else {
            echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px; font-size:14px\" align=\"center\">
			<strong>" . $lable->_("Có lỗi sảy ra, xin cấu hình lại mail trên sever") . " </strong>
			</div>";
        }
    } else {
        echo "<div style=\"padding-top:100px; padding-bottom:100px; padding-left:20px; padding-right:20px; font-size:14px\" align=\"center\">
			<strong>Email đã được đăng ký</strong>
			</div>";
    }
    /*}else{
            echo 'You are spammer ! Get the @$%K out';
    }*/
    include_once("footer.php");
}
//
function randPasword()
{
    include_once("header.php");
    include('phpmailer/class.smtp.php');
    include "phpmailer/class.phpmailer.php";
    include_once("phpmailer/config.php");
    global $db, $lable;
    //$username=getParamPost("txtUsername");
    $email = getParamPost("txtEmail");
    $sql = "SELECT * FROM user WHERE ((email='$email') OR (mobile='$email'))";
    $rs = $db->Execute($sql);

    if ($rs->fields("email")) {
        $password = uniquename();
        $sql = "UPDATE user SET password='" . md5($password) . "' WHERE email='$email'";
        $db->Execute($sql);

        $emailFrom        = getSession("email");
        $nameFrom        = getSession("site_name");
        $emailTo          = $rs->fields("email");
        $nameTo            = $rs->fields("name");

        $subject = "Lấy lại mật khẩu trên " . _DOMAIN_ROOT_URL . "";
        //$message = "Xin chào! cảm ơn bạn đã đăng ký tài khoản trên website "._DOMAIN_ROOT_URL.". Bạn hãy click vào link bên dưới để kích hoạt tài khoản:"._DOMAIN_ROOT_URL."/?m=user&f=confirm&id=".$idNew."&key=".$random_key."<br><br>";

        //$content 		= $lable->_("Hello")." <b>". $rs->fields("username")."</b><p> ".$lable->_("Account on website") . "<a href=\""._DOMAIN_ROOT_URL."\">"._DOMAIN_ROOT_URL."</a></br>".$lable->_("Choose a password").": ". $password ."<p>";
        //	$content 		.= ;
        //$content 		.= $lable->_("User name").": ". $rs->fields("username")."<p>";
        $content         = "<table width=\"100%\" border=\"0\" cellspacing=\"10\" cellpadding=\"0\">
							  <tr>							
								<td align=\"left\">Xin chào " . $rs->fields("name") . "</td>
							  </tr>
							 <tr>							
								<td align=\"left\">Thông tin tài khoản của bạn:</td>
							  </tr>
							  <tr>								
								<td align=\"left\">Tên đăng nhập: " . $rs->fields("username") . " hoặc " . $rs->fields("mobile") . "</td>
							  </tr>
							  <tr>								
								<td align=\"left\">Mật khẩu mới: " . $password . "</td>
							  </tr>
							</table>";

        $resurn = sendMailer($subject, $content, $nameTo, $emailTo, $diachicc = '', $emailFrom, $nameFrom);
        if ($resurn)    $note = "Mật khẩu mới đã được gửi về địa chỉ mail của bạn, vui lòng kiểm tra mail để lấy thông tin";
        else $note = $lable->_("Có lỗi sảy ra");
    } else {
        $note = $lable->_("Email này chưa đăng ký tài khoản");
    }


    echo "<div style=\"padding-top:100px; padding-bottom:130px;  text-align:center; font-weight:bold; font-size:14px\">" . $note . "</div>";
    include_once("footer.php");
}
//
function godetele()
{
    global $db;
    $username = getSession("username");
    if (!$username) return;

    $id = getParam("id");

    $userid = getMemberNameID($username, "id");
    $sql = "DELETE FROM  sys_userorder WHERE (id=$id) AND (userid=$userid)";
    $result = $db->Execute($sql);

    include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
    $ret_page = "../user_project/";

    if ($result) {
        $a = new msgBox("Please wait...", "OKOnly", "Message", array($ret_page), 1);
        $a->showMsg();
    } else {
        $a = new msgBox("false!", "OKOnly", "Message", array($ret_page), 1);
        $a->showMsg();
    }
}

function userLogin()
{
    global $db, $moduleName;
    $email = getParamPost("email");
    $password = getParamPost("password");
    $ret_page = getParamPost("ret_page");
    $mName = getParamPost("mName");
    $sql = "SELECT * FROM user WHERE (email='$email') OR (mobile='$email')";

    $rs = $db->Execute($sql);

    //$affiliate_id=$email;

    $isAjax = (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest');

    $ret_page = getParamPost("ret_page");
    if (!$ret_page) {
        $ret_page = getSession("ret_page");
        if (!$ret_page) $ret_page = _DOMAIN_ROOT_URL . "/user_dashboard/";
    }

    $login_page = $_SERVER['HTTP_REFERER'];
    if (!$login_page) $login_page = _DOMAIN_ROOT_URL . "/user_login/";

    if (!$rs->fields("email")) {
        $login_error = "Tài khoản chưa được đăng ký";
        if ($isAjax) {
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => $login_error));
            exit;
        }
        setSession("login_error", $login_error);
        header("Location: " . $login_page);
        exit;
    } elseif (!($rs->fields("ctrl") & 1)) {
        $login_error = "Tài khoản chưa được kích hoạt";
        if ($isAjax) {
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => $login_error));
            exit;
        }
        setSession("login_error", $login_error);
        header("Location: " . $login_page);
        exit;
    } elseif ($rs->fields("password") != md5($password)) {
        $login_error = "Mật Khẩu Không Đúng";
        if ($isAjax) {
            header("Content-Type: application/json");
            echo json_encode(array("success" => false, "message" => $login_error));
            exit;
        }
        setSession("login_error", $login_error);
        header("Location: " . $login_page);
        exit;
    } else {
        $affiliate_id = $rs->fields("mobile");
        if ($mName != 'home') {
            $ret_page = $ret_page . "&aff=" . $affiliate_id;
        } else {
            $ret_page = $ret_page . "?aff=" . $affiliate_id;
        }
        setSession("username", $rs->fields("username"));
        setSession("login_time_stamp", time());
        setcookie("affiliate_id", $affiliate_id, time() + (8640 * 30), "/");
        $MemberName = $rs->fields("name");
        if ($isAjax) {
            header("Content-Type: application/json");
            echo json_encode(array("success" => true, "redirect" => $ret_page));
            exit;
        }
        include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
        $a = new msgBox("Please wait...", "OKOnly", "Message", array($ret_page), 1);
        $a->showMsg();
    }
    setSession("ret_page", "");
}

function getMemberID($username)
{
    global $db;
    if (!$username) return;
    $sql = "SELECT * FROM user WHERE (username='$username') AND (ctrl&1=1)";
    $rs = $db->Execute($sql);
    $arr = $rs->fields;
    if (!$arr["img"]) $arr["imgs_view"] = _DOMAIN_ROOT_URL . "/images/nonecccdt.gif";
    else $arr["imgs_view"] = _DOMAIN_ROOT_URL . "/images/user/" . $arr["img"];
    if (!$arr["img1"]) $arr["imgb_view"] = _DOMAIN_ROOT_URL . "/images/nonecccds.gif";
    else $arr["imgb_view"] = _DOMAIN_ROOT_URL . "/images/user/" . $arr["img1"];
    return $arr;
}
//
function changeInfo()
{
    global $db, $lable;
    $username = getSession("username");
    if (!$username) return;

    $txtUsername = getParamPost("txtEmail");
    $txtEmail = getParamPost("txtEmail");
    $txtPassword = getParamPost("txtPassword");
    $name = getParamPost("name");
    $address = getParamPost("address");
    $mobile = getParamPost("mobile");
    $cmt = getParamPost("cmt");
    $tknh = getParamPost("tknh");

    $imgsmall = getParamPost("imgsmall");
    $imgbig = getParamPost("imgbig");

    $filePDF = getParamPost("filePDF");

    $sinhngay = getParamPost("sinhngay");
    $sex = getParamPost("sex");
    $ngaycmt = getParamPost("ngaycmt");
    $noicapcmt = getParamPost("noicapcmt");
    $tenchutknh = getParamPost("tenchutknh");
    $nganhangtknh = getParamPost("nganhangtknh");
    $chinhanhtknh = getParamPost("chinhanhtknh");

    //if($filePDF){
    //	$from=_DOMAIN_ROOT_PATH."/temp/$filePDF";
    //	$to=_DOMAIN_ROOT_PATH."/images/user/$filePDF";
    //	moveFile($from,$to);
    //}


    //$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgsmall;
    if ($imgsmall) {
        $from = _DOMAIN_ROOT_PATH . "/temp/" . $imgsmall;
        $to = _DOMAIN_ROOT_PATH . "/images/user/" . $imgsmall;
        moveFile($from, $to);
    }
    //$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$imgbig;
    if ($imgbig) {
        $from = _DOMAIN_ROOT_PATH . "/temp/" . $imgbig;
        $to = _DOMAIN_ROOT_PATH . "/images/user/" . $imgbig;
        moveFile($from, $to);
    }



    $record = array();
    $record["username"] = $txtUsername;
    $record["email"] = $txtEmail;
    if ($txtPassword) $record["password"] = md5($txtPassword);

    $record["name"] = $name;
    $record["address"] = $address;
    $record["mobile"] = $mobile;
    $record["img"] = $imgsmall;
    $record["img1"] = $imgbig;

    $record["cmt"] = $cmt;
    $record["tknh"] = $tknh;

    $record["sinhngay"] = $sinhngay;
    $record["sex"] = $sex;
    $record["ngaycmt"] = $ngaycmt;
    $record["noicapcmt"] = $noicapcmt;
    $record["tenchutknh"] = $tenchutknh;
    $record["nganhangtknh"] = $nganhangtknh;
    $record["chinhanhtknh"] = $chinhanhtknh;


    $sql = "SELECT * FROM user WHERE email='$username'";
    $rs = $db->Execute($sql);
    $sql = $db->GetUpdateSQL($rs, $record);
    $return = $db->Execute($sql);
    include_once("header.php");
    if ($return) {
        echo "<div style=\"padding-top:100px; padding-bottom:100px; font-weight:bold; text-align:center;\">THAY ĐỔI THÔNG TIN THÀNH CÔNG !</div>";
    } else {
        echo "<div style=\"padding-top:100px; padding-bottom:100px; text-align:center; font-weight:bold\">False!</div>";
    }
    include_once("footer.php");
}

function productListUser($username)
{
    global $db, $lang;
    $sql = "SELECT sys_product.*";
    $sql .= " FROM add_list , sys_product";
    $sql .= " WHERE add_list.username =  '$username' AND add_list.idpro =  sys_product.id AND (sys_product.ctrl&1=1)";
    $sql .= " ORDER BY sys_product.date_create DESC";
    $arr = $db->GetAssoc($sql);
    //echo $sql;
    //print_r($arr);
    return $arr;
}
//
function getTSI()
{
    global $db;
    $sql = "SELECT *, DATE_FORMAT(date, '" . format_date() . "') as date FROM xuat_su WHERE type=0  ORDER BY id DESC LIMIT 1";
    $rs = $db->Execute($sql);
    return $rs->fields;
}
//
function getTSITangGiam()
{
    global $db;
    $sql = "SELECT *, DATE_FORMAT(date, '" . format_date() . "') as date FROM xuat_su WHERE type=0  ORDER BY id DESC LIMIT 1,2";
    $rs = $db->Execute($sql);
    return $rs->fields;
}
//
//
function getTSI2()
{
    global $db;
    $sql = "SELECT *, DATE_FORMAT(date, '" . format_date() . "') as date  FROM xuat_su WHERE type=1 ORDER BY id DESC LIMIT 1";
    $rs = $db->Execute($sql);
    return $rs->fields;
}
//
function getTSITangGiam2()
{
    global $db;
    $sql = "SELECT *, DATE_FORMAT(date, '" . format_date() . "') as date FROM xuat_su WHERE type=1  ORDER BY id DESC LIMIT 1,2";
    $rs = $db->Execute($sql);
    return $rs->fields;
}
//
function getUserorder($username)
{
    global $db;
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create, sys_product.name as nameproduct, sys_product.alias, sys_product.promotion, sys_function.htaccess as url";
    $sql .= " FROM user, sys_userorder, sys_product, sys_function";
    $sql .= " WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_product.id = sys_userorder.catID) AND (sys_userorder.loaidt=0) AND (sys_product.catID=sys_function.id)";
    $sql .= " ORDER BY sys_userorder.date_create DESC";
    //echo $sql;
    $arr = $db->GetAssoc($sql);
    return $arr;
}
//
//
function getUserHocvien($username)
{
    global $db;

    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create, user.email as emailhlv";
    $sql .= " FROM sys_inveslist_cat , sys_userorder, user";
    $sql .= " WHERE sys_inveslist_cat.artID =  sys_userorder.lop AND sys_inveslist_cat.catID =  user.id AND sys_userorder.ctrl&1=1";
    $sql .= " AND user.username =  '$username'";
    $sql .= " ORDER BY sys_userorder.id DESC";

    $arr = $db->GetAssoc($sql);
    return $arr;
}
//
function getUserGioithieu($username)
{
    global $db;
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create, sys_product.name as nameproduct, sys_product.alias, sys_function.htaccess as url";
    $sql .= " FROM user, sys_userorder, sys_product, sys_function";
    $sql .= " WHERE (sys_userorder.nguoigioithieu = '$username') AND (user.id = sys_userorder.userid) AND (sys_product.id = sys_userorder.catID) AND (sys_userorder.loaidt=0) AND (sys_product.catID=sys_function.id)";
    $sql .= " ORDER BY sys_userorder.date_create DESC";

    $arr = $db->GetAssoc($sql);
    return $arr;
}
// gop von
//
function getUserordergopvon($username)
{
    global $db;
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create, sys_gopvon.alias, sys_gopvon.name as nameproduct, DATE_FORMAT(sys_userorder.ngaycklan1, '%d/%m/%Y') as ngaycklan1, DATE_FORMAT(sys_userorder.ngaycklan2, '%d/%m/%Y') as ngaycklan2, sys_function.htaccess as url";
    $sql .= " FROM user, sys_userorder, sys_gopvon, sys_function";
    $sql .= " WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_gopvon.id = sys_userorder.catID) AND (sys_userorder.ctrl=0) AND (sys_userorder.loaidt=1) AND (sys_userorder.hoancoc=0) AND (sys_gopvon.catID=sys_function.id)";
    $sql .= " ORDER BY sys_userorder.date_create DESC";
    $arr = $db->GetAssoc($sql);
    return $arr;
}
//
function getUserSohuugopvon($username)
{
    global $db;
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create, DATE_FORMAT(sys_userorder.ngayhoancoc, '%d/%m/%Y') as datehoancoc, sys_gopvon.name as nameproduct, DATE_FORMAT(sys_userorder.ngaycklan1, '%d/%m/%Y') as ngaycklan1, DATE_FORMAT(sys_userorder.ngaycklan2, '%d/%m/%Y') as ngaycklan2, sys_gopvon.alias, sys_function.htaccess as url";
    $sql .= " FROM user, sys_userorder, sys_gopvon, sys_function";
    $sql .= " WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_gopvon.id = sys_userorder.catID) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.loaidt=1) AND (sys_gopvon.catID=sys_function.id)";
    $sql .= " ORDER BY sys_userorder.date_create DESC";
    $arr = $db->GetAssoc($sql);
    return $arr;
}
//Hoan coc
//
function getUserHoancoc($username)
{
    global $db;
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create, sys_product.name as nameproduct, DATE_FORMAT(sys_userorder.ngaycklan1, '%d/%m/%Y') as ngaycklan1, DATE_FORMAT(sys_userorder.ngaycklan2, '%d/%m/%Y') as ngaycklan2";
    $sql .= " FROM user, sys_userorder, sys_product";
    $sql .= " WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_product.id = sys_userorder.catID) AND (sys_userorder.hoancoc=1) AND (sys_userorder.loaidt=0)";
    $sql .= " ORDER BY sys_userorder.date_create DESC";
    $arr = $db->GetAssoc($sql);
    return $arr;
}

function getUserHoancocGopvon($username)
{
    global $db;
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create, sys_gopvon.name as nameproduct, DATE_FORMAT(sys_userorder.ngaycklan1, '%d/%m/%Y') as ngaycklan1, DATE_FORMAT(sys_userorder.ngaycklan2, '%d/%m/%Y') as ngaycklan2";
    $sql .= " FROM user, sys_userorder, sys_gopvon";
    $sql .= " WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_gopvon.id = sys_userorder.catID) AND (sys_userorder.hoancoc=1) AND (sys_userorder.loaidt=1)";
    $sql .= " ORDER BY sys_userorder.date_create DESC";
    $arr = $db->GetAssoc($sql);
    return $arr;
}
//
///////

function getUserorder2($username)
{
    global $db;
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create";
    $sql .= " FROM user, sys_userorder";
    $sql .= " WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.loai=1)";
    $sql .= " ORDER BY sys_userorder.date_create ASC";
    $arr = $db->GetAssoc($sql);
    return $arr;
}
//
//
function getUserSohuu2()
{
    global $db;
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create";
    $sql .= " FROM user, sys_userorder";
    $sql .= " WHERE (user.id = sys_userorder.userid) AND (sys_userorder.hdban=0) AND (sys_userorder.loai=1) AND (sys_userorder.ctrl&1=1) AND (sys_userorder.trangthai=0)";
    $sql .= " ORDER BY sys_userorder.date_create ASC";
    $arr = $db->GetAssoc($sql);
    return $arr;
}
//
//
function getxacthucdatban($username)
{
    global $db;
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create";
    $sql .= " FROM user, sys_userorder";
    $sql .= " WHERE (user.username = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&0=0) AND (sys_userorder.tinh_trang=1)";
    $sql .= " ORDER BY sys_userorder.date_create ASC";
    $arr = $db->GetAssoc($sql);
    return $arr;
}
//
function huy()
{
    global $db, $lang, $lable;
    include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");

    $id = getParam("id");


    $sqlhuy = "SELECT * FROM sys_userorder WHERE id=$id AND trangthai='0'";
    $rs = $db->Execute($sqlhuy);
    $luonghuy = $rs->fields("model");
    $hdban = $rs->fields("hdban");
    $loai = $rs->fields("loai");
    if ($loai == '0') {
        $ret_page = "../user_project/";
    } else {
        $ret_page = "../user_project456/";
    }

    if ($luonghuy > 0) {
        //$sql="UPDATE sys_userorder SET model=model+'".$luonghuy."',product_in='0' WHERE id=$hdban";

        $sql = "UPDATE sys_userorder SET trangthai=2 WHERE id=$id";
        $db->Execute($sql);


        $sql = "UPDATE sys_userorder SET model=model+'" . $luonghuy . "', product_in=product_in-'" . $luonghuy . "' WHERE id=$hdban";

        $return = $db->Execute($sql);
        if ($return) {
            $a = new msgBox(_UPDATE_SUCCESSFU, "OKOnly", "Message", array($ret_page), 1);
        } else {
            $a = new msgBox(_ERRO, "OKOnly", "Message", array($ret_page), 1);
        }
    } else {
        $a = new msgBox(_ERRO, "OKOnly", "Message", array($ret_page), 1);
    }
    $a->showMsg();
}
//
function getHDcuadoitacchuyennghiep($username)
{
    global $db;
    $month = getParam("month");
    $monthtoday = date("m");
    $year = getParam("year");
    $yeartoday = date("Y");
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create, user.name as nameuser, MONTH(sys_userorder.date_create) as month, YEAR(sys_userorder.date_create) as year";
    $sql .= " FROM user, sys_userorder";
    $sql .= " WHERE (user.gioithieu = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1)";
    if ($month) {
        $sql .= " AND (MONTH(sys_userorder.date_create) = '$month')";
    } else {
        $sql .= " AND (MONTH(sys_userorder.date_create) = '$monthtoday')";
    }
    if ($year) {
        $sql .= " AND (YEAR(sys_userorder.date_create) = '$year')";
    } else {
        $sql .= " AND (YEAR(sys_userorder.date_create) = '$yeartoday')";
    }
    $sql .= " ORDER BY sys_userorder.date_create DESC";
    $arr = $db->GetAssoc($sql);
    //echo $sql;
    return $arr;
}
function getHDcuanhanvienchuyennghiep($username)
{
    global $db;
    $month = getParam("month");
    $monthtoday = date("m");
    $year = getParam("year");
    $yeartoday = date("Y");
    $sql = "SELECT sys_userorder.*, DATE_FORMAT(sys_userorder.date_create, '" . format_date() . "') as date_create, user.name as nameuser, MONTH(sys_userorder.date_create) as month, YEAR(sys_userorder.date_create) as year";
    $sql .= " FROM user, sys_userorder";
    $sql .= " WHERE (user.gioithieu = '$username') AND (user.id = sys_userorder.userid) AND (sys_userorder.ctrl&1=1)";
    if ($month) {
        $sql .= " AND (MONTH(sys_userorder.date_create) = '$month')";
    } else {
        $sql .= " AND (MONTH(sys_userorder.date_create) = '$monthtoday')";
    }
    if ($year) {
        $sql .= " AND (YEAR(sys_userorder.date_create) = '$year')";
    } else {
        $sql .= " AND (YEAR(sys_userorder.date_create) = '$yeartoday')";
    }
    $sql .= " ORDER BY sys_userorder.date_create DESC";
    $arr = $db->GetAssoc($sql);
    //echo $sql;
    return $arr;
}

//
function nameHlv($id)
{
    global $themeName, $smarty, $lable, $db;
    $id = $id["id"];

    $sql = "SELECT * FROM sys_inveslist WHERE id=$id";
    $rs = $db->Execute($sql);
    $name = $rs->fields("name");

    $sqluser = "SELECT user.* FROM user,sys_inveslist_cat,sys_inveslist WHERE user.id = sys_inveslist_cat.catID AND sys_inveslist.id=sys_inveslist_cat.artID AND sys_inveslist.id=$id";
    $arruser = $db->GetAssoc($sqluser);
    $smarty->assign('arruser', $arruser);
    $smarty->assign('name', $name);
    $smarty->display(_DOMAIN_ROOT_TEMPLATE . '/user_danhsach_file.tpl', 'user_danhsach_file_' . $themeName);

    return;
}
//
