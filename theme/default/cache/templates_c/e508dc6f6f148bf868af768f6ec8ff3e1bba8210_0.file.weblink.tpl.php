<?php
/* Smarty version 3.1.36, created on 2026-06-29 15:30:39
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/weblink.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a422d2fe66ae2_31335110',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e508dc6f6f148bf868af768f6ec8ff3e1bba8210' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/weblink.tpl',
      1 => 1754187771,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a422d2fe66ae2_31335110 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 language="javascript" type="text/javascript">
function callLock(id){
	AjaxRequest.get(
		{
		'url':window.location.search + '&op=lock&id='+id
		,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
		,'onError':function(req){}
		}
	)	
}
//
function goEdit(id,f){
	document.frmList.id.value=id;
	document.frmList.op.value='frm';
	progress('frm');
	var status = AjaxRequest.submit(
		f
		,{
		  'url':window.location.search
		  ,'onSuccess':function(req){ document.getElementById('frm').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );		  
	  return status;	
}
//
function goDelete(id,f){
	if (confirm('are you sure to delete?')!=0){
		document.frmList.id.value=id;
		document.frmList.op.value='delelte';
		progress('listWeblink');	
		var status = AjaxRequest.submit(
			f
			,{
			  'url':window.location.search
			  ,'onSuccess':function(req){ document.getElementById('listWeblink').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  return status;	
	}
}
//
function callSubmit(f){
	progress('listWeblink');	
	var status = AjaxRequest.submit(
		f
		,{
		  'url':window.location.search
		  ,'onSuccess':function(req){ document.getElementById('listWeblink').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );		  
	  return status;
}
<?php echo '</script'; ?>
>

<div style="padding-bottom:10px" class="topic"><?php echo $_smarty_tpl->tpl_vars['Website_associate']->value;?>
</div>
<div id="frm"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['frmWeblink'][0], array( array(),$_smarty_tpl ) );?>
</div>
<div id="listWeblink"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['listWeblink'][0], array( array(),$_smarty_tpl ) );?>
</div>
<?php }
}
