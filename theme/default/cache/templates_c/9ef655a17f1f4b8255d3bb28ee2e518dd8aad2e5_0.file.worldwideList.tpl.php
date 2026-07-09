<?php
/* Smarty version 3.1.36, created on 2026-02-02 22:51:17
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/worldwideList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6980c7f52ab781_02791511',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9ef655a17f1f4b8255d3bb28ee2e518dd8aad2e5' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/worldwideList.tpl',
      1 => 1754187771,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6980c7f52ab781_02791511 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>

<style>
	.yellow {
		background-color: #ddd !important;
	}
</style>
<?php echo '<script'; ?>
>


	$(function() {
		$('tr.unselected').hover(function() {
			$(this).addClass('yellow');
		}, function() {
			$(this).removeClass('yellow');
		});
	});
<?php echo '</script'; ?>
>

<form name="frmList" action="#" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table">
  <tr class="tr">
    <td class="td">Stt</td>
    <td class="td"></td>
    <td width="100%" class="td">Tên</td>    
    <td align="center" nowrap="nowrap" class="td">Trạng thái</td>
  </tr>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
  <tr class="unselected" bgcolor="<?php echo smarty_function_cycle(array('values'=>"#FFFFFF,#F7F7F7"),$_smarty_tpl);?>
">
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['no'];?>
</td>
    <td class="td"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/worldwide/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" width="70" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer" /></td>
    <td class="td">
		<a href="#" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" class="title"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a><br />
        <em style="color:#999999"><?php echo $_smarty_tpl->tpl_vars['item']->value['address'];?>
</em><br />
		Nhóm: <span style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['item']->value['funname'];?>
</span></td>    
   
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
  </tr>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>
<div style="text-align:right; color:#0000CC"> <?php echo $_smarty_tpl->tpl_vars['Display']->value;?>
</div>
</form><?php }
}
