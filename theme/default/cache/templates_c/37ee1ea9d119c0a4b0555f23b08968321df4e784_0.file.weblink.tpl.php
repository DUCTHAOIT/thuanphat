<?php
/* Smarty version 3.1.36, created on 2026-07-08 06:26:47
  from 'C:\xampp\htdocs\thuanphatitc.vn\theme\default\templates\weblink.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a4dd187f306e5_97157257',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '37ee1ea9d119c0a4b0555f23b08968321df4e784' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thuanphatitc.vn\\theme\\default\\templates\\weblink.tpl',
      1 => 1783309162,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a4dd187f306e5_97157257 (Smarty_Internal_Template $_smarty_tpl) {
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
