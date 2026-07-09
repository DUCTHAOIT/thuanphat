<?php
/* Smarty version 3.1.36, created on 2026-06-29 15:30:37
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/voucher.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a422d2d99c551_96847253',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5de90cef4d34dfb4309fc3c7984c152fb8b32e8c' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/voucher.tpl',
      1 => 1754187770,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a422d2d99c551_96847253 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 language="javascript" type="text/javascript">
	function goEdit(id){
		document.frmList.id.value=id;
		document.frmList.op.value='frm';
		document.frmList.submit();	
	}
	//
	function goPhoto(id){
		document.frmList.id.value=id;
		document.frmList.op.value='photo';
		document.frmList.submit();	
	}
	//
	//
	function goFile(id){
		document.frmList.id.value=id;
		document.frmList.op.value='file';
		document.frmList.submit();	
	}
	//
	function goDelete(id,f){
		if (confirm('are you sure to delete?')!=0){
			document.frmList.id.value=id;
			document.frmList.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=voucher'
				  ,'onSuccess':function(req){ document.getElementById('voucherList').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );		  
			  return status;	
		}
	}
	//
	function callSearch(f){
		var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=voucher'
			  ,'onSuccess':function(req){ document.getElementById('voucherList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('voucherList');
		  return status;		
	}
	//
	function btnGo_Click(evt){
		var e=(window.event)?event:evt;
		if(e.keyCode==13){
			document.getElementById('btnSearch').click(); 
			return false;
		}
	}
	function callLock(id){
		AjaxRequest.get(
			{
			'url':'?m=voucher&op=lockvoucher&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
<?php echo '</script'; ?>
>

<div class="topic">Quản lý Voucher</div>
<div align="right"><a href="?m=voucher&op=frm" class="title"><?php echo $_smarty_tpl->tpl_vars['Create']->value;?>
</a></div>
<div id="voucherList"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['voucherList'][0], array( array(),$_smarty_tpl ) );?>
</div>
<?php }
}
