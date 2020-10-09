<style>
     .lin p > a{
    padding: 3px 12px;
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857;
    color: #2E3338;
    text-decoration: none;
    background-color: #FFF;
    border: 1px solid #DDD;
    margin-right: 3px;
}
 .lin p > a:hover{
    color: #2E3338;
    background-color: #EEE;
    border-color: #DDD;
    margin-right: 3px;
}
 .lin p > a.current{
    z-index: 2;
    color: white;
    cursor: default;
    background-color: #2E3338;
    border-color: #2E3338;
    margin-right: 3px;
}
</style>
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
                        <?php if($this->session->userdata('statusPerfil')!=3){ ?>
                            <a href="<?php echo base_url();?>index.php/bodyshop/crear_proyecto" class="btn btn-primary">Crear nuevo proyecto</a>
                        <?php } ?>
                         <a target="_blank" href="<?php echo base_url();?>index.php/bodyshop/tablero_asesores" class="btn btn-primary">Tablero asesores</a>
                         <a target="_blank" href="<?php echo base_url();?>index.php/bodyshop/backup" class="btn btn-primary">Backup</a>
                          <a target="_blank" href="<?php echo base_url();?>index.php/bodyshop/estadisticas_estatus" class="btn btn-primary">Estadísticas</a>
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
                    
                    <form action="" id="frm">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>Estatus</label>
                                <?php echo $drop_status ?>
                            </div>
                            <div class="col-sm-2">
                                <label>Placas</label>
                                <?php echo $input_placas ?>
                            </div>
                            <div class="col-sm-2">
                                <label>Modelo</label>
                                <?php echo $input_modelo ?>
                            </div>
                             <div class="col-sm-2">
                                <label>Asesores</label>
                                <?php echo $drop_asesores ?>
                            </div>
                            <div class='col-sm-2'>
                                <label for="">Fecha inicio</label>
                                <div class='input-group date' id='datetimepicker2'>
                                    <?php echo $input_fecha_inicio; ?>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class='col-sm-2'>
                                <label for="">Fecha Fin</label>
                                <div class='input-group date' id='datetimepicker2'>
                                    <?php echo $input_fecha_fin; ?>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Técnicos</label>
                                <?php echo $drop_tecnicos ?>
                            </div>
                            <div class="col-sm-2">
                                <label>Proyecto</label>
                                <?php echo $drop_proyectoNombre ?>
                            </div>

                            

                            <div class="col-sm-2" style="margin-top: 23px;">
                                <button id="buscar" class="btn btn-info text-right">Buscar</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    

                    <div class="project-list">
                        <div id="tabla">
                            <?php echo $tabla ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>

<script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/general.js"></script>
<script>
    var site_url = "<?php echo site_url();?>";
        var timelieUrl =site_url+"/bodyshop/timeline";
        var id_proyecto = '';
        var accion = '';
    $(document).on('ready',function(){
        $('body').on('click','.busquedalink',function(e){
            e.preventDefault();         
            url=$(this).prop('href');
            ajaxLoad(url,$("#frm").serialize(),"tabla","POST",function(){

            });
        });
        $("#buscar").on("click",function(e){
            e.preventDefault();
            url="<?php echo site_url('bodyshop/buscar_proyectos') ?>";
            ajaxLoad(url,$("#frm").serialize(),"tabla","POST",function(){

            });
        });
        $('.date').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            locale: 'es'
        });
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
        $("body").on("click",'.editar_cita',function(e){
            e.preventDefault();
            id_proyecto = $(this).data('id_proyecto');
            accion = "editar";
               var url =site_url+"/bodyshop/login_editar/0";
               customModal(url,{},"GET","md",ValidarLogin,"","Ingresar","Cancelar","Editar","modal1");
        }); 
    });
    function ValidarLogin(){
            var url =site_url+"/bodyshop/login_editar";
            ajaxJson(url,{"usuario":$("#usuario").val(),"password":$("#password").val()},"POST","",function(result){
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
                    if(result <0){
                        ErrorCustom('Usuario o contraseña inválidos.');
                    }else if(result==0){
                        ErrorCustom('El usuario no es administrador');
                    }else{
                        if(accion=='editar'){
                            window.location.href = site_url+'/bodyshop/editar_proyecto/'+id_proyecto;
                        }else{
                            //var perfil = "{{$this->session->userdata('tipo_perfil')}}";
                            //alert(perfil);
                            callbackEliminarCita();
                        }
                        
                        
                    }
                }
            });
        }
</script>
