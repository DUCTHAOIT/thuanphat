<?php 
	//include_once("header.php");	
?>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js?ver=2.1.4'></script>
<script type='text/javascript' src='http://pif.vn/wp-content/plugins/mailchimp/js/scrollTo.js?ver=1.5.2'></script>
<script type='text/javascript' src='http://pif.vn/wp-includes/js/jquery/jquery.form.min.js?ver=3.37.0'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var mailchimpSF = {"ajax_url":"http:\/\/pif.vn\/"};
/* ]]> */
</script>
<script type='text/javascript' src='http://pif.vn/wp-content/plugins/mailchimp/js/mailchimp.js?ver=1.5.2'></script>
<script type='text/javascript' src='http://pif.vn/wp-includes/js/jquery/ui/core.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='http://pif.vn/wp-content/plugins/mailchimp//js/datepicker.js?ver=4.5.3'></script>
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
<script src="http://pif.vn/wp-content/themes/passioninvestment/js/moment.min.js"></script>
<script src="http://pif.vn/wp-content/themes/passioninvestment/js/highstock.js"></script>
<!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="hq">
              <div class="box_hieuquadautu">
                <div id="value"></div>
                <div class="clearfix"></div>
                <div id="container_line"></div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="ss">
              <div class="box_hieuquadautu">
                <div id="value2"></div>
                <div class="clearfix"></div>
                <div id="container_line2"></div>
              </div>
            </div>
          </div>
        </div>
        <p class="text-center" style=" font-size: 150%;margin-top: -30px">Quý khách có thể đầu tư ngay  <a class="" href="http://members.pif.vn/ContactPen">tại đây</a></p>
        <p class="text-center" style="margin-top: -5px">Xem chi tiết hiệu quả đầu tư hàng tuần <a class="" href="http://pif.vn/bao-cao-hieu-qua-dau-tu/">tại đây</a></p>
        
      </div>
    </div>
  </div>          
</section>
<script>
    // <![CDATA[
jQuery(function() {
        var rootNAV = 10000;
        var rootVNI = 574.4;
        var data = [
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
            [Date.UTC(2016, 0, 04), 0.00, 0],
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
// ]]></script>    <!--  /Hieu qua -->
<?php 
	include_once("footer.php");	
?>