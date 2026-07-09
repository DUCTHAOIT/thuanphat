{literal}
{/literal}
<table width="100%%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding:20px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-bottom:5px; padding-top:5px;"><strong style="color:#FF0000">{$Note}: </strong> {$Your_Visitors_Cart}</td>
  </tr>
  <tr>
    <td>
	<form method="post" action="?m=basket" name="loginForm">
	<input type="hidden" value="login" name="op"/>
	<input type="hidden" value="/view_basket/" name="ret_page"/>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td><strong>{$Information_login}</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" style="padding-right:10px">E-Mail:</td>
        <td><input type="text" style="width: 160px;" name="username"/></td>
      </tr>
      <tr>
        <td align="right" style="padding-right:10px">{$Password}:</td>
        <td><input type="password" style="width: 160px;" name="password"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td style="padding-top:10px"><input type="image" title="Sign In" alt="Sign In" src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/button_login.gif"/></td>
      </tr>
	   <tr>
        <td align="right" style="padding-top:10px; padding-right:10px"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/bullet1.gif" /></td>
        <td style="padding-top:10px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/?m=user&op=forget" class="content"> Quên mật khẩu</a> </td>
      </tr>
    </table>
	</form>
	</td>
  </tr>
  <tr>
    <td style="padding-top:10px; border-bottom:1px solid #cccccc">&nbsp;</td>
  </tr>
  <tr>
    <td style="padding-bottom:5px; padding-top:30px;"><strong>{$New_Customer}</strong></td>
  </tr>
  <tr>
    <td>{$I_am_a_new_customer} <a href="/user/"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/button_create_account.gif" border="0" /></a></td>
  </tr>
  <tr>
    <td style="padding-top:10px; border-bottom:1px solid #cccccc">&nbsp;</td>
  </tr>
  <!--
  <tr>
    <td style="padding-bottom:5px; padding-top:30px;"><strong>{$Proceed_Directly_to_Checkout}</strong></td>
  </tr>
  <tr>
    <td>{$Proceed_to_Checkout_without} <a href="?m=basket&op=frmcheckout"><img src="modules/basket/images/button_checkout.gif" alt="Checkout" border="0" title=" Checkout "/></a></td>
  </tr>
  -->
</table></td>
  </tr>
</table>