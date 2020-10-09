
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Dashboard</h2>
        <a href="<?php echo base_url();?>index.php/bodyshop" class="btn btn-primary">Regresar</a>
        <button id="btnAddProyecto" class="btn btn-primary pull-right" type="button">Crear proyecto</button>
    </div>
    <div class="row">
      <div class="col-sm-12">
      <div id="chart"></div>
      </div>
    </div>
    
</div>
<script src="../../statics/js/custom/d3.v5.min.js" charset="utf-8"></script>
<script>
  var site_url = "<?php echo site_url();?>";
  var json =JSON.parse('<?php echo json_encode($data);?>');
  var totales = ['Total'];
  var totalesAtrasados = ['Total Atrasados'];
  var nombres = [];
  $.each(json,function (i,item) {
    totales.push(item.total);
    totalesAtrasados.push(item.totalAtrasados);
    nombres.push(item.nombre);
  })
  console.log(nombres);
  var chart = c3.generate({
  data: {
      columns: [
          totales,
          totalesAtrasados
      ]
  },
  axis: {
      x: {
          type: 'category',
          categories: nombres
      }
  }
  });

  $("#btnAddProyecto").on('click',function(){
    console.log('click');
      customModal(
          site_url+"/bodyshop/crear_proyecto/true",
            {},
          "GET",
          'lg',
          callback_guardar_proyecto,
          "",
          "Guardar",
          "",
          "Crear proyecto",
          "modalModelo"
      );
  });
  function callback_guardar_proyecto()
    {
      $("[class*='error_']").empty();
      ajaxJson(site_url+"/bodyshop/save_proyecto", $('#frmProyecto').serialize(), "POST", true, function(result){ 
        location.reload();
      });
    }
</script>