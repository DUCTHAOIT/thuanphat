{literal}
<script language="javascript">
function dropCategory(obj){
	if(document.getElementById(obj).style.display == ""){		
		document.getElementById(obj).style.display = "none";
		document.frmTemp.objdrop.value = "none";	
	}
	else{
		document.getElementById(obj).style.display = "";
		document.frmTemp.objdrop.value = obj.id;
	}
}


</script>
{/literal}
<div class="container">
<div class="row">
	<div class="col-xs-12 col-sm-3 col-md-3"  style="padding-bottom:30px">
    	<div class="room-sidebar">
        	 <div>{usermenu2}</div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9 col-md-9">
        <div class="clearfix" style="height:25px"></div>
        <div class="titledaotao">Thông tin học viên</div>
        <div class="box-table" style="padding-top:10px"> 
        
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table" style="border:1px solid #CCCCCC">
          <tr style="background-color:#0b7a62">
         
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Họ tên</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Email</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Điện thoại</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Khóa học</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Cơ sở</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Số giờ học</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Số giờ đã học</strong></td>
            <td  style="vertical-align: middle; text-align:center; color:#FFFFFF; font-size:0.8rem;"><strong>Ngày bắt đầu</strong></td>
            <td  style="vertical-align: middle; text-align:cente; color:#FFFFFF; font-size:0.8rem;"><strong>Điểm danh</strong></td>
          </tr>
          {foreach key=key item=item from=$arrUserHocvien}
              <tr bgcolor="{cycle values="#ffffff,#F4F4F4"}">
              	
                
                <td style="vertical-align: middle;" align="center">{$item.name}</td>
                <td style="vertical-align: middle;" align="center">{$item.email}</td>
                <td style="vertical-align: middle;" align="center">{$item.mobile}</td>
                 <td  align="center" style="vertical-align: middle;">{nameHlv id=$item.lop}</td>
                 <td  style="text-align: center; vertical-align: middle;">{$item.cosohoc}</td>
                 <td  style="text-align: center; vertical-align: middle;">{$item.sogio}</td>
                <td  style="text-align: center; vertical-align: middle;">{$item.sogiodahoc}</td>
                <td  style="text-align: center; vertical-align: middle;">{$item.date_create}</td>
                <td align="center" style="cursor:pointer; vertical-align: middle; color:#FF0000" onClick="JavaScript:dropCategory({$key})">Chi tiết</td>
                </td>
              </tr>
              <tr id="{$key}" style="display:none;">
              	<td colspan="9">
                	<div id="diemdanh_{$key}">{diemdanh id=$key}</div>
					
                        	<link rel="stylesheet" type="text/css" href="../js/jscalendar_v1.4.4/source/jsCalendar.css">
                            <link rel="stylesheet" type="text/css" href="../js/jscalendar_v1.4.4/themes/jsCalendar.micro.css">
                            <script type="text/javascript" src="../js/jscalendar_v1.4.4/source/jsCalendar.js"></script>
                            <script type="text/javascript" src="../js/jscalendar_v1.4.4/extensions/jsCalendar.datepicker.js"></script>
                            <input type="hidden" name="userid" id="userid{$key}" value="{$userid}">
                            <input type="hidden" name="id" id="id{$key}" value="{$key}">
                            <div class="row">
                                <div class="col-xs-4 col-sm-2 col-md-2"  style="vertical-align: middle; line-height:36px">Ngày học:</div>
                                <div class="col-xs-8 col-sm-4 col-md-4">
                                    <div style="position:relative; width:100%;"><input type="text" id="date{$key}" name="date" style="width:100%" class="text" value="" data-datepicker/>
                                        <div style="position:absolute; right:0; top:0; z-index:9; width:20px; height:30px; padding-top:15px"><i class="fal fa-calendar-alt"></i></div>
                                    </div>
                                </div>    
                            
                                <div class="col-xs-4 col-sm-2 col-md-2"  style="vertical-align: middle; line-height:36px">Số giờ học:</div>
                                <div class="col-xs-8 col-sm-4 col-md-4">
                                    <input id="sogiohoc{$key}" type="text" class="text"  name="sogiohoc" style="width:100%"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 col-md-2">Nhận xét:</div>
                                <div class="col-xs-12 col-sm-10 col-md-10">
                                    <textarea id="comments{$key}" class="text" style="height: 100px; width: 100%;" name="comments"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 col-md-2"></div>
                                <div class="col-xs-12 col-sm-10 col-md-10">
                                    <button type="submit" id="update{$key}"  class="btn_viewmore3">Cập nhật</button>
                                </div>
                            </div>
                            {literal}
                            <script>
                                $(document).ready(function(){
                                    $("#update{/literal}{$key}{literal}").click(function(){
                                        var id=$("#id{/literal}{$key}{literal}").val();
										var date=$("#date{/literal}{$key}{literal}").val();
                                        var sogiohoc=$("#sogiohoc{/literal}{$key}{literal}").val();
                                        var comments=$("#comments{/literal}{$key}{literal}").val();
										var userid=$("#userid{/literal}{$key}{literal}").val();
                                        $.ajax({
                                            url:'../../?m=user&f=hlvnhanxet',
                                            method:'POST',
                                            data:{
                                                id:id,
												userid:userid,
												date:date,
												sogiohoc:sogiohoc,
                                                comments:comments
                                            },
											success: function(result){
      											$("#diemdanh_{/literal}{$key}{literal}").html(result);											
											}										
                                        });
                                    });
                                });
                            </script>	
                            {/literal}
                        

                </td>
              </tr>
           {/foreach}
        </table>
        </div>
		</div>
	</div>
</div>