<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name="formUserLogin" action="" enctype="multipart/form-data">
  <tr>
    <td style="background-color:#F0F0F0; border-left:1px solid #C8C8C8; border-right:1px solid #C8C8C8; border-top:1px solid #C8C8C8; padding:5px">
	<div style="float:left;"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/login.gif"></div>
	<div style="padding-top:10px; text-transform:uppercase; color:#8D0100"><strong>{$Login}</strong></div>	</td>
  </tr>
  <tr>
    <td bgcolor="#D8D8D8" style="border-left:1px solid #C8C8C8; border-right:1px solid #C8C8C8; border-top:2px solid #8D0100; padding:10px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>Email</td>
        <td width="100%"><input type="text" name="email" style="width:100%" class="text"></td>
      </tr>
      <tr>
        <td style="padding-right:10px">Password</td>
        <td><input type="password" name="password" style="width:100%" class="text"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="right"><input type="submit" name="btnSubmit" class="button" value="{$Sign_in}"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="background-color:#F0F0F0; border-left:1px solid #C8C8C8; border-right:1px solid #C8C8C8; border-bottom:1px solid #C8C8C8; padding:10px">
	<div style="padding-bottom:5px; text-align:right;"><a href="#">{$Forgot_password}</a> &nbsp;|&nbsp; <a href="#">{$Sign_up}</a></div>	
	</td>
  </tr>
</form>
</table>