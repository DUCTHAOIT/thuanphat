<?php
//include "include/common_action.php";
//$module_dir = "modules/poll";
//get_module_language("modules/poll");

function is_polled($poll_id) {
	return (int)get_session_var("poll_" . $poll_id);
}

function View_poll($poll_id="")
{ global $module_page;
	
	$current_file = urlencode(basename($_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING']) ;
	$lang = get_current_language();
	$db = get_condb();
	
	if (!$poll_id) $poll_id = get_config("poll");
	
	$rs = $db->Execute("SELECT * FROM poll WHERE poll_id=" . $poll_id . 
						" OR parent_poll_id=" . $poll_id . " ORDER BY ordinal ASC");
	
	if (!$rs || !$rs->RecordCount() || $rs->fields["parent_poll_id"]) return;
	
	if (is_polled($poll_id)) {
		View_result($poll_id);
	}
	else {
		begin_box_tham_gio(_POLL);
?>
	<form action="<?php echo $module_page; ?>" method=post>
	 <input type=hidden name=module value=poll>
	 <input type=hidden name=op value=vote>
	 <input type=hidden name=main_poll value="<?php echo $poll_id ?>">
	 <input type=hidden name=ret_page value="<?php echo $current_file ?>">
		  <table  border=0> 
			<tr>
				<td>
					<font class="title_poll">
				<?php				
					echo translate($rs->fields["content"],$lang);
				?>	
				</font></td>
			</tr>
<?php	
	$rs->MoveNext();
	while (!$rs->EOF) {
		echo "	<tr>
					<td><font class=content_poll><input type=radio name=poll value=" . $rs->fields["poll_id"] . ">" . translate($rs->fields["content"],$lang) . "</font></td>
				</tr>";
					
		$rs->MoveNext();				
	}
?>	
			<tr>
				<td nowrap align=center >
					<hr width="80%">
					<input type="submit" value=" <?php echo _VOTE  ?>">
					<!--<input type=button onClick="location='<?php echo $module_page . "?module=poll&op=result&poll=" . $poll_id; ?>'" value="<?php echo _RESULT ?>">	-->
				</td>
			</tr>					
		</table>
	 </form>
<?php		
		end_box_tham_gio();
	}
	
}

function Vote(){
	$db = get_condb();
	$poll = $_POST['poll'];
	$main_poll = $_POST["main_poll"];
	
	if ($poll) {
		$db->Execute("UPDATE poll SET score=score+1 WHERE poll_id=" . $poll ." OR poll_id=" . $main_poll);		
	}
	$rs = $db->Execute("SELECT * FROM poll WHERE poll_id=" . $main_poll);
	set_session_var("poll_" . $main_poll, $rs->fields["is_view"]);
		
	$ret_page = get_param("ret_page");
	echo $ret_page;
	//header("Location: " . urldecode($ret_page));
}

function View_result($poll_id) 
{	
	if (!is_polled($poll_id)) {
		echo "<b>" . _POLL_FIRST . "</b>";
		
		View_poll($poll_id);
		
		return;	
	}
	$db = get_condb();
		
	$rs = $db->Execute("SELECT * FROM poll WHERE poll_id=" . $poll_id . 
						" OR parent_poll_id=" . $poll_id . " ORDER BY ordinal ASC");
		if ($rs->RecordCount() && !$rs->fields["parent_poll_id"]) {
			Begin_draw_box_blue(_POLL . " - " . _RESULT);
			
			echo "<font class=title>" .  translate($rs->fields["content"],$lang) . " [" .$rs->fields["score"] . " " . _VOTE ."]</font><br>";	
			
			$total = $rs->fields["score"];
			$max_length = 100;  
			
			echo "<table>";
			$rs->MoveNext();
			while (!$rs->EOF) {
				echo "<tr>";
				echo "<td><font class=content>" .  translate($rs->fields["content"],$lang) . "</font></td>";
				
				$tile = round($rs->fields["score"] / $total, 2);
				echo "<td><span style=\"background-color:#CCCCCC;height:10; width=" . ($tile * $max_length). "; border=1\"></span></td>";
				echo  "<td>" . ($tile * 100). "% (" .$rs->fields["score"] . ")</td></tr>";
				
				$rs->MoveNext();
			}
		echo "</table>";
		
		End_draw_box_blue();
		}

}
?>