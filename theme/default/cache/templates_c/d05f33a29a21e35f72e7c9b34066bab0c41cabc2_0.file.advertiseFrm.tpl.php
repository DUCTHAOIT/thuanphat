<?php
/* Smarty version 3.1.36, created on 2026-04-08 10:44:51
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/advertiseFrm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_69d5cf338f0ba4_33726496',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd05f33a29a21e35f72e7c9b34066bab0c41cabc2' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/advertiseFrm.tpl',
      1 => 1754187750,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69d5cf338f0ba4_33726496 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div>
<h4 class="page-title">Thêm mới quảng cáo</h4>
<form name="frmmain" action="?m=advertise" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
<input type="hidden" name="fileName" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" />
<input type="hidden" name="position" value="0" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap="nowrap" class="td">Tiêu đề</td>
    <td width="100%" class="td"><input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" class="form-control" /></td>
  </tr>
   <tr>
    <td nowrap="nowrap" class="td">Tiêu đề 2</td>
    <td class="td"><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['address'];?>
" name="address" class="form-control" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td">		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="fileNamev">
            <a href="#" onclick="WindowUpload('fileName')">
			<?php if ($_smarty_tpl->tpl_vars['arr']->value['img']) {?>
			<img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/advertise/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" style="max-height:200px" />
			
			<?php }?>
            </a>
			</td>
          </tr>
          <tr>
            <td><a href="#" onclick="WindowUpload('fileName')"><i class="me-2 mdi mdi-folder-image"></i> Upload logo</a></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
  </tr>
 
  <tr>
    <td nowrap="nowrap" class="td"><?php echo $_smarty_tpl->tpl_vars['Tel']->value;?>
</td>
    <td class="td"><input type="text" name="tel" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['tel'];?>
" class="form-control" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td"><?php echo $_smarty_tpl->tpl_vars['Website']->value;?>
</td>
    <td class="td"><input type="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['website'];?>
" name="website" class="form-control" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td"><?php echo $_smarty_tpl->tpl_vars['Description']->value;?>
</td>
    <td class="td"><textarea name="des" style="height:150" class="form-control"><?php echo $_smarty_tpl->tpl_vars['arr']->value['des'];?>
</textarea></td>
  </tr>
 
  <tr>
	<td nowrap="nowrap" class="td">Vị trí:</td>
	<td  class="td">
	<select name="position"  class="select2 form-select shadow-none form-control"
                        style="width: 30%; height: 36px">	  
	 <!--
      <option value="0" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['arr']->value['position'] == '0') {?> selected="selected" <?php }?> >&nbsp; &nbsp;Popup (height=265px)</option>	  
	 	 
     
	  <option value="3" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['arr']->value['position'] == '3') {?> selected="selected" <?php }?>>&nbsp; &nbsp; Giờ vàng (620px - 430px)</option>	
       <option value="4" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['arr']->value['position'] == '4') {?> selected="selected" <?php }?>>&nbsp; &nbsp; Những con số (280px - 114px)</option>
    -->
     <option value="1" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['arr']->value['position'] == '1') {?> selected="selected" <?php }?>>&nbsp; &nbsp; Đối tác</option>
     <option value="2" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['arr']->value['position'] == '2') {?> selected="selected" <?php }?> >&nbsp; &nbsp;Giữa trên Home</option>	
     <option value="3" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['arr']->value['position'] == '3') {?> selected="selected" <?php }?>>&nbsp; &nbsp; Footer</option>	   	 
	</select>		
	</td>
	</tr>
  
  <tr>
    <td nowrap="nowrap" class="td"><?php echo $_smarty_tpl->tpl_vars['No']->value;?>
</td>
    <td class="td"><input type="text" name="no" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['no'];?>
" style="width:50" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap" class="td"><?php echo $_smarty_tpl->tpl_vars['Languages']->value;?>
</td>
    <td class="td"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getCboLanguage'][0], array( array('langID'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>
</td>
  </tr>  
  <tr>
    <td nowrap="nowrap" class="td">&nbsp;</td>
    <td class="td"><input type="submit" value="Update" class="btn btn-primary" /></td>
  </tr>
</table>
</form>
</div><?php }
}
