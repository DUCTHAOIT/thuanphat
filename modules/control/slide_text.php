<?php 
	function slide(){
		global $db,$smarty,$lang;
		$sql="SELECT * FROM slide ORDER BY sort DESC";		
		$arr=$db->getAssoc($sql);	
		
		if(!$arr){ return;}
		?>
  
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL;?>/js/banner/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo _DOMAIN_ROOT_URL;?>/js/banner/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?php echo _DOMAIN_ROOT_URL;?>/js/banner/owl.theme.css">


<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL;?>/js/banner/animate.css">


<!-- javascript -->
<script src="<?php echo _DOMAIN_ROOT_URL;?>/js/banner/jquery-1.12.1.min.js"></script>
<script src="<?php echo _DOMAIN_ROOT_URL;?>/js/banner/bootstrap.min.js"></script>

<script src="<?php echo _DOMAIN_ROOT_URL;?>/js/banner/owl.carousel.min.js"></script>
<link rel="stylesheet" href="<?php echo _DOMAIN_ROOT_URL;?>/js/banner/slide.css" />


<div id="slider" class="carousel slide banner" data-ride="carousel">
	<ol class="carousel-indicators">
	<?php
		$i=0;
		foreach($arr as $k=>$v){			
    ?>
    	<li data-target="#slider" data-slide-to="<?php echo $i?>" class="<?php if($i=='0'){echo "active";}?>" ></li>
	<?php
		$i++;
		}
    ?>
	</ol>
	<div class="carousel-inner">    		
				 <?php
			 	$i=0;
				foreach($arr as $k=>$v){			
				?>				
				<div class="item <?php if($i=='0'){echo "active";}?>">
					<img data-src="<?php echo _DOMAIN_ROOT_URL;?>/img/logo/<?php echo $v["logo"];?>" src="<?php echo _DOMAIN_ROOT_URL;?>/img/logo/<?php echo $v["logo"];?>" class="img-responsive">
					<div class="container">
						<div class="carousel-caption">
							<div class="carousel-text">
								<h1 class="animated bounceInRight"><?php echo $v["name"];?></h1>
								<ul class="list-unstyled carousel-list">
									<li class="animated bounceInLeft" data-original-title="" title=""><?php echo $v["des"];?></li>
								</ul>							
							</div>
						</div>
					</div>
				</div>
				<?php
				$i++;
				}
				?> 
				
     </div>
</div>
<style type="text/css" media="screen">
	#slider {
		max-height: 500px;
		overflow: hidden;
		padding: 0;
	}
	#slider .item {
	}
	#slider .item img {
		max-width: 100%;
	}
</style>
<script>
jQuery(document).ready(function() {
    jQuery("#owl-demo").owlCarousel({
        items: 2,
        lazyLoad: true,
        autoPlay: 3000,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 2
            },
            1023: {
                items: 2
            },
        }
    });

    function setHeight($item) {
        var $max = 0;
        jQuery($item).each(function() {
            $tmp = jQuery(this).height();
            if ($max < $tmp) $max = $tmp;
        });
        jQuery($item).each(function() {
            jQuery(this).height($max);
        });
    }

    function setHeightMin($item) {
        var $min = jQuery(this).height();
        jQuery($item).each(function() {
            $tmp = jQuery(this).height();
            if ($min > $tmp) $min = $tmp;
        });
        jQuery($item).each(function() {
            jQuery(this).height($min);
        });
    }
    jQuery(window).on('load', function() {
        setHeight('.box_info');
    });
});
</script>
<?php        		
	}
	//
?>