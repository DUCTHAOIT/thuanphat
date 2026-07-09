<?php
function chart(){ 
	global $db,$lang;
	$sql="SELECT *, DATE_FORMAT(date_create, '".format_date()."') as date_create FROM sys_chiso";
	$sql.=" WHERE (ctrl&1=1) AND (lang='$lang') AND (loai=0)";
	$sql.=" ORDER BY id ASC LIMIT 0,60";
	$arr=$db->GetAll($sql);	
?>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "dark1", // "light2", "dark1", "dark2"
	title: {
		text: ""
	},
	axisY: {
		title: "Biến động NAV theo tuần"
	},
	data: [{
		type: "line",
		name: "TSTT (%)",
		showInLegend: "true",
		//xValueFormatString: "####",
		dataPoints: [
			<?php
			for($i=0;$i<count($arr); $i++)
			{
				
				
				echo "{ label: '".$arr[$i]["date_create"]."', y: ".$arr[$i]["giatri1"]." },\n";
			}					
			?>
		
			//{ x: 1501120673000, y: 31.142 }
		]
		
		<?php //echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	},
	{
		type: "line",
		name: "TSBV (%)",
		showInLegend: "true",
		//xValueFormatString: "####",
		dataPoints: [
			<?php
			for($i=0;$i<count($arr); $i++)
			{
				
				
				echo "{ label: '".$arr[$i]["date_create"]."', y: ".$arr[$i]["giatri2"]." },\n";
			}					
			?>
		
			//{ x: 1501120673000, y: 31.142 }
		]
	},
	{
		type: "line",
		name: "VNINDEX (%)",
		showInLegend: "true",
		//xValueFormatString: "####",
		dataPoints: [
			<?php
			for($i=0;$i<count($arr); $i++)
			{
				
				
				echo "{ label: '".$arr[$i]["date_create"]."', y: ".$arr[$i]["giatri3"]." },\n";
			}					
			?>
		
			//{ x: 1501120673000, y: 31.142 }
		]
	}]
});
chart.render();
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
} 
}
</script>
<div id="chartContainer" style="height: 370px; width: 100%; background-color:#2a2a2a"></div>
<script src="../js/canvasjs.min.js"></script>
<?php 
}
?>