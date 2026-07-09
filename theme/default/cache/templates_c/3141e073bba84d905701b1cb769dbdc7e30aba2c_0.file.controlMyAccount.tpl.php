<?php
/* Smarty version 3.1.36, created on 2025-08-31 22:59:43
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/controlMyAccount.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b4716fe9d9e1_26019356',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3141e073bba84d905701b1cb769dbdc7e30aba2c' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/controlMyAccount.tpl',
      1 => 1754187756,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b4716fe9d9e1_26019356 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.html_select_date.php','function'=>'smarty_function_html_select_date',),));
?>

<?php echo '<script'; ?>
 language="javascript" type="text/javascript">
function isValidEmail(str) {
	if((str.indexOf(".") > 2) && (str.indexOf("@") > 0)){
		document.getElementById('lbl_email').innerHTML = "<img src=\"images/check.gif\" />";
		return true;
	}	
	else{
		document.getElementById('lbl_email').innerHTML = "<img src=\"images/not_check.gif\" />";
		return false;
	} 
}
//
function checkForm(){
	var obj;
	obj=document.frmMyAccount;
	if(!isValidEmail(obj.txt_email.value)){
		alert("Email!");
		obj.txt_email.focus();
		return;
	}	
	if(obj.txt_password.value != obj.txt_re_password.value){
		alert("Password not similar!");
		obj.txt_password.focus();
		return;
	}
	if(!obj.txt_fistname.value){
		alert("Fist name!");
		obj.txt_fistname.focus();
		return;
	}else{
		obj.submit();
	}
}
//
function checkStr(obj,txt){
	
}
<?php echo '</script'; ?>
>

<form name="frmMyAccount" action="?m=control" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="mModify" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['memberID']->value;?>
" />
<input type="hidden" name="f" value="my_account" />
<div class="topic"><?php echo $_smarty_tpl->tpl_vars['Member_create']->value;?>
</div>
<table width="60%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px"><?php echo $_smarty_tpl->tpl_vars['Email']->value;?>
 <label style="color:#FF0000">*</label></td>
    <td width="100%" style="padding-left:10px; padding-left:10px">
	<input id="txt_email" name="txt_email" type="text" class="text" maxlength="255" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['email'];?>
" onchange="isValidEmail(document.frmMyAccount.txt_email.value)" /><label id="lbl_email" style="padding-left:10px; color:#FF0000"></label></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px"><?php echo $_smarty_tpl->tpl_vars['Password']->value;?>
 <label style="color:#FF0000">*</label></td>
    <td style="padding-left:10px; padding-left:10px"><input name="txt_password" type="password" class="text" maxlength="255" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px"><?php echo $_smarty_tpl->tpl_vars['Re_password']->value;?>
 <label style="color:#FF0000">*</label></td>
    <td style="padding-left:10px; padding-left:10px"><input name="txt_re_password" type="password" class="text" maxlength="255" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">&nbsp;</td>
    <td style="padding-left:10px; padding-left:10px">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px"><?php echo $_smarty_tpl->tpl_vars['First_name']->value;?>
 <label style="color:#FF0000">*</label></td>
    <td style="padding-left:10px; padding-left:10px"><input value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['fistname'];?>
" name="txt_fistname" type="text" class="text" maxlength="50" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px"><?php echo $_smarty_tpl->tpl_vars['Last_name']->value;?>
</td>
    <td style="padding-left:10px; padding-left:10px"><input value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['lastname'];?>
" name="txt_lastname" type="text" class="text" maxlength="50" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px"><?php echo $_smarty_tpl->tpl_vars['Address']->value;?>
</td>
    <td style="padding-left:10px; padding-left:10px"><input value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['address'];?>
" name="txt_address" type="text" class="text" maxlength="255" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px"><?php echo $_smarty_tpl->tpl_vars['Mobile']->value;?>
</td>
    <td style="padding-left:10px; padding-left:10px"><input value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['mobile'];?>
" name="txt_mobile" type="text" class="text" maxlength="30" /></td>
  </tr>
  <!--
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px"><?php echo $_smarty_tpl->tpl_vars['Birthday']->value;?>
</td>
    <td style="padding-left:10px; padding-left:10px">
	<?php echo smarty_function_html_select_date(array('prefix'=>"date",'display_years'=>false),$_smarty_tpl);?>
 <input name="dateYear" type="text" style="width:50px" maxlength="4" /></td>
  </tr>
  -->
  
  <tr>
    <td style="padding-right:10px; padding-left:10px" nowrap="nowrap">&nbsp;</td>
    <td style="padding-left:10px; padding-left:10px"><input type="button" onclick="checkForm();" class="button" value="<?php echo $_smarty_tpl->tpl_vars['Update']->value;?>
" /> </td>
  </tr>
</table>
</form><?php }
}
