<script src="<?php echo base_url();?>statics/js/custom/jquery.numeric.js"></script>

<script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>

<script src="<?php echo base_url();?>statics/js/custom/general.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/jquery.numeric.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<style>
    .eliminar_tr{
        font-size: 20px;
        margin-right: 10px;
        cursor: pointer;
    }
</style>
<script>

function status_acti(id){
  $("#id_actividad").val(id);
}
</script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Detalles del proyecto</h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="animated fadeInUp">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-b-md">
                                <a href="#modal-status" class="btn btn-white btn-xs pull-right" data-toggle="modal">
                                    Ver estatus
                                </a>
                            </div>
                        </div>
                        <h2><?php echo $proyecto->proyectoNombre;?></h2>
                    </div>
                    <dl class="dl-horizontal">
                        <dt>Status: &nbsp;</dt>
                        <label><?php echo isset($estatus->nombre) ? $estatus->nombre :''; ?></label>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>Asesor: &nbsp;</dt>
                        <dd ><?php echo isset($asesor->nombre) ? $asesor->nombre :'' ; ?></dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Creado por:</dt> <dd><?php echo nombre_usuario($proyecto->proyectoIdAdmin);?></dd>
                        <dt>Cliente:</dt> <dd><a href="#" class="text-navy"> <?php echo $proyecto->proyectoCliente;?></a> </dd>
                    </dl>
                </div>
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Número de siniestro:</dt> 
                        <dd><?php echo $proyecto->numero_siniestro;?></dd>
                        <dt>Número de póliza</dt> 
                        <dd><?php echo $proyecto->numero_poliza;?></dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Modelo:</dt> 
                        <dd><?php echo isset($proyecto->vehiculo_modelo) ? $proyecto->vehiculo_modelo :''; ?></dd>
                        <dt>Placas:</dt> <dd><?php echo isset($proyecto->vehiculo_placas) ? $proyecto->vehiculo_placas :''; ?></dd>
                    </dl>
                </div>
                <div class="col-lg-6">
                    <dl class="dl-horizontal">
                        <dt>Año del vehículo:</dt>
                        <dd><?php echo $proyecto->vehiculo_anio;?></dd>
                        <dt>Número de serie:</dt> 
                        <dd><?php echo $proyecto->vehiculo_numero_serie;?></dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7" id="cluster_info">
                    <dl class="dl-horizontal" >
                        <dt>Fecha de creación:</dt> 
                        <dd><?php echo $proyecto->proyectoFechaCreacion;?></dd>
                        <dt>Participantes:</dt>
                        <dd class="project-people">
                            <?php if($participantes!=0):?>
                                <?php foreach($participantes as $par):?>
                                    <?php $imagen_url = imagen_usuario($par->ppIdAdmin);?>
                                    <?php if($imagen_url==""){?>
                                        <img alt="image" class="img-circle" src="<?php echo base_url();?>statics/img/avatar.png" title="<?php echo nombre_usuario($par->ppIdAdmin);?>">
                                    <?php }else{?>
                                        <img alt="image" class="img-circle" src="<?php echo base_url().$imagen_url;?>" title="<?php echo nombre_usuario($par->ppIdAdmin);?>">
                                    <?php }?>
                                <?php endforeach;?>
                           <?php endif;?>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>Completado:</dt>
                        <dd>
                            <div class="progress progress-striped active m-b-sm">
                                <div style="width: <?php echo $progress;?>%;" class="progress-bar"></div>
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>Estatus</dt>
                        <dd>
                            <?php echo isset($data['estatus']->nombre) ? $data['estatus']->nombre : ''; ?>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <div class="wrapper wrapper-content project-manager">
        <h4><?php echo $proyecto->proyectoDescripcion;?></h4>
        <p class="small">
            <?php echo $proyecto->comentarios_servicio;?>
        </p>
    </div>
</div>
<div class="row m-t-sm">
    <div class="col-lg-12">
        <div class="panel blank-panel">
            <div class="panel-heading">
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-1" data-toggle="tab">Mensajes de usuarios</a></li>
                        <li class=""><a href="#tab-2" data-toggle="tab">Cargar archivos</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-1">
                        <div class="feed-activity-list">
                            <div class="feed-element">
                                <div class="media-body ">
                                    <form role="form" action="<?php echo base_url();?>index.php/bodyshop/proyectos/save_comentario_detalle_proyecto" method="post">
                                            <input type="text" placeholder="Titulo" class="form-control" name="commen[comentarioMensaje]">
                                            <input type="hidden" placeholder="Titulo" class="form-control" name="commen[comentarioIdProyecto]" value="<?php echo $id_proyecto;?>">
                                            <br/>
                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Guardar</strong></button>
                                    </form>
                                </div>
                            </div>
                            <?php if(count($comentarios) > 0):?>
                                <?php foreach($comentarios as $coment):?>
                                    <div class="feed-element">
                                        <div class="media-body ">
                                            <?php if ($coment->comentarioIdAdmin != 0): ?>
                                                <strong><?php echo nombre_usuario($coment->comentarioIdAdmin);?></strong>  <br>
                                            <?php else: ?>
                                                <strong>cliente</strong>  <br>
                                            <?php endif ?>
                                            <br>
                                            <small class="text-muted"><?php echo $coment->hora;?> - <?php echo $coment->fecha;?></small>
                                            <div class="well">
                                                <?php echo $coment->comentarioMensaje;?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-2">
                       <div class="feed-element">
                            <div class="media-body ">
                                <button id="btnDownloadZip" class="btn btn-sm btn-primary m-t-n-xs" type="button"><strong>Descargar seleccionados</strong></button>
                            </div>
                       </div>
                       <?php if($descargables!=0):?>
                            <?php foreach($descargables as $desca):?>
                                <div class="feed-element">
                                    <a href="#" class="pull-left">
                                        <?php $imagen_url = imagen_usuario($desca->descargableIdAdmin);?>
                                        <?php if($imagen_url==""){?>
                                            <img alt="image" class="img-circle" src="<?php echo base_url();?>statics/img/avatar.png" title="<?php echo nombre_usuario($desca->descargableIdAdmin);?>">
                                        <?php }else{?>
                                            <img alt="image" class="img-circle" src="<?php echo base_url().$imagen_url;?>" title="<?php echo nombre_usuario($desca->descargableIdAdmin);?>">
                                        <?php }?>
                                    </a>
                                    <div class="media-body ">
                                    <strong><?php echo $desca->descargableNombre;?></strong>  <br>
                                    <small class="text-muted"><?php echo $desca->descargableFechaCreacion;?></small>
                                    <input type="checkbox" class="jsDowload" data-id="<?php echo $desca->descargableId;?>" />
                                    <a href="<?php echo base_url().$desca->descargableUrl;?>">Descargar</a>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        <?php else: ?>
                            <div class="media-body ">
                                <strong>Sin descargables</strong>
                            </div>
                        <?php endif;?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
