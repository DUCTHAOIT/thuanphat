<?php
/* Smarty version 3.1.36, created on 2026-04-08 12:00:32
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/productListPhoto.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_69d5e0f09911f6_26864772',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '684e09460822024ffb0a8c1ac1db83e98966ce34' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/productListPhoto.tpl',
      1 => 1754187766,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69d5e0f09911f6_26864772 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form name="frmList" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="" />
<input type="hidden" name="photoID" value="" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['groupID']->value;?>
" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #cccccc">
  <tr>
  	<?php $_smarty_tpl->_assignInScope('i', "0");?>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
	<?php if ($_smarty_tpl->tpl_vars['i']->value == 4) {?>
	</tr><tr>
	<?php $_smarty_tpl->_assignInScope('i', 1);?>
	<?php }?>
    <td valign="top" style="padding:10px">
	<div style="width:190px; padding-bottom:5px; padding-top:5px; text-align:center">	
	<?php if ($_smarty_tpl->tpl_vars['item']->value['img']) {?><a href="?m=product&op=photo&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['proid'];?>
&idPhoto=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" border="0" onmouseover="border='1'" onmouseout="border='0'" width="120" /></a><?php }?></div>	
	<div style="width:190px; padding-bottom:5px; padding-top:5px; text-align:center"><img src="images/delete.gif" title="<?php echo $_smarty_tpl->tpl_vars['Delete']->value;?>
" style="cursor:pointer" onclick="goDelete(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,document.frmList)" /></div>
	</td>
	<?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);?>
	<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </tr>
</table>
</form><?php }
}
