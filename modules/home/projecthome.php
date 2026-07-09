<?php
function projecthome(){
	global $db,$lang;
	$sql="SELECT * FROM sys_function WHERE (ctrl&17=17) AND (module='htmlpage') AND (parent<>'0') AND (lang='$lang') ORDER BY sort LIMIT 0,2";	
	$rs=$db->Execute($sql);		
	if($rs->RecordCount()){	
	$j=0;
	while(!$rs->EOF){
	?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
      
               <tr>
             	<td style="padding:5px; padding-top:10px" valign="top">
                	<div style="border:1px solid #CCCCCC; background-color:#FFFFFF; padding:2px;">
             		   <?php echo "<a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."\"  class=\"content\"><img src=\""._DOMAIN_ROOT_URL."/image.php?width=218&image="._DOMAIN_ROOT_URL."/images/function/".$rs->fields("img1")."\" border=\"0\" vspace=\"0\" hspace=\"0\"  width=\"90\" height=\"70\"  style=\"border:1px solid #FFFFFF\"/></a>"; ?>
                 	</div>
                 </td>
                 <td valign="top" style="text-align:justify; padding-top:5px; padding-right:10px; padding-top:10px;">   
                 
                    <?php 
                        echo "<a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."\"  class=\"title\">".$rs->fields("name")."</a><br>"; 
						
						echo "<a href=\""._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")."\"  class=\"content\">".strstrim($rs->fields("des"),30)."...</a>"; 
                    ?>		
               </td>
              </tr> 
        </table>             
          
		<?php    
        $j++;
        $rs->MoveNext();
        }		
     
	}
}
?>