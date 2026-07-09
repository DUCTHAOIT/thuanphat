{literal}
<script language="javascript" type="text/javascript">
function displayAnswer(id){
	status=document.getElementById('faq'+id).style.display;
	if(status=="none") document.getElementById('faq'+id).style.display=''; 
	else document.getElementById('faq'+id).style.display='none'; 
}
</script>
{/literal}
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">  
 <tr>
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="left" valign="top" nowrap="nowrap" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/titlebb.gif); background-repeat:repeat-x"><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/iconOther.gif" border="0" ></td>
			<td class="titleblock" width="100%" align="left" nowrap="nowrap" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/center/titlebb.gif); background-repeat:repeat-x;">Home <img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/namefun.gif" /> Comment</td>
		  </tr>
		</table>	</td>	
  </tr>
  <tr>
    <td style="padding-bottom:20px;" >{faqList}</td>
  </tr>  
</table>
