<link rel="stylesheet" type="text/css" href="{$smarty.const._DOMAIN_ROOT_URL}/jsfile/jquery-popup/style.css" />
	
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="{$smarty.const._DOMAIN_ROOT_URL}/jsfile/jquery-popup/popup.js"></script>

<body onload="openOffersDialog();">
<div id="overlay" class="overlay"></div>
<div id="boxpopup" class="box">
	<a onclick="closeOffersDialog('boxpopup');" class="boxclose"></a>
	<div id="content"><img src="{$smarty.const._DOMAIN_ROOT_URL}/jsfile/jquery-popup/km.jpg" width="800px"  /></div>
</div>


<div>{producthome}</div>
<div style="padding-top:5px;">{FunctionHome}</div>
</body>
