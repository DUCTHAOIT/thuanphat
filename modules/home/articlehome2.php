<?php
function articlehome2(){
	global $db,$lang;
	$sql="SELECT * FROM sys_function WHERE (ctrl&17=17) AND (module='download') AND (lang='$lang')";	
	$rs=$db->Execute($sql);		
	if($rs->RecordCount()){	
		?>
       <link type="text/css" rel="stylesheet" href="../../js/jquery.capty/css/jquery.capty.css"/>
		<script type="text/javascript" src="../../js/jquery.capty/js/jquery.js"></script>
		<script type="text/javascript" src="../../js/jquery.capty/js/jquery.capty.min.js"></script>
		<?php
            $j=0;
            while(!$rs->EOF){
            ?>
        	<table width="484px" border="0" cellspacing="0" cellpadding="0">
        	  <tr>
                <td  nowrap="nowrap" align="left" style="background-image:url(<?php echo _DOMAIN_ROOT_URL?>/theme_images/bgtitle.png); background-repeat:repeat-x; background-position:bottom; padding-bottom:20px" class="titleBlock"><?php echo $rs->fields("name");?></td>            
              </tr>
            </table>
            <div style="height:30px"></div>	
		<?php
			$sql="SELECT sys_download.*, sys_function.htaccess FROM sys_download,sys_function WHERE sys_function.id =  sys_download.catID AND sys_function.ctrl&1=1 AND (sys_function.id=".$rs->fields("id").") AND sys_download.ctrl&1=1 ORDER BY sys_download.id DESC LIMIT 0,3";			
			//echo $sql;
			$arr_article=$db->GetAssoc($sql);
			if(count($arr_article)){
			$i=0;
			foreach($arr_article as $k=>$v){
			?>
            <?php if($i==0){?>
           	 
             <div>
             	
				 <?php echo "<a href=\""._DOMAIN_ROOT_URL."/".$v["htaccess"]."".$v["alias"]."\"  class=\"default\"><img name=\"#content-target\" id=\"content\" alt=\"".$v["name"]."\" src=\""._DOMAIN_ROOT_URL."/image.php?width=218&image="._DOMAIN_ROOT_URL."/images/article/".$v["img"]."\" border=\"0\" vspace=\"0\" hspace=\"0\"  width=\"484\" height=\"333\" /></a>"; ?>
             </div>
            <div id="content-target">
            	<font style="font-size:18px;"><?php echo $v["name"];?></font>
            </div>
            <?php }else{?>
             <div style="float:left; padding-right:30px; padding-top:30px">
             	 <?php echo "<a  href=\""._DOMAIN_ROOT_URL."/".$v["htaccess"]."".$v["alias"]."\"  class=\"content\"><img id=\"animation".$i."\" alt=\"".$v["name"]."\" src=\""._DOMAIN_ROOT_URL."/image.php?width=218&image="._DOMAIN_ROOT_URL."/images/article/".$v["img"]."\" border=\"0\" vspace=\"0\" hspace=\"0\"  width=\"225\" height=\"180\"  style=\"border:1px solid #FFFFFF\"/></a>"; ?>
             </div>
            <?php }?>
            
			<?php
			 $i++;
		}	
		}	
		?>
     	<div style="height:30px"></div>	
        <?php    
            $j++;
            $rs->MoveNext();
            }		
        ?>	
		<script type="text/javascript">
		$(function() {

			$('#default').capty();

			$('#animation1').capty({
				animation1: 'fade',
				speed:		400
			});
			
			$('#animation2').capty({
				animation2: 'fade',
				speed:		400
			});

			$('#fixed').capty({
				animation:	'fixed'
			});

			$('#content').capty({
				height:		46,
				opacity:	.6
			});

			$('.fix').capty({
				cWrapper:	'capty-tile',
				prefix:		'<span style="color: #35BB87;">Luigui</span> - ',
				sufix:		'Super Mario Bros.&reg;'
			});

		});
	</script>
    <?php 
	}
}
?>