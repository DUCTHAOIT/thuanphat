<?php
class menuLeft{
	var $arrMenu, $arr;
	var $level=0;
	var $sql;
	
	/**
	 * 
	 * 
	 * Tra ve mot mang chua tat ca du lieu theo cau sql truyen vao
	 * Sau do goi ham sap xep va them vao mang truong co ten Level
	 * Mang duoc sap xep voi parent lam key	 * 
	 * 
	 * @param unknown_type $sql
	 * @return unknown
	 * 
	 * 
	 * 
	 */
	function getArrAll(){
		try {			
			global $db;
			if(!$this->sql) return;			
			$rs=$db->Execute($this->sql);				
			while(!$rs->EOF){				
				$parent=$rs->fields("parent");
				$id=$rs->fields("id");
				$this->arr[$parent][$id]=$rs->fields;
				$rs->MoveNext();
				
			}			
			return $this->arr;
						
		}catch (Exception $e){
			
		}		
	}
	
	/**
	 * 
	 * Lap mang tra va dua mang tra vao mang trung gian $arrMenu
	 * Goi ham de tim mang con, neu co thi dua tiep vao mang trung hian $arrMenu ngay sau tra no.
	 *
	 * @return unknown
	 * 
	 */
	
	function orderMenu(){
		$this->getArrAll();		
		if(count($this->arr)==0) return ;
		while (list($key, $value) = each($this->arr[0])) {				
		    $this->arr[0][$key]["level"]=$this->level;
		    $this->arr[0][$key]["endTree"]=count($this->arr[$key]);
		    $this->arr[0][$key]["root"]="true";
		    $this->arr[0][$key]["fid"]=$value["id"];
			$this->arrMenu[]=$this->arr[0][$key];
			$fids=$value["id"];				
			$this->subMenu($this->arr[$key],$this->level,$fids);				
			
		}
		return $this->arrMenu;
	}
	
	/**
	 * 
	 * Tim mang con, neu co thi dua tiep vao mang trung hian $arrMenu ngay sau tra no.
	 *
	 * @param unknown_type $arrSub
	 * @param unknown_type $level
	 * 
	 */
	function subMenu($arrSub,$level,$fid){		
		$level++;
		if(!$arrSub){
			return;			
		}
		while (list($key, $value) = each($arrSub)) {
			$value["level"]=$level;
			$value["endTree"]=count($this->arr[$key]);			
			$fids=$fid."_".$value["id"];
			$value["fid"]=$fids;
			
			$this->arrMenu[]=$value;			
			$this->subMenu($this->arr[$key],$level,$fids);
		}		
	}
	
}
?>
