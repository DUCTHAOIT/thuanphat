<?php
	function getCboFunction($selectID){
		global $db,$lang;
		$selectID = $selectID["selectID"];
		loadClass("menuLevel");
		$obj=new menuLevel();		
		$obj->sql="SELECT * FROM sys_function WHERE lang='$lang' ORDER BY sort ASC";
		$arr=$obj->orderMenu();		
		$strCombo = '<select id="cboFunction" name="cboFunction"><option value="0"></option>';
		foreach ($arr as $key=>$value){
			if($value["id"]==$selectID) $strCombo.='<option value="'.$value["id"].'" selected="selected" >'.space($value["level"]).$value["name"].'</option>';
			else $strCombo.='<option value="'.$value["id"].'">'.space($value["level"]).$value["name"].'</option>';
		}
		$strCombo.='</select>';
		return $strCombo;
	}
	//
	function getCboPosition($selectID){
		global $db,$lang;
		$selectID = $selectID["selectID"];		
		$sql="SELECT ctrl,name FROM sys_position WHERE lang='$lang'";
		$db->setFetchMode(ADODB_FETCH_ASSOC);		
		$arr=$db->GetAssoc($sql);
		echo "<select size=\"5\" multiple name=\"position[]\">";
		foreach ($arr as $key=>$value){
			if($key & $selectID) echo "<option value=\"".$key."\" selected=\"selected\">".$value."</option>";
			else echo "<option value=\"".$key."\">".$value."</option>";
		}
		echo "</select>";
	}
	//
	function space($level){		
		$str="";
		if($level > 0){
			for($i=0; $i<=$level+5; $i++){
				$str.="-";
			}
			return $str;
		}
		return $str;
	}
	//
function Update(){
    global $db,$lang;
    include_once("modules/function/url.php");

    $id=getParamPost("id");

    $parent=getParamPost("cboFunction");

    $sql="SELECT parent FROM sys_function WHERE id = '$parent'";
    $rs=$db->Execute($sql);
    $parentroot=$rs->fields("parent");

    $name=trim(getParamPost("name"));
    //$des=getParamPost("des");
    $des=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
    //$des=str_replace("'","&#8217;",$des);// bo dau phay tren
    $moduleName=getParamPost("module");
    $order=getParamPost("order");
    $action=getParamPost("action");
    $focus=getParamPost("focus");
    if(!$focus){ $focus=0; }
    $lang=getParamPost("lang");
    $theme=getParamPost("theme");
    $position=getParamPost("position");
    $security=getParamPost("security");
    $fileName=getParamPost("fileName");
    $fileName2=getParamPost("fileName2");

    $title=getParamPost("title");
    $description=getParamPost("description");
    $keywords=getParamPost("keywords");

    if($position){
        foreach ($position as $key=>$value){
            $ctrl+=(int)$value;
        }
    }
    $ctrl+=(int)$action + (int)$security;


    $txtModuleName=getParamPost("txt_".$moduleName);

    $sourcefile=_DOMAIN_ROOT_PATH."/temp/".$fileName;
    if(file_exists($sourcefile)){
        $from=$sourcefile;
        $to=_DOMAIN_ROOT_PATH."/images/function/".$fileName;
        moveFile($from,$to);
    }
    $sourcefile=_DOMAIN_ROOT_PATH."/temp/".$fileName2;
    if(file_exists($sourcefile)){
        $from=$sourcefile;
        $to=_DOMAIN_ROOT_PATH."/images/function/".$fileName2;
        moveFile($from,$to);
    }

    loadClass("convertStringMenu");
    $converString=new convertStringMenu();

    if(!$id){
        $sql="INSERT INTO sys_function (name,parent,des,sort,focus,ctrl,lang,img1,img2,module,id_htmlpage,theme, title, description, keywords)";
        $sql.=" VALUES('$name','$parent','$des','$order','$focus','$ctrl','$lang','$fileName','$fileName2','$moduleName'," . (empty($txtModuleName) ? "NULL" : "'$txtModuleName'") . ",'$theme', '$title','$description','$keywords')";
        $return=$db->Execute($sql);
        $idNew=$db->Insert_ID();

        //####xac dunh url
        //Xac dinh htaccess
        //if($parent>0){
        if($parent==0){
            $sql="SELECT name as htaccess FROM sys_function WHERE id =  '$idNew'";
            $rs=$db->Execute($sql);
            $htaccess=$lang."/".strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";

            $url="?m=".$moduleName."&idF=".$idNew;
        }else{
            $sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$idNew')) as htaccess";
            $sql.=" FROM sys_function";
            $sql.=" WHERE id = '$parent'";
            $rs=$db->Execute($sql);
            $htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";

            $url="?m=".$moduleName."&idF=".$parent.'_'.$idNew;
            //$url="?m=".$moduleName."&idF=".$parent;
        }
        /*
        $sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$idNew')) as htaccess";
        $sql.=" FROM sys_function";
        if($parent>0){
        $sql.=" WHERE id = '$parent'";
        }
        $rs=$db->Execute($sql);
        $htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";


        //xac dinh URL
        //$url="?m=".$moduleName."&idF=".$idNew;
        //	$url="?m=".$moduleName."&idsub=".$parent."&idF=".$idNew;
        if($parent==0){
        $url="?m=".$moduleName."&idF=".$idNew;
        }else{
            $url="?m=".$moduleName."&idF=".$parent.'_'.$idNew;
            //$url="?m=".$moduleName."&idF=".$parent;
        }
        */

        if($txtModuleName){
            $url.="&id_$moduleName=$txtModuleName";
        }
        $url.="&";
        //cap nhat vao base
        $sql = "UPDATE sys_function SET";
        $sql.=" htaccess='$htaccess', url='$url' WHERE id='$idNew'";
        $db->Execute($sql);

        $sql="SELECT * FROM sys_config WHERE (name='rewrite_url')";
        $rs=$db->Execute($sql);

        if($rs->fields('value')=="htaccess"){
            $content="\nRewriteRule ^$htaccess"."(.*)  ". $url."id=$1";
            fwriteFile($content);
        }
        //}
    }
    else
    {
        $sql = "UPDATE sys_function SET";
        $sql.=" name='$name', parent='$parent', des='$des', sort='$order', focus='$focus', ctrl='$ctrl', lang='$lang', img1='$fileName', img2='$fileName2',module='$moduleName', id_htmlpage=" . (empty($txtModuleName) ? "NULL" : "'$txtModuleName'") . ", theme='$theme',title='$title',description='$description',keywords='$keywords' WHERE id=$id";
        $db->Execute($sql);

        //if($parent>0){
        //	$sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$id')) as htaccess";
        //	$sql.=" FROM sys_function";
        //	if($parent>0){
        //	$sql.=" WHERE id = '$parent'";
        //	}
        //	$rs=$db->Execute($sql);

        //	$htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";
        //}
        //else
        //{
        //	$htaccess="/";
        //}

        //xac dinh URL


        //if($parent==0){
        //$url="?m=".$moduleName."&idF=".$id;
        //}else{
        //$url="?m=".$moduleName."&idF=".$parent.'_'.$id;
        //$url="?m=".$moduleName."&idF=".$parent;
        //}
        if($parent==0){
            $sql="SELECT name as htaccess FROM sys_function WHERE id =  '$id'";
            $rs=$db->Execute($sql);
            $htaccess=$lang."/".strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";

            $url="?m=".$moduleName."&idF=".$id;
        }else{
            $sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$id')) as htaccess";
            $sql.=" FROM sys_function";
            $sql.=" WHERE id = '$parent'";
            $rs=$db->Execute($sql);
            $htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";

            $url="?m=".$moduleName."&idF=".$parent.'_'.$id;
            //$url="?m=".$moduleName."&idF=".$parent;
        }

        if($txtModuleName){
            $url.="&id_$moduleName=$txtModuleName";
        }
        $url.="&";

        $sql = "UPDATE sys_function SET";
        $sql.=" htaccess='$htaccess', url='$url' WHERE id='$id'";
        $db->Execute($sql);

        $sql="SELECT * FROM sys_config WHERE (name='rewrite_url')";
        $rs=$db->Execute($sql);

        if($rs->fields('value')=="htaccess"){
            $file=_DOMAIN_ROOT_PATH."/htaccess.txt";
            $newfile=_DOMAIN_ROOT_PATH."/.htaccess";
            if (!copy($file, $newfile)) {
                echo "failed to copy $file...\n";
            }
            $sql="SELECT id,url,htaccess FROM sys_function";
            $arr=$db->GetAssoc($sql);
            foreach($arr as $key=>$value){
                if(strlen($value["htaccess"])>2){
                    $content="\nRewriteRule ^".$value["htaccess"]."(.*) ".$value["url"]."id=$1";
                    fwriteFile($content);
                }
            }
        }
    }
    include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
    $ret_page="?m=function";
    $a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);
    $a->showMsg();
}
	//
	function Update_2025(){
		global $db,$lang;
		include_once("modules/function/url.php");
		
		$id=getParamPost("id");
		
		$parent=getParamPost("cboFunction");
		
		$sql="SELECT parent FROM sys_function WHERE id = '$parent'";
		$rs=$db->Execute($sql);	
		$parentroot=$rs->fields("parent");		
		
		$name=trim(getParamPost("name"));
		//$des=getParamPost("des");
		$des=str_replace("'","&#8217;",getParamPost("content"));// bo dau phay tren
		//$des=str_replace("'","&#8217;",$des);// bo dau phay tren
		$moduleName=getParamPost("module");
		$order=getParamPost("order");
		$action=getParamPost("action");	
		$focus=getParamPost("focus");		
		$lang=getParamPost("lang");
		$theme=getParamPost("theme");
		$position=getParamPost("position");
		$security=getParamPost("security");
		$fileName=getParamPost("fileName");
		$fileName2=getParamPost("fileName2");
		
		$title=getParamPost("title");
		$description=getParamPost("description");
		$keywords=getParamPost("keywords");
		
		if($position){			
			foreach ($position as $key=>$value){
				$ctrl+=(int)$value;
			}
		}		
		$ctrl+=(int)$action + (int)$security;		
		
		
		$txtModuleName=getParamPost("txt_".$moduleName);				
		
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$fileName;
		if(file_exists($sourcefile)){
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/images/function/".$fileName;
			moveFile($from,$to);			
		}
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$fileName2;
		if(file_exists($sourcefile)){
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/images/function/".$fileName2;
			moveFile($from,$to);			
		}		
		
		loadClass("convertStringMenu");
		$converString=new convertStringMenu();
		
		if(!$id){			
			$sql="INSERT INTO sys_function (name,parent,parentroot,des,sort,focus,ctrl,lang,img1,img2,module,id_htmlpage,theme, title, description, keywords)";
			$sql.=" VALUES('$name','$parent','$parentroot','$des','$order','$focus','$ctrl','$lang','$fileName','$fileName2','$moduleName','$txtModuleName','$theme', '$title','$description','$keywords')";
			$return=$db->Execute($sql);
			$idNew=$db->Insert_ID();
			
			//####xac dunh url
			//Xac dinh htaccess
			//if($parent>0){
				if($parent==0){		
					$sql="SELECT name as htaccess FROM sys_function WHERE id =  '$idNew'";
					$rs=$db->Execute($sql);			
					$htaccess=$lang."/".strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";
					
					$url="?m=".$moduleName."&idF=".$idNew;
				}else{
					$sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$idNew')) as htaccess";
					$sql.=" FROM sys_function";
					$sql.=" WHERE id = '$parent'";
					$rs=$db->Execute($sql);			
					$htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";
				
					$url="?m=".$moduleName."&idF=".$parent.'_'.$idNew;
					//$url="?m=".$moduleName."&idF=".$parent;
				}
				/*
				$sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$idNew')) as htaccess";
				$sql.=" FROM sys_function";
				if($parent>0){
				$sql.=" WHERE id = '$parent'";
				}	
				$rs=$db->Execute($sql);			
				$htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";
					
			
				//xac dinh URL
				//$url="?m=".$moduleName."&idF=".$idNew;			
				//	$url="?m=".$moduleName."&idsub=".$parent."&idF=".$idNew;
				if($parent==0){			
				$url="?m=".$moduleName."&idF=".$idNew;
				}else{
					$url="?m=".$moduleName."&idF=".$parent.'_'.$idNew;
					//$url="?m=".$moduleName."&idF=".$parent;
				}	
				*/
				
				if($txtModuleName){
					$url.="&id_$moduleName=$txtModuleName";								
			 	}
			 	$url.="&";
				//cap nhat vao base
				$sql = "UPDATE sys_function SET";
				$sql.=" htaccess='$htaccess', url='$url' WHERE id='$idNew'";
				$db->Execute($sql);
				
			 	$sql="SELECT * FROM sys_config WHERE (name='rewrite_url')";
				$rs=$db->Execute($sql);
				
				if($rs->fields('value')=="htaccess"){	
					$content="\nRewriteRule ^$htaccess"."(.*)  ". $url."id=$1";
					fwriteFile($content);
				}
			//}			
		}
		else
		{			
			$sql = "UPDATE sys_function SET";
			$sql.=" name='$name', parent='$parent', parentroot='$parentroot', des='$des', sort='$order', focus='$focus', ctrl='$ctrl', lang='$lang', img1='$fileName', img2='$fileName2',module='$moduleName', id_htmlpage='$txtModuleName', theme='$theme',title='$title',description='$description',keywords='$keywords' WHERE id=$id";
			$db->Execute($sql);
			
			//if($parent>0){
			//	$sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$id')) as htaccess";
			//	$sql.=" FROM sys_function";
			//	if($parent>0){
			//	$sql.=" WHERE id = '$parent'";
			//	}	
			//	$rs=$db->Execute($sql);			

			//	$htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";
			//}
			//else 
			//{
			//	$htaccess="/";
			//}			
			
			//xac dinh URL
			
			
			//if($parent==0){			
			//$url="?m=".$moduleName."&idF=".$id;
			//}else{
			//$url="?m=".$moduleName."&idF=".$parent.'_'.$id;
				//$url="?m=".$moduleName."&idF=".$parent;
			//}	
			if($parent==0){	
				$sql="SELECT name as htaccess FROM sys_function WHERE id =  '$id'";
				$rs=$db->Execute($sql);			
				$htaccess=$lang."/".strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";
					
				$url="?m=".$moduleName."&idF=".$id;
			}else{
				$sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$id')) as htaccess";
				$sql.=" FROM sys_function";
				$sql.=" WHERE id = '$parent'";
				$rs=$db->Execute($sql);			
				$htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";
				
				$url="?m=".$moduleName."&idF=".$parent.'_'.$id;
				//$url="?m=".$moduleName."&idF=".$parent;
			}
			
			if($txtModuleName){
				$url.="&id_$moduleName=$txtModuleName";								
		 	}
		 	$url.="&";
		 	
		 	$sql = "UPDATE sys_function SET";
			$sql.=" htaccess='$htaccess', url='$url' WHERE id='$id'";
			$db->Execute($sql);

			$sql="SELECT * FROM sys_config WHERE (name='rewrite_url')";
			$rs=$db->Execute($sql);
			
			if($rs->fields('value')=="htaccess"){				 
				$file=_DOMAIN_ROOT_PATH."/htaccess.txt";				
				$newfile=_DOMAIN_ROOT_PATH."/.htaccess";
				if (!copy($file, $newfile)) {
				    echo "failed to copy $file...\n";
				}
				$sql="SELECT id,url,htaccess FROM sys_function";
				$arr=$db->GetAssoc($sql);
				foreach($arr as $key=>$value){
					if(strlen($value["htaccess"])>2){
						$content="\nRewriteRule ^".$value["htaccess"]."(.*) ".$value["url"]."id=$1";
						fwriteFile($content);						
					}
				}
			}
		}				
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=function";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);		
		$a->showMsg();		
	}
	//
	//
	function UpdateOld(){
		global $db,$lang;
		include_once("modules/function/url.php");
		
		$id=getParamPost("id");
		
		$parent=getParamPost("cboFunction");
		$name=trim(getParamPost("name"));
		$des=getParamPost("des");
		//$des=str_replace("'","&#8217;",$des);// bo dau phay tren
		$moduleName=getParamPost("module");
		$order=getParamPost("order");
		$action=getParamPost("action");	
		$focus=getParamPost("focus");		
		$lang=getParamPost("lang");
		$position=getParamPost("position");
		$fileName=getParamPost("fileName");
		$fileName2=getParamPost("fileName2");
		
		if($position){			
			foreach ($position as $key=>$value){
				$ctrl+=(int)$value;
			}
		}		
		$ctrl+=(int)$action + (int)$security;		
		
		
		$txtModuleName=getParamPost("txt_".$moduleName);				
		
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$fileName;
		if(file_exists($sourcefile)){
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/images/function/".$fileName;
			moveFile($from,$to);			
		}
		$sourcefile=_DOMAIN_ROOT_PATH."/temp/".$fileName2;
		if(file_exists($sourcefile)){
			$from=$sourcefile;
			$to=_DOMAIN_ROOT_PATH."/images/function/".$fileName2;
			moveFile($from,$to);			
		}		
		
		loadClass("convertStringMenu");
		$converString=new convertStringMenu();
		
		if(!$id){			
			$sql="INSERT INTO sys_function (name,parent,des,sort,focus,ctrl,lang,img1,img2,module)";
			$sql.=" VALUES('$name','$parent','$des','$order','$focus','$ctrl','$lang','$fileName','$fileName2','$moduleName')";
			$return=$db->Execute($sql);
			$idNew=$db->Insert_ID();
			
			//####xac dunh url
			//Xac dinh htaccess
			//if($parent>0){
				$sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$idNew')) as htaccess";
				$sql.=" FROM sys_function";
				if($parent>0){
				$sql.=" WHERE id = '$parent'";
				}	
				$rs=$db->Execute($sql);			
				$htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";
					
			
				//xac dinh URL
				//$url="?m=".$moduleName."&idF=".$idNew;			
				//	$url="?m=".$moduleName."&idsub=".$parent."&idF=".$idNew;
				if($parent==0){			
				$url="?m=".$moduleName."&idF=".$idNew;
				}else{
					$url="?m=".$moduleName."&idF=".$parent.'_'.$idNew;
					//$url="?m=".$moduleName."&idF=".$parent;
				}	
				
				if($txtModuleName){
					$url.="&id_$moduleName=$txtModuleName";								
			 	}
			 	$url.="&";
				//cap nhat vao base
				$sql = "UPDATE sys_function SET";
				$sql.=" htaccess='$htaccess', url='$url' WHERE id='$idNew'";
				$db->Execute($sql);
				
			 	$sql="SELECT * FROM sys_config WHERE (name='rewrite_url')";
				$rs=$db->Execute($sql);
				
				if($rs->fields('value')=="htaccess"){	
					$content="\nRewriteRule ^$htaccess"."(.*)  ". $url."\$1";
					fwriteFile($content);
				}
			//}			
		}
		else
		{			
			$sql = "UPDATE sys_function SET";
			$sql.=" name='$name', parent='$parent', des='$des', sort='$order', focus='$focus', ctrl='$ctrl', lang='$lang', img1='$fileName', img2='$fileName2',module='$moduleName'  WHERE id=$id";
			$db->Execute($sql);
			
			//if($parent>0){
				$sql="SELECT CONCAT(name,'/', (SELECT name FROM sys_function WHERE id =  '$id')) as htaccess";
				$sql.=" FROM sys_function";
				if($parent>0){
				$sql.=" WHERE id = '$parent'";
				}	
				$rs=$db->Execute($sql);			
				$htaccess=strtolower($converString->remoteDiacritic($rs->fields("htaccess")))."/";
			//}
			//else 
			//{
			//	$htaccess="/";
			//}			
			
			//xac dinh URL
			
			
			if($parent==0){			
			$url="?m=".$moduleName."&idF=".$id;
			}else{
			$url="?m=".$moduleName."&idF=".$parent.'_'.$id;
				//$url="?m=".$moduleName."&idF=".$parent;
			}	
			if($txtModuleName){
				$url.="&id_$moduleName=$txtModuleName";								
		 	}
		 	$url.="&";
		 	
		 	$sql = "UPDATE sys_function SET";
			$sql.=" htaccess='$htaccess', url='$url' WHERE id='$id'";
			$db->Execute($sql);

			$sql="SELECT * FROM sys_config WHERE (name='rewrite_url')";
			$rs=$db->Execute($sql);
			
			if($rs->fields('value')=="htaccess"){				 
				$file=_DOMAIN_ROOT_PATH."/htaccess.txt";				
				$newfile=_DOMAIN_ROOT_PATH."/.htaccess";
				if (!copy($file, $newfile)) {
				    echo "failed to copy $file...\n";
				}
				$sql="SELECT id,url,htaccess FROM sys_function";
				$arr=$db->GetAssoc($sql);
				foreach($arr as $key=>$value){
					if(strlen($value["htaccess"])>7){
						$content="\nRewriteRule ^".$value["htaccess"]."(.*) ".$value["url"]."\$1";
						fwriteFile($content);						
					}
				}
			}
		}				
		include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
		$ret_page="?m=function";
		$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);		
		$a->showMsg();		
	}
	//
	function getFunctionList(){
		global $db,$lang;		
		loadClass("menuLevel");
		$obj=new menuLevel();		
		$obj->sql="SELECT * FROM sys_function WHERE lang='$lang' ORDER BY sort ASC";
		$arr=$obj->orderMenu();	
		return $arr;
	}
	//
	function getPosition(){
		global $db,$lang;
		$sql="SELECT ctrl,name FROM sys_position WHERE lang='$lang'";
		$db->setFetchMode(ADODB_FETCH_ASSOC);
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	function getFunctionID($FuncID){
		if(!$FuncID) return;
		global $db,$lang;
		$sql="SELECT * FROM sys_function WHERE (id=$FuncID) AND (lang='$lang')";
		$rs=$db->Execute($sql);
		$arr=$rs->fields;
		return $arr;
	}
	//
	function deleteFunction($funcID){		
		global $db;
		$sql="DELETE FROM sys_function WHERE id=$funcID";
		$return=$db->Execute($sql);
		if($return) return true;
		else return false;
	}
	/**
	 * ghi url ra file htaccess
	 * $content noi dung can ghi
	 * @param unknown_type $content
	 */
	function fwriteFile($content){		
		$fileName = '.htaccess';
		if(is_writable(_DOMAIN_ROOT_PATH."/".$fileName)){			
			if (!$handle = fopen(_DOMAIN_ROOT_PATH."/".$fileName, 'a')) {
				 echo "Cannot open file ($fileName)";
				 exit;
			}			
			if (fputs($handle, $content) === FALSE) {
				echo "Cannot write to file ($fileName)";
				exit;
			}			
			fclose($handle);		
		} else {
			echo "The file $fileName is not writable";
		}		
	}
?>