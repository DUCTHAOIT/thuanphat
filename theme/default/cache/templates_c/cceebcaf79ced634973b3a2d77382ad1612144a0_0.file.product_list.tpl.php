<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:45:10
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/product_list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b01716344223_97552155',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cceebcaf79ced634973b3a2d77382ad1612144a0' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/product_list.tpl',
      1 => 1754191432,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b01716344223_97552155 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('k', "0");
$_smarty_tpl->_assignInScope('i', "0");
$_smarty_tpl->_assignInScope('j', "0");
echo '<script'; ?>
 type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"><?php echo '</script'; ?>
>
<link href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css"
      rel="stylesheet" type="text/css" />
<div class="row"> 
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

    <div class="col-xs-12 col-sm-4 col-md-4" style="padding-bottom:40px;">
     	<div class="item-recruit-khoahoc ">
            <div class="avarta">
               <?php if ($_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['img']) {?>
                	 <a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['url'];
echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['alias'];?>
" class="aff">
                    <img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/image.php?width=1000&image=images/product/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['img'];?>
" class="img-fluid w-100" alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
">
                </a>
               <?php }?> 
            </div>
            <div class="info">
                <h3 style="margin-top:10px; margin-bottom:5px"><a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['url'];
echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['alias'];?>
" class="title aff"  title="<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
" ><?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
</a></h3>
                                <p class="font-weight-bold">
                    <?php if ($_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['price']) {?>
                        Giá: <strong class="h5 font-weight-bold mb-0" style="color:#FF6600"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['price']),$_smarty_tpl ) );?>
</strong> <del><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['price_old']),$_smarty_tpl ) );?>
</del>

                     <?php } else { ?>
                            Liên hệ
                     <?php }?>
         
         </p>

            </div>
            <div>
            	<div class="col-xs-6 col-sm-6 col-md-6" style="padding-bottom:10px; padding-top:10px; border-top:0.5px solid #CCCCCC; padding-left:0px; font-size:0.9rem; line-height:24px">
                    <button class="btn_viewmore3 btn-block" data-id="<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['id'];?>
" tabindex="-1">Thêm vào giỏ hàng</button>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6" style="padding-bottom:10px; padding-top:10px; border-top:0.5px solid #CCCCCC; padding-right:0px; float: right; text-align: right">
                	<a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['url'];
echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['alias'];?>
" class="aff"><button class="btn_viewmore2" tabindex="-1">Chi tiết<i class="fas fa-arrow-right ml-2"></i></button></a>
                   

                </div>
            </div>
        </div>
              
     </div> 

<?php $_smarty_tpl->_assignInScope('i', ((string)$_smarty_tpl->tpl_vars['i']->value)."+1");
$_smarty_tpl->_assignInScope('k', ((string)$_smarty_tpl->tpl_vars['k']->value)."+1");
}
}
?>
</div>    

<div style="text-align:center; padding:20px;"><?php echo $_smarty_tpl->tpl_vars['sPage']->value;?>
</div>

<div id="dialog" style="display: none">
    Sản phẩm đã được thêm vào giỏ hàng
</div>


    <?php echo '<script'; ?>
>
        $(document).ready(function(){
            $('.btn-block').click(function(e){
                e.preventDefault(); // Ngăn form hoặc thẻ a gây reload

                var id = $(this).data('id');
                console.log("Đã click, product_id =", id); // Kiểm tra id có lấy được không

                $.ajax({
                    url: '../../?m=basket&op=add_basket',
                    type: 'post',
                    data: { product_id: id },
                    success: function(response){
                        console.log("Phản hồi từ server:", response);

                        // Hiển thị thông tin trả về
                        $('#div_view_basket').html(response);

                        // Hiển thị hộp thoại
                        $("#dialog").dialog({
                            modal: true,
                            title: "Thông báo",
                            width: 350,
                            height: 150,
                            open: function (event, ui) {
                                setTimeout(function () {
                                    $("#dialog").dialog("close");
                                }, 2000);
                            }
                        });
                    },
                    error: function(err){
                        console.error("Lỗi:", err);
                        alert("Đã xảy ra lỗi khi thêm giỏ hàng.");
                    }
                });
            });
        });
    <?php echo '</script'; ?>
>


 <?php }
}
