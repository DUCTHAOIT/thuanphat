{literal}

    <link rel="stylesheet" href="../../js/flexslider/css/flexslider.css" type="text/css" media="screen" />
    <link rel='stylesheet' id='willgroup-fancybox-css'  href='https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css?ver=5.3.11' type='text/css' media='all' />
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js?ver=5.3.11'></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>
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

{/literal}
<div class="container" style="padding:10px" >
    <div class="namefun text-center">{$nameFun}</div>
</div>

<div class="container">
    <div class="col-xs-12 col-sm-7 col-md-7" style="padding:5px; padding-top:0px;">
        <div id="slider" class="flexslider">
            <!-- slides -->
            <ul class="slides">
                {if $arrColor}
                    {assign var="i" value=1}
                    <li>
                        <a class="text-white text-center d-block position-relative" data-fancybox="all-photos" data-caption="" href="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr.img}" data-thumb-type="image">
                            <img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr.img}" alt="{$arr.name}">
                        </a>


                    </li>
                    {foreach item=item key=key from=$arrColor}
                        <li>
                            <a class="text-white text-center d-block position-relative" data-fancybox="all-photos" data-caption="" href="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$item.img}" data-thumb-type="image">
                                <img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$item.img}" alt="{$arr.name}">
                            </a>


                        </li>
                        {assign var="i" value=$i+1}
                    {/foreach}
                {else}
                    <li>
                        <a class="text-white text-center d-block position-relative" data-fancybox="all-photos" data-caption="" href="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr.img}" data-thumb-type="image">
                            <img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr.img}" alt="{$arr.name}">
                        </a>
                    </li>
                {/if}
            </ul>
        </div>
        <div id="carousel" class="flexslider">
            <ul class="slides">
                {if $arrColor}
                    {assign var="i" value=1}
                    <li>
                        <a id="carousel-selector-0" class="selected" data-slide-to="0" data-target="#custCarousel">
                            <img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=300px&image={$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr.img}" alt="{$arr.name}" class="img-fluid w-100" style="max-height:220px">
                        </a>
                    </li>
                    {foreach item=item key=key from=$arrColor}
                        <li>
                            <a id="carousel-selector-{$i}" data-slide-to="{$i}" data-target="#custCarousel">
                                <img src="{$smarty.const._DOMAIN_ROOT_URL}/image.php?width=300px&image={$smarty.const._DOMAIN_ROOT_URL}/images/product/{$item.img}" alt="{$arr.name}" class="img-fluid w-100" style="max-height:220px">
                            </a>
                        </li>
                        {assign var="i" value=$i+1}
                    {/foreach}
                {else}

                {/if}
            </ul>
        </div>
        <div class="accordion">
            <div class="item active">
                <div class="item__header flex-lc">
                    <h5>Thông tin chi tiết</h5>
                    <button type="button"></button>
                </div>
                <div class="item__content">
                    {$arr.content}
                </div>
            </div>
            <div class="item">
                <div class="item__header flex-lc">
                    <h5>Chính Sách Affiliate – Tiếp thị liên kết</h5>
                    <button type="button"></button>
                </div>
                <div class="item__content">
                    {$arr.tienich}
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5">
            <div  class="room-sidebar">
                <form name="frmBooking" action="{$smarty.const._DOMAIN_ROOT_URL}/view_basket/" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="m" value="basket" />
                    <input type="hidden" name="op" value="view_basket" />
                    <input type="hidden" name="product_id" value="{$arr.id}" />
                    <input type="hidden" name="qty"  value="1"  />

                    <div style="border-bottom:1px solid #ebebeb; text-align:justify; padding-top:5px; padding-bottom:5px"><h1 class="title" style="text-align:left; font-size:22px">{$arr.name}</h1></div>
                    <div>{$arr.summary}</div>
                    <div>
                        <p class="font-weight-bold" style="font-size:1.5rem">
                            Giá:
                            {if $arr.price>0}
                                {format_number number=$arr.price}
                            {else}
                                Contact
                            {/if}
                            {if $arr.price_old>0}
                                <font align="center" style="padding:5px; color:#999999; text-decoration:line-through;" class="content">{format_number number=$arr.price_old}</font>
                            {/if}
                        </p>
                    </div>
                    <div style="padding-bottom:30px">
                        <p  style="font-size:11px;">
                            {assign var="$max" value=$average_rating}
                            {for $foo=1 to $average_rating}
                                <span class="fa fa-star star-yellow"></span>
                            {/for}
                            {for $foo=$average_rating to 3}
                                <span class="fa fa-star"></span>
                            {/for}
                            ({$total_review})
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
                                <input type="hidden" id="inputid" name="id" value="{$arr.id}">
                                <input type="hidden" id="inputuserid" name="user_id" value="{$user_id}">
                                <input type="text" id="commentName" name="name" value="{$MemberName}" class="form-control" placeholder="Họ và tên" data-container="body" data-toggle="popover" data-placement="top" data-content="Full name" />
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
                            {assign var="k" value=0}
                            {foreach key=key item=item from=$arrreview}
                                <li class="media">
                                    <a href="#" class="float-left">
                                        <img src="/images/avatar.png" alt="" class="rounded-circle">
                                    </a>
                                    <div class="media-body">
                        <span class="text-muted float-right"  style="font-size:13px; color:#666666">
                            <small class="text-muted">{$item.created_date}</small>
                        </span>
                                        <strong class="text-success">{$item.people_name}</strong>
                                        <p  style="font-size:11px;">
                                            {assign var="$max" value=$item.star}
                                            {for $foo=1 to $item.star}
                                                <span class="fa fa-star star-yellow"></span>
                                            {/for}
                                            {for $foo=$item.star to 4}
                                                <span class="fa fa-star"></span>
                                            {/for}
                                        </p>
                                        <p>{$item.content}</p>
                                    </div>
                                </li>
                                {assign var="k" value=$k+1}
                            {/foreach}
                        </ul>
                    </div>
                </div>
            </div>
            <!-- comment-->






        </div>
</div>
<div class="container">
    <div class="topic">Sản phẩm khác</div>
    <div>{productRelation}</div>
</div>
<div id="dialog" style="display: none">
    Sản phẩm đã được thêm vào giỏ hàng
</div>
{literal}
    <script>
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
    </script>

    <script language="javascript">

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

    </script>
    <!-- jQuery -->

    <!-- FlexSlider -->
    <script defer src="../../js/flexslider/js/jquery.flexslider.js"></script>

    <script type="text/javascript">
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
    </script>

{/literal}