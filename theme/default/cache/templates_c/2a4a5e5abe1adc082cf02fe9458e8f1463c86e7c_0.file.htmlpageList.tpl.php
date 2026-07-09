<?php
/* Smarty version 3.1.36, created on 2025-09-10 22:56:49
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/htmlpageList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68c19fc1e81b98_20970769',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a4a5e5abe1adc082cf02fe9458e8f1463c86e7c' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/htmlpageList.tpl',
      1 => 1754187763,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68c19fc1e81b98_20970769 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>


<form name="listHtmlpage" action="?m=htmlpage" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table">
  <tr class="tr">
    <td class="td">ID</td>
    <td align="center" class="td"><img src="images/delete.gif" alt="Delete" onclick="goDelete(document.listHtmlpage)" style="cursor:pointer" /></td>
    <td class="td">&nbsp;</td>
    <td width="100%" class="td">Title name</td>
    </tr>  
	  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
	  <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#FFFFFF,#F8F8F8"),$_smarty_tpl);?>
">
	    <td class="td"><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</td>
		<td align="center" class="td">
		<?php if ($_smarty_tpl->tpl_vars['item']->value['del'] == 1) {?>
		<input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" name="chkdelete[]" />
		<?php } else { ?>
		<input type="checkbox" disabled="disabled" />
		<?php }?>		</td>
		<td class="td"><img src="images/edit.gif" alt="Edit" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer" /></td>
		<td class="td" style="padding-left:20px"><a href="#" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a><em style="color:#666666">(<?php echo $_smarty_tpl->tpl_vars['item']->value['date'];?>
)</em></td>
	  </tr>
	  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>
</form><?php }
}
