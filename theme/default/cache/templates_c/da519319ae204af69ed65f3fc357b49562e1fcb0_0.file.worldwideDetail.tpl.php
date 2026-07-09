<?php
/* Smarty version 3.1.36, created on 2025-08-29 15:01:35
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/worldwideDetail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b15e5fe7b794_22093931',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'da519319ae204af69ed65f3fc357b49562e1fcb0' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/worldwideDetail.tpl',
      1 => 1754197061,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b15e5fe7b794_22093931 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="container">
    <div class="namefun text-center"><?php echo $_smarty_tpl->tpl_vars['nameFun']->value;?>
</div>
    <div class="text-center">
        <h1 class="topiccontent"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h1>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['des']->value) {?><div class="content" ><?php echo $_smarty_tpl->tpl_vars['des']->value;?>
</div><?php }?>
    <div class="row" >
        <div class="col-xs-12 col-sm-4 col-md-4" style="padding-bottom:20px;"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/worldwide/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
"  border="0" vspace="0"  alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" class="img-thumbnail" /></div>
        <div class="col-xs-12 col-sm-8 col-md-8" style="padding-bottom:20px;">
            <p class="title"><?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
</p>
            <p><i><?php echo $_smarty_tpl->tpl_vars['arr']->value['address'];?>
</i></p>
            <p><?php echo $_smarty_tpl->tpl_vars['arr']->value['des'];?>
</p>
        </div>

    </div>
</div><?php }
}
