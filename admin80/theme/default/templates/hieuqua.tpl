{literal}
	<script language="javascript" type="text/javascript">
		function callSearch(f)
		{			
			var status = AjaxRequest.submit(
			f
			,{
			  'url':'?m=hieuqua'
			  ,'onSuccess':function(req){ document.getElementById('listhieuqua').innerHTML=req.responseText;}
			  ,'onError':function(req){}
			}
		  );
		  progress('listhieuqua');
		  return status;		
		}	
		function goEdit(id){
			document.frmListhieuqua.id.value=id;
			document.frmListhieuqua.op.value='frm';
			document.frmListhieuqua.submit();	
		}
		//
		function goDelete(id,f){
		if (confirm('Bạn có chắc chắn xóa?')!=0){
			document.frmListhieuqua.id.value=id;
			document.frmListhieuqua.op.value='delete';
			var status = AjaxRequest.submit(
				f
				,{
				  'url':'?m=hieuqua'
				  ,'onSuccess':function(req){ document.getElementById('listhieuqua').innerHTML=req.responseText;}
				  ,'onError':function(req){}
				}
			  );
			  progress('listhieuqua');
			  return status;	
		}
	}
	//
	function btnGo_Click(evt){
		var e=(window.event)?event:evt;
		if(e.keyCode==13){
			document.getElementById('btnSearch').click(); 
			return false;
		}
	}
	function callLock(id){
		AjaxRequest.get(
			{
			'url': window.location.search + '&op=lock&id='+id
			,'onSuccess':function(req){document.getElementById('lock_'+id).innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)	
	}
	</script>
{/literal}
<div class="topic">Chart TSTT</div>
<div style="text-align:right"><a href="?m=hieuqua&op=frm" class="title">Thêm mới</a></div>
<div id="listhieuqua">{listhieuqua}</div>