<?php
	function menuLeftOfMenuTop(){
		global $db,$smarty, $themeName, $lang;		
		$fid=getparamFID(getParam("idF"),true);
		
		$parentroot=getFunctionNameID($fid,"parent");	
		if($parentroot==0){		
			$parentroot=$fid;
		}
			
			$fidsub=getparamFID(getParam("idF"),false);
			$parentrootsub=getFunctionNameID($fidsub,"parentroot");			
			if($parentrootsub<>0){			
				$fidsub=$fid;
			}
		
		$namesub=getFunctionNameID($parentroot,"name");		
		
		
		
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_function";		
		$obj->limit="all";
		$obj->where="ctrl&5=5";
		$obj->orderBy="sort";
		$sql=$obj->sqlSelect();
		
		include_once("modules/control/menuLevelLeft.class.php");
		$obj=new menuLevelLeft();
		$obj->fid=$parentroot;
		$obj->sql=$sql;
		
		$arr=$obj->orderMenu();		
		
		if(!$arr) return;
		//if(count($arr)<=1) return;
		$countarr=count($arr);		
		
		$smarty->assign('namesub',$namesub);		
		$smarty->assign('arr',$arr);
		$smarty->assign('countarr',$countarr);	
		$smarty->assign('fid',$fid);
		$smarty->assign('fidsub',$fidsub);
		$smarty->assign('themeName',$themeName);
		$smarty->assign('count',count($arr));
		//$smarty->registerPlugin("function","productListmenu", "productListmenu");	
		$smarty->registerPlugin("function","menuLeftOfMenuTopSub", "menuLeftOfMenuTopSub");	
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/menuLeftOfMenuTop.tpl','menuLeftOfMenuTop_'.$fid);	
	}	
	//
	function menuLeftOfMenuTopSub(){
		global $db,$smarty, $themeName, $lang;		
		
		$fid=getparamFID(getParam("idF"),false);
		
		$fidsub=getparamFID(getParam("idF"),false);
		$parentrootsub=getFunctionNameID($fidsub,"parentroot");	
		
			if($parentrootsub<>0){			
				$fid=getparamFID(getParam("idF"),true);
			}else{
				$fid=getparamFID(getParam("idF"),false);
			}
		
		$sql="SELECT * FROM sys_function WHERE (lang='$lang') AND ctrl&1=1 AND parent='$fid' ORDER BY sort ASC";	
		$arr=$db->GetAll($sql);	
		if(!$arr) return;
			
		$fid=getparamFID(getParam("idF"),false);	
		$smarty->assign('arr',$arr);		
		$smarty->assign('fid',$fid);
		$smarty->assign('themeName',$themeName);
		
		$smarty->registerPlugin("function","productListmenu", "productListmenu");	
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/menuLeftOfMenuTopSub.tpl','menuLeftOfMenuTopSub_'.$fid);	
	}
		
	function productListmenu(){
		global $db,$lang;
		$fid=getparamFID(getParam("idF"),false);		
		$sql="SELECT sys_product.*, sys_function.htaccess FROM sys_product, sys_function WHERE (sys_function.id = ".$fid.") AND (sys_function.id=sys_product.catID) AND (sys_product.ctrl&1=1) ORDER BY date_create DESC";					
		$arr_product=$db->GetAssoc($sql);
		if(count($arr_product)){
	
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:5px; border-top:1px solid #FFFFFF;">
		 <?php
			
			foreach($arr_product as $k=>$v){						
			?>
			<tr>
			<td><img src="<?php echo _DOMAIN_ROOT_URL;?>/theme_images/button.gif" border="0" hspace="5" vspace="5"/></td>
			<td width="100%" align="left" >							
				<?php
					echo "<a id=".$v["id"]." href=\""._DOMAIN_ROOT_URL."/".$v["htaccess"]."".$v["alias"]."\" class=\"content\" style=\"font-size:11px\">".$v["name"]."</a>";		
				?>
			 </td>	
			 </tr>		
			<?php 			
			}
		  ?>
		   </tr>
		 </table>
	<?php	
			}		
		}
	?>