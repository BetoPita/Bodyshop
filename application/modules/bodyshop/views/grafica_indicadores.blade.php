

<div id="container_{{$tipo}}" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script>
 	var catalogo =JSON.parse('<?php echo json_encode($catalogo);?>');
 	var datos =JSON.parse('<?php echo json_encode($datos);?>');
 	var array_catalogo = [];
 	var array_datos = [];
  var tipo_grafica = "{{$tipo}}";
 	 //Armar array de catálogo
 	$.each(catalogo,function (i,item) {
	    array_catalogo.push(item.tipo);
	});

	//Fin array catálogo

	//Armar array de datos
	$.each(datos,function (i,item) {
    var array_temporal = [];
    $.each(item,function (i2,item2) {
      array_temporal.push(parseFloat(item2));
    });
	    array_datos.push({"name":i,"data":array_temporal})
	 });
	//Fin de array de datos
	Highcharts.chart('container_'+tipo_grafica, {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Indicadores de calidad'
  },
  xAxis: {
  	categories:array_catalogo,
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Valor'
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
  series: array_datos
});
</script>