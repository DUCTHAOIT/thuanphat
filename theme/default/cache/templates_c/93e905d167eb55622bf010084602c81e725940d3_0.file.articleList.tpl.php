<?php
/* Smarty version 3.1.36, created on 2025-09-10 23:00:57
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/articleList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68c1a0b9e57fb0_12285557',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93e905d167eb55622bf010084602c81e725940d3' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/articleList.tpl',
      1 => 1754187751,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68c1a0b9e57fb0_12285557 (Smarty_Internal_Template $_smarty_tpl) {
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

<form name="frmListArticle" action="?m=article" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%" border="1" cellspacing="0" cellpadding="2"  class="table table-striped table-bordered dataTable">

  <tr class="tr">
    <td class="td">ID</td>
    <td width="100%" class="td"><?php echo $_smarty_tpl->tpl_vars['Article_name']->value;?>
</td>
    <td align="center" nowrap="nowrap" class="td"><?php echo $_smarty_tpl->tpl_vars['Source']->value;?>
</td>
     <td align="center" nowrap="nowrap" class="td">Người nhập</td>
   
    <td align="center" nowrap="nowrap" class="td" colspan="3"><?php echo $_smarty_tpl->tpl_vars['Status']->value;?>
</td>
  
     <td class="td">Xem trước</td>
    
  </tr>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
  <tr class="unselected" bgcolor="<?php echo smarty_function_cycle(array('values'=>"#FFFFFF,#F7F7F7"),$_smarty_tpl);?>
">
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</td>
    <td class="td">
		<a href="#" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" class="title"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a> <em style="color:#999999">(<?php echo $_smarty_tpl->tpl_vars['item']->value['date_create'];?>
)</em><br />
		<?php echo $_smarty_tpl->tpl_vars['Group_name']->value;?>
: <span style="font-weight: bold"><?php echo $_smarty_tpl->tpl_vars['item']->value['topicName'];?>
</span></td>
    <td align="center" class="td"><?php if ($_smarty_tpl->tpl_vars['item']->value['source']) {?> <?php echo $_smarty_tpl->tpl_vars['item']->value['source'];?>
 <?php } else { ?>N/A<?php }?></td>
     <td align="center" class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['lastname'];?>
 <?php echo $_smarty_tpl->tpl_vars['item']->value['fistname'];?>
</td>
   
    <td align="center" class="td" id="lock_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="callLock(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer"><img src="images/<?php echo $_smarty_tpl->tpl_vars['item']->value['ctrl'];?>
.gif"  /></td>
    <td class="td"><img src="images/edit.gif" alt="Edit" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer" /></td>
    <td class="td"><img src="images/delete.gif" alt="Delete" onclick="goDelete(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,document.frmListArticle)" style="cursor:pointer" /></td>
      <td class="td"><a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['htaccess'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
" target="_blank"><img src="images/icon_search.gif" style="cursor:pointer" border="0" /></a></td>
    
  </tr>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>
<div style="text-align:right; color:#0000CC"> <?php echo $_smarty_tpl->tpl_vars['sPage']->value;?>
</div>
</form>
<?php }
}
