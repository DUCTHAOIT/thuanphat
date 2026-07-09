<?php
function producthlv(){
	global $db,$lang;
	$sql="SELECT * FROM sys_function WHERE (ctrl&1=1) AND (module='partner') AND (lang='$lang') ORDER BY sort LIMIT 0,1";	
	$rs=$db->Execute($sql);		
	if($rs->RecordCount()){	
	?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/css/swiper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.6/js/swiper.min.js"></script>
<style>
	.btn-sl-khoahoc{width:52px;height:52px;position:absolute;text-align:center;line-height:50px;background-color:#fff;-webkit-border-radius:50%;border-radius:50%;font-size:24px;top:50%;margin-top:-26px;z-index:99;-webkit-box-shadow:0 0 5px 0 rgba(110,110,110,1);-moz-box-shadow:0 0 5px 0 rgba(110,110,110,1);box-shadow:0 0 5px 0 rgba(110,110,110,1);color:#484848}.btn-sl-khoahoc:hover{color:#fff;background-color:#0b7a62}.btn-sl-next-hlv{right:-30px}.btn-sl-prev-hlv{left:-30px}.btn-sl-next-news{top:50%!important}.btn-sl-prev-news{top:50%!important}
	.pos-re {
		position: relative;
	}
	
	.item-recruit-tron-hlv .avarta-tron-hlv {
	  overflow: hidden;
	  border-radius:50%;
	}
	
	.item-recruit-tron-hlv .avarta-tron-hlv img {
	  transition: .4s all !important;
	  height: 240px;
	  width:240px
	  object-fit: cover;
	}
	
	.item-recruit-tro-hlvn .avarta-tron-hlv img:hover {
	  transform: scale(1.04);
	}
	@media handheld, only screen and (max-width: 570px){
		.btn-sl-prev-hlv {
			left: -5px;
		}
		.btn-sl-next-hlv {
			right: -5px;
		}
	}
	@media handheld, only screen and (max-width: 768px){
		.btn-sl-prev-hlv {
			left: -10px;
		}
		.btn-sl-next-hlv {
			right: -10px;
		}	
		.btn-sl-khoahoc {
			width: 34px;
			height: 34px;
			line-height: 32px;
		}
		
		.item-recruit-tron-hlv .avarta-tron-hlv img {
		  transition: .4s all !important;
		  height: 210px;
		  width:210px
		  object-fit: cover;
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
<section>
<div class="row">
	 <div class="titledaotao" id="giangvien"><a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess")?>"><?php echo $rs->fields("name");?></a></div>
</div>
		
<div class="pos-re" style="margin-left:-20px; margin-right:-20px; padding-bottom:20px; padding-top:30px">
<div class="swiper-container swiper-container-news" id="newshome-<?php echo $rs->fields("id");?>">
<div class="swiper-wrapper text-center" >

<?php
	$sql="SELECT sys_partner.id,sys_partner.name,sys_partner.summary,sys_partner.alias,DATE_FORMAT(sys_partner.date_create, '".format_date()."') as today,sys_partner.img,sys_partner_cat.catID FROM sys_partner_cat,sys_partner WHERE (sys_partner_cat.artID= sys_partner.id) AND (sys_partner_cat.catID=".$rs->fields("id").") AND sys_partner.ctrl&1=1 ORDER BY today DESC LIMIT 0,16";			
	$arr_partner=$db->GetAssoc($sql);
	if(count($arr_partner)){
	$i=0;
	foreach($arr_partner as $k=>$v){
?>


<div class="swiper-slide">
<div class="item-news-home item-hvr">
<div class="item-recruit-tron-hlv"  style="padding:10px; padding-left:20px; padding-right:20px;">
    <div class="avarta-tron-hlv">
    <a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"];?>"><img class="lazy entered loaded" data-src="<?php echo _DOMAIN_ROOT_URL."/image.php?width=600&image="._DOMAIN_ROOT_URL."/images/partner/".$v["img"];?>" alt="<?php echo $v["name"];?>" data-ll-status="loaded" src="<?php echo _DOMAIN_ROOT_URL."/image.php?width=600&image="._DOMAIN_ROOT_URL."/images/partner/".$v["img"];?>" width="100%"></a>
    </div>
	
                 	
		<?php 
        echo "<div class=\"content\" style=\"padding-top:20px\"><a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"]."\"  class=\"title\">".$v["name"]."</a></div>";
        echo "<div class=\"content\" style=\"\"><a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"]."\" class=\"content\" style=\"line-height:20px\">".strstrimphp($v["summary"],22).",...</a></div>";
    
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
<a href="#" class="btn-sl-khoahoc btn-sl-next-hlv btn-sl-next-news button-next-news-home<?php echo $rs->fields("id");?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
<a href="#" class="btn-sl-khoahoc btn-sl-prev-hlv btn-sl-prev-news button-prev-news-home<?php echo $rs->fields("id");?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>

</div>
</section>

<script>
		var swiper = new Swiper('#newshome-<?php echo $rs->fields("id");?>', {
		  spaceBetween: 30,
		  slidesPerView: 4,
		  slidesPerColumn: 2,
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
			  slidesPerView: 4,
			  spaceBetween: 20
			},
			1300: {
			  slidesPerView: 4,
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