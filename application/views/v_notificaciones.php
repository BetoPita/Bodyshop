<style>
    .fa{
        color: black;
        font-size: 15px;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url();?>statics/css/custom/jquery.dataTables.min.css">
<script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/general.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/jquery.dataTables.min.js"></script>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-content">
                    <!---span class="text-muted small pull-right">Last modification: <i class="fa fa-clock-o"></i> 2:10 pm - 12.06.2014</span-->
                    <h2>Notificaciones</h2>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="tbl_notificaciones" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Notificación</th>
                                        <th>Descripción</th>
                                        <th>estatus</th>
                                       <!-- <th>Acciones</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($notificaciones) > 0){ ?>
                                        <?php foreach ($notificaciones as $n) { ?>
                                            <tr>
                                                <td><?php echo $n->titulo ?></td>
                                                <td><?php echo $n->texto; ?></td>
                                                <td><?php echo ($n->estadoWeb)==1 ? 'Activa':'Inactiva' ?></td>
                                                <!--<td>
                                                    <?php if($n->estadoWeb==0){  ?>
                                                    <a href="" name="cambiar" id="cambiar" class="fa fa-bars js_activar" data-id="<?php echo $n->idnoti ?>" title="Activar"/>
                                                    <?php } else{ ?>
                                                         <a href="" name="cambiar" id="cambiar" class="fa fa-bars js_activar" data-id="<?php echo $n->idnoti ?>" title="Desactivar"/>
                                                    <?php } ?>
                                                </td>-->
                                            </tr>
                                    <?php } } ?>

                                    <?php if(count($notificaciones_cronogramas) > 0){ ?>
                                        <?php foreach ($notificaciones_cronogramas as $n) { ?>
                                            <tr>
                                                <td><?php echo $n->cronoTitulo ?></td>
                                                <td><?php echo $n->cronoFecha." ".$n->cronoHora ?></td>
                                                <td><?php echo ($n->estadoWeb)==1 ? 'Activa':'Inactiva' ?></td>
                                            </tr>
                                    <?php } } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
var site_url = "<?php echo site_url() ?>";
  var base_url = "<?php echo base_url() ?>";
$(document).ready(function(){
  ConstruirTabla("tbl_notificaciones","No hay resultados para mostrar.",2,true);

   $("body").on('click','.js_detalles',function(e){
    e.preventDefault();
    var id = $(this).data('id');
    url=site_url+"/bitacora_negocios/detalles_fc";
        customModal(url,{"id":id},"POST","md","","","","Cerrar","Detalles Ford Credit","Modal1","");
  });
});
</script>