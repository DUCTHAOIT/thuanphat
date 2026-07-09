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
		  'url':'?m=article&op=search'
		  ,'onSuccess':function(req){ document.getElementById('articleList').innerHTML=req.responseText;}
		  ,'onError':function(req){}
		}
	  );
	  progress('articleList');
	  return status;
}
</script>
{/literal}
<div class="container">
	<div class="namefun text-center">{$nameFun}</div>
	<div class="text-center">
        <h1 class="topiccontent">{$name}</h1>
    </div>
    {if $des}<div class="content" >{$des}</div>{/if}
    <div class="row" >{articleList}</div>
</div>