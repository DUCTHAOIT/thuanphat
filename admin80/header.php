<?php	
	global $themeName, $smarty, $lable;	
	$smarty->assign('themeName',$themeName);
	
		
	$smarty->assign('Hello',$lable->_("Hello"));
	$smarty->assign('fistName',getSession("fistName"));
	$smarty->assign('uid',getSession("uid"));
	
//	$smarty->assign('menu',$smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/menu.tpl"));
	$smarty->registerPlugin("function","menuLeft","menuLeft");
	$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/header.tpl','header_'.$themeName);
	
	/**
	 * menu admin
	 *
	 */
	function menuLeft(){		
		global $db,$lang,$lable;		
		
		$sPermit=getSession("permitID");
		
		$sPermit=str_replace("'", "", $sPermit);
		$permitID=explode(",", $sPermit);
		if(!$permitID) return;
		foreach($permitID as $key => $value){			
			$permit[$value]=true;
		}		
		
		$sql="SELECT id, parent, name$lang as name,icon, url,des$lang as des FROM sys_menu_admin WHERE id IN(" . implode(",", $permitID) . ") AND ctrl&1=1 ORDER BY `order` ASC";
		$rs = $db->Execute($sql);
		?>
        <aside class="left-sidebar" data-sidebarbg="skin4">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav">
          <ul id="sidebarnav" class="pt-4">
         	 <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="<?php echo _DOMAIN_ROOT_URL."/admin80/"; ?>"
                  aria-expanded="false"
                  ><i class="mdi mdi-view-dashboard"></i
                  ><span class="hide-menu">Home</span></a
                >
              </li>
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
           
            if($arr[$key]){
				if($permit[$value["id"]]){	
            ?>
                 
                 <li class="sidebar-item">
                 	<a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="<?php if($arr[0][$key]["icon"]){ echo $arr[0][$key]["icon"];}else{echo "mdi mdi-relative-scale";}?>"></i
                  ><span class="hide-menu"><?php echo $arr[0][$key]["name"];?></span></a>
                    <ul aria-expanded="false" class="collapse first-level" style="background-color:#e0e0e0">
                        <?php 
						$j=1;
                        foreach($arr[$key] as $k=>$v){
                        if($arr[$k]){//menu cap 2 khong co link
                                        // hien thi menu cap 2
                        ?>
                            <li class="sidebar-item" style="height:30px">
                    <a href="<?php echo _DOMAIN_ROOT_URL."/admin80/".$arr[$key][$k]["url"]; ?>" class="sidebar-link"
                      ><i class="<?php if($j%2){ echo "me-2 mdi mdi-arrow-right";}else{echo "me-2 mdi mdi-arrow-right";}?>"></i
                      ><span class="hide-menu"><?php echo $arr[$key][$k]["name"];?></span></a>	
                        	 </li>	
                          <?php
                            }else{
                            ?>
                            <li class="sidebar-item" style="height:30px">
                    			<a href="<?php echo _DOMAIN_ROOT_URL."/admin80/".$arr[$key][$k]["url"]; ?>" class="sidebar-link"><i class="<?php if($j%2){ echo "me-2 mdi mdi-arrow-right";}else{echo "me-2 mdi mdi-arrow-right";}?>"></i><span class="hide-menu"><?php echo $arr[$key][$k]["name"];?></span></a>	
                        	 </li>				
                        <?php
                            }
							 $j=$j+1;						
                          }
                        ?>
                     </ul>
                  </li>  
                <?php
				}
            }else{?>
                <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="<?php echo _DOMAIN_ROOT_URL."/admin80/".$arr[0][$key]["url"]; ?>"
                  aria-expanded="false"
                  ><i class="<?php if($arr[0][$key]["icon"]){ echo $arr[0][$key]["icon"];}else{echo "mdi mdi-relative-scale";}?>"></i
                  ><span class="hide-menu"><?php echo $arr[0][$key]["name"];?></span></a></li>
            <?php	
           	 }
            }
            ?>	
         </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
<?php	
	}
?>
