<?php
/* Smarty version 3.1.36, created on 2025-10-03 11:23:31
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/product.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68df4fc3e5a3b7_53793675',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5f0a1f10b2c1ea0501da65d8f890b317c26d0386' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/product.tpl',
      1 => 1754187765,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68df4fc3e5a3b7_53793675 (Smarty_Internal_Template $_smarty_tpl) {
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
				  'url':'?m=product'
				  ,'onSuccess':function(req){ document.getElementById('productList').innerHTML=req.responseText;}
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
			  'url':'?m=product'
			  ,'onSuccess':function(req){ document.getElementById('productList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('productList');
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
			'url':'?m=product&op=lockProduct&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
<?php echo '</script'; ?>
>


<div>
<form name="frmSearch" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="list" />
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px" nowrap="nowrap"><strong><?php echo $_smarty_tpl->tpl_vars['Product_group']->value;?>
:</strong></td>
    <td style="padding-left:10px">
	<select name="catID" style="border:1px solid #cccccc;">
	<option value="" selected="selected"></option>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrTopicProduct']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
	<option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" style="padding-left:<?php echo $_smarty_tpl->tpl_vars['item']->value['level']*15;?>
px; padding-right:10px" >&nbsp; &nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
	<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</select>
	</td>	  
    <td style="padding-left:10px" nowrap="nowrap"><strong>Tên hoặc mã sản phẩm:</strong></td>
    <td style="padding-left:10px"><input type="text" class="text" name="keyword" style="width:150" onkeypress="return btnGo_Click(event);" /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="button" id="btnSearch" value="Search" class="button" onclick="callSearch(document.frmSearch)" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
</div>
<div align="right"><a href="?m=product&op=frm" class="title"><?php echo $_smarty_tpl->tpl_vars['Create']->value;?>
</a></div>
<div id="productList"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['productList'][0], array( array(),$_smarty_tpl ) );?>
</div>
<?php }
}
