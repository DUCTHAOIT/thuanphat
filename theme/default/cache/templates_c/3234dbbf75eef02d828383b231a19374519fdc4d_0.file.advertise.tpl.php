<?php
/* Smarty version 3.1.36, created on 2026-02-02 22:48:46
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/advertise.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6980c75e23a629_40289451',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3234dbbf75eef02d828383b231a19374519fdc4d' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/advertise.tpl',
      1 => 1754187750,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6980c75e23a629_40289451 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 language="javascript" type="text/javascript">
function callLock(id){
	AjaxRequest.get(
		{
		'url':window.location.search + '&op=lockAdvertise&id='+id
		,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
		,'onError':function(req){}
		}
	)	
}
//
function goEdit(id){
	document.frmList.id.value=id;
	document.frmList.op.value='frm';
	document.frmList.submit();	
}
//
function goDelete(id,f){
	if (confirm('are you sure to delete?')!=0){
		document.frmList.id.value=id;
		document.frmList.op.value='pDelete';		
		var status = AjaxRequest.submit(
			f
			,{
			  'url':window.location.search
			  ,'onSuccess':function(req){ document.getElementById('advertiseList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );	
		  progress('advertiseList');		  
		  return status;	
	}
}
<?php echo '</script'; ?>
>

<div style="text-align:right; padding-bottom:5px"><a href="?m=advertise&op=frm" class="title"><?php echo $_smarty_tpl->tpl_vars['Create_advertise']->value;?>
</a></div>
<div id="advertiseList"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['advertiseList'][0], array( array(),$_smarty_tpl ) );?>
</div>
<?php }
}
