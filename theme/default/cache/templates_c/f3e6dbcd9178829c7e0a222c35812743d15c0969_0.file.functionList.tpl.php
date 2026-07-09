<?php
/* Smarty version 3.1.36, created on 2025-09-10 08:44:08
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/functionList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68c0d7e8ed9d59_38039023',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f3e6dbcd9178829c7e0a222c35812743d15c0969' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/functionList.tpl',
      1 => 1754187758,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68c0d7e8ed9d59_38039023 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>
<!--
Danh sach chuc nang
-->

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

<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table">
  <tr  class="tr">
    <td class="td" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['Function_name']->value;?>
</td>
    <td align="right" style="padding-right:10px" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['Show_position']->value;?>
</td>
   
    <td align="center" nowrap="nowrap" style="padding-left:10px; padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Order']->value;?>
</td>
    <td align="center" style="padding-left:10px; padding-right:10px" nowrap="nowrap">Module</td>
   
    <td align="center" style="padding-left:10px; padding-right:10px">&nbsp;</td>
    </tr>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
  <tr class="unselected" bgcolor="<?php echo smarty_function_cycle(array('values'=>"#FFFFFF,#F7F7F7"),$_smarty_tpl);?>
">
  <?php $_smarty_tpl->_assignInScope('padding', $_smarty_tpl->tpl_vars['item']->value['level']*10+10);?>	
    <td width="100%" class="td" nowrap="nowrap" style="padding-left:<?php echo $_smarty_tpl->tpl_vars['padding']->value;?>
; padding-right:20px">
	<?php if ($_smarty_tpl->tpl_vars['item']->value['del'] == 1) {?>
		<a href="?m=function&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" class="title"><?php if ($_smarty_tpl->tpl_vars['item']->value['root'] == true) {?> <strong><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</strong><?php } else {
echo $_smarty_tpl->tpl_vars['item']->value['name'];
}?></a>
	<?php } else { ?> 
		<?php if ($_smarty_tpl->tpl_vars['item']->value['root'] == true) {?> <strong><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</strong><?php } else {
echo $_smarty_tpl->tpl_vars['item']->value['name'];
}?>
	<?php }?></td>
	<td align="right" style="padding-left:10px; padding-right:10px" nowrap="nowrap">
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrPosition']->value, 'i', false, 'k');
$_smarty_tpl->tpl_vars['i']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->do_else = false;
?>
		<?php if ($_smarty_tpl->tpl_vars['item']->value['ctrl']&$_smarty_tpl->tpl_vars['k']->value) {?>
		<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
,
		<?php }?>
	<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>	</td>
   
    <td align="center" style="padding-left:10px; padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['item']->value['sort'];?>
</td>
    <td align="center" style="padding-left:10px; padding-right:10px" nowrap="nowrap"><?php if ($_smarty_tpl->tpl_vars['item']->value['module'] == 'htmlpage') {?>Trang HTML<?php }
if ($_smarty_tpl->tpl_vars['item']->value['module'] == 'article') {?>Bài viết<?php }
if ($_smarty_tpl->tpl_vars['item']->value['module'] == 'product') {?>Khóa học<?php }
if ($_smarty_tpl->tpl_vars['item']->value['module'] == 'gopvon') {?>Gói Combo<?php }
if ($_smarty_tpl->tpl_vars['item']->value['module'] == 'contact') {?>Liên hệ<?php }
if ($_smarty_tpl->tpl_vars['item']->value['module'] == 'partner') {?>HLV<?php }?></td>
	
	<!--
  
	<td align="center" style="padding-left:10px; padding-right:10px" nowrap="nowrap">
		 <?php if ($_smarty_tpl->tpl_vars['item']->value['module'] == 'product'&$_smarty_tpl->tpl_vars['item']->value['parent'] > 0) {?><a href="?m=function&f=search_criteria&id_function=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><img src="images/icon_search.gif"  border="0" title="Search criteria" /></a><?php }?> 
	</td>
	-->
    <td align="center" style="padding-left:10px; padding-right:10px" nowrap="nowrap"> 	 
	<?php if ($_smarty_tpl->tpl_vars['item']->value['del'] == 1) {?>
		<a href="?m=function&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><img src="images/edit.gif"  border="0" title="Edit" /></a>  &nbsp;<a href="?m=function&op=delete&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" onclick="return confirm('Bạn chắc muốn xóa?');"><img src="images/delete.gif" border="0" title="Delete" /></a> 
	<?php } else { ?> 
		<img src="images/edit_off.gif"  border="0" title="Edit" /> &nbsp; <img src="images/deleteOff.gif" border="0" />	
	<?php }?> 
    <?php if ($_smarty_tpl->tpl_vars['item']->value['ctrl']&2) {?> <img src="images/security.gif" title="Security" /> <?php }?> <?php if ($_smarty_tpl->tpl_vars['item']->value['ctrl']&1) {?> <?php } else { ?> <img src="images/0.gif" title="Lock" /> <?php }?>
    </td>
</tr>
 <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>  
</table>
<?php }
}
