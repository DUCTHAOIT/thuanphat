<?php
/* Smarty version 3.1.36, created on 2025-09-01 13:59:35
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/worldwide.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b544575abd52_35390488',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '536c89cadedd05e5e95de1d178a88c54d3799e5a' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/worldwide.tpl',
      1 => 1754188634,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b544575abd52_35390488 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="container">
    <div class="namefun text-center"><?php echo $_smarty_tpl->tpl_vars['nameFun']->value;?>
</div>
    <div class="text-center">
        <h1 class="topiccontent"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h1>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['des']->value) {?><div class="content" ><?php echo $_smarty_tpl->tpl_vars['des']->value;?>
</div><?php }?>
    <div class="row" ><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['worldwideList'][0], array( array(),$_smarty_tpl ) );?>
</div>
</div><?php }
}
