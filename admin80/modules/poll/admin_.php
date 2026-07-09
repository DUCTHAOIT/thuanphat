<?php
if (!defined('LOADED_AS_ADMIN')) {
    echo ("You can't access this file directly...");
    return;
}
?>
<script language="JavaScript" src="js/over_tables.js"></script>
<?php
//include "include/common_action.php";
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
	$lang = get_current_language();
	$db = get_condb();
	$sql = "SELECT poll_id, content, score FROM poll WHERE parent_poll_id=0";

	$rs=$db->Execute($sql);
	$i=1;
?>
	<table width="60%" border="0" align="center" cellpadding="0" cellspacing="1" id="table">
	<tr class="tr2" style="padding:3 ">
		<td class="title"><?php echo _STT?></td>
		<td class="title" width="100%"><?php echo _CONTENT?></td>
		<td class="title" nowrap><?php echo _SELECT_NUM?></td>
		<td colspan="2"></td>
	</tr>
<?php while(!$rs->EOF){ ?>
	<tr class="content" style="padding:3 ">
		<td><?php echo $i++?></td>
		<td><?php echo translate($rs->fields["content"],$lang)?></td>
		<td><?php echo translate($rs->fields["score"],$lang)?></td>
		<td><a href="admin.php?opcode=module&module=poll&op=edit&poll=<?php echo $rs->fields["poll_id"]?>"><img src="modules/poll/b_edit.png" border="0"></a></td>
		<td><a href="admin.php?opcode=module&module=poll&op=delete_action&poll=<?php echo $rs->fields["poll_id"]?>"><img src="modules/poll/b_drop.png" border="0"></a></td>
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
{ global $current_file, $admin_page;
	$db = get_condb();
	$poll_id = get_param("poll");

	$rs = $db->Execute("SELECT * FROM poll WHERE poll_id=" . $poll_id . " OR parent_poll_id=" . $poll_id . " ORDER BY ordinal ASC");
	if (!$rs || !$rs->RecordCount())
		return;

	$poll_arr = $rs->GetArray();

?>

<form action="<?php echo $admin_page?>" method=post>
 <input type=hidden name=opcode value=module>
 <input type=hidden name=module value=poll>
 <input type=hidden name=op value="update_action">
 <input type=hidden name="fldpoll[0]" value="<?php echo $poll_id ?>">
 <input type=hidden name="poll" value="<?php echo $poll_id ?>">
 <input type=hidden name="fldordinal[0]" value="0">
 <input type=hidden name=ret_page value="<?php echo $current_file ?>">
 
 <table border=0 align="center" >
 	<tr>
 	  <td class=tr2 colspan="2">&nbsp;</td>
    </tr>
 	<tr>
 		<td class=title><?php echo _QUESTION ?></td>
 		<td><input type=text name="fldoption_vn[0]" value="<?php echo translate($poll_arr[0]["content"],"vn") ?>" size=50 > <?php echo _VIETNAMESE ?><br>
 			<input type=text name="fldoption_en[0]" value="<?php echo translate($poll_arr[0]["content"],"en") ?>"size=50 > <?php echo _ENGLISH ?><br>
 		</TD>
 	</tr>
 	<tr>
 		<td class=title ><?php echo _SELECT_NUM ?></td>
 		<td><input type=text name="fldscore[0]" value="<?php echo $poll_arr[0]["score"] ?>"  size=3>	</td>
 	</tr>
 	<tr>
 	  <td class=title >&nbsp;</td>
 	  <td align="right"><input type=submit value="<?php echo _ACTIVE_POLL ?>" onClick="this.form.op.value='select_action'"></td>
    </tr>
 <!--	<tr>
 		<td class=title><?php echo _SELECT_NUM ?></td>
 		<td>
 			<input type=text name=num size=4> &nbsp; 2 - 10 &nbsp;&nbsp;
 			<input type=button value="<?php echo _ADD ?>" onClick="this.form.num.enable=false;Gen_option(this.form.num.value)" >
 			<input type=Reset onClick="Reset()">
 		</td>
 	</tr>	-->
 </table>
 
 <p>&nbsp;</p>
  <table border=0 align="center" style="border:1">
    <tr class="tr2"> 
      <td>&nbsp;</td>
      <td class=title><?php echo _POSITION ?></td>
      <td class=title><?php echo _CONTENT ?></td>
      <td class=title><?php echo _SELECT_NUM ?></td>
      <td class=title>&nbsp;</td>
    </tr>
    <?php
	for($i=1, $max=count($poll_arr); $i < $max;$i++) {
?>
	
    <tr class=tr_line1> 
      <td class=title ><?php echo _OPTION . " " . $i ?></td>
      <td> <input type=hidden name="fldpoll[<?php echo $i ?>]" value="<?php echo $poll_arr[$i]["poll_id"] ?>"> 
        <input type=text name="fldordinal[<?php echo $i ?>]" value="<?php echo $poll_arr[$i]["ordinal"] ?>" size=3> 
      </td>
      <td nowrap class="content"> <input type=text name="fldoption_vn[<?php echo $i ?>]" value="<?php echo translate($poll_arr[$i]["content"],"vn") ?>" size=50 > 
        <?php echo _VIETNAMESE ?><br> <input type=text name="fldoption_en[<?php echo $i ?>]" value="<?php echo translate($poll_arr[$i]["content"],"en") ?>" size=50 > 
        <?php echo _ENGLISH ?><br></TD>
      <td><input type=text name="fldscore[<?php echo $i ?>]" value="<?php echo $poll_arr[$i]["score"] ?>" size=3> 
      </td>
      <td><a href="<?php echo  $admin_page . "?opcode=module&module=poll&op=delete_action&poll=" . $poll_arr[$i]["poll_id"] . "&main_poll=" . $poll_id ?>"><img src="modules/poll/b_drop.png" border="0"></a></td>
    </tr>
    <?php
 		}
?>
  <tr class=tr_line1> 
      <td class=title ><?php echo _OPTION . " " . $i ?></td>
      <td> 
        <input type=text name="fldordinal[<?php echo $i ?>]" value="<?php echo $i ?>" size=3> 
      </td>
      <td nowrap class="content">
	  		<input type=text name="fldoption_vn[<?php echo $i ?>]" value="" size=50 ><?php echo _VIETNAMESE ?><br> 
			<input type=text name="fldoption_en[<?php echo $i ?>]" value="" size=50 > <?php echo _ENGLISH ?><br>
	  </TD>
      <td><input type=text name="fldscore[<?php echo $i ?>]" value="<?php echo $poll_arr[$i]["score"] ?>" size=3> 
      </td>
      <td>&nbsp;</td>
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
	check_permit(_ADMIN_UPDATE_POLL);
	$db = get_condb();
	$poll_id = get_param("poll");
	$fldpoll = $_POST['fldpoll'];
	$fldordinal = $_POST['fldordinal'];
	$fldoption_vn = $_POST['fldoption_vn'];
	$fldoption_en = $_POST['fldoption_en'];
	$fldscore = $_POST['fldscore'];

	for($i=0,$max=count($fldpoll); $i < $max; $i++) {
		$content = get_language_form($fldoption_vn[$i],'vn') .  get_language_form($fldoption_en[$i],'en');

		$sql = "UPDATE poll SET content='" . $content . "', ordinal='" . $fldordinal[$i] . "', score='" . $fldscore[$i] . "' WHERE poll_id=" . $fldpoll[$i];
		$db->Execute($sql);
	}
	
	if (strlen($fldoption_vn[$max]) || strlen($fldoption_en[$max]) || strlen($fldoption_fr[$max]) ) {
		$content = get_language_form($fldoption_vn[$max],'vn') .  get_language_form($fldoption_en[$max],'en');

		$sql = "INSERT INTO poll (content,parent_poll_id, ordinal) VALUES ('" . $content . "'," . $poll_id . "," . $fldordinal[$max] . ")";
		$db->Execute($sql);
		
	}
	
	$ret_page = get_param("ret_page");
	header("Location: " . $ret_page);
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
 		<td class=title><?php echo _SELECT_NUM ?></td>
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
	chek_permit(_ADMIN_DELETE_POLL);
	global $admin_page;
	
	$poll_id = get_param("poll");
	$main_poll = get_param("main_poll");
	
	if ($main_poll)
		$ret_page = $admin_page . "?opcode=module&module=poll&op=edit&poll=" . $main_poll;
	else
		$ret_page = $admin_page . "?opcode=module&module=poll&op=list";
		
	$db = get_condb();

	$db->Execute("DELETE FROM poll WHERE poll_id=" . $poll_id . " OR parent_poll_id=" . $poll_id);

	header("Location: " . $ret_page);
}

function admin_create_action_poll(){
	check_permit(_ADMIN_CREATE_ACTION_POLL);
	$db = get_condb();

	//die("create");
	$fldoption_vn = $_POST['fldoption_vn'];
	$fldoption_en = $_POST['fldoption_en'];

	//print_r($fldoption_vn);
	$fldoption = array();

	for($i=0, $max=count($fldoption_vn);$i < $max; $i++) {
		if ($fldoption_vn[$i]=="" && $fldoption_en[$i]=="" ) {
			unset($fldoption_vn[$i], $fldoption_en[$i], $fldoption_fr[$i]);
		}else
			$fldoption[] = get_language_form($fldoption_vn[$i],'vn') . get_language_form($fldoption_en[$i],'en') ;
	}
	//print_r($fldoption);


	$sql= "INSERT INTO poll (content) VALUES ('" . $fldoption[0] . "')";
	$db->Execute($sql);
	$id = $db->Insert_ID();
	for($i=1, $max=count($fldoption);$i < $max; $i++) {
		$sql= "INSERT INTO poll (content,parent_poll_id, ordinal) VALUES ('" . $fldoption[$i] . "'," . $id . "," . $i . ")";
		$db->Execute($sql);
	}

	$ret_page = get_param("ret_page");
	header("Location: " . $ret_page);
}

function admin_add_selection_poll(){ 
	check_permit(_ADMIN_CREATE_ACTION_POLL);
	global $current_file;
	$db = get_condb();
	$poll_id = get_param("poll");

	$rs = $db->Execute("SELECT * FROM poll WHERE poll_id=" . $poll_id . " OR parent_poll_id=" . $poll_id . " ORDER BY ordinal ASC");
	if (!$rs || !$rs->RecordCount())
		return;

	echo "<FONT class=boxTitle >" . _ADD_MORE_OPTION . "</font>" ;
?>

<form action="<?php echo $admin_page?>" method=post>
 <input type=hidden name=opcode value=module>
 <input type=hidden name=module value=poll>
 <input type=hidden name=op value="add_selection_action">
 <input type=hidden name="poll" value="<?php echo $poll_id ?>">
 <input type=hidden name="fldordinal" value="<?php echo $rs->RecordCount(); ?>">
 <input type=hidden name=ret_page value="<?php echo $current_file ?>">
 <table width=80% border=0 align="center" >
 	<tr>
 		<td class=title><?php echo _QUESTION ?></td>
 		<td class="content">
			<input type=text value="<?php echo translate($rs->fields["content"],"vn") ?>" size=50 > <?php echo _VIETNAMESE ?><br>
 			<input type=text value="<?php echo translate($rs->fields["content"],"en") ?>" size=50 > <?php echo _ENGLISH ?>
 		</TD>
 	</tr>
 	<tr>
 		<td class=title ><?php echo _SELECT_NUM ?></td>
 		<td><input type=text name="fldscore" value="<?php echo $rs->fields["score"] ?>"  size=3></td>
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
	check_permit(_ADMIN_CREATE_ACTION_POLL);
	$db = get_condb();
	$poll_id = get_param("poll");
	
	//die("create");
	$fldoption_vn = $_POST['fldoption_vn'];
	$fldoption_en = $_POST['fldoption_en'];
	$fldordinal = $_POST['fldordinal'];
	
	$fldoption = get_language_form($fldoption_vn,'vn') . get_language_form($fldoption_en,'en');
	
	$sql= "INSERT INTO poll (content,parent_poll_id, ordinal) VALUES ('" . $fldoption . "'," . $poll_id . "," . $fldordinal . ")";
	//echo $sql;
	$db->Execute($sql);

	$ret_page = get_param("ret_page");
	header("Location: " . $ret_page);	
}

function admin_select_action_poll(){
	check_permit(_ADMIN_CREATE_ACTION_POLL);
	$db = get_condb();
	
	$poll = $_POST['poll'];
	
	$db->Execute("UPDATE config SET value='" . $poll . "' WHERE name='poll'");
	
	include(_ESA_ROOT_PATH . "/classes/msgbox.class.php");
	
	global $main_page;
	
	$ret_page = get_param("ret_page");
	if (empty($ret_page))   $ret_page=$main_page;
  	else $ret_page = urldecode($ret_page);
	
	$a=new msgBox(_POLL_ACTIVE_OK,"OKOnly", "Message", array($ret_page), 5);		
	$a->showMsg();			
		
	set_session("config_tb","");	// Refresh config session
	
	$ret_page = get_param("ret_page");
	header("Location: " . $ret_page);	
	
}
?>