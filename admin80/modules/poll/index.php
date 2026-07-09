<script language="JavaScript" src="js/over_tables.js"></script>
<?php
include "modules/poll/lib.php";
 	$current_file = basename($_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING'] ;
 	$op = getParam("op");
 	if (!strpos($op,"action")) {
 		include("header.php");
 		echo "<table width=100%>
 				<tr>
 					<td colspan=2 align=center ><h3>Thăm dò ý kiến</h3></td>
 				</tr>
 				<tr>
 					<td align=left><input type=button value=\"Thêm mới\" onClick=\"location='?m=poll&op=create'\"></td>
 					<td align=right><input type=button value=\"Danh sách\" onClick=\"location='?m=poll&op=list'\"></td>
 				</tr>
 			 </table>";
 		switch ($op) {
 			case "create": admin_create_poll(); break;
			case "create_action": admin_create_action_poll(); break;
 			case "edit": admin_edit_poll(); break;
			case "action": admin_select_action_poll(); break;
			case "add_selection": admin_add_selection_poll(); break;
 			case "list":
 			default: admin_list_poll();

 		}
 		include("footer.php");
	}
	else {
		$module = getParam("m");
		$func = "admin_" . $op . "_" . $module;
		$func();
	}

function fn($data)
{
	$lang= get_current_language();
	return translate($data,$lang);
}

function admin_list_poll(){
	global $db, $lang, $themeName;	
	//$db = get_condb();
	$sql = "SELECT * FROM polls WHERE pol_parent_id=0 AND lang='$lang'";
	$rs=$db->Execute($sql);
	$i=1;

?>
	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" id="table">
	<tr class="tr2" style="padding:3 ">
		<td class="td"><?php echo "Stt";?></td>
		<td class="td" width="100%"><?php echo "Câu hỏi";?></td>
		<td></td>
		<td ></td>
	</tr>
<?php while(!$rs->EOF){ ?>
	<tr class="content" style="padding:5px">
		<td class="td"><?php echo $i++?></td>
		<td class="td"><?php echo $rs->fields["pol_name"];?></td>
		<td>
		<?php 
				$pol_active=$rs->fields["pol_active"];
				if($pol_active=="1")
				$img="<span><img src=\"images/1.gif\" title=\"". _ARTICLE_ACTIVE ."\"  border=\"0\"></span>";
				else $img="<span><a href=\"?m=poll&op=action&poll=".$rs->fields["pol_id"]."\"><img src=\"images/0.gif\" title=\"". _ARTICLE_UNACTIVE ."\"  style=\"cursor:pointer\" border=\"0\"></a></span>";
					
				
				echo $img;
				?>	
		</td>
		<td><a href="?&m=poll&op=edit&poll=<?php echo $rs->fields["pol_id"]?>"><img src="modules/poll/b_edit.png" border="0"></a></td>
		<td><a href="?&m=poll&op=delete_action&poll=<?php echo $rs->fields["pol_id"]?>"><img src="modules/poll/b_drop.png" border="0"></a></td>		
	</tr>
<?php
		$rs->MoveNext();
	}
?>
</table>
	<script language="JavaScript">
		tigra_tables('table', 1, 0, '#F2F2F2', '#E5E5E5', '#D8EEFE', '#C5E6FE');
	</script>
<?php
}

function admin_edit_poll()
{ global $current_file, $admin_page, $db, $lang;
  	$pol_id = $_GET['poll'];
	$sql="SELECT * FROM polls WHERE lang='$lang' AND pol_id=" . $pol_id . " OR pol_parent_id=" . $pol_id . " ORDER BY pol_id ASC";
	$rs = $db->Execute($sql);
	
	$db_total_hits = "SELECT SUM(pol_hits) AS pol_hits
							 FROM polls
							 WHERE pol_parent_id = ".$pol_id."";

	$rstotal=$db->Execute($db_total_hits);	
	$pol_hits = $rstotal->fields("pol_hits");
	
	if (!$rs || !$rs->RecordCount())
	return;
	$poll_arr = $rs->GetArray();
	
?>

<form action="#" method=post>
 <input type=hidden name=opcode value=module>
 <input type=hidden name=module value=poll>
 <input type=hidden name=op value="update_action">
 <input type=hidden name="fldpoll[0]" value="<?php echo $pol_id ?>">
 <input type=hidden name="poll" value="<?php echo $pol_id ?>">
 <input type=hidden name="fldordinal[0]" value="0">
 <input type=hidden name=ret_page value="<?php echo $current_file ?>">
 
 <table border=0 align="center" >
 	<tr>
 	  <td class=tr2 colspan="2">&nbsp;</td>
    </tr>
 	<tr>
 		<td class=title><?php echo "Câu hỏi"; ?></td>
 		<td>			
			<input type=text name="fldoption[0]" value="<?php echo $poll_arr[0]["pol_name"]; ?>" size=50 >
		</td>
 	</tr>
 	<tr>
 		<td class=title ><?php echo "Số đánh giá"; ?></td>
 		<td class="title" style="font-size:18px; color:#FF0000"><?php echo $pol_hits; ?></td>
 	</tr>
 	<tr>
 	  <td class=title >&nbsp;</td>
 	  <td align="right"><input type=submit value="<?php echo "Kích hoạt"; ?>" onClick="this.form.op.value='select_action'"></td>
    </tr>
 </table>
 
 <p>&nbsp;</p>
  <table border=0 align="center" style="border:1">
    <tr class="tr2"> 
      <td>&nbsp;</td>
      <td class=title><?php echo "Các câu trả lời"; ?></td>
       <td class=title>&nbsp;</td>
    </tr>
    <?php
	for($i=1, $max=count($poll_arr); $i < $max;$i++) {
?>
	
    <tr class=tr_line1> 
      <td class=title ><?php echo "Câu trả lời" . $i ?></td>
      <td nowrap class="content"> 
	  <input type=hidden name="fldpoll[<?php echo $i ?>]" value="<?php echo $poll_arr[$i]["pol_id"]; ?>">
	  <input type=text name="fldoption[<?php echo $i ?>]" value="<?php echo $poll_arr[$i]["pol_name"]; ?>" size=50 >
	 </TD>       
      <td><a href="<?php echo "?m=poll&op=delete_action&poll=" . $poll_arr[$i]["pol_id"] . "&main_poll=" . $pol_id ?>"><img src="modules/poll/b_drop.png" border="0"></a></td>
    </tr>
    <?php
 		}
?>
  <tr class=tr_line1> 
      <td class=title ><?php echo "Câu trả lời" . $i ?></td>
       <td nowrap class="content">
	  		<input type=text name="fldoption[<?php echo $i ?>]" value="" size=50 >
	  </TD>
     </tr>
    <tr> 
      <td colspan=5 align=center>
	  	<input type=submit value="<?php echo "Cập nhật"; ?>" onClick="this.form.op.value='update_action'"> 
        &nbsp;&nbsp;&nbsp; <input type=submit value="<?php echo "Xóa bỏ"; ?>" onClick="this.form.op.value='delete_action'; return confirm('<?php echo _AREYOUSURE ?>')"> 
      </td>
    </tr>
  </table>
</form>
<?php

}
function admin_update_action_poll(){
	global $current_file, $admin_page,$db, $lang;
	$pol_id = getParam("poll");
	$fldpoll = getParamPost("fldpoll");
	$fldordinal = getParamPost("fldordinal");
	$fldoption = getParamPost("fldoption");
	$fldscore = getParamPost("fldscore");
	$max=count($fldpoll);	
	for($i=0,$max=count($fldpoll); $i < $max; $i++) {
		$pol_name = $fldoption[$i];
		$sql = "UPDATE polls SET pol_name='" . $pol_name . "' WHERE pol_id=" . $fldpoll[$i];			
		$db->Execute($sql);	
	}
	
	if (strlen($fldoption[$max])) {
		$pol_name = $fldoption[$max];
		$sql = "INSERT INTO polls (pol_name,pol_parent_id, pol_order, lang) VALUES ('" . $pol_name . "'," . $pol_id . "," . $max . ",'" . $lang . "')";
		$db->Execute($sql);
	}	
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	$ret_page = "?m=poll";
	$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);	
	$a->showMsg();						
	
}

function admin_create_poll(){ 
	global $admin_page;
	$ret_page = "?m&module=poll&op=list";
?>
<script type="text/javascript">
function Reset()
{
	for(i=2;i<=10;i++) {
		var poll = document.getElementById("poll" + i)
		poll.style.display="none";
	}
}
function Gen_option(num)
{
	if (num >=2 && num <=10) {
		var poll = document.getElementById("poll" + num)
		poll.style.display="block";
	}

}
</script>

<form action="#" method=post>
 <input type="hidden" name="m" value="poll">
 <input type="hidden" name="op" value="create_action">
 <table width=80% border=0 align="center" >
 	<tr class=title>
 		<td ><?php echo "Câu hỏi"; ?></td>
 		<td><input type=text name="fldoption[]" size=50 > 			
 		</TD>
 	</tr>
 	<tr>
 		<td class=title align="left" style="padding-left:10"><?php echo "Số câu lựa chọn"; ?></td>
 		<td>
 			<input type=text name=num size=4> &nbsp; 2 - 10 &nbsp;&nbsp;
 			<input type=button value="<?php echo "Thêm"; ?>" onClick="this.form.num.enable=false;Gen_option(this.form.num.value)" >
 			<input type=Reset onClick="Reset()">
 		</td>
 	</tr>
</table>
<?php
 for($i=2; $i <= 10;$i++) {
?>
<div  name="<?php echo "poll" . $i ?>" id="<?php echo "poll" . $i ?>" style="text-align:center; display:none">
 <table>
<?php
 	for($j=1; $j <= $i; $j++) {		
?>
 	<tr class=tr_line1>
 		<td class=title ><?php echo "Câu trả lời" . " " . $j ?></td>
 		<td><input type=text name="fldoption[]" size=50 ></TD>
 	</tr>
<?php
 	}
?>
	<tr>
		<td colspan=2 align=center><input type=submit value="<?php echo _UPDATE ?>"></td>
	</tr>
 </table>
</div>
 <?php
 	}
 	echo "</form>";
 }
function admin_delete_action_poll(){ 
	//chek_permit(_ADMIN_DELETE_POLL);
	global  $current_file, $admin_page,$db, $lang;
	
	$pol_id = $_GET['poll'];
	$main_poll = getParam("main_poll");
	
	if ($main_poll)
		$ret_page = "?m=poll&op=edit&poll=" . $main_poll;
	else
		$ret_page = "?m=poll&op=list";
	$sql="DELETE FROM polls WHERE pol_id=" . $pol_id . " OR pol_parent_id=" . $pol_id."";
	$db->Execute($sql);
	
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);	
	$a->showMsg();			
		
	set_session("config_tb","");	// Refresh config session
	
	$ret_page = "?m=poll&opcode=module";
	header("Location: " . $ret_page);		
}

function admin_create_action_poll(){
	global $db, $lang;	
	$fldoption = $_POST['fldoption'];	
	for($i=0, $max=count($fldoption);$i < $max; $i++) {
		if ($fldoption[$i]=="") {
			unset($fldoption[$i]);
		}else
			$fldoption2[] = $fldoption[$i];
	}
	$sql= "INSERT INTO polls (pol_name,lang) VALUES ('" . $fldoption2[0] . "','" . $lang . "')";
	$db->Execute($sql);
	$id = $db->Insert_ID();
	for($i=1, $max=count($fldoption2);$i < $max; $i++) {
		$sql= "INSERT INTO polls (pol_name,pol_parent_id, pol_order, lang) VALUES ('" . $fldoption2[$i] . "'," . $id . "," . $i . ",'" . $lang . "')";		
		$db->Execute($sql);		
	}
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	$ret_page = "?m=poll&opcode=module";
	$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);	
	$a->showMsg();	
	
}

function admin_add_selection_poll(){ 
	global $current_file, $db;
	$db = get_condb();
	$pol_id = getParam("poll");

	$rs = $db->Execute("SELECT * FROM polls WHERE pol_id=" . $pol_id . " OR pol_parent_id=" . $pol_id . " ORDER BY pol_order ASC");
	if (!$rs || !$rs->RecordCount())
		return;

	echo "<FONT class=boxTitle >" . _ADD_MORE_OPTION . "</font>" ;
?>

<form action="<?php echo $admin_page?>" method=post>
 <input type=hidden name=opcode value=module>
 <input type=hidden name=module value=poll>
 <input type=hidden name=op value="add_selection_action">
 <input type=hidden name="poll" value="<?php echo $pol_id ?>">
 <input type=hidden name="fldordinal" value="<?php echo $rs->RecordCount(); ?>">
 <input type=hidden name=ret_page value="<?php echo $current_file ?>">
 <table width=80% border=0 align="center" >
 	<tr>
 		<td class=title><?php echo _QUESTION ?></td>
 		<td class="content">
			<input type=text value="<?php echo translate($rs->fields["pol_name"],"vn") ?>" size=50 > <?php echo _VIETNAMESE ?><br>
 			<input type=text value="<?php echo translate($rs->fields["pol_name"],"en") ?>" size=50 > <?php echo _ENGLISH ?>
 		</TD>
 	</tr>
 	<tr>
 		<td class=title ><?php echo _SELECT_NUM ?></td>
 		<td><input type=text name="fldscore" value="<?php echo $rs->fields["pol_hits"] ?>"  size=5></td>
 	</tr>
 </table>
 <p>&nbsp;</p>
  <table width="80%" border=0 align="center" style="border:1">
    <tr> 
      <td>&nbsp;</td>
      <td class=title><?php echo _CONTENT ?></td>
    </tr>
    <tr class=tr_line1> 
      <td class=title ><?php echo _OPTION ?></td>
      <td nowrap class="content"> <input type=text name="fldoption_vn" value="" size=50 > <?php echo _VIETNAMESE ?><br> 
        <input type=text name="fldoption_en" value="" size=50 > <?php echo _ENGLISH ?><br> 
      </TD>
    </tr>
    <tr> 
      <td colspan=2 align=center> <input type=submit value="<?php echo _UPDATE?>" > 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT type="button" value="Cancel" onClick="history.back()"> </td>
    </tr>
  </table>
</form>
<?php

}

function admin_add_selection_action_poll(){
	//check_permit(_ADMIN_CREATE_ACTION_POLL);
	global $db, $lang;
	$pol_id = getParam("poll");
	$fldoption = $_POST['fldoption'];
	$fldordinal = $_POST['fldordinal'];
	
	$fldoption = $fldoption;
	
	$sql= "INSERT INTO polls (pol_name,pol_parent_id, pol_hits, lang) VALUES ('" . $fldoption . "'," . $pol_id . "," . $fldordinal . "," . $lang . ")";
	//echo $sql;
	$db->Execute($sql);

	$ret_page = "?m=poll";
	header("Location: " . $ret_page);	
}

function admin_select_action_poll(){
	global $current_file, $admin_page,$db, $lang;
	$poll  = $_GET['poll'];
	$db->Execute("UPDATE polls SET pol_active= 0 WHERE lang='".$lang."'");		
	$db->Execute("UPDATE polls SET pol_active= 1 WHERE (pol_id = " . $poll.") AND (lang='".$lang."')");	
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	global $main_page;
	
	$ret_page = "?m=poll";
	if (empty($ret_page))   $ret_page=$main_page;
  	else $ret_page = urldecode($ret_page);
	
	$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 1);	
	$a->showMsg();			
		
	set_session("config_tb","");	// Refresh config session
	
	$ret_page = "?m=poll";
	header("Location: " . $ret_page);	
	
}
?>