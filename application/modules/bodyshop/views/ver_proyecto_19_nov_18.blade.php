<script src="<?php echo base_url();?>statics/js/custom/jquery.numeric.js"></script>

<script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>

<script src="<?php echo base_url();?>statics/js/custom/general.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/jquery.numeric.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

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
        <!--ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li class="active">
                <strong>Project detail</strong>
            </li>
        </ol-->
    </div>
    
</div>
<input type="hidden" name="idproyectoall" id="idproyectoall" value="{{$idproyectoall}}">
<div class="row">
    <div class="col-lg-9">
        <div class="animated fadeInUp">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-b-md">
                                  <a href="#" id="cambiar_status" class="btn btn-white btn-xs pull-right" data-toggle="modal">
                                  Cambiar estatus
                                  </a>
                                  @if($this->session->userdata('statusPerfil')!=3)
                                   <a href="#modal-parcicipante" class="btn btn-white btn-xs pull-right" data-toggle="modal">
                                     Agregar Participantes
                                   </a>
                                   @endif
                                   @if(!$proyecto->participantes_asignados && $this->session->userdata('statusPerfil')!=3)
                                   <a href="#" class="btn btn-white btn-xs pull-right asignar_participantes">
                                     Participantes del Proceso.
                                   </a>
                                   @endif
                                    <a href="#modal-form" class="btn btn-white btn-xs pull-right" data-toggle="modal">Agregar actividades</a>
                                    <?php if ($estatus->estatusId == 6 || $estatus->estatusId == 7|| $estatus->estatusId == 8|| $estatus->estatusId == 10): ?>

                                        @if(!$tecnicos_asignado && $this->session->userdata('statusPerfil')!=3)
                                        <a data-target="#modal-tecnicos" data-toggle="modal" class="btn btn-white btn-xs pull-right asignar_tecnico">
                                         Asignar un tecnico
                                       </a>
                                       @endif
                                       <div id="modal-tecnicos" class="modal fade">
                                           <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Asignar técnico</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <form action="<?php echo base_url();?>index.php/bodyshop/asignar_tecnico" id="frmTecnico" method="post">
                                                        <div class="form-group">
                                                            <label for="nombretecnico">Tecnico</label>
                                                            <select  name="tecnicos" class="form-control" id="tecnicos">
                                                                <option value="0">Seleccionar tecnico</option>
                                                                <?php foreach ($catalogo_tecnicos as $key => $tecnicos): ?>
                                                                    <option value="<?php echo $tecnicos->id ?>"><?php echo $tecnicos->tecnico ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                            <input type="hidden" value="<?php echo $id_proyecto; ?>" name="idproyecto">
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <button type="button" id="btnasignartecnico"  class="btn btn-primary">Asignar</button>
                                                        <script>
                                                            
                                                            $("#btnasignartecnico").on('click', function() {
                                                                var idtecnico = $("#tecnicos").val();
                                                                if(idtecnico != 0){
                                                                  $("#frmTecnico").submit();  
                                                                }else{
                                                                    alert("Seleccionar tecnico");
                                                                }
                                                            });
                                                            

                                                        </script>
                                                      </div>
                                                    </form>
                                                  </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                       </div>
                                    <?php endif ?>
                                    <div id="modal-form" class="modal fade" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">

                                                            <form role="form" action="<?php echo base_url();?>index.php/bodyshop/save_activi" method="post">
                                                                <div class="form-group"><label>Titulo</label> <input type="text" placeholder="Titulo" class="form-control" name="act[actividadTitulo]"></div>
                                                                <div class="form-group" id="data_1">
                                                                    <label class="font-noraml">Fecha Inicio</label>
                                                                    <div class="input-group date">
                                                                        <span class="input-group-addon">
                                                                          <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control" value="03/04/2016" name="act[actividadFechaInicio]">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group" id="data_1">
                                                                    <label class="font-noraml">Fecha Fin</label>
                                                                    <div class="input-group date">
                                                                        <span class="input-group-addon">
                                                                          <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                        <input type="text" class="form-control" value="03/04/2016" name="act[actividadFechaFin]">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group"><label>Comentarios</label> <input type="text" placeholder="Comentarios" class="form-control" name="act[actividadComentarios]"></div>

                                                                  <input type="hidden" placeholder="Titulo" class="form-control" name="act[actividadIdProyecto]" value="<?php echo $id_proyecto;?>">
                                                                <div>
                                                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Guardar</strong></button>

                                                                </div>
                                                            </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- Anticipo, facturado, pagado, entregad-->
                                <h2><?php echo $proyecto->proyectoNombre;?></h2>
                            </div>
                            
                        </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <dl class="dl-horizontal">
                                        <dt>Status: &nbsp;</dt>
                                        <label ><?php echo $estatus->nombre; ?></label>

                                    </dl>

                                </div>
                                <div class="col-sm-6 text-right">
                                     <?php $dias_entrega = $this->principal->getDiffDate($proyecto->fecha_fin); ?>
                                 @if($dias_entrega!='')
                                    <h2>Días para entrega:</h2>
                                    <h1 style="font-weight: bold !important">{{$dias_entrega}}</h1> 
                                @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <dl class="dl-horizontal">
                                        <dt>{{($proyecto->transito==1)?'EN TRÁNSITO':''}}</dt>
                                    </dl>
                                </div>
                            </div>
                            
                            <dl class="dl-horizontal">
                                <dt>Asesor: &nbsp;</dt>
                                <dd ><?php echo $asesor->nombre; ?></dd>

                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="dl-horizontal">

                                <dt>Creado por:</dt> <dd><?php echo nombre_usuario($proyecto->proyectoIdAdmin);?></dd>
                                <!--dt>Messages:</dt> <dd>  162</dd-->
                                <dt>Cliente:</dt> <dd><a href="#" class="text-navy"> <?php echo $proyecto->proyectoCliente;?></a> </dd>
                                <!--dt>Version:</dt> <dd>   v1.4.2 </dd-->
                            </dl>
                        </div>
                         <div class="col-lg-6">
                            <dl class="dl-horizontal">

                                <dt>Número de siniestro:</dt> <dd><?php echo $proyecto->numero_siniestro;?></dd>
                                <!--dt>Messages:</dt> <dd>  162</dd-->
                                <dt>Número de póliza</dt> <dd><?php echo $proyecto->numero_poliza;?></dd>
                                <!--dt>Version:</dt> <dd>   v1.4.2 </dd-->
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="dl-horizontal">

                                <dt>Modelo:</dt> <dd><?php echo $proyecto->vehiculo_modelo;?></dd>
                                <!--dt>Messages:</dt> <dd>  162</dd-->
                                <dt>Placas:</dt> <dd><?php echo $proyecto->vehiculo_placas;?></dd>
                                

                               
                            </dl>
                        </div>
                        <div class="col-lg-6">
                            <dl class="dl-horizontal">

                                <dt>Año del vehículo:</dt> <dd><?php echo $proyecto->vehiculo_anio;?></dd>
                                <!--dt>Messages:</dt> <dd>  162</dd-->
                                <dt>Número de serie:</dt> <dd><?php echo $proyecto->vehiculo_numero_serie;?></dd>
                                <!--dt>Version:</dt> <dd>   v1.4.2 </dd-->
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7" id="cluster_info">
                            <dl class="dl-horizontal" >

                                <!--dt>Last Updated:</dt> <dd>16.08.2014 12:15:57</dd-->
                                <dt>Fecha de creación:</dt> <dd>    <?php echo $proyecto->proyectoFechaCreacion;?></dd>
                                <dt>Fecha de entrega:</dt> <dd>    <?php echo $proyecto->fecha_fin;?></dd>
                                <dt>Participantes:</dt>
                                <dd class="project-people">
                                <?php if($participantes!=0):?>
                                    <?php foreach($participantes as $par):?>
                                        <?php $imagen_url = imagen_usuario($par->ppIdAdmin); ?>
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
                        <div class="col-sm-5">
                            <h2>Técnicos asignados</h2>
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Técnico</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($tecnicos_asignados)>0)
                                        @foreach($tecnicos_asignados as $t => $vt)
                                            <tr>
                                                <td>{{$vt->tecnico}}</td>
                                                <td>{{$vt->estatus}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">No hay técnicos asignados</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="wrapper wrapper-content project-manager">
            <h4><?php echo $proyecto->proyectoDescripcion;?></h4>
            <!--img src="<?php echo base_url();?>statics/css/tema/img/zender_logo.png" class="img-responsive"-->
            <p class="small">
                <?php echo $proyecto->comentarios_servicio;?>
            </p>
            <!--p class="small font-bold">
                <span><i class="fa fa-circle text-warning"></i> High priority</span>
            </p-->
            <!--h5>Project tag</h5>
            <ul class="tag-list" style="padding: 0">
                <li><a href=""><i class="fa fa-tag"></i> Zender</a></li>
                <li><a href=""><i class="fa fa-tag"></i> Lorem ipsum</a></li>
                <li><a href=""><i class="fa fa-tag"></i> Passages</a></li>
                <li><a href=""><i class="fa fa-tag"></i> Variations</a></li>
            </ul>
            <h5>Project files</h5>
            <ul class="list-unstyled project-files">
                <li><a href=""><i class="fa fa-file"></i> Project_document.docx</a></li>
                <li><a href=""><i class="fa fa-file-picture-o"></i> Logo_zender_company.jpg</a></li>
                <li><a href=""><i class="fa fa-stack-exchange"></i> Email_from_Alex.mln</a></li>
                <li><a href=""><i class="fa fa-file"></i> Contract_20_11_2014.docx</a></li>
            </ul>
            <div class="text-center m-t-md">
                <a href="#" class="btn btn-xs btn-primary">Add files</a>
                <a href="#" class="btn btn-xs btn-primary">Report contact</a>

            </div-->
        </div>
    </div>
</div>
<div class="row m-t-sm">
                        <div class="col-lg-12">
                        <div class="panel blank-panel">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab">Mensajes de usuarios</a></li>
                                    <li class=""><a href="#tab-2" data-toggle="tab">Actividad</a></li>
                                    <li class=""><a href="#tab-3" data-toggle="tab">Cronograma</a></li>
                                    <li class=""><a href="#tab-4" data-toggle="tab">Cargar archivos</a></li>
                                    <li class=""><a href="#tab-5" data-toggle="tab">Gastos</a></li>
                                    <?php if( status_admin($this->session->userdata('id'))!=3){?>
                                    <li class=""><a href="#tab-6" data-toggle="tab">Ventas </a></li>
                                  <?php }?>
                                    <li id="calidad" class=""><a href="#tab-7" data-toggle="tab">Calidad</a></li>
                                    <li class="" id="tab-presupuesto"><a href="#tab-8" data-toggle="tab">Presupuesto</a></li>
                                    @if ($estatus->estatusId == 6 || $estatus->estatusId == 7|| $estatus->estatusId == 8|| $estatus->estatusId == 10)
                                        @if($this->session->userdata('id')==53 || $this->session->userdata('id')==88 || $this->session->userdata('id')==1 || $this->session->userdata('id')==12 )
                                            <li class=""><a href="#tab-9" data-toggle="tab">Indicadores de calidad</a></li>
                                        @endif
                                    @endif
                                    <li class=""><a href="#tab-10" data-toggle="tab">Historial comentarios </a></li>
                                    @if($this->session->userdata('id')==12 || $this->session->userdata('id')==1 || $this->session->userdata('id')==53 || $this->session->userdata('id')==88 || $this->session->userdata('id')==45)
                                     <li class="" id="tab-tiempos"><a href="#tab-11" data-toggle="tab">Tiempos</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                        <div class="tab-content">
                        <div class="tab-pane active" id="tab-1">
                            <div class="feed-activity-list">

                                 <div class="feed-element">
                                    <div class="media-body ">
                                        <form role="form" action="<?php echo base_url();?>index.php/bodyshop/save_comentario" method="post">
                                                <input type="text" placeholder="Titulo" class="form-control" name="commen[comentarioMensaje]">
                                                <input type="hidden" placeholder="Titulo" class="form-control" name="commen[comentarioIdProyecto]" value="<?php echo $id_proyecto;?>">
                                                <br/>
                                                <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Guardar</strong></button>
                                        </form>
                                    </div>
                                </div>
                                <?php //print_r($comentarios);?>
                                <?php if($comentarios!=0):?>
                                <?php foreach($comentarios as $coment):?>
                                <div class="feed-element">
                                    <a href="#" class="pull-left">
                                      <?php $imagen_url = imagen_usuario($coment->comentarioIdAdmin);?>
                                      <?php if($imagen_url==""){?>
                                          <img alt="image" class="img-circle" src="<?php echo base_url();?>statics/img/avatar.png" title="<?php echo nombre_usuario($coment->comentarioIdAdmin);?>">
                                      <?php }else{?>
                                          <img alt="image" class="img-circle" src="<?php echo base_url().$imagen_url;?>" title="<?php echo nombre_usuario($coment->comentarioIdAdmin);?>">
                                      <?php }?>
                                    </a>
                                    <div class="media-body ">
                                        <!--small class="pull-right">2h ago</small-->
                                        <strong><?php echo nombre_usuario($coment->comentarioIdAdmin);?></strong>  <br>
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

                            <table class="table table-striped">
                                <thead>

                                <tr>
                                    <!--th>Status</th-->
                                    <th>Estatus</th>
                                    <th>Título</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Comentarios</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if($actividades!=0):?>
                                <?php foreach($actividades as $activi):?>
                                <tr>
                                    <td>
                                      <?php if($activi->actividadStatus==1){?>
                                        <span class="label label-primary" style="cursur:pointer;"  href="#modal-status_activi" onclick="status_acti(<?php echo $activi->actividadId?>)"  data-toggle="modal" id="<?php echo $activi->actividadId?>"><i class="fa fa-check"></i> en proceso</span>
                                        <?php }else{?>
                                        <span ><i class="fa fa-check"></i> terminada</span>
                                        <?php }?>
                                    </td>
                                    <td>
                                      <?php echo $activi->actividadTitulo;?>
                                    </td>
                                    <td>
                                       <?php echo $activi->actividadFechaInicio;?>
                                    </td>
                                    <td>
                                        <?php echo $activi->actividadFechaFin;?>
                                    </td>
                                    <td>
                                    <p class="small">
                                        <?php echo $activi->actividadComentarios;?>
                                    </p>
                                    </td>

                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>

                                </tbody>
                            </table>

                        </div>

                        <div class="tab-pane" id="tab-3">

                          <form role="form" action="<?php echo base_url();?>index.php/bodyshop/save_cronograma" method="post">
                            <div class="form-group">
                              <label>Titulo</label>
                              <input class="form-control" name="crono[cronoTitulo]" />
                            </div>
                              <!--div class="form-group">
                                <label>Fecha</label>
                                <input class="form-control" name="crono[cronoFecha]" />
                              </div-->
                              <div class="row">
                                <div class="col-lg-6">


                                  <div class="ibox-content">



                                      <div class="form-group" id="data_1">
                                          <label class="font-noraml">Fecha</label>
                                          <div class="input-group date">
                                              <span class="input-group-addon"><i class="fa fa-calendar"></i>
                                              </span><input type="text" class="form-control" value="{{date('d/m/Y')}}" name="crono[cronoFecha]">
                                          </div>
                                      </div>


                                  </div>
                                </div>
                                <div class="col-lg-6">

                                  <div class="ibox-content">

                                      <p>
                                          Hora
                                      </p>

                                      <div class="input-group clockpicker" data-autoclose="true">
                                          <input type="text" class="form-control" value="" name="crono[cronoHora]">
                                          <span class="input-group-addon">
                                              <span class="fa fa-clock-o"></span>
                                          </span>
                                      </div>
                                  </div>
                                </div>
                              </div>




                                <input type="hidden" placeholder="Titulo" class="form-control" name="crono[cronoIdProyecto]" value="<?php echo $id_proyecto;?>">
                              <div>
                                  <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Agregar</strong></button>

                              </div>
                          </form>

                          <!--a href="#modal-cronograma" class="btn btn-white btn-xs pull-right" data-toggle="modal">Agregar cronograma</a-->

                            <table class="table table-striped">
                                <thead>

                                <tr>

                                    <th>Título</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php if($cronograma!=0):?>
                                <?php foreach($cronograma as $cron):?>
                                <tr>


                                    <td>
                                       <?php echo $cron->cronoTitulo;?>
                                    </td>
                                    <td>
                                        <?php echo $cron->cronoFecha;?>
                                    </td>

                                    <td>
                                        <?php echo $cron->cronoHora;?>
                                    </td>


                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>

                                </tbody>
                            </table>

                        </div>


                        <div class="tab-pane" id="tab-4">

                          <div class="feed-element">

                             <div class="media-body ">
                                  <form role="form" action="<?php echo base_url();?>index.php/bodyshop/save_descargable" method="post" enctype="multipart/form-data">
                                         <input type="text" placeholder="Titulo" class="form-control" name="desca[descargableNombre]" required>
                                         <input type="file" name="image[]" multiple required/>
                                         <input type="hidden" placeholder="Titulo" class="form-control" name="desca[descargableIdProyecto]" value="<?php echo $id_proyecto;?>">
                                         <br/>
                                             <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Guardar descargable</strong></button>



                                     </form>
                             </div>
                         </div>
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
                                 <!--small class="pull-right">2h ago</small-->
                                 <strong><?php echo $desca->descargableNombre;?></strong>  <br>
                                 <small class="text-muted"><?php echo $desca->descargableFechaCreacion;?></small>
                                 <input type="checkbox" class="jsDowload" data-id="<?php echo $desca->descargableId;?>" />
                                 <!--<a href="<?php echo site_url().'/bodyshop/dowloadFile/'.$desca->descargableId;?>">Descargar</a>-->
                                 <a href="<?php echo base_url().$desca->descargableUrl;?>">Descargar</a>
                             </div>
                         </div>

                     <?php endforeach;?>
                     <?php endif;?>

                        </div>

                        <div class="tab-pane" id="tab-5">
                          <div class="feed-element">

                             <div class="media-body ">
                                  <form role="form" action="<?php echo base_url();?>index.php/bodyshop/save_gasto" method="post" enctype="multipart/form-data">
                                         <input type="text" placeholder="Concepto" class="form-control" name="gasto[concepto]" required>
                                         <input type="text" placeholder="Gasto" class="form-control" name="gasto[gasto]" required>

                                         <input type="hidden" placeholder="Titulo" class="form-control" name="gasto[idProyecto]" value="<?php echo $id_proyecto;?>">
                                         <br/>
                                             <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Guardar gasto</strong></button>



                                     </form>
                             </div>
                         </div>

                         <?php if($gastos!=0):?>
                           <?php $total = 0;?>
                         <?php foreach($gastos as $gasto):?>
                         <div class="feed-element">

                             <div class="media-body ">
                                 <small class="pull-right">Fecha: <?php echo $gasto->fechaCreacion;?></small>
                                 <strong>Concepto:<?php echo $gasto->concepto;?></strong>  <br>
                                 <strong class="text-muted">Gasto$<?php echo $gasto->gasto;?></strong>

                             </div>
                         </div>
                         <hr/>
                         <?php $total+=$gasto->gasto;?>
                     <?php endforeach;?>
                     <strong class="text-muted" style="color:green;">Total $<?php echo $total;?></strong>
                     <?php endif;?>


                        </div>
                        <div class="tab-pane" id="tab-6">
                          <div class="feed-element">

                            <label>Total ventas proyecto:</label>
                              <?php $aux1 = $this->principal->get_sucu_id_user($this->session->userdata('id'));?>
                              <a  class="btn btn-sm btn-primary pull-right m-t-n-xs" type="button" href="<?php echo base_url();?>index.php/compras/ventas/<?php echo $aux1;?>">Ventas</a>



                         </div>
                        </div>
                        <div class="tab-pane" id="tab-7">
                            <div id="div7"></div>
                        </div> <!-- fin tab7 -->                       
                        <!--tab8 -->
                        <div class="tab-pane" id="tab-8">
                            <div id="div8"></div>
                        </div>
                        <!--fin tab8 -->
                        <div class="tab-pane" id="tab-9">
                                <!--Mecánica -->
                            <div class="row">
                                <div class="col-sm-6">
                                        <h1>Indicador de calidad Mecánica</h1>
                                        <form action="" method="POST" id="frm-mecanica">
                                        <input type="hidden" class="form-control" id="proyectoId" name="proyectoId" value="<?php echo $id_proyecto;?>">
                                        <input type="hidden" class="form-control" id="status_actual" name="status_actual" value="6">
                                        
                                        <table class="table table-bordere">
                                            <thead>
                                                <tr>
                                                    <td>Tipo de falla</td>
                                                    <?php
                                                    ?>
                                                        @foreach($this->principal->getTecnicosByStatusAndProyect($id_proyecto,6) as $t => $value_tec)
                                                            <td>
                                                                {{$value_tec->tecnico}}
                                                            </td>
                                                        @endforeach
                                                    <td>Frecuencia</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($catalogo_fallas_mecanica as $c => $value)
                                                <tr>
                                                    <td>{{$value->tipo}}</td>
                                                        @foreach($this->principal->getTecnicosByStatusAndProyect($id_proyecto,6) as $t => $value_tec)
                                                            <td>
                                                               <input type="number" class="form-control js_total_mecanica mecanica_{{$value_tec->id_tecnico}} js_frecuencia_mecanica_{{$value->id}}" data-idtecnico="{{$value_tec->id_tecnico}}" data-mecanica="{{$value->id}}" value="{{$this->principal->getValorFalla($value->id,$id_proyecto,$value_tec->id_tecnico)}}" name="falla[{{$value_tec->id_tecnico}}-{{$value->id}}]" id="">
                                                            </td>
                                                        @endforeach
                                                        <td>
                                                            <input disabled="disabled" type="text" class="form-control total_frecuencia_mecanica_{{$value->id}} js_total_frecuencia_mecanica" value="" name="" id="">
                                                        </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-right">Total de fallas por técnico</td>
                                                    @foreach($this->principal->getTecnicosByStatusAndProyect($id_proyecto,6) as $t => $value_tec)
                                                        <td>
                                                            <input disabled="disabled" type="text" class="form-control totales_mecanica_{{$value_tec->id_tecnico}}" value="" name="" id="">
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <input disabled="disabled" type="text" class="form-control js_total_mecanica_frecuencia" value="" name="" id="">
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    
                                    </form>
                                    <div class="row text-right">
                                        <div class="col-sm-12">
                                            <button data-formulario="frm-mecanica" id="guardar_falla" class="btn btn-success guardar_falla">Guardar indicador</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="div_grafica_mecanica">
                                    <div class="col-sm-6">
                                        <h1 class="text-center">Gráfica</h1>
                                        {{$grafica_mecanica}}
                                    </div>
                                </div>
                            </div>                                
                            <br>
                            <!-- FIN MECÁNICA -->
                            <div class="row">
                                <div class="col-sm-6">
                                        <h1>Indicador de calidad Laminado</h1>
                                        <form action="" method="POST" id="frm-laminado">
                                        <input type="hidden" class="form-control" id="proyectoId" name="proyectoId" value="<?php echo $id_proyecto;?>">
                                        <input type="hidden" class="form-control" id="status_actual" name="status_actual" value="7">
                                        
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>Tipo de falla</td>
                                                    <?php
                                                    ?>
                                                        @foreach($this->principal->getTecnicosByStatusAndProyect($id_proyecto,7) as $t => $value_tec)
                                                            <td>
                                                                {{$value_tec->tecnico}}
                                                            </td>
                                                        @endforeach
                                                    <td>Frecuencia</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($catalogo_fallas_laminado as $c => $value)
                                                <tr>
                                                    <td>{{$value->tipo}}</td>
                                                        @foreach($this->principal->getTecnicosByStatusAndProyect($id_proyecto,7) as $t => $value_tec)
                                                            <td>
                                                               <input type="number" class="form-control js_total_laminado laminado_{{$value_tec->id_tecnico}} js_frecuencia_laminado_{{$value->id}}" data-idtecnico="{{$value_tec->id_tecnico}}" data-laminado="{{$value->id}}" value="{{$this->principal->getValorFalla($value->id,$id_proyecto,$value_tec->id_tecnico)}}" name="falla[{{$value_tec->id_tecnico}}-{{$value->id}}]" id="">
                                                            </td>
                                                        @endforeach
                                                        <td>
                                                            <input disabled="disabled" type="text" class="form-control total_frecuencia_laminado_{{$value->id}} js_total_frecuencia_laminado" value="" name="" id="">
                                                        </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-right">Total de fallas por técnico</td>
                                                    @foreach($this->principal->getTecnicosByStatusAndProyect($id_proyecto,7) as $t => $value_tec)
                                                        <td>
                                                            <input disabled="disabled" type="text" class="form-control totales_laminado_{{$value_tec->id_tecnico}}" value="" name="" id="">
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <input disabled="disabled" type="text" class="form-control js_total_laminado_frecuencia" value="" name="" id="">
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </form>
                                    <div class="row text-right">
                                        <div class="col-sm-12">
                                            <button data-formulario="frm-laminado" id="guardar_falla" class="btn btn-success guardar_falla">Guardar indicador</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="div_grafica_laminado">
                                    <div class="col-sm-6">
                                        <h1 class="text-center">Gráfica</h1>
                                        {{$grafica_laminado}}
                                    </div>
                                </div>
                            </div>
                        <!--Formulario de pintura-->
                        <div class="row">
                            <div class="col-sm-6">
                                    <h1>Indicador de calidad Pintura</h1>
                                    <form action="" method="POST" id="frm-pintura">
                                    <input type="hidden" class="form-control" id="proyectoId" name="proyectoId" value="<?php echo $id_proyecto;?>">
                                    <input type="hidden" class="form-control" id="status_actual" name="status_actual" value="8">
                                    
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Tipo de falla</td>
                                                <?php
                                                ?>
                                                    @foreach($this->principal->getTecnicosByStatusAndProyect($id_proyecto,8) as $t => $value_tec)
                                                        <td>
                                                            {{$value_tec->tecnico}}
                                                        </td>
                                                    @endforeach
                                                <td>Frecuencia</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($catalogo_fallas_pintura as $c => $value)
                                            <tr>
                                                <td>{{$value->tipo}}</td>
                                                    @foreach($this->principal->getTecnicosByStatusAndProyect($id_proyecto,8) as $t => $value_tec)
                                                        <td>
                                                           <input type="number" class="form-control js_total_pintura pintura_{{$value_tec->id_tecnico}} js_frecuencia_pintura_{{$value->id}}" data-idtecnico="{{$value_tec->id_tecnico}}" data-pintura="{{$value->id}}" value="{{$this->principal->getValorFalla($value->id,$id_proyecto,$value_tec->id_tecnico)}}" name="falla[{{$value_tec->id_tecnico}}-{{$value->id}}]" id="">
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <input disabled="disabled" type="text" class="form-control total_frecuencia_pintura_{{$value->id}} js_total_frecuencia_pintura" value="" name="" id="">
                                                    </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-right">Total de fallas por técnico</td>
                                                @foreach($this->principal->getTecnicosByStatusAndProyect($id_proyecto,8) as $t => $value_tec)
                                                    <td>
                                                        <input disabled="disabled" type="text" class="form-control totales_pintura_{{$value_tec->id_tecnico}}" value="" name="" id="">
                                                    </td>
                                                @endforeach
                                                <td>
                                                    <input disabled="disabled" type="text" class="form-control js_total_pintura_frecuencia" value="" name="" id="">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                                <div class="row text-right">
                                    <div class="col-sm-12">
                                        <button data-formulario="frm-pintura" id="guardar_falla" class="btn btn-success guardar_falla">Guardar indicador</button>
                                    </div>
                                </div>
                            </div>
                            <div id="div_grafica_laminado">
                                    <div class="col-sm-6">
                                        <h1 class="text-center">Gráfica</h1>
                                        {{$grafica_pintura}}
                                    </div>
                                </div>
                        </div>

                        <!--Fin frmulario de pintura -->

                        </div>
                        <!-- FIN TAB 10 -->
                        <div class="tab-pane" id="tab-10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Comentario</th>
                                                <th>Estatus</th>
                                                <th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($historial)>0)
                                                @foreach($historial as $h => $value)
                                                <tr>
                                                    <td>{{$value->fecha}}</td>
                                                    <td>{{$value->comentario}}</td>
                                                    <td>{{$value->status}}</td>
                                                    <td>{{$value->usuario}}</td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">Aún no se han registrado cambios de estatus</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- FIN TAB 11 -->
                        <div class="tab-pane" id="tab-11">
                            <div id="div11"></div>
                        </div>
                        <!-- FIN TAB 11 -->
                        </div>

                        </div>

                        </div>
                        </div>
</div>

<form action="" id="frm-add-part">
    <input type="hidden" id="idcategoria" name="idcategoria">
    <input type="hidden" id="principal" name="principal">
    <input type="hidden" id="idbody" name="idbody">

</form>

<script>

  var site_url = "<?php echo site_url() ?>";
  var idsubcategoria_delete = '';
  var fecha_actual = "<?php echo date('Y-m-d') ?>";
  var formulario_actual = ''; //saber cual es el formulario actual de la gráfica.

  //Variables para ver si ya cargo la tab
  var cargo_calidad = '';
  var cargo_presupuesto = '';
  //Fin variables
    $('.date').datetimepicker({
        minDate: fecha_actual,
        format: 'DD/MM/YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        locale: 'es'
    });
  $(".numeric").numeric();
  $(".positive").numeric({ negative : false });
  $("body").on('click','#guardar',callback_guardar);
  $(".asignar_participantes").on('click',function(e){
    e.preventDefault();
    ConfirmCustom("¿Está seguro de asignar los participantes al proyecto?", asignarTodosParticipantes,"", "Confirmar", "Cancelar");
  });

  $('#btnDownloadZip').on('click',function(){
      if($('.jsDowload:checked').length==0)
      {
          alert('Debe seleccionar los archivos a descargar');
      }
      else{
          var ids =[];
          $.each($('.jsDowload:checked'),function(i,item){
             ids.push($(item).data('id'));
          });
          window.open(site_url+"/bodyshop/downloadFiles/"+ids.join('-'),'_blank');
          //window.location.href=site_url+"/bodyshop/downloadFiles/"+ids.join('-');
      }
  });
    $('.jsLlegaronRefacciones').on('click',function(){
        ajaxJson(site_url+"/bodyshop/llegaronrefacciones", {"idproyecto":$("#idproyectosave").val(),"llegaron":$(this).is(':checked')}, "POST", true, function(result){ 
            
        });
    });
    $("#tab-tiempos").on('click',function(){
        var idproy = $("#idproyectoall").val();
        ajaxLoad(site_url+"/bodyshop/getTimes/"+idproy,{},"div11","GET",function(){

        });
    });
    //CALIDAD
    $("#calidad").on('click',function(){
        var idproy = $("#idproyectosave").val();
        if(cargo_calidad==''){
            ajaxLoad(site_url+"/bodyshop/calidad/"+idproy,{},"div7","GET",function(){
            });
            cargo_calidad = 1;
        }
        
    })
    $("body").on('click','#btn-guardar-calidad',function(){
        ajaxJson(site_url+"/bodyshop/save_calidad",$("#frm-guardar-calidad").serialize(), "POST", true, function(result){ 
                if(result==1){
                    alert('Registro guardado correctamente',function(){
                        ajaxLoad(site_url+"/bodyshop/calidad/"+idproy,{},"div7","GET",function(){
                        });
                    });
                    
                }else{
                    alert('Error al guardar');
                }
        });
    });
    //FIN CALIDAD
    $("#tab-presupuesto").on('click',function(){
        var idproy = $("#proyectoId").val();
        if(cargo_presupuesto==''){
            ajaxLoad(site_url+"/bodyshop/vpresupuesto/"+idproy,{},"div8","GET",function(){
            });
            cargo_presupuesto = 1;
        }
        
    });
    function callback_guardar()
    {
      $("[class*='error_']").empty();
      ajaxJson(site_url+"/bodyshop/savePresupuesto", $('#frm').serialize(), "POST", true, function(result){ 
        
          if(isNaN(result)){
                data = JSON.parse( result );
                //Se recorre el json y se coloca el error en la div correspondiente
                $.each(data, function(i, item) {
                    $(".error_"+i).empty();
                    $(".error_"+i).append(item);
                    $(".error_"+i).css("color","red");
                });
        }else{
            if(result==1){
               ExitoCustom("Guardado correctamente",function(){
                     var idproy = $("#proyectoId").val();
                     ajaxLoad(site_url+"/bodyshop/vpresupuesto/"+idproy,{},"div8","GET",function(){
                    });
               });
            }else{
                  ErrorCustom('No se pudo guardar, intenta otra vez.');
            }
        }
      });
    }
    //TAB PRESUPUESTO

    //FIN PRESUPUESTO

    //CAMBIAR ESTATUS
    $("#cambiar_status").on('click',function(){
        customModal(site_url+"/bodyshop/modal_cambiar_status",{"idproy":$("#proyectoId").val()},"POST","md",cambiarStatus,"","Cambiar","","Cambiar Estatus","modalStatus");
    });
    function cambiarStatus(){
        ajaxJson(site_url+"/bodyshop/cambiar_status", $("#frm-cambiar-status").serialize(), "POST", true, function(result){ 
            if(result==1){
                ExitoCustom("Estatus cambiado correctamente",function(){
                    window.location.reload();
                })
            }
        });
    }
    //FIN CAMBIAR ESTATUS

   

  function asignarTodosParticipantes(){
    ajaxJson(site_url+"/bodyshop/asignarTodosParticipantes", {"idproyecto":$("#idproyectoall").val()}, "POST", true, function(result){ 
        if(result==1){
            ExitoCustom("Participantes asignados correctamente",function(){
                window.location.reload();
            })
        }
    });
  }

$("body").on('click','#addfield',function(){
    var url =site_url+"/bodyshop/agregar_subcategoria/";
    customModal(url,{},"GET","md",UpdateTable,"","Guardar","","Agregar Parte","modal1");
    
});
//Agregar parte por categoria
$("body").on('click','.addFieldByCategory',function(){
    idcategoria = $(this).data('idcategoria');
    var principal = $(this).data('principal');
    $("#idcategoria").val(idcategoria);
    $("#principal").val(principal);
    $("#idbody").val($("#idproyectosave").val());
    var url =site_url+"/bodyshop/agregar_field_to_category/";
    customModal(url,$("#frm-add-part").serialize(),"POST","md",UpdateTableByCategory,"","Guardar","","Agregar Parte","modal1");
    $(".busqueda").select2();
    
});
//Funciones de mecanica
$("body").on('change','.js_total_mecanica',function(){
    var idtecnico = $(this).data('idtecnico');
    var mecanica = $(this).data('mecanica');
    var suma = 0;
   $.each( $(".mecanica_"+idtecnico), function( key, value ) {
      var valor_actual = $(value).val();
      if(valor_actual==''){
        $(value).val(0);
        valor_actual = 0;
      }
      suma =  parseFloat(suma) + parseFloat(valor_actual);
    });
   $(".totales_mecanica_"+idtecnico).val(parseFloat(suma));

   //Sumar tipo de falla
   var suma_frecuencia = 0;
   $.each( $(".js_frecuencia_mecanica_"+mecanica), function( key, value ) {
      var valor_actual_frecuencia = $(value).val();
      if(valor_actual_frecuencia==''){
        $(value).val(0);
        valor_actual_frecuencia = 0;
      }
      
      suma_frecuencia =  parseFloat(suma_frecuencia) + parseFloat(valor_actual_frecuencia);
    });
   $(".total_frecuencia_mecanica_"+mecanica).val(parseFloat(suma_frecuencia));


   //Actualizar el total de frecuencia
   

    var suma_total_frecuencia = 0;
    $.each( $(".js_total_frecuencia_mecanica"), function( key, value ) {
        var valor_total_frecuencia = $(value).val();
        if(valor_total_frecuencia==''){
            $(value).val(0);
            valor_total_frecuencia = 0;
          }
          suma_total_frecuencia =  parseFloat(suma_total_frecuencia) + parseFloat(valor_total_frecuencia);
        });
    $(".js_total_mecanica_frecuencia").val(parseFloat(suma_total_frecuencia));
});
$(".js_total_mecanica").trigger('change');
//Fin funciones mecanica

//Funciones de laminado
$("body").on('change','.js_total_laminado',function(){
    var idtecnico = $(this).data('idtecnico');
    var laminado = $(this).data('laminado');
    var suma = 0;
   $.each( $(".laminado_"+idtecnico), function( key, value ) {
      var valor_actual = $(value).val();
      if(valor_actual==''){
        $(value).val(0);
        valor_actual = 0;
      }
      suma =  parseFloat(suma) + parseFloat(valor_actual);
    });
   $(".totales_laminado_"+idtecnico).val(parseFloat(suma));

   //Sumar tipo de falla
   var suma_frecuencia = 0;
   $.each( $(".js_frecuencia_laminado_"+laminado), function( key, value ) {
      var valor_actual_frecuencia = $(value).val();
      if(valor_actual_frecuencia==''){
        $(value).val(0);
        valor_actual_frecuencia = 0;
      }
      
      suma_frecuencia =  parseFloat(suma_frecuencia) + parseFloat(valor_actual_frecuencia);
    });
   $(".total_frecuencia_laminado_"+laminado).val(parseFloat(suma_frecuencia));


   //Actualizar el total de frecuencia
   

    var suma_total_frecuencia = 0;
    $.each( $(".js_total_frecuencia_laminado"), function( key, value ) {
        var valor_total_frecuencia = $(value).val();
        if(valor_total_frecuencia==''){
            $(value).val(0);
            valor_total_frecuencia = 0;
          }
          suma_total_frecuencia =  parseFloat(suma_total_frecuencia) + parseFloat(valor_total_frecuencia);
        });
    $(".js_total_laminado_frecuencia").val(parseFloat(suma_total_frecuencia));
});
$(".js_total_laminado").trigger('change');
$(".guardar_falla").on('click',function(){
    var formulario = $(this).data('formulario');
    formulario_actual = $(this).data('formulario');
    ajaxJson(site_url+"/bodyshop/saveFalla", $("#"+formulario).serialize(), "POST", true, function(result){ 
            if(result==1){
                ExitoCustom('Indicador de calidad guardado con éxito',function(){
                     window.location.reload();
                });
            }else{
                ErrorCustom('Error al guardar el indicador de calidad');
            }

        });
});
//Fin laminado

//Funciones de pintura
$("body").on('change','.js_total_pintura',function(){
    var idtecnico = $(this).data('idtecnico');
    var pintura = $(this).data('pintura');
    var suma = 0;
   $.each( $(".pintura_"+idtecnico), function( key, value ) {
      var valor_actual = $(value).val();
      if(valor_actual==''){
        $(value).val(0);
        valor_actual = 0;
      }
      suma =  parseFloat(suma) + parseFloat(valor_actual);
    });
   $(".totales_pintura_"+idtecnico).val(parseFloat(suma));

   //Sumar tipo de falla
   var suma_frecuencia = 0;
   $.each( $(".js_frecuencia_pintura_"+pintura), function( key, value ) {
      var valor_actual_frecuencia = $(value).val();
      if(valor_actual_frecuencia==''){
        $(value).val(0);
        valor_actual_frecuencia = 0;
      }
      
      suma_frecuencia =  parseFloat(suma_frecuencia) + parseFloat(valor_actual_frecuencia);
    });
   $(".total_frecuencia_pintura_"+pintura).val(parseFloat(suma_frecuencia));


   //Actualizar el total de frecuencia
   

    var suma_total_frecuencia = 0;
    $.each( $(".js_total_frecuencia_pintura"), function( key, value ) {
        var valor_total_frecuencia = $(value).val();
        if(valor_total_frecuencia==''){
            $(value).val(0);
            valor_total_frecuencia = 0;
          }
          suma_total_frecuencia =  parseFloat(suma_total_frecuencia) + parseFloat(valor_total_frecuencia);
        });
    $(".js_total_pintura_frecuencia").val(parseFloat(suma_total_frecuencia));
});
$(".js_total_pintura").trigger('change');
//Fin laminado
function UpdateTable(){
    ajaxJson(site_url+"/bodyshop/agregar_subcategoria", {"idproyecto":$("#idproyectosave").val(),"subcategoria":$("#subcategoria").val()}, "POST", true, function(result){ 
            result = JSON.parse( result );
            if(result.idsubcategoria>0){

                $(".close").trigger('click');
               addRow(result.idsubcategoria,result.subcategoria);
            }else{
                  ErrorCustom('No se pudo guardar, intenta otra vez.');
            }
        });
    
}
function UpdateTableByCategory(){
    var idsubcategoria=$( "#idsubcat").val();
    var subcategoria=$( "#idsubcat option:selected" ).text();
    var idcat = $("#idcat").val();
    //$(".busqueda").select2();
    $(".close").trigger('click');

    //meto al formulario temporal las subcategorias que ya se dieron de alta
    $("#frm-add-part").append('<input class="sub_registradas_'+idsubcategoria+'" type="hidden" value="'+idsubcategoria+'"  name="sub_registradas[]">');
    addRowCategory(idsubcategoria,subcategoria,idcat);
}
function addRowCategory(idsubcategoria,subcategoria,$idcategoria){
    //
    var html = '<tr class="tr-cat-'+idcategoria+' eliminar-tr-'+idsubcategoria+'"><td width="25%"><i data-idsubcategoria="'+idsubcategoria+'" class="fa fa-minus eliminar_tr"></i>'+subcategoria+'</td><td width="15%"><select name="tipo['+idsubcategoria+']"  class="form-control"><option value="">-- Selecciona --</option><option value="C">C</option><option value="R">R</option><option value="P">P</option></select></td><td  width="20%"><input type="text" name="noparte['+idsubcategoria+']" class="form-control" value="" placeholder="#parte"></td><td  width="20%"><input type="text" name="precio['+idsubcategoria+']" class="form-control positive" value="" placeholder="Precio"></td><td><input type="text" name="existencia['+idsubcategoria+']" class="form-control positive" value="" placeholder="Existencia"></td><td><input value="'+idsubcategoria+'" type="checkbox" name="pintura['+idsubcategoria+']" ></td></tr>';
    //
    $('.tr-cat-'+idcategoria+':last').after(html);
    //$('.tr-cat-'+idcategoria+' tr:last').after(html);
}

function addRow(idsubcategoria,subcategoria){
    var html = '<tr class=""><td width="25%">'+subcategoria+'</td><td width="15%"><select name="tipo['+idsubcategoria+']"  class="form-control"><option value="">-- Selecciona --</option><option value="C">C</option><option value="R">R</option><option value="P">P</option></select></td><td  width="20%"><input type="text" name="noparte['+idsubcategoria+']" class="form-control" value="" placeholder="#parte"></td><td  width="20%"><input type="text" name="precio['+idsubcategoria+']" class="form-control positive" value="" placeholder="Precio"></td><td><input type="text" name="existencia['+idsubcategoria+']" class="form-control positive" value="" placeholder="Existencia"></td><td><input value="'+idsubcategoria+'" type="checkbox" name="pintura['+idsubcategoria+']" ></td></tr>';
    $('#tlb-presupuesto tr:last').after(html);
}
$("body").on('click','.eliminar_tr',function(){
    idsubcategoria_delete = $(this).data('idsubcategoria');
    ConfirmCustom("¿Está seguro de eliminar el registro?", eliminarTr,"", "Confirmar", "Cancelar");
});
function eliminarTr(){
    $(".eliminar-tr-"+idsubcategoria_delete).remove();
    $(".sub_registradas_"+idsubcategoria_delete).remove();
}
//Refrescar las gráficas
function updateGrafica(){
    var div = '';
    if(status==6){
        div = 'div_grafica_mecanica';
    }else if(status==7){
        div = 'div_grafica_laminado';
    }else{
        div = 'div_grafica_mecanica';
    }
    ajaxLoad(site_url+"/bodyshop/updateGrafica",$("#"+formulario_actual).serialize(),div,"POST",function(){

    });
}
function actualizar(datos){
        Highcharts.chart('container', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'Indicadores de calidad mecánica'
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
       //$('#container').highcharts().reflow();
    }
</script>