<?php
function newsHomeLeft(){			
	global $smarty,$lable;
	echo "<div id=\"viewnewsHome\"><script language=\"javascript\">newsHomeLeft();</script></div>";		
}
?>
<script language="javascript">
function newsHomeLeft()
{
	progress('viewnewsHome');
	AjaxRequest.get(
		{
		'url':'../../?m=control&f=viewnewsHome'
		,'onSuccess':function(req){document.getElementById('viewnewsHome').innerHTML=req.responseText;}
		,'onError':function(req){}
		}
	)		
}	
</script>