<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:40:49
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/chinhsach.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b01611b73592_66571537',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd0bdba384f7556adf1e9807c13667e48baf44f2b' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/chinhsach.tpl',
      1 => 1754410070,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b01611b73592_66571537 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style>
	.chinhsach {
		padding: 15px;
		padding-left: 20px;
		margin-left: -20px;
		max-height: 450px;
		overflow-x: hidden;
		overflow-y: scroll;
	}
	.chinhsach::-webkit-scrollbar {
    width: 6px;
	}
	.chinhsach::-webkit-scrollbar-thumb {
		background: #cdcdcd;
	}
	.chinhsach::-webkit-scrollbar-track {
		background: #f1f1f1;
	}
</style>


<div class="chinhsach">
    <?php echo $_smarty_tpl->tpl_vars['about']->value;?>

</div><?php }
}
