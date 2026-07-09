{literal}
<script language="javascript" type="text/javascript">
function checkSendMail(f){
	var regex = /^(([\-\w]+)\.?)+@(([\-\w]+)\.?)+\.[a-zA-Z]{2,4}$/;	
	var obj;
	obj=document.frmContact;
	if(obj.name.value==""){
		alert("Name");
		obj.name.focus();
		return;		
	}else if(obj.email.value=='' || obj.email.value==null || !regex.test(obj.email.value)){
		alert("Email address!");
		obj.email.focus();
		return;
	}else if(obj.subject.value==""){
		alert("Subject");
		obj.subject.focus();
		return;
	}else if(obj.content.value==""){		
		alert("Content");
		obj.content.focus();
		return;
	}else{			
		var status = AjaxRequest.submit(
			f
			,{
			  'url':window.location.search
			  ,'onSuccess':function(req){ document.getElementById('infoContact').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('infoContact');
		  return status;
	  }
}
//
function isValidEmail(str) {
	if((str.indexOf(".") > 2) && (str.indexOf("@") > 0)){
		return true;
	}	
	else{
		return false;
	} 
}
</script>
{/literal}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td style="padding-left:20px; padding-top:20px; font-size:20px; color:#104C71" class="title" nowrap="nowrap">{$topicName}</td>
	<td width="100%">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
   	
  <tr><td width="100%" colspan="2" align="center" valign="top" style="padding-top:10px">
  <TABLE WIDTH="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0>
  {if $img1}
  <tr><td  valign="top" align="center"><img src="modules/function/images/{$img1}" /></td></tr>
  {/if}
</TABLE></td></tr>
{if $des}
  <tr>
    <td colspan="2" class="contant" style="padding:20px;">{$des}</td>
  </tr>
{/if}
  <tr>
    <td colspan="2" style="padding-right:20px;" >
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="bottom"><img src="images/flower.gif" /></td>
    <td width="100%"><table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2" align="right" class="td" style="padding-right:10px;"><h2 align="center"><strong>HERZLICH WILLKOMMEN bei Sushi-Chi</strong></h2>
       </td>
        </tr>
      <tr>
        <td align="right" class="title" style="padding-right:10px;">Adressdaten</td>
        <td class="td">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" class="td" style="padding-right:10px;">Inhaber: </td>
        <td class="td" nowrap="nowrap">Frau Minh Hang Nguyen</td>
      </tr>
      <tr>
        <td align="right" class="td" style="padding-right:10px;">Adresse:</td>
        <td class="td">Kapuzinerstr. 16</td>
      </tr>
      <tr>
        <td align="right" class="td" style="padding-right:10px;">Postleitzahl/Ort:</td>
        <td class="td">80337 München</td>
      </tr>  
      
      <tr>
        <td align="right" class="td" style="padding-right:10px;">Telefon:</td>
        <td class="td">089/26019042</td>
      </tr>     
      <tr>
        <td align="right" class="td" style="padding-right:10px;">e-mail:</td>
        <td class="td"><a href="mailto:info@sushi-chi.de">info@sushi-chi.de</a></td>
      </tr>
	  
	  <tr>
        <td align="right" class="td" style="padding-right:10px; padding-top:10px;"><strong>Lieferzeiten</strong></td>
        <td class="td">&nbsp;</td>
      </tr>
        <tr>
        <td align="right" class="td" style="padding-right:10px;" nowrap="nowrap">Montag - Freitag:</td>
        <td class="td" align="left">11.00 - 14.30 und 17.00 - 22.30 Uhr</td>
      </tr>
	  <tr>
        <td align="right" class="td" style="padding-right:10px;">Samstag:</td>
        <td class="td">17.00 - 22.30 Uhr</td>
      </tr>
      <tr>
        <td align="right" class="td" style="padding-right:10px;">Sonn- und Feiertag:</td>
        <td class="td">16.00 Uhr - 22.30 Uhr </td>
      </tr>	        
    </table></td>
  </tr>
</table>

	</td>	
  </tr>
</table>
