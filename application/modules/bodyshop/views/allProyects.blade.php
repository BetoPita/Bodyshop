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
                        <a href="<?php echo base_url();?>index.php/bodyshop/dashboard" class="btn btn-primary">Ir a dasboard</a>
                        <a href="<?php echo base_url();?>index.php/bodyshop/crear_proyecto" class="btn btn-primary">Crear nuevo proyecto</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <a href="<?php echo base_url();?>index.php/bodyshop" class="btn btn-white btn-sm" ><i class="fa fa-refresh"></i> Refrescar</a>
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
                                    <th>Proyecto</th>
                                    <th>Auto</th>
                                    <th>Nuevo Modelo</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($proyectos!=0):?>
                            <?php foreach($proyectos as $res):?>
                            <tr>
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
                                <th>
                                    <?php $modelo = $this->principal->getModel($res->proyectoId); ?>
                                    <select data-id="{{$res->proyectoId}}" name="" id="modelo-{{$res->proyectoId}}" class="form-control changemodel">
                                        @foreach($modelos as $m => $value)
                                        <option {{(trim($value->modelo)==trim($modelo))?'selected':''}} value="{{$value->id}}">{{$value->modelo}}</option>
                                        @endforeach
                                    </select>
                                </th>
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
        var site_url = "{{site_url()}}";
        //var table = ConstruirTabla('tbl','No se encontraron resultados',0);
        $(".changemodel").on('change',function(){
            var idproyecto = $(this).data('id');
            var modelo = $("#modelo-"+idproyecto+" option:selected").text();

            ajaxJson(site_url+"/bodyshop/updateModelo", {"idproyecto":idproyecto,"modelo":modelo}, "POST", true, function(result){ 
                if(result==1){
                    ExitoCustom("Guardado correctamente",function(){
                        window.location.reload();
                    })
                }
          });
        })
    });
</script>
