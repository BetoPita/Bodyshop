<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Lista de proyectos</h2>
        <!--ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li class="active">
                <strong>Project list</strong>
            </li>
        </ol-->
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>Todos los proyectos asignados a esta cuenta</h5>
                    <div class="ibox-tools">
                        <a href="<?php echo base_url();?>index.php/bodyshop/crear_proyecto" class="btn btn-primary btn-xs">Crear nuevo proyecto</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <button type="button" id="loading-example-btn" class="btn btn-white btn-sm" ><i class="fa fa-refresh"></i> Refrescar</button>
                        </div>
                        <div class="col-md-11">
                            <!--div class="input-group"><input type="text" placeholder="Buscar" class="input-sm form-control"> <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-primary">ir!</button> </span></div-->
                        </div>
                    </div>

                    <div class="project-list">

                        <table id="tbl" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Estatus</th>
                                    <th>Proyecto</th>
                                    <th>Auto</th>
                                    <th>Avance</th>
                                    <th>Integrantes</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($proyectos!=0):?>
                            <?php foreach($proyectos as $res):?>
                            <tr>
                                <td class="project-status">
                                    <span class="label label-primary"><?php echo $res->nombre; ?></span>
                                </td>
                                <td class="project-title">
                                    <a href="project_detail.html"><?php echo $res->proyectoNombre;?></a>
                                    <br/>
                                    <small>Fecha de creación: <?php echo $res->proyectoFechaCreacion;?></small>
                                </td>
                                <td class="project-title">
                                    <a href="#">Placas: <?php echo $res->vehiculo_placas;?></a>
                                    <br/>
                                    <small>Modelo: <?php echo $res->vehiculo_modelo;?></small>
                                </td>
                                <td class="project-completion">
                                        <!--<small>Avance</small>-->
                                        <div class="progress progress-mini">
                                            <div style="width: <?php echo ($res->status * 100)/9; ?>%;" class="progress-bar"></div>
                                        </div>
                                </td>
                                <td class="project-people">
                                  <?php $participantes = $this->principal->get_result('ppIdProyecto', $res->proyectoId,'bodyshop_participantes');?>
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
                                    <!--a href=""><img alt="image" class="img-circle" src="<?php echo base_url();?>statics/css/tema/img/a3.jpg"></a>
                                    <a href=""><img alt="image" class="img-circle" src="<?php echo base_url();?>statics/css/tema/img/a1.jpg"></a>
                                    <a href=""><img alt="image" class="img-circle" src="<?php echo base_url();?>statics/css/tema/img/a2.jpg"></a>
                                    <a href=""><img alt="image" class="img-circle" src="<?php echo base_url();?>statics/css/tema/img/a4.jpg"></a>
                                    <a href=""><img alt="image" class="img-circle" src="<?php echo base_url();?>statics/css/tema/img/a5.jpg"></a-->
                                </td>
                                <td class="project-actions">
                                    <a href="<?php echo base_url()?>index.php/bodyshop/ver_proyecto/<?php echo $res->proyectoId;?>" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> Ver </a>
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
    $(document).on('ready',function(){
        var table = ConstruirTabla('tbl','No se encontraron resultados',0);

    });
</script>
