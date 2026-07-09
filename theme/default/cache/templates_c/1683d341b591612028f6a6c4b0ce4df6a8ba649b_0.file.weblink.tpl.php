<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:34:40
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/weblink.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b014a0978af5_99378549',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1683d341b591612028f6a6c4b0ce4df6a8ba649b' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/weblink.tpl',
      1 => 1754188634,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b014a0978af5_99378549 (Smarty_Internal_Template $_smarty_tpl) {
?><table border="0" cellspacing="0" cellpadding="0">
  <tr>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>	
    <td nowrap="nowrap" style="padding:2px" align="center"><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
" target="_blank"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/advertise/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" border="0" width="30px;"></a></td>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </tr>
</table><?php }
}
