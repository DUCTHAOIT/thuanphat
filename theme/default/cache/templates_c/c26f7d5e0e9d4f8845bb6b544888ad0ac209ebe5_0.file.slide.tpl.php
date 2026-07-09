<?php
/* Smarty version 3.1.36, created on 2025-10-15 10:38:09
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/slide.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68ef172126e4b6_82698432',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c26f7d5e0e9d4f8845bb6b544888ad0ac209ebe5' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/slide.tpl',
      1 => 1754187766,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68ef172126e4b6_82698432 (Smarty_Internal_Template $_smarty_tpl) {
?>
	<?php echo '<script'; ?>
 language="javascript">
		function checkForm()
		{
			var obj=document.frmmain;
			if(!obj.name.value)
			{
				alert('slide name!');
				obj.name.focus();
			}
			else
			{
				obj.submit();
			}
		}
		//
		function searchList(str)
		{
			AjaxRequest.get(
			{
			'url':'?m=product&f=slide&op=search&search='+ str
			,'onSuccess':function(req){document.getElementById('td_slideList').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
		}
	<?php echo '</script'; ?>
>

<div style="text-transform:uppercase" class="title">Quản lý ảnh slide</div>
<form name="frmmain" action="?m=product&f=slide" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="add" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
<input type="hidden" name="logo" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['logo'];?>
" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="top" style="padding:10px; border:1px solid #D3D7DC">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td nowrap="nowrap" class="td title">Tiêu đề</td>
        <td width="100%" class="td"><input type="text" name="name" style="width:100%" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" onkeyup="searchList(this.value);" /></td>
      </tr>
       <tr>
        <td nowrap="nowrap" class="td title">Mô tả</td>
        <td width="100%" class="td"><input type="text" name="des" style="width:100%" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['des'];?>
" /></td>
      </tr>
       <tr>
        <td nowrap="nowrap" class="td title">Link:</td>
        <td width="100%" class="td"><input type="text" name="link" style="width:100%" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['link'];?>
"/></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="td">&nbsp;</td>
        <td class="td">
		<div id="logov"><?php if ($_smarty_tpl->tpl_vars['arr']->value['logo']) {?><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/logo/<?php echo $_smarty_tpl->tpl_vars['arr']->value['logo'];?>
" onclick="WindowUpload('logo')" style="cursor:pointer; max-width:500px" /><?php }?></div>
		<label onclick="WindowUpload('logo')" style="cursor:pointer" class="title"> <i class="me-2 mdi mdi-folder-image"></i>Upload Image</label></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="td title">Thứ tự:</td>
        <td width="100%" class="td"><input type="text" name="sort" style="width:10%" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['sort'];?>
"/></td>
      </tr>
      <tr>
        <td nowrap="nowrap" class="td">&nbsp;</td>
        <td align="left" class="td"><input type="button" class="btn btn-primary" value="<?php echo $_smarty_tpl->tpl_vars['Update']->value;?>
" onclick="checkForm();" /></td>
      </tr>
    </table></td>
   
  </tr>
</table>
</form>
 <div id="td_slideList"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['slideList'][0], array( array(),$_smarty_tpl ) );?>
</div><?php }
}
