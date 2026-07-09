<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:40:32
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/article.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b016004b9805_72991669',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b20febf70128b56e0065e9315a7a319ce1077b6b' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/article.tpl',
      1 => 1754188609,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b016004b9805_72991669 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 language="javascript" type="text/javascript">
function callSearch(f){
	var keyword,obj;
	obj=document.frmSearch;
	keyword=obj.txtSearch.value;	
	if(keyword){		
		//obj.submit();
		searchDocument(f)
	}else obj.txtSearch.focus();	
	
}

function txtEnterKey(evt) 
{
   var e=(window.event)?event:evt;
	if(e.keyCode==13){
		document.getElementById('btnSearch').onclick();
		return false;
	}
}
//
function searchDocument(f){
	var status = AjaxRequest.submit(
		f
		,{
		  'url':'?m=article&op=search'
		  ,'onSuccess':function(req){ document.getElementById('articleList').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );
	  progress('articleList');
	  return status;
}
<?php echo '</script'; ?>
>

<div class="container">
	<div class="namefun text-center"><?php echo $_smarty_tpl->tpl_vars['nameFun']->value;?>
</div>
	<div class="text-center">
        <h1 class="topiccontent"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h1>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['des']->value) {?><div class="content" ><?php echo $_smarty_tpl->tpl_vars['des']->value;?>
</div><?php }?>
    <div class="row" ><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['articleList'][0], array( array(),$_smarty_tpl ) );?>
</div>
</div><?php }
}
