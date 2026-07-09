<?php 

	include_once("header.php");
		global $smarty, $lable,$arr_info_page,$db;
		$id  = getParam("id");
		
?>  
<style type="text/css">@import url(../js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="../js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="../js/jscalendar/calendar-setup.js"></script>
<form name="frmmain" action="?m=post" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="addProduct" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="imgsmall" value="{$arr.img}" />
<input type="hidden" name="imgbig" value="{$arr.img1}" />
<input type="hidden" name="filePDF" value="{$arr.pdf}" />
<table border="0" cellspacing="5" cellpadding="0" width="100%">
	  <tr>
		<td align="right" style="padding-right:10px; padding-top:10px" nowrap="nowrap">{$Product_group}: </td>
		<td width="50%" style="padding-top:10px">		
		<select name="catID" id="catID" style="border:1px solid #cccccc;" onchange="technical();">			
		{foreach key=key item=item from=$arrTopicProduct}
		{if $item.id==$arr.catID}  			
		  <option value="{$item.id}" selected="selected" >{if $item.level=='1'}&nbsp; &nbsp; {elseif $item.level=='2'}&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; {/if}{$item.name}</option>
		{else}
			<option value="{$item.id}"  style="padding-left:15px; padding-right:10px">{if $item.level=='1'} &nbsp; &nbsp; {elseif $item.level=='2'}&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; {/if}{$item.name}</option>
		{/if}	
		{/foreach}
		</select>		</td>
      </tr>
      <tr>
      	<td></tr>
	    <td  valign="bottom" style="padding-top:10px">
		<div><strong>{$Photo_small_size}</strong><br />
		  <em style="color:#666666"></em></div>
		<div id="imgsmallv"><a href="#" onclick="WindowUpload('imgsmall')"><img src="{$arr.imgs_view}" border="0" style="max-width:500px" /></a></div><label style="cursor:pointer" onclick="removeImg()"><strong>Remove photo</strong></label>			</td>
	  
	  </tr>
	  
	  <tr>
		<td align="right" style="padding-right:10px;" nowrap="nowrap">{$Product_name}: </td>
		<td><input name="name" type="text" style="width:80%" class="text" maxlength="255" value="{$arr.name}" /></td>
	  </tr>

  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap"></td>
    <td style="padding:1px; border:1px solid #cccccc; background-color:#F8F8F8" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">          
		  <tr>
            <td id="filePDFv">
			{if $arr.pdf}<img src="images/_.pdf.gif" />{/if}			</td>
          </tr>
          <tr>
            <td><a href="#" onclick="windowUploadFile('filePDF')">{$Insert_file}</a></td>
          </tr>
        </table></td>
  </tr> 

  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Thông tin chi tiết: </td>
    <td colspan="3">
    	<?php 
			viewFckeditor('content');
		?>
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
			'url':'?m=product&f=search_manufacturers&fid='+document.frmmain.catID.value + '&id_product=' + document.frmmain.id.value
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
			'url':'?m=product&f=search_xuatsu&fid='+document.frmmain.catID.value + '&id_product=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_xuatsu').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function technical(){		
		AjaxRequest.get(
			{
			'url':'?m=product&f=search_criteria&fid='+document.frmmain.catID.value + '&id_product=' + document.frmmain.id.value
			,'onSuccess':function(req){document.getElementById('div_technical').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	//
	function logo_hang_san_xuat(){		
		AjaxRequest.get(
			{
			'url':'?m=product&f=logo_hang_san_xuat&id_hang_san_xuat='+document.frmmain.hang_san_xuat.value
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
<?php 
	include_once("footer.php");
?>