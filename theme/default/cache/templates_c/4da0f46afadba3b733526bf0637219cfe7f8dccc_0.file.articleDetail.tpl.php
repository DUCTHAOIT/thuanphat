<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:53:22
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/articleDetail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b0190270d682_48950292',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4da0f46afadba3b733526bf0637219cfe7f8dccc' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/articleDetail.tpl',
      1 => 1754188609,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b0190270d682_48950292 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="container">
	<div class="namefun text-center"><?php echo $_smarty_tpl->tpl_vars['nameFun']->value;?>
</div>
	<div class="text-center">
        <h1 class="topiccontent"><?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
</h1>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['arr']->value['summary']) {?><div class="title"><?php echo $_smarty_tpl->tpl_vars['arr']->value['summary'];?>
</div><?php }?>
    <div class="content"><?php echo $_smarty_tpl->tpl_vars['arr']->value['content'];?>
</div> 
    <div class="clr"></div>
     <div class="topiccontent"><h1><?php if ($_smarty_tpl->tpl_vars['lang']->value == 'vn') {?>Tin liên quan<?php } else { ?>Related news<?php }?></h1></div>
    <div>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrrelation']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
    <?php if ($_smarty_tpl->tpl_vars['item']->value['id'] <> $_smarty_tpl->tpl_vars['arr']->value['id']) {?>  
   		<div class="row" style="border-bottom:1px dotted #CCCCCC;padding:0px; padding-top:10px; padding-bottom:10px;">
            <div class="col-xs-12 col-sm-3 col-md-3">
                <a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['htaccess'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/image.php?width=400&image=<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/article/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" border="0" vspace="0"  hspace="0" width="100%"/></a>	
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9" >
                <h3><a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['htaccess'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
" class="title"  title="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></h3>
                <div class="news-day"><?php echo $_smarty_tpl->tpl_vars['item']->value['date_create'];?>
</div>
                <font class="content" style="text-align:justify; font-size:16px"><?php echo nl2br($_smarty_tpl->tpl_vars['item']->value['summary']);?>
</font>   
            </div>
        </div>           
    <?php }?>	    
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </div>
</div><?php }
}
