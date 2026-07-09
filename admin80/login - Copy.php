<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
<script language="javascript" src="js/ajaxRequest.js"></script>
<SCRIPT language=javascript type=text/javascript>
	function setFocus() {
		document.loginForm.email.select();
		document.loginForm.email.focus();
	}	
</SCRIPT>
<style type="text/css">
<!--
-->
BODY {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; FONT-SIZE: 11px; PADDING-BOTTOM: 0px; MARGIN: 0px; COLOR: #333; PADDING-TOP: 0px; FONT-FAMILY: Tahoma,Arial, Helvetica, sans-serif; BACKGROUND-COLOR: #333
}
FORM {
	MARGIN: 0px
}
.button {
	BORDER-RIGHT: medium none; PADDING-RIGHT: 4px; BORDER-TOP: medium none; PADDING-LEFT: 4px; FONT-WEIGHT: bold; FONT-SIZE: 11px; BACKGROUND: url(images/bgbutton.gif) no-repeat; PADDING-BOTTOM: 4px; BORDER-LEFT: medium none; WIDTH: 97px; COLOR: #fff; PADDING-TOP: 4px; BORDER-BOTTOM: medium none; HEIGHT: 24px
}
.login {
	MARGIN-TOP: 6em; BACKGROUND: url(images/login.gif) no-repeat; MARGIN-LEFT: auto; OVERFLOW: hidden; WIDTH: 500px; COLOR: #fff; MARGIN-RIGHT: auto; HEIGHT: 337px
}
.login P {
	PADDING-RIGHT: 1em; PADDING-LEFT: 1em; PADDING-BOTTOM: 0px; PADDING-TOP: 0px
}
.form-block {
	BORDER-RIGHT: #cccccc 1px solid; PADDING-RIGHT: 10px; BORDER-TOP: #cccccc 1px solid; PADDING-LEFT: 10px; BACKGROUND: #e9ecef; PADDING-BOTTOM: 10px; BORDER-LEFT: #cccccc 1px solid; PADDING-TOP: 15px; BORDER-BOTTOM: #cccccc 1px solid
}
.login-form {
	MARGIN-TOP: 95px; MARGIN-LEFT: 210px; TEXT-ALIGN: left
}
.login-text {
	FLOAT: left; TEXT-ALIGN: left
}
.inputlabel {
	FONT-WEIGHT: bold; TEXT-ALIGN: left
}
.inputboxusr {
	BORDER-RIGHT: #333333 1px solid; BORDER-TOP: #333333 1px solid; BACKGROUND: url(images/bginputusr.gif) no-repeat right top; MARGIN: 0px 0px 1em; BORDER-LEFT: #333333 1px solid; WIDTH: 150px; BORDER-BOTTOM: #333333 1px solid
}
.inputboxpwd {
	BORDER-RIGHT: #333333 1px solid; BORDER-TOP: #333333 1px solid; BACKGROUND: url(images/bginputpwd.gif) no-repeat right top; MARGIN: 0px 0px 1em; BORDER-LEFT: #333333 1px solid; WIDTH: 150px; BORDER-BOTTOM: #333333 1px solid
}
.clr {
	CLEAR: both
}
.ctr {
	TEXT-ALIGN: center
}
.version {
	FONT-SIZE: 0.8em
}
.footer {
	TEXT-INDENT: -5000px
}
.footer DIV {
	COLOR: #ccc
}
.footer DIV A {
	FONT-WEIGHT: bold; COLOR: #ffffff; TEXT-DECORATION: none
}
.message {
	BORDER-RIGHT: #b22222 1px solid; PADDING-RIGHT: 7px; BORDER-TOP: #b22222 1px solid; MARGIN-TOP: 10px; PADDING-LEFT: 7px; FONT-WEIGHT: bold; FONT-SIZE: 13px; BACKGROUND: #f1f3f5; PADDING-BOTTOM: 7px; BORDER-LEFT: #b22222 1px solid; WIDTH: 400px; COLOR: #cc0033; PADDING-TOP: 7px; BORDER-BOTTOM: #b22222 1px solid
}

</style></head>

<BODY onload=setFocus();>
<DIV id=ctr align=center>
	<DIV class=login>
		<DIV class=login-form>
			<FORM id="loginForm" name="loginForm" action="action.php" method="post">
			<input type="hidden" name="op" value="login">
			<input type="hidden" name="PHPSESSID" value="<?php echo $GLOBALS["_COOKIE"]["PHPSESSID"]?>">
				<DIV class=inputlabel>Email</DIV><INPUT class=inputboxusr size=15 name=email> 
				<DIV class=inputlabel>Password</DIV><INPUT class=inputboxpwd type=password size=15 name=pass> 
				<DIV align=left><INPUT class="button" type="submit" value="Login" name="submit"><label id="message"></label></DIV>
			</FORM>
		</DIV>
		<DIV class=clr></DIV>
	</DIV>
</DIV>
</BODY>
</html>