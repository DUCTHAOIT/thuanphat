<?php
/* Smarty version 3.1.36, created on 2025-10-15 10:38:09
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/slide_List.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68ef17212ff8e3_39437899',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2eb58d5274486af3ed85353b262a99111cc99f60' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/slide_List.tpl',
      1 => 1754187766,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68ef17212ff8e3_39437899 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/www/wwwroot/thuanphatitc.vn/smarty-master/libs/plugins/function.cycle.php','function'=>'smarty_function_cycle',),));
?>

<table border="1" cellspacing="0" cellpadding="0" class="table">
  <tr class="tr">
  	<td class="td">STT</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Photo']->value;?>
</td>
    <td class="td"><?php echo $_smarty_tpl->tpl_vars['Product_name']->value;?>
</td>
    <td class="td">&nbsp;</td>
    </tr>
  <?php
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_start = (int)@$_smarty_tpl->tpl_vars['pageID']->value < 0 ? max(0, (int)@$_smarty_tpl->tpl_vars['pageID']->value + $__section_i_0_loop) : min((int)@$_smarty_tpl->tpl_vars['pageID']->value, $__section_i_0_loop);
$__section_i_0_total = min(($__section_i_0_loop - $__section_i_0_start), (int)@$_smarty_tpl->tpl_vars['limit']->value < 0 ? $__section_i_0_loop : (int)@$_smarty_tpl->tpl_vars['limit']->value);
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total !== 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = $__section_i_0_start; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
  <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#ffffff,#F4F4F4"),$_smarty_tpl);?>
">
  	 <td class="td title"><?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['sort'];?>
</td>
    <td class="td">
	<?php if ($_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['logo']) {?>
		<img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/logo/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['logo'];?>
" width="100px" />	
	<?php }?>	</td>
    <td width="50%" class="td title"><?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
<br />Link:<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['link'];?>
</td>
    <td align="center" class="td" nowrap="nowrap"><a href="?m=product&f=slide&id=<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['id'];?>
"><img src="images/edit.gif" border="0" /></a> &nbsp; <a href="?m=product&f=slide&op=del&id=<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['id'];?>
"><img src="images/delete.gif" border="0" /></a></td>
    </tr>
  <?php
}
}
?>
</table>
<div><?php echo $_smarty_tpl->tpl_vars['sPage']->value;?>
</div><?php }
}
