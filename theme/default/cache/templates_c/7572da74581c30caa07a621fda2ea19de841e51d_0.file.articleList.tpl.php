<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:40:32
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/articleList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b01600593a65_28012961',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7572da74581c30caa07a621fda2ea19de841e51d' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/articleList.tpl',
      1 => 1754188609,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b01600593a65_28012961 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('k', "0");
$_smarty_tpl->_assignInScope('i', "0");
$_smarty_tpl->_assignInScope('j', "0");?>
<div class="container">
<?php
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_start = (int)@$_smarty_tpl->tpl_vars['pageID']->value < 0 ? max(0, (int)@$_smarty_tpl->tpl_vars['pageID']->value + $__section_i_0_loop) : min((int)@$_smarty_tpl->tpl_vars['pageID']->value, $__section_i_0_loop);
$__section_i_0_total = min(($__section_i_0_loop - $__section_i_0_start), (int)@$_smarty_tpl->tpl_vars['limit']->value < 0 ? $__section_i_0_loop : (int)@$_smarty_tpl->tpl_vars['limit']->value);
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total !== 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = $__section_i_0_start; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
if ($_smarty_tpl->tpl_vars['k']->value == 1) {?>
    <?php $_smarty_tpl->_assignInScope('k', "0");?>

 <?php }?>	

     <div class="row article">
        <div class="col-xs-12 col-sm-4 col-md-4">
                <?php if ($_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['img']) {?>
                    <a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['htaccess'];
echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['alias'];?>
"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/image.php?width=600&image=<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/article/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['img'];?>
" class="img-fluid"  alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" border="0" vspace="0"  hspace="0" width="100%" /></a>	
                <?php }?>               
        </div>
        <div class="col-xs-12 col-sm-8 col-md-8">
               <a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['htaccess'];
echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['alias'];?>
" class="title"  title="<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
" style="font-size:18px"  ><?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
</a>
               <div class="news-day"><?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['date_create'];?>
</div>
               <font class="content" style="text-align:justify;"><?php echo nl2br($_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['summary']);?>
</font>     
        </div>       
      </div>   
      <div style="height:10px; border-top:1px dotted #3ca995; margin-top:10px"></div> 
    
<?php $_smarty_tpl->_assignInScope('i', ((string)$_smarty_tpl->tpl_vars['i']->value)."+1");
$_smarty_tpl->_assignInScope('k', ((string)$_smarty_tpl->tpl_vars['k']->value)."+1");
}
}
?>
</div>
<div class="container text-center"" style="padding-top:15px"><?php echo $_smarty_tpl->tpl_vars['sPage']->value;?>
</div><?php }
}
