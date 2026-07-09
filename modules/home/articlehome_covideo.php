<?php
function articlehome(){
	global $db,$lang;
	$sql="SELECT * FROM sys_function WHERE (ctrl&17=17) AND (module='article') AND (lang='$lang') ORDER BY sort LIMIT 0,1";	
	$rs=$db->Execute($sql);		
	if($rs->RecordCount()){	
	?>
    <?php
            $j=0;
            while(!$rs->EOF){
            ?>
            <h2 class="title"><a href="<?php echo _DOMAIN_ROOT_URL."/".$rs->fields("htaccess");?>"  ><?php echo $rs->fields("name");?></a></h2>
                 
		<?php
			$sql="SELECT sys_article.id,sys_article.name,sys_article.summary,sys_article.alias,DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create, TO_DAYS(sys_article.date_create) as today, sys_article.img,sys_article_cat.catID, sys_function.htaccess FROM sys_article_cat,sys_article,sys_function WHERE sys_article_cat.artID =  sys_article.id AND sys_article_cat.catID =  sys_function.id AND sys_function.ctrl&1=1 AND (sys_function.id=".$rs->fields("id").") AND sys_article.lang='$lang' AND sys_article.ctrl&1=1 ORDER BY today DESC LIMIT 0,4";			
		//	echo $sql;
			$arr_article=$db->GetAssoc($sql);
			if(count($arr_article)){
			$i=0;
			foreach($arr_article as $k=>$v){
				?>
             
                	 <?php if($i==0){?>
                     	 <div class="highlights">
                            <article class="post flex">
                                <?php echo "<a href=\""._DOMAIN_ROOT_URL."/".$v["htaccess"]."".$v["alias"]."\"  ><img src=\""._DOMAIN_ROOT_URL."/image.php?width=600&image="._DOMAIN_ROOT_URL."/images/article/".$v["img"]."\" width=\"100%\" /></a>"; ?>
                               
                                <div class="post__content">
                                    <h3>
                                    <?php echo "<a href=\""._DOMAIN_ROOT_URL."/".$v["htaccess"]."".$v["alias"]."\" >".$v["name"]."</a>"; ?>
                                   </h3>
                                </div>
                            </article>
                        </div>
                   		
                   
                    <?php }else{
						if($i==1){echo "<div class=\"news__list flex\">";}
					?>  
                    
                    	<article class="post">
                            <?php echo "<a href=\""._DOMAIN_ROOT_URL."/".$v["htaccess"]."".$v["alias"]."\"  ><img src=\""._DOMAIN_ROOT_URL."/image.php?width=370&image="._DOMAIN_ROOT_URL."/images/article/".$v["img"]."\"/></a>"; ?>
                            <h3><?php 
                        echo "<a href=\""._DOMAIN_ROOT_URL."/".$v["htaccess"]."".$v["alias"]."\">".$v["name"]."</a>"; 	
						?></h3>
                        </article>
                    
                    <?php
						if($i==3){echo "</div>";}
                    	}
					?>
             		 
			<?php
			 $i++;
		}	
		}	
		?> 
      
        <?php    
            $j++;
            $rs->MoveNext();
            }
		?>
  <?php   
	}
}
?>