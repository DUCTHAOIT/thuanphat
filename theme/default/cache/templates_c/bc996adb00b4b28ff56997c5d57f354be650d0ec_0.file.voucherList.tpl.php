<?php
/* Smarty version 3.1.36, created on 2026-06-29 15:30:37
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/voucherList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a422d2daeafc5_70090487',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bc996adb00b4b28ff56997c5d57f354be650d0ec' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/voucherList.tpl',
      1 => 1754187770,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a422d2daeafc5_70090487 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>

<div style="text-align:right"><strong><?php echo $_smarty_tpl->tpl_vars['countArr']->value;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['vouchers_in_the_list']->value;?>
</div>
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%%" border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
    <td class="td" align="center">ID</td>
    <td class="td" align="center">Mã Voucher</td>
    <td class="td" align="center">% Giá trị giảm</td>
     <td class="td" align="center">Ngày Tạo</td>
    <td class="td" align="center">Ghi chú: </td>
    <td class="td" nowrap="nowrap">Trạng thái</td>
    <td class="td" nowrap="nowrap">Khách hàng</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Status']->value;?>
</td>
    </tr>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
  <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#ffffff,#F4F4F4"),$_smarty_tpl);?>
">
   <td align="left" class="td"><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</td>
    <td class="td" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
    <td align="center" class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['loai'];?>
</td>
    <td align="center" class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['date_create'];?>
</td>
    <td align="center" class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['des'];?>
</td>
    
    <td nowrap="nowrap" class="td"><?php if ($_smarty_tpl->tpl_vars['item']->value['trangthai'] == 0) {?><font style="color:#FF0000">Chưa sử dụng</font><?php }
if ($_smarty_tpl->tpl_vars['item']->value['trangthai'] == 1) {?><font style="color:#0000FF">Đã Sử dụng</font><?php }?></td>
    <td align="center" class="td"><?php if ($_smarty_tpl->tpl_vars['item']->value['userid']) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['nameUser'][0], array( array('id'=>$_smarty_tpl->tpl_vars['item']->value['userid']),$_smarty_tpl ) );
}?></td>
    <td align="center" class="td"><img src="images/delete.gif" onclick="goDelete(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,document.frmList)" style="cursor:pointer" /></td>
    </tr>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>
</form>
<?php echo $_smarty_tpl->tpl_vars['sPage']->value;
}
}
