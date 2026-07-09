<table width="100" border="0" cellspacing="0" cellpadding="0">
{assign var="i" value=1}
{foreach key=key item=item from = $arrListfile}
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
     <td  style="border:1px solid #999999"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td nowrap="nowrap" style="padding:5px"><strong><a href="{$smarty.const._DOMAIN_ROOT_URL}/lib/{$item.logo}">{$item.name}</a></strong></td>
        <td style="padding-left:10px; padding-right:10px;"><a href="?m={$moduleName}&op=deletelistFile&id_function={$item.catID}&id_technical={$item.id}"><img src="images/delete.gif" border="0" /></a></td>
      </tr>
    </table></td>
  </tr>
{assign var="i" value=$i+1}
{/foreach}
</table>
