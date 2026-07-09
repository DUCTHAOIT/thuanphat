<?php
	function getPageList(){
		global $db;		
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_page";		
		$obj->orderBy="name";
		$sql=$obj->sqlSelect();						
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function getBlockOnPageList($pid,$pos){
		global $db;		
		$sql="SELECT sys_block_page.*, sys_block.path, sys_block.name, sys_block.des FROM sys_block_page , sys_block WHERE (sys_block_page.pgid =  '$pid') AND (sys_block_page.position & $pos=$pos) AND (sys_block_page.blid =  sys_block.id) ORDER BY soft";		
		//echo $sql;
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	function getPath(){
		global $db,$lable,$arrPosition;
		$pid=getParam("pid");
		$pos=getParam("pos");
		$sql="SELECT des FROM sys_page WHERE id=$pid";		
		$rs=$db->Execute($sql);	
		$path=$rs->fields("des");
		$path.=" / " . $lable->_($arrPosition[$pos]);		
		echo $path;
	}
	//
	function addBlock(){
		global $db, $lable;
		$pos=getParamPost("pos");
		$des=trim(getParamPost("des"));
		$content=getParamPost("content");
		$langID=getParamPost("lang");
		$id=getParamPost("id");		
		loadClass("convertString");
		$obj= new convertString;
		//Ghi du lieu vao base
		$record=array();
		if(!$id){			
			$name= $obj->remoteDiacritic($des)."_". date("Ymd")."_".$langID;
			$path="modules/block/".$name.".php";
			$record["name"]=$name;
			$record["position"]=$pos;
			$record["path"]=$path;		
			$record["des"]=$des;
			$record["lang"]=$langID;
			$record["ctrl"]=1;			
			$sql = "SELECT * FROM sys_block WHERE 0 = -1";
			$rs = $db->Execute($sql);
			$sql = $db->GetInsertSQL($rs, $record);			
			$return=$db->Execute($sql);
		}else{			
			$sql = "SELECT * FROM sys_block WHERE id=$id";
			$rs = $db->Execute($sql);						
			$name=$rs->fields("name");
			$path=$rs->fields("path");
			$record["des"]=$des;
			$record["lang"]=$langID;			
			$sql = $db->GetUpdateSQL($rs, $record);
			$db->Execute($sql);	
		}
		
		$content_file="<?php function ".$name."(){ ?>\n";		
		$content_file.=$content;
		$content_file.="\n<?php }?>";		
		//ghi vao file
		$path = _DOMAIN_ROOT_PATH."/".$path;
		if ($handle = fopen($path, 'w+')) {
			fwrite($handle, $content_file);
			fclose($handle); 
		}else{
			die($lable->_("Cannot write file"));
		}		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=block&op=blockList";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);		
		$a->showMsg();		
	}
	//
	function getBlockList(){
		global $db,$lang;
		
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_block";		
		$obj->fieldsName="*, DATE_FORMAT(date, '".format_date()."') as date";
		$obj->orderBy="id DESC";
		$sql=$obj->sqlSelect();			
		$arr=$db->GetAssoc($sql);		
		return $arr;
	}
	//
	function getBlockID($id){
		global $db,$lang;		
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_block";		
		$obj->fieldsName="*, DATE_FORMAT(date, '".format_date()."') as date";
		$obj->orderBy="id DESC";
		$obj->where="id='$id'";
		$sql=$obj->sqlSelect();	
		$rs=$db->Execute($sql);		
		$arr=$rs->fields;
		return $arr;
	}
	//
	function getContentBlock($path,$nameBlock){		
		if (file_exists($path)){ 
			$fd = @fopen("$path", "rb");
			if($fd){
				$content = fread($fd, filesize($path));
			}	
		    @fclose($fd);		  
		    $vowels = array("<?php function $nameBlock(){ ?>", "<?php }?>"); 
		    $content = str_replace($vowels, "", $content); 	
	   }	   
	   return $content;
	}
	//
	function blockDelete(){
		global $db;
		
		loadClass("fileSystem");
		$obj=new fileSystem();
		
		$id=getParamPost("id");
		
		//xoa file tren server
		$sql="SELECT path, name FROM sys_block WHERE id=".$id;
		$rs=$db->Execute($sql);
		$obj->delFile(_DOMAIN_ROOT_PATH."/".$rs->fields("path"));
		
		//xoa block trong bang sys_block
		$sql="DELETE FROM sys_block WHERE id=".$id;
		$db->Execute($sql);
		
		// xoa block trong bang sys_block_page
		$sql="DELETE FROM sys_block_page WHERE blid=".$id;
		$db->Execute($sql);
		
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");		
		$ret_page="?m=block&op=blockList";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);		
		$a->showMsg();
	}
	//
	function getBlockPosition($pos){
		global $db,$lang;		
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_block";		
		$obj->fieldsName="id,des";
		if($pos <=4) $obj->where="position&2=2 OR position&4=4";
		else $obj->where="position&$pos=$pos";
		$obj->orderBy="id DESC";		
		$sql=$obj->sqlSelect();	
		$arr=$db->GetAssoc($sql);		
		//print_r($arr);		
		return $arr;
	}
	//
	function addBlockOnPage(){
		global $db,$lang, $lable;
		$blockID=getParamPost("blockID");
		//thu tu hien thi
		$order=getParamPost("order");
		//vi tri hien thi
		$pos=getParamPost("pos");
		// chi so trang hien thi
		$pid=getParamPost("pid");
		
		$sql="SELECT * FROM sys_block_page WHERE blid='$blockID' AND pgid='$pid'";
		$arr=$db->GetAssoc($sql);
		if(!$arr){			
			$sql="INSERT INTO sys_block_page(blid, pgid, ctrl, position, soft) VALUES ('$blockID','$pid', 1, '$pos', '$order')";		
			$return=$db->Execute($sql);
			if(!$return) die($lable->_("Cannot create block"));			
			blockListOnPage();		
		}else die($lable->_("Block exist"));		
	}
	//
	function deleteBlockOnPage($id){
		global $db,$lang,$lable;		
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_block_page";				
		$obj->where="id=$id";
		$obj->limit="all";
		$sql=$obj->sqlDelete();
		$return=$db->Execute($sql);
		if(!$return) die($lable->_("Cannot delete block"));
		blockListOnPage();
	}
	//
	function orderBlock(){
		global $db;
		$pid=getParamPost("pid");
		$pos=getParamPost("pos");
		$id=getParamPost("id");
		$type=getParam("type");
		
		$arr=getBlockOnPageList($pid,$pos);
		$i=1;
		foreach($arr as $key=>$value){			
			$order[$i]["id"]=$key;
			$order[$i]["soft"]=$i;
			if($key==$id) $j=$i;
			$i++;
		}
		$tam=$order[$j]["soft"];
		if($type=="down"){
			$order[$j]["soft"]=(int)$order[$j+1]["soft"];
			if($order[$j+1]) $order[$j+1]["soft"]=$tam;
		}else{
			if(!(int)$order[$j-1]["soft"]) $order[$j]["soft"]=count($order)+1;
			else $order[$j]["soft"]=(int)$order[$j-1]["soft"];
			if($order[$j-1]) $order[$j-1]["soft"]=$tam;			
		}
		
		foreach($order as $key=>$value){
			$sql="UPDATE sys_block_page SET soft=".$value["soft"] ." WHERE id=". $value["id"];			
			$db->Execute($sql);
			//echo $sql."<br>";
		}
		blockListOnPage();
	}
	//
	function callLock(){
		global $db,$lang,$lable;		
		$id=getParam("id");		
		$sql="UPDATE sys_block_page SET ctrl=IF(ctrl=0,1,0) WHERE  id=$id";
		$db->Execute($sql);
		$sql="SELECT ctrl FROM sys_block_page WHERE  id=$id";
		$rs=$db->Execute($sql);
		echo "<img src=\"images/".$rs->fields("ctrl").".gif\" style=\"cursor:pointer\" />";
	}
?>