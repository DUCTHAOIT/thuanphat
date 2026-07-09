{literal}

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
			height:100px;

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
				margin-top:100px;
			}
		}
	</style>
{/literal}
<div class="container-fluid" style="background-color:#0c7962; padding:0px;">

	<div class="container" style="padding-top:30px; padding-bottom:30px">
		<div class="text-center" style="padding-bottom:10px"><h2 class="topic" ><a href="#"  style="color:#FFFFFF">Ý kiến khách hàng</a></h2></div>
		<div class="row">

			{assign var="i" value=0}
			{foreach key=key item=item from=$arr}
				{if $i==0}
					<div class="col-xl-4 col-lg-4">
						<div class="intro-giangvien nonemb">
							<a class="infoleader-item infoleader-item-blur link-view-giangvien" data-name="" data-intro="" data-class="" data-title="" data-img="" href="{$smarty.const._DOMAIN_ROOT_URL}/img/partner/{$item.img}" style="color:#FFFFFF">
								<div id="lop" class="infoleader-item-note infoleader-item-note1"></div>
								<h3 class="infoleader-name color-white title" style="text-transform:uppercase;">
									<div id="name-giangvien" data-name="{$item.img}" data-img="{$smarty.const._DOMAIN_ROOT_URL}/img/partner/{$item.img}" data-class="" data-title="{$item.name}">{$item.name}</div>
								</h3>
								<div class="infoleader-intro" id="titlegiangvien">{$item.summary}</div>
								<div class="combo-line-hlv"></div>
								<div class="infoleader-intro" id="introgiangvien">{strstrimhlv str=$item.content}</div>
							</a>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4">
						<div class="item-recruit">
							<div class="avarta_hlv">
								<a class="infoleader-item infoleader-item-blur link-view-giangvien" data-name="" data-intro="" data-class="" data-title="" data-img="" href="{$smarty.const._DOMAIN_ROOT_URL}/img/partner/{$item.img}">
									<img id="imggiangvien" src="{$smarty.const._DOMAIN_ROOT_URL}/img/partner/{$item.img}" alt="" class="hvr-grow"  width="100%">

								</a>
							</div>

							<div class="intro-giangvien-mb nonepc">
								<a class="infoleader-item infoleader-item-blur link-view-giangvien" data-name="" data-intro="" data-class="" data-title="" data-img="" href="{$smarty.const._DOMAIN_ROOT_URL}/img/partner/{$item.img}" style="color:#FFFFFF">
									<h3 class="infoleader-name color-white title" style="text-transform:uppercase;">
										<div id="name-giangvien-mb" data-name="{$item.img}" data-img="{$smarty.const._DOMAIN_ROOT_URL}/img/partner/{$item.img}" data-class="" data-title="{$item.name}">{$item.name}</div>
									</h3>
									<div class="infoleader-intro" id="titlegiangvien-mb">{$item.summary}</div>

								</a>
							</div>

						</div>
					</div>
				{/if}
				{assign var="i" value=$i+1}
			{/foreach}


			<div class="col-xl-4 col-lg-4" style="padding-top:20px; padding-bottom:10px">
				<div id="listthumb" class="pos-re">
					<div class="swiper-container swiper-container-giangvien swiper-container-horizontal swiper-container-multirow swiper-container-android" id="slhome-324">
						<div class="swiper-wrapper" style="width: 917px; transform: translate3d(-458px, 0px, 0px); transition-duration: 0ms;">



							{assign var="i" value=0}
							{foreach key=key item=item from=$arr}


								<div class="swiper-slide" style="padding-bottom:20px;">
									<div class="item-giangvien item-giangvien-home item-hvr">
										<div class="img-thumb-giangvien"><a href="javascript:void(0)" data-link="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}{$item.alias}" data-name="{$item.name}" data-title="{$item.summary}" data-intro="{strstrimhlv str=$item.content}" data-class="" data-img="{$smarty.const._DOMAIN_ROOT_URL}/img/partner/{$item.img}"><img style="display:block; width:100%" class="" src="{$smarty.const._DOMAIN_ROOT_URL}/img/partner/{$item.img}" alt="{$item.name}"  width="100%"></a></div>
									</div>
								</div>
								{assign var="i" value=$i+1}
								{if $i==2}{assign var="i" value=0}{/if}
							{/foreach}
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

{literal}
	<script type="text/javascript">
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
	</script>

	<script>

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
			$("#name-giangvien").attr("data-name",($(this).attr("data-name")));
			$("#name-giangvien").attr("data-intro",($(this).attr("data-intro-full")));
			$("#name-giangvien").attr("data-img",($(this).attr("data-img")));
			$("#name-giangvien").attr("data-class",($(this).attr("data-class")));
			$("#name-giangvien").attr("data-title",($(this).attr("data-title")));






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

			$("#name-giangvien").attr("data-name",$("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-name"));
			$("#name-giangvien").attr("data-intro",$("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-intro"));
			$("#name-giangvien").attr("data-img",$("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-img"));
			$("#name-giangvien").attr("data-class",$("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-class"));
			$("#name-giangvien").attr("data-title",$("#listthumb").children(':first').find(".img-thumb-giangvien a").attr("data-title"));
		});

	</script>

{/literal}