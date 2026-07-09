<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="5400" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0"/>
<link href="../../favicon.ico" rel="shortcut icon" /><link href="theme/default/default.css?v=2.1.14" rel="stylesheet"/>
<script language="javascript" src="js/ajaxRequest.js"></script>
<SCRIPT language=javascript type=text/javascript>
	function setFocus() {
		document.loginForm.email.select();
		document.loginForm.email.focus();
	}	
</SCRIPT>
<body  onload=setFocus();>

<div class="wrapper wrapper-login">
	<div class="cover">
    	<div class="inside">
    		<div class="box">
        	
            <div class="heading">Quản Lý Tên miền</div>
            <div class="clear"></div>     

            <div class="middle fc">
            	<a href="login.php?lang=en" class="fr langen animate" title="English" tabindex="-1"></a>                  
				 <div class="clear"></div>
				 <div class="heading_new" style="display: none;">
				 		
				 	<div>
				 		<p>Đăng nhập để quản lý hệ thống</p>
				 	</div>
				 					 </div>
                    <FORM id="loginForm" name="loginForm" action="action.php" method="post">
                    <input type="hidden" name="op" value="login">
                    <input type="hidden" name="PHPSESSID" value="<?php echo $GLOBALS["_COOKIE"]["PHPSESSID"]?>">
                	<label class="fl">Email:</label>
                    <input  type="text" name="email" id="email" placeholder="Email" class="input fr corner_3" autocomplete="off" maxlength="100" value=""/>
                    <div class="clear" style="height:10px"></div>               
                    <label class="fl">Mật khẩu:</label>
                     <input name="pass" id="pass" type="password"  placeholder="Password" maxlength="32" class="input fr corner_3" autocomplete="off" value=""/>
                    <div class="clear" style="height:10px"></div>                                     
                    <label class="fl">&nbsp;</label>
                                     
                    <div >
                    	
                    	<input name="submit" id="submit" class="button fl corner_3 bld" type="submit" value="Đăng nhập" />
                        
                        
                        <div class="clear" style="height:20px"></div>
                                                
                    </div>
                    <div class="clear"></div>                    
                </form>
                            </div>
        </div>
            <div class="clear"></div>
           
        </div>
        <div class="footer">
    <div class="logo_new" style="display: none;">
        <img src="images/icon_cpn.jpg">
    </div>
    <div class="head_new" style="display: none;">Quản Lý Hệ thống</div>
    <div class="inside fc">
        <ul>
        <li>
        <strong>Quản trị hệ thống giúp bạn quản lý toàn bộ thông tin hiển thị trên website</strong></li>
        
        </ul>
        <div class="clear"></div>
    </div>
    <div class="copyright_new" style="display: none;">
        <ul>
            <li></li>
        </ul>
    </div>
</div>        <div class="tc copyright"></div>
    </div>
</div>

</body>
</html>
