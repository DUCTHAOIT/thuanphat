{literal}
<script language="javascript">
function dropCategory(obj){
	if(document.getElementById(obj).style.display == ""){		
		document.getElementById(obj).style.display = "none";
		document.frmTemp.objdrop.value = "none";	
	}
	else{
		document.getElementById(obj).style.display = "";
		document.frmTemp.objdrop.value = obj.id;
	}
}

</script>
{/literal}

<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border:1px solid #a6a6a6;  border-top:0px solid #a6a6a6;"> 	
     {foreach key=key item=item from=$arr}
      {if $item.parent=='0'}     
       <tr height="25px">			  				
            <td class="titleblock" width="100%" align="center" nowrap="nowrap" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/titlebb.gif); background-repeat:repeat-x;">{$item.name}</td>
        </tr>
      {else}
      <tr>
        <td valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr id="{$item.id}" style="background-image:url({$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/bgmenu.gif); background-repeat:repeat-x">							
                <td align="left" ><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/icon.gif" vspace="5" hspace="5" border="0" /></td>
                <td width="100%" nowrap="nowrap" style="padding-left:5px"><a href="{$smarty.const._DOMAIN_ROOT_URL}/{$item.htaccess}"  id="a{$item.id}" class="title" style="color:#0061a5">{$item.name}</a></td>
                <td><img src="{$smarty.const._DOMAIN_ROOT_URL}/theme_images/block/bgmenu.gif" border="0" /></td>
              </tr>
            </table></td>        
    </tr>  
     {/if}
      {/foreach}
</table>