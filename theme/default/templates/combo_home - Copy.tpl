{literal}
<link rel="stylesheet" type="text/css" href="../../js/slick/slick.css">
<link rel="stylesheet" type="text/css" href="../../js/slick/slick-theme.css">
<style type="text/css">
	
	.slider {
		width: 100%;
		margin: 10px auto;
	}
	.slick-slide img {
	  width: 100%;
	}
	
	.slick-prev:before,
	.slick-next:before {
		color: #0b7a62;
	}
.button3 {
	background-color: #FFFFFF; 
	color: #006633; 
	border: 1px solid #666666;
	border-radius: 4px;
	height:20px;
	font-size:11px;
	padding-left:5px;
	padding-right:5px;
}

.button3:hover {
	background-color: #f37022;
	color: #006633;
	border-radius: 4px;
	height:20px;
	font-size:11px;
	padding-left:5px;
	padding-right:5px;
}
	.bodycombo {
		 margin-left:-40px; 
		 margin-right:-40px
	}
@media (max-width: 1000px) { 
	.bodycombo {
		 margin-left:-25px; 
		 margin-right:-25px
	}
}  
</style> 
{/literal}
<section class="text-center">
<div class="container"  style="padding-bottom:20px;">
    <div class="topic">
        <h2 class="topic" style="color:#FFFFFF; ">Gói Combo</h2>
    </div>
    <div class="bodycombo" style="position:relative;">
                <div class="slider responsive" >
                {assign var="k" value="0"}
                {foreach key=key item=item from=$arr}
                   <div style="position:relative">
                   <div class="combo-home-item hvr-float" style="margin:10px; margin-bottom:30px; padding:20px; height: 500px; ">
                            <h3 class="combo-item-name"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.url}{$item.alias}" class="title2" style="text-transform:uppercase">{$item.name}</a></h3>
                            {if $item.promotion}<div class="content">{$item.promotion}</div>{/if}
                            <div class="combo-line"></div>
                            <div class="combo-info ih" style="text-align:justify">
                            {$item.content}
                            <br>
                            {if $item.summary}<font style="color:#FF6600; font-size:14px"><i>{$item.summary}</i></font>{/if}
                            </div>
                            
                                <div class="row" style="padding-top:10px; padding-bottom:10px">
                                    <div class="col-6" align="left">
                                        <div class="combo-price"><del>{format_number number=$item.price_old}</del></div>
                                    </div>
                                    <div class="col-6" align="right">
                                        <div  class="h5 font-weight-bold mb-0" style="color:#FF6600"><strong>{format_number number=$item.price}</strong></div>
                                    </div>
                                </div>
                           		 <div style="position: absolute; bottom: 0px;  width: 100%; left:0px; right:0px">
                                 <a href="#" data-toggle="modal" data-id="{$item.id}" class="btn-block-combo"><button class="btn_viewmore1" tabindex="-1">Đăng ký</button></a>
                                 
                                </div>
                                                 
                       
                     </div>
                     </div>
                  {assign var="i" value="$i+1"}
       			 {/foreach}
                </div>
                
        </div> 
</div>  
</section>
{literal}  
<script src="../../js/slick/slick.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).on('ready', function() {
  $(".regular").slick({
	dots: true,
	infinite: true,
	slidesToShow: 3,
	slidesToScroll: 3,
	responsive: [
		{
		  breakpoint: 1024,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 2,
			infinite: true,
			dots: true
		  }
		},
		{
		  breakpoint: 600,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 2
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		  }
		}
	  ]
  });
  $(".center").slick({
	dots: true,
	infinite: true,
	centerMode: true,
	slidesToShow: 3,
	slidesToScroll: 3
  });
  $(".variable").slick({
	dots: true,
	infinite: true,
	variableWidth: true
  });
  $(".lazy").slick({
	lazyLoad: 'ondemand', // ondemand progressive anticipated
	autoplay: true,
	infinite: true
  });
});

$('.responsive').slick({
  dots: true,
  infinite: false,
  autoplay: true,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 3,
  responsive: [
	{
	  breakpoint: 1024,
	  settings: {
		slidesToShow: 2,
		slidesToScroll: 2,
		infinite: true,
		dots: true
	  }
	},
	{
	  breakpoint: 600,
	  settings: {
		slidesToShow: 2,
		slidesToScroll: 2
	  }
	},
	{
	  breakpoint: 480,
	  settings: {
		slidesToShow: 1,
		slidesToScroll: 1
	  }
	}
  ]
});
</script> 


<script>
 $('.btn-block-combo').click(function(){
	var id=$(this).data('id');
	//undefined
	//alert(id);
	//shows loading text
	//it dosent work
    //$('.data-modal').html('loading');
    $.ajax({
		url: '../../?m=dangky&f=dangkycombo',
		type: 'post',
		data: {id: id},
		success: function(response){ 
			// Add response in Modal body
			$('.modal-body-dangky').html(response); 

			// Display Modal
			$('#myModalDangkyKhoahocShow').modal('show'); 
		},
        error:function(err){
            alert("error"+JSON.stringify(err));
        }
     });
});
</script>	    
{/literal}