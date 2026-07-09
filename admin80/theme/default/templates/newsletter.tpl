{literal}
	<script language="javascript">		
		function goDelete(f){
		if (confirm('Bạn có chắc chắn xóa?')!=0){			
			document.listNewsletter.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=email'
				  ,'onSuccess':function(req){ document.getElementById('listNewsletter').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listNewsletter');
			  return status;	
		}
	}
	</script>
{/literal}
<div id="listNewsletter">{listNewsletter}</div>