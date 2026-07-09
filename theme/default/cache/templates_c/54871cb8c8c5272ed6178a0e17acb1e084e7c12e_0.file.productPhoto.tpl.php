<?php
/* Smarty version 3.1.36, created on 2026-04-08 12:00:32
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/productPhoto.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_69d5e0f08f3ba2_08730250',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '54871cb8c8c5272ed6178a0e17acb1e084e7c12e' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/productPhoto.tpl',
      1 => 1754187766,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69d5e0f08f3ba2_08730250 (Smarty_Internal_Template $_smarty_tpl) {
?>
<link rel="stylesheet" href="js/upload/css/style.css">

<?php echo '<script'; ?>
 language="javascript" type="text/javascript">
	function goDelete(id,f){
		if (confirm('are you sure to delete?')!=0){
		document.frmList.photoID.value=id;
		document.frmList.op.value='deletePhoto';				
		var status = AjaxRequest.submit(
			f
			,{
			  'url':window.location.search
			  ,'onSuccess':function(req){ document.getElementById('productListPhoto').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  progress('productListPhoto');
		  return status;	
		}
	}
	
	function checkSendMail(f){
		var obj;
		obj=document.frmmain;
		if(obj.img_file.value==""){
			alert("Bạn cần chọn file ảnh");
			obj.img_file.focus();
			return;
		}else{	
			
			obj.submit();					
		  }
	}
//
<?php echo '</script'; ?>
>

<form name="frmmain" action="?m=product" method="post" enctype="multipart/form-data" id="formUpload" onSubmit="return false;">
<input type="hidden" name="op" value="addPhoto" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" style="padding-bottom:15px;"><strong><?php echo $_smarty_tpl->tpl_vars['Management_products']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
</strong></td>
    </tr>
  <tr>
    <td align="center">
		<?php if ($_smarty_tpl->tpl_vars['arr']->value['img']) {?>
	<img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
"  width="250px"/>
	<?php } else { ?>
		Not image
	<?php }?></td>
    <td width="100%" style="padding-left:50px">
	<div style="color:#FF0000; padding-bottom:15px"><strong>Mỗi lần cập nhật không quá 5 file ảnh</strong></div>
    <h2>Upload hình ảnh</h2>
		
			<div class="progress">
				<div class="progress-bar">0%</div>
			</div>
			<input type="file" name="img_file[]" multiple="true" onChange="previewImg(event);" id="img_file" accept="image/*">
			<div class="box-preview-img"></div>
			<div style="margin:5px"><input type="button" onclick="checkSendMail(document.frmmain);" value="Upload" class="button" /></div>
			<div class="output"></div>
		
        
	</td>
  </tr>
 
</table>
</form>
<div style="padding-bottom:10px; padding-top:10px" class="title"><?php echo $_smarty_tpl->tpl_vars['Photo_relation']->value;?>
</div>
<div id="productListPhoto"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['productListPhoto'][0], array( array(),$_smarty_tpl ) );?>
</div>

<?php echo '<script'; ?>
 src="js/upload/js/jquery.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/upload/js/jquery.form.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/upload/js/main.js"><?php echo '</script'; ?>
>
<?php }
}
