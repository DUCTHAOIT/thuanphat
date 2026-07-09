<?php
/* Smarty version 3.1.36, created on 2026-06-29 15:30:38
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/newsletter.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a422d2eced2e5_86893711',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7a4785d76e5b5e55a418057a815e6d8127108961' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/newsletter.tpl',
      1 => 1754187764,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a422d2eced2e5_86893711 (Smarty_Internal_Template $_smarty_tpl) {
?>
	<?php echo '<script'; ?>
 language="javascript">		
		function goDelete(f){
		if (confirm('Bạn có chắc chắn xóa?')!=0){			
			document.listNewsletter.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=email'
				  ,'onSuccess':function(req){ document.getElementById('listNewsletter').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listNewsletter');
			  return status;	
		}
	}
	<?php echo '</script'; ?>
>

<div id="listNewsletter"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['listNewsletter'][0], array( array(),$_smarty_tpl ) );?>
</div><?php }
}
