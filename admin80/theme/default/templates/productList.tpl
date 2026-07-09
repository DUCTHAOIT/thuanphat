{literal}{/literal}
<div style="text-align:right"><strong>{$countArr}</strong> {$products_in_the_list}</div>
<form name="frmList" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="" />
<input type="hidden" name="op" value="" />
<table width="100%%" border="1" cellspacing="0" cellpadding="0" class="table table-striped table-bordered dataTable">
  <tr class="tr">
    <td class="td">ID</td>
    <td class="td">{$Photo}</td>
    <td class="td">{$Product_name}</td>   
    <td class="td">{$Date_create}</td>
    <td class="td" nowrap="nowrap">{$Status}</td> 
    <td class="td" align="center">Slide ảnh</td>
    </tr>
  {foreach key=key item=item from=$arr}
  <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
   <td align="center" class="td">{$key}</td>	
    <td class="td">
	{if $item.img}
		<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$item.img}" width="70" onclick="goEdit({$key})" style="cursor:pointer" />
	{else}
		<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/none.gif" width="70" onclick="goEdit({$key})" style="cursor:pointer" />
	{/if}	</td>
    <td width="50%" class="td">
	<a href="#" class="title" onclick="goEdit({$key})">{$item.name}</a><br />
	Nhóm: <strong>{$item.nameCat}</strong></td>     
    <td align="center" class="td">{$item.date_create}</td>	
    <td align="center" class="td">
    	<label style="padding-right:5px"><img src="images/delete.gif" onclick="goDelete({$key},document.frmList)" style="cursor:pointer" title="Delete" />	</label>
	<label style="padding-right:5px" title="Edit"><img src="images/edit.gif" onclick="goEdit({$key})" style="cursor:pointer" /> </label>
	<label id="lock_{$key}" onclick="callLock({$key})" style="cursor:pointer; padding-right:5px"><img src="images/{$item.ctrl}.gif" /></label>
    </td>
  
     <td align="center" class="td"><a href="#" onclick="goPhoto({$key})"><img src="images/product_photo.jpg" border="0" /></a></td>
 
    </tr>
  {/foreach}
</table>
</form>
{$sPage}