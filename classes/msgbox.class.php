<style>
.msg {
    background: #f8f9fa;
    padding: 12px;
    border: 2px solid #ced4da;
    border-radius: 8px;
    font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size: 14px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: auto;
    text-align: center;
}

.msgButton {
    background: #007bff;
    color: white;
    padding: 8px 16px;
    text-decoration: none;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
    display: inline-block;
    margin: 5px;
}

.msgButton:hover {
    background: #0056b3;
}

.msgTitle {
    background: #343a40;
    color: white;
    font-size: 16px;
    font-weight: bold;
    padding: 8px;
    border-radius: 4px 4px 0 0;
}

.msglinks {
    text-decoration: none;
    color: white;
}

.msgIcon {
    font-family: Webdings;
    font-weight: bold;
    font-size: 24px;
    color: #dc3545;
    margin-bottom: 8px;
    display: block;
}
</style>
<?php
class msgBox{
	var $msgButtons;
	var $msgPrompt;	
	var $msgTitle;
	var $msgIcon;
	var $iconType; // type of icon = ("text","image")
	var $msgLinks;
	var $msgTime; // = 0 if not transfer
	var $linkTransfer;

	function __construct($prompt, $buttons, $title="Message", $linksArray=array(), $msgTime=0, $linkTransfer=""){
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
		$this->msgPrompt = $prompt;
		$this->msgTitle = $title;
		$this->msgTime = $msgTime;
		$this->linkTransfer = $linkTransfer;
		$this->msgLinks = $linksArray;
	}

	function makeLinks($linksArray){
		$this->msgLinks = $linksArray;
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
		echo "\t<td class=\"msgTitle\" colspan=\"2\" align=\"center\"><b>".$this->msgTitle."&nbsp;</b></td>";
		echo "  </tr>";
		echo "  <tr>";
		echo "\t<td width=\"5%\">";        
		if ($this->iconType=="text")
			echo "<span class=\"msgIcon\">".$this->msgIcon."</span>";
		else 
			echo "<span class=\"msgIcon\"><img src=\"".$this->msgIcon."\" border=0></span>";            
		echo "  </td>";
		echo "\t<td valign=\"top\">".$this->msgPrompt."</td>";
		echo "  </tr>";
		echo "  <tr>";
		echo "<td colspan=\"2\" valign=\"top\" align=\"center\">";
		for($idx=0; $idx < count($this->msgButtons); $idx++){
			echo "<a href=\"".$this->msgLinks[$idx]."\" class=\"msgButton\">".$this->msgButtons[$idx]."</a>";
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
?>