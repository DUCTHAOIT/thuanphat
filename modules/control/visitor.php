<?php	
	//-------visitor----------------
	//http://ip-to-country.webhosting.info/	
	function visitor(){
		global $db,$smarty,$lable;		
		if(!getSession("visitor")){
		$ip = Dot2LongIP(getenv(REMOTE_ADDR));		
		$sql="INSERT INTO `sys_visitor` (`ip`,`date`) VALUES ('$ip',now())";		
		$db->Execute($sql);				
		setSession("visitor",true);
		}	
		
		$smarty->assign('Counter_statistics',$lable->_("Counter statistics"));	
		$smarty->assign('Total_visitors',$lable->_("Total visitors"));	
		$smarty->assign('Online_users',$lable->_("Online users"));			
		$smarty->assign('visitor',getVisitor());
		$smarty->assign('OnlineUsers',getOnlineUsers());
		$visitor=getVisitor();
		$OnlineUsers=getOnlineUsers()+20;
		
		if(strlen($OnlineUsers)-1>=0){		
			$numonline1 = substr( $OnlineUsers, strlen($OnlineUsers)-1, 1);			
		}else{
			$numonline1='0';
		}
		
		if(strlen($OnlineUsers)-2>=0){		
			$numonline2 = substr( $OnlineUsers, strlen($OnlineUsers)-2, 1);			
		}else{
			$numonline2='0';
		}
		
		if(strlen($OnlineUsers)-3>=0){		
			$numonline3 = substr( $OnlineUsers, strlen($OnlineUsers)-3, 1);			
		}else{
			$numonline3='0';
		}
		
		
		
		
		if(strlen($visitor)-1>=0){		
			$num1 = substr( $visitor, strlen($visitor)-1, 1);
		}else{
			$num1='0';
		}
		if(strlen($visitor)-2>=0){		
			$num2 = substr( $visitor, strlen($visitor)-2, 1);			
		}else{
			$num2='0';
		}
		if(strlen($visitor)-3>=0){		
			$num3 = substr( $visitor, strlen($visitor)-3, 1);			
		}else{
			$num3='0';
		}
		if(strlen($visitor)-4>=0){		
			$num4 = substr( $visitor, strlen($visitor)-4, 1);			
		}else{
			$num4='0';
		}
		if(strlen($visitor)-5>=0){		
			$num5 = substr( $visitor, strlen($visitor)-5, 1);			
		}else{
			$num5='0';
		}
		if(strlen($visitor)-6>=0){		
			$num6 = substr( $visitor, strlen($visitor)-6, 1);			
		}else{
			$num6='0';
		}
		if(strlen($visitor)-7>=0){		
			$num7 = substr( $visitor, strlen($visitor)-7, 1);			
		}else{
			$num7='0';
		}		
		if(strlen($visitor)-8>=0){		
			$num8 = substr( $visitor, strlen($visitor)-2, 1);		
		}else{
			$num8='0';
		}
		
		$smarty->assign('numonline1',$numonline1);
		$smarty->assign('numonline2',$numonline2);
		$smarty->assign('numonline3',$numonline3);
		
		$smarty->assign('num1',$num1);
		$smarty->assign('num2',$num2);
		$smarty->assign('num3',$num3);
		$smarty->assign('num4',$num4);
		$smarty->assign('num5',$num5);
		$smarty->assign('num6',$num6);
		$smarty->assign('num7',$num7);
		$smarty->assign('num8',$num8);
		
		
		//echo (strlen ("christopher")); 
		//echo (substr ("abcdefkl", -5, 1)); // in ra “oph”
		$smarty->display(_DOMAIN_ROOT_TEMPLATE.'/visitor.tpl','visitor_');			
	}	
	//
	
	function getOnlineUsers(){
		global $db;
		$sql="SELECT count(sys_visitor.id) as memberOnline";
		$sql.=" FROM sys_visitor";
		$sql.=" WHERE (TIME_TO_SEC(CURTIME()) - TIME_TO_SEC(`date`) < 15*60) AND (TO_DAYS(`date`)=TO_DAYS(now()))";		
		$rs=$db->Execute($sql);				
		if($rs->fields("memberOnline") > 0) $memberOnline = $rs->fields("memberOnline");
		else $memberOnline =1;		
		return $memberOnline;
	}
	//
	function getVisitor(){
		global $db;
		$sql="SELECT count(sys_visitor.id) as visitor FROM sys_visitor";
		$rs=$db->Execute($sql);
		return $rs->fields("visitor");
	}	
	function Dot2LongIP ($IPaddr) { 
		if ($IPaddr == ""){
			return 0;
		}else{ 
			$ips = split ("\.", "$IPaddr"); 
			$ip=($ips[0]*16777216) + ($ips[1]*65536) + ($ips[2]*256) + $ips[3];			
			return $ip;			
		}
	} 
	//
	/*
	// doc file .cvs chua du lieu IP down ve tu trang http://ip-to-country.webhosting.info/ dua vao bang sys_iptocountry
	// lan dau doc khong het file, thay row > row tren man hinh roi chay tiep
	$row = 1;
	$handle = fopen("c:/ip-to-country.csv", "r");
	
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {	    
	    //if($row >82720){
	    	echo "<p> line $row: <br /></p>\n";
	        $sql="INSERT INTO sys_iptocountry (IP_FROM,IP_TO,COUNTRY_CODE2,COUNTRY_CODE3,COUNTRY_NAME) VALUES('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."');";
		    $db->Execute($sql);
	    //}	    
	    $row++;
	}
	fclose($handle);
*/
?>