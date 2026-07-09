
<style type="text/css">
/*menu top*/
.nav-top-bound{
    height: 33px;
    padding: 0 10px;
    background: white;
}

.nav-top-inner{
    height: 33px;
    padding: 5px 0;
}

ul.nav-top{
    list-style:none;
    margin:0;
    padding: 0;
	height:40px;
}

ul.nav-top > li{
    display: inline;
    position: relative;
    z-index: 9999;
	padding-top:18px; 
	padding-bottom:18px;
	padding-left:10px; 
	padding-right:10px;	
	
}
ul.nav-top > li:hover{  	
	
}

ul.nav-top > li > a{
    font-weight: 500;
    font-size: 15px;
    padding: 8px 14px;
    line-height: 40px;
	color:#000000;
	text-transform:uppercase;
}


ul.nav-top > li > a:hover, ul.nav-top > li > a:active, ul.nav-top > li.li-current > a{
    text-decoration: none;
    color: #f37022;
	
	
}

.nav-hover > a{
    color: #f37022;
}

ul.CLIP > li > a{
    padding: 5px 2px;
}

ul.NEWS > li > a{
    padding: 5px 2px;

}

ul.BOOK > li > a{
    padding: 8px 22px;
}

/*lv2*/
ul.nav-top > li > ul{
    display: none;
    width: 230px;  
    position: absolute;
    left: 0px;
    top: 43px;
    padding: 0;
    margin: 0;   
    -webkit-background-clip: padding-box; /* for Safari */
    background-clip: padding-box; /* for IE9+, Firefox 4+, Opera, Chrome */
	
	border: 1px solid #ebebeb;
    border-radius: 0px 0px 10px 10px;
   	background:#FFFFFF;
    z-index: 99999;
    line-height: normal;
    border-top: 0px;
}

ul.nav-top > li:hover > ul{
    display: block;
}

ul.nav-top > li > ul > li{
    display: block; 
    position: relative;
	padding-bottom:5px;
}

ul.nav-top > li > ul > li:first-child{
    padding-top: 0px;
}

ul.nav-top > li > ul > li:last-child{
    padding-bottom: 0px;
}

ul.nav-top > li > ul > li a{
    font-weight: normal;
    padding: 0px 10px !important;
    display: block;
    text-decoration: none !important;
    color: #000000;
    font-size: 13px;
	border-top:1px solid #ebebeb;
	line-height:30px;
}

ul.nav-top > li > ul > li > a:hover, ul.nav-top > li > ul > li.li-current > a{
    color: #f37022;
}

/*lv3*/
ul.nav-top > li > ul > li > ul{
    display: none;
    width: 225px;
    position: absolute;
    left: 204px;
    top: 0;
    margin: 0;
	padding-left:0px;
    z-index: 9999;
    border: 1px solid #ebebeb;
    border-radius: 0px 0px 10px 10px;
    background: url(../../theme_images/menu/bgtop.png);
    line-height: normal;
    -webkit-background-clip: padding-box; /* for Safari */
    background-clip: padding-box; /* for IE9+, Firefox 4+, Opera, Chrome */
}
ul.nav-top > li > ul > li > ul > li{
	margin:0px;
    display: block;
	padding-left:0px;
	
}

ul.nav-top > li > ul > li > ul > li > a{
    font-weight: normal;
	margin:0px;
    display: block;
    text-decoration: none !important;
    color: #FFFFFF;
    font-size: 13px;
	border-top:1px solid #ebebeb;
	line-height:30px;
}
ul.nav-top > li > ul > li:hover > ul{
    display: block;
	background-color:#f37022;
}

ul.nav-top > li > ul > li > ul > li > a:hover, ul.nav-top > li > ul > li > ul > li.li-current > a{
    padding-left: 10px !important;
    color: #f37022;
}

</style>
 <div>
         <ul class="nav-top NEWS">
        
<?php	
	$i=0;
	while(!$rs->EOF){
			$parent=$rs->fields("parent");
			$id=$rs->fields("id");
			$arr[$parent][$id]=$rs->fields;
		$rs->MoveNext();
	}
	?>
	<li class=" level1 has-sub" id="center<?php echo $key;?>"><a id="a<?php echo $key;?>"  style="text-decoration:none" href="<?php echo _DOMAIN_ROOT_URL; ?>"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
    <?php
	foreach($arr[0] as $key=>$value){
	$j==1;	
	if($arr[$key]){
	?>
		 
         <li class=" level1 has-sub" id="center<?php echo $key;?>"><a id="a<?php echo $key;?>"  style="text-decoration:none;" href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"]; ?>"><?php echo $arr[0][$key]["name"];?></a>
         	<ul>
            	<?php 
				foreach($arr[$key] as $k=>$v){
				if($arr[$k]){//menu cap 2 khong co link
								// hien thi menu cap 2
				?>
					 <li class=" level2"><a  style="text-decoration:none;"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"]; ?>" ><?php echo $arr[$key][$k]["name"];?></a>	
                     
                    <ul>
						<?php 
						foreach($arr[$k] as $k1=>$v1){// hien thi menu cap 3
						?>
						<li class=" level3"><a href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$k][$k1]["htaccess"] ?>" style="text-decoration:none" ><?php echo $arr[$k][$k1]["name"]; ?></a></li>
						<?php					  
						  }
						?>
                     </ul>   
					</li>	
				  <?php
					}else{
					?>
					<li class=" level2" style="width:220px; float:left; margin-left:3px"><a  style="text-decoration:none;"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"]; ?>" ><i class="fa fa-angle-right"></i> <?php echo $arr[$key][$k]["name"];?></a>	</li>			
				<?php
					}					
				  }
				?>
             </ul>
          </li>      
                
        		
		<?php
	$j=$j+1;
	}else{?>
		 <li class=" level1 has-sub" id="center<?php echo $key;?>"><a id="a<?php echo $key;?>"  style="text-decoration:none" href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"]; ?>"><?php echo $arr[0][$key]["name"];?></a></li>
	<?php	
	}		
	$j=$j+1;
	}
	?>	
 </ul>
</div>    
<script type="text/javascript">
    jQuery('li.li-current').parents('li').addClass('li-current');
  
    jQuery('ul.nav-top li').hover(
        function(){
            jQuery(this).parents('.level1').addClass('nav-hover');
        },
        function(){
            jQuery(this).parents('.level1').removeClass('nav-hover');
        }
    );
</script>