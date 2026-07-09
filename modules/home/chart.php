<?php
function chart(){ 
	global $db,$lang;
	$sql="SELECT * FROM sys_chiso";
	$sql.=" WHERE (ctrl&1=1) AND (lang='$lang') AND (loai=0)";
	$sql.=" ORDER BY id ASC";
	$arr=$db->GetAll($sql);	
?>
<div id="chart2"></div>
<script>
var seriesData7 = [
		<?php
		for($i=0;$i<count($arr); $i++)
		{
			$nam=date("Y", strtotime($arr[$i]["date_create"])); // gives 201101
			$thang=date("m", strtotime($arr[$i]["date_create"])); // gives 201101
			//$thang=$thang-1;			
			$ngay=date("d", strtotime($arr[$i]["date_create"])); // gives 201101
			
			
			
			//echo "[Date.UTC(".$nam.",".$thang.",".$ngay."), ".$arr[$i]["giatri1"]."],\n";
			echo "{name:'".$ngay."/".$thang."/".$nam."',y:".$arr[$i]["giatri1"]."},\n";
		}					
		?>
    ];
    var seriesData8 =  [
     <?php
		for($i=0;$i<count($arr); $i++)
		{
			$nam=date("Y", strtotime($arr[$i]["date_create"])); // gives 201101
			$thang=date("m", strtotime($arr[$i]["date_create"])); // gives 201101
			//$thang=$thang-1;			
			$ngay=date("d", strtotime($arr[$i]["date_create"])); // gives 201101
			
			
			
			//echo "[Date.UTC(".$nam.",".$thang.",".$ngay."), ".$arr[$i]["giatri1"]."],\n";
			echo "{name:'".$ngay."/".$thang."/".$nam."',y:".$arr[$i]["giatri2"]."},\n";
		}					
		?>
    ];
    var seriesData9 = [
               <?php
		for($i=0;$i<count($arr); $i++)
		{
			$nam=date("Y", strtotime($arr[$i]["date_create"])); // gives 201101
			$thang=date("m", strtotime($arr[$i]["date_create"])); // gives 201101
			//$thang=$thang-1;			
			$ngay=date("d", strtotime($arr[$i]["date_create"])); // gives 201101
			
			
			
			//echo "[Date.UTC(".$nam.",".$thang.",".$ngay."), ".$arr[$i]["giatri1"]."],\n";
			echo "{name:'".$ngay."/".$thang."/".$nam."',y:".$arr[$i]["giatri3"]."},\n";
		}					
		?>
         ];

    Highcharts.chart('chart2', {
        chart: {
            type: 'area',
            backgroundColor: 'transparent',
            style: {
                fontFamily: 'Open Sans',
            }
        },
        accessibility: {
            description: ''
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        legend:{
            itemStyle: {
                color: '#fff',
                fontWeight: '400',
                textTransform: 'uppercase',
            },
            itemHoverStyle: {
                color: '#fff'
            },
            itemCheckboxStyle: {
                width: '37px',
                height: '18px'
            },
            symbolWidth: 50
        },
        xAxis: {
            allowDecimals: false,
            labels: {
                formatter: function () {
                   return seriesData7[this.value]["name"];
                },
                style:{
                    color: '#fff',
                    fontsize: '12.5px',
                    fontweight: '300'
                },
            },
            accessibility: {
                rangeDescription: 'Range: 2018 to 2020.'
            }
        },
        yAxis: {
            title: {
                text: ''
            },
            labels: {
                formatter: function () {
                    return this.value + '%';
                },
                style:{
                    color: '#fff',
                    fontsize: '12.5px',
                    fontweight: '300'
                },
            },
            gridLineDashStyle: 'ShortDash',
            gridLineWidth: 0.8
        },
        tooltip: {
            tooltip: {
                useHTML:true,
                pointFormatter: function(){
                if ((this.index -1)< 0) {
                        return '';
                    }
                    var tang = this.y - this.series.data[(this.index -1)].y ;
                    var cr =Math.round((tang/this.y)*100);
                    return '<div>'+ this.name +'  <div> : '+ cr + ' %</div></div>';
                },
                backgroundColor: '#001434',
                borderColor: '#fff',
                style: {
                    display: 'block',
                    height: '50px',
                    color: '#fff',
                    fontWeight: '700',
                    fontsize: '20px',
                    textAlign: 'center',
                    padding: '10px 16px',
                    stroke: 'none',
                    strokeWidth: '0'
                },
                dateTimeLabelFormats:{
                    year: ' ',
                }
            },
        },
        plotOptions: {
            area: {
                // pointStart: 1940,
                marker: {
                    enabled: false,
                    symbol: 'circle',
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true
                        }
                    }
                },
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, 'rgba(57, 247, 207,0)'],
                        [1, 'rgba(57, 247, 207,0)']
                    ]
                },
                lineColor: '#00ff7f',
                lineWidth: 4,
            },
        },
        series: [{
            name: 'TSTT (%)',
            data: seriesData7,
            color: '#3cf2b2'
        }, {
            name: 'TSBV (%)',
            data:seriesData8,
            color: '#0000ff',
            lineColor: '#0000ff',
        },
            {
                name: 'VNINDEX (%)',
                data: seriesData9,
				color: '#c00',
           		lineColor: '#c00',
                
            }
        ]
    });
</script>
<?php 
}
?>