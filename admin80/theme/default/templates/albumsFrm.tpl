<form name="frmmain" action="?m=albums" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addalbums" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="imgsmall" value="{$arr.img}" />
<input type="hidden" name="imgbig" value="{$arr.img1}" />
<input type="hidden" name="filePDF" value="{$arr.pdf}" />

<div class="topic">{$Create}</div>
<table width="100%%" border="0" cellspacing="5" cellpadding="0">
<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
  <tr class="tr" height="24">
    <td colspan="2"></td>
    </tr>
  
  <tr>
    <td colspan="2" nowrap="nowrap" style="padding-right:10px">
		<table border="0" cellspacing="5" cellpadding="0">
	  <tr>
		<td align="right" style="padding-right:10px; padding-top:10px" nowrap="nowrap">{$albums_group}: </td>
		<td width="50%" style="padding-top:10px">		
		<select name="catID" id="catID" style="border:1px solid #cccccc;" onchange="technical();">			
		{foreach key=key item=item from=$arrTopicalbums}
		{if $item.id==$arr.catID}  			
		  <option value="{$item.id}" style="padding-left:{$item.level*15}px; padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-left:{$item.level*15}px; padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}	
		{/foreach}
		</select>		</td>
	    <td width="25%" rowspan="11" valign="bottom" style="padding-top:10px">
		<div><strong>{$Photo_small_size}</strong><br />
		  <em style="color:#666666">(w: 100px - h: 100px)</em></div>
		<div id="imgsmallv"><a href="#" onclick="WindowUpload('imgsmall')"><img src="{$arr.imgs_view}" border="0" /></a></div>		</td>
	    <td width="25%" rowspan="11" valign="bottom" style="padding-top:10px"><div><strong>{$Photo_big_size}</strong><br />
	      <em style="color:#666666">(w: 500px - h: 500px)</em></div>
		<div id="imgbigv"><a href="#" onclick="WindowUpload('imgbig')"><img src="{$arr.imgb_view}" border="0" /></a></div></td>
	  </tr>
	  
	  <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">{$albums_name}: </td>
		<td><input name="name" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.name}" /></td>
	    </tr>
	  <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">{$Manufacturers}:</td>
	    <td>
		<select name="khach_hang" style="border:1px solid #cccccc;" onchange="logo_hang_san_xuat()">		
		 <option value="0" style="padding-right:10px" >&nbsp; &nbsp;------------------&nbsp;&nbsp;</option>
		{foreach key=key item=item from=$arr_khach_hang}		
		{if $item.username==$arr.khach_hang}
  			
		  <option value="{$item.username}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.username}</option>
		{else}
		  <option value="{$item.username}" style="padding-right:10px" >&nbsp; &nbsp;{$item.username}</option>
		{/if}
		{/foreach}
		</select>		
		</td>
	    </tr>
	  <tr>	
	  <!--
	  <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">Xuất xứ:</td>
	    <td><input name="model" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.model}" /></td>
	    </tr>
	  <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">{$Manufacturers}:</td>
	    <td>
		<select name="hang_san_xuat" style="border:1px solid #cccccc;" onchange="logo_hang_san_xuat()">		
		{foreach key=key item=item from=$arr_hang_san_xuat}
		{if $key==$arr.hang_san_xuat}
  			
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>
		<div id="div_logo_hang_san_xuat"></div>
		</td>
	    </tr>
	  <tr>
		<td align="right" style="padding-right:10px; text-decoration:line-through; color:#FF0000" nowrap="nowrap">{$Price_old}:</td>
		<td><input name="price_old" type="text" style="width:80%" class="text" maxlength="20" value="{$arr.price_old}" /></td>
	    </tr>
	  <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Price_new}:</td>
	    <td><input name="price_new" style="width:80%" type="text" class="text" maxlength="20" value="{$arr.price}" /></td>
	    </tr>
	  <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">{$albumss_sold_in}:</td>
	    <td><input name="albums_in" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.albums_in}" /></td>
	    </tr>	  
	  <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Delivery}:</td>
	    <td><input name="delivery" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.delivery}" /></td>
	    </tr>
	  <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Promotion}</td>
	    <td><input name="promotion" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.promotion}" /></td>
	    </tr>
	  <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">Tình Trạng:</td>
	    <td>
		<select name="tinh_trang" style="border:1px solid #cccccc;">		
		{foreach key=key item=item from=$arr_tinh_trang}
		{if $key==$arr.tinh_trang}  			
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>	
		</td>
	    </tr>
	  <tr>
		<td align="right" style="padding-right:10px" nowrap="nowrap">{$Special_promotion}</td>
		<td>
		<input name="special_promotion" type="checkbox" {if $arr.special_promotion==1} checked="checked" {/if} />
		</td>
	    </tr>
		-->
	</table>	</td>
    </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"></td>
    <td style="padding:1px; border:1px solid #cccccc; background-color:#F8F8F8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td id="filePDFv">
			{if $arr.pdf}<img src="../../images/_.pdf.gif" />{/if}			</td>
          </tr>
          <tr>
            <td><a href="#" onclick="windowUploadFile('filePDF')">{$Insert_file}</a></td>
          </tr>
        </table></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Summary}</td>
    <td width="100%"><textarea name="summary" class="textarea" style="height:100">{$arr.summary}</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Detail}: </td>
    <td>{viewFckeditor content=$arr.content}</td>
  </tr>
  
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Technical}:</td>
    <td>{viewFckeditors contents=$arr.technical}</td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Date_create}: </td>
    <td><input type="text" name="date" id="date" style="width:20%" class="text" value="{if $arr.date_create}{$arr.date_create} {else} {$date_create} {/if}" />&nbsp;
	<button id="btndate" class="button" style="height:20;">...</button> <em>( yyyy /m /d )</em></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"> </td>
    <td><div id="div_technical"></div></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Languages}:</td>
    <td>{getCboLanguage langID=$arr.lang}</td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
    <td><input type="submit" class="button" value="{$Update}" /></td>
  </tr>
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
	//
	
	function removeImg(imgName){
		document.getElementById('viewImg').innerHTML="";
		document.frmmain.img.value="";
	}
	//
	function technical(){		
		AjaxRequest.get(
			{
			'url':'?m=albums&f=search_criteria&fid='+document.frmmain.catID.value + '&id_albums=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_technical').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function khach_hang(){		
		AjaxRequest.get(
			{
			'url':'?m=albums&f=khach_hang&id_khach_hang='+document.frmmain.hang_san_xuat.value
			,'onSuccess':function(req){document.getElementById('div_khach_hang').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	technical();
	logo_hang_san_xuat();
</script>
{/literal}
</table>
</form>