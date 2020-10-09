<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tablero BodyShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url();?>statics/css/custom/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'statics/js/libraries/confirm.jquery.js'; ?>"></script>
    <script src="<?php echo base_url();?>statics/css/tema/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/general.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    
    <div style='width:3580px' class="container">
        <div style="width: 20%;">
            <h1>Tablero BodyShop</h1>
        </div>
        <div style="width: 20%;">
            <a href="bodyshop/tablero/cerrar_sesion_tablero" class="pull-right cerrar_sesion">Cerrar Sesión</a>
        </div>
        <hr><br>
        <div id="postList">
        <?php foreach ($data as $key => $value) {?>
           <div class="column">
                <div class="column-header" style="background-color:<?php echo $value['estatus']->color ?>">
                    <label><?php echo $value['estatus']->nombre ?></label>
                </div>
                <?php foreach ($value['proyectos'] as $key2 => $value2) {?>
                    <?php if (!is_null($value['estatus']->horas) && !is_null($value2->fecha_estatus)): ?>
                        <?php $tiempo = get_tiempo_laboral($value2->fecha_estatus,$value['estatus']->horas,TRUE); ?>
                    <?php endif ?>
                    <div class="card-{{$value2->proyectoId}} column-item <?php if(!is_null($value['estatus']->horas) && !is_null($value2->fecha_estatus))
                                                    { 
                                                        if(get_tiempo_laboral($value2->fecha_estatus,$value['estatus']->horas)){
                                                            echo 'atrasado';
                                                        }

                                                        if ($value['estatus']->estatusId == 1) {
                                                           echo ($tiempo/30) >= 1 ? " atrasado":"";
                                                        }

                                                        if ($value['estatus']->estatusId == 2) {
                                                           echo ($tiempo/60) >= 2 ? " atrasado":"";
                                                        }

                                                        if ($value['estatus']->estatusId == 3) {
                                                           echo ($tiempo/60) >= 2 ? " atrasado":"";
                                                        }

                                                        if ($value['estatus']->estatusId == 13) {
                                                           echo ($tiempo/240) >= 4 ? " atrasado":"";
                                                        }

                                                        if ($value['estatus']->estatusId == 14) {
                                                           echo ($tiempo/2880) >= 4 ? " atrasado":"";
                                                        }

                                                        if ($value['estatus']->estatusId == 7) {
                                                           echo ($tiempo/480) >= 8 ? " atrasado":"";
                                                        }

                                                    } ?>">
                        <label class="text-center"><?php echo $value2->proyectoNombre ?></label>
                        <br>
                        <hr>
                        @if($value['estatus']->estatusId==12)
                                <input class="finalizar_proyecto" title="Finalizar proyecto" style="float: right;" type="checkbox" name="finalizar" data-id="<?php echo $value2->proyectoId ?>" ><span></span></input>
                            @endif
                        <br>
                        <small>
                            @if($value2->transito==1)
                            <strong>TRÁNSITO</strong>
                            <br>
                            @endif
                        </small>

                        <label>Placas: </label>
                        <small><?php echo $value2->vehiculo_placas ?></small><br><br>
                        <label>Modelo: </label> 
                        <small><?php echo $value2->vehiculo_modelo ?></small><br><br>
                        <label>Fecha de creación:</label><br>
                        <small><?php echo $value2->proyectoFechaCreacion ?></small><br><br>
                        <label>Fecha estatus:</label><br>
                        <small><?php echo $value2->fecha_estatus ?></small>
                        <br>
                        <label>Fecha entrega:</label><br>
                        <small><?php echo $value2->fecha_fin ?></small>
                        <br>

                        <?php $dias_entrega = $this->principal->getDiffDate($value2->fecha_fin); ?>

                        @if($dias_entrega!='')
                            <br>
                            <label>Días para entrega:</label><br>
                            <small>{{$dias_entrega}}</small>
                            <br>
                        @endif

                        @if($value2->tecnico!='')
                        <br>
                        <label>Técnico:</label><br>
                        <small><?php echo $value2->tecnico ?></small>
                        <br>
                        @endif
                        

                        <!--@if($value['estatus']->estatusId==6 || $value['estatus']->estatusId==7 || $value['estatus']->estatusId==8)
                        <br>
                        <label><a href="#" class="ver_tecnicos" data-status="{{$value['estatus']->estatusId}}" data-proyectoId="{{$value2->proyectoId}}" style="text-decoration: none;color: #FFF">Ver Técnico(s)</a> / <a href="#" class="asignar_tecnicos" data-status="{{$value['estatus']->estatusId}}" data-proyectoId="{{$value2->proyectoId}}" style="text-decoration: none;color: #FFF">Asignar Técnico</a></label><br>
                        @endif-->

                        <?php if ($value2->status == 5 && $value2->llegaron_refacciones!=1): ?>
                             <div class="line pendiente-refacciones"></div> 
                        <?php endif ?>
                        <br>
                        <?php $orden = $this->principal->getOrder($value['estatus']->estatusId); ?>
                        <?php if($value['estatus']->estatusId < $total && 
                                ($value2->status != 5 || 
                                ($value2->status == 5 && $value2->llegaron_refacciones == 1))
                                ): ?>
                                
                                <?php if ($value2->status == 4 || 
                                          $value2->status == 13 || 
                                          $value2->status == 14 || 
                                          $value2->status == 15 ||
                                          $value2->status == 16 || 
                                          $value2->status == 5 ): ?>
    
                                          <?php else: ?>
                                    @if($value2->transito==0 || $orden<6)
                                        @if($value2->status != 12)
                                        <button class="btn jsCambiarStatus" 
                                                data-id="<?php echo $value2->proyectoId ?>" 
                                                data-estatusid="<?php echo isset($data[$key+1]['estatus']->estatusId) ? $data[$key+1]['estatus']->estatusId :"" ; ?>" 
                                                data-estatusname="<?php echo isset($data[$key+1]['estatus']->nombre) ? $data[$key+1]['estatus']->nombre : ""; ?>" data-tipologin="1">
                                            Cambiar estatus
                                        </button>
                                        <br>
                                        <br>
                                        @endif
                                        <button class="btn jsCambiarStatus text-center" 
                                                data-id="<?php echo $value2->proyectoId ?>" 
                                                data-estatusid="<?php echo isset($data[$key+1]['estatus']->estatusId) ? $data[$key+1]['estatus']->estatusId :"" ; ?>" 
                                                data-estatusname="<?php echo isset($data[$key+1]['estatus']->nombre) ? $data[$key+1]['estatus']->nombre : ""; ?>" data-tipologin="2">
                                            Asignar Comentario
                                        </button>
                                        
                                    @endif
                              <?php endif ?>
                            
                        <?php endif ?>
                    </div>
                 <?php }?>
           </div>
        <?php }?>
        </div>
    </div>
    <script>
        var site_url = "<?php echo site_url();?>";
        var loginUrl =site_url+"/bodyshop/tablero/login";
        var TecnicosUrl =site_url+"/bodyshop/tablero/tecnicosAsignados";
        var asignarTecnicoUrl =site_url+"/bodyshop/tablero/asignarTecnico";
        var $current = '';
        var aPos = '';
        var id_usuario = '';

        $(document).on('ready',function(){

            $('.jsCambiarStatus').on('click',function(){
                $current=$(this);

                customModal(
                    loginUrl,
                        {},
                    "GET",
                    'md',
                    callbackLogIn,
                    "",
                    "Iniciar",
                    "",
                    "Iniciar sesión",
                    "modalModelo"
                );
            });
            $('.ver_tecnicos').on('click',function(e){
                e.preventDefault();
                var status = $(this).data('status');
                var proyectoId = $(this).data('proyectoid');
                customModal(
                    TecnicosUrl,
                        {"status":status,"proyectoId":proyectoId},
                    "POST",
                    'md',
                    "",
                    "",
                    "",
                    "Salir",
                    "Técnico(s) asignados",
                    "modalTecnicos"
                );
            });
            $('.asignar_tecnicos').on('click',function(e){
                e.preventDefault();
                var status = $(this).data('status');
                var proyectoId = $(this).data('proyectoid');
                customModal(
                    asignarTecnicoUrl,
                        {"status":status,"proyectoId":proyectoId},
                    "POST",
                    'md',
                    callbackAsignarTecnico,
                    "",
                    "Asignar",
                    "Cancelar",
                    "Asignar Técnico",
                    "modalAsignar"
                );
            });
            $(".finalizar_proyecto").on('click',function(){
                aPos = $(this);
                ConfirmCustom("¿Está seguro de finalizar el proyecto?", FinalizarProyecto,CancelarFinalizacion, "Confirmar", "Cancelar");
            })
            $("body").on('click','.js_historial_status',function(e){
                e.preventDefault();
                var idp = $(this).data('idproyecto');
                customModal(
                    site_url+'/bodyshop/tablero/ver_historial_comentarios_estatus',
                        {"proyectoId":idp},
                    "POST",
                    'md',
                    "",
                    "",
                    "",
                    "Cerrar",
                    "Historial de comentarios",
                    "modalStatus"
                );
                
            })
            
            //FUNCIONES CUANDO ES GUARDAR COMENTARIO

        });
        function FinalizarProyecto(){
             var url =site_url+"/bodyshop/tablero/finalizar";
            ajaxJson(url,{"proyectoId":$(aPos).data('id')},"POST","",function(response){
                if(response==1){
                    $(".card-"+$(aPos).data('id')).remove();
                    alert('Proyecto Finalizado correctamente');
                }else{
                    alert('Error al finalizar el proyecto por favor intenta de nuevo.');
                }
            });
        }
        function CancelarFinalizacion(){
            $(aPos).prop('checked',false);
        }
        var callbackLogIn = function (response){
            
			//var url =site_url+"/citas/login_editar_cita";
			ajaxJson(loginUrl,{"usuario":$("#usuario").val(),"password":$("#password").val()},"POST","",function(response){
                console.log(response);
				//var res = confirm('¿Está seguro que quiere cambiar el proyecto a estatus '+$(this).data('estatusname')+'?');
                if(response.success){
                    id_usuario = response.id_usuario;
                    $(".modalModelo").modal('hide');
                    if($($current).data('tipologin')==1){ //Cambiar estatus
                        ConfirmCustom("¿Está seguro de cambiar el estatus", callbackComentario,"", "Confirmar", "Cancelar");
                    }else{ //Comentario
                        customModal(
                            site_url+"/bodyshop/tablero/modalComentario",
                                {id_proyecto:$($current).data('id')},
                            "GET",
                            'md',
                            callbackComentario,
                            "",
                            "Guardar",
                            "",
                            "Guardar comentario",
                            "modalComentario"
                        );
                    }   
                    
                }else{
                    if(response.validation)
                    {
                        $.each(response.errors, function(i, item) {
                            $(".error_"+i).empty();
                            $(".error_"+i).append(item);
                            $(".error_"+i).css("color","red");
                        });
                    }
                    else
                        alert(response.message);
                }
			});
            
        };
        function callbackComentario(){
            if($($current).data('tipologin')==1){
                jQuery.ajax({
                    type: 'POST',
                    url: site_url+'/bodyshop/tablero/cambiar_status',
                    datatype: "JSON",
                    async: true,
                    cache: false,
                    data: {id_proyecto:$($current).data('id'),tablero:true,id_usuario:id_usuario},
                    statusCode: {
                        200: function (result) {
                            location.reload();
                        }
                    }
                });
            }else{
                var comentario = $("#comentario_cambio").val();
                if(comentario==''){
                $(".error_comentario_cambio").empty().append('El campo es requerido');
                }else{
                     jQuery.ajax({
                            type: 'POST',
                            url: site_url+'/bodyshop/tablero/saveOnlyComment',
                            datatype: "JSON",
                            async: true,
                            cache: false,
                            data: {id_proyecto:$($current).data('id'),id_usuario:id_usuario,comentario:comentario},
                            statusCode: {
                                200: function (result) {
                                    if(result==1){
                                        $(".modalComentario").modal('hide');
                                        alert('Comentario guardado con éxito');
                                    }else{
                                        alert('Error al guardar el comentario por favor intenta de nuevo');
                                    }
                                }
                            }
                        });
                }
            }
                
        }
        function callbackComentariobk(){
            var comentario = $("#comentario_cambio").val();
            //if(comentario==''){
                //$(".error_comentario_cambio").empty().append('El campo es requerido');
            //}else{
                 jQuery.ajax({
                        type: 'POST',
                        url: site_url+'/bodyshop/tablero/cambiar_status',
                        datatype: "JSON",
                        async: true,
                        cache: false,
                        data: {id_proyecto:$($current).data('id'),status:$($current).data('estatusid'),tablero:true,id_usuario:id_usuario,comentario:comentario,tipologin:$($current).data('tipologin')},
                        statusCode: {
                            200: function (result) {
                                location.reload();
                            }
                        }
                    });
            //}
        }
        function callbackAsignarTecnico() {
            if($("#nuevotecnico").val()!=0){
                ajaxJson(site_url+"/bodyshop/tablero/cambiarTecnico",$("#frm-asignar-tecnico").serialize(), "POST", true, function(result){ 
                    if(result==1){
                        $(".close").trigger('click');
                        alert('Técnico asignado correctamente');
                    }else{
                        alert('Error al asignar el técnico');
                    }
                    
                });
            }else{
                $(".error_nuevotecnico").empty().append('El técnico es requerido');
            }
        }
    </script>
</body>
</html>