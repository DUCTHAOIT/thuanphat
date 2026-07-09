<?php 
	function hieuqua(){
		global $db, $smarty, $lable, $arr_info_page, $lang;
		$sql="SELECT * FROM sys_hieuqua";
		$sql.=" WHERE (ctrl&1=1) AND (lang='$lang')";
		$sql.=" ORDER BY date_create DESC";	
		$arr=$db->GetAll($sql);	
?>
<link rel="stylesheet" type="text/css" href="../../jsfile/tabview/tabview.css">
<script type="text/javascript" src="../../jsfile/tabview/yahoo-dom-event.js"></script>
<script type="text/javascript" src="../../jsfile/tabview/element-min.js"></script>
<script type="text/javascript" src="../../jsfile/tabview/tabview-min.js"></script>

<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js?ver=2.1.4'></script>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td class="yui-skin-sam" style="" valign="top" width="100%">
    <div id="demo" class="yui-navset">   
         <ul class="yui-nav">   
             <li class="selected"><a href="#tab1"><em style="font-size:16px">Hiệu quả đầu tư</em></a></li>                           
             <li><a href="#tab2"><em style="font-size:16px">So sánh với VNIndex</em></a></li>
         </ul>               
         <div class="yui-content" style="padding-top:10px">   
             <div id="tab1">
                <div>
                  <div class="box_hieuquadautu">
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
    </td>
  </tr>
</table>
<p class="title" style=" font-size:16px" align="center">Quý khách có thể đầu tư ngay  <a class="title" style="font-size:16px"  href="http://thachsanhinvestment.com.vn/vn/dang-ki-dau-tu/">tại đây</a></p>
<p class="content"  align="center">Xem chi tiết hiệu quả đầu tư hàng tuần <a class="content" href="http://thachsanhinvestment.com.vn/hoat-dong-dau-tu/bao-cao-hoat-dong-dau-tu/">tại đây</a></p>
        
     
<script>
    // <![CDATA[
jQuery(function() {
        var rootNAV = 10000;
        var rootVNI = 574.4;
        var data = [
            <?php
			for($i=0;$i<count($arr); $i++)
			{
				echo "[Date.UTC(".$arr[$i]["nam"].",".$arr[$i]["thang"].",".$arr[$i]["ngay"]."), ".$arr[$i]["giatri1"]."],\n";
			}					
			?>
			
          ];
var first = data[0];
        var firstDate = moment(first[0]);

        var last = data[data.length - 1];
        var lastDate = moment(last[0]);
        var duubli = last[1];
        $('#value').html(lastDate.format('DD.MM.YYYY') + ' <span> - Giá trị đơn vị đầu tư: ' + duubli.toLocaleString() + '</span>');
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

                    $('#value').html(moment(this.x).format('DD.MM.YYYY') + ' <span> - Giá trị đơn vị đầu tư: ' + duubli.toLocaleString()  + '</span>');
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
                    day: '%e/%y/%Y',
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
        var rootVNI = 574.4;
        var data = [
            <?php
			for($i=0;$i<count($arr); $i++)
			{
				echo "[Date.UTC(".$arr[$i]["nam"].",".$arr[$i]["thang"].",".$arr[$i]["ngay"]."), ".$arr[$i]["giatri2"].", ".$arr[$i]["giatri3"]."],\n";
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
                    day: '%e/%y/%Y',
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