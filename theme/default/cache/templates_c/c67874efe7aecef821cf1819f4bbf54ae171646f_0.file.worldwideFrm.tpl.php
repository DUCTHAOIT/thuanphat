<?php
/* Smarty version 3.1.36, created on 2026-04-08 12:13:23
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/worldwideFrm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_69d5e3f33b7f82_88932015',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c67874efe7aecef821cf1819f4bbf54ae171646f' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/worldwideFrm.tpl',
      1 => 1754187771,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69d5e3f33b7f82_88932015 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form name="frmmain" action="?m=worldwide" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
<input type="hidden" name="fileName" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" />
<input type="hidden" name="position" value="0" />


<div class="topic">Thêm mới</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td align="right" style="padding-right:10px; padding-top:10px" nowrap="nowrap">Danh mục: </td>
		<td width="50%" style="padding-top:10px">		
		<select name="catID" id="catID" style="border:1px solid #cccccc;">			
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrTopicProduct']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
		<?php if ($_smarty_tpl->tpl_vars['item']->value['id'] == $_smarty_tpl->tpl_vars['arr']->value['catID']) {?>  			
		  <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" selected="selected"  style="padding-left:15px; padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
		<?php } else { ?>
		  <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"  style="padding-left:15px; padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
		<?php }?>	
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</select>	
  </tr>
  <tr>
    <td nowrap="nowrap" >Họ tên</td>
    <td width="100%" ><input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" class="text" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" >&nbsp;</td>
    <td >		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="fileNamev">
			<?php if ($_smarty_tpl->tpl_vars['arr']->value['img']) {?>
			<img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/worldwide/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" style="max-height:200px" />
			
			<?php }?>
			</td>
           
          </tr>
          <tr>
            <td><a href="#" onclick="WindowUpload('fileName')"><i class="me-2 mdi mdi-folder-image"></i> Upload image</a></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
  </tr>
 
  <tr>
    <td nowrap="nowrap" >Địa chỉ</td>
    <td ><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['address'];?>
" name="address" class="text" /></td>
  </tr>
   <tr>
    <td nowrap="nowrap" >Điện thoại</td>
    <td ><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['tel'];?>
" name="tel" class="text" /></td>
  </tr>
  <!--<tr>
    <td nowrap="nowrap" ><?php echo $_smarty_tpl->tpl_vars['Website']->value;?>
</td>
    <td ><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['website'];?>
" name="website" class="text" /></td>
  </tr>
  
  <tr>
    <td nowrap="nowrap" >Tóm tắt</td>
    <td ><textarea name="address" style="height:150" class="text"><?php echo $_smarty_tpl->tpl_vars['arr']->value['address'];?>
</textarea></td>
  </tr>
 -->
  <tr>
    <td nowrap="nowrap" >Ý kiến</td>
    <td ><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['viewFckeditor'][0], array( array('content'=>$_smarty_tpl->tpl_vars['arr']->value['des']),$_smarty_tpl ) );?>
	</td>
  </tr>
 
  
  <!--
  <tr>
	<td nowrap="nowrap" >Vị trí:</td>
	<td>
	<select name="position" style="border:1px solid #cccccc;">	  
	  <option value="0" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['arr']->value['position'] == '0') {?> selected="selected" <?php }?> >&nbsp; &nbsp;factory</option>	  
	  <option value="1" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['arr']->value['position'] == '1') {?> selected="selected" <?php }?>>&nbsp; &nbsp; engineering company</option>
	      
	</select>		
	</td>
	</tr>
 -->
  <tr>
    <td nowrap="nowrap" ><?php echo $_smarty_tpl->tpl_vars['No']->value;?>
</td>
    <td ><input type="text" name="no" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['no'];?>
" style="width:50" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" ><?php echo $_smarty_tpl->tpl_vars['Languages']->value;?>
</td>
    <td ><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getCboLanguage'][0], array( array('langID'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>
</td>
  </tr>  
  <tr>
    <td nowrap="nowrap" >&nbsp;</td>
    <td ><input type="submit" value="Update" class="btn btn-primary" /></td>
  </tr>
</table>
</form><?php }
}
