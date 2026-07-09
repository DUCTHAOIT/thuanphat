<?php
/* Smarty version 3.1.36, created on 2025-08-28 16:48:49
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/product_detail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b02601c47432_45934576',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f25913b5e087cdcb5c444f36514cca13deb49b0e' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/product_detail.tpl',
      1 => 1756205722,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b02601c47432_45934576 (Smarty_Internal_Template $_smarty_tpl) {
?>

    <link rel="stylesheet" href="../../js/flexslider/css/flexslider.css" type="text/css" media="screen" />
    <link rel='stylesheet' id='willgroup-fancybox-css'  href='https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css?ver=5.3.11' type='text/css' media='all' />
    <?php echo '<script'; ?>
 type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js?ver=5.3.11'><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"><?php echo '</script'; ?>
>
    <link href="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css"
          rel="stylesheet" type="text/css" />
    <!--Rating-->
    <style>
        .rate-bag{background-color: aliceblue;}
        .comment-wrapper .media-list .media img {
            width:64px;
            height:64px;
            border:2px solid #e5e7e8;
        }

        .comment-wrapper .media-list .media {
            border-bottom:1px dashed #efefef;
            padding-bottom:15px;
        }
        .comment-wrapper ul{padding-left: 0px;}
        .comment-wrapper .media-body{padding-left: 10px;}
        .comment{
            padding-top: 15px;
        }
        /*Rating*/
        .starrating > input {display: none;}  /* Remove radio buttons */

        .starrating > label:before {
            margin: 2px;
            font-size: 1em;
            display: inline-block;
        }

        .starrating > label
        {
            color: #222222; /* Start color when not clicked */
        }

        .starrating > input:checked ~ label
        { color: #ffca08 ; } /* Set yellow color when star checked */

        .starrating > input:hover ~ label
        { color: #ffca08 ;  } /* Set yellow color when star hover */
        .risingstar{width: 120px; margin-top:5px}

    </style>


<div class="container" style="padding:10px" >
    <div class="namefun text-center"><?php echo $_smarty_tpl->tpl_vars['nameFun']->value;?>
</div>
</div>

<div class="container">
    <div class="col-xs-12 col-sm-7 col-md-7" style="padding:5px; padding-top:0px;">
        <div id="slider" class="flexslider">
            <!-- slides -->
            <ul class="slides">
                <?php if ($_smarty_tpl->tpl_vars['arrColor']->value) {?>
                    <?php $_smarty_tpl->_assignInScope('i', 1);?>
                    <li>
                        <a class="text-white text-center d-block position-relative" data-fancybox="all-photos" data-caption="" href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" data-thumb-type="image">
                            <img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
">
                        </a>


                    </li>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrColor']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
                        <li>
                            <a class="text-white text-center d-block position-relative" data-fancybox="all-photos" data-caption="" href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" data-thumb-type="image">
                                <img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
">
                            </a>


                        </li>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);?>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <?php } else { ?>
                    <li>
                        <a class="text-white text-center d-block position-relative" data-fancybox="all-photos" data-caption="" href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" data-thumb-type="image">
                            <img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
">
                        </a>
                    </li>
                <?php }?>
            </ul>
        </div>
        <div id="carousel" class="flexslider">
            <ul class="slides">
                <?php if ($_smarty_tpl->tpl_vars['arrColor']->value) {?>
                    <?php $_smarty_tpl->_assignInScope('i', 1);?>
                    <li>
                        <a id="carousel-selector-0" class="selected" data-slide-to="0" data-target="#custCarousel">
                            <img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/image.php?width=300px&image=<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['arr']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" class="img-fluid w-100" style="max-height:220px">
                        </a>
                    </li>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrColor']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
                        <li>
                            <a id="carousel-selector-<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" data-target="#custCarousel">
                                <img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/image.php?width=300px&image=<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
" class="img-fluid w-100" style="max-height:220px">
                            </a>
                        </li>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);?>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                <?php } else { ?>

                <?php }?>
            </ul>
        </div>
        <div class="accordion">
            <div class="item active">
                <div class="item__header flex-lc">
                    <h5>Thông tin chi tiết</h5>
                    <button type="button"></button>
                </div>
                <div class="item__content">
                    <?php echo $_smarty_tpl->tpl_vars['arr']->value['content'];?>

                </div>
            </div>
            <div class="item">
                <div class="item__header flex-lc">
                    <h5>Chính Sách Affiliate – Tiếp thị liên kết</h5>
                    <button type="button"></button>
                </div>
                <div class="item__content">
                    <?php echo $_smarty_tpl->tpl_vars['arr']->value['tienich'];?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5">
            <div  class="room-sidebar">
                <form name="frmBooking" action="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/view_basket/" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="m" value="basket" />
                    <input type="hidden" name="op" value="view_basket" />
                    <input type="hidden" name="product_id" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['id'];?>
" />
                    <input type="hidden" name="qty"  value="1"  />

                    <div style="border-bottom:1px solid #ebebeb; text-align:justify; padding-top:5px; padding-bottom:5px"><h1 class="title" style="text-align:left; font-size:22px"><?php echo $_smarty_tpl->tpl_vars['arr']->value['name'];?>
</h1></div>
                    <div><?php echo $_smarty_tpl->tpl_vars['arr']->value['summary'];?>
</div>
                    <div>
                        <p class="font-weight-bold" style="font-size:1.5rem">
                            Giá:
                            <?php if ($_smarty_tpl->tpl_vars['arr']->value['price'] > 0) {?>
                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['arr']->value['price']),$_smarty_tpl ) );?>

                            <?php } else { ?>
                                Contact
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['arr']->value['price_old'] > 0) {?>
                                <font align="center" style="padding:5px; color:#999999; text-decoration:line-through;" class="content"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['arr']->value['price_old']),$_smarty_tpl ) );?>
</font>
                            <?php }?>
                        </p>
                    </div>
                    <div style="padding-bottom:30px">
                        <p  style="font-size:11px;">
                            <?php $_smarty_tpl->_assignInScope(((string)$_smarty_tpl->tpl_vars['max']->value), $_smarty_tpl->tpl_vars['average_rating']->value);?>
                            <?php
$_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int) ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? $_smarty_tpl->tpl_vars['average_rating']->value+1 - (1) : 1-($_smarty_tpl->tpl_vars['average_rating']->value)+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0) {
for ($_smarty_tpl->tpl_vars['foo']->value = 1, $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++) {
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration === 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration === $_smarty_tpl->tpl_vars['foo']->total;?>
                                <span class="fa fa-star star-yellow"></span>
                            <?php }
}
?>
                            <?php
$_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int) ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? 3+1 - ($_smarty_tpl->tpl_vars['average_rating']->value) : $_smarty_tpl->tpl_vars['average_rating']->value-(3)+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0) {
for ($_smarty_tpl->tpl_vars['foo']->value = $_smarty_tpl->tpl_vars['average_rating']->value, $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++) {
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration === 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration === $_smarty_tpl->tpl_vars['foo']->total;?>
                                <span class="fa fa-star"></span>
                            <?php }
}
?>
                            (<?php echo $_smarty_tpl->tpl_vars['total_review']->value;?>
)
                        </p>
                    </div>

                    <button class="wt-btn wt-btn--outline wt-width-full" type="submit" data-skip-bin-overlay="true" onClick="javascript:checkSendMail(document.frmBooking)">
                        Mua ngay
                    </button>

                    <div class="wt-width-full" data-add-to-cart-button="" data-selector="add-to-cart-button" style="margin-top:10px" onClick="javascript:checkSendMail(document.frmBooking)">
                        <div class="wt-btn wt-btn--filled wt-width-full">
                            <span>  Thêm vào giỏ hàng </span>
                        </div>
                    </div>



                </form>
                <div style="padding:10px;" id="formcomment">
                    <div>
                        <h1 class="title" style="text-align:left; font-size:22px">Đánh giá</h1>
                    </div>
                    <form id="frmCommenPost" action="#" method="post">
                        <div class="row">
                            <div class="col-md-12 col-12 padding-bottom-5">
                                <input type="hidden" id="inputid" name="id" value="<?php echo $_smarty_tpl->tpl_vars['arr']->value['id'];?>
">
                                <input type="hidden" id="inputuserid" name="user_id" value="<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
">
                                <input type="text" id="commentName" name="name" value="<?php echo $_smarty_tpl->tpl_vars['MemberName']->value;?>
" class="form-control" placeholder="Họ và tên" data-container="body" data-toggle="popover" data-placement="top" data-content="Full name" />
                            </div>
                            <div class="col-md-12 col-12">
                                <textarea class="form-control" id="commentContent" name="comment" placeholder="Ý kiến" rows="3" data-container="body" data-toggle="popover" data-placement="top" data-content="Comment"></textarea>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="starrating risingstar d-flex justify-content-center flex-row-reverse" data-container="body" data-toggle="popover" data-placement="top" data-content="" id="starVin">
                                    <input type="radio" class="get_value" id="star5" name="rating" value="5" /><label class="fa fa-star" for="star5" title="5 star"></label>
                                    <input type="radio" class="get_value" id="star4" name="rating" value="4" /><label class="fa fa-star" for="star4" title="4 star"></label>
                                    <input type="radio" class="get_value" id="star3" name="rating" value="3" /><label class="fa fa-star" for="star3" title="3 star"></label>
                                    <input type="radio" class="get_value" id="star2" name="rating" value="2" /><label class="fa fa-star" for="star2" title="2 star"></label>
                                    <input type="radio" class="get_value" id="star1" name="rating" value="1" /><label class="fa fa-star" for="star1" title="1 star"></label>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <button type="button" id="btnPostComment" class="btn btn-success">Đánh giá</button>
                                <div class="text-center" style="display: none; text-align:center; position:absolute; right:15%; top:10px" id="loading_image">
                                    <img src="//s.svgbox.net/loaders.svg?fill=maroon&ic=tail-spin"
                                         style="width:20px">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div>

                    <div class="comment-wrapper">

                        <ul class="media-list">
                            <b>Các đánh giá của khách hàng</b>
                            <?php $_smarty_tpl->_assignInScope('k', 0);?>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arrreview']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
                                <li class="media">
                                    <a href="#" class="float-left">
                                        <img src="/images/avatar.png" alt="" class="rounded-circle">
                                    </a>
                                    <div class="media-body">
                        <span class="text-muted float-right"  style="font-size:13px; color:#666666">
                            <small class="text-muted"><?php echo $_smarty_tpl->tpl_vars['item']->value['created_date'];?>
</small>
                        </span>
                                        <strong class="text-success"><?php echo $_smarty_tpl->tpl_vars['item']->value['people_name'];?>
</strong>
                                        <p  style="font-size:11px;">
                                            <?php $_smarty_tpl->_assignInScope(((string)$_smarty_tpl->tpl_vars['max']->value), $_smarty_tpl->tpl_vars['item']->value['star']);?>
                                            <?php
$_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int) ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? $_smarty_tpl->tpl_vars['item']->value['star']+1 - (1) : 1-($_smarty_tpl->tpl_vars['item']->value['star'])+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0) {
for ($_smarty_tpl->tpl_vars['foo']->value = 1, $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++) {
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration === 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration === $_smarty_tpl->tpl_vars['foo']->total;?>
                                                <span class="fa fa-star star-yellow"></span>
                                            <?php }
}
?>
                                            <?php
$_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int) ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? 4+1 - ($_smarty_tpl->tpl_vars['item']->value['star']) : $_smarty_tpl->tpl_vars['item']->value['star']-(4)+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0) {
for ($_smarty_tpl->tpl_vars['foo']->value = $_smarty_tpl->tpl_vars['item']->value['star'], $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++) {
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration === 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration === $_smarty_tpl->tpl_vars['foo']->total;?>
                                                <span class="fa fa-star"></span>
                                            <?php }
}
?>
                                        </p>
                                        <p><?php echo $_smarty_tpl->tpl_vars['item']->value['content'];?>
</p>
                                    </div>
                                </li>
                                <?php $_smarty_tpl->_assignInScope('k', $_smarty_tpl->tpl_vars['k']->value+1);?>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- comment-->






        </div>
</div>
<div class="container">
    <div class="topic">Sản phẩm khác</div>
    <div><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['productRelation'][0], array( array(),$_smarty_tpl ) );?>
</div>
</div>
<div id="dialog" style="display: none">
    Sản phẩm đã được thêm vào giỏ hàng
</div>

    <?php echo '<script'; ?>
>
        $(document).ready(function(){
            $( "#btnPostComment" ).click(function() {

                var id = $('#inputid').val();
                var name = $('#commentName').val();
                var comment = $('#commentContent').val();
                var user_id = $('#inputuserid').val();
                var rating = jQuery('#starVin .get_value:checked').val();

                if(name.trim() == '' ){
                    alert('Full name!');
                    $('#commentName').focus();
                    return false;
                }else if(comment.trim() == '' ){
                    alert('Comment!');
                    $('#commentContent').focus();
                    return false;
                }else{
                    $( "#btnPostComment").attr("disabled", "disabled");
                    $("#loading_image").show();
                    url="../../?m=product&f=reviews&name="+ name +"&comment="+ comment +"&rating="+ rating +"&user_id="+ user_id +"&id="+ id;
                    AjaxRequest.get(
                        {
                            'url':url
                            ,'onSuccess':function(req){
                                document.getElementById('formcomment').innerHTML=req.responseText;
                                $("#loading_image").hiden();
                            }
                            ,'onError':function(req){}
                        }
                    )
                }
            });
        })
    <?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 language="javascript">

        /*Accordion*/
        $(document).ready(function () {
            var $accordion = $('.accordion');

            // Ẩn tất cả trừ phần đang active
            $accordion.find('.item__content').hide();
            $accordion.find('.item.active .item__content').show();

            $accordion.on('click', '.item__header', function () {
                var $item = $(this).closest('.item');
                var $content = $item.find('.item__content');

                if ($item.hasClass('active')) {
                    $content.slideUp();
                    $item.removeClass('active');
                } else {
                    $accordion.find('.item').removeClass('active');
                    $accordion.find('.item__content').slideUp();

                    $item.addClass('active');
                    $content.slideDown();
                }
            });
        });

        //
        function checkSendMail(f){
            var obj;
            obj=document.frmBooking;

            //alert(obj.product_id.value);
            url="/add_basket/&product_id="+ obj.product_id.value +"&qty="+ obj.qty.value +"/";
            AjaxRequest.get(
                {
                    'url':url
                    //,'onSuccess':function(req){document.getElementById('addToShoppingCart').innerHTML=req.responseText;  $("#simpleModal").modal('show');}
                    ,'onSuccess':function(req){
                        document.getElementById('div_view_basket').innerHTML=req.responseText;

                        $("#dialog").dialog({
                            modal: true,
                            title: "Thông báo",
                            width: 330,
                            height: 150,
                            open: function (event, ui) {
                                setTimeout(function () {
                                    $("#dialog").dialog("close");
                                }, 2000);
                            }
                        });



                    }
                    ,'onError':function(req){}
                }
            )

        }

        function checkBooking(f){
            var obj;
            obj=document.frmBooking;
            if(obj.color.value==""){
                alert("Xin chọn màu sắc");
                obj.color.focus();
                return;
            }else{
                obj.submit();
            }
        }
        //
        //product_and_manufacturers();
        //product_in_technical();

    <?php echo '</script'; ?>
>
    <!-- jQuery -->

    <!-- FlexSlider -->
    <?php echo '<script'; ?>
 defer src="../../js/flexslider/js/jquery.flexslider.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 type="text/javascript">
        // $(function(){
        //   SyntaxHighlighter.all();
        // });
        $(window).load(function(){
            $('#carousel').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 210,
                itemMargin: 5,
                asNavFor: '#slider'
            });

            $('#slider').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                sync: "#carousel",
                start: function(slider){
                    $('body').removeClass('loading');
                }
            });
        });
    <?php echo '</script'; ?>
>

<?php }
}
