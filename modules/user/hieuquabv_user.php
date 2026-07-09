<?php 
	function hieuquabv(){
		global $db, $smarty, $lable, $arr_info_page, $lang;
		$sql="SELECT * FROM sys_hieuqua";
		$sql.=" WHERE (ctrl&1=1) AND (lang='$lang') AND (loai=1)";
		$sql.=" ORDER BY date_create ASC";	
		$arr=$db->GetAll($sql);	
		
		//$sqlupdown="SELECT sys_hieuqua.*, DATE_FORMAT(sys_hieuqua.date_create, '".format_date()."') as date_create FROM sys_hieuqua ORDER BY sys_hieuqua.date_create DESC LIMIT 0,2";		
		$sqlupdown="SELECT * FROM  `sys_hieuqua` WHERE (ctrl&1=1) AND (loai=1) ORDER BY date_create DESC LIMIT 0 , 2";	
		$arrupdown=$db->GetAll($sqlupdown);	
?>
<link rel="stylesheet" type="text/css" href="../../jsfile/tabview/tabview.css">
<script type="text/javascript" src="../../jsfile/tabview/yahoo-dom-event.js"></script>
<script type="text/javascript" src="../../jsfile/tabview/element-min.js"></script>
<script type="text/javascript" src="../../jsfile/tabview/tabview-min.js"></script>

<script type='text/javascript' src='../../js/hieuqua/scrollTo.js?ver=1.5.2'></script>
<script type='text/javascript' src='../../js/hieuqua/jquery.form.min.js?ver=3.37.0'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var mailchimpSF = {"ajax_url":"http:\/\/pif.vn\/"};
/* ]]> */
</script>
<script type='text/javascript' src='../../js/hieuqua/mailchimp.js?ver=1.5.2'></script>
<script type='text/javascript' src='../../js/hieuqua/core.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='../../js/hieuqua/datepicker.js?ver=4.5.3'></script>

<script type="text/javascript">
        jQuery(function($) {
            $('.date-pick').each(function() {
                var format = $(this).data('format') || 'mm/dd/yyyy';
                format = format.replace(/yyyy/i, 'yy');
                $(this).datepicker({
                    autoFocusNextInput: true,
                    constrainInput: false,
                    changeMonth: true,
                    changeYear: true,
                    beforeShow: function(input, inst) { $('#ui-datepicker-div').addClass('show'); },
                    dateFormat: format.toLowerCase(),
                });
            });
            d = new Date();
            $('.birthdate-pick').each(function() {
                var format = $(this).data('format') || 'mm/dd';
                format = format.replace(/yyyy/i, 'yy');
                $(this).datepicker({
                    autoFocusNextInput: true,
                    constrainInput: false,
                    changeMonth: true,
                    changeYear: false,
                    minDate: new Date(d.getFullYear(), 1-1, 1),
                    maxDate: new Date(d.getFullYear(), 12-1, 31),
                    beforeShow: function(input, inst) { $('#ui-datepicker-div').removeClass('show'); },
                    dateFormat: format.toLowerCase(),
                });

            });

        });
    </script>
    
    <!-- javascript -->
<script src="../../js/hieuqua/moment.min.js"></script>
<script src="../../js/hieuqua/highstock.js"></script>
<div class="yui-skin-sam" width="100%">
    <div id="demo" class="yui-navset">   
         <ul class="yui-nav">   
             <li class="selected"><a href="#tab1"><em>Hiệu quả đầu tư</em></a></li>                           
             <li><a href="#tab2"><em>So sánh với VNIndex</em></a></li>
         </ul>               
         <div class="yui-content" style="padding-top:10px">   
             <div id="tab1">
                <div>
                  <div class="box_hieuquadautu">
                    <div style="float:right; font-size:18px" class="title">
                    <?php
					for($i=0;$i<count($arrupdown); $i++)
					{
						//if($i==0){ $giatri1=$arrupdown[$i]["giatri1"];}else{ $giatri2=$arrupdown[$i]["giatri1"];}
						if($i==0){ $giatri1=$arrupdown[$i]["giatri1"];}else{ $giatri2=$arrupdown[$i]["giatri1"];}													
					}	
											
						$tanggiam=($giatri1-$giatri2)/$giatri2*100;
						$tanggiam=round($tanggiam,2);
						if($tanggiam>0){ echo "<span style=\"font-size:16px;\">U ".number_format($giatri1, 0, '.', ',')."&nbsp;&nbsp;</span><span style=\"color:green\">".$tanggiam."%</span><span class=\"fa fa-arrow-up\" style=\"color:green\" aria-hidden=\"true\"></span>";}else{echo "<span style=\"font-size:16px;\">U ".number_format($giatri1, 0, '.', ',')."&nbsp;&nbsp;</span><span style=\"color:red\">".$tanggiam."%</span><span class=\"fa fa-arrow-down\" style=\"color:red\" aria-hidden=\"true\"></span>";}
					?>
                    </div>
                  	<div style="float:left" class="title">Ngày:&nbsp;</div>
                    <div id="value" class="title"></div>
                    <div class="clearfix"></div>
                    <div id="container_line"></div>
                  </div>
                </div>                						
             </div>
             <div id="tab2" style="width:100%">
                <div>
                  <div class="box_hieuquadautu">
                    <div style="float:left" class="title">Ngày:&nbsp;</div>
                    <div id="value2" class="title"></div>
                    <div class="clearfix"></div>
                    <div id="container_line2"></div>
                  </div>
                </div> 							
             </div>                  	
        </div>  
    </div>
</div>         
<script>
    // <![CDATA[
jQuery(function() {
        var rootNAV = 10000;
        var rootVNI = 729.87;
        var data = [
           /*
		    [Date.UTC(2016,0,4), 10000],
            [Date.UTC(2016,0,11), 10000],
            [Date.UTC(2016,0,18), 10000],
            [Date.UTC(2016,0,25), 10215],
            [Date.UTC(2016,1, 01), 10287],
            [Date.UTC(2016,1, 19), 10407],
            [Date.UTC(2016,1, 26), 10423],
            [Date.UTC(2016,2, 04), 10927],
            [Date.UTC(2016,2, 12), 10980],
            [Date.UTC(2016,2, 18), 11044],
            [Date.UTC(2016,2, 25), 11077],
            [Date.UTC(2016,3, 01), 10829],
            [Date.UTC(2016,3,7), 11019],
            [Date.UTC(2016,3, 15), 11141],
            [Date.UTC(2016,3, 22), 11188],
            [Date.UTC(2016,3, 29), 11391],
            [Date.UTC(2016,4,5), 11852],
            [Date.UTC(2016,4, 13), 11785],
            [Date.UTC(2016,4, 20), 11945],
            [Date.UTC(2016,4, 27), 12636],
            [Date.UTC(2016,5, 03), 13342],
            [Date.UTC(2016,5, 10), 13987],
            [Date.UTC(2016,5, 17), 14572],
            [Date.UTC(2016,5, 24), 16758],
            [Date.UTC(2016,6, 01), 16979],
            [Date.UTC(2016,6, 08), 17792],
            [Date.UTC(2016,6, 15), 17977],
            [Date.UTC(2016,6, 22), 17715],
            [Date.UTC(2016,6, 29), 17535],
            [Date.UTC(2016,7, 05), 17378],
            [Date.UTC(2016,7, 12), 17857],
            [Date.UTC(2016,7, 19), 18792],
            [Date.UTC(2016,7, 26), 18244],
            [Date.UTC(2016,8, 01), 18375],
            [Date.UTC(2016,8, 09), 18271],
            [Date.UTC(2016,8, 16), 17693],
            [Date.UTC(2016,8, 23), 18233],
            [Date.UTC(2016,8, 30), 18362],
            [Date.UTC(2016,9, 07), 17883],
            [Date.UTC(2016,9, 14), 18873],
            [Date.UTC(2016,9, 21), 18991],
            [Date.UTC(2016,9, 28), 18684],
            [Date.UTC(2016,10, 04), 18760],
            [Date.UTC(2016,10, 11), 19249],
            [Date.UTC(2016,10, 18), 19172],
            [Date.UTC(2016,10, 25), 19722],
            [Date.UTC(2016,11, 02), 19876],
            [Date.UTC(2016,11, 09), 19126],
            [Date.UTC(2016,11, 16), 19011],
            [Date.UTC(2016,11, 23), 19154],
            [Date.UTC(2016,11, 30), 19538],
            [Date.UTC(2016,12, 06), 19626],
            [Date.UTC(2016,12, 13), 20079],
            [Date.UTC(2016,12, 20), 19927],
            [Date.UTC(2016,12, 25), 20026],
			[Date.UTC(2017,4, 17), 10000],
			*/
            [Date.UTC(2021,1, 01), 10000],
           
			
			<?php
			for($i=0;$i<count($arr); $i++)
			{
				$nam=date("Y", strtotime($arr[$i]["date_create"])); // gives 201101
				$thang=date("m", strtotime($arr[$i]["date_create"])); // gives 201101
				$thang=$thang-1;			
				$ngay=date("d", strtotime($arr[$i]["date_create"])); // gives 201101
				echo "[Date.UTC(".$nam.",".$thang.",".$ngay."), ".$arr[$i]["giatri1"]."],\n";
			}					
			?>
          ];
		var first = data[0];
        var firstDate = moment(first[0]);

        var last = data[data.length - 1];
        var lastDate = moment(last[0]);
        var duubli = last[1];
        $('#value').html(lastDate.format('DD.MM.YYYY') + ' <span> - Giá trị đơn vị đầu tư: ' + duubli.toLocaleString() + ' (U)</span>');
        Highcharts.setOptions({
            lang: {
                thousandsSep: ',',
                decimalPoint: ','
            }
        });
        jQuery('#container_line').highcharts({
            chart: {
                type: 'spline',
            },
            credits: {
                enabled: false
            },
            title: {
                text: '',
            },
            tooltip: {
                dateTimeLabelFormats: {
                    day: '%e/%m/%Y',
                    week: '%e/%m/%Y',
                    month: '%M/%Y',
                    year: '%Y'
                },
formatter: function () {
                    var duubli = this.y;

                    $('#value').html(moment(this.x).format('DD.MM.YYYY') + ' <span> - Giá trị đơn vị đầu tư: ' + duubli.toLocaleString()  + ' (U)</span>');
                    return false;
                }
            },
            xAxis: {
                title: {
                    style: {
                        display: 'none'
                    }
                },
                type: 'datetime',
                dateTimeLabelFormats: {
                    //day: '%e/%y/%Y',
					day: '%e/%m/%Y',
                    week: '%e/%m/%Y',
                    month: '%m/%Y',
                    year: '%Y'
                },
                gridLineWidth: 1
            },
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    },
formatter: function () {
                        return Highcharts.numberFormat(this.value, 0,'.',',');
                    }
                },
                title: {
                    text: '<span style="font-family: arial,helvetica,sans-serif;">Giá trị đơn vị đầu tư</span>',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }],
            plotOptions: {

                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },
            series: [{
                type: 'area',
                name: 'Giá trị đơn vị đầu tư',
                data: data,
                pointStart: Date.UTC(2016, 0, 1),
                pointInterval: 24 * 3600 * 1000,
                
            }]
        });
    });
    jQuery(function() {

        var rootNAV = 10000;
        var rootVNI = 1022.90;
        var data = [
           /*  
            [Date.UTC(2016, 0, 11), 0.00, -2.17],
            [Date.UTC(2016, 0, 18), 0.00, -8.36],
            [Date.UTC(2016, 0, 25), 2.15, -5.57],
            [Date.UTC(2016, 1, 01), 2.87, -5.88],
            [Date.UTC(2016, 1, 19), 4.07, -3.55],
            [Date.UTC(2016, 1, 26), 4.23, -1.44],
            [Date.UTC(2016, 2, 04), 9.27, -0.12],
            [Date.UTC(2016, 2, 12), 9.80, 0.50],
            [Date.UTC(2016, 2, 18), 10.44, 0.24],
            [Date.UTC(2016, 2, 25), 10.77, -0.40],
            [Date.UTC(2016, 3, 01), 8.29, -2.79],
            [Date.UTC(2016, 3, 07), 10.19, -0.37],
            [Date.UTC(2016, 3, 15), 11.41, 0.87],
            [Date.UTC(2016, 3, 22), 11.88, 3.15],
            [Date.UTC(2016, 3, 29), 13.91, 4.17],
            [Date.UTC(2016, 4, 05), 18.52, 5.59],
            [Date.UTC(2016, 4, 13), 17.85, 6.34],
            [Date.UTC(2016, 4, 20), 19.45, 7.03],
            [Date.UTC(2016, 4, 27), 26.36, 5.87],
            [Date.UTC(2016, 5, 03), 33.42, 8.27],
            [Date.UTC(2016, 5, 10), 39.87, 9.65],
            [Date.UTC(2016, 5, 17), 45.72, 7.81],
            [Date.UTC(2016, 5, 24), 67.58, 8.07],
            [Date.UTC(2016, 6, 01), 69.79, 11.47328],
            [Date.UTC(2016, 6, 08), 77.92, 14.67],
            [Date.UTC(2016, 6, 15), 79.77, 15.7],
            [Date.UTC(2016, 6, 22), 77.15, 13.14],
            [Date.UTC(2016, 6, 29), 75.35, 13.55],
            [Date.UTC(2016, 7, 05), 73.78, 9.48],
            [Date.UTC(2016, 7, 12), 78.57, 14.16],
            [Date.UTC(2016, 7, 19), 87.92, 15.3],
            [Date.UTC(2016, 7, 26), 82.44, 16.26],
            [Date.UTC(2016, 8, 01), 83.75, 16.5],
            [Date.UTC(2016, 8, 09), 82.71, 16.2],
            [Date.UTC(2016, 8, 16), 76.93, 13.39],
            [Date.UTC(2016, 8, 23), 82.33, 17.36],
            [Date.UTC(2016, 8, 30), 83.62, 19.38],
            [Date.UTC(2016, 9, 07), 78.83, 19.07],
            [Date.UTC(2016, 9, 14), 88.73, 19.60],
            [Date.UTC(2016, 9, 21), 89.91, 19.23],
            [Date.UTC(2016, 9, 28), 86.84, 18.78],
            [Date.UTC(2016, 10, 04), 87.60, 16.07],
            [Date.UTC(2016, 10, 11), 92.49, 18.25],
            [Date.UTC(2016, 10, 18), 91.72, 17.21],
            [Date.UTC(2016, 10, 25), 97.22, 17.67],
            [Date.UTC(2016, 11, 02), 98.76, 15.8],
            [Date.UTC(2016, 11, 09), 91.26, 15.44],
            [Date.UTC(2016, 11, 16), 90.11, 17.54],
            [Date.UTC(2016, 11, 23), 91.54, 15.66],
            [Date.UTC(2016, 11, 30), 95.38, 15.75],
            [Date.UTC(2016, 12, 06), 96.26, 18.35],
            [Date.UTC(2016, 12, 13), 100.79, 19.27],
            [Date.UTC(2016, 12, 20), 99.27, 19.47],
            [Date.UTC(2016, 12, 25), 100.26,21.39],
            [Date.UTC(2017, 1, 3), 107.47,21.93],
            [Date.UTC(2017, 1, 10), 109.85,22.52],
            [Date.UTC(2017, 1, 17), 114.23,23.23],
            [Date.UTC(2017, 1, 24), 110.25,24.39],
            [Date.UTC(2017, 2, 3), 110.89,24.06],
			[Date.UTC(2017, 0, 04), 0.00, 0],
			*/
			
		 <?php
			for($i=0;$i<count($arr); $i++)
			{
				$nam=date("Y", strtotime($arr[$i]["date_create"])); // gives 201101
				$thang=date("m", strtotime($arr[$i]["date_create"])); // gives 201101
				$thang=$thang-1;			
				$ngay=date("d", strtotime($arr[$i]["date_create"])); // gives 201101	
				
				//$tanggiam=($giatri1-$giatri2)/$giatri2*100;
				$tangtruongdvdt=($arr[$i]["giatri1"]-10000)/100;
				$tangtruongdvdt=round($tangtruongdvdt,2);
				
				$tangtruongvnindex=($arr[$i]["giatri3"]-1022.90)/1022.90*100;
				$tangtruongvnindex=round($tangtruongvnindex,2);
						
				
							
				echo "[Date.UTC(".$nam.",".$thang.",".$ngay."), ".$tangtruongdvdt.", ".$tangtruongvnindex."],\n";
			}					
		  ?>	
        ];
        var data1 = [];
        var data2= [];
        for (i=0; i< data.length; i++) {
            time = data[i][0];
            pi = data[i][1];
            vni = data[i][2];
            data1[i] = [time,pi];
            data2[i] = [time,vni];
        }
        console.log(data1);
        var first = data[0];
        var firstDate = moment(first[0]);

        var last = data[data.length - 1];
        var lastDate = moment(last[0]);
        var duubli = last[1];
        $('#value2').html(lastDate.format('DD.MM.YYYY') + ' - <span> Tăng trưởng đầu tư: ' + duubli.toFixed(2) + '%</span>');
        Highcharts.setOptions({
            lang: {
                thousandsSep: ',',
                decimalPoint: ','
            }
        });
        jQuery('#container_line2').highcharts({
            chart: {
                type: 'spline',
            },
            rangeSelector: {
                selected: 1
            },
            credits: {
                enabled: false
            },
            title: {
                text: '',
            },
            tooltip: {
                dateTimeLabelFormats: {
                    day: '%e/%m/%Y',
                    week: '%e/%m/%Y',
                    month: '%M/%Y',
                    year: '%Y'
                },
valueSuffix: ' %',
                shared: true
            },
            xAxis: {
                title: {
                    style: {
                        display: 'none'
                    }
                },
                type: 'datetime',
                dateTimeLabelFormats: {
                   // day: '%e/%y/%Y',
				    day: '%e/%m/%Y',
                    week: '%e/%m/%Y',
                    month: '%m/%Y',
                    year: '%Y'
                },
                gridLineWidth: 1
            },
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value} Tr',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    },
                    formatter: function () {
                        return Highcharts.numberFormat(this.value, 0,'.',',');
                    }
                },
                title: {
                    text: '<span style="font-family: arial,helvetica,sans-serif;">Tăng trưởng đơn vị đầu tư</span>',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }],
            plotOptions: {
                area: {
                    
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
                type: 'area',
                name: 'Tăng trưởng đơn vị đầu tư ',
                data: data1,
                color: '#00a651',
            },
            {
                type: 'area',
                name: 'VNindex',
                data: data2,
                color: '#0088FF',
            }
            ]
        });
    });
var tabView = new YAHOO.widget.TabView('demo');  	
// ]]></script>    <!--  /Hieu qua -->

<?php 
	}
?>