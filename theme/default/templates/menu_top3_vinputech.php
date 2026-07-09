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
	background-image: url(../../theme_images/menu/bgtop.png);
	background-position:top;
	background-repeat:repeat-x;
	height:48px;
}

ul.nav-top > li{
    display: inline;
    position: relative;
    z-index: 9999;
	padding-top:18px; 
	padding-bottom:30px;
	padding-left:8px; 
	padding-right:8px;
}
ul.nav-top > li:hover{
   background-image: url(../../theme_images/menu/menuCenterOn.png);
	background-position:right top;
	background-repeat:no-repeat;
	
}

ul.nav-top > li > a{
    font-weight: bold;
    font-size: 13px;
    padding: 8px 14px;
    line-height: 50px;
	color:#FFFFFF;
	text-transform:uppercase;
}


ul.nav-top > li > a:hover, ul.nav-top > li > a:active, ul.nav-top > li.li-current > a{
    text-decoration: none;
    color: #FFFFFF;
	
	
}

.nav-hover > a{
    color: #ff4882;
}

ul.CLIP > li > a{
    padding: 8px 5px;
}

ul.NEWS > li > a{
    padding: 8px 10px;

}

ul.BOOK > li > a{
    padding: 8px 22px;
}

/*lv2*/
ul.nav-top > li > ul{
    display: none;
    width: 240px;
    background: #22b14c;  
    position: absolute;
    left: 0px;
    top: 48px;
    padding: 0;
    margin: 0;
    z-index: 9999;
    border-radius: 0 3px 3px 3px;
    border-bottom: 2px solid rgba(0, 0, 0, 0.3);
    -webkit-background-clip: padding-box; /* for Safari */
    background-clip: padding-box; /* for IE9+, Firefox 4+, Opera, Chrome */
	font-size:12px;
}

ul.nav-top > li:hover > ul{
    display: block;

}

ul.nav-top > li > ul > li{
    display: block; 
    position: relative;
}

ul.nav-top > li > ul > li:first-child{
    padding-top: 10px;
}

ul.nav-top > li > ul > li:last-child{
    padding-bottom: 10px;
}

ul.nav-top > li > ul > li a{
    font-weight: normal;
    padding: 5px 10px !important;
    display: block;
    text-decoration: none !important;
    color: #FFFFFF;
    font-size: 12px;
}

ul.nav-top > li > ul > li > a:hover, ul.nav-top > li > ul > li.li-current > a{
    color: #006633;
}

/*lv3*/
ul.nav-top > li > ul > li > ul{
    display: none;
    width: 180px;
    background: #7C3610;  
    position: absolute;
    left: 180px;
    top: 0;
    margin: 0;
    z-index: 9999;
    border-radius: 3px;
    border-bottom: 2px solid rgba(0, 0, 0, 0.3);
    -webkit-background-clip: padding-box; /* for Safari */
    background-clip: padding-box; /* for IE9+, Firefox 4+, Opera, Chrome */
}

ul.nav-top > li > ul > li:hover > ul{
    display: block;
}

ul.nav-top > li > ul > li > ul > li > a:hover, ul.nav-top > li > ul > li > ul > li.li-current > a{
    padding-left: 10px !important;
    color: #F9F2B9;
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
	
    <?php
	foreach($arr[0] as $key=>$value){
	$j==1;	
	if($arr[$key]){
	?>
		 
         <li class=" level1 has-sub" id="center<?php echo $key;?>"><a id="a<?php echo $key;?>"  style="text-decoration:none;" href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"]; ?>"><?php echo $arr[0][$key]["name"];?></a>
         	<ul>
            	<?php 
				foreach($arr[$key] as $k=>$v){
				?>
					<li class=" level2"><a  style="text-decoration:none;"  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"]; ?>" ><?php echo $arr[$key][$k]["name"];?></a>	</li>			
				<?php
					
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