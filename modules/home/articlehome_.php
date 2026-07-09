<?php
function articlehome(){
	global $db,$lang;
	$sql="SELECT * FROM sys_function WHERE (ctrl&17=17) AND (module='article') AND (lang='$lang') ORDER BY sort";
	$rs=$db->Execute($sql);	
	if($rs->RecordCount()){	
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
			<?php
            $j=0;
            while(!$rs->EOF){
            if($j==2){
                $j=0;
                echo "</tr><tr>";
            }
            ?>
			<td valign="top" width="50%" style="padding:5px;">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	  <tr height="30">
                <td  nowrap="nowrap" align="left" style="border-bottom:2px solid #e53a0f;" class="titleBlock"><a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess")?>" class="titleBlock"><?php echo $rs->fields("name");?></a></td>
                <td  nowrap="nowrap" width="100%" align="left" style="border-bottom:2px solid #c9cacb;">		
                    <img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/spacer.gif" border="0" width="1" height="1" />
                </td>  
              </tr>
            </table>		
         <table width="100%" border="0" cellspacing="0" cellpadding="0">			
		<?php
			$sql="SELECT sys_article.id,sys_article.name,sys_article.summary,sys_article.alias,DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create,sys_article.img,sys_article_cat.catID FROM sys_article_cat,sys_article WHERE (sys_article_cat.artID= sys_article.id) AND (sys_article_cat.catID=".$rs->fields("id").") AND sys_article.ctrl&1=1 ORDER BY sys_article.date_create DESC LIMIT 0,3";			
			$arr_article=$db->GetAssoc($sql);
			if(count($arr_article)){
			$i=0;
			foreach($arr_article as $k=>$v){
				if($i==1){
				echo "<tr style=\"padding:5px;  background-color:#ededed\">";
				}else{
					echo "<tr>";
				}
			?>
			
            <td  style="padding:3px;" valign="top">
                <?php echo "<a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"]."\"  class=\"content\"><img src=\""._DOMAIN_ROOT_URL."/image.php?width=115&image="._DOMAIN_ROOT_URL."/images/article/".$v["img"]."\" border=\"0\" vspace=\"5\" hspace=\"0\"  width=\"115\" height=\"77\" style=\"border:1px solid #FFFFFF\"/></a>"; ?>
             </td>
             
            <td width="100%"  style="padding:5px; text-align:justify;  line-height:23px;" valign="top">
                <?php 
					echo "<a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"]."\"  class=\"title\">".$v["name"]."</a> (".$v["date_create"].")<br>"; 
					echo "<a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."".$v["alias"]."\" class=\"content\" style=\"text-decoration:none;text-align:justify; color:#000000\">".$v["summary"]."</a><br>";
				?>
                
             </td>
            </tr>
            <tr>
            	<td colspan="2"> <img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/spacer.gif" border="0" width="1" height="10" /></td>
            </tr>
			<?php
			 $i++;
		}	
		}	
		?>
        </table> 
        </td>
        <?php    
            $j++;
            $rs->MoveNext();
            }		
        ?>	
      </tr>
    </table>
    <?php 
	}
}
?>