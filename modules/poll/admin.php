<script language="JavaScript" src="js/over_tables.js"></script>
<?php
$module_dir="modules/poll";
get_module_language($module_dir);
include "modules/poll/lib.php";
 	get_module_language("modules/poll");
 	$current_file = basename($_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING'] ;
 	$op = get_param("op");
 	if (!strpos($op,"action")) {
 		include("header.php");
 		echo "<table width=100%>
 				<tr>
 					<td colspan=2 align=center ><h3>" . _POLL. "</h3></td>
 				</tr>
 				<tr>
 					<td align=left><input type=button value=\"" . _ADD . "\" onClick=\"location='$admin_page?opcode=module&module=poll&op=create'\"></td>
 					<td align=right><input type=button value=\"" . _LIST_POLL . "\" onClick=\"location='$admin_page?opcode=module&module=poll&op=list'\"></td>
 				</tr>
 			 </table>";
 		switch ($op) {
 			case "create": admin_create_poll(); break;
 			case "edit": admin_edit_poll(); break;
			case "action": admin_select_action_poll(); break;
			case "add_selection": admin_add_selection_poll(); break;
 			case "list":
 			default: admin_list_poll();

 		}
 		include("footer.php");
	}
	else {
		$module = get_param("module");
		$func = "admin_" . $op . "_" . $module;
		$func();
	}

function fn($data)
{
	$lang= get_current_language();
	return translate($data,$lang);
}

function admin_list_poll(){
	global $db, $lang, $theme_name;
	$lang = get_current_language();
	//$db = get_condb();
	$sql = "SELECT * FROM polls WHERE pol_parent_id=0";
	$rs=$db->Execute($sql);
	$i=1;

?>
	<table width="60%" border="0" align="center" cellpadding="0" cellspacing="1" id="table">
	<tr class="tr2" style="padding:3 ">
		<td class="title"><?php echo _STT?></td>
		<td class="title" width="100%"><?php echo _CONTENT?></td>
		<td></td>
		<td ></td>
	</tr>
<?php while(!$rs->EOF){ ?>
	<tr class="content" style="padding:3 ">
		<td><?php echo $i++?></td>
		<td><?php echo translate($rs->fields["pol_name"],$lang)?></td>
		<td>
		<?php 
				$pol_active=$rs->fields["pol_active"];
				if($pol_active=="1")
				$img="<span><img src=\"admin/images/1.gif\" title=\"". _ARTICLE_ACTIVE ."\"  border=\"0\"></span>";
				else $img="<span><a href=\"admin.php?opcode=module&module=poll&op=action&poll=".$rs->fields["pol_id"]."\"><img src=\"admin/images/0.gif\" title=\"". _ARTICLE_UNACTIVE ."\"  style=\"cursor:pointer\" border=\"0\"></a></span>";
					
				
				echo $img;
				?>	
		</td>
		<td><a href="admin.php?opcode=module&module=poll&op=edit&poll=<?php echo $rs->fields["pol_id"]?>"><img src="modules/poll/b_edit.png" border="0"></a></td>
		<td><a href="admin.php?opcode=module&module=poll&op=delete_action&poll=<?php echo $rs->fields["pol_id"]?>"><img src="modules/poll/b_drop.png" border="0"></a></td>		
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
	$sql="SELECT * FROM polls WHERE pol_id=" . $pol_id . " OR pol_parent_id=" . $pol_id . " ORDER BY pol_id ASC";
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

<form action="<?php echo $admin_page?>" method=post>
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
 		<td class=title><?php echo _QUESTION ?></td>
 		<td><input type=text name="fldoption_vn[0]" value="<?php echo translate($poll_arr[0]["pol_name"],"vn") ?>" size=50 > <?php echo _VIETNAMESE ?><br>
 			<input type=text name="fldoption_en[0]" value="<?php echo translate($poll_arr[0]["pol_name"],"en") ?>"size=50 > <?php echo _ENGLISH ?><br>
 		</TD>
 	</tr>
 	<tr>
 		<td class=title ><?php echo _SELECT_NUM ?></td>
 		<td class="title" style="font-size:18px; color:#FF0000"><?php echo $pol_hits; ?></td>
 	</tr>
 	<tr>
 	  <td class=title >&nbsp;</td>
 	  <td align="right"><input type=submit value="<?php echo _ACTIVE_POLL ?>" onClick="this.form.op.value='select_action'"></td>
    </tr>
 </table>
 
 <p>&nbsp;</p>
  <table border=0 align="center" style="border:1">
    <tr class="tr2"> 
      <td>&nbsp;</td>
      <td class=title><?php echo _CONTENT ?></td>
       <td class=title>&nbsp;</td>
    </tr>
    <?php
	for($i=1, $max=count($poll_arr); $i < $max;$i++) {
?>
	
    <tr class=tr_line1> 
      <td class=title ><?php echo _OPTION . " " . $i ?></td>
      <td nowrap class="content"> <input type=text name="fldoption_vn[<?php echo $i ?>]" value="<?php echo translate($poll_arr[$i]["pol_name"],"vn") ?>" size=50 > 
        <?php echo _VIETNAMESE ?><br> <input type=text name="fldoption_en[<?php echo $i ?>]" value="<?php echo translate($poll_arr[$i]["pol_name"],"en") ?>" size=50 > 
        <?php echo _ENGLISH ?><br></TD>
       
      <td><a href="<?php echo  $admin_page . "?opcode=module&module=poll&op=delete_action&poll=" . $poll_arr[$i]["pol_id"] . "&main_poll=" . $pol_id ?>"><img src="modules/poll/b_drop.png" border="0"></a></td>
    </tr>
    <?php
 		}
?>
  <tr class=tr_line1> 
      <td class=title ><?php echo _OPTION . " " . $i ?></td>
       <td nowrap class="content">
	  		<input type=text name="fldoption_vn[<?php echo $i ?>]" value="" size=50 ><?php echo _VIETNAMESE ?><br> 
			<input type=text name="fldoption_en[<?php echo $i ?>]" value="" size=50 > <?php echo _ENGLISH ?><br>
	  </TD>
     </tr>
    <tr> 
      <td colspan=5 align=center>
	  	<input type=submit value="<?php echo _UPDATE ?>" onClick="this.form.op.value='update_action'"> 
        &nbsp;&nbsp;&nbsp; <input type=submit value="<?php echo _DELETE ?>" onClick="this.form.op.value='delete_action'; return confirm('<?php echo _AREYOUSURE ?>')"> 
      </td>
    </tr>
  </table>
</form>
<?php

}
function admin_update_action_poll(){
	global $current_file, $admin_page,$db, $lang;
	$pol_id = $_GET['poll'];
	$fldpoll = $_POST['fldpoll'];
	$fldordinal = $_POST['fldordinal'];
	$fldoption_vn = $_POST['fldoption_vn'];
	$fldoption_en = $_POST['fldoption_en'];
	$fldscore = $_POST['fldscore'];
	$max=count($fldpoll); 
	for($i=0,$max=count($fldpoll); $i < $max; $i++) {
		$pol_name = get_language_form($fldoption_vn[$i],'vn') .  get_language_form($fldoption_en[$i],'en');
		$sql = "UPDATE polls SET pol_name='" . $pol_name . "', pol_order='" . $fldordinal[$i] . "' WHERE pol_id=" . $fldpoll[$i];
		$db->Execute($sql);
		
		
	
	}
	if (strlen($fldoption_vn[$max]) || strlen($fldoption_en[$max]) || strlen($fldoption_fr[$max]) ) {
		$pol_name = get_language_form($fldoption_vn[$max],'vn') .  get_language_form($fldoption_en[$max],'en');

		$sql = "INSERT INTO polls (pol_name,pol_parent_id, pol_hits) VALUES ('" . $pol_name . "'," . $pol_id . "," . $fldordinal[$max] . ")";
		$db->Execute($sql);
	}

	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	$ret_page = "admin.php?module=poll&opcode=module";
	$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 5);	
	$a->showMsg();						
	
}

function admin_create_poll(){ 
	global $admin_page;
	$ret_page = $admin_page . "?opcode=module&module=poll&op=list";
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

<form action="<?php echo $admin_page?>" method=post>
 <input type=hidden name=opcode value=module>
 <input type=hidden name=module value=poll>
 <input type=hidden name=op value="create_action">
 <input type=hidden name=ret_page value="<?php echo $ret_page ?>">
 <table width=80% border=0 align="center" >
 	<tr class=title>
 		<td ><?php echo _QUESTION ?></td>
 		<td><input type=text name="fldoption_vn[]" size=50 > <?php echo _VIETNAMESE ?><br>
 			<input type=text name="fldoption_en[]" size=50 > <?php echo _ENGLISH ?>
 		</TD>
 	</tr>
 	<tr>
 		<td class=title align="left" style="padding-left:10"><?php echo _SELECT_NUM ?></td>
 		<td>
 			<input type=text name=num size=4> &nbsp; 2 - 10 &nbsp;&nbsp;
 			<input type=button value="<?php echo _ADD ?>" onClick="this.form.num.enable=false;Gen_option(this.form.num.value)" >
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
 		for($j=1; $j <= $i;$j++) {
?>
 	<tr class=tr_line1>
 		<td class=title ><?php echo _OPTION . " " . $j ?></td>
 		<td><input type=text name="fldoption_vn[]" size=50 > <?php echo _VIETNAMESE ?><br>
 			<input type=text name="fldoption_en[]" size=50 > <?php echo _ENGLISH ?><br>
 		</TD>
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
	$main_poll = get_param("main_poll");
	
	if ($main_poll)
		$ret_page = $admin_page . "?opcode=module&module=poll&op=edit&poll=" . $main_poll;
	else
		$ret_page = $admin_page . "?opcode=module&module=poll&op=list";
	$sql="DELETE FROM polls WHERE pol_id=" . $pol_id . " OR pol_parent_id=" . $pol_id."";
	$db->Execute($sql);
	
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 5);	
	$a->showMsg();			
		
	set_session("config_tb","");	// Refresh config session
	
	$ret_page = "admin.php?module=poll&opcode=module";
	header("Location: " . $ret_page);		
}

function admin_create_action_poll(){
	global $db, $lang;
	$fldoption_vn = $_POST['fldoption_vn'];
	$fldoption_en = $_POST['fldoption_en'];	
	$fldoption = array();
	for($i=0, $max=count($fldoption_vn);$i < $max; $i++) {
		if ($fldoption_vn[$i]=="" && $fldoption_en[$i]=="" ) {
			unset($fldoption_vn[$i], $fldoption_en[$i], $fldoption_fr[$i]);
		}else
			$fldoption[] = get_language_form($fldoption_vn[$i],'vn') . get_language_form($fldoption_en[$i],'en') ;
	}
	$sql= "INSERT INTO polls (pol_name) VALUES ('" . $fldoption[0] . "')";
	$db->Execute($sql);
	$id = $db->Insert_ID();
	for($i=1, $max=count($fldoption);$i < $max; $i++) {
		$sql= "INSERT INTO polls (pol_name,pol_parent_id, pol_order) VALUES ('" . $fldoption[$i] . "'," . $id . "," . $i . ")";
		$db->Execute($sql);
	}
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	$ret_page = "admin.php?module=poll&opcode=module";
	$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 5);	
	$a->showMsg();	
	
}

function admin_add_selection_poll(){ 
	global $current_file, $db;
	$db = get_condb();
	$pol_id = get_param("poll");

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
	global $db;
	$pol_id = get_param("poll");
	
	//die("create");
	$fldoption_vn = $_POST['fldoption_vn'];
	$fldoption_en = $_POST['fldoption_en'];
	$fldordinal = $_POST['fldordinal'];
	
	$fldoption = get_language_form($fldoption_vn,'vn') . get_language_form($fldoption_en,'en');
	
	$sql= "INSERT INTO polls (pol_name,pol_parent_id, pol_hits) VALUES ('" . $fldoption . "'," . $pol_id . "," . $fldordinal . ")";
	//echo $sql;
	$db->Execute($sql);

	$ret_page = "admin.php?module=poll&opcode=module";
	header("Location: " . $ret_page);	
}

function admin_select_action_poll(){
	global $current_file, $admin_page,$db, $lang;
	$poll  = $_GET['poll'];
	$db->Execute("UPDATE polls SET pol_active= 0");		
	$db->Execute("UPDATE polls SET pol_active= 1 WHERE pol_id = " . $poll."");	
	include(_DOMAIN_ROOT_PATH . "/classes/msgbox.class.php");
	global $main_page;
	
	$ret_page = "admin.php?module=poll&opcode=module";
	if (empty($ret_page))   $ret_page=$main_page;
  	else $ret_page = urldecode($ret_page);
	
	$a=new msgBox(_UPDATE_SUCCESSFU,"OKOnly", "Message", array($ret_page), 5);	
	$a->showMsg();			
		
	set_session("config_tb","");	// Refresh config session
	
	$ret_page = "admin.php?module=poll&opcode=module";
	header("Location: " . $ret_page);	
	
}
?>