<?php
/* Smarty version 3.1.36, created on 2025-09-03 08:49:13
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/memberList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b79e990129c6_35063860',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b4a7f7ad2c416fc13208613ed8a462002133f116' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/memberList.tpl',
      1 => 1754187764,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b79e990129c6_35063860 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table table-striped table-bordered dataTable">
  <tr class="tr">
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['No']->value;?>
</td>
	<td class="td">&nbsp;</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Email']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Last_name']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Mobile']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Address']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Number_access']->value;?>
</td>
    </tr>
  <?php if ($_smarty_tpl->tpl_vars['arr']->value) {?>
  <?php $_smarty_tpl->_assignInScope('i', 1);?>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>  
    <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#FFFFFF,#F7F7F7"),$_smarty_tpl);?>
">
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
	<td class="td">
	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer" /> </label>
	<label id="lock_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="callLock(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer; padding-right:5px"><img src="images/<?php echo $_smarty_tpl->tpl_vars['item']->value['ctrl'];?>
.gif" /></label>
	</td>
    <td class="td"><a href="mailto:<?php echo $_smarty_tpl->tpl_vars['item']->value['email'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['email'];?>
</a></td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['fullname'];?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['address'];?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>
</td>
    </tr>
  <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);?>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  <?php } else { ?>
  <tr>
    <td colspan="7"><?php echo $_smarty_tpl->tpl_vars['Cannot_member']->value;?>
</td>
  </tr>
  <?php }?>
</table>
</form><?php }
}
