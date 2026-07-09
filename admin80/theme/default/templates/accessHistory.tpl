<table width="100%" border="1" cellspacing="0" cellpadding="0" class="table">
{assign var="i" value="1"}
{foreach key=key item=item from=$arr}
  <tr height="25" bgcolor="{cycle values="#ffffff,#F4F4F4"}">
    <td class="td">{$i}</td>
    <td class="td">{$item.ip}</td>
    <td class="td"><img src="images/flags/{$item.code|lower}.png" /></td>
    <td class="td">{$item.date}</td>
  </tr>
  {assign var="i" value="$i+1"}
{/foreach}
</table>
