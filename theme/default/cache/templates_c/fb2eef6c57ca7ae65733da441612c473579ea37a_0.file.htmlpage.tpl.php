<?php
/* Smarty version 3.1.36, created on 2026-07-08 08:30:21
  from 'C:\xampp\htdocs\thuanphatitc.vn\theme\default\templates\htmlpage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a4dee7db68a81_57855992',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fb2eef6c57ca7ae65733da441612c473579ea37a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thuanphatitc.vn\\theme\\default\\templates\\htmlpage.tpl',
      1 => 1783309162,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a4dee7db68a81_57855992 (Smarty_Internal_Template $_smarty_tpl) {
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
