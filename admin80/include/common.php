<?php
	include_once("include/configSystem.php");
	$themeName="default";	
	define('_DOMAIN_ROOT_TEMPLATE',_DOMAIN_ROOT_PATH.'/admin80/theme/'.$themeName.'/templates');		
	
	include_once("include/configDatabase.php");
	include_once("include/configSmarty.php");
	include_once(_DOMAIN_ROOT_PATH."/adodb5/adodb.inc.php");
	
	$db=dbConnect($DATABASE_HOST,$DATABASE_NAME,$DATABASE_USER,$DATABASE_PASSWORD);
	
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
//        $ADODB_FETCH_MODE=ADODB_FETCH_BOTH;
//        $db->setFetchMode(ADODB_FETCH_BOTH);
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
		//echo $filename;
		@include_once($filename);
	}
	//
	function Err($string="",$header=true){
		if($header==true){
			include_once("header.php");
			echo "<div style=\"font-weight:bold;color:#CC0000; text-align:center; padding-bottom:10px; padding-bottom:10px\">Erro: $string</div>";	
			include_once("footer.php");
		}else{
			echo "<div style=\"font-weight:bold;color:#CC0000; text-align:center; padding-bottom:10px; padding-bottom:10px\">Erro: $string</div>";	
		}	
	}	
	function converMoney($money,$remover=true){
		if(!$money) return 0;
		if($remover==true){
			$money = number_format($money,0,",",".");
		}else{
			// dua cac so ve dang chuan de luu vao data
			$value = array(".", ",");
			$money = str_replace($value, "", $money);
		}
		return $money;
	}
	//	
	function messange($mess){
		echo "<div style=\"color:#FF0000\">$mess</div>";
	}
	function moveFile($from,$to){// di chuyen file 
		@copy($from,$to);
		@unlink($from);
	}
	function getCboLanguage($langID){
		global $db, $lang;
		$langID=$langID["lang"];
		if(!$langID) $langID=$lang;
		//echo $lang;
		$sql="SELECT * FROM sys_language";
		$db->setFetchMode(ADODB_FETCH_ASSOC);
		$arr=$db->GetAssoc($sql);
		echo "<select name=\"lang\">";
		foreach ($arr as $key=>$value){
			if($key==$langID) echo "<option value=\"".$key."\" selected=\"selected\">".$value."</option>";
			else echo "<option value=\"".$key."\">".$value."</option>";
		}
		echo "</select>";
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
			return number_format($number, 0, '.', ',')."";		
		}elseif($lang=="en"){
			return "\$ ".number_format($number, 0, '.', ',');
		}
	}
	function format_number2($number){
		global $lang;
		$number=$number["number"];
		if($number==0) return;
		if($lang=="vn"){
			return number_format($number, 2, '.', ',')."";		
		}elseif($lang=="en"){
			return "\$ ".number_format($number, 2, '.', ',');
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
		$sql="SELECT * FROM sys_language WHERE key='$lang'";
		$rs=$db->Execute($sql);
		if($rs->fields("key")) setSession("lang_id",$lang);
	}
	function viewFckeditor($content){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
					
		$content = $content["content"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor() ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		// Giữ lại thẻ <i>/<span> rỗng (icon font kiểu Font Awesome <i class="fa fa-...">) khi lưu nội dung -
		// mặc định CKEditor coi các thẻ inline không có text bên trong là "rỗng" và tự xoá lúc Submit.
		// Lưu ý: property đúng của class CKEditor là $config (chữ thường), không phải $Config.
		$oCKEditor->config['extraAllowedContent'] = 'i(*)[*]{*}; span(*)[*]{*}';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content;

		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ;

		$oCKEditor->editor('content',$content,'','') ;

	}

	function viewFckeditor_giaodiencu($content){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
		
		$config['toolbar'] = array(
			 array('Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates'
			, 'clipboard',  'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ,
			 'editing',  'Find','Replace','-','SelectAll','-','SpellChecker', 'Maximize', 'ShowBlocks','Smiley','SpecialChar' ),
			array(
			 'basicstyles',  'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ,
			 'paragraph', 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
			'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl',
			 'links',  'Link','Unlink','Anchor' ),
			array( 'insert', 'Image','Flash','Table','HorizontalRule','PageBreak','Iframe' ,
			 'styles', 'Styles','Format','Font','FontSize',
			'colors',  'TextColor','BGColor',
			 'tools' )
		);
		
		$config['skin'] = 'v2';
			
		$content = $content["content"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor() ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content;
		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		
		$oCKEditor->editor('content',$content,$config,'') ;
		
	}
	//
	//
	function viewFckeditor_($content){
	
		include_once("js/ckeditor/ckeditor.php");
		
		$content = $content["content"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content;
		$oCKEditor->editor('content',$content,'','');
		
	}
	//
	function viewFckeditor__($content){
		include("js/ckeditor/ckeditor.php") ;
		require_once ('js/ckfinder/ckfinder.php') ; 
		$sBasePath = 'js/ckeditor/';
		$oCKeditor = new CKEditor() ;
		$oCKeditor->BasePath = $sBasePath;
		CKFinder::SetupCKEditor( $ckeditor, 'js/ckfinder/' ) ;
		//$ckeditor->replace("NoiDung"); 
		$oCKeditor->Value = 'Huong dan cau hinh CKeditor';
		$oCKeditor->editor('content') ;
		
		
	}
	//
	function viewFckeditors($contents){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$contents = $contents["contents"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('contents') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content;
		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		
		$oCKEditor->editor('contents',$contents,'','') ;
		
	}
	//
	function viewFckeditors_($contents){
		//include_once("js/fckeditor/fckeditor.php");		
		include_once("js/ckeditor/ckeditor.php");	
		$contents = $contents["contents"];		
		$sBasePath = "js/fckeditor/";
		$oFCKeditor = new FCKeditor('contents') ;
		$oFCKeditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Height		= 200;
		$oFCKeditor->Value		= $contents;
		$oFCKeditor->Create() ;
	}		
	//
	function viewFckeditor1($content1){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content1 = $content1["content1"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content1') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content1;
		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		
		$oCKEditor->editor('content1',$content1,'','') ;
		
	}
	//
	function viewFckeditor1_($content1){
//		include_once("js/fckeditor/fckeditor.php");		
		include_once("js/ckeditor/ckeditor.php");	
		$content1 = $content1["content1"];		
		$sBasePath = "js/fckeditor/";
		$oFCKeditor = new FCKeditor('content1') ;
		$oFCKeditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Height		= 200;
		$oFCKeditor->Value		= $content1;
		$oFCKeditor->Create() ;
	}		
	//
	function viewFckeditor2($content2){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content2 = $content2["content2"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content2') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content;
		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		
		$oCKEditor->editor('content2',$content2,'','') ;
		
	}
	//
	function viewFckeditor2_($content2){
		//include_once("js/fckeditor/fckeditor.php");		
		include_once("js/ckeditor/ckeditor.php");	
		$content2 = $content2["content2"];		
		$sBasePath = "js/fckeditor/";
		$oFCKeditor = new FCKeditor('content2') ;
		$oFCKeditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Height		= 200;
		$oFCKeditor->Value		= $content2;
		$oFCKeditor->Create() ;
	}		
	//
	function viewFckeditor3($content3){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content3 = $content3["content3"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content3') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content3;
		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		
		$oCKEditor->editor('content3',$content3,'','') ;
		
	}
	//
	function viewFckeditor3_($content3){
		//include_once("js/fckeditor/fckeditor.php");		
		include_once("js/ckeditor/ckeditor.php");	
		$content3 = $content3["content3"];		
		$sBasePath = "js/fckeditor/";
		$oFCKeditor = new FCKeditor('content3') ;
		$oFCKeditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Height		= 200;
		$oFCKeditor->Value		= $content3;
		$oFCKeditor->Create() ;
	}		
	//
	function viewFckeditor4($content4){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content4 = $content4["content4"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content4') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content4;
		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		
		$oCKEditor->editor('content4',$content4,'','') ;
		
	}
	//
	//
	function viewFckeditor5($content5){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content5 = $content5["content5"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content5') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content5;
		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		
		$oCKEditor->editor('content5',$content5,'','') ;
		
	}
	
	//
	//
	function viewFckeditor6($content6){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content6 = $content6["content6"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content6') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content6;		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		$oCKEditor->editor('content6',$content6,'','') ;
		
	}
	//
	//
	function viewFckeditor7($content7){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content7 = $content7["content7"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content7') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content7;		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		$oCKEditor->editor('content7',$content7,'','') ;
		
	}
	//
	function viewFckeditor8($content8){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content8 = $content8["content8"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content8') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content8;		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		$oCKEditor->editor('content8',$content8,'','') ;
		
	}
	//
	function viewFckeditor9($content9){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content9 = $content9["content9"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content9') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content9;		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		$oCKEditor->editor('content9',$content9,'','') ;
		
	}
	//
	function viewFckeditor10($content10){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content10 = $content10["content10"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content10') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content10;		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		$oCKEditor->editor('content10',$content10,'','') ;
		
	}
	//
	function viewFckeditor11($content11){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content11 = $content11["content11"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content11') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content11;		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		$oCKEditor->editor('content11',$content11,'','') ;
		
	}
	//
	function viewFckeditor12($content12){
	
		include_once("js/ckeditor/ckeditor.php");
		require_once('js/ckfinder/ckfinder.php'); 
			
		$content12 = $content12["content12"];	
		$sBasePath = "js/ckeditor/";
		$oCKEditor = new CKEditor('content12') ;
		$oCKEditor->Config['ToolbarStartExpanded'] = false ;
		//$oFCKeditor->ToolbarSet = 'basic';
		$oCKEditor->BasePath	= $sBasePath ;
		$oCKEditor->Height		= 400;
		$oCKEditor->Value		= $content12;		
		CKFinder::SetupCKEditor( $oCKEditor, 'js/ckfinder/' ) ; 
		$oCKEditor->editor('content6',$content12,'','') ;
		
	}
	
	//
	//
	function vieweditor($content){
		$content=$content["content"];
	?>
		<script>
		// Don't forget to add CSS for your custom styles.
		CKEDITOR.addCss('figure[class*=easyimage-gradient]::before { content: ""; position: absolute; top: 0; bottom: 0; left: 0; right: 0; }' +
		  'figure[class*=easyimage-gradient] figcaption { position: relative; z-index: 2; }' +
		  '.easyimage-gradient-1::before { background-image: linear-gradient( 135deg, rgba( 115, 110, 254, 0 ) 0%, rgba( 66, 174, 234, .72 ) 100% ); }' +
		  '.easyimage-gradient-2::before { background-image: linear-gradient( 135deg, rgba( 115, 110, 254, 0 ) 0%, rgba( 228, 66, 234, .72 ) 100% ); }');
	
		CKEDITOR.replace('<?php echo $content;?>', {
		  extraPlugins: 'easyimage',
		  removePlugins: 'image',
		  removeDialogTabs: 'link:advanced',
		  toolbar: [{
			  name: 'document',
			  items: ['Undo', 'Redo']
			},
			{
			  name: 'styles',
			  items: ['Format']
			},
			{
			  name: 'basicstyles',
			  items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
			},
			{
			  name: 'paragraph',
			  items: ['NumberedList', 'BulletedList']
			},
			{
			  name: 'links',
			  items: ['Link', 'Unlink']
			},
			{
			  name: 'insert',
			  items: ['EasyImageUpload']
			}
		  ],
		  height: 250,
		  cloudServices_uploadUrl: 'https://33333.cke-cs.com/easyimage/upload/',
		  // Note: this is a token endpoint to be used for CKEditor 4 samples only. Images uploaded using this token may be deleted automatically at any moment.
		  // To create your own token URL please visit https://ckeditor.com/ckeditor-cloud-services/.
		  cloudServices_tokenUrl: 'https://33333.cke-cs.com/token/dev/ijrDsqFix838Gh3wGO3F77FSW94BwcLXprJ4APSp3XQ26xsUHTi0jcb1hoBt',
		  easyimage_styles: {
			gradient1: {
			  group: 'easyimage-gradients',
			  attributes: {
				'class': 'easyimage-gradient-1'
			  },
			  label: 'Blue Gradient',
			  icon: 'https://ckeditor.com/docs/ckeditor4/4.11.3/examples/assets/easyimage/icons/gradient1.png',
			  iconHiDpi: 'https://ckeditor.com/docs/ckeditor4/4.11.3/examples/assets/easyimage/icons/hidpi/gradient1.png'
			},
			gradient2: {
			  group: 'easyimage-gradients',
			  attributes: {
				'class': 'easyimage-gradient-2'
			  },
			  label: 'Pink Gradient',
			  icon: 'https://ckeditor.com/docs/ckeditor4/4.11.3/examples/assets/easyimage/icons/gradient2.png',
			  iconHiDpi: 'https://ckeditor.com/docs/ckeditor4/4.11.3/examples/assets/easyimage/icons/hidpi/gradient2.png'
			},
			noGradient: {
			  group: 'easyimage-gradients',
			  attributes: {
				'class': 'easyimage-no-gradient'
			  },
			  label: 'No Gradient',
			  icon: 'https://ckeditor.com/docs/ckeditor4/4.11.3/examples/assets/easyimage/icons/nogradient.png',
			  iconHiDpi: 'https://ckeditor.com/docs/ckeditor4/4.11.3/examples/assets/easyimage/icons/hidpi/nogradient.png'
			}
		  },
		  easyimage_toolbar: [
			'EasyImageFull',
			'EasyImageSide',
			'EasyImageGradient1',
			'EasyImageGradient2',
			'EasyImageNoGradient',
			'EasyImageAlt'
		  ]
		});
	  </script>
    <?php    
	}		
	//
			
	//
	function resizeToFile($sourcefile, $dest_x, $dest_y, $targetfile,$quality,$fileType="image/gif")
	{	
		$picsize=getimagesize("$sourcefile");
		$source_x = $picsize[0];
		$source_y = $picsize[1];		
			
		if($fileType=="image/jpeg" or $fileType=="image/jpg"){
			$img = imagecreatefromjpeg($sourcefile);				
			$target_id=imagecreatetruecolor($dest_x, $dest_y);
			imagecopyresampled($target_id,$img,0,0,0,0,$dest_x,$dest_y,$source_x,$source_y);
			imagejpeg ($target_id,"$targetfile",$quality);
			return true;
		}elseif($fileType=="image/gif") {
			$img = imagecreatefromgif($sourcefile);				
			$target_id=imagecreatetruecolor($dest_x, $dest_y);
			imagecopyresampled($target_id,$img,0,0,0,0,$dest_x,$dest_y,$source_x,$source_y);
			imagegif ($target_id,"$targetfile");
			return true;
		}elseif($fileType=="image/png") {
			$img = imagecreatefrompng($sourcefile);				
			$target_id=imagecreatetruecolor($dest_x, $dest_y);
			imagecopyresampled($target_id,$img,0,0,0,0,$dest_x,$dest_y,$source_x,$source_y);
			imagepng ($target_id,"$targetfile");
			return true;
		}else return false;
	}
	//
	function getextension($name){
		$post = strrpos($name,".");
		if ($post==0) return "";
		$tem = substr($name,$post);
		return $tem;
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
		return $tem;
	}
	//
	function checkPermit($mName){
		global $db;		
		if($mName=="home" or $m="control") return;
		loadClass("constructSql");
		$obj=new constructSql();
		$obj->fieldsName="module_name,permit";
		$obj->tableName="sys_modules";
		$obj->limit="all";
		$sql=$obj->sqlSelect();
		$arr=$db->GetAssoc($sql);
		
		$nPermit=(int)$arr[$mName];
		$uPermit=(int)getSession("permit");		
		
		if(!($nPermit & $uPermit)){
			include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
			$ret_page="?";
			$a=new msgBox("Not permit","OKOnly", "Message", array($ret_page), 1);
			$a->showMsg();
		}
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
	            $page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . $base_url . "&amp;pageID=" . ( ( $i - 1 ) * $per_page ) . '">' . $i . '</a>';
	            if ( $i <  $init_page_max )
	            {
	                $page_string .= " | ";
	            }
	        }
	
	        if ( $total_pages > 3 ){
	            if ( $on_page > 1  && $on_page < $total_pages )
	            {
	                $page_string .= ( $on_page > 5 ) ? ' ... ' : ' | ';
	
	                $init_page_min = ( $on_page > 4 ) ? $on_page : 5;
	                $init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;
	
	                for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
	                {
	                    $page_string .= ($i == $on_page) ? '<b>' . $i . '</b>' : '<a href="' . $base_url . "&amp;pageID=" . ( ( $i - 1 ) * $per_page ) . '">' . $i . '</a>';
	                    if ( $i <  $init_page_max + 1 )
	                    {
	                        $page_string .= ' | ';
	                    }
	                }
	
	                $page_string .= ( $on_page < $total_pages - 4 ) ? ' ... ' : ' | ';
	            }
	            else
	            {
	                $page_string .= ' ... ';
	            }
	
	            for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
	            {
	                $page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>'  : '<a href="' . $base_url . "&amp;pageID=" . ( ( $i - 1 ) * $per_page ) . '">' . $i . '</a>';
	                if( $i <  $total_pages )
	                {
	                    $page_string .= " | ";
	                }
	            }
	        }
	    }
	    else
	    {
	    		
	        for($i = 1; $i < $total_pages + 1; $i++)
	        {
	            $page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . $base_url . "&amp;pageID=" . ( ( $i - 1 ) * $per_page )  . '">' . $i . '</a>';
	            if ( $i <  $total_pages )
	            {
	                $page_string .= ' | ';
	            }
	        }
	       // return 'ddd';
	    }
	
	    if ( $add_prevnext_text )
	    {
	        if ( $on_page > 1 )
	        {
	            $page_string = ' <a href="' . $base_url . "&amp;pageID=" . ( ( $on_page - 2 ) * $per_page )  . '">Previous </a>&nbsp;&nbsp;' . $page_string;
	        }
	
	        if ( $on_page < $total_pages )
	        {
	            $page_string .= '&nbsp;&nbsp;<a href="' . $base_url . "&amp;pageID=" . ( $on_page * $per_page )  . '">Next</a>';
	        }
	
	    }
	
	    $page_string = ' ' . $page_string;
	
	    return $page_string;
	}
	//
	//
	function file_size($path){
		(int)$size=filesize($path);
		if($size >= 1024){
			$size=$size/1024;
			$type = " KB";
			if($size >= 1024){
				$size=$size/1024;
				$type=" MB";
			}
		}else $type=" Bytes";
		$size=$size . $type;
		return $size;
	}
	//
	//
	function convert_vi_to_en($str) {
		  $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
		  $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
		  $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
		  $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
		  $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
		  $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
		  $str = preg_replace("/(đ)/", "d", $str);
		  $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
		  $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
		  $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
		  $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
		  $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
		  $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
		  $str = preg_replace("/(Đ)/", "D", $str);
		  $str = str_replace(" ", "-", str_replace("&*#39;","",$str));
		  return $str;
	  }
	  //
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }
?>