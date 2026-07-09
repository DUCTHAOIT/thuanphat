<?php
/* Smarty version 3.1.36, created on 2025-09-10 08:44:09
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/fucntionMain.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68c0d7e9053bd0_48313242',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5e72738e818070c9279942f5dcfb04c9995f16d1' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/fucntionMain.tpl',
      1 => 1754187758,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68c0d7e9053bd0_48313242 (Smarty_Internal_Template $_smarty_tpl) {
?><h2>Quản lý chức năng</h2>
<form name="frmmain" action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="m" value="function" />
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
<input type="hidden" id="fileName" name="fileName" value="<?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['img1'];?>
" />
<input type="hidden" id="fileName2" name="fileName2" value="<?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['img2'];?>
" />
<input type="hidden" name="theme" value="default" />
<table width="100%" border="0" cellspacing="5" cellpadding="5" >
  <tr>
    <td style="padding:15px"><table width="100%" border="0" cellspacing="0" cellpadding="5" >
  <tr>
    <td>&nbsp;</td>
    <td width="100%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getCboFunction'][0], array( array('selectID'=>$_smarty_tpl->tpl_vars['infoFunc']->value['parent']),$_smarty_tpl ) );?>
</td>
  </tr>
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['Function_name']->value;?>
</td>
    <td><input type="text" class="form-control" name="name" size="40" value="<?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['name'];?>
"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
		<div><em style="color:#666666"><?php echo $_smarty_tpl->tpl_vars['Photo_big_size']->value;?>
</em></div>
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td id="fileNamev" style="padding-bottom:10px; padding-top:10px"><?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['img1']) {?><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/function/<?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['img1'];?>
" style="max-width:500" /><?php }?></td>
			<td id="fileName2v" style="padding-left:40px;"><?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['img2']) {?><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/function/<?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['img2'];?>
" style="max-width:500"/><?php }?></td>
		  </tr>
		  <tr>
			<td nowrap="nowrap">
			<label style="cursor:pointer" onclick="WindowUpload('fileName')"><strong>Upload photo 1</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg()"><strong>Remove photo 1</strong></label></td>
			<td style="padding-left:40px;">
			<label style="cursor:pointer" onclick="WindowUpload('fileName2')"><strong>Upload photo 2</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg2()"><strong>Remove photo 2</strong></label>
			</td>
		  </tr>
		</table>	
	</td>
  </tr>
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['Description']->value;?>
</td>
    <td><div id="des"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['viewFckeditor'][0], array( array('content'=>$_smarty_tpl->tpl_vars['infoFunc']->value['des']),$_smarty_tpl ) );?>
</div></td>
  </tr>
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['Function_url']->value;?>
</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['Article']->value;?>
</td>
        <td width="90%"><input type="radio" name="module" id="article" value="article" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'article') {?> checked="checked" <?php }?> /></td>
        </tr>
      
     
    <tr>
	   <tr>
        <td>Khóa học</td>
        <td><input type="radio" name="module" id="product" value="product" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'product') {?> checked="checked" <?php }?> /></td>
      </tr>
      <tr>
        <td>Combo</td>
        <td><input type="radio" name="module" id="gopvon" value="gopvon" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'gopvon') {?> checked="checked" <?php }?> /></td>
      </tr>
        <tr>
        <td style="padding-right:10px;" nowrap="nowrap">Ý kiến khách hàng</td>
        <td><input type="radio" name="module" id="worldwide" value="worldwide" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'worldwide') {?> checked="checked" <?php }?> /></td>
      </tr>
      
		<tr>
        <td style="padding-right:10px;">Huấn luyện viên</td>
        <td><input type="radio" name="module" id="partner" value="partner" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'partner') {?> checked="checked" <?php }?> /></td>
      </tr>
       <tr>
        <td>Đăng ký</td>
        <td><input type="radio" name="module" id="contact" value="contact" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'contact') {?> checked="checked" <?php }?> /></td>
      </tr>	  
     <!--    
      <tr>
        <td>Đăng ký</td>
        <td><input type="radio" name="module" id="invest" value="invest" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'invest') {?> checked="checked" <?php }?> /></td>
      </tr>
     <tr>
        <td>Video</td>
        <td><input type="radio" name="module" id="video" value="video" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'video') {?> checked="checked" <?php }?> /></td>
      </tr>
    <tr>
        <td>Photo</td>
        <td><input type="radio" name="module" id="photo" value="photo" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'photo') {?> checked="checked" <?php }?> /></td>
      </tr>
        
     
	  <tr>
        <td>Danh mục đầu tư</td>
        <td><input type="radio" name="module" id="inveslist" value="inveslist" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'inveslist') {?> checked="checked" <?php }?> /></td>
      </tr>
	 
     
	  -->
      
      <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['HTML']->value;?>
</td>
        <td><input type="radio" name="module" id="htmlpage" value="htmlpage" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['module'] == 'htmlpage') {?> checked="checked" <?php }?> onfocus="txt_htmlpage.focus()" /> ID= <input type="text" class="form-control" id="txt_htmlpage" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['id_htmlpage']) {?> value="<?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['id_htmlpage'];?>
" <?php }?> name="txt_htmlpage" style="width:40" onfocus="htmlpage.checked=true" /></td>
        </tr>
      
    </table></td>
  </tr>  
    
  <tr>
    <td nowrap="nowrap" style="padding-right:15px"><?php echo $_smarty_tpl->tpl_vars['Show_position']->value;?>
</td>
    <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getCboPosition'][0], array( array('selectID'=>$_smarty_tpl->tpl_vars['infoFunc']->value['ctrl']),$_smarty_tpl ) );?>
</td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding-right:15px"><?php echo $_smarty_tpl->tpl_vars['Order']->value;?>
</td>
    <td><input type="text" class="form-control" name="order" style="width:40" value="<?php if (!$_smarty_tpl->tpl_vars['infoFunc']->value['sort']) {?> 0 <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['sort'];?>
 <?php }?>" /></td>
  </tr>
  
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['Action']->value;?>
?</td>  
	<td><input type="checkbox" value="1" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['ctrl']&1) {?> checked="checked" <?php }?> name="action" /></td>
  </tr>
  <tr>
    <td align="left" style="padding:5px; text-transform:uppercase; background-color:#CCCCCC" nowrap="nowrap" colspan="4">Thông tin hỗ trợ SEO</td>  
  </tr>
  
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Title</td>
    <td width="100%" colspan="3"><textarea name="title"  class="form-control" style="height:100"><?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['title'];?>
</textarea></td>
  </tr>
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Description</td>
    <td width="100%" colspan="3"><textarea name="description"  class="form-control" style="height:100"><?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['description'];?>
</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Keywords</td>
    <td width="100%" colspan="3"><textarea name="keywords"  class="form-control" style="height:100"><?php echo $_smarty_tpl->tpl_vars['infoFunc']->value['keywords'];?>
</textarea></td>
  </tr>
   <tr>
  	 <td nowrap="nowrap" style="padding-right:10px">Tiêu điểm?</td>
    <td><input type="checkbox" name="focus" id="focus" value="1" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['focus']) {?> checked="checked" <?php }?> /></td>      
  	</tr> 
  <!--
   
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['Action']->value;?>
?</td>
    <td><input type="checkbox" value="1" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['ctrl']&1) {?> checked="checked" <?php }?> name="action" />	</td>
  </tr>
  <tr>
    <td>Giao diện</td>
    <td>
		<select name="theme" style="border:1px solid #cccccc;">	  
		  <option value="default" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['theme'] == 'default') {?> selected="selected" <?php }?> >&nbsp; &nbsp;Mặc định</option>	  		
		  <option value="blue" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['theme'] == 'blue') {?> selected="selected" <?php }?>>&nbsp; &nbsp;blue</option>	       
		   <option value="darkblue" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['theme'] == 'darkblue') {?> selected="selected" <?php }?> >&nbsp; &nbsp;darkblue</option>	  
		  <option value="gray" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['theme'] == 'gray') {?> selected="selected" <?php }?>>&nbsp; &nbsp; gray</option>
		  <option value="green" style="padding-right:10px" <?php if ($_smarty_tpl->tpl_vars['infoFunc']->value['theme'] == 'green') {?> selected="selected" <?php }?>>&nbsp; &nbsp;green</option>	       
		 </select>	
	</td>
  </tr>
  -->
  <tr>
    <td><?php echo $_smarty_tpl->tpl_vars['Language']->value;?>
</td>
    <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getCboLanguage'][0], array( array('lang'=>$_smarty_tpl->tpl_vars['lang']->value),$_smarty_tpl ) );?>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="padding-top:10px"><input type="button" value="<?php echo $_smarty_tpl->tpl_vars['Update']->value;?>
" class="btn btn-primary" onclick="checkSubmit()" />	</td>
  </tr>
</table></td>
  </tr>
</table>

</form>
<div>
<?php echo $_smarty_tpl->tpl_vars['functionList']->value;?>

</div>

  <?php echo '<script'; ?>
 language="Javascript1.2">
	function removeImg(){
		document.getElementById('fileNamev').innerHTML="";
		document.frmmain.fileName.value="";
	}	
	function removeImg2(){		
		document.getElementById('fileName2v').innerHTML="";
		document.frmmain.fileName2.value="";
	}	
	function checkSubmit(){
		var obj;
		obj=document.frmmain;
		if(!obj.name.value){
			alert("Bạn cần nhập tên chức năng!");
			obj.name.focus();
			return;
		}else{		
			obj.submit();
		}
	} 	  
	<?php echo '</script'; ?>
>
<?php }
}
