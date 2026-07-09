<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:40:00
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/htmlpage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b015e0035ce7_07687308',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48c49ee4db85bedd3d28d721665b175e8f093bdc' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/htmlpage.tpl',
      1 => 1754188618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b015e0035ce7_07687308 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="container" style="padding:10px" >
	<div class="namefun text-center"><?php echo $_smarty_tpl->tpl_vars['nameFun']->value;?>
</div>
	<div class="text-center">
        <h1 class="topiccontent"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h1>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['des']->value) {?><div class="content" ><?php echo $_smarty_tpl->tpl_vars['des']->value;?>
</div><?php }?>
    <div class="content" ><?php echo $_smarty_tpl->tpl_vars['arr']->value['content'];?>
</div>
</div><?php }
}
