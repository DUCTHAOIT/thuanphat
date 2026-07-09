{literal} 
<style>
.testimonial {
    min-height: 550px;
    position: relative;
   background-color:#0c7962;
}
.item-content {
	width:60%;
}
@media (max-width: 1000px) {  
  .item-content {
	width:90%;
  }
}
</style>
<script>function loadAsync(e,t){var a,n=!1;a=document.createElement("script"),a.type="text/javascript",a.src=e,a.onreadystatechange=function(){n||this.readyState&&"complete"!=this.readyState||(n=!0,"function"==typeof t&&t())},a.onload=a.onreadystatechange,document.getElementsByTagName("head")[0].appendChild(a)}</script>

<link rel='stylesheet' id='wpo_min-header-0-css'  href='../js/kh/wpo-minify-header-f7c02f17.min.css' type='text/css' media='all' />
<script>if (!navigator.userAgent.match(/x11.*fox\/54|oid\s4.*xus.*ome\/62|x11.*ome\/62|oobot|ighth|tmetr|eadles|ingdo/i)){
    loadAsync('../js/kh/wpo-minify-header-f5340c16.min.js', null);
}</script>
{/literal} 
<section class="text-center ">
<div class="row testimonial">
<div class="container" >
    <div class="topic">
        <h2 class="topic" style="color:#FFFFFF; ">Ý kiến khách hàng</h2>
    </div>
    <div class="container" style="padding:0px">
    
    
<div class='tss-wrapper ' id='tss-container-358377514'  data-layout='carousel11' data-desktop-col='5'  data-tab-col='3'  data-mobile-col='3'>
<div data-title='Loading ...' class='rt-row tss-carousel11 tss-even tss-pre-loader'>
       
        <div  class='tss-carousel-thumb swiper'>
        	<div class="swiper-wrapper">
            
            		{assign var="i" value="0"}
                    {foreach key=key item=item from=$arr}
                    <div class="profile-img-wrapper swiper-slide"><div class='profile-img-wrapper-inner'><img alt='{$item.name}' class='rt-responsive-img' src='{$smarty.const._DOMAIN_ROOT_URL}/img/worldwide/{$item.img}' /></div></div>
                    {assign var="i" value=$i+1}
                    {/foreach}
               
               
        	</div>
        </div>
 
 
 <div class="carousel-wrapper">
 <div  class='tss-carousel-main swiper'
										data-loop='false'
										data-items-desktop='5'
										data-items-tab='3'
										data-items-mobile='3'
										data-autoplay='true'
										data-autoplay-timeout='5000'
										data-autoplay-hover-pause='true'
										data-dots='true'
										data-nav='true'
										data-lazy-load='false'
										data-auto-height='false'
										data-smart-speed='2000'
										><div class="swiper-wrapper">
                                        
                                        
                                        
                         	{assign var="i" value="0"}
                            {foreach key=key item=item from=$arr}
                                        
                                        
                                        <div class='rt-col-md-12 rt-col-sm-12 rt-col-xs-12 even-grid-item tss-grid-item slide-item swiper-slide even-grid-item default-margin tss-img-circle'>
                                        <div class="single-item-wrapper"><div class="tss-meta-info"></div>                                        
                                        <div class="item-content-wrapper" align="center"><div class='item-content' style="color:#FFFFFF">{$item.des}</div></div><h3 style="color:#FFFFFF; text-transform:uppercase; font-weight:700">{$item.name}</h3><h4 class="author-bio"><span class='author-designation'></span></h4>
                                        
                                        </div></div>

                            {assign var="i" value=$i+1}
                            {/foreach}   
                            
</div>
<div class="swiper-arrow swiper-button-next"><i class="fa fa-chevron-right"></i></div><div class="swiper-arrow swiper-button-prev"><i class="fa fa-chevron-left"></i></div><div class="swiper-pagination"></div></div></div><div class="rt-loading-overlay"></div><div class="rt-loading rt-ball-clip-rotate"><div></div></div></div></div></div>
            
            

 </div>
   </div>
 </div>     
</section>
{literal} 

<script>if (!navigator.userAgent.match(/x11.*fox\/54|oid\s4.*xus.*ome\/62|x11.*ome\/62|oobot|ighth|tmetr|eadles|ingdo/i)){
    loadAsync('../js/kh/wpo-minify-footer-f88e6b60.min.js', null);
}</script>

   
{/literal}