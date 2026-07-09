<?php
function articlehome(){
	global $db,$lang;
	$sql="SELECT * FROM sys_function WHERE (ctrl&17=17) AND (module='article') AND (lang='$lang') ORDER BY sort LIMIT 0,3";	
	$rs=$db->Execute($sql);		
	if($rs->RecordCount()){	
	?>

<style>
	.btn-sl-khoahoc{width:52px;height:52px;position:absolute;text-align:center;line-height:50px;background-color:#fff;-webkit-border-radius:50%;border-radius:50%;font-size:24px;top:50%;margin-top:-26px;z-index:99;-webkit-box-shadow:0 0 5px 0 rgba(110,110,110,1);-moz-box-shadow:0 0 5px 0 rgba(110,110,110,1);box-shadow:0 0 5px 0 rgba(110,110,110,1);color:#484848}.btn-sl-khoahoc:hover{color:#fff;background-color:#0b7a62}.btn-sl-next-khoahoc{right:-30px}.btn-sl-prev-khoahoc{left:-30px}.btn-sl-next-news{top:30%!important}.btn-sl-prev-news{top:30%!important}
	.pos-re {
		position: relative;
	}
	@media handheld, only screen and (max-width: 570px){
		.btn-sl-prev-khoahoc {
			left: -5px;
		}
		.btn-sl-next-khoahoc {
			right: -5px;
		}
	}
	@media handheld, only screen and (max-width: 768px){
		.btn-sl-prev-khoahoc {
			left: -10px;
		}
		.btn-sl-next-khoahoc {
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
<?php
	$j=0;
	while(!$rs->EOF){	
?>
<section class="text-center">
<div style="padding-top:10px;">
    <h2 class="topic"><a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess")?>"><?php echo $rs->fields("name");?></a></h2>
</div>
		
<div class="pos-re" style="padding-bottom:10px">
<div class="swiper-container swiper-container-news" id="newshome-<?php echo $rs->fields("id");?>">
<div class="swiper-wrapper" >

<?php
	$sql="SELECT sys_article.id,sys_article.name,sys_article.summary,sys_article.alias,DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create,sys_article.img,sys_article_cat.catID FROM sys_article_cat,sys_article WHERE (sys_article_cat.artID= sys_article.id) AND (sys_article_cat.catID=".$rs->fields("id").") AND sys_article.ctrl&1=1 ORDER BY sys_article.date_create DESC LIMIT 0,10";			
	$arr_article=$db->GetAssoc($sql);
	if(count($arr_article)){
	$i=0;
	foreach($arr_article as $k=>$v){
?>


<div class="swiper-slide">
<div class="item-news-home item-hvr">
<div class="item-recruit">
    <div class="avarta">
    <a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"];?>"><img class="lazy entered loaded" data-src="<?php echo _DOMAIN_ROOT_URL."/image.php?width=600&image="._DOMAIN_ROOT_URL."/images/article/".$v["img"];?>" alt="<?php echo $v["name"];?>" data-ll-status="loaded" src="<?php echo _DOMAIN_ROOT_URL."/image.php?width=600&image="._DOMAIN_ROOT_URL."/images/article/".$v["img"];?>" width="100%"></a>
    </div>
	
                 	
		<?php 
        echo "<div class=\"content\" style=\"text-align:justify; padding-top:10px\"><h2><a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"]."\"  class=\"title\">".$v["name"]."</a></h2></div>";
        echo "<div class=\"content\" style=\"text-align:justify;\"><a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"]."\" class=\"content\" style=\"line-height:20px\">".strstrimphp($v["summary"],22).",...</a></div>";
    
    ?>
</div>
</div>
</div>
<?php
		 $i++;
		}	
	}	
?>
</div>
</div>

<a href="#" class="btn-sl-khoahoc btn-sl-next-khoahoc btn-sl-next-news button-next-news-home<?php echo $rs->fields("id");?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
<a href="#" class="btn-sl-khoahoc btn-sl-prev-khoahoc btn-sl-prev-news button-prev-news-home<?php echo $rs->fields("id");?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>

</div>
</section>

<script>
		var swiper = new Swiper('#newshome-<?php echo $rs->fields("id");?>', {
		  slidesPerView: 3,
		  loop:true,
		  navigation: {
			nextEl: '.button-next-news-home<?php echo $rs->fields("id");?>',
			prevEl: '.button-prev-news-home<?php echo $rs->fields("id");?>',
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
	</script> 
<?php    
	$j++;
	$rs->MoveNext();
	}		
?>	     
  <?php   
	}
}
?>