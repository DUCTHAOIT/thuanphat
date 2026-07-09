<h2>Quản lý chức năng</h2>
<form name="frmmain" action="index.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="m" value="function" />
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" id="fileName" name="fileName" value="{$infoFunc.img1}" />
<input type="hidden" id="fileName2" name="fileName2" value="{$infoFunc.img2}" />
<input type="hidden" name="theme" value="default" />
<table width="100%" border="0" cellspacing="5" cellpadding="5" >
  <tr>
    <td style="padding:15px"><table width="100%" border="0" cellspacing="0" cellpadding="5" >
  <tr>
    <td>&nbsp;</td>
    <td width="100%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>{getCboFunction selectID=$infoFunc.parent}</td>
  </tr>
  <tr>
    <td>{$Function_name}</td>
    <td><input type="text" class="form-control" name="name" size="40" value="{$infoFunc.name}"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
		<div><em style="color:#666666">{$Photo_big_size}</em></div>
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td id="fileNamev" style="padding-bottom:10px; padding-top:10px">{if $infoFunc.img1}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/function/{$infoFunc.img1}" style="max-width:500" />{/if}</td>
			<td id="fileName2v" style="padding-left:40px;">{if $infoFunc.img2}<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/function/{$infoFunc.img2}" style="max-width:500"/>{/if}</td>
		  </tr>
		  <tr>
			<td nowrap="nowrap">
			<label style="cursor:pointer" onclick="WindowUpload('fileName')"><strong>Upload photo 1</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg()"><strong>Remove photo 1</strong></label></td>
			<td style="padding-left:40px;">
			<label style="cursor:pointer" onclick="WindowUpload('fileName2')"><strong>Upload photo 2</strong></lable> &nbsp; | &nbsp;
			<label style="cursor:pointer" onclick="removeImg2()"><strong>Remove photo 2</strong></label>
			</td>
		  </tr>
		</table>	
	</td>
  </tr>
  <tr>
    <td>{$Description}</td>
    <td><div id="des">{viewFckeditor content=$infoFunc.des}</div></td>
  </tr>
  <tr>
    <td>{$Function_url}</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>{$Article}</td>
        <td width="90%"><input type="radio" name="module" id="article" value="article" {if $infoFunc.module=='article'} checked="checked" {/if} /></td>
        </tr>
      
     
    <tr>
	   <tr>
        <td>Khóa học</td>
        <td><input type="radio" name="module" id="product" value="product" {if $infoFunc.module=='product'} checked="checked" {/if} /></td>
      </tr>
      <tr>
        <td>Combo</td>
        <td><input type="radio" name="module" id="gopvon" value="gopvon" {if $infoFunc.module=='gopvon'} checked="checked" {/if} /></td>
      </tr>
        <tr>
        <td style="padding-right:10px;" nowrap="nowrap">Ý kiến khách hàng</td>
        <td><input type="radio" name="module" id="worldwide" value="worldwide" {if $infoFunc.module=='worldwide'} checked="checked" {/if} /></td>
      </tr>
      
		<tr>
        <td style="padding-right:10px;">Huấn luyện viên</td>
        <td><input type="radio" name="module" id="partner" value="partner" {if $infoFunc.module=='partner'} checked="checked" {/if} /></td>
      </tr>
       <tr>
        <td>Đăng ký</td>
        <td><input type="radio" name="module" id="contact" value="contact" {if $infoFunc.module=='contact'} checked="checked" {/if} /></td>
      </tr>	  
     <!--    
      <tr>
        <td>Đăng ký</td>
        <td><input type="radio" name="module" id="invest" value="invest" {if $infoFunc.module=='invest'} checked="checked" {/if} /></td>
      </tr>
     <tr>
        <td>Video</td>
        <td><input type="radio" name="module" id="video" value="video" {if $infoFunc.module=='video'} checked="checked" {/if} /></td>
      </tr>
    <tr>
        <td>Photo</td>
        <td><input type="radio" name="module" id="photo" value="photo" {if $infoFunc.module=='photo'} checked="checked" {/if} /></td>
      </tr>
        
     
	  <tr>
        <td>Danh mục đầu tư</td>
        <td><input type="radio" name="module" id="inveslist" value="inveslist" {if $infoFunc.module=='inveslist'} checked="checked" {/if} /></td>
      </tr>
	 
     
	  -->
      
      <tr>
        <td>{$HTML}</td>
        <td><input type="radio" name="module" id="htmlpage" value="htmlpage" {if $infoFunc.module=='htmlpage'} checked="checked" {/if} onfocus="txt_htmlpage.focus()" /> ID= <input type="text" class="form-control" id="txt_htmlpage" {if $infoFunc.id_htmlpage} value="{$infoFunc.id_htmlpage}" {/if} name="txt_htmlpage" style="width:40" onfocus="htmlpage.checked=true" /></td>
        </tr>
      
    </table></td>
  </tr>  
    
  <tr>
    <td nowrap="nowrap" style="padding-right:15px">{$Show_position}</td>
    <td>{getCboPosition selectID=$infoFunc.ctrl}</td>
  </tr>
  <tr>
    <td nowrap="nowrap" style="padding-right:15px">{$Order}</td>
    <td><input type="text" class="form-control" name="order" style="width:40" value="{if !$infoFunc.sort} 0 {else} {$infoFunc.sort} {/if}" /></td>
  </tr>
  
  <tr>
    <td>{$Action}?</td>  
	<td><input type="checkbox" value="1" {if $infoFunc.ctrl & 1} checked="checked" {/if} name="action" /></td>
  </tr>
  <tr>
    <td align="left" style="padding:5px; text-transform:uppercase; background-color:#CCCCCC" nowrap="nowrap" colspan="4">Thông tin hỗ trợ SEO</td>  
  </tr>
  
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Title</td>
    <td width="100%" colspan="3"><textarea name="title"  class="form-control" style="height:100">{$infoFunc.title}</textarea></td>
  </tr>
   <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Description</td>
    <td width="100%" colspan="3"><textarea name="description"  class="form-control" style="height:100">{$infoFunc.description}</textarea></td>
  </tr>
  <tr>
    <td align="right" style="padding-right:10px" nowrap="nowrap">Keywords</td>
    <td width="100%" colspan="3"><textarea name="keywords"  class="form-control" style="height:100">{$infoFunc.keywords}</textarea></td>
  </tr>
   <tr>
  	 <td nowrap="nowrap" style="padding-right:10px">Tiêu điểm?</td>
    <td><input type="checkbox" name="focus" id="focus" value="1" {if $infoFunc.focus} checked="checked" {/if} /></td>      
  	</tr> 
  <!--
   
  <tr>
    <td>{$Action}?</td>
    <td><input type="checkbox" value="1" {if $infoFunc.ctrl & 1} checked="checked" {/if} name="action" />	</td>
  </tr>
  <tr>
    <td>Giao diện</td>
    <td>
		<select name="theme" style="border:1px solid #cccccc;">	  
		  <option value="default" style="padding-right:10px" {if $infoFunc.theme=='default'} selected="selected" {/if} >&nbsp; &nbsp;Mặc định</option>	  		
		  <option value="blue" style="padding-right:10px" {if $infoFunc.theme=='blue'} selected="selected" {/if}>&nbsp; &nbsp;blue</option>	       
		   <option value="darkblue" style="padding-right:10px" {if $infoFunc.theme=='darkblue'} selected="selected" {/if} >&nbsp; &nbsp;darkblue</option>	  
		  <option value="gray" style="padding-right:10px" {if $infoFunc.theme=='gray'} selected="selected" {/if}>&nbsp; &nbsp; gray</option>
		  <option value="green" style="padding-right:10px" {if $infoFunc.theme=='green'} selected="selected" {/if}>&nbsp; &nbsp;green</option>	       
		 </select>	
	</td>
  </tr>
  -->
  <tr>
    <td>{$Language}</td>
    <td>{getCboLanguage lang=$lang}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="padding-top:10px"><input type="button" value="{$Update}" class="btn btn-primary" onclick="checkSubmit()" />	</td>
  </tr>
</table></td>
  </tr>
</table>

</form>
<div>
{$functionList}
</div>
{literal}
  <script language="Javascript1.2">
	function removeImg(){
		document.getElementById('fileNamev').innerHTML="";
		document.frmmain.fileName.value="";
	}	
	function removeImg2(){		
		document.getElementById('fileName2v').innerHTML="";
		document.frmmain.fileName2.value="";
	}	
	function checkSubmit(){
		var obj;
		obj=document.frmmain;
		if(!obj.name.value){
			alert("Bạn cần nhập tên chức năng!");
			obj.name.focus();
			return;
		}else{		
			obj.submit();
		}
	} 	  
	</script>
{/literal}