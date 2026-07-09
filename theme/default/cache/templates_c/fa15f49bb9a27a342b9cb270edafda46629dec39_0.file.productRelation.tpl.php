<?php
/* Smarty version 3.1.36, created on 2025-08-28 16:48:49
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/productRelation.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b02601cbd207_64668568',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa15f49bb9a27a342b9cb270edafda46629dec39' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/productRelation.tpl',
      1 => 1754188626,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b02601cbd207_64668568 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="row" style="padding:10px; text-align:center">
    <?php $_smarty_tpl->_assignInScope('k', "0");?>
    <?php
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['arr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_start = (int)@$_smarty_tpl->tpl_vars['pageID']->value < 0 ? max(0, (int)@$_smarty_tpl->tpl_vars['pageID']->value + $__section_i_0_loop) : min((int)@$_smarty_tpl->tpl_vars['pageID']->value, $__section_i_0_loop);
$__section_i_0_total = min(($__section_i_0_loop - $__section_i_0_start), (int)@$_smarty_tpl->tpl_vars['limit']->value < 0 ? $__section_i_0_loop : (int)@$_smarty_tpl->tpl_vars['limit']->value);
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total !== 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = $__section_i_0_start; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
        <?php if ($_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['id'] <> $_smarty_tpl->tpl_vars['idPro']->value) {?>
            <div class="col-xs-6 col-sm-4 col-md-3" style="padding-bottom:20px;">
                <div class="item-recruit">
                    <div class="avarta">
                        <a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['url'];
echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['alias'];?>
"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['img'];?>
"  border="0" alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
" title="Chi tiết" hspace="0" vspace="0"  class="image" width="100%"/></a>
                    </div>
                    <div>
                        <h3 class="content" align="left">
                            <a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['url'];
echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['alias'];?>
"><?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
</a>
                        </h3>
                        <p class="font-weight-bold"><span class="font-weight-bold">
                            <?php if ($_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['price'] > 0) {?>
                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['price']),$_smarty_tpl ) );?>

                            <?php } else { ?>
                                Liên hệ
                            <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['price_old'] > 0) {?>
                                    <font align="center" style="padding:5px;    color:#999999; text-decoration:line-through;" class="content"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['price_old']),$_smarty_tpl ) );?>
</font>
                                <?php }?>
         </span></p>

                    </div>
                </div>
            </div>
            <?php $_smarty_tpl->_assignInScope('k', $_smarty_tpl->tpl_vars['k']->value+1);?>
        <?php }?>
    <?php
}
}
?>
</div><?php }
}
