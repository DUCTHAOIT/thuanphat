<!--
Danh sach chuc nang
-->
{literal}
<style>
	.yellow {
		background-color: #ddd !important;
	}
</style>
<script>


	$(function() {
		$('tr.unselected').hover(function() {
			$(this).addClass('yellow');
		}, function() {
			$(this).removeClass('yellow');
		});
	});
</script>
{/literal}
<table width="100%" border="1" cellspacing="0" cellpadding="2" class="table">
  <tr  class="tr">
    <td class="td" nowrap="nowrap">{$Function_name}</td>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Show_position}</td>
   
    <td align="center" nowrap="nowrap" style="padding-left:10px; padding-right:10px">{$Order}</td>
    <td align="center" style="padding-left:10px; padding-right:10px" nowrap="nowrap">Module</td>
   
    <td align="center" style="padding-left:10px; padding-right:10px">&nbsp;</td>
    </tr>
  {foreach key=key item=item from=$arr}
  <tr class="unselected" bgcolor="{cycle values="#FFFFFF,#F7F7F7"}">
  {assign var="padding" value=$item.level*10+10}	
    <td width="100%" class="td" nowrap="nowrap" style="padding-left:{$padding}; padding-right:20px">
	{if $item.del==1}
		<a href="?m=function&id={$item.id}" class="title">{if $item.root==true} <strong>{$item.name}</strong>{else}{$item.name}{/if}</a>
	{else} 
		{if $item.root==true} <strong>{$item.name}</strong>{else}{$item.name}{/if}
	{/if}</td>
	<td align="right" style="padding-left:10px; padding-right:10px" nowrap="nowrap">
	{foreach key=k item=i from=$arrPosition}
		{if $item.ctrl & $k}
		{$i},
		{/if}
	{/foreach}	</td>
   
    <td align="center" style="padding-left:10px; padding-right:10px">{$item.sort}</td>
    <td align="center" style="padding-left:10px; padding-right:10px" nowrap="nowrap">{if $item.module=='htmlpage'}Trang HTML{/if}{if $item.module=='article'}Bài viết{/if}{if $item.module=='product'}Khóa học{/if}{if $item.module=='gopvon'}Gói Combo{/if}{if $item.module=='contact'}Liên hệ{/if}{if $item.module=='partner'}HLV{/if}</td>
	
	<!--
  
	<td align="center" style="padding-left:10px; padding-right:10px" nowrap="nowrap">
		 {if $item.module=='product' & $item.parent>0 }<a href="?m=function&f=search_criteria&id_function={$item.id}"><img src="images/icon_search.gif"  border="0" title="Search criteria" /></a>{/if} 
	</td>
	-->
    <td align="center" style="padding-left:10px; padding-right:10px" nowrap="nowrap"> 	 
	{if $item.del==1}
		<a href="?m=function&id={$item.id}"><img src="images/edit.gif"  border="0" title="Edit" /></a>  &nbsp;<a href="?m=function&op=delete&id={$item.id}" onclick="return confirm('Bạn chắc muốn xóa?');"><img src="images/delete.gif" border="0" title="Delete" /></a> 
	{else} 
		<img src="images/edit_off.gif"  border="0" title="Edit" /> &nbsp; <img src="images/deleteOff.gif" border="0" />	
	{/if} 
    {if $item.ctrl & 2} <img src="images/security.gif" title="Security" /> {/if} {if $item.ctrl & 1} {else} <img src="images/0.gif" title="Lock" /> {/if}
    </td>
</tr>
 {/foreach}  
</table>
