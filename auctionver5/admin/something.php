    <script type="text/javascript" src = "../js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src = "../js/jquery.js"></script>
        <script src="../../../highcharts/js/highstock.js"></script>
        <script src="../../../highcharts/js/modules/exporting.js"></script>
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script>
$(function() {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Monthly Sales of 2016'
        },
        xAxis: {
            categories: [
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Sales (per thousand pesos)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0"></td>' +
                '<td style="padding:0"><b>Php {point.y:.1f}k</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            data: [
            1,2,3,4
            ]
        }]
    });
});
</script>