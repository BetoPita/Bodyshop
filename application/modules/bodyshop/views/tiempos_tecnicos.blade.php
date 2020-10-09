<h1>{{$titulo}}</h1>
<br>
<div id="container_{{$status}}" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
<script>
	var status ="{{$status}}";
    var datos =JSON.parse('<?php echo json_encode($datos);?>');
    var proyectos = [];
    var array_temporal = [];
    var data_tiempostatus = [];
    var data_tiempoproceso = [];
    var data_tiemporetraso = [];
    $.each(datos,function (i,item) {
        proyectos.push('<a target="_blank" href="'+item.url+'">'+item.proyectoNombre+'</a>');
        data_tiempostatus.splice(i,i,parseFloat(item.minutos_cita));
        data_tiempoproceso.splice(i,i,parseFloat(item.minutos_realizo_cita));
        data_tiemporetraso.splice(i,i,parseFloat(item.minutos_retraso));
    });

    Highcharts.chart('container_'+status, {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: proyectos
    },
    yAxis: [{
        min: 0,
        title: {
            text: 'Minutos'
        }
    }, {
        title: {
            text: ''
        },
        opposite: true
    }],
    legend: {
        shadow: false
    },
    tooltip: {
        shared: true
    },
    plotOptions: {
        column: {
            grouping: false,
            shadow: false,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Tiempo de estatus',
        color: 'rgba(165,170,217,1)',
        data: data_tiempostatus,
        tooltip: {
            valueSuffix: ' Minutos'
        },
        pointPadding: 0.3,
        pointPlacement: -0.2
    }, {
        name: 'Tiempo de proceso',
        color: 'rgba(126,86,134,.9)',
        data: data_tiempoproceso,
        tooltip: {
            valueSuffix: ' Minutos'
        },
        pointPadding: 0.4,
        pointPlacement: -0.2
    },{
        name: 'Tiempo de atraso',
        color: 'rgba(248,161,63,1)',
        data: data_tiemporetraso,
        tooltip: {
            valueSuffix: ' Minutos'
        },
        pointPadding: 0.4,
        pointPlacement: 0.2
    }
    // }, {
    //     name: 'Profit',
    //     color: 'rgba(248,161,63,1)',
    //     data: [183.6],
    //     tooltip: {
    //         valuePrefix: '$',
    //         valueSuffix: ' M'
    //     },
    //     pointPadding: 0.3,
    //     pointPlacement: 0.2,
    //     yAxis: 1
    // }, {
    //     name: 'Profit Optimized',
    //     color: 'rgba(186,60,61,.9)',
    //     data: [203.6],
    //     tooltip: {
    //         valuePrefix: '$',
    //         valueSuffix: ' M'
    //     },
    //     pointPadding: 0.4,
    //     pointPlacement: 0.2,
    //     yAxis: 1
    // }
    ]
});
</script>