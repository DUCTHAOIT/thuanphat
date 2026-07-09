<style>
.msg{
	padding: 10px;
	background-color: #FFFFFF;
	color:#000000;
    border-radius: 5px;
    box-shadow: -2px 1px 4px 1px rgba(146,146,146,146);
	
}

.msgButton{
	background:#CCCCCC;
	color:#000000;
	padding: 5px;
	font-weight:bold;	
	text-decoration: none;
	border: groove thin;
	font-size:12px;
}

.msgTitle{
	background: #FFFFFF;
	color: HighlightText;
	color:#000000;		
}

.msglinks{
	text-decoration: none;
	color: ButtonText;
}

.msgIcon{
	font-family: Webdings;
	font-weight: bolder;
	font-size: xx-large;
	color:#000000;
}
</style>
<?php
class msgBox{
	var $msgButtons;
	var $msgPrompt;	
	var $msgTitle;
	var $msgIcon;
	var $iconType;		// type of icon = ("text","image")
	var $msgLinks;
	var $msgTime;	// = 0 if not transfer
	var $linkTransfer;	//
	
	function msgBox($prompt,$buttons,$title="Message", $linksArray=array(), $msgTime=0, $linkTransfer=""){		
		switch($buttons){
			case "OKOnly" :
				$this->msgButtons=array("OK");
				$this->msgIcon="i";
				break;
			case "OKCancel":
				$this->msgButtons=array("OK","Cancel");
				$this->msgIcon="s";
				break;
			case "AbortRetryIgnore":
				$this->msgButtons=array("Abort","Retry","Ignore");
				$this->msgIcon="x";
				break;
			case "YesNoCancel":
				$this->msgButtons=array("Yes","No","Cancel");
				$this->msgIcon="s";
				break;
			case "YesNo":
				$this->msgButtons=array("Yes","No");
				$this->msgIcon="s";
				break;
			case "RetryCancel":
				$this->msgButtons=array("Retry","Cancel");
				$this->msgIcon="r";
				break;
		} // end switch
		
		$this->iconType = "text";
		
		// set the title
		$this->msgPrompt=$prompt;
		$this->msgTitle=$title;
		
		$this->msgTime = $msgTime;
		$this->linkTransfer = $linkTransfer;
		
		$this->msgLinks=$linksArray;
	}
	//
	function makeLinks($linksArray){
		$this->msgLinks=$linksArray;
	}	
	
	function setButtonText($text_arr){
		$this->msgButtons = $text_arr;
	}
	
	function setIcon($icon, $iconType="text") {
		$this->msgIcon = $icon;
	}
	
	function showMsg(){
		
		echo "<table width=\"40%\"  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"2\" class=\"msg\">";
		echo "  <tr>";
		echo "	<td class=\"msgTitle\" colspan=\"2\" align=\"left\"><b>".$this->msgTitle."&nbsp;</b></td>";
		echo "  </tr>";
		echo "  <tr>";
		echo "	<td width=\"5%\">";		
		if ($this->iconType=="text")
			echo "<span class=\"msgIcon\">".$this->msgIcon."</span>";
		else 
			echo "<span class=\"msgIcon\"><img src=\"".$this->msgIcon."\" border=0></span>";			
		echo "  </td>";
		echo "	<td valign=\"top\">".$this->msgPrompt."</td>";
		echo "  </tr>";
		echo "  <tr>";
		echo "<td colspan=\"2\" valign=\"top\" align=\"center\">";
			for($idx=0;$idx<count($this->msgButtons);$idx++){
				echo "<span class=\"msgButton\">";
				echo "<a href=\"".$this->msgLinks[$idx]."\" class=\"content\">";			
				echo $this->msgButtons[$idx];
				echo "</a>";
				echo "</span>";
				echo "&nbsp;";
			}
		echo "</td>";
		echo "  </tr>";
		echo "</table>";
		
		if ($this->msgTime) {
			if (!strlen($this->linkTransfer))
				$this->linkTransfer = $this->msgLinks[0];
			echo "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\"> \n";
			die("<meta http-equiv=\"REFRESH\" content=\"" .$this->msgTime ."; url=" . $this->linkTransfer ."\">");			
		}
	}
}
#$links=array("abort.php","retry.php","ignore.php");
#$a=new msgBox("The user login failed","AbortRetryIgnore");
#$a->makeLinks($links);
#$a->showMsg();
?>