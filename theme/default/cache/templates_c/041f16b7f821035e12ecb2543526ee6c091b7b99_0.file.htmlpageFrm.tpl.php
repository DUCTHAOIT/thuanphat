<?php
/* Smarty version 3.1.36, created on 2025-09-10 22:57:27
  from '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/htmlpageFrm.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68c19fe7d43734_45691366',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '041f16b7f821035e12ecb2543526ee6c091b7b99' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/admin80/theme/default/templates/htmlpageFrm.tpl',
      1 => 1754187762,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68c19fe7d43734_45691366 (Smarty_Internal_Template $_smarty_tpl) {
?><form name="frmmain" action="?m=htmlpage" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
<input type="hidden" name="filePDF" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['pdf'];?>
" />
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td colspan="2"><h2><?php echo $_smarty_tpl->tpl_vars['Html_mannagement']->value;?>
</h2></td>
    </tr>
    
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
:</td>
    <td width="100%"><input type="text" name="title" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['title'];?>
" /></td>
  </tr>
  
  
  <tr>
    <td align="right" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Content']->value;?>
 :</td>
    <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['viewFckeditor'][0], array( array('content'=>$_smarty_tpl->tpl_vars['arr']->value['content']),$_smarty_tpl ) );?>
</td>
  </tr>
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">File</td>
    <td style="padding:1px; border:1px solid #cccccc; background-color:#F8F8F8"><table width="100%" border="0" cellspacing="0" cellpadding="0">          
		  <tr>
            <td id="filePDFv">
			<?php if ($_smarty_tpl->tpl_vars['arr']->value['pdf']) {?><img src="images/_.pdf.gif" /><?php }?>			</td>
          </tr>
          <tr>
            <td><a href="#" onclick="windowUploadFile('filePDF')">Upload file</a></td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px"><?php echo $_smarty_tpl->tpl_vars['Language']->value;?>
: </td>
    <td><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getCboLanguage'][0], array( array('lang'=>$_smarty_tpl->tpl_vars['arr']->value['lang']),$_smarty_tpl ) );?>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="submit" value="Submit" class="btn btn-success btn-lg text-white" />	</td>
  </tr>  
</table>
</form><?php }
}
