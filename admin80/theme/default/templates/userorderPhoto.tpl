{literal}
<link rel="stylesheet" href="js/upload/css/style.css">

<script language="javascript" type="text/javascript">
	function goDelete(id,f){
		if (confirm('are you sure to delete?')!=0){
		document.frmList.photoID.value=id;
		document.frmList.op.value='deletePhoto';				
		var status = AjaxRequest.submit(
			f
			,{
			  'url':window.location.search
			  ,'onSuccess':function(req){ document.getElementById('productListPhoto').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );		  
		  progress('productListPhoto');
		  return status;	
		}
	}
	
	function checkSendMail(f){
		var obj;
		obj=document.frmmain;
		if(obj.img_file.value==""){
			alert("Bạn cần chọn file ảnh");
			obj.img_file.focus();
			return;
		}else{	
			
			obj.submit();					
		  }
	}
//
</script>
{/literal}
<form name="frmmain" action="?m=product" method="post" enctype="multipart/form-data" id="formUpload" onSubmit="return false;">
<input type="hidden" name="op" value="addPhoto" />
<input type="hidden" name="id" value="{$id}" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" style="padding-bottom:15px;"><strong>{$Management_products} {$arr.name}</strong></td>
    </tr>
  <tr>
    <td align="center">
		{if $arr.img}
	<img src="{$smarty.const._DOMAIN_ROOT_URL}/images/product/{$arr.img}"  width="250px"/>
	{else}
		Not image
	{/if}</td>
    <td width="100%" style="padding-left:50px">
	<div style="color:#FF0000; padding-bottom:15px"><strong>Mỗi lần cập nhật không quá 5 file ảnh</strong></div>
    <h2>Upload hình ảnh</h2>
		
			<div class="progress">
				<div class="progress-bar">0%</div>
			</div>
			<input type="file" name="img_file[]" multiple="true" onChange="previewImg(event);" id="img_file" accept="image/*">
			<div class="box-preview-img"></div>
			<div style="margin:5px"><input type="button" onclick="checkSendMail(document.frmmain);" value="Upload" class="button" /></div>
			<div class="output"></div>
		
        
	</td>
  </tr>
 
</table>
</form>
<div style="padding-bottom:10px; padding-top:10px" class="title">{$Photo_relation}</div>
<div id="productListPhoto">{productListPhoto}</div>
{literal}
<script src="js/upload/js/jquery.js"></script>
<script src="js/upload/js/jquery.form.js"></script>
<script src="js/upload/js/main.js"></script>
{/literal}