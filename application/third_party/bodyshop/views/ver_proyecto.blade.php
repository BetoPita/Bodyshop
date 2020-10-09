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


<div class="row">
    <div class="col-lg-9">
        <div class="animated fadeInUp">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-b-md">
                              <a href="#modal-status" class="btn btn-white btn-xs pull-right" data-toggle="modal">
                              Cambiar estatus
                              </a>
                               <a href="#modal-parcicipante" class="btn btn-white btn-xs pull-right" data-toggle="modal">
                                 Agregar Participantes
                               </a>





                    <!--a  class="btn btn-primary" href="#modal-form">Form in simple modal box</a-->
                    <a href="#modal-form" class="btn btn-white btn-xs pull-right" data-toggle="modal">Agregar actividades</a>



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
                                                <!--div class="form-group"><label>Fecha inicio</label> <input type="text" placeholder="Fecha inicio" class="form-control" name="act[actividadFechaInicio]"></div>
                                                <div class="form-group"><label>Fecha Final</label> <input type="text" placeholder="Fecha final" class="form-control" name="act[actividadFechaFin]"></div-->

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
                            <dl class="dl-horizontal">
                                <dt>Status: &nbsp;</dt>
                                <label ><?php echo $estatus->nombre; ?></label>

                            </dl>
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
                                <!--dt>Version:</dt> <dd> 	v1.4.2 </dd-->
                            </dl>
                        </div>
                         <div class="col-lg-6">
                            <dl class="dl-horizontal">

                                <dt>Número de siniestro:</dt> <dd><?php echo $proyecto->numero_siniestro;?></dd>
                                <!--dt>Messages:</dt> <dd>  162</dd-->
                                <dt>Número de póliza</dt> <dd><?php echo $proyecto->numero_poliza;?></dd>
                                <!--dt>Version:</dt> <dd> 	v1.4.2 </dd-->
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="dl-horizontal">

                                <dt>Modelo:</dt> <dd><?php echo $proyecto->vehiculo_modelo;?></dd>
                                <!--dt>Messages:</dt> <dd>  162</dd-->
                                <dt>Placas:</dt> <dd><?php echo $proyecto->vehiculo_placas;?></dd>
                                <!--dt>Version:</dt> <dd> 	v1.4.2 </dd-->
                            </dl>
                        </div>
                        <div class="col-lg-6">
                            <dl class="dl-horizontal">

                                <dt>Año del vehículo:</dt> <dd><?php echo $proyecto->vehiculo_anio;?></dd>
                                <!--dt>Messages:</dt> <dd>  162</dd-->
                                <dt>Número de serie:</dt> <dd><?php echo $proyecto->vehiculo_numero_serie;?></dd>
                                <!--dt>Version:</dt> <dd> 	v1.4.2 </dd-->
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7" id="cluster_info">
                            <dl class="dl-horizontal" >

                                <!--dt>Last Updated:</dt> <dd>16.08.2014 12:15:57</dd-->
                                <dt>Fecha de creación:</dt> <dd> 	<?php echo $proyecto->proyectoFechaCreacion;?></dd>
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
                                    <!--small>Project completed in <strong>60%</strong>. Remaining close the project, sign a contract and invoice.</small-->
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
                                    <li class=""><a href="#tab-7" data-toggle="tab">Calidad</a></li>
                                    <li class=""><a href="#tab-8" data-toggle="tab">Presupuesto</a></li>
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
                                              </span><input type="text" class="form-control" value="03/04/2014" name="crono[cronoFecha]">
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
                                          <input type="text" class="form-control" value="09:30" name="crono[cronoHora]">
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
                                         <input type="file" name="image" required/>
                                         <input type="hidden" placeholder="Titulo" class="form-control" name="desca[descargableIdProyecto]" value="<?php echo $id_proyecto;?>">
                                         <br/>
                                             <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Guardar descargable</strong></button>



                                     </form>
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
                            <form role="form" action="<?php echo base_url();?>index.php/bodyshop/save_calidad" method="post" enctype="multipart/form-data">
                                <input type="hidden" placeholder="Titulo" class="form-control" name="pregunta[idProyecto]" value="<?php echo $id_proyecto;?>">
                                <div class="feed-element">
                                    <a href="<?php echo base_url();?>index.php/bodyshop/pdf_calidad/<?php echo $id_proyecto;?>" class="btn btn-sm btn-primary pull-right m-t-n-xs" target="_blank">Exportar PDF</a>
                                    
                                </div>
                                <div class="feed-element">
                                    <?php foreach($preguntas as $item):?>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-6"><?php echo $item['seccion']->idbodyshop_calidad_preguntas_seccion.' '.$item['seccion']->nombre; ?></th>
                                                    <th class="col-sm-1">SI</th>
                                                    <th class="col-sm-1">NO</th>
                                                    <th class="col-sm-2">AUTORIZO</th>
                                                    <th class="col-sm-2">OBSERVACIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($item['preguntas'] as $pregunta):?>
                                                    <tr>
                                                        <td><?php echo  $item['seccion']->idbodyshop_calidad_preguntas_seccion.'.'.$pregunta->numero.' '.$pregunta->pregunta; ?></td>
                                                        <td>
                                                            <?php if($pregunta->respuesta == 1) {?>
                                                                <input checked="checked" type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="1">
                                                            <?php } else  {?>
                                                                <input type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="1">
                                                            <?php }; ?>
                                                        </td>
                                                        <td>
                                                            <?php if($pregunta->respuesta == 1) {?>
                                                                <input type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="0">
                                                            <?php } else  {?>
                                                                <input checked="checked" type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="0">
                                                            <?php }; ?>
                                                            
                                                        </td>
                                                        <td>
                                                            <?php echo form_input('pregunta[item]['.$pregunta->idbodyshop_calidad_preguntas.'][autorizo]',set_value('autorizo',exist_obj($pregunta,'autorizo')),'class="form-control" '); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo form_input('pregunta[item]['.$pregunta->idbodyshop_calidad_preguntas.'][observaciones]',set_value('observaciones',exist_obj($pregunta,'observaciones')),'class="form-control" '); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    <?php endforeach;?>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-6">REGISTRO DE NO CONFORMIDADES</th>
                                                    <th class="col-sm-2">NOMBRE /PROCESO</th>
                                                    <th class="col-sm-1"></th>
                                                    <th class="col-sm-1"></th>
                                                    <th class="col-sm-2"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($conformidadesText as $item):?>
                                                    <tr>
                                                        <td>
                                                            <?php echo form_input('conformidad[item]['.$item->idbodyshop_conformidades.'][conformidad]',set_value('conformidad',exist_obj($item,'conformidad')),'class="form-control" '); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo form_input('conformidad[item]['.$item->idbodyshop_conformidades.'][proceso]',set_value('proceso',exist_obj($item,'proceso')),'class="form-control" '); ?>
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    <?php foreach($conformidades as $item):?>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-6"><?php echo $item['seccion']->nombre; ?></th>
                                                    <th class="col-sm-1">SI</th>
                                                    <th class="col-sm-1">NO</th>
                                                    <th class="col-sm-2"></th>
                                                    <th class="col-sm-2"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($item['preguntas'] as $pregunta):?>
                                                    <tr>
                                                        <td><?php echo  $pregunta->pregunta; ?></td>
                                                        <td>
                                                            <?php if($pregunta->respuesta == 1) {?>
                                                                <input checked="checked" type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="1">
                                                            <?php } else  {?>
                                                                <input type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="1">
                                                            <?php }; ?>
                                                        </td>
                                                        <td>
                                                            <?php if($pregunta->respuesta == 1) {?>
                                                                <input type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="0">
                                                            <?php } else  {?>
                                                                <input checked="checked" type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="0">
                                                            <?php }; ?>
                                                            
                                                        </td>
                                                        <td>
                                                           
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    <?php endforeach;?>
                                </div>
                                <div class="feed-element">
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Guardar</strong></button>
                                </div>
                            </form>
                        </div>
                        <!--tab8 -->
                        <div class="tab-pane" id="tab-8">
                            <div class="feed-element">
                                    <a href="<?php echo base_url();?>index.php/bodyshop/pdf_presupuesto/<?php echo $id_proyecto;?>" class="btn btn-sm btn-primary pull-right m-t-n-xs" target="_blank">Exportar PDF</a>
                                </div>
                            <form role="form" id="frm" method="post">
                            <input type="hidden" class="form-control" id="idproyectosave" name="idproyectosave" value="<?php echo $id_proyecto;?>">
                              <div class="row">
                                <div class="col-sm-3">
                                  <label>Fecha:</label>
                                  <?php echo $input_fecha ?>
                                </div>
                                <div class="col-sm-3">
                                  <label>Torre:</label>
                                  <?php echo $input_torre ?>
                                </div>
                                <div class="col-sm-3">
                                  <label>Tipo de vehículo:</label>
                                  <?php echo $input_tipo_vehiculo ?>
                                </div>
                                <div class="col-sm-3">
                                  <label>Placas:</label>
                                  <?php echo $input_placas ?>
                                </div>
                              </div>
                               <div class="row">
                                <div class="col-sm-3">
                                  <label>Serie:</label>
                                  <?php echo $input_serie ?>
                                </div>
                                <div class="col-sm-3">
                                  <label>Orden de reparación:</label>
                                  <?php echo $input_orden_reparacion ?>
                                </div>
                                <div class="col-sm-3">
                                  <label>Color:</label>
                                  <?php echo $drop_color ?>
                                </div>
                                <div class="col-sm-3">
                                  <label>Modelo:</label>
                                  <?php echo $drop_vehiculo_modelo ?>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-3">
                                  <label>Aseguradora:</label>
                                  <?php echo $input_aseguradora ?>
                                </div>
                              </div>
                              <table id="tlb-presupuesto" width="70%" class="table table-striped table-hover table-responsive">
                                <thead>
                                  <tr class="text-center">
                                    <th>Parte</th>
                                    <th>Tipo</th>
                                    <th># Parte</th>
                                    <th>Precio</th>
                                    <th>Existencia</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($datos as $d => $primero)
                                    <tr class="text-right">
                                      <td colspan="5"><strong><h1><?php echo $d ?></h1></strong></td>
                                    </tr>
                                      @foreach($primero as $p => $segundo)
                                      <tr class="text-center">
                                        <td colspan="5"><strong><h2><?php echo $p ?></h2></strong></td>
                                      </tr>
                                          @foreach($segundo as $s => $tercero)
                                           
                                            <?php
                                            $datos_presupuesto = $this->mp->getDatosDetalle($id_proyecto,$tercero->id_subcategoria);
                                            //print_r($datos_presupuesto);die();
                                            if(count($datos_presupuesto)>0){
                                              $tipo_select = $datos_presupuesto[0]->tipo;
                                              $noparte_select = $datos_presupuesto[0]->noparte;
                                              $precio_select = $datos_presupuesto[0]->precio;
                                              $existencia_select = $datos_presupuesto[0]->existencia;
                                            }else{
                                              $tipo_select = '';
                                              $noparte_select = '';
                                              $precio_select = '';
                                              $existencia_select = '';
                                            }

                                          ?>
                                          @if(count($datos_presupuesto)>0)
                                          <tr class="tr-cat-{{$tercero->id}}">
                                            <td width="25%"><?php echo $tercero->subcategoria ?></td>
                                            <td width="15%">
                                              <select name="tipo[<?php echo $tercero->id_subcategoria ?>]"  class="form-control">
                                                <option value="">-- Selecciona --</option>
                                                <option value="C" <?php echo ($tipo_select=='C')?'selected':'' ?>>C</option>
                                                <option value="R" <?php echo ($tipo_select=='R')?'selected':'' ?>>R</option>
                                                <option value="P" <?php echo ($tipo_select=='P')?'selected':'' ?>>P</option>
                                              </select>
                                            </td>
                                            <td  width="20%">
                                              <input type="text" name="noparte[<?php echo $tercero->id_subcategoria ?>]" class="form-control" value="<?php echo $noparte_select ?>" placeholder="#parte">
                                            </td>
                                            <td  width="20%">
                                              <input type="text" name="precio[<?php echo $tercero->id_subcategoria ?>]" class="form-control positive" value="<?php echo $precio_select ?>" placeholder="Precio">
                                            </td>
                                            <td>
                                              <input type="text" name="existencia[<?php echo $tercero->id_subcategoria ?>]" class="form-control positive" value="<?php echo $existencia_select ?>" placeholder="Existencia">
                                              <!--<i class="fa fa-minus"></i>-->
                                            </td>
                                          </tr>
                                        @else
                                        @endif
                                          @endforeach
                                            <tr class="tr-cat-{{$tercero->id}}">
                                                <td colspan="5"></td>
                                            </tr>
                                          <tr class="text-right">
                                              <td colspan="5">
                                                  <button type="button" data-idcategoria="{{$tercero->id}}" data-principal="{{$d}}" class="btn btn-info addFieldByCategory">Agregar</button>
                                              </td>
                                          </tr>
                                      @endforeach
                                  @endforeach
                                </tbody>
                              </table>
                              </form>
                              <div class="row text-right">
                                <div class="col-sm-12">
                                  <button id="addfield" class="btn btn-info">Agregar parte</button>
                                   <button id="guardar" class="btn btn-success">Guardar</button>
                                </div>
                              </div>
                        </div>
                        <!--fin tab8 -->
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
  $(".numeric").numeric();
  $(".positive").numeric({ negative : false });
  $("#guardar").on('click',callback_guardar);
function callback_guardar()
    {
      $("[class*='error_']").empty();
      ajaxJson(site_url+"/bodyshop/savePresupuesto", $('#frm').serialize(), "POST", true, function(result){ 
        console.log(result);
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
              // ExitoCustom("Guardado correctamente",function(){
              //   window.location.href = site_url+'/ventas_facturacion/busquedas';
              // });
               ExitoCustom("Guardado correctamente",function(){
                window.location.reload();
               });
            }else{
                  ErrorCustom('No se pudo guardar, intenta otra vez.');
            }
        }
      });
    }
$("#addfield").on('click',function(){
    var url =site_url+"/bodyshop/agregar_subcategoria/";
    customModal(url,{},"GET","md",UpdateTable,"","Guardar","Cancelar","Agregar Parte","modal1");
    
});
//Agregar parte por categoria
$(".addFieldByCategory").on('click',function(){
    idcategoria = $(this).data('idcategoria');
    var principal = $(this).data('principal');
    $("#idcategoria").val(idcategoria);
    $("#principal").val(principal);
    $("#idbody").val($("#idproyectosave").val());
    var url =site_url+"/bodyshop/agregar_field_to_category/";
    customModal(url,$("#frm-add-part").serialize(),"POST","md",UpdateTableByCategory,"","Guardar","Cancelar","Agregar Parte","modal1");
    $(".busqueda").select2();
    
});
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
    $("#frm-add-part").append('<input class="sub_registradas_'+idsubcategoria+'" type="text" value="'+idsubcategoria+'"  name="sub_registradas[]">');
    addRowCategory(idsubcategoria,subcategoria,idcat);
}
function addRowCategory(idsubcategoria,subcategoria,$idcategoria){
    //console.log(idsubcategoria,subcategoria);
    var html = '<tr class="tr-cat-'+idcategoria+' eliminar-tr-'+idsubcategoria+'"><td width="25%"><i data-idsubcategoria="'+idsubcategoria+'" class="fa fa-minus eliminar_tr"></i>'+subcategoria+'</td><td width="15%"><select name="tipo['+idsubcategoria+']"  class="form-control"><option value="">-- Selecciona --</option><option value="C">C</option><option value="R">R</option><option value="P">P</option></select></td><td  width="20%"><input type="text" name="noparte['+idsubcategoria+']" class="form-control" value="" placeholder="#parte"></td><td  width="20%"><input type="text" name="precio['+idsubcategoria+']" class="form-control positive" value="" placeholder="Precio"></td><td><input type="text" name="existencia['+idsubcategoria+']" class="form-control positive" value="" placeholder="Existencia"></td></tr>';
    //console.log(html);
    $('.tr-cat-'+idcategoria+':last').after(html);
    //$('.tr-cat-'+idcategoria+' tr:last').after(html);
}

function addRow(idsubcategoria,subcategoria){
    var html = '<tr class=""><td width="25%">'+subcategoria+'</td><td width="15%"><select name="tipo['+idsubcategoria+']"  class="form-control"><option value="">-- Selecciona --</option><option value="C">C</option><option value="R">R</option><option value="P">P</option></select></td><td  width="20%"><input type="text" name="noparte['+idsubcategoria+']" class="form-control" value="" placeholder="#parte"></td><td  width="20%"><input type="text" name="precio['+idsubcategoria+']" class="form-control positive" value="" placeholder="Precio"></td><td><input type="text" name="existencia['+idsubcategoria+']" class="form-control positive" value="" placeholder="Existencia"></td></tr>';
    $('#tlb-presupuesto tr:last').after(html);
}
$("body").on('click','.eliminar_tr',function(){
    idsubcategoria_delete = $(this).data('idsubcategoria');
    ConfirmCustom("¿Está seguro de eliminar el registro?", eliminarTr,"", "Confirmar", "Cancelar");

    
    

})
function eliminarTr(){
    $(".eliminar-tr-"+idsubcategoria_delete).remove();
    $(".sub_registradas_"+idsubcategoria_delete).remove();
}
</script>