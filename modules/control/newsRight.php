<?php
function newsRight(){
	global $db,$lang, $lable;	
	?>
    <script type="text/javascript" src="../../js/demo_files/jquery.js"></script>
	<script type="text/javascript" src="../../js/demo_files/jquery.vticker-min.js"></script>
    <script type="text/javascript">
    $(function(){
        $('#news-container').vTicker({ 
            speed: 500,
            pause: 3000,
            animation: 'fade',
            mousePause: false,
            showItems: 4
        });
            $('#news-container1').vTicker({
            speed: 700,
            pause: 4000,
            animation: 'fade',
            mousePause: false,
            showItems: 1
        });
    });
    </script>
	
    <div style="padding-top:10px">        
         <h3 class="widget-title"><?php if($lang=='vn'){ echo "Tin mới";}else{ echo "Hotnews";}?></h3> 
         <div style="overflow: hidden; position: relative; height: 485px;" id="news-container">
            <ul style="position: absolute; margin: 0pt; padding: 0pt; top: 0px;">
				 <?php	
				  $sql="SELECT sys_article.id,sys_article.name,sys_article.alias,sys_article.summary,sys_article.img,sys_article_cat.catID, DATE_FORMAT(sys_article.date_create, '".format_date()."') as date_create, sys_function.htaccess FROM sys_article_cat,sys_article, sys_function WHERE (sys_article_cat.artID= sys_article.id) AND (sys_article_cat.catID=sys_function.id) AND (sys_article.lang='$lang') AND sys_article.ctrl&1=1 AND sys_function.ctrl&1=1 ORDER BY sys_article.date_create DESC LIMIT 0,10";			
					$arr_article=$db->GetAssoc($sql);
					$j=count($arr_article);
					if(count($arr_article)){
					foreach($arr_article as $k=>$v){					
					?>
                    <li style="height: 99px; display: list-item;">
					<div class="thumbnail">
						<?php if($v["img"]){?><a href="<?php echo _DOMAIN_ROOT_URL."/".$v["htaccess"]."".$v["alias"] ?>" ><img src="<?php echo _DOMAIN_ROOT_URL;?>/image.php?width=95&image=<?php echo _DOMAIN_ROOT_URL;?>/images/article/<?php echo $v["img"]?>" width="95px" height="75px" border="0" vspace="0"  hspace="0" alt="<?php echo $v["name"];?>"/></a><?php }?>
					</div>
                        <div class="thumbnail_fix">
                            <div class="news-day"><?php echo $v["date_create"]?></div>
                            <?php echo "<a  href=\""._DOMAIN_ROOT_URL."/".$v["htaccess"]."".$v["alias"]."\"   class=\"content\"  style=\"font-size:12px\">".$v["name"]."</a>"; ?>
                        </div>
                    </li>
				<?php 
					}
					}
				  ?>
		</ul>
      </div>
  </div>   	
	<?php			
}
?>