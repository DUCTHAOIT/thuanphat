<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:34:40
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/doitac2.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b014a0951360_23598790',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b33cca1d588a8671540381cbebcff883464ee0b8' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/doitac2.tpl',
      1 => 1754188615,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b014a0951360_23598790 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript" src="../../js/jssor/jssor.slider.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../../js/jssor/slide.js"><?php echo '</script'; ?>
>


<!-- Jssor Slider Begin -->
<div id="slider1_container" class="slider1 home-slide-partner-container" style="padding-bottom:80px">

    <!-- Loading Screen -->
    <div u="loading" style="position: absolute; top: 0px; left: 0px;">
        <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                        background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
        </div>
        <div style="position: absolute; display: block; background: url(http://jquery/jssor.slider.freeTrial/img/loading.gif) no-repeat center center;
                        top: 0px; left: 0px;width: 100%;height:100%;">
        </div>
    </div>

    <!-- Slides Container -->
    <div u="slides" class="home-slide-partner-pieces" style="position: absolute; left: 15px; right:15px; width: 100%; height: 100px; overflow: hidden;">
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
             <div style="height:auto; width:150px">
                <a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['htaccess'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/advertise/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" style="width:110px; height:60px"  u="image"  border="0" vspace="0"  hspace="0" /></a>
            </div>
       <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>	       
      
    </div>

    <!-- Navigator Skin Begin -->
    
    <style>
        .slider1-N div, .slider1-N div:hover, .slider1-N div.av
        {
            background: url(http://jquery/jssor.slider.freeTrialimg/sprite-03.png) no-repeat;
            overflow:hidden;
            cursor: pointer;
        }
        .slider1-N div { background-position: 0px -240px; }
        .slider1-N div:hover, .slider1-N div.av:hover, .slider1-N div.hv { background-position: -30px -240px; }
        .slider1-N div.av { background-position: -60px -240px; }
        .slider1-N div.dn { background-position: -90px -240px; }
   
        .slider1 .al, .slider1 .ar, .slider1 .aldn, .slider1 .ardn, .slider1 .alhv, .slider1 .arhv
        {
            position: absolute;
            cursor: pointer;
            display: block;
            background: url(../../js/jssor/Sprite-03.png) no-repeat;
            overflow:hidden;
        }
        .slider1 .al { background-position: 0px -60px; }
        .slider1 .ar { background-position: -60px -60px; }
        .slider1 .al:hover, .slider1 .alhv { background-position: 0px 0px; }
        .slider1 .ar:hover, .slider1 .arhv { background-position: -60px 0px; }
        .slider1 .aldn { background-position: -120px -60px; }
        .slider1 .ardn { background-position: -180px -60px; }
    </style>
	<?php echo '<script'; ?>
>
        jssor_slider1_starter('slider1_container');
    <?php echo '</script'; ?>
>
    
</div>
<!-- Jssor Slider End --><?php }
}
