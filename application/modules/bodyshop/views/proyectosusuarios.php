<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Lista de proyectos</h2>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>Todos los proyectos asignados a esta cuenta</h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <a href="<?php echo base_url();?>index.php/bodyshop" class="btn btn-white btn-sm" ><i class="fa fa-refresh"></i> Refrescar</a>
                        </div>
                        <div class="col-md-11">
                        </div>
                    </div>

                    <div class="project-list">

                        <table id="tbl" class="table table-hover">
                            <thead>
                                <tr>
                                    <th id="fecha">Fecha de creación</th>
                                    <th>Estatus</th>
                                    <th>Proyecto</th>
                                    <th>Auto</th>
                                    <th>Avance</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(count($proyectos) > 0):?>
                            <?php foreach($proyectos as $res):?>
                            <tr>
                                <td><?php echo $res->proyectoFechaCreacion ?></td>
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
                                        <div class="progress progress-mini">
                                            <div style="width: <?php echo ($res->status * 100)/12; ?>%;" class="progress-bar"></div>
                                        </div>
                                </td>
                                <td class="project-actions">
                                    <a href="<?php echo base_url()?>index.php/bodyshop/proyectos/detalle_proyecto?id=<?php echo base64_encode($res->proyectoId); ?>" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> Ver </a>
                                    <button type="button" class="btn btn-white btn-sm jsTimeline" data-id="<?php echo $res->proyectoId;?>"><i class="fa fa-calendar"></i></button>
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
        var timelieUrl =site_url+"/bodyshop/timeline";
    $(document).on('ready',function(){
        var table = ConstruirTabla('tbl','No se encontraron resultados',0);
        $("#fecha").trigger('click');
        $('body').on('click','.jsTimeline',function(){
            customModal(
                timelieUrl+'/'+$(this).data('id'),
                {  } ,
                "GET",
                'md',
                "",
                "",
                "",
                "Cerrar",
                "Linea de tiempo",
                "modalModelo"
            );
        });
    });
</script>
