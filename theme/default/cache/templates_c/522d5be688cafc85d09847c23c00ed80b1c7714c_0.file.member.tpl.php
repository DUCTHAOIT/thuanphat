<?php
/* Smarty version 3.1.36, created on 2025-09-03 08:49:12
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/member.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b79e98ec4fc8_13266789',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '522d5be688cafc85d09847c23c00ed80b1c7714c' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/member.tpl',
      1 => 1754187764,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b79e98ec4fc8_13266789 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 language="javascript" type="text/javascript">
function callLock(id){
	AjaxRequest.get(
		{
		'url':'?m=member&op=lockMember&id='+id
		,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
		,'onError':function(req){}
		}
	)	
}
//
function goEdit(id){
	document.frmList.id.value=id;
	document.frmList.op.value='frmCreate';
	document.frmList.submit();	
}
//
function goDelete(id,f){
	if (confirm('are you sure to delete?')!=0){
		document.frmList.id.value=id;
		document.frmList.op.value='mDelelte';
		var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=member'
			  ,'onSuccess':function(req){ document.getElementById('memberList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  return status;	
	}
}
<?php echo '</script'; ?>
>

<div style="text-align:right; padding-bottom:10px"><a href="?m=member&op=frmCreate" class="title"><?php echo $_smarty_tpl->tpl_vars['Member_create']->value;?>
</a></div>
<div id="memberList"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['memberList'][0], array( array(),$_smarty_tpl ) );?>
</div>
<?php }
}
