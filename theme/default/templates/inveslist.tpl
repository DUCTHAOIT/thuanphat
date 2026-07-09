{literal}
<script language="javascript" type="text/javascript">
function callSearch(f){
	var keyword,obj;
	obj=document.frmSearch;
	keyword=obj.txtSearch.value;	
	if(keyword){		
		//obj.submit();
		searchDocument(f)
	}else obj.txtSearch.focus();	
	
}

function txtEnterKey(evt) 
{
   var e=(window.event)?event:evt;
	if(e.keyCode==13){
		document.getElementById('btnSearch').onclick();
		return false;
	}
}
//
function searchDocument(f){
	var status = AjaxRequest.submit(
		f
		,{
		  'url':'?m=inveslist&op=search'
		  ,'onSuccess':function(req){ document.getElementById('inveslistList').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );
	  progress('inveslistList');
	  return status;
}
</script>
{/literal}
<div class="contentFun">{$nameFun}</div>
<div class="topicContent"><h1>{$name}</h1></div>
<div style="padding-top:10px;">{inveslistList}</div>