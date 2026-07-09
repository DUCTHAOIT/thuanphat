<link href="theme/default/assets/libs/select2/dist/css/select2.min.css" rel="stylesheet" />

<form name="frmmain" action="?m=inveslist" method="post" enctype="multipart/form-data">
<input type="hidden" name="op" value="update" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="fileName" value="{$arr.img}" />
<input type="hidden" id="fileName1" name="fileName1" value="{$arr.img1}" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<style type="text/css">@import url(js/jscalendar/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
  <tr>
    <td colspan="2" class="topic">Tạo mới lớp học</td>
    </tr>
  <tr>
    <td align="right"  class="td" nowrap="nowrap">Tên lớp :</td>
    <td  class="td"><input type="text" name="name" class="text" value="{$arr.name}" /></td>
  </tr>   
   
  <tr>
    <td align="right"  class="td" nowrap="nowrap">Huấn luyện viên:</td>
    <td  class="td">
	<select id="groupID" name="groupID[]" size="5" multiple="multiple" style="border:1px solid #cccccc;">
	{foreach key=key item=item from=$arrTopicinveslist}
	<option value="{$key}" style="padding-left:10px; padding-right:10px" {$item.select} >&nbsp;{$item.name} </option>
	{/foreach}	
	</select>
	</td>
  </tr>
  
  <tr>
   <td class="td">Thêm học viên</td>
   <td  class="td">
    
                      <select
                        class="select2 form-select shadow-none mt-3"
                        multiple="multiple"
                        style="height: 36px; width: 100%"
                       name="userid[]">
                       {foreach key=key item=item from=$arrHocvien}
                        <option value="{$key}"  {$item.select}  >&nbsp;{$item.name} </option>
                       {/foreach}
                      </select>
    </td>
  </tr>
 
  <tr>
    <td align="right"  class="td">Mô tả :</td>
    <td  class="td">
	{viewFckeditor content=$arr.content}	</td>
  </tr>
   <tr>
    <td align="right"  class="td" nowrap="nowrap">Địa điểm:</td>
    <td  class="td"><input type="text" name="summary" class="text" value="{$arr.summary}" /></td>
  </tr>  
   <tr>
    <td align="right"  class="td" nowrap="nowrap">Ngày khai giảng :</td>
    <td width="100%"  class="td">
	<input type="text" name="date" id="date" style="width:20%" class="text" value="{if $id}{$arr.date_create} {else} {$date_create} {/if}" />&nbsp;
	<button id="btndate" class="button" style="height:20;">...</button>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td  class="td">
	<input type="submit" value="Submit" class="btn btn-primary" />	</td>
  </tr>
  {literal}
  <script language="Javascript1.2">
		 Calendar.setup(
			{
			  inputField  : "date",         // ID of the input field
			  ifFormat    : "%Y-%m-%d",    // the date format
			  button      : "btndate",       // ID of the button
			  showsTime	  :	true
			}
		  );							  
		function removeImg(){
			document.getElementById('fileNamev').innerHTML="";
			document.frmmain.fileName.value="";
		}	
		function removeImg1(){
			document.getElementById('fileName1v').innerHTML="";
			document.frmmain.fileName1.value="";
		}		  
	</script>
	
	{/literal}
</table>
</form>
<script src="theme/default//assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="theme/default//assets/libs/select2/dist/js/select2.min.js"></script>
<script>
  //***********************************//
  // For select 2
  //***********************************//
  $(".select2").select2();

  /*colorpicker*/
  $(".demo").each(function () {
	//
	// Dear reader, it's actually very easy to initialize MiniColors. For example:
	//
	//  $(selector).minicolors();
	//
	// The way I've done it below is just for the demo, so don't get confused
	// by it. Also, data- attributes aren't supported at this time...they're
	// only used for this demo.
	//
	$(this).minicolors({
	  control: $(this).attr("data-control") || "hue",
	  position: $(this).attr("data-position") || "bottom left",

	  change: function (value, opacity) {
		if (!value) return;
		if (opacity) value += ", " + opacity;
		if (typeof console === "object") {
		  console.log(value);
		}
	  },
	  theme: "bootstrap",
	});
  });
  /*datwpicker*/
  jQuery(".mydatepicker").datepicker();
  jQuery("#datepicker-autoclose").datepicker({
	autoclose: true,
	todayHighlight: true,
  });
  var quill = new Quill("#editor", {
	theme: "snow",
  });
</script>