{literal}
<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
	<script language="javascript">
		function checkForm()
		{
			var obj=document.frmmain;
			if(!obj.name.value)
			{
				alert('tinhtrang name!');
				obj.name.focus();
			}
			else
			{
				obj.submit();
			}
		}
		//
		function searchList(str)
		{
			AjaxRequest.get(
			{
			'url':'?m=product&f=tinhtrang&op=search&search='+ str
			,'onSuccess':function(req){document.getElementById('td_tinhtrangList').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
		}
	</script>
{/literal}
<div style="text-transform:uppercase" class="title">{$Management_tinhtrang}</div>
<form name="frmmain" action="?m=product&f=tinhtrang" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="add" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="logo" value="{$arr.logo}" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" valign="top" style="padding:10px; border:1px solid #D3D7DC">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right" style="padding-right:10px" nowrap="nowrap">Ngày:</td>
        <td width="100%" colspan="2" class="td">
        <input type="text" name="date" id="date" style="width:40%" class="text" value="{if $id}{$arr.date_create} {else} {$date_create} {/if}" />&nbsp;
        <button id="btndate" class="button" style="height:20;">...</button>	</td>
      </tr> 
      <tr>
        <td nowrap="nowrap" class="td title">Giá trị</td>
        <td width="100%" class="td"><input type="text" name="name" style="width:100%" value="{$arr.name}" onkeyup="searchList(this.value);" /></td>
      </tr>
	  <!--
      <tr>
        <td nowrap="nowrap" class="td">&nbsp;</td>
        <td class="td">
		<div id="logov">{if $arr.logo}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/logo/{$arr.logo}" onclick="WindowUpload('logo')" style="cursor:pointer" />{/if}</div>
		<label onclick="WindowUpload('logo')" style="cursor:pointer" class="title">{$Company_logo}</label></td>
      </tr>
	  -->
      <tr>
        <td nowrap="nowrap" class="td">&nbsp;</td>
        <td align="right" class="td"><input type="button" value="{$Update}" onclick="checkForm();" /></td>
      </tr>
    </table></td>
    <td valign="top" style="padding-left:10px" id="td_tinhtrangList">{tinhtrangList}</td>
  </tr>
</table>
</form>
{literal}
<script language="Javascript1.2">
	 Calendar.setup(
		{
		  inputField  : "date",         // ID of the input field
		  ifFormat    : "%Y-%m-%d",    // the date format
		  button      : "btndate",       // ID of the button
		  showsTime	  :	true
		}
	  );							  
	function removeImg(){
		document.getElementById('fileNamev').innerHTML="";
		document.frmmain.fileName.value="";
	}	
	function removeImg1(){
		document.getElementById('fileName1v').innerHTML="";
		document.frmmain.fileName1.value="";
	}		  
</script>

{/literal}