function createGraph(xa){
    var sa = "1.3";
    var title = "All Bids";
    var num = [1,2,3];
    var myJsonString = JSON.parse(num);
    
$(function() {
    $('#graph').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: title
        },
        xAxis: {
            categories: [
            "sadas"
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Bids'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0"></td>' +
                '<td "><b>{point.y:.1f}bids</b></td></tr>',
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
                myJsonString
            ]
        }]
    });
});
}

function ajaxGraph(num){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
            // document.getElementById('graph').innerHTML = xmlhttp.responseText;
            alert(xmlhttp.responseText)
        } // if ready state
    };

    xmlhttp.open("POST","something.php", false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(false);   
}
