{literal}
<script language="javascript" type="text/javascript">
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
	obj=document.frmCreateMember;
	if(!isValidEmail(obj.txt_email.value)){
		alert("Email!");
		obj.txt_email.focus();
		return;
	}
	if(obj.chenge_pass.checked==true){
		if(obj.txt_password.value != obj.txt_re_password.value){
			alert("Password not similar!");
			obj.txt_password.focus();
			return;
		}
	}
	if(!obj.txt_fistname.value){
		alert("Fist name!");
		obj.txt_fistname.focus();
		return;
	}else{
		obj.submit();
	}
}
function change_passworld(check){
	if(check==true)
	{
		document.getElementById('tr_passworld').style.display='';
		document.getElementById('tr_re_passworld').style.display='';
	}
	else
	{
		document.getElementById('tr_passworld').style.display='none';
		document.getElementById('tr_re_passworld').style.display='none';
	}
}
</script>
{/literal}
<form name="frmCreateMember" action="?m=member" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="mCreate" />
<input type="hidden" name="id" value="{$memberID}" />
<div class="topic">{$Member_create}</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">{$Email} <label style="color:#FF0000">*</label></td>
    <td width="100%" style="padding-left:10px; padding-left:10px">
	<input id="txt_email" name="txt_email" type="text" class="text" maxlength="255" value="{$arr.email}" onchange="isValidEmail(document.frmCreateMember.txt_email.value)" /><label id="lbl_email" style="padding-left:10px; color:#FF0000"></label></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">&nbsp;</td>
    <td style="padding-left:10px; padding-left:10px"><input type="checkbox" name="chenge_pass" onclick="change_passworld(this.checked)" />{$Change_password}</td>
  </tr>
  <tr id="tr_passworld" style="display:none">
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">{$Password} <label style="color:#FF0000">*</label></td>
    <td style="padding-left:10px; padding-left:10px"><input name="txt_password" type="password" class="text" maxlength="255" /></td>
  </tr>
  <tr id="tr_re_passworld" style="display:none">
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">{$Re_password} <label style="color:#FF0000">*</label></td>
    <td style="padding-left:10px; padding-left:10px"><input name="txt_re_password" type="password" class="text" maxlength="255" /></td>
  </tr>
  
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">{$First_name} <label style="color:#FF0000">*</label></td>
    <td style="padding-left:10px; padding-left:10px"><input value="{$arr.fistname}" name="txt_fistname" type="text" class="text" maxlength="50" /></td>
  </tr>
 
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">{$Address}</td>
    <td style="padding-left:10px; padding-left:10px"><input value="{$arr.address}" name="txt_address" type="text" class="text" maxlength="255" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">{$Mobile}</td>
    <td style="padding-left:10px; padding-left:10px"><input value="{$arr.mobile}" name="txt_mobile" type="text" class="text" maxlength="30" /></td>
  </tr>
  <!--
   <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">{$Last_name}</td>
    <td style="padding-left:10px; padding-left:10px"><input value="{$arr.lastname}" name="txt_lastname" type="text" class="text" maxlength="50" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">{$Birthday}</td>
    <td style="padding-left:10px; padding-left:10px">
	{html_select_date prefix="date" display_years=false} <input name="dateYear" type="text" style="width:50px" maxlength="4" /></td>
  </tr>
  -->
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px; padding-left:10px">{$List_of_rights}</td>
    <td style="padding-left:10px; padding-left:10px">
	{getPermit sPermit=$arr.permit}	</td>
  </tr>
  <tr>
    <td style="padding-right:10px; padding-left:10px" nowrap="nowrap">&nbsp;</td>
    <td style="padding-left:10px; padding-left:10px"><input type="button" onclick="checkForm();" class="button" value="{$Update}" /> </td>
  </tr>
</table>
</form>