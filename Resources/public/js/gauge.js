function update() {
    var item = $('.container-speed');
    var chart = item.highcharts();
    var point;
    var newVal;
    var inc;

    var begin = new Date();
    $.ajax({
        url: item.data().url,
        success: function(){
            if (chart) {
                current = new Date();
                inc = current.getTime()- begin.getTime();
                point = chart.series[0].points[0];
                newVal = point.y + inc;
                if (newVal < 0 || newVal > 10000) {
                    newVal = point.y - inc;
                }
                point.update(inc);
            }
        },
        error: function(){
        }
    });
}


$(function () {
//    console.log($('.container-speed').data());
    var gaugeOptions = {
        chart: {
            type: 'solidgauge'
        },
        title: null,
        pane: {
            center: ['50%', '50%'],
            size: '90%',
            startAngle: -90,
            endAngle: 90,
            background: {
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
        },
        tooltip: {
            enabled: false
        },
        yAxis: {
            min: 0,
            max: 10000,
            stops: [
                [0.1, '#55BF3B'], // green
                [0.5, '#DDDF0D'], // yellow
                [0.9, '#DF5353'] // red
            ],
            lineWidth: 0,
            minorTickInterval: null,
            tickPixelInterval: 400,
            tickWidth: 0,
            title: {
                y: -90
            },
            labels: {
                y: 16
            }
        },
        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };
    // The speed gauge
    $('.container-speed').highcharts(Highcharts.merge(gaugeOptions, {
        credits: {
            enabled: false
        },

        series: [{
            name: 'Speed',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                '<span style="font-size:12px;color:silver">mms</span></div>'
            },
            tooltip: {
                valueSuffix: ' mms'
            }
        }]

    }));
    update();
    setInterval(update, 10000);
});