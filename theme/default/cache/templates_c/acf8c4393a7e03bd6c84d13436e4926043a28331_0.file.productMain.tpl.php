<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:45:10
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/productMain.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b017162911d9_95971348',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'acf8c4393a7e03bd6c84d13436e4926043a28331' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/productMain.tpl',
      1 => 1754740245,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b017162911d9_95971348 (Smarty_Internal_Template $_smarty_tpl) {
?><section>
<div class="container">
	<div class="namefun text-center"><?php echo $_smarty_tpl->tpl_vars['nameFun']->value;?>
</div>
	<div class="text-center">
        <h1 class="topiccontent"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h1>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['des']->value) {?><div class="content" align="center"  style="padding:10px; padding-bottom:30px"><?php echo $_smarty_tpl->tpl_vars['des']->value;?>
</div><?php }?>
    <div><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['product_list'][0], array( array(),$_smarty_tpl ) );?>
</div>
</div>
</section>

<?php }
}
