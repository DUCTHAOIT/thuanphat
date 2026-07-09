<?php
/* Smarty version 3.1.36, created on 2026-06-29 15:30:39
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/weblinkList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a422d2ff28f72_99855749',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c98a03959a5b1c55c5f220fab236625cece35c7' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/weblinkList.tpl',
      1 => 1754187771,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a422d2ff28f72_99855749 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form name="frmList" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">&nbsp;</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Name_weblink']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Website']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Description']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['No']->value;?>
</td>
  </tr>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
  <tr>
    <td class="td"><label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,document.frmList)" style="cursor:pointer" /> </label>
	<label id="lock_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="callLock(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer; padding-right:5px"><img src="images/<?php echo $_smarty_tpl->tpl_vars['item']->value['ctrl'];?>
.gif" /></label></td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
    <td class="td"><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
</a></td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['des'];?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['no'];?>
</td>
  </tr>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>
</form><?php }
}
