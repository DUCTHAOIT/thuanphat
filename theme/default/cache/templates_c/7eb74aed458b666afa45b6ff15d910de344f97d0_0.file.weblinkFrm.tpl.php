<?php
/* Smarty version 3.1.36, created on 2026-06-29 15:30:39
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/weblinkFrm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a422d2fed4ce3_30634420',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7eb74aed458b666afa45b6ff15d910de344f97d0' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/weblinkFrm.tpl',
      1 => 1754187771,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a422d2fed4ce3_30634420 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form name="frmmain" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update"  />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['id'];?>
"  />
<input type="hidden" name="fileName" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" />
  <table width="100%" border="0" cellspacing="0" cellpadding="0">    
    <tr>
      <td nowrap="nowrap">Tên</td>
      <td width="90%"><input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" style="width:40%" class="text" /></td>
    </tr>
    <tr>
      <td>Link</td>
      <td><input type="text" name="url" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['url'];?>
" class="text" style="width:40%" /></td>
    </tr>
    <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="fileNamev">
			<?php if ($_smarty_tpl->tpl_vars['arr']->value['img']) {?><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/advertise/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" /><?php }?>
			</td>
           
          </tr>
          <tr>
            <td><a href="#" onclick="WindowUpload('fileName')"><i class="me-2 mdi mdi-folder-image"></i> Upload logo</a></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
  </tr>
    <tr>
      <td><?php echo $_smarty_tpl->tpl_vars['No']->value;?>
</td>
      <td><input type="text" name="no" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['no'];?>
" class="text" style="width:10%" /></td>
    </tr>
    <tr>
      <td><?php echo $_smarty_tpl->tpl_vars['Description']->value;?>
</td>
      <td><textarea name="des" class="textarea" style="height:100px"><?php echo $_smarty_tpl->tpl_vars['arr']->value['des'];?>
</textarea></td>
    </tr>
    <tr>
      <td><?php echo $_smarty_tpl->tpl_vars['Language']->value;?>
</td>
      <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getCboLanguage'][0], array( array('langID'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>
</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left"><input type="button" class="btn btn-primary" onclick="callSubmit(document.frmmain)" value="<?php echo $_smarty_tpl->tpl_vars['Update']->value;?>
" /></td>
    </tr>
  </table>
</form><?php }
}
