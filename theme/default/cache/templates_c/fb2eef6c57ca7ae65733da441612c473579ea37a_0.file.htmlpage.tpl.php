<?php
/* Smarty version 3.1.36, created on 2026-07-12 13:25:57
  from 'C:\xampp\htdocs\thuanphatitc.vn\theme\default\templates\htmlpage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a5379c54dbcc4_99486635',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fb2eef6c57ca7ae65733da441612c473579ea37a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thuanphatitc.vn\\theme\\default\\templates\\htmlpage.tpl',
      1 => 1783855490,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a5379c54dbcc4_99486635 (Smarty_Internal_Template $_smarty_tpl) {
?><link rel="stylesheet" href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/theme/default/templates/htmlpage.css">

<div class="namefun text-center"><?php echo $_smarty_tpl->tpl_vars['nameFun']->value;?>
</div>
<div class="text-center">
    <h1 class="topiccontent"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h1>
</div>

<div class="container hp-wrap">
    <?php if ($_smarty_tpl->tpl_vars['des']->value) {?><div class="hp-des"><?php echo $_smarty_tpl->tpl_vars['des']->value;?>
</div><?php }?>
    <div class="hp-content"><?php echo $_smarty_tpl->tpl_vars['arr']->value['content'];?>
</div>
</div>
<?php }
}
