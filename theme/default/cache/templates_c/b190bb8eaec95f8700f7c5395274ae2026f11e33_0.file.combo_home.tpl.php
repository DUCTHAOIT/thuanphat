<?php
/* Smarty version 3.1.36, created on 2026-07-08 08:01:45
  from 'C:\xampp\htdocs\thuanphatitc.vn\theme\default\templates\combo_home.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_6a4de7c9634519_02502215',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b190bb8eaec95f8700f7c5395274ae2026f11e33' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thuanphatitc.vn\\theme\\default\\templates\\combo_home.tpl',
      1 => 1783309163,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6a4de7c9634519_02502215 (Smarty_Internal_Template $_smarty_tpl) {
?>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/css/swiper.min.css">

	<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/js/swiper.min.js"><?php echo '</script'; ?>
>

	<style>

		.btn-sl-combo{width:52px;height:52px;position:absolute;text-align:center;line-height:50px;background-color:#fff;-webkit-border-radius:50%;border-radius:50%;font-size:24px;top:50%;margin-top:-52px;z-index:99;-webkit-box-shadow:0 0 5px 0 rgba(110,110,110,1);-moz-box-shadow:0 0 5px 0 rgba(110,110,110,1);box-shadow:0 0 5px 0 rgba(110,110,110,1);color:#484848}.btn-sl-combo:hover{color:#fff;background-color:#0b7a62}.btn-sl-next-combo{right:-30px}.btn-sl-prev-combo{left:-30px}.btn-sl-next-combo{top:50%!important}.btn-sl-prev-combo{top:50%!important}

		.pos-re-combo {

			position: relative;

		}

		@media handheld, only screen and (max-width: 570px){

			.btn-sl-prev-combo {

				left: -5px;

			}

			.btn-sl-next-combo {

				right: -5px;

			}

		}

		@media handheld, only screen and (max-width: 768px){

			.btn-sl-prev-combo {

				left: -10px;

			}

			.btn-sl-next-combo {

				right: -10px;

			}

		}

		@media handheld, only screen and (max-width: 768px){

			.btn-sl-combo {

				width: 34px;

				height: 34px;

				line-height: 32px;

			}

		}

		@media handheld, only screen and (max-width: 992px){

			.btn-sl-combo {

				margin-top: -34px;

			}

		}

	</style>



<section class="text-center">

	<div class="topic">

		<h2 class="topic">Sản phẩm nổi bật</h2>



	</div>

	<div class="content"  style="padding-bottom:30px">Chúng tôi luôn hướng đến sản phẩm chất lượng và an toàn sức khỏe cho người dùng bằng nguồn gốc tự nhiên. Mang đến cho mọi người những món quà lành sạch, thơm ngon, bổ dưỡng từ thiên nhiên, đảm bảo vệ sinh an toàn thực phẩm là tôn chỉ và sứ mệnh mà Công ty Thuận Phát theo đuổi và xây dựng.</div>



	<div class="pos-re-combo" style="padding-bottom:10px">

		<div class="swiper-container swiper-container-combo" id="combo-home">

			<div class="swiper-wrapper" >



				<?php $_smarty_tpl->_assignInScope('k', "0");?>

				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'key');
$_smarty_tpl->tpl_vars['item']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->do_else = false;
?>

					<div class="swiper-slide">

						<div  class="combo-home-item hvr-float" style="height:450px; border: 1px solid #0c7962; margin-top: 10px; padding: 10px;">

							<h3 class="combo-item-name"><a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
"  class="btn-block-combo title2" style="text-transform:uppercase"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></h3>

							<?php if ($_smarty_tpl->tpl_vars['item']->value['promotion']) {?><div class="content"><?php echo $_smarty_tpl->tpl_vars['item']->value['promotion'];?>
</div><?php }?>

							<div class="combo-line"></div>

							<div class="item-recruit" style="text-align:justify; padding-top: 10px">



								<?php if ($_smarty_tpl->tpl_vars['item']->value['img']) {?>

									<div class="avarta">

										<a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
"><img src="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/images/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
"  border="0" alt="<?php echo $_smarty_tpl->tpl_vars['arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['name'];?>
" title="Chi tiết" hspace="0" vspace="0"  class="image" width="100%"/></a>

									</div>

								<?php }?>

								<div  style="padding-top:10px; padding-bottom: 10px;"><?php echo $_smarty_tpl->tpl_vars['item']->value['summary'];?>
</div>

								<div  style="padding-bottom: 10px; text-align: center">Giá: <strong class="h5 font-weight-bold mb-0" style="color:#FF6600"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['item']->value['price']),$_smarty_tpl ) );?>
</strong> <del><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['format_number'][0], array( array('number'=>$_smarty_tpl->tpl_vars['item']->value['price_old']),$_smarty_tpl ) );?>
</del> </div>





							</div>

							<div style="position: absolute; bottom: 0px;  width: 100%; left:0px; right:0px">

								<a href="<?php echo @constant('_DOMAIN_ROOT_URL');?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];
echo $_smarty_tpl->tpl_vars['item']->value['alias'];?>
"><button class="btn_viewmore1" tabindex="-1">Chi tiết<i class="fas fa-arrow-right ml-2"></i></button></a>



							</div>

						</div>

					</div>

					<?php $_smarty_tpl->_assignInScope('i', ((string)$_smarty_tpl->tpl_vars['i']->value)."+1");?>

				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

			</div>

		</div>





		<a href="#" class="btn-sl-combo btn-sl-next-combo btn-sl-next-combo button-next-combo-combo-home"><i class="fa fa-angle-right" aria-hidden="true"></i></a>

		<a href="#" class="btn-sl-combo btn-sl-prev-combo btn-sl-prev-combo button-prev-combo-combo-home"><i class="fa fa-angle-left" aria-hidden="true"></i></a>



	</div>

</section>



	<?php echo '<script'; ?>
>

		var swiper = new Swiper('#combo-home', {

			slidesPerView: 3,

			loop:true,

			navigation: {

				nextEl: '.button-next-combo-combo-home',

				prevEl: '.button-prev-combo-combo-home',

			},

			pagination: {

				el: '.swiper-pagination',

				type: 'bullets',

			},

			spaceBetween: 30,

			breakpoints: {

				320: {

					slidesPerView: 1,

					spaceBetween: 10,

					autoplay: {

						delay: 3000,

					},

				},

				580: {

					slidesPerView: 'auto',

					spaceBetween: 20,

					autoplay: {

						delay: 3000,

					},

				},

				680: {

					slidesPerView: 'auto',

					spaceBetween: 20,

					autoplay: {

						delay: 3000,

					},

				},

				992: {

					slidesPerView: 2,

					spaceBetween: 20,

					autoplay: {

						delay: 3000,

					},

				},

				1200: {

					slidesPerView: 3,

					spaceBetween: 20

				},

				1300: {

					slidesPerView: 3,

					spaceBetween: 20

				}

			}

		});

	<?php echo '</script'; ?>
>

<?php }
}
