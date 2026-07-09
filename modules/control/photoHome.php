<?php 
	function photoHome(){
		global $db,$smarty,$lang;
		
		$fid=getparamFID(getParam("idF"),false);	
		
		$sql="SELECT sys_photo.*";
		$sql.=" FROM sys_photo_cat , sys_photo";
		//$sql.=" WHERE sys_photo.lang='$lang' AND sys_photo.ctrl&1=1 AND parent=0";
		$sql.=" WHERE sys_photo.ctrl&1=1 AND parent=0";
		$sql.=" ORDER BY `no` ASC";			
		$arr=$db->getAssoc($sql);		
		if(!$arr){ return;}
		?>
		<script type="text/javascript" src="../../js/jquery-1.2.6.pack.js"></script>

		<style type="text/css">
		
		/*Make sure your page contains a valid doctype at the top*/
		#simplegallery1{ //CSS for Simple Gallery Example 1
		position: relative; /*keep this intact*/
		visibility: hidden; /*keep this intact*/
		border: 0px solid darkred;
		}
		
		#simplegallery1 .gallerydesctext{ //CSS for description DIV of Example 1 (if defined)
		text-align: left;
		padding:5px; padding-bottom:0px;
		}
		
		</style>
		
		<script type="text/javascript" src="../../js/simplegallery.js">
		
		/***********************************************
		* Simple Controls Gallery- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* This notice MUST stay intact for legal use
		* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
		***********************************************/
		
		</script>
		<?php
		echo "<script type=\"text/javascript\">
			var mygallery=new simpleGallery({
			wrapperid: \"simplegallery1\", 
			dimensions: [570, 202], 
			imagearray: [\n";
			$j=count($arr);
			$i=0;
			foreach($arr as $k=>$v){
				echo "[\""._DOMAIN_ROOT_URL."/img/photo/".$v["img1"]."\", \"\", \"\", \"\"],\n";
				$i++;
			}
			echo "[\""._DOMAIN_ROOT_URL."/img/photo/home.jpg\", \"\", \"\", \"\"]\n";	
			echo "],";
			echo "autoplay: [true, 5000, 2],";
			echo "persist: false,";
			echo "fadeduration: 500,";
			echo "oninit:function(){";			
			echo "},";
			echo "onslide:function(curslide, i){";			
			echo "}";
			echo "})";
			echo "</script>";
			echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td align=\"center\" valign=\"top\"><div id=\"simplegallery1\"></div></td>
				  </tr>
				</table>";		
		//$smarty->assign('arr', $arr);	
		//$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/photoHome.tpl','photoHome_');
		
	}
	//
?>