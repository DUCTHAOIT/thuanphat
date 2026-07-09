<?php
/* Smarty version 3.1.36, created on 2025-08-28 15:46:03
  from '/www/wwwroot/thuanphatitc.vn/theme/default/templates/testimonials.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_68b0174b9b1819_83298984',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd2e0ccc06421a86ef6afb3e98d709af6d633b359' => 
    array (
      0 => '/www/wwwroot/thuanphatitc.vn/theme/default/templates/testimonials.tpl',
      1 => 1754188629,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68b0174b9b1819_83298984 (Smarty_Internal_Template $_smarty_tpl) {
?>

<style>

	.intro-giangvien {
		line-height: 24px;
		margin-bottom: 20px;
		height:400px;
		background: url(../theme/default/images/hlvinfo.png);
	    background-repeat: no-repeat;
	    background-size: 100% 400px;
	    color:#FFFFFF;
		padding:10px;
		padding-right:35px;
		text-align:justify;
	}
	.intro-giangvien-mb {
		 color:#FFFFFF;
		 background-color:#0a9e7e;
		 border-radius: 10px;
		 padding:10px;
		 text-align:center;
		 left: 0;
		 right: 0;
		 margin:15px;
		 margin-top: -20px;
		 position:absolute;
		 height:200px;
		 
	}
	.infoleader-item {
		border-radius: 10px;
		display: block;
		overflow: hidden;
		margin-top: 0;
		margin-right: 0;
		position: relative;
	}
	.img-thumb-giangvien {
	  overflow: hidden;
	  border-radius:50%;
	  height: 100px;
	  width:100px; 
	  
	}
	.img-thumb-giangvien img {		
		transition: .4s all !important;
		height: 100px;
		width:100px;
		margin:5px
		object-fit: cover;
	}
	.img-thumb-giangvien img:hover {
	  transform: scale(1.04);
	}
	.img-thumb-giangvien-act {
		border:2px solid #2fd7b3;
	}
	.combo-line-hlv {
		height: 2px;
		width: 60px;
		background-color: #2fd7b3;
		margin-top: 15px;
		margin-bottom:15px;
		text-align:left;
	}
	@media (max-width: 768px) {
	  .img-thumb-giangvien {
		  overflow: hidden;
		  border-radius:50%;
		  height: 60px;
		  width:60px; 
		  
		}
	  .img-thumb-giangvien img {
		  height: 60px;
	  }
	  #listthumb {
	  	 margin-top:180px;
	  }
	}
	.test-summary-sortlist{
		height: 50px;
		overflow: hidden;
	}
</style>
<?php echo '<script'; ?>
 type="text/javascript">
    $(function(){
        $(document).on('click','.lessbutton-list:hidden,.lessbutton-list:visible',function(){
            $(this).parent(".readmore-list").prev(".summary-test").addClass('test-summary-sortlist').removeClass('test-summary-full');
            $(this).parent(".readmore-list").html('<a class="morebutton-list" href="javascript:void(0)">Read more <i class="fa fa-angle-double-down fa-lg"></i></a>');
        });
        $(document).on('click','.morebutton-list:hidden,.morebutton-list:visible',function(){
            $(this).parent(".readmore-list").prev(".summary-test").addClass('test-summary-full').removeClass('test-summary-sortlist');
            $(this).parent(".readmore-list").html('<a class="lessbutton-list" href="javascript:void(0)">Read less <i class="fa fa-angle-double-up fa-lg"></i></a>');
        });
    });
<?php echo '</script'; ?>
>


<?php echo '<script'; ?>
 type="text/javascript">
    $(function(){
        $('#testimonials-rotate').carousel({interval:12000});
        $(document).on('click','.morebutton:hidden,.morebutton:visible',function(){$(".testimonials blockquote").addClass('fullreview').removeClass('shortreview');$(".readmore .text-info").html('<a class="lessbutton" href="javascript:void(0)">Read less <i class="fa fa-angle-double-up fa-lg"></i></a>')})
        $(document).on('click','.lessbutton:hidden,.lessbutton:visible',function(){$(".testimonials blockquote").addClass('shortreview').removeClass('fullreview');$(".readmore .text-info").html('<a class="morebutton" href="javascript:void(0)">Read more <i class="fa fa-angle-double-down fa-lg"></i></a>')});
    });
<?php echo '</script'; ?>
>   

<div class="container-fluid testimonial" style="background-color:#0c7962; padding:0px; padding-bottom: 40px">

<div class="container" style="padding-top:30px; padding-bottom:30px">
<div class="text-center" style="padding-bottom:10px"><h2 class="topic" ><a href="#"  style="color:#FFFFFF">Ý kiến khách hàng</a></h2></div>
<div class="row">

<?php $_smarty_tpl->_assignInScope('i', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>
    <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
    <div class="col-xl-4 col-lg-4">
        <div class="intro-giangvien nonemb">
        	<a class="infoleader-item infoleader-item-blur link-view-giangvien" data-name="" data-intro="" data-class="" data-title="" data-img="" href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/worldwide/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" style="color:#FFFFFF">
            <div id="lop" class="infoleader-item-note infoleader-item-note1"></div>
            <h3 class="infoleader-name color-white title" style="text-transform:uppercase;">
            <div id="name-giangvien" data-name="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" data-img="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/worldwide/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" data-class="" data-title="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</div>
            </h3>
            <div class="infoleader-intro" id="titlegiangvien"><?php echo $_smarty_tpl->tpl_vars['item']->value['address'];?>
</div>
            <div class="combo-line-hlv"></div>
            <div class="infoleader-intro" id="introgiangvien"><?php echo $_smarty_tpl->tpl_vars['item']->value['des'];?>
</div>
            </a>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4">
        <div class="item-recruit">
            <div class="avarta_hlv">
            <a class="infoleader-item infoleader-item-blur link-view-giangvien" data-name="" data-intro="" data-class="" data-title="" data-img="" href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/worldwide/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
">
            <img id="imggiangvien" src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/worldwide/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" alt="" class="hvr-grow"  width="100%">
            
            </a>
            </div>
            
            <div class="intro-giangvien-mb nonepc">
                <a class="infoleader-item infoleader-item-blur link-view-giangvien" data-name="" data-intro="" data-class="" data-title="" data-img="" href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/worldwide/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" style="color:#FFFFFF">
                <h3 class="infoleader-name color-white title" style="text-transform:uppercase;">
                <div id="name-giangvien-mb" data-name="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" data-img="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/worldwide/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" data-class="" data-title="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
">1<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</div>
                </h3>
                <div class="infoleader-intro" id="introgiangvien-mb"><?php echo $_smarty_tpl->tpl_vars['item']->value['des'];?>
</div>
                </a>
            </div>
        
        </div>
    </div>
    <?php }
$_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>


<div class="col-xl-4 col-lg-4" style="padding-top:20px; padding-bottom:10px">
<div id="listthumb" class="pos-re">
<div class="swiper-container swiper-container-giangvien swiper-container-horizontal swiper-container-multirow swiper-container-android" id="slhome-324">
<div class="swiper-wrapper" style="width: 917px; transform: translate3d(-458px, 0px, 0px); transition-duration: 0ms;">



<?php $_smarty_tpl->_assignInScope('i', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>


<div class="swiper-slide" style="padding-bottom:20px;">
<div class="item-giangvien item-giangvien-home item-hvr">
<div class="img-thumb-giangvien"><a href="javascript:void(0)" data-link="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['htaccess'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" data-title="<?php echo $_smarty_tpl->tpl_vars['item']->value['address'];?>
" data-intro="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['strstrimhlv'][0], array( array('str'=>$_smarty_tpl->tpl_vars['item']->value['des']),$_smarty_tpl ) );?>
" data-class="" data-img="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/worldwide/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
"><img style="display:block; width:100%" class="" src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/img/worldwide/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
"  width="100%"></a></div>
</div>
</div>
<?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
if ($_smarty_tpl->tpl_vars['i']->value == 2) {
$_smarty_tpl->_assignInScope('i', 0);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
</div>
</div>

</div>


<!--
<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
<a href="#" class="btn-sl-khoahoc btn-sl-next-khoahoc btn-sl-giangvien btn-sl-next-giangvien-324 swiper-button-disabled" tabindex="0" role="button" aria-label="Next slide" aria-disabled="true"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
<a href="#" class="btn-sl-khoahoc btn-sl-prev-khoahoc btn-sl-giangvien btn-sl-prev-giangvien-324" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="false"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
-->
</div>
</div>
</div>
</div>
</div>


<?php echo '<script'; ?>
 type="text/javascript">
				  var swiper = new Swiper('#slhome-324', {
				  spaceBetween: 10,
				  slidesPerView: 3,
				  slidesPerColumn: 3,
				  loop:false,
				  navigation: {
					nextEl: '.btn-sl-next-giangvien-324',
					prevEl: '.btn-sl-prev-giangvien-324',
				  },
				  autoplay: {
					delay: 3000,
				  },
				  spaceBetween: 30,
				  breakpoints: {
					320: {
					  slidesPerView: 5,
					  spaceBetween: 20,
					  autoplay: {
						delay: 3000,
					  },
					},
			
					579: {
					  slidesPerView: 5,
					  slidesPerColumn: 1,
					  spaceBetween: 10,
					  autoplay: {
						delay: 3000,
					  },
					},
			
					768: {
					  slidesPerView: 5,
					  slidesPerColumn: 1,
					  spaceBetween: 10,
					  autoplay: {
						delay: 3000,
					  },
					},
					992: {
					  slidesPerView: 4,
					  spaceBetween: 10,
					  slidesPerColumn: 1,
					  slidesPerColumnFill: 'row',
					  spaceBetween: 10
					},
					1200: {
					  slidesPerView: 3,
					  slidesPerColumn: 3,
					  slidesPerColumnFill: 'row',
					  spaceBetween: 10
					},
					1300: {
					  slidesPerView: 3,
					  spaceBetween: 10,
                      slidesPerColumn: 3,
					  slidesPerColumnFill: 'row',
					  
					}
				  }
			});
		<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
 
 $( ".item-giangvien a" ).click(function() {
		$("#name-giangvien").html($(this).attr("data-name"));
		$("#imggiangvien").attr("src",($(this).attr("data-img")));
		$("#introgiangvien").html($(this).attr("data-intro"));
		$("#titlegiangvien").html($(this).attr("data-title"));
		
		$("#name-giangvien-mb").html($(this).attr("data-name"));
		$("#imggiangvien-mb").attr("src",($(this).attr("data-img")));
		$("#introgiangvien-mb").html($(this).attr("data-intro"));
		$("#titlegiangvien-mb").html($(this).attr("data-title"));
		
		$("#lop").html($(this).attr("data-class"));
		$(".link-view-giangvien").attr("href",($(this).attr("data-link")));
		
		
 });
 $( ".img-thumb-giangvien" ).click(function() {
	 $(".img-thumb-giangvien").removeClass("img-thumb-giangvien-act");
	 $(this).addClass("img-thumb-giangvien-act");
 });
 
 $(document).ready(function() {
	 $("#name-giangvien").html($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-name"));
	 //$("#listthumb").children(':first').find(".img-thumb-giangvien").addClass("img-thumb-giangvien-act");
	 //$("#name-giangvien").attr("href",($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-link")));
	 $("#imggiangvien").attr("src",($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-img")));
	 $("#introgiangvien").html($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-intro-full"));
	 $("#lop").html($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-class"));
	 $(".link-view-giangvien").attr("href",($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-link")));
	 
	 
	 $("#name-giangvien-mb").html($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-name"));
	 $("#imggiangvien-mb").attr("src",($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-img")));
	 $("#introgiangvien-mb").html($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-intro-full"));
	 $("#lop-mb").html($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-class"));
	 $(".link-view-giangvien-mb").attr("href",($("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-link")));
	 
 });

<?php echo '</script'; ?>
>

<?php }
}
