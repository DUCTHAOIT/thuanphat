<style>
/* The Overlay (background) */
.overlay {
  /* Height & width depends on how you want to reveal the overlay (see JS below) */   
  height: 100%;
  width: 0;
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  background-color:#FFFFFF;
  overflow-x: hidden; /* Disable horizontal scroll */
  transition: 0.5s; /* 0.5 second transition effect to slide in or slide down the overlay (height or width, depending on reveal) */
}

/* Position the content inside the overlay */
.overlay-content {
  position: relative;
  top: 5%; /* 25% from the top */
  width: 300px; /* 100% width */
  margin-top: 30px; /* 30px top margin to avoid conflict with the close button on smaller screens */
}

/* The navigation links inside the overlay */
.overlay a {
  padding: 8px;
  text-decoration: none;
  font-size: 36px;
  color: #818181;
  display: block; /* Display block instead of inline */
  transition: 0.3s; /* Transition effects on hover (color) */
}

/* When you mouse over the navigation links, change their color */
.overlay a:hover, .overlay a:focus {
  color: #f1f1f1;
}

/* Position the close button (top right corner) */
.overlay .closebtn {
  position: absolute;
  top: 10px;
  left: 15px;
  font-size: 30px;
}
.window ::-webkit-scrollbar, .ubuntu ::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
</style>
<style type="text/css">
/*menu top*/
.menu-mobile ul li {
    font-size: 13px;
    font-weight: bold;
    color: #595959;
    padding-top: 8px;
	padding-bottom:8px;
    list-style: none;
}
.menu-mobile ul li ul li{
    font-size: 12px;
    font-weight: 400;
    color: #595959;
    padding-top: 8px;
	padding-bottom:8px;
	padding-left:10px;
    list-style: none;
}
.menu-mobile ul li ul li ul li{
    font-size: 12px;
    font-weight: 400;
    color: #595959;
    padding-top: 8px;
	padding-bottom:8px;
	padding-left:20px;
    list-style: none;
}
.menuMobileOn{
  
}

.menuMobileOff{
  
}
</style>
<script>
function openNav() {
  document.getElementById("myNav").style.width = "300px";
}

function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}
</script>
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>


<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay-content">	
  <nav class="small aside-nav">
	<ul>
<script language="javascript">
function dropCategory(obj){
	if(document.getElementById(obj).style.display == ""){		
		document.getElementById(obj).style.display = "none";
		document.frmTemp.objdrop.value = "none";	
	}
	else{
		document.getElementById(obj).style.display = "";
		//document.frmTemp.objdrop.value = obj.id;
	}
}

</script>
	<?php	
	$i=0;
	while(!$rs->EOF){
			$parent=$rs->fields("parent");
			$id=$rs->fields("id");
			$arr[$parent][$id]=$rs->fields;
		$rs->MoveNext();
	}
	?>
	<li class="menu-item menu-item-type-post_type menu-item-object-page"><a  href="<?php echo _DOMAIN_ROOT_URL; ?>"><?php if($lang=='vn'){ echo "Trang chủ";}else{ echo "Home";}?></a></li>
    <?php
	foreach($arr[0] as $key=>$value){
		if($arr[$key]){// menu cap 1 co menu con
					// hien thi menu cap 1 khong co link
	?>				
					<li class="menu-item menu-item-type-post_type menu-item-object-page" id="a<?php echo $key ?>" ><a href="#" style="font-size:14px" onClick="JavaScript:dropCategory(<?php echo $key ?>);"><?php echo $arr[0][$key]["name"] ?><i class="fa fa-chevron-circle-down pull-left" aria-hidden="true"></i></a>
                    	<ul id="<?php echo $key ?>" class="sub-menu" style="display: none;">						
								<?php 
									foreach($arr[$key] as $k=>$v){
									// hien thi menu cap 2
									if($arr[$k]){//menu cap 2 khong co link
								?>
										<li id="tr<?php echo $k ?>" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
											<a href="#"  class="title"  style="font-size:12px" onClick="JavaScript:dropCategory(<?php echo $k ?>);"><?php echo $arr[$key][$k]["name"] ?><i class="fa fa-chevron-down pull-right" aria-hidden="true"></i>
										</li>
                                        <ul  id="<?php echo $k ?>" style="display: none; padding-left:20px">
								<?php		
										foreach($arr[$k] as $k1=>$v1){// hien thi menu cap 3
											?>
											<li id="tr<?php echo $k1 ?>">																							
												<i class="fa fa-circle" aria-hidden="true" style="font-size:8px"></i>&nbsp;&nbsp;<a href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$k][$k1]["htaccess"] ?>" class="content" style="text-decoration:none" id="mb<?php echo $k1?>"><?php echo $arr[$k][$k1]["name"] ?></a></li>
										
                            			<?php
											}
										?>
                                        </ul>
                                <?php                                   		
									}else{//hien thi menu cap 2 co link
								?>
									<li class="menu-item menu-item-type-post_type menu-item-object-room" id="tr<?php echo $k ?>" style="padding-left:10px;"><a  href="<?php echo _DOMAIN_ROOT_URL."/".$arr[$key][$k]["htaccess"] ?>"   id="mb<?php echo $k ?>"><?php echo $arr[$key][$k]["name"] ?></a></li>
								<?php
									}	
								}	
								?>	
						</ul></li>		
			<?php }else{ // menu cap 1 khong co link ?>
					  <li class="menu-item menu-item-type-post_type menu-item-object-page">
                      	<a href="<?php echo _DOMAIN_ROOT_URL."/".$arr[0][$key]["htaccess"] ?>" class="title" id="mb<?php echo $key ?>" class="title"  style="font-size:14px"><?php echo $arr[0][$key]["name"] ?></a>
					  </li>
					<?php 
				}			
		}
		
?>
</ul>
</nav>
</div>
</div>
<script language="javascript">
<?php
	if(getParam("idF")){
		$idF=explode("_", getParam("idF"));
		if(count($idF)>1){
			//echo "document.getElementById('tr".$idF[1]."').style.background=\"#D0A21A\";\n";
			//echo "document.getElementById('a".$idF[1]."').style.color=\"#fe0000\";\n";
			echo "dropCategory(".$idF[0].");\n";	
		}
	}
?>
</script>