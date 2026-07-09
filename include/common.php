<?php
	include_once("admin80/include/configSystem.php");		
	
	include_once(_DOMAIN_ROOT_PATH."/admin80/include/configDatabase.php");
	include_once(_DOMAIN_ROOT_PATH."/adodb5/adodb.inc.php");

	$db=dbConnect($DATABASE_HOST,$DATABASE_NAME,$DATABASE_USER,$DATABASE_PASSWORD);
	initConfig();
	
	$themeName=getSession("theme");
	define('_DOMAIN_ROOT_TEMPLATE',_DOMAIN_ROOT_PATH.'/theme/'.$themeName.'/templates');
	include_once(_DOMAIN_ROOT_PATH."/include/configSmarty.php");
	
	
	function dbConnect( $host='localhost', $dbname, $user='root', $passwd='', $persist=false ) {
		global $db, $ADODB_FETCH_MODE;
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		$db = newADOConnection('mysqli');
		$db->autoRollback = true;
		
		if ($persist){
	        $db->PConnect($host, $user, $passwd, $dbname)
			or die( 'FATAL ERROR: Connection to database server failed' );
		}else{
	        $db->connect($host, $user, $passwd, $dbname)
			or die( 'FATAL ERROR: Connection to database server failed!' );
		}
	        $db->Execute("SET NAMES 'utf8'");

//        $result = $db->execute("SELECT * FROM hang_san_xuat");
//        if ($result === false) die("failed");

	    return $db;
	}
	//lay gia tri tren duong truyen theo 2 phuong thuc POST,GET
	function getParam($param_name){	
		$param_value = "";
		if(isset($_POST[$param_name]))
			$param_value = $_POST[$param_name];
		else if(isset($_GET[$param_name]))
			$param_value = $_GET[$param_name];
		return trim($param_value);
	}
	/**
	 * Khoi tao seccsion trong ban sys_config
	 *
	 */
	function initConfig(){
		global $db;
		if(getSession("web_title")) return;				
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_config";		
		$obj->limit="all";
		$sql=$obj->sqlSelect();		
		$arr=$db->GetAssoc($sql);
		if(!count($arr))die("Session error!");
		foreach($arr as $key=>$value){
			setSession($key,$value["value"]);
		}		
	}
	/**
	 * 
	 * lay gia tri tren duong truyen theo 2 phuong thuc POST,GET
	 *
	 * @param unknown_type $param_name
	 * @return unknown
	 */
	function getParamPost($param_name){	
		return $_POST[$param_name];
	}
	
	/**
	 * 
	 * dua gia tri vao session
	 *
	 * @param unknown_type $param_name
	 * @param unknown_type $param_value
	 */ 
	function setSession($param_name, $param_value){
		if (isset($_SESSION[_PREFIX.$param_name]))
				unset($_SESSION[_PREFIX.$param_name]);
		$_SESSION[_PREFIX.$param_name] = $param_value;
	}
	
	/**
	 * 
	 * lay gia tri trong session
	 *
	 * @param unknown_type $param_name
	 * @return unknown
	 */
	function getSession($param_name){ 
		if (isset($_SESSION[_PREFIX.$param_name])) $param_value = $_SESSION[_PREFIX.$param_name];
		else $param_value="";
		return $param_value;
	}
	/**
	 * Nap file class
	 *
	 * @param unknown_type $filename
	 */
	function loadClass($filename){
		$pathFolder=explode("::", $filename);	
		if(count($pathFolder)>1){
			foreach($pathFolder as $key=>$value) 
			$path.=$pathFolder[$key]."/";	
			$filename = substr(trim($path), 0, (strlen($path)-1));
		}
		else{
			$filename="classes/".$filename;
		}
		$filename.=".class.php";
		@include_once(_DOMAIN_ROOT_PATH."/".$filename);
	}		
	//
	function format_date(){
		global $lang;
		if($lang=="vn") $formatDate="%d/%m/%Y";
		
		else  $formatDate="%m/%d/%Y";
		return $formatDate;
	}	
	//
	function format_number($number){
		global $lang;
		$number=$number["number"];
		if($number==0) return;
		if($lang=="vn"){
			return number_format($number, 0, '.', ',')."đ";	
		}elseif($lang=="en"){
			return "\$ ".number_format($number, 0, '.', ',');
		}
	}
	function format_number2($number){
		global $lang;
		$number=$number["number"];
		if($number==0) return;
		if($lang=="vn"){
			return number_format($number, 0, '.', ',')."";	
		}elseif($lang=="en"){
			return "\$ ".number_format($number, 0, '.', ',');
		}
	}
	
	//lay gia tri bien lang trong session neu khong co default=vn
	function getLang(){
		$lang = getSession("lang_id");
		if (!strlen($lang)){
			$lang = "vn";			
		}
		return $lang;
	}
	//
	function setLang($lang=""){
		global $db;
		if(!$lang) return;
		$sql="SELECT * FROM sys_language WHERE `key`='$lang'";
		$rs=$db->Execute($sql);
		if($rs->fields("key")) setSession("lang_id",$lang);
	}
	//
	//
	function get_more_menu()
	{
		global $db,$arr_info_page,$smarty,$lang;		
		$sql="SELECT id,parent,name,htaccess as url FROM sys_function WHERE (lang='$lang') AND ctrl&65=65 ORDER BY sort";
		$arr=$db->GetAssoc($sql);
		return $arr;
	}
	//
	//
	function getTopMenu(){
		global $db,$arr_info_page,$smarty;		
		
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="id,parent,name,url,htaccess";
		$obj->tableName="sys_function";		
		$obj->where="ctrl&9=9";
		$obj->orderBy="sort";
		$obj->limit="all";
		$sql=$obj->sqlSelect();
		$rs=$db->Execute($sql);
		
		$arr[0][0]["parent"]=0;
		$arr[0][0]["name"]="TRANG CHỦ";
		$arr[0][0]["htaccess"]='';
		
		while(!$rs->EOF)
		{
			$parent=$rs->fields("parent");
			$arr[$parent][]=$rs->fields;
			$rs->MoveNext();
		}	
		
		//print_r($arr[0]);
		// hien thi menu cap 1
		
		$str_menu_level_0 = '<div class="div_tab_top" id="div_tab" style="clear: right;">';
		$str_menu_level_0.= '<ul>';		
			
		$str_menu_level_1='<div class="tab_content" id="tab_content">';
		$str_menu_level_1.='<ul style="margin-left: 0px;"></ul>';
		$str_menu_level_1.='</div>';
		
		$i=1;
		$number_menu_level_0=count($arr[0]);
		
		$url=getSession("rewrite_url");
		$select_tab=1;
		
		//$str_menu_level_0.='<li id="tab_1" onclick="changtab(1,5)" onmouseover="changtab(1,5,1)" onmouseout="mouseout(1,5)">';
		//$str_menu_level_0.='<a href="#"><span>Home</span></a>';
		//$str_menu_level_0.='</li>';
			
		foreach($arr[0] as $key=>$value)
		{
			//echo $value["name"]."<br>";
			// select tab menu top
			if($arr_info_page["parent"]==$value["id"])
			{
				$select_tab = $i;				
			}			
			//
			if(strlen($value["htaccess"])>3){
				$url_level_0= $value["htaccess"];
			} 
			else {$url_level_0="#";};
			
			$str_menu_level_0.='<li id="tab_'.$i.'" onclick="changtab('.$i.','.$number_menu_level_0.')" onmouseover="changtab('.$i.','.$number_menu_level_0.',1)" onmouseout="mouseout(1,'.$number_menu_level_0.')" class="tab_select">';
			$str_menu_level_0.='<a href="'._DOMAIN_ROOT_URL."/". $url_level_0 .'" class="title" style="color:#353794"><span>'.$value["name"].'</span></a>';
			$str_menu_level_0.='</li>';
			
			//str div menu level 1
			$str_menu_level_1.='<div id="content_'.$i.'" style="display: none; background: #FF0000;" class="tab_content">';
			$str_menu_level_1.='<ul style="margin-left: 0px;">';
			
			if($arr[$value["id"]])
			{				
				foreach($arr[$value["id"]] as $k=>$v)
				{					
					$str_menu_level_1.='<li><a href="'._DOMAIN_ROOT_URL."/".$v[$url].'"><span>'.$v["name"].'</span></a>&nbsp; &nbsp; | &nbsp; &nbsp;</li>';
				}
				$str_menu_level_1=substr($str_menu_level_1, 0, strlen($str_menu_level_1)-20);  
			}
			
			$str_menu_level_1.='</ul>';
			$str_menu_level_1.='</div>';
			
			$i++;
		}
				
		$str_menu_level_0.= '</ul>';
		$str_menu_level_0.='</div>';			
		
		$script="<script>changtab('$select_tab','$number_menu_level_0')</script>";
				
		$smarty->assign('str_menu_level_0',$str_menu_level_0);
		$smarty->assign('str_menu_level_1',$str_menu_level_1);
		$smarty->assign('script',$script);	
		
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/topMenu.tpl','topMenu_'.$themeName);		
	}
	//
	//
	function getTopMenuDuongmn(){
		global $db;		
		loadClass("constructSql");
		$obj=new constructSql();		
		$obj->tableName="sys_function";		
		$obj->where="ctrl&9=9 AND parent=0";
		$obj->orderBy="sort";
		$obj->limit="all";
		$sql=$obj->sqlSelect();			
		$arr=$db->GetAssoc($sql);
		return $arr;		
	}
	//
	//
	function get_button_menu()
	{
		global $db,$arr_info_page,$smarty;		
		
		loadClass("constructSql");
		$url=getSession("rewrite_url");
		$obj=new constructSql();		
		$obj->fieldsName="id,parent,name, img2,$url as url";
		$obj->tableName="sys_function";		
		$obj->where="ctrl&33=33";
		$obj->orderBy="sort";
		$obj->limit="all";
		$sql=$obj->sqlSelect();		
		
		loadClass("menuLevel");	
		$obj=new menuLevel();
		$obj->sql=$sql;
		
		//$sql="SELECT id, parent, name, img2, htaccess as url FROM sys_function WHERE (lang='vn') AND ctrl&32=32 ORDER BY sort";
				
		$arr=$obj->orderMenu();
		
		return $arr;
	}
	//
	function getLeftBlock(){
		global $db,$moduleName;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="sys_block.name, sys_block.path";
		$obj->fieldsLang="sys_page.";
		$obj->tableName="sys_page, sys_block_page, sys_block";		
		$obj->where="sys_page.id =  sys_block_page.pgid AND sys_block_page.blid =  sys_block.id AND sys_page.name =  '$moduleName' AND sys_block_page.`position`& 2 =  2 AND sys_block_page.ctrl=1";
		$obj->orderBy="sys_block_page.soft";
		$obj->limit="all";		
		$sql=$obj->sqlSelect();
		$arr=$db->getAssoc($sql);
		return $arr;		
	}
	//
	function getCenterBlock(){
		global $db,$moduleName;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="sys_block.name, sys_block.path";
		$obj->fieldsLang="sys_page.";
		$obj->tableName="sys_page, sys_block_page, sys_block";		
		$obj->where="sys_page.id =  sys_block_page.pgid AND sys_block_page.blid =  sys_block.id AND sys_page.name =  '$moduleName' AND sys_block_page.`position`& 16 =  16 AND sys_block_page.ctrl=1";
		$obj->orderBy="sys_block_page.soft";
		$obj->limit="all";		
		$sql=$obj->sqlSelect();		
		
		$arr=$db->GetAssoc($sql);
		return $arr;		
	}
	//
	function getRightBlock(){
		global $db,$moduleName;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="sys_block.name, sys_block.path";
		$obj->fieldsLang="sys_page.";
		$obj->tableName="sys_page, sys_block_page, sys_block";		
		$obj->where="sys_page.id =  sys_block_page.pgid AND sys_block_page.blid =  sys_block.id AND sys_page.name =  '$moduleName' AND sys_block_page.`position`& 4 =  4 AND sys_block_page.ctrl=1";
		$obj->orderBy="sys_block_page.soft";
		$obj->limit="all";
		$sql=$obj->sqlSelect();
        $db->SetFetchMode(ADODB_FETCH_ASSOC);
		$arr=$db->getAssoc($sql);
		return $arr;		
	}
	//
	function sendMail_old($From,$FromName,$To,$ToName,$Subject,$Html,$AttmFiles=""){
//	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\nFrom: ".$From."\r\nReply-to: ".$From."";	
	//$headers ="MIME-Version: 1.0\r\n";
	//$headers.="Content-type: text/html";
	//$headers.="From: ".$FromName." <".$From.">\n"; 
	//$headers.="To: ".$ToName." <".$To.">\n"; 
	//$headers.="Reply-To: ".$FromName." <".$From.">\n"; 
	
	//$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	//Messages start with text/html alternatives in OB
	// plaintext goes here	
	// html section 
		$body             = $Html;
		$body			  = str_replace("\n", "", $body);
		$order   = array("\r\n", "\n", "\r", "");
		$replace = '';
		$body = str_replace($order, $replace, $body);
		$body             = eregi_replace("[\]",'',$body);
		$order   = array("\r\n", "\n", "\r", "");
		$replace = '';
		$body = str_replace($order, $replace, $body);
	////	
	if($AttmFiles){
	 foreach($AttmFiles as $AttmFile){
	  $patharray = explode ("/", $AttmFile); 
	  $FileName=$patharray[count($patharray)-1];
	  $body.= "\n--".$OB."\n";
	  $body.="Content-Type: application/octetstream;\n\tname=\"".$FileName."\"\n";
	  $body.="Content-Transfer-Encoding: base64\n";
	  $body.="Content-Disposition: attachment;\n\tfilename=\"".$FileName."\"\n\n";
	
	  //file goes here
	  $fd=fopen ($AttmFile, "r");
	  $FileContent=fread($fd,filesize($AttmFile));
	  fclose ($fd);
	  $FileContent=chunk_split(base64_encode($FileContent));
	  $Msg.=$FileContent;
	  $Msg.="\n\n";
	 }
	}
	
	//message ends
	$Msg.="\n--".$OB."--\n";
	mail($To,$Subject,$body,$headers); 
	return true;
	//syslog(LOG_INFO,"Mail: Message sent to $ToName <$To>");
	$status=SendMail($from,$from_name, $to,$to_name, $Subject, $HTML,$ATTM);
	if($status){
		$thank="<center><font class=title style=\"padding-top:60px\">"._CONTACT_THANK_YOU."</font></center>";
		echo $thank;
		//gui thu cam on cho ngui lien he
		$from=get_config("email");
		$from_name=get_config("site_name");
		$to=$email;
		$to_name=$name;
		$Subject=get_config("site_name")." "._CONTACT_BACK_0;
		$TEXT="";
		$HTML=_CONTACT_BACK_1. " ".$name ."<br>";
		$HTML.=_CONTENT_BACK_2.get_config("site_name"). _CONTENT_BACK_3."<a href=\"http://www.".get_config("site_name")."/modules.php?module=contact \">http://www.".get_config("site_name")."/modules.php?module=contact</a> ";
		$HTML.=_CONTENT_BACK_4 . date ("d-m-YY : h:i:s A")."<br>"; 
		$HTML.="<span class=title>"._CONTENT_BACK_5."</span><br><br>";
		$HTML.=_FULL_NAME." : ".$name."<br>";
		$HTML.=_PHONE." : ". $phone."<br>";
		$HTML.=_EMAIL.": ".$email."<br>";
		$HTML.=$content;
		$ATTM="";
		SendMail($from,$from_name, $to,$to_name, $Subject, $TEXT,$HTML,$ATTM);
	}
	}
	//
	//
	function sendMail($emailFrom,$nameFrom,$emailTo,$nameTo,$subject,$content,$fileAttachment=""){			
		loadClass("phpmailer");
		$mail             = new PHPMailer();
					
		//$body           = $mail->getFile('contents.html');
		$body 			  = $content;
		$body             = eregi_replace("[\]",'',$body);
		
		$mail->IsSendmail(); // telling the class to use SendMail transport
		$mail->CharSet		= 	"UTF-8";
		$mail->From       = $emailFrom;
		$mail->FromName   = $nameFrom;			
		$mail->Subject    = $subject;
		
		//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->MsgHTML($body);
		
		$mail->AddAddress($emailTo, $nameTo);
		if($fileAttachment) $mail->AddAttachment($fileAttachment);             // attachment
		//$mail->AddAttachment("images/phpmailer.gif");             // attachment
		if(!$mail->Send()) return false;
		else return true;
		
	}	
	/**
	 * code phan trang
	 *
	 * @param unknown_type $base_url
	 * @param unknown_type $num_items 	//Tong so record
	 * @param unknown_type $per_page	//so record tren mot trang
	 * @param unknown_type $pageID_item	//so ban ghi da hien thi
	 * @param unknown_type $add_prevnext_text
	 * @return unknown
	 */
	
	function sPage($base_url, $num_items, $per_page, $pageID_item, $add_prevnext_text = TRUE)
	{
		global $lable;
	    $total_pages = ceil($num_items/$per_page);		
	    if ( $total_pages == 1 )
	    {
	        return '';
	    }		
	    $on_page = floor($pageID_item / $per_page) + 1;
	
	    $page_string = '';
	    if ( $total_pages > 10 )
	    {
	        $init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
	
	        for($i = 1; $i < $init_page_max + 1; $i++)
	        {
	            $page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a class="botron" href="' . $base_url . "&amp;pageID=" . ( ( $i - 1 ) * $per_page ) . '">&nbsp;' . $i . '&nbsp;</a>';
	            if ( $i <  $init_page_max )
	            {
	                $page_string .= "&nbsp;";
	            }
	        }
	
	        if ( $total_pages > 3 ){
	            if ( $on_page > 1  && $on_page < $total_pages )
	            {
	                $page_string .= ( $on_page > 5 ) ? ' ... ' : '&nbsp;';
	
	                $init_page_min = ( $on_page > 4 ) ? $on_page : 5;
	                $init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;
	
	                for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
	                {
	                    $page_string .= ($i == $on_page) ? '<b>&nbsp;' . $i . '&nbsp;</b>' : '<a class="botron" href="' . $base_url . "&amp;pageID=" . ( ( $i - 1 ) * $per_page ) . '">&nbsp;' . $i . '&nbsp;</a>';
	                    if ( $i <  $init_page_max + 1 )
	                    {
	                        $page_string .= '&nbsp;';
	                    }
	                }
	
	                $page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : '&nbsp;';
	            }
	            else
	            {
	                $page_string .= ' ... ';
	            }
	
	            for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
	            {
	                $page_string .= ( $i == $on_page ) ? '<b>&nbsp;' . $i . '&nbsp;</b>'  : '<a class="botron" href="' . $base_url . "&amp;pageID=" . ( ( $i - 1 ) * $per_page ) . '">&nbsp;' . $i . '&nbsp;</a>';
	                if( $i <  $total_pages )
	                {
	                    $page_string .= "&nbsp;";
	                }
	            }
	        }
	    }
	    else
	    {
	    		
	        for($i = 1; $i < $total_pages + 1; $i++)
	        {
	            $page_string .= ( $i == $on_page ) ? '<font class="botronactive">&nbsp;' . $i . '&nbsp;</font>' : '<a class="botron"  href="' . $base_url . "&amp;pageID=" . ( ( $i - 1 ) * $per_page )  . '">&nbsp;' . $i . '&nbsp;</a>';
	            if ( $i <  $total_pages )
	            {
	                $page_string .= '&nbsp;';
	            }
	        }
	       // return 'ddd';
	    }
	
	    if ( $add_prevnext_text )
	    {
	        if ( $on_page > 1 )
	        {
	            $page_string = ' <a  class="botron" href="' . $base_url . "&amp;pageID=" . ( ( $on_page - 2 ) * $per_page )  . '">&nbsp;'.$lable->_("<").'&nbsp;</a>&nbsp;' . $page_string;
	        }
	
	        if ( $on_page < $total_pages )
	        {
	            $page_string .= '&nbsp;<a class="botron" href="' . $base_url . "&amp;pageID=" . ( $on_page * $per_page )  . '">&nbsp;'.$lable->_(">").'&nbsp;</a>';
	        }
	
	    }
	
	    $page_string = ' ' . $page_string;
	
	    return $page_string;
	}
	//
	function box_block_title($title)
	{
		global $smarty;		
		
		$title=$title["title"];
		$smarty->assign('title',$title);
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/box_block.tpl','box_block_');	
	}
	function check_view_script($table_fields)
	{		
		$sql="REPLACE(REPLACE(REPLACE($table_fields, CHAR(13,10), '<br>'),'\'',''),'\"','&quot;')";
		return $sql;
	}
	//
	//
	function getFunctionNameID($fid,$nameField=""){
		global $db;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="*";		
		$obj->tableName="sys_function";		
		$obj->where="id=$fid";
		$obj->limit="all";
		$sql=$obj->sqlSelect();		
		$rs=$db->Execute($sql);
		if($nameField) $name=$rs->fields[$nameField];
		else $name=$rs->fields["name"];		
		return $name;
	}
	//
	//
	//
	function getFunctionNameSub($fid){
		global $db,$lable;
		$parent1=getParam("parent1");
		$parent2=getParam("parent2");
		
		$sql="SELECT ABC.name, ABC.htaccess, ABC.parent, (SELECT name FROM sys_function WHERE id=ABC.parent LIMIT 0, 1 ) as Namepather, (SELECT htaccess FROM sys_function WHERE id=ABC.parent LIMIT 0, 1 ) as htaccesspather FROM sys_function ABC WHERE ABC.id=$fid";		
		$rs=$db->Execute($sql);
		if(strlen($rs->fields("Namepather"))>0)
		$nameFun="<a href="._DOMAIN_ROOT_URL.">".$lable->_("Home")."</a>&nbsp;&nbsp;<i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>&nbsp;&nbsp;<a href="._DOMAIN_ROOT_URL."/".$rs->fields("htaccesspather").">".$rs->fields("Namepather")."</a>&nbsp;&nbsp;<i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>&nbsp;&nbsp;<a href="._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")." style=\"color:#3ca995\">".$rs->fields("name")."</a>";	
		else
		$nameFun= "<a href="._DOMAIN_ROOT_URL." class=\"contentFun\">".$lable->_("Home")."</a>&nbsp;&nbsp;<i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i>&nbsp;&nbsp;<a href="._DOMAIN_ROOT_URL."/".$rs->fields("htaccess")." class=\"contentFun\" style=\"color:#3ca995\">".$rs->fields("name")."</a>";				
		return $nameFun;
	}
	
	//
	function getFunctionNameSub_khonglink($fid){
		global $db;
		$sql="SELECT ABC.name, ABC.parent, (SELECT name FROM sys_function WHERE id=ABC.parent LIMIT 0, 1 ) as Namepather FROM sys_function ABC WHERE ABC.id=$fid";		
		$rs=$db->Execute($sql);
		if(strlen($rs->fields("Namepather"))>0)
		$nameFun="".$rs->fields("Namepather")." &nbsp;&nbsp;<img src="._DOMAIN_ROOT_URL."/theme_images/namefun.gif />&nbsp;&nbsp;  <font style=\"color:#f0ff00\">".$rs->fields("name")."</font>";
		else
		$nameFun= "<font style=\"color:#f0ff00\">".$rs->fields("name")."</font>";				
		return $nameFun;
	}
	//
	//
	function getFunctionNameSub_($fid){
		global $db;
		$sql="SELECT ABC.name, ABC.parent, (SELECT name FROM sys_function WHERE id=ABC.parent LIMIT 0, 1 ) as Namepather FROM sys_function ABC WHERE ABC.id=$fid";		
		$rs=$db->Execute($sql);
		if(strlen($rs->fields("Namepather"))>0)
		$nameFun="".$rs->fields("Namepather")." <img src="._DOMAIN_ROOT_URL."/theme_images/namefun.gif />  ".$rs->fields("name");	
		else
		$nameFun= "".$rs->fields("name");				
		return $nameFun;
	}
	//
	//
	function getMemberNameID($username,$nameField=""){
		global $db;
		if(!$username) return;
		
		$sql="SELECT * FROM user WHERE username='$username'";		
		$rs=$db->Execute($sql);
		if($nameField) $name=$rs->fields[$nameField];
		else $name=$rs->fields["name"];	
		return $name;
	}
	//
    function getUsersID($mobile,$nameField=""){
        global $db;
        if(!$mobile) return;

        $sql="SELECT * FROM user WHERE mobile='$mobile'";
        $rs=$db->Execute($sql);
        if($nameField) $name=$rs->fields[$nameField];
        else $name=$rs->fields["name"];
        return $name;
    }
	//
	function getUserNameID($id,$nameField=""){
		global $db;
		if(!$id) return;
		
		$sql="SELECT * FROM user WHERE id='$id'";		
		$rs=$db->Execute($sql);
		if($nameField) $name=$rs->fields[$nameField];
		else $name=$rs->fields["name"];	
		return $name;
	}
	//
	//
	function getparamFID($fid,$order=true){
		$arr=explode("_", $fid);		
		if(!$order) $fid =$arr[count($arr)-1];
		else $fid=$arr[0];		
		return $fid;
	}
	//
	function strleft($value,$len)
	 {
	  return $len < 10 ?$value : preg_replace('/\s+[^\s]*$/','...',substr(preg_replace('/(\<[^\>]+\>|[\x00-\x1F]|\s{2,})/',' ',$value),0,$len)); 
	 }
	 //
	 function strstrimphp($str,$maxlen){
			
			$str=strip_tags($str,"<br><strong>");
			$a=trim($str);
			$len=strlen($a);
			$string='';
			$dem=1;
			for($i==0;$i<=$len;$i++){
			if($a[$i]==' '){
			$dem++;
			}
			if($dem<=$maxlen){
			$string.=$a[$i];
			}
			}
			if($dem>$maxlen){
			$string.="&nbsp;";
			}
			return $string;
		
	}
	 //
	 function strstrim($str,$maxlen){
			$maxlen=30;
			$str=$str["str"];
			$str=strip_tags($str,"<br><strong><p>");
			$a=trim($str);
			$len=strlen($a);
			$string=' ';
			$dem=1;
			for($i==0;$i<=$len;$i++){
			if($a[$i]==' '){
			$dem++;
			}
			if($dem<=$maxlen){
			$string.=$a[$i];
			}
			}
			if($dem>$maxlen){
			$string.=",...&nbsp;";
			}
			return $string;
		
	}
	 //
	  //
	 function strstrimhlv($str,$maxlen){
			$maxlen=55;
			$str=$str["str"];
			$str=strip_tags($str,"<br><strong><p>");
			$a=trim($str);
			$len=strlen($a);
			$string=' ';
			$dem=1;
			for($i==0;$i<=$len;$i++){
			if($a[$i]==' '){
			$dem++;
			}
			if($dem<=$maxlen){
			$string.=$a[$i];
			}
			}
			if($dem>$maxlen){
			$string.=",...&nbsp;";
			}
			return $string;
		
	}
	 //
	//
	 function strstrimtemp($str){
			
			$maxlen=50;
			$str=$str["str"];
			$str=strip_tags($str,"<br><strong><p>");
			$a=trim($str);
			$len=strlen($a);
			$string=' ';
			$dem=1;
			for($i==0;$i<=$len;$i++){
			if($a[$i]==' '){
			$dem++;
			}
			if($dem<=$maxlen){
			$string.=$a[$i];
			}
			}
			if($dem>$maxlen){
			$string.=",...&nbsp;";
			}
			return $string;
		
	}
	//
	 function strstrimtempworldwide($str){
			
			$maxlen=30;
			$str=$str["str"];
			$str=strip_tags($str,"<br><strong><p>");
			$a=trim($str);
			$len=strlen($a);
			$string=' ';
			$dem=1;
			for($i==0;$i<=$len;$i++){
			if($a[$i]==' '){
			$dem++;
			}
			if($dem<=$maxlen){
			$string.=$a[$i];
			}
			}
			if($dem>$maxlen){
			$string.=",...&nbsp;";
			}
			return $string;
		
	}
	function moveFile($from,$to){// di chuyen file 
		@copy($from,$to);
		@unlink($from);
	}
	//
	function htmlcontent($id){
		global $smarty,$db,$themeName,$lable,$lang;				
		$sql="SELECT * FROM sys_htmlpage WHERE (ctrl&1=1) AND (id=$id)";		
		$rs=$db->Execute($sql);
		$content=$rs->fields("content");
		return $content;
	}
	//
	function htmlcontentField($id,$nameField=""){
		global $db;
		if(!$id) return;
		$sql="SELECT * FROM sys_htmlpage WHERE (ctrl&1=1) AND (id=$id)";		
		$rs=$db->Execute($sql);
		if($nameField) $name=$rs->fields[$nameField];
		else $name=$rs->fields["content"];	
		return $name;
	}
	//
	function funcontent($id){
		global $smarty,$db,$themeName,$lable,$lang;				
		$sql="SELECT * FROM sys_function WHERE (ctrl&1=1) AND (id=$id)";		
		$rs=$db->Execute($sql);
		$content=$rs->fields("des");
		return $content;
	}
	function to_days($date)
	{
		$bits  = explode('-', $date, 2);
		$year = $bits[0];
		if(is_leap_year($year))
		{
			$bits[0] = '2000';
		}
		else{
			$bits[0] = '1999';
		}
		$date = implode('-',$bits);
		$leaps = 387;	//leap years up to 1600
		for($i = 1600; $i < $year; $i++)
		{
			if(is_leap_year($i))
			{
				++$leaps;
			}
		}
		$days = date('z', strtotime($date));
		return $leaps + ($year * 365) + $days + 1;
	}
	function is_leap_year($year)
	{
		if($year % 100 == 0 && $year % 400 == 0)
		{
			return true;	
		}
		if($year % 100 == 0)
		{
			return false;	
		}
		if($year % 4 == 0)
		{
			return true;	
		}
		return false;
	}
	function vn_to_str($str){
 
		$unicode = array(
		 
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		 
		'd'=>'đ',
		 
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		 
		'i'=>'í|ì|ỉ|ĩ|ị',
		 
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		 
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		 
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		 
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		 
		'D'=>'Đ',
		 
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		 
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		 
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		 
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		 
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
		 
		);
		 
		foreach($unicode as $nonUnicode=>$uni){
		 
		$str = preg_replace("/($uni)/i", $nonUnicode, $str);
		 
		}
		//$str = str_replace(' ','_',$str);
		 
		return $str;
		 
		}
		
	//
	function uniquename(){
		$d=getdate();
		$tem = ((int)$d["year"]-1900)*12*30*24*60*60;
		$tem += (int)$d["mon"]*30*24*60*60;
		$tem += ((int)$d["mday"])*24*60*60;
		$tem += ((int)$d["hours"])*60*60;
		$tem += ((int)$d["minutes"])*60;
		$tem += ((int)$d["seconds"]);
		$tem .= rand(1,100);
		$tem = base_convert($tem,10,32);
		$tem = strtoupper((string)$tem);
		return trim($tem);
	}
	//	
?>