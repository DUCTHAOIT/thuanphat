<?php
/* Smarty version 3.1.36, created on 2025-10-03 11:23:32
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/productList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68df4fc40843a0_20810738',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '629d693504f7004a3199e6b3a845200d0eae0c99' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/productList.tpl',
      1 => 1754187766,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68df4fc40843a0_20810738 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>

<div style="text-align:right"><strong><?php echo $_smarty_tpl->tpl_vars['countArr']->value;?>
</strong> <?php echo $_smarty_tpl->tpl_vars['products_in_the_list']->value;?>
</div>
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%%" border="1" cellspacing="0" cellpadding="0" class="table table-striped table-bordered dataTable">
  <tr class="tr">
    <td class="td">ID</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Photo']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Product_name']->value;?>
</td>   
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Date_create']->value;?>
</td>
    <td class="td" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['Status']->value;?>
</td> 
    <td class="td" align="center">Slide ảnh</td>
    </tr>
  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
  <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#ffffff,#F4F4F4"),$_smarty_tpl);?>
">
   <td align="center" class="td"><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</td>	
    <td class="td">
	<?php if ($_smarty_tpl->tpl_vars['item']->value['img']) {?>
		<img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" width="70" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer" />
	<?php } else { ?>
		<img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/none.gif" width="70" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer" />
	<?php }?>	</td>
    <td width="50%" class="td">
	<a href="#" class="title" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a><br />
	Nhóm: <strong><?php echo $_smarty_tpl->tpl_vars['item']->value['nameCat'];?>
</strong></td>     
    <td align="center" class="td"><?php echo $_smarty_tpl->tpl_vars['item']->value['date_create'];?>
</td>	
    <td align="center" class="td">
    	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer" /> </label>
	<label id="lock_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onclick="callLock(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)" style="cursor:pointer; padding-right:5px"><img src="images/<?php echo $_smarty_tpl->tpl_vars['item']->value['ctrl'];?>
.gif" /></label>
    </td>
  
     <td align="center" class="td"><a href="#" onclick="goPhoto(<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
)"><img src="images/product_photo.jpg" border="0" /></a></td>
 
    </tr>
  <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</table>
</form>
<?php echo $_smarty_tpl->tpl_vars['sPage']->value;
}
}
