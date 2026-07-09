<?php
/* Smarty version 3.1.36, created on 2026-02-02 22:51:17
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/worldwide.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6980c7f5260698_24984342',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d359b3df83415af8b34a326e207473717f1a807' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/worldwide.tpl',
      1 => 1754187771,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6980c7f5260698_24984342 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 language="javascript" type="text/javascript">
	function callSearch(f)
		{			
			var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=worldwide'
			  ,'onSuccess':function(req){ document.getElementById('worldwideList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('listArticle');
		  return status;		
		}	
function callLock(id){
	AjaxRequest.get(
		{
		'url':window.location.search + '&op=lockworldwide&id='+id
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
			  ,'onSuccess':function(req){ document.getElementById('worldwideList').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );	
		  progress('worldwideList');		  
		  return status;	
	}
}
<?php echo '</script'; ?>
>

<form name="frmSearch" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="list" />
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px"><strong>Nhóm:</strong></td>
    <td style="padding-left:10px">
	<select name="catID" style="border:1px solid #cccccc;">
	<option value="" selected="selected"></option>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrTopicArticle']->value, 'item', false, 'key');
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
    <td style="padding-left:10px"><strong>Từ khóa:</strong></td>
    <td style="padding-left:10px"><input type="text" id="txtSearch" name="keyword" class="text" value="<?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
" style="width:200" onkeypress="return btnGo_Click(event);" /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="button" id="btnSearch" value="Search" class="button" onclick="callSearch(document.frmSearch)" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<div style="text-align:right; padding-bottom:5px"><a href="?m=worldwide&op=frm" class="title">Thêm mới</a></div>
<div id="worldwideList"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['worldwideList'][0], array( array(),$_smarty_tpl ) );?>
</div>
<?php }
}
