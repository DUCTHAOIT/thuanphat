<?php
/* Smarty version 3.1.36, created on 2026-04-08 11:19:11
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/articleFrm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_69d5d73fe61cf7_47519079',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '449625c3a2bdc1020e38cb530d872188239fa2b0' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/articleFrm.tpl',
      1 => 1754187751,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_69d5d73fe61cf7_47519079 (Smarty_Internal_Template $_smarty_tpl) {
?><form name="frmmain" action="?m=article" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
<input type="hidden" name="fileName" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" />
<input type="hidden" id="fileName1" name="fileName1" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['img1'];?>
" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td colspan="2" class="topic">Cập nhật tin bài</td>
    </tr>
  <tr>
    <td align="right" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Date_create']->value;?>
 :</td>
    <td width="100%">
    <div style="width:200px">
    	<input type="text" name="date" id="date" style="width:200px" value="<?php if ($_smarty_tpl->tpl_vars['id']->value) {
echo $_smarty_tpl->tpl_vars['arr']->value['date_create'];?>
 <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['date_create']->value;?>
 <?php }?>"  class="text" data-datepicker/>
         <div style="position:absolute; right:0; top:0; z-index:9; width:20px; height:30px; padding-top:10px"><i class="fal fa-calendar-alt"></i></div>
     </div>                        
	</td>
  </tr>  
  <tr>
    <td align="right" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Group_name']->value;?>
 :</td>
    <td>
	<select id="groupID" name="groupID[]" size="5" multiple="multiple" style="border:1px solid #cccccc;">
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrTopicArticle']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
	<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" style="padding-left:10px; padding-right:10px" <?php echo $_smarty_tpl->tpl_vars['item']->value['select'];?>
 ><?php if ($_smarty_tpl->tpl_vars['item']->value['parent'] == '0') {
} else { ?>&nbsp; &nbsp;&nbsp; &nbsp;<?php }
echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
 </option>
	<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>	
	</select>
	</td>
  </tr>
  
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['Article_name']->value;?>
 :</td>
    <td><input type="text" name="name" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" /></td>
  </tr>
  <tr>
    <td align="right" nowrap="nowrap" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Images']->value;?>
 :</td>
    <td>
	<div><strong><?php echo $_smarty_tpl->tpl_vars['Photo_big_size']->value;?>
</strong><br /><em style="color:#666666">(w: 300px, h: 200px)</em></div>
	<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td id="fileNamev" style="padding-bottom:10px; padding-top:10px"><?php if ($_smarty_tpl->tpl_vars['arr']->value['img']) {?><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/article/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" /><?php }?></td>
			<!-- <td id="fileName1v" style="padding-left:40px;"><?php if ($_smarty_tpl->tpl_vars['arr']->value['img1']) {?><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/article/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img1'];?>
" /><?php }?></td>-->
		  </tr>
		  <tr>
			<td nowrap="nowrap">
			<label style="cursor:pointer" onclick="WindowUpload('fileName')"><strong>Upload photo</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg()"><strong>Remote photo</strong></label></td>
			<!--
            <td style="padding-left:40px;">
			<label style="cursor:pointer" onclick="WindowUpload('fileName1')"><strong>Upload photo</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg1()"><strong>Remote photo</strong></label>
			</td>
            -->
		  </tr>
		</table>	
		
		</td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['Images_title']->value;?>
 :</td>
    <td><input type="text" name="title_img" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['title_img'];?>
" /></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Summary']->value;?>
 :</td>
    <td><textarea name="summary" class="textarea" style="height:150"><?php echo $_smarty_tpl->tpl_vars['arr']->value['summary'];?>
</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Content']->value;?>
 :</td>
    <td>
	<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['viewFckeditor'][0], array( array('content'=>$_smarty_tpl->tpl_vars['arr']->value['content']),$_smarty_tpl ) );?>
	</td>
  </tr>
  <tr>
	<td align="right" style="padding-right:10px">Tin tiêu biểu:</td>
	<td>
	<input name="special_promotion" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['arr']->value['special_promotion'] == 1) {?> checked="checked" <?php }?> />
	</td>
	</tr>
  <tr>
    <td align="right" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Source']->value;?>
 :</td>
    <td><input type="text" name="source" class="text" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['source'];?>
" /></td>
  </tr>
  <tr>
    <td align="left" style="padding:5px; text-transform:uppercase; background-color:#CCCCCC" nowrap="nowrap" colspan="4">Thông tin hỗ trợ SEO</td>  
  </tr>
  
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Title</td>
    <td width="100%" colspan="3"><textarea name="title" class="textarea" style="height:100"><?php echo $_smarty_tpl->tpl_vars['arr']->value['title'];?>
</textarea></td>
  </tr>
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Description</td>
    <td width="100%" colspan="3"><textarea name="description" class="textarea" style="height:100"><?php echo $_smarty_tpl->tpl_vars['arr']->value['description'];?>
</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Keywords</td>
    <td width="100%" colspan="3"><textarea name="keywords" class="textarea" style="height:100"><?php echo $_smarty_tpl->tpl_vars['arr']->value['keywords'];?>
</textarea></td>
  </tr>
  
  <tr>
    <td align="right" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Language']->value;?>
 :</td>
    <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getCboLanguage'][0], array( array('langID'=>$_smarty_tpl->tpl_vars['arr']->value['lang']),$_smarty_tpl ) );?>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="submit" value="Submit" />	</td>
  </tr>
  
  <?php echo '<script'; ?>
 language="Javascript1.2">
								  
		function removeImg(){
			document.getElementById('fileNamev').innerHTML="";
			document.frmmain.fileName.value="";
		}	
		function removeImg1(){
			document.getElementById('fileName1v').innerHTML="";
			document.frmmain.fileName1.value="";
		}		  
	<?php echo '</script'; ?>
>
	
	
</table>
</form><?php }
}
