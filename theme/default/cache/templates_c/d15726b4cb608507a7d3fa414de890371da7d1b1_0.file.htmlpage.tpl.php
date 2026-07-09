<?php
/* Smarty version 3.1.36, created on 2025-09-10 22:56:49
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/htmlpage.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68c19fc1dc4950_74392501',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd15726b4cb608507a7d3fa414de890371da7d1b1' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/htmlpage.tpl',
      1 => 1754187762,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68c19fc1dc4950_74392501 (Smarty_Internal_Template $_smarty_tpl) {
?>
	<?php echo '<script'; ?>
 language="javascript">
		function callSearch()
		{
			AjaxRequest.get(
				{
				'url':'?m=htmlpage&op=list&txtSearch='+document.getElementById('txtSearch').value
				,'onSuccess':function(req){document.getElementById('listHtmlpage').innerHTML=req.responseText;}
				,'onError':function(req){}
				}
			)		
		}	
		function goEdit(id){
			document.listHtmlpage.id.value=id;
			document.listHtmlpage.op.value='frm';
			document.listHtmlpage.submit();	
		}
		//
		function goDelete(f){
		if (confirm('Bạn có chắc chắn xóa?')!=0){			
			document.listHtmlpage.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=htmlpage'
				  ,'onSuccess':function(req){ document.getElementById('listHtmlpage').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listHtmlpage');
			  return status;	
		}
	}
	<?php echo '</script'; ?>
>

<form action="?m=htmlpage" method="post" enctype="multipart/form-data">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border:1px solid #E3E6EB; padding-bottom:2px; padding-left:2px; padding-right:2px; padding-top:2px"><table border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#E3E6EB" height="30">
    <td style="padding-left:10px"><strong><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
:</strong></td>
    <td style="padding-left:10px"><input type="text" id="txtSearch" name="txtSearch" class="text" style="width:200" value="<?php echo $_smarty_tpl->tpl_vars['Keyword']->value;?>
"  /></td>
    <td style="padding-left:10px; padding-right:10px"><input type="submit" name="btnSearch" class="button" value="Search" /></td>
  </tr>
</table></td>
  </tr>
</table>
</form>
<div style="text-align:right"><a href="?m=htmlpage&amp;op=frm"><?php echo $_smarty_tpl->tpl_vars['Create']->value;?>
</a></div>
<div id="listHtmlpage"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['listHtmlpage'][0], array( array(),$_smarty_tpl ) );?>
</div><?php }
}
