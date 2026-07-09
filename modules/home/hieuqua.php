<?php 
	function hieuqua(){
		global $db, $smarty, $lable, $arr_info_page, $lang;
		$sql="SELECT * FROM sys_hieuqua";
		$sql.=" WHERE (ctrl&1=1) AND (lang='$lang') AND (loai=0) AND (giatri1<>'')";
		$sql.=" ORDER BY date_create ASC";	
		$arr=$db->GetAll($sql);	
		
		//$sqlupdown="SELECT sys_hieuqua.*, DATE_FORMAT(sys_hieuqua.date_create, '".format_date()."') as date_create FROM sys_hieuqua ORDER BY sys_hieuqua.date_create DESC LIMIT 0,2";		
		$sqlupdown="SELECT *, DATE_FORMAT(date_create, '".format_date()."') as datedvdt FROM  `sys_hieuqua` WHERE (ctrl&1=1) AND (loai=0) ORDER BY date_create DESC LIMIT 0 , 2";	
		$arrupdown=$db->GetAll($sqlupdown);	
?>
<div class="tab-pane fade show active" id="tab1">
    <div align="right" style="font-size:16px; color:#FFFFFF">
    	<?php
					for($i=0;$i<count($arrupdown); $i++)
					{
						if($i==0){ $giatri1=$arrupdown[$i]["giatri1"]; $datedvdt=$arrupdown[$i]["datedvdt"];}else{ $giatri2=$arrupdown[$i]["giatri1"];}												
					}	
											
						$tanggiam=($giatri1-$giatri2)/$giatri2*100;
						$tanggiam=round($tanggiam,2);
						echo "<span style=\"font-size:16px; color:#FFFFFF\">Ngày ".$datedvdt." - </span>";
						if($tanggiam>0){ echo "<span style=\"font-size:16px; color:#FFFFFF\">U ".number_format($giatri1, 0, '.', ',')."&nbsp;&nbsp;</span><span style=\"color:green\">".$tanggiam."%</span><span class=\"fa fa-arrow-up\" ></span>";}else{echo "<span style=\"font-size:16px; color:#FFFFFF\">U ".number_format($giatri1, 0, '.', ',')."&nbsp;&nbsp;</span><span style=\"color:red\">".$tanggiam."%</span><span class=\"fa fa-arrow-down\" style=\"color:red\" aria-hidden=\"true\"></span>";}
					?>
    </div>
    <div id="chart1" style="height: 335px;"></div>
   
    <div class="featured">
        <h4>ĐẶC TRƯNG GÓI ĐẦU TƯ</h4>
        <ul class="featured__list flex">
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-dt1.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-dt1-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Đầu tư vào cổ phiếu</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-company.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-company-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Tăng trưởng mạnh trong ngắn hạn</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-mt.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-mt-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Mục tiêu đầu tư 50-100%/năm</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-invest.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-invest-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Vốn đầu tư tối thiểu 10 triệu</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-db.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-db-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Sử dụng đòn bẩy tài chính</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-rr.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-rr-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Rủi ro cao</div>
            </li>
        </ul>
    </div>
</div>
<div class="tab-pane fade" id="tab2">
    <div align="right" style="font-size:16px; color:#FFFFFF">
    	<?php
					for($i=0;$i<count($arrupdown); $i++)
					{
						if($i==0){ $giatri1=$arrupdown[$i]["giatri1"]; $datedvdt=$arrupdown[$i]["datedvdt"];}else{ $giatri2=$arrupdown[$i]["giatri1"];}												
					}	
											
						$tanggiam=($giatri1-$giatri2)/$giatri2*100;
						$tanggiam=round($tanggiam,2);
						echo "<span style=\"font-size:16px; color:#FFFFFF\">Ngày ".$datedvdt." - </span>";
						if($tanggiam>0){ echo "<span style=\"font-size:16px; color:#FFFFFF\">U ".number_format($giatri1, 0, '.', ',')."&nbsp;&nbsp;</span><span style=\"color:green\">".$tanggiam."%</span><span class=\"fa fa-arrow-up\" ></span>";}else{echo "<span style=\"font-size:16px; color:#FFFFFF\">U ".number_format($giatri1, 0, '.', ',')."&nbsp;&nbsp;</span><span style=\"color:red\">".$tanggiam."%</span><span class=\"fa fa-arrow-down\" style=\"color:red\" aria-hidden=\"true\"></span>";}
					?>
    </div>
    <div id="chart4" style="height: 335px;"></div>
   
    <div class="featured">
        <h4>ĐẶC TRƯNG GÓI ĐẦU TƯ</h4>
        <ul class="featured__list flex">
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-dt1.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-dt1-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Đầu tư vào cổ phiếu</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-company.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-company-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Tăng trưởng mạnh trong ngắn hạn</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-mt.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-mt-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Mục tiêu đầu tư 50-100%/năm</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-invest.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-invest-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Vốn đầu tư tối thiểu 10 triệu</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-db.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-db-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Sử dụng đòn bẩy tài chính</div>
            </li>
            <li>
                <div class="icon">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-rr.png" class="nm" alt="">
                    <img src="<?php echo _DOMAIN_ROOT_URL;?>/assets/img/icon-rr-hv.png" class="hv" alt="">
                </div>
                <div class="txt">Rủi ro cao</div>
            </li>
        </ul>
    </div>
</div>

<script>

    var seriesData1 = [
				
               // {name:'1/10/2018',y:10000},
                //{name:'21/03/2019',y:10005},
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
	
	 var seriesData4 = [
                <?php
				for($i=0;$i<count($arr); $i++)
				{
					$nam=date("Y", strtotime($arr[$i]["date_create"])); // gives 201101
					$thang=date("m", strtotime($arr[$i]["date_create"])); // gives 201101
					//$thang=$thang-1;			
					$ngay=date("d", strtotime($arr[$i]["date_create"])); // gives 201101
					
					$tangtruongdvdt=($arr[$i]["giatri1"]-10000)/100;
					$tangtruongdvdt=round($tangtruongdvdt,2);
					
					//echo "[Date.UTC(".$nam.",".$thang.",".$ngay."), ".$arr[$i]["giatri1"]."],\n";
					echo "{name:'".$ngay."/".$thang."/".$nam."',y:".$tangtruongdvdt."},\n";
				}					
				?>
            ];
        var seriesData5 = [
		
				<?php
				for($i=0;$i<count($arr); $i++)
				{
					$nam=date("Y", strtotime($arr[$i]["date_create"])); // gives 201101
					$thang=date("m", strtotime($arr[$i]["date_create"])); // gives 201101
					//$thang=$thang-1;			
					$ngay=date("d", strtotime($arr[$i]["date_create"])); // gives 201101
					
					
					
					$tangtruongvnindex=($arr[$i]["giatri3"]-1022.90)/1022.90*100;
					$tangtruongvnindex=round($tangtruongvnindex,2);
					
					//$giatrivnindex=$arr[$i]["giatri3"]*10;
					//echo "[Date.UTC(".$nam.",".$thang.",".$ngay."), ".$arr[$i]["giatri1"]."],\n";
					echo "{name:'".$ngay."/".$thang."/".$nam."',y:".$tangtruongvnindex."},\n";
				}					
				?>
            ];
///////////
Highcharts.chart('chart1', {
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

            },
            itemHoverStyle: {
                color: '#fff'
            },
            itemCheckboxStyle: {
                width: '37px',
                height: '18px'
            },
            symbolWidth: 70
        },
        xAxis: {
             type: 'datetime',
            allowDecimals: false,
            labels: {
                formatter: function () {
                    return seriesData1[this.value]["name"];
                },
                style:{
                    color: '#fff',
                    fontsize: '12.5px',
                    fontweight: '300'
                },
                format: '{value:%Y-%m-%d}',
                rotation: 12,
                align: 'center'
            },
            accessibility: {
                rangeDescription: 'Range: 2019 to 2021.'
            },
            gridLineColor:'#fff',
            gridLineDashStyle: 'ShortDash',
            title: {
                style:{
                    color: '#fff'
                }
            },

        },
        yAxis: {
            title: {
                text: 'Giá trị đơn vị đầu tư',
                style:{
                    color: '#ffffff'
                },
                margin: 25
            },
            labels: {
                formatter: function () {
                    return this.value / 1000 + 'k';
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
            useHTML:true,
            pointFormatter: function(){
                    // if ((this.index -1)< 0) {
                    //     return '<div>'+ this.name +'  <div>'+  this.series.name +'  : 0 %</div></div>';
                    // }
                    // console.log(this);
                    // var tang = this.y - this.series.data[(this.index -1)].y ;
                    // var cr =Math.round((tang/this.y)*100);
                    // return '<div>'+ this.name +'  <div>'+  this.series.name +'  : '+cr + ' %</div></div>';
                    return '<div>'+ this.name +'  <div>'+  this.series.name +'  : '+this.y + ' (U)</div></div>';
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
        plotOptions: {
            area: {
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
                        [0, 'rgba(57, 247, 207,.6)'],
                        [1, 'rgba(57, 247, 207,0)']
                    ]
                },
                lineColor: '#00ff7f',
                lineWidth: 3,
            }
        },
        series: [{
            name: 'GIÁ TRỊ ĐƠN VỊ ĐẦU TƯ',
            data: seriesData1,
            color: '#3cf2b2'
        }]
    });
	/////
	Highcharts.chart('chart4', {
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

            },
            itemHoverStyle: {
                color: '#fff'
            },
            itemCheckboxStyle: {
                width: '37px',
                height: '18px'
            },
            symbolWidth: 70
        },
        xAxis: {
            allowDecimals: false,
            labels: {
                formatter: function () {
                    return seriesData4[this.value]["name"];
                },
                style:{
                    color: '#fff',
                    fontsize: '12.5px',
                    fontweight: '300'
                },
                align: 'center',
            },
            accessibility: {
                rangeDescription: 'Range: 2018 to 2021.'
            },
            gridLineColor:'#fff',
            gridLineDashStyle: 'ShortDash',
            title: {
                style:{
                    color: '#fff'
                }
            },

        },
        yAxis: {
            title: {
                text: 'Giá trị đơn vị đầu tư',
                style:{
                    color: '#ffffff'
                },
                margin: 25
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
            useHTML:true,
            pointFormatter: function(){
                var tang1 = this.series.chart.series[0].data[(this.index)].y - this.series.chart.series[0].data[(this.index -1)].y ;
                var tang2 = this.series.chart.series[1].data[(this.index)].y - this.series.chart.series[1].data[(this.index -1)].y ;
                   if ((this.index -1)< 0) {
                    return '<div>'+ this.name +'  <div>'+this.series.chart.series[0].name+': 0 %</div><div>'+this.series.chart.series[1].name+': 0 %</div></div>';
                   }
                   //var cr1 =Math.round((tang1/this.series.chart.series[0].data[(this.index)].y)*100);
                   //var cr2 =Math.round((tang1/this.series.chart.series[1].data[(this.index)].y)*100);
				   var cr1 =this.series.chart.series[0].data[(this.index)].y;
				   var cr2 =this.series.chart.series[1].data[(this.index)].y;

                    return '<div>'+ this.name +'  <div>'+this.series.chart.series[0].name+': '+ cr1 + ' %</div><div>'+this.series.chart.series[1].name+': '+ cr2 + ' %</div></div>';
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
        plotOptions: {
            area: {
                // pointStart: 2018,
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
                lineColor: '#00ff7f',
                lineWidth: 3,
            }
        },
        series: [{
            name: 'GIÁ TRỊ ĐƠN VỊ ĐẦU TƯ',
            data: seriesData4,
            color: '#3cf2b2',
            fillColor : {
                linearGradient : [0, 0, 0, 300],
                stops : [
                    [0, 'rgba(57, 247, 207,.6)'],
                    [1, 'rgba(57, 247, 207,0)']
                ]
            },
        },{
            name: 'VNINDEX (%)',
            data: seriesData5,
            color: '#c00',
            lineColor: '#c00',
            fillColor : {
                linearGradient : [0, 0, 0, 300],
                stops : [
                    [0, 'rgba(244, 11, 11,.6)'],
                    [1, 'rgba(244, 11, 11,0)']
                ]
            },
        }]
    });
	///////					
</script>

<?php 
	}
?>