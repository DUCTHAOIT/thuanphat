<link rel="stylesheet" type="text/css" href="../js/jscalendar_v1.4.4/source/jsCalendar.css">
<link rel="stylesheet" type="text/css" href="../js/jscalendar_v1.4.4/themes/jsCalendar.micro.css">
<script type="text/javascript" src="../js/jscalendar_v1.4.4/source/jsCalendar.js"></script>
<script type="text/javascript" src="../js/jscalendar_v1.4.4/extensions/jsCalendar.datepicker.js"></script>

<form name="frmNhanxet" action="?m=hdgopvon" method="post" enctype="multipart/form-data">
<input type="hidden" name="add_text" id="add_text" value="1">
<div class="row">
	<div class="col-xs-4 col-sm-2 col-md-2"  style="vertical-align: middle;">Ngày học:</div>
    <div class="col-xs-8 col-sm-4 col-md-4">
    	<div style="position:relative; width:100%;"><input type="text" id="date" name="date" style="width:100%" class="text" value=""  data-datepicker/>
        	<div style="position:absolute; right:0; top:0; z-index:9; width:20px; height:30px; padding-top:15px"><i class="fal fa-calendar-alt"></i></div>
    	</div>
    </div>    

	<div class="col-xs-4 col-sm-2 col-md-2"  style="vertical-align: middle;">Số giờ học:</div>
    <div class="col-xs-8 col-sm-4 col-md-4">
    	<input id="sogiohoc" type="text" class="text"  name="sogiohoc" style="width:100%"/>
    </div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-2 col-md-2">Nhận xét:</div>
    <div class="col-xs-12 col-sm-10 col-md-10">
    	<textarea id="comments" class="text" style="height: 100px; width: 100%;" name="comments"></textarea>
    </div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-2 col-md-2"></div>
    <div class="col-xs-12 col-sm-10 col-md-10">
    	<input type="button" onClick="checkSendMail(document.frmNhanxet);" value="Cập nhật" class="button" />
        <button type="submit" id="update">UPDATE</button>
    </div>
</div>
</form>
{literal}
<script>
	$(document).ready(function(){
		$("#update").click(function(){
			var date=$("#date").val();
			var sogiohoc=$("#sogiohoc").val();
			var comments=$("#comments").val();
			alert(date);
			$.ajax({
				url:'update.php',
				method:'POST',
				data:{
					name:name,
					ctgr:ctgr
				},
				success:function(response){
					alert(response);
				}
			});
		});
	});
</script>	
{/literal}