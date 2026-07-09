<?php
/* Smarty version 3.1.36, created on 2025-09-10 23:00:57
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/article.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68c1a0b9da9f21_81977792',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f35f52fe13b9005690614243ae3ca7bfcb54cb0e' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/article.tpl',
      1 => 1754187751,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68c1a0b9da9f21_81977792 (Smarty_Internal_Template $_smarty_tpl) {
?>
	<?php echo '<script'; ?>
 language="javascript" type="text/javascript">
		function callSearch(f)
		{			
			var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=article'
			  ,'onSuccess':function(req){ document.getElementById('listArticle').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('listArticle');
		  return status;		
		}	
		function goEdit(id){
			document.frmListArticle.id.value=id;
			document.frmListArticle.op.value='frm';
			document.frmListArticle.submit();	
		}
		//
		function goDelete(id,f){
		if (confirm('Bạn có chắc chắn xóa?')!=0){
			document.frmListArticle.id.value=id;
			document.frmListArticle.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=article'
				  ,'onSuccess':function(req){ document.getElementById('listArticle').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listArticle');
			  return status;	
		}
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
			'url': window.location.search + '&op=lock&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	function callDuyet(id){
		AjaxRequest.get(
			{
			'url': window.location.search + '&op=duyet&id='+id
			,'onSuccess':function(req){document.getElementById('duyet_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	<?php echo '</script'; ?>
>

<form name="frmSearch" action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="list" />
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px"><strong><?php echo $_smarty_tpl->tpl_vars['Group_name']->value;?>
:</strong></td>
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
    <td style="padding-left:10px"><strong><?php echo $_smarty_tpl->tpl_vars['Keyword']->value;?>
:</strong></td>
    <td style="padding-left:10px"><input type="text" id="txtSearch" name="keyword" class="text" value="<?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
" style="width:200" onkeypress="return btnGo_Click(event);" /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="button" id="btnSearch" value="Search" class="button" onclick="callSearch(document.frmSearch)" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<div style="text-align:right"><a href="?m=article&op=frm" class="title"><?php echo $_smarty_tpl->tpl_vars['Article_create']->value;?>
</a></div>
<div id="listArticle"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['listArticle'][0], array( array(),$_smarty_tpl ) );?>
</div><?php }
}
