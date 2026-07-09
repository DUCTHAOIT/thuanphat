// JavaScript Document
//
//Begin function menu top
//
showtime = 0;
function changtab(id,count,clear){
	for(i=1;i<=count;i++){
		document.getElementById('tab_'+i).className='tab_nomal';
	}
	document.getElementById('tab_'+id).className='tab_select';
	valueHtml = document.getElementById('content_'+id).innerHTML;	
	document.getElementById('tab_content').innerHTML = valueHtml;
	if(clear==1) clearInterval(showtime);
}	
//
function mouseout(id,count){
	showtime = setInterval(function() {changtab(id,count,1)},6000);
}
//
// end function menu top
//
function view_support_online()
	{
		url="/view_support_online/";
		AjaxRequest.get(
			{
			'url':url
			,'onSuccess':function(req){document.getElementById('div_view_support_online').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)
	}
function view_support_online_home()
	{
		url="/view_support_online_home/";
		AjaxRequest.get(
			{
			'url':url
			,'onSuccess':function(req){document.getElementById('div_view_support_online_home').innerHTML=req.responseText;}
			,'onError':function(req){}
			}
		)
	}	
function windowUploadFile(fileName){
	window.open('../?m=control&f=uploadFileDownload&fileName='+ fileName,'Upload','top=350,left=250,width=500px,height=110px,scrollbars=yes');
}
function windowUploadcv(fileName){
	window.open('../?m=control&f=uploadFilecv&fileName='+ fileName,'Upload','top=350,left=250,width=500px,height=110px,scrollbars=yes');
}
function WindowUpload(fileName){
	window.open('../?m=control&f=uploadFile&fileName='+ fileName,'Upload','top=350,left=250,width=500px,height=110px,scrollbars=yes');
}
function uploadFilePhoto(fileName){
	window.open('../?m=control&f=uploadFilePhoto&fileName='+ fileName,'Upload','top=350,left=250,width=500px,height=110px,scrollbars=yes');
}
