<script type="text/javascript">
 $(document).ready(function(){

  $("#formulario").submit(function(){
       var band = 0;

       if($("#proyectoNombre").val() == ''){
           $("#proyectoNombre").css("border", "1px solid #FF0000");
           band++;
       }
       else{
           $("#proyectoNombre").css("border", "1px solid #ADA9A5");
       }

       if($("#proyectoCliente").val() == '' ){
           $("#proyectoCliente").css("border", "1px solid #FF0000");
           band++;
       }
       else{
           $("#proyectoCliente").css("border", "1px solid #ADA9A5");
       }

        if($("#proyectoDescripcion").val() == '' ){
           $("#proyectoDescripcion").css("border", "1px solid #FF0000");
           band++;
       }
       else{
           $("#proyectoDescripcion").css("border", "1px solid #ADA9A5");
       }



       if(band != 0){
           //$("#errorMessage").text("Por favor, verifique los campos marcados.").show();
           return false;
       }
       else{
           //$("#errorMessage").hide();
           /*var opt = {
               success : editNews
           }
           $(this).ajaxSubmit(opt);
           */
           return true;
       }
  });

});

   function editNews(){
      alert('proyecto creado.');
   }

</script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Crear proyecto</h2>

    </div>
</div>


<div class="row">
    <div class="col-sm-12 b-r"><!--h3 class="m-t-none m-b">Sign in</h3-->
        <form id="frmProyecto" role="form" action="<?php echo base_url()?>/index.php/bodyshop/save_proyecto" method="post" id="formulario">
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Nombre del proyecto</label>
                    <?php echo $drop_proyectoNombre; ?>
                    
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Cliente</label>
                    <input type="text" placeholder="Cliente" class="form-control" name="save[proyectoCliente]" id="proyectoCliente">
                    
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Descripción del proyecto</label>
                     <input type="text" placeholder="Descripción" class="form-control" name="save[proyectoDescripcion]" id="proyectoDescripcion">
                   
                </div>
            </div>
             <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Número de siniestro</label>
                    <?php echo $numero_siniestro; ?>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Número de póliza</label>
                    <?php echo $numero_poliza; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Año del vehículo</label>
                    <?php echo $drop_vehiculo_anio; ?>
                    <div class="error error_vehiculo_anio"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Placas</label>
                    <?php echo $input_vehiculo_placas; ?>
                    <div class="error error_vehiculo_placas"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Color</label>
                     <?php echo $drop_color; ?>
                    <div class="error error_id_color"></div>
                </div>
            </div>
            <div class="row">
                <div id="div_modelo" class="col-sm-3 form-group">
                    <label for="">Modelo</label>
                     <?php echo $drop_vehiculo_modelo; ?>
                    <div class="error error_vehiculo_modelo"></div>
                </div>
                <div class="col-sm-1 form-group">
                    <br>
                    <button id="addModelo" type="button" class="btn btn-primary btn-sm">+</button>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Número de serie</label>
                     <?php echo $input_vehiculo_numero_serie; ?>
                    <div class="error error_numero_serie"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Asesor</label>
                    <?php echo $drop_asesor; ?>
                    <div class="error error_asesor"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 form-group">
                    <label for="">Estatus</label>
                    <?php echo $drop_id_status_color; ?>
                </div>
                <!--<div class="col-sm-4">
                    <br>
                    <label for="">¿Cita por días completos?</label>
                    <?php echo $input_dia_completo; ?>
                </div>-->
                <div class="col-sm-4">
                    <label>Asignar técnico</label>
                    <?php echo $drop_tecnicos_dias; ?>
                </div>
            </div>
            <div id="div_completo">
                <br>
                <div class="row">
                    <div class='col-sm-3'>
                    <label for="">Fecha inicio</label>
                        <div class="form-group1">
                            <div class='input-group date' id='datetimepicker2'>
                                <?php echo $input_fecha_inicio; ?>
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-3'>
                    <label for="">Fecha Fin</label>
                        <div class="form-group1">
                            <div class='input-group date' id='datetimepicker2'>
                                <?php echo $input_fecha_fin; ?>
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-sm-3">
                    <label for="">Hora de inicio del día</label>
                        <div class="input-group clockpicker clockpicker_comienzo" data-autoclose="true">
                        <?php echo $input_hora_comienzo; ?>
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>-->
                </div>
                <!--<div class="row">
                    <div class="col-sm-3">
                        <label>Día extra</label>
                        <div class="form-group1">
                            <div class='input-group date' id='datetimepicker3'>
                                 <?php echo $input_fecha_parcial; ?>
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="">Hora inicio trabajo</label>
                         <div class="input-group clockpicker" data-autoclose="true">
                            <?php echo $input_hora_inicio_extra; ?>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                            <br>
                                <span class="error_hora_inicio_extra"></span>
                        </div>
                        <div class="col-sm-3">
                            <label for="">Hora fin trabajo</label>
                            <div class="input-group clockpicker clockpicker_fin" data-autoclose="true">
                            <?php echo $input_hora_fin_extra; ?>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                            <br>
                                
                        </div>
                    </div>
                </div>--> <!-- completos -->
                <!--<div id="div_incompleto" class="row">
                    <div class="col-sm-4">
                        <label>Asignar técnico</label>
                        <?php echo $drop_tecnicos; ?>
                        <span class="error error_tecnico"></span>
                    </div>
                    <div class="col-sm-3">
                        <label for="">Hora inicio trabajo</label>
                        <div class="input-group clockpicker clockpicker_fin" data-autoclose="true">
                        <?php echo $input_hora_inicio; ?>
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="">Hora fin trabajo</label>
                        <div class="input-group clockpicker clockpicker_fin" data-autoclose="true">
                            <?php echo $input_hora_fin; ?>
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                        <br>
                            
                    </div>
                </div>--> <!-- 0 -->
            <div class="row">
                <div class="col-sm-8">
                    <label for="">Comentarios</label>
                    <?php echo $input_comentarios; ?>
                    <div class="error error_comentario"></div>
                </div>
            </div>
            <br>
            <h3>Mis datos</h3>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Correo electrónico</label>
                    <?php echo $input_email; ?>
                    <div class="error error_email"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Nombre(s)</label>
                    <?php echo $input_datos_nombres; ?>
                    <div class="error error_nombre"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Apellido Paterno</label>
                    <?php echo $input_datos_apellido_paterno; ?>
                    <div class="error error_apellido_paterno"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Apellido Materno</label>
                    <?php echo $input_datos_apellido_materno; ?>
                    <div class="error error_apellido_materno"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Teléfono</label>
                    <?php echo $input_datos_telefono; ?>
                    <div class="error error_telefono"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Teléfono</label>
                    <?php echo $input_datos_telefono2; ?>
                    <div class="error error_telefono"></div>
                </div>
            </div>
            <div>
                <?php if($modal==false){ ?>
                <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Guardar</strong></button>
                <?php }; ?>
            </div>
        </form>
    </div>
</div>

<script>
    var site_url = "<?php echo site_url();?>";
    $('.clockpicker').clockpicker();
    //$("#div_completo").hide();
    var fecha_actual = "<?php echo date('Y-m-d') ?>";
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
    /*$("#dia_completo").on('click',function(){
        if($(this).prop('checked')){
            $(this).val(1);
        $("#div_completo").show('slow');
        $("#div_incompleto").hide('slow');
        }else{
            $(this).val(1);
        $("#div_completo").hide('slow');
        $("#div_incompleto").show('slow');
        }
    });*/
    $("#addModelo").on('click',function(){
        customModal(
            site_url+"/bodyshop/saveModelo",
             {},
            "POST",
            'md',
            callback_guardar,
            "",
            "Guardar",
            "",
            "Agregar modelo",
            "modalModelo"
        );
    });
    function callback_guardar()
    {
      $("[class*='error_']").empty();
      ajaxJson(site_url+"/bodyshop/saveModelo", $('#frmModelo').serialize(), "POST", true, function(result){ 
        var response = data = JSON.parse( result );
        if(response.success)
        {
            ajaxLoad(site_url+"/bodyshop/getDropModelo", { id : response.id}, "div_modelo", "POST", function () {
                closeModal({Modal:'modalModelo'});
            });
        }
        else{
            $.each(response.errors, function(i, item) {
                $(".error_"+i).empty();
                $(".error_"+i).append(item);
                $(".error_"+i).css("color","red");
            });
        }
      });
    }
    /*$('.clockpicker_inicio').clockpicker({
        afterDone: function() {
                //validar_fecha_inicio();
        },
    });
    $('.clockpicker_fin').clockpicker({
        afterDone: function() {
            //validar_fin();
        },
    });*/
</script>
