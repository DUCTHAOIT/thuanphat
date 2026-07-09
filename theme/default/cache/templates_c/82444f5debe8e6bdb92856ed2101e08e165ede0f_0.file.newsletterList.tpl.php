<?php
/* Smarty version 3.1.36, created on 2026-06-29 15:30:38
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/newsletterList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a422d2ed5e500_80192895',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '82444f5debe8e6bdb92856ed2101e08e165ede0f' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/newsletterList.tpl',
      1 => 1754187764,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a422d2ed5e500_80192895 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>


<form name="listNewsletter" action="?m=email" method="post">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="send" />
<table width="100%" border="10" cellspacing="0" cellpadding="2" class="table">
  <tr class="tr">
    <td class="td">ID</td>
    <td width="100%" class="td">Email</td>
    
    <td align="center" class="td">Xác thực</td>
    <td class="td">&nbsp;</td>
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
		<td class="td" style="padding-left:20px"><?php echo $_smarty_tpl->tpl_vars['item']->value['email'];?>
</td>
       
		<td align="center" class="td">
		<?php if ($_smarty_tpl->tpl_vars['item']->value['status'] == 1) {?>
		<img src="images/loai0.gif" alt="Đã xác thực" border="0" />
		<?php } else { ?>
		<img src="images/loai1.gif" alt="Chưa xác thực" border="0" />
		<?php }?>		</td>
		<td class="td"><a href="?m=email&op=delete&id=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><img src="images/delete.gif" alt="Delete" style="cursor:pointer" border="0" /></a></td>
	  </tr>
	  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      <!--
	   <tr>
		<td align="right" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Content']->value;?>
 :</td>
		<td colspan="4" ><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['viewFckeditor'][0], array( array('content'=>$_smarty_tpl->tpl_vars['arr']->value['content']),$_smarty_tpl ) );?>
</td>
	  </tr>
	  <tr>
	  	<td colspan="5" align="right"><input type="submit" value="Send" /></td>
	  </tr>
      -->
</table>
</form><?php }
}
