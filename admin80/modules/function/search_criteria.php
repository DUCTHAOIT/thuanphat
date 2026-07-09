<?php
	switch($op){
		case "add"			: add();break;		
		case "delete"		: delete();break;
		default				: mainShow();break;
	}
	//
	function mainShow(){
		include_once("header.php");
		global $themeName, $smarty, $lable,$db;		
		$id=getParam("id_function");
		
		if($id){
			$sql="SELECt * FROM sys_function WHERE id='$id'";
			$rs=$db->Execute($sql);	
			$catName=$rs->fields("name");
		}		
		
		$smarty->assign('id_function',$id);
		$smarty->assign('Username_technical',$lable->_("Username technical"));
		$smarty->assign('Technical',$lable->_("Technical"));
		$smarty->assign('more_technical_early_entry',$lable->_("more technical early entry"));
		
		$smarty->assign('catName',$catName);
		$smarty->assign('technicalList',technicalList($id));
		$smarty->assign('frmEdit',frmEdit());		
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/function_search_criteria.tpl','function_search_criteria_');
		
		include_once("footer.php");
	}
	//
	function add(){
		global $db;
		$technical=getParamPost("technical");				
		$order_number=getParamPost("order_number");
		$logo=getParamPost("logo");
			
		$id_technical=getParamPost("id_technical");	
		$id_function=trim(getParamPost("id_function"));				
		
		if($id_technical){			
			$arrID=getParamPost("id");			
			if($arrID){				
				foreach ($arrID as $key=>$value)
				{
					if((!$value) AND ($technical[$key]))
					{						
						$sql="INSERT INTO sys_product_search (catID,parent,name,order_number,logo) VALUES ('$id_function','$id_technical','".$technical[$key]."','".$order_number[$key]."','".$logo[$key]."')";
						$db->Execute($sql);						
					}
					elseif($value)
					{						
						$sql="UPDATE sys_product_search SET name='".$technical[$key]."', order_number='".$order_number[$key]."', logo='".$logo[$key]."' WHERE (id='".$value."')";
						$db->Execute($sql);						
					}					
				}
			}			
		}
		else{						
			if($technical)
			{
				foreach($technical as $key=>$value)
				{
					if($key==0){
						//nghi du lieu tra
						$sql="INSERT INTO sys_product_search (catID,parent,name,order_number,logo) VALUES ('$id_function','0','$value','".$order_number[$key]."','".$logo[$key]."')";		
						$db->Execute($sql);	
						$idNew=$db->Insert_ID();
					}
					elseif($value)
					{
						//nghi du lieu con
						$sql="INSERT INTO sys_product_search (catID,parent,name,order_number,logo) VALUES ('$id_function','$idNew','$value','".$order_number[$key]."','".$logo[$key]."')";		
						$db->Execute($sql);
					}
				}
			}
		}	
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=function&f=search_criteria&id_function=".$id_function;
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);		
		$a->showMsg();	
	}
	/**
	 * Danh sach thong so ky thuat
	 * $fid id chuc nang
	 * @param unknown_type $fid
	 * @return unknown
	 */
	function technicalList($fid){
		if(!$fid) return;
		global $db,$smarty;
		loadClass("menuLevel");
		$obj=new menuLevel();
		$obj->sql="SELECT * FROM sys_product_search WHERE catID='$fid' ORDER BY order_number";
		$arr=$obj->orderMenu();		
		$smarty->assign('arr',$arr);		
		$output= $smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/function_search_criteria_panel.tpl");		
		
		return $output;		
	}
	
	function frmEdit(){
		global $themeName, $smarty, $lable,$db;	
		$id_technical=getParam("id_technical");
		$id_function=getParam("id_function");
		if($id_technical){
			$sql="SELECT * FROM sys_product_search WHERE (id =  '$id_technical') OR (parent =  '$id_technical') ORDER BY parent ASC";
			$arr=$db->GetAll($sql);
		}else{
			for($i=0; $i<=5;$i++){				
				$arr[$i]=$i;
			}
		}		
		$smarty->assign('arr',$arr);
		$smarty->assign('id_function',$id_function);
		$smarty->assign('id_technical',$id_technical);
		$output= $smarty->fetch(_DOMAIN_ROOT_TEMPLATE."/function_search_criteria_form.tpl");
		return $output;
	}
	//
	function delete(){
		global $db;
		$id_technical=getParam("id_technical");		
		$id_function=getParam("id_function");		
		$sql="DELETE FROM sys_product_search WHERE (id='$id_technical') OR (parent='$id_technical')";
		$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=function&f=search_criteria&id_function=".$id_function;
		$a=new msgBox(_DELETE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);		
		$a->showMsg();
	}
?>