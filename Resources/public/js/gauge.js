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
                point.update(inc / 1000);
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
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: null,
        pane: {
            startAngle: -150,
            endAngle: 150,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        yAxis: {
            min: 0,
            max: 10,
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',

            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'sec'
            },
            plotBands: [{
                from: 0,
                to: 2,
                color: '#55BF3B' // green
            }, {
                from: 2,
                to: 6,
                color: '#DDDF0D' // yellow
            }, {
                from: 6,
                to: 10,
                color: '#DF5353' // red
            }]
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
                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>'
            }
        }]

    }));
    update();
    setInterval(update, 10000);
});