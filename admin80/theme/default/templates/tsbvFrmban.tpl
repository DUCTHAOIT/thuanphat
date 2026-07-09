<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
<form name="frmmain" action="?m=tsbv" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addtsbv" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="imgsmall" value="{$arr.img}" />
<input type="hidden" name="imgbig" value="{$arr.img1}" />
<input type="hidden" name="filePDF" value="{$arr.pdf}" />

<div class="topic">{$Create}</div>
<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr class="tr" height="24">
    <td></td>
  </tr>  
  <tr>
    <td nowrap="nowrap" style="padding-right:10px">
		<table border="0" cellspacing="5" cellpadding="0" width="100%">
	 
	  <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Số Hợp Đồng: </td>
		<td><input name="name" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.name}" /></td>
	  </tr>
      <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">Giá trị mua:</td>
		<td><input name="price_old" type="text" style="width:80%" class="text" maxlength="20" value="{$arr.price_old}" /></td>
	  </tr>
       <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Giá mua 1 ĐVĐT bình quân:</td>
	    <td><input name="price_new" style="width:80%" type="text" class="text" maxlength="20" value="{$arr.price}" /></td>
	  </tr>
       <tr>
            <td align="right" style="padding-right:10px; " nowrap="nowrap">Số lượng ĐVĐT:</td>
            <td><input name="model" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.model}" /></td>
	    </tr>
      
     
	  
      <!--

        <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Hãng:</td>
	    <td><input name="delivery" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.delivery}" /></td>
	    </tr>
         <tr>

         <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Chứng chỉ chất lượng:</td>
	    <td><input name="tsbv_in" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.tsbv_in}" /></td>
	    </tr>
       <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Đơn vị:</td>
	    <td><input name="delivery" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.delivery}" /></td>
	    </tr>

       <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">Drive mode:</td>
	    <td>
		<select name="dongsp" style="border:1px solid #cccccc;">
		{foreach key=key item=item from=$arr_dongsp}
		{if $key==$arr.dongsp}
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>
		</td>
	    </tr>

         <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">Rated power :</td>
	    <td>
		<select name="loai" style="border:1px solid #cccccc;">
		{foreach key=key item=item from=$arr_loai}
		{if $key==$arr.loai}
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>
		</td>
	    </tr>

       -->
	    <!--
         <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">lĩnh vực:</td>
	    <td>
		<select name="linhvuc" style="border:1px solid #cccccc;">
		{foreach key=key item=item from=$arr_linhvuc}
		{if $key==$arr.linhvuc}
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>
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
	  <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Link báo giá:</td>
	    <td><input name="tsbv_in" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.tsbv_in}" />(http://www.linkwebsite.com)</td>
	    </tr>
	  <tr>

	 <tr>
	    <td align="right" style="padding-right:10px" nowrap="nowrap">Tình trạng:</td>
	    <td><input name="promotion" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.promotion}" /></td>
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
	    <td align="right" style="padding-right:10px" nowrap="nowrap">{$tsbvs_sold_in}:</td>
	    <td><input name="tsbv_in" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.tsbv_in}" /></td>
	    </tr>

	</table>	</td>
    </tr>


  	-->
 
  <tr>
	    <td align="right" style="padding-right:10px; " nowrap="nowrap">Người mua:</td>
	    <td>
		<select name="userid" style="border:1px solid #cccccc;">
		{foreach key=key item=item from=$arr_user}
		{if $key==$arr.userid}
		  <option value="{$item.id}" style="padding-right:10px" selected="selected" >&nbsp; &nbsp;{$item.name}</option>
		{else}
			<option value="{$item.id}" style="padding-right:10px" >&nbsp; &nbsp;{$item.name}</option>
		{/if}
		{/foreach}
		</select>
		</td>
	    </tr>
  	
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">{$Date_create}: </td>
    <td  colspan="3"><input type="text" name="date" id="date" style="width:20%" class="text" value="{if $arr.date_create}{$arr.date_create} {else} {$date_create} {/if}" />&nbsp;
	<button id="btndate" class="button" style="height:20;">...</button> <em>( yyyy /m /d )</em></td>
  </tr>

  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">&nbsp;</td>
    <td  colspan="3"><input type="submit" class="button" value="{$Update}" /></td>
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
	//
	//
	function removeImg(){
		document.getElementById('imgsmallv').innerHTML="";
		document.frmmain.imgsmall.value="";
	}	
	//	
	function removeImg2(){
		document.getElementById('imgbigv').innerHTML="";
		document.frmmain.imgbig.value="";
	}
	//
	
	//
	//
	function manufacturers(){		
		AjaxRequest.get(
			{
			'url':'?m=tsbv&f=search_manufacturers&fid='+document.frmmain.catID.value + '&id_tsbv=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_manufacturers').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	//
	function xuatsu(){		
		AjaxRequest.get(
			{
			'url':'?m=tsbv&f=search_xuatsu&fid='+document.frmmain.catID.value + '&id_tsbv=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_xuatsu').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function technical(){		
		AjaxRequest.get(
			{
			'url':'?m=tsbv&f=search_criteria&fid='+document.frmmain.catID.value + '&id_tsbv=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_technical').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function logo_hang_san_xuat(){		
		AjaxRequest.get(
			{
			'url':'?m=tsbv&f=logo_hang_san_xuat&id_hang_san_xuat='+document.frmmain.hang_san_xuat.value
			,'onSuccess':function(req){document.getElementById('div_logo_hang_san_xuat').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	manufacturers();
	xuatsu();
	//technical();
	//logo_hang_san_xuat();
</script>
{/literal}