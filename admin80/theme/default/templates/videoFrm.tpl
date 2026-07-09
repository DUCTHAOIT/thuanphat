{literal}{/literal}
<form name="frmmain" action="?m=video" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<input type="hidden" id="fileName1" name="fileName1" value="{$arr.img1}" />
<div class="topic">{$video_infomation}</div>
<table width="100%" border="0" cellpadding="5" cellspacing="0"> 		
		   <tr>
            <td  align="right" style="padding-right:10px; padding-left:10px;" nowrap="nowrap">Đầu mục</td>
            <td class="td">
                <select name="groupID">					
                    {foreach key=key item=item from=$arrGroup}
                        {if $arr.catID==$key}
                        <option value="{$key}" selected="selected">{$item.name}</option>	
                        {else}
                        <option value="{$key}">{$item.name}</option>
                        {/if}
                    {/foreach}
                </select>
            </td>
          </tr>
          <tr>
				<td  align="right" style="padding-right:10px; padding-left:10px;" nowrap="nowrap">Tiêu đề: </td>
				<td  style="padding-right:5px"><input name="name" type="text" style="width:100%" class="text" maxlength="255" value="{$arr.name}" /></td>
		  </tr>		 
		   <tr>
			<td  align="right">Video:</td>
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td nowrap="nowrap">Lấy từ Youtobe.com</td>
					<td><input type="radio" name="youtube" id="youtubera" value="youtube" {if $arr.youtube} checked="checked" {/if} onfocus="txt_youtube.focus()"  onclick="dropCategory2()" /></td>
					<td width="100%"> Code= <input type="text" class="text" id="txt_youtube"  {if $arr.youtube} value="{$arr.youtube}" {/if} name="txt_youtube" style="width:200" onfocus="youtubera.checked=true" /></td>
				  </tr>
				  <tr>
					<td>Up file .Flv</td>
					<td><input type="radio" name="youtube" id="video" value="video" onclick="dropCategory()" {if $arr.img1} checked="checked" {/if} /></td>
					<td><div id="flv" {if !$arr.img1} style="display:none;" {/if} >
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td id="fileName1v"></td>
						  </tr>
						  {if $arr.img1}
						   <tr>
							<td><img src="../../images/att.gif" /><a href="#" onclick="windowUploadFile('fileName1')">{$arr.img1}</a></td>
						  </tr>
						  {else}
						  <tr>
							<td><img src="../../images/att.gif" /><a href="#" onclick="windowUploadFile('fileName1')">Upload file Video</a></td>
						  </tr>	  
						  {/if}
						</table>
						</div></td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				</table>

			
			</td>
	      </tr>
		  <tr>
			<td  align="right" style="padding-right:10px; padding-left:10px;" nowrap="nowrap">Mô tả: </td>
			<td  style="padding-right:5px">{viewFckeditor content=$arr.des}</td>
		  </tr>  
		   <tr>
			<td nowrap="nowrap" class="td" align="right">Thứ tự</td>
			<td class="td"><input type="text" name="no" class="text" value="{$arr.no}" style="width:50" /></td>
		  </tr>
		  <!--
		   <tr>
			<td nowrap="nowrap" class="td" align="right">Video nổi bật</td>
			<td class="td"><input name="special_promotion" type="checkbox" {if $arr.special_promotion==1} checked="checked" {/if} /></td>
		  </tr> 
		  -->
		  <tr>  
			<td  style="">&nbsp;</td>
			<td  style="padding:5px;" align="left"><input type="submit" value="Update" class="button" /></td>
		  </tr>
		</table>
</form>
{literal}
<script language="Javascript1.2">	
	function disSubmit(check){
		$("#submit_register").attr("disabled", (check == true ? false : true));
	}
	//
	function dropCategory(){
		if(document.getElementById('flv').style.display == ""){		
			document.getElementById('flv').style.display = "none";
			document.frmTemp.objdrop.value = "none";	
		}
		else{
			document.getElementById('flv').style.display = "";
			//document.frmTemp.objdrop.value = obj.id;
		}
	}
	
	function dropCategory2(){
		document.getElementById('flv').style.display = "none";
	}

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
</script>
{/literal}