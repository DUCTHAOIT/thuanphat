<?php
/* Smarty version 3.1.36, created on 2025-10-03 11:21:32
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/productFrm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68df4f4c1f73c1_13287906',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '08850946a290411afa15e4b5a7e8108ead08c6da' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/productFrm.tpl',
      1 => 1754187765,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68df4f4c1f73c1_13287906 (Smarty_Internal_Template $_smarty_tpl) {
?><style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<?php echo '<script'; ?>
 type="text/javascript" src="js/jscalendar/calendar.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/jscalendar/lang/calendar-en.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/jscalendar/calendar-setup.js"><?php echo '</script'; ?>
>
<form name="frmmain" action="?m=product" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addProduct" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
<input type="hidden" name="imgsmall" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" />
<input type="hidden" name="imgbig" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img1'];?>
" />
<input type="hidden" name="filePDF" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['pdf'];?>
" />
<h2>Thêm mới</h2>
<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td nowrap="nowrap" style="padding-right:10px">
		<table border="0" cellspacing="5" cellpadding="0" width="100%">
	  <tr>
		<td align="right" style="padding-right:10px; padding-top:10px" nowrap="nowrap">Đầu mục: </td>
		<td width="50%" style="padding-top:10px">		
		<select name="catID" id="catID" style="border:1px solid #cccccc;" onchange="technical();">			
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrTopicProduct']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
		<?php if ($_smarty_tpl->tpl_vars['item']->value['id'] == $_smarty_tpl->tpl_vars['arr']->value['catID']) {?>  			
		  <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" selected="selected" ><?php if ($_smarty_tpl->tpl_vars['item']->value['level'] == '1') {?>&nbsp; &nbsp; <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['level'] == '2') {?>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <?php }
echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
		<?php } else { ?>
			<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"  style="padding-left:15px; padding-right:10px"><?php if ($_smarty_tpl->tpl_vars['item']->value['level'] == '1') {?> &nbsp; &nbsp; <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['level'] == '2') {?>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <?php }
echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
		<?php }?>	
		<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</select>		</td>
	    <td width="25%" rowspan="4" valign="bottom" style="padding-top:10px">
		<div>Ảnh đại diện (kích thước khuyến nghị w:1000px - h:600px)<br />
		  <em style="color:#666666"></em></div>
		<div id="imgsmallv"><a href="#" onclick="WindowUpload('imgsmall')"><img src="<?php echo $_smarty_tpl->tpl_vars['arr']->value['imgs_view'];?>
" border="0" style="max-width:300px" /></a></div><label style="cursor:pointer" onclick="removeImg()"><strong>Remove photo</strong></label>			</td>
	    <!--
        <td width="25%" rowspan="6" valign="bottom" style="padding-top:10px"><div><strong><?php echo $_smarty_tpl->tpl_vars['Photo_big_size']->value;?>
</strong><br />
	      <em style="color:#666666">(w: 270px - h: 180px)</em></div>
		<div id="imgbigv"><a href="#" onclick="WindowUpload('imgbig')"><img src="<?php echo $_smarty_tpl->tpl_vars['arr']->value['imgb_view'];?>
" border="0" /></a></div><label style="cursor:pointer" onclick="removeImg2()"><strong>Remove photo</strong></label></td>
        -->
	  </tr>
	  
	  <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Tên: </td>
		<td><input name="name" type="text" style="width:80%" class="text" maxlength="255" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" /></td>
	  </tr>
       <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Sologan</td>
	    <td><input name="promotion" type="text" style="width:80%" class="text" maxlength="255" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['promotion'];?>
" /></td>
	    </tr>
        <tr>	 
		<td align="right" style="padding-right:10px; text-decoration:line-through" nowrap="nowrap">Giá cũ:</td>
		<td><input name="price_old" type="text" style="width:80%" class="text" maxlength="20" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['price_old'];?>
" /></td>
	  </tr>  
       <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Giá niêm yết:</td>
	    <td><input name="price_new" style="width:80%" type="text" class="text" maxlength="20" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['price'];?>
" /></td>
	  </tr>

 <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Tóm tắt</td>
    <td width="100%" colspan="3"><textarea name="summary" class="textarea" style="height:100"><?php echo $_smarty_tpl->tpl_vars['arr']->value['summary'];?>
</textarea></td>
  </tr>
 
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Nội dung:</td>
    <td colspan="3"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['viewFckeditor'][0], array( array('content'=>$_smarty_tpl->tpl_vars['arr']->value['content']),$_smarty_tpl ) );?>
</td>
  </tr>
	<tr>
		<td align="right" style="padding-right:10px" nowrap="nowrap">Chính Sách Affiliate: </td>
		<td colspan="3"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['viewFckeditor1'][0], array( array('content1'=>$_smarty_tpl->tpl_vars['arr']->value['tienich']),$_smarty_tpl ) );?>
</td>
	</tr>
	<tr>
		<td align="right" style="padding-right:10px" nowrap="nowrap">Nổi bật:</td>
		<td>
			<input name="special_promotion" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['arr']->value['special_promotion'] == 1) {?> checked="checked" <?php }?> />
		</td>
	</tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Thứ tự:</td>
    <td><input type="text" class="text" name="sort" style="width:40" value="<?php if (!$_smarty_tpl->tpl_vars['arr']->value['sort']) {?>1<?php } else {
echo $_smarty_tpl->tpl_vars['arr']->value['sort'];
}?>" /></td>
  </tr>
   
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['Date_create']->value;?>
: </td>
    <td  colspan="3"><input type="text" name="date" id="date" style="width:20%" class="text" value="<?php if ($_smarty_tpl->tpl_vars['arr']->value['date_create']) {
echo $_smarty_tpl->tpl_vars['arr']->value['date_create'];?>
 <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['date_create']->value;?>
 <?php }?>" />&nbsp;
	<button id="btndate" class="button" style="height:20;">...</button> <em>( yyyy /m /d )</em></td>
  </tr>

  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
    <td  colspan="3"><input type="submit" class="btn btn-primary" value="<?php echo $_smarty_tpl->tpl_vars['Update']->value;?>
" /></td>
  </tr>
</table>
</td></tr></table>

</form>

<?php echo '<script'; ?>
 language="Javascript1.2">
	$("#tongvondautu1,#tongvondautu2,#tongvondautu3,#sotienmotxuat1,#sotienmotxuat2,#sotienmotxuat3,#chietkhau12,#chietkhau1,#chietkhau22,#chietkhau2,#chietkhau32,#chietkhau3").on('keyup', function(){
		var n = parseInt($(this).val().replace(/\D/g,''),10);
		$(this).val(n.toLocaleString());
	});
	
	Calendar.setup(
		{
		  inputField  : "date",         // ID of the input field
		  ifFormat    : "%Y-%m-%d",    // the date format
		  button      : "btndate",       // ID of the button
		  showsTime	  :	true
		}			
	  );  

	//
	//
	function removeImg(){
		document.getElementById('imgsmallv').innerHTML="";
		document.frmmain.imgsmall.value="";
	}	
	//	
	function removeImg2(){
		document.getElementById('imgbigv').innerHTML="";
		document.frmmain.imgbig.value="";
	}
	//
	
	//
	//
	function manufacturers(){		
		AjaxRequest.get(
			{
			'url':'?m=product&f=search_manufacturers&fid='+document.frmmain.catID.value + '&id_product=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_manufacturers').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	//
	function xuatsu(){		
		AjaxRequest.get(
			{
			'url':'?m=product&f=search_xuatsu&fid='+document.frmmain.catID.value + '&id_product=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_xuatsu').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function technical(){		
		AjaxRequest.get(
			{
			'url':'?m=product&f=search_criteria&fid='+document.frmmain.catID.value + '&id_product=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_technical').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function logo_hang_san_xuat(){		
		AjaxRequest.get(
			{
			'url':'?m=product&f=logo_hang_san_xuat&id_hang_san_xuat='+document.frmmain.hang_san_xuat.value
			,'onSuccess':function(req){document.getElementById('div_logo_hang_san_xuat').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	manufacturers();
	xuatsu();
	//technical();
	//logo_hang_san_xuat();
<?php echo '</script'; ?>
>
<?php }
}
