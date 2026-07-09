<?php
/* Smarty version 3.1.36, created on 2026-07-08 06:26:47
  from 'C:\xampp\htdocs\thuanphatitc.vn\theme\default\templates\advertiseCenter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a4dd187a47379_34252491',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ac61fdd46771bd642d625c9dbfe6681f8a811b12' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thuanphatitc.vn\\theme\\default\\templates\\advertiseCenter.tpl',
      1 => 1783309159,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a4dd187a47379_34252491 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('i', "0");?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>

<div class="banner banner--qc pr">

        <div class="item">

            <div class="banner__img"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/advertise/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" alt=""></div>

            <div class="banner__content_qc">

                <div class="container">

                   <div class="item_content_qc" align="left" style="padding-left:20px;">

                        <h2 style="font-weight:500"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</h2>

                        <p  style="font-weight:500"><?php echo $_smarty_tpl->tpl_vars['item']->value['address'];?>
</p>

                        <a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/user/" class="btn_viewmore flex-center">Đăng ký ngay</a>

                    </div>

                </div>

            </div>

        </div>

 </div>

<?php $_smarty_tpl->_assignInScope('i', ((string)$_smarty_tpl->tpl_vars['i']->value)."+1");?>	 

<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
