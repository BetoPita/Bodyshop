<style>
.popover.clockpicker-popover{
    z-index: 3000000;
}
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Lista de proyectos</h2>
    </div>
    <div class="col-sm-2 pull-right">
        <a style="font-size: 18px;" href="{{site_url('bodyshop/tablero/cerrar_sesion_backup')}}">Cerrar sesión</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">

            <div class="ibox">
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Proyectos Finalizados</h5>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="project-list">

                        <table id="tbl" class="table table-hover">
                            <thead>
                                <tr>
                                    <th id="fecha">Fecha de creación</th>
                                    <th>Estatus</th>
                                    <th>Proyecto</th>
                                    <th>Auto</th>
                                    <th>Cliente</th>
                                    <th>Teléfono</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($proyectos!=0):?>
                            <?php foreach($proyectos as $res):?>
                            <tr>
                                <td><?php echo $res->proyectoFechaCreacion ?></td>
                                <td class="project-status">
                                    <span class="label label-primary"><?php echo $res->nombre; ?></span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html"><?php echo $res->proyectoNombre;?></a>
                                    <br/>
                                    <small>Fecha de entrega: <?php echo $res->fecha_fin;?></small>
                                </td>
                                <td class="project-title">
                                    <a href="#">Placas: <?php echo $res->vehiculo_placas;?></a>
                                    <br/>
                                    <small>Modelo: <?php echo $res->vehiculo_modelo;?></small>
                                </td>
                                <td><?php echo $res->proyectoCliente ?></td>
                                <td><?php echo $res->datos_telefono ?></td>
                                <td class="project-actions">
                                   
                                    <button title="Comentar" type="button" class="btn btn-white btn-sm js_comentar" data-id="<?php echo $res->proyectoId;?>">
                                        <i class="fa fa-comment" aria-hidden="true"> Comentar</i>
                                    </button>
                                    <button title="Lista de comentarios" type="button" class="btn btn-white btn-sm js_historial" data-id="<?php echo $res->proyectoId;?>">
                                        <i class="fa fa-info" aria-hidden="true"> Historial</i>
                                    </button>
                                    <!--a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a-->
                                </td>
                            </tr>
                            <?php endforeach;?>
                            <?php endif;?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var site_url = "<?php echo site_url();?>";
        var comentar_backup =site_url+"/bodyshop/comentar_backup";
        var historial_comentarios =site_url+"/bodyshop/historial_comentariosbk";

        
        var id_proyecto = '';
        var accion = '';
    $(document).on('ready',function(){
        var table = ConstruirTabla('tbl','No se encontraron resultados',0);
        $("#fecha").trigger('click');
        $('body').on('click','.js_comentar',function(){
            customModal(
                comentar_backup+'/'+$(this).data('id'),
                {  } ,
                "GET",
                'md',
                callbackComentar,
                "",
                "Guardar",
                "Cerrar",
                "Asignar Comentario",
                "modalComentario"
            );
        }); 
        $('body').on('click','.js_historial',function(){
            customModal(
                historial_comentarios+'/'+$(this).data('id'),
                {  } ,
                "GET",
                'md',
                "",
                "",
                "",
                "Cerrar",
                "Lista de comentarios",
                "historialComentario"
            );
        }); 

        
    });
    function callbackComentar(){
            var url =site_url+"/bodyshop/comentar_backup";
            ajaxJson(url,$("#frm-comentario-backup").serialize(),"POST","",function(result){
                if(isNaN(result)){
                    data = JSON.parse( result );
                    //Se recorre el json y se coloca el error en la div correspondiente
                    $.each(data, function(i, item) {
                         $.each(data, function(i, item) {
                            $(".error_"+i).empty();
                            $(".error_"+i).append(item);
                            $(".error_"+i).css("color","red");
                        });
                    });
                }else{
                    if(result ==0){
                        ErrorCustom('No se pudo guardar el comentario, por favor intenta de nuevo');
                    }else{
                        ExitoCustom('Comentario asignado correctamente',function(){
                            $(".modalComentario").modal('hide');
                        });
                    }
                }
            });
        }
</script>
