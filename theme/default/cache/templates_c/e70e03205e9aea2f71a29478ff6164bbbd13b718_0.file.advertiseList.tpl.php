<?php
/* Smarty version 3.1.36, created on 2026-02-02 22:48:46
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/advertiseList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6980c75e377842_80499056',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e70e03205e9aea2f71a29478ff6164bbbd13b718' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/advertiseList.tpl',
      1 => 1754187750,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6980c75e377842_80499056 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>

<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td">&nbsp;</td>
	<td class="td">&nbsp;</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Name']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Tel']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Website']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Address']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['No']->value;?>
</td>
    <td class="td">&nbsp;</td>
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
.gif" /></label>	</td>
    <td class="td"><a href="#" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" ><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['tel'];?>
</td>
    <td class="td"><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['website'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['item']->value['website'];?>
</a></td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['address'];?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['no'];?>
</td>
    <td class="td"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/advertise/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" width="100" /></td>
    </tr>
  <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);?>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  <?php } else { ?>
  <tr>
    <td colspan="8" class="td" style="color:#FF0000">Not find data!</td>
  </tr>
  <?php }?>
</table>
</form><?php }
}
