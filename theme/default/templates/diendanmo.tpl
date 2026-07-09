{literal} 
<style>
	.btn-sl-khoahoc{width:34px;height:34px;position:absolute;text-align:center;line-height:34px;background-color:#fff;-webkit-border-radius:50%;border-radius:50%;font-size:24px;top:50%;margin-top:-16px;z-index:99;-webkit-box-shadow:0 0 5px 0 rgba(110,110,110,1);-moz-box-shadow:0 0 5px 0 rgba(110,110,110,1);box-shadow:0 0 5px 0 rgba(110,110,110,1);color:#484848}.btn-sl-khoahoc:hover{color:#fff;background-color:#0b7a62}.btn-sl-next-khoahoc-camnhan{right:-30px}.btn-sl-prev-khoahoc-camnhan{left:-30px}.btn-sl-next-camnhan{bottom: 0;top: inherit;right: 50%;margin-right: -40px;}.btn-sl-prev-camnhan{bottom: 0;top: inherit;left: 50%;margin-left: -40px;}
	.pos-re {
		position: relative;
	}
	@media handheld, only screen and (max-width: 570px){
		.btn-sl-prev-khoahoc-camnhan {
			left: -5px;
		}
		.btn-sl-next-khoahoc-camnhan {
			right: -5px;
		}
	}
	@media handheld, only screen and (max-width: 768px){
		.btn-sl-prev-khoahoc-camnhan {
			left: -10px;
		}
		.btn-sl-next-khoahoc-camnhan {
			right: -10px;
		}
	}
	@media handheld, only screen and (max-width: 768px){
		.btn-sl-khoahoc {
			width: 34px;
			height: 34px;
			line-height: 32px;
		}
	}
	@media handheld, only screen and (max-width: 992px){
		.btn-sl-khoahoc {
			margin-top: -17px;
		}
	}
</style>
{/literal}
<div class="pos-re" style="padding-bottom:20px">
<div class="swiper-container swiper-container-news" id="newshome-camnhan">
<div class="swiper-wrapper" style="padding-bottom:40px;" >


                	{assign var="i" value="0"}
                    {foreach key=key item=item from=$arr}
                    <div class="swiper-slide">
                    <div class="item-news-home camnhan">
                            <div>{$item.des}</div>
                            <div style="padding-top:20px; font-size:0.8rem">
                            <strong>{$item.name}</strong>
                            <p>{$item.address}</p>
                            </div>
                            
                   
                    </div>
                    </div>
                    {assign var="i" value=$i+1}
                    {/foreach}
</div>
</div>

<a href="#" class="btn-sl-khoahoc btn-sl-next-khoahoc btn-sl-next-camnhan button-next-news-home-camnhan"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
<a href="#" class="btn-sl-khoahoc btn-sl-prev-khoahoc btn-sl-prev-camnhan button-prev-news-home-camnhan"><i class="fa fa-angle-left" aria-hidden="true"></i></a>

</div>
{literal} 
<script>
                var swiper = new Swiper('#newshome-camnhan', {
                  slidesPerView: 2,
                  loop:true,
                  navigation: {
                    nextEl: '.button-next-news-home-camnhan',
                    prevEl: '.button-prev-news-home-camnhan',
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
                      slidesPerView: 1,
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
                    1300: {
                      slidesPerView: 2,
                      spaceBetween: 30
                    }
                  }
                });
            </script>
{/literal}