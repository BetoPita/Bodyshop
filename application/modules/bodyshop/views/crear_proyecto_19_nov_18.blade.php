<link href="<?php echo base_url();?>statics/css/bootstrap/css/bootstrap-switch.css" rel="stylesheet">
<script src="<?php echo base_url();?>statics/css/bootstrap/js/bootstrap-switch.js"></script>

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
           return true;
       }
  });

});

   function editNews(){
      alert('proyecto creado.');
   }

</script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>Crear proyecto</h2>
    </div>
    <div class="col-sm-4 pull-right form-group">
        @if($transito)
            <?php $checked="checked"; ?>
        @else
            <?php $checked=""; ?>
        @endif
      <label>¿En tránsito?</label>
      <input type="checkbox" name="my-checkbox" class="bootstrap-switch-success" {{$checked}}>
    </div>
</div>


<div class="row">
    <div class="col-sm-12 b-r"><!--h3 class="m-t-none m-b">Sign in</h3-->
        <form id="frmProyecto" role="form" action="<?php echo base_url()?>/index.php/bodyshop/save_proyecto" method="post" id="formulario">
            <input type="hidden" id="transito" name="save[transito]">
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Nombre del proyecto</label>
                    <?php echo $drop_proyectoNombre; ?>
                    <span class="error error_proyectoNombre" data-clase="proyectoNombre"></span>
                    
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Cliente</label>
                    <input type="text" placeholder="Cliente" class="form-control" name="save[proyectoCliente]" id="proyectoCliente">
                    <span class="error error_proyectoCliente" data-clase="proyectoCliente"></span>
                    
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Descripción del proyecto</label>
                     <input type="text" placeholder="Descripción" class="form-control" name="save[proyectoDescripcion]" id="proyectoDescripcion">
                     <span class="error error_proyectoDescripcion" data-clase="proyectoDescripcion"></span>
                   
                </div>
            </div>
             <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Número de siniestro</label>
                    <?php echo $numero_siniestro; ?>
                    <span class="error error_numero_siniestro" data-clase="numero_siniestro"></span>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Número de póliza</label>
                    <?php echo $numero_poliza; ?>
                    <span class="error error_numero_poliza" data-clase="numero_poliza"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Año del vehículo</label>
                    <?php echo $drop_vehiculo_anio; ?>
                    <div class="error error_vehiculo_anio" data-clase="vehiculo_anio"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Placas</label>
                    <?php echo $input_vehiculo_placas; ?>
                    <div class="error error_vehiculo_placas" data-clase="vehiculo_placas"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Color</label>
                     <?php echo $drop_color; ?>
                    <div class="error error_id_color" data-clase="id_color"></div>
                </div>
            </div>
            <div class="row">
                <div id="div_modelo" class="col-sm-3 form-group">
                    <label for="">Modelo</label>
                     <?php echo $drop_vehiculo_modelo; ?>
                    <div class="error error_vehiculo_modelo" data-clase="vehiculo_modelo"></div>
                </div>
                <div class="col-sm-1 form-group">
                    <br>
                    <button id="addModelo" type="button" class="btn btn-primary btn-sm">+</button>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Número de serie</label>
                     <?php echo $input_vehiculo_numero_serie; ?>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">¿CITA?</label><br>
                    Si <?php echo $input_tablero; ?>
                </div>
            </div>
            <div class="row">
                 <div class="col-sm-4 form-group">
                    <label for="">Asesor</label>
                    <?php echo $drop_asesor; ?>
                    <div class="error error_asesor" data-clase="asesor"></div>
                </div>
                 <div class="col-sm-4 form-group div_tablero">
                    <label for="">Fecha</label>
                    <?php echo $drop_fecha ?>
                </div>
                <div class="col-sm-4 form-group div_tablero">
                    <label for="">Horario</label>
                    <?php echo $drop_horario ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 form-group">
                    <label for="">Estatus</label>
                    <?php echo $drop_id_status_color; ?>
                    <div class="error error_id_status_color" data-clase="id_status_color"></div>
                </div>
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
                        <div class="error error_fecha_inicio" data-clase="fecha_inicio"></div>
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
                        <div class="error error_fecha_fin" data-clase="fecha_fin"></div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label for="">Tipo de golpe</label>
                        <?php echo $drop_tipo_golpe ?>
                        <div class="error error_tipo_golpe" data-clase="tipo_golpe"></div>
                    </div>
                <!--<div class="col-sm-4">
                    <br>
                    <label for="">¿Cita por días completos?</label>
                    <?php echo $input_dia_completo; ?>
                </div>
                <div class="col-sm-4">
                    <label>Asignar técnico</label>
                    <?php echo $drop_tecnicos_dias; ?>
                </div>-->
            </div>
            <div id="div_completo">
                <br>
                <div class="row">
                    
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
                    <label for="">Nombre(s)</label>
                    <?php echo $input_datos_nombres; ?>
                    <div class="error error_nombre" data-clase="datos_nombre"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Apellido Paterno</label>
                    <?php echo $input_datos_apellido_paterno; ?>
                    <div class="error error_apellido_paterno" data-clase="datos_apellido_paterno"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Apellido Materno</label>
                    <?php echo $input_datos_apellido_materno; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Teléfono</label>
                    <?php echo $input_datos_telefono; ?>
                    <div class="error error_telefono" data-clase="datos_telefono"></div>
                </div>
                <div class="col-sm-4 form-group">
                    <label for="">Teléfono2</label>
                    <?php echo $input_datos_telefono2; ?>
                </div>
            </div>
            <br>
            <h3>Asignar a usuarios</h3>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <label for="">Correo electrónico</label>
                    <?php echo $input_email; ?>
                    <div class="error error_email" data-clase="datos_email"></div>
                </div>
                <div class="col-sm-4">
                    <label for="">Password</label>
                    <?php echo $input_datos_password; ?>
                    <div class="error input_datos_password" data-clase="datos_password"></div>
                </div>
            </div>

            <div>
                <?php if($modal==false){ ?>
                <button id="btnguardar" class="btn btn-sm btn-primary pull-right m-t-n-xs" type="button"><strong>Guardar</strong></button>
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
   
    $("#btnguardar").on('click', function(event) {
        event.preventDefault();
        //
        var contador = 0;
        $.each($(".error"), function(i, item) {
            var id = $(item).data('clase');
            
            var valor = $("#"+id).val();
            if(valor ==''){
                contador ++;
                $(item).empty();
                $(item).append("El campo es requerido");
                $(item).css("color","red");
            }else{
                $(item).empty();
            }
        });
        console.log(contador);
        if(contador==0){
            $("#frmProyecto").submit();
        }
    });

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
    $("#asesor").on("change",function(){
    var url=site_url+"/bodyshop/getfechas";
        $("#fecha").empty();
        $("#fecha").append("<option value=''>-- Selecciona --</option>");
        $("#fecha").attr("disabled",true);
        $("#horario").empty();
        $("#horario").append("<option value=''>-- Selecciona --</option>");
        $("#horario").attr("disabled",true);
        asesor=$(this).val();
        if(asesor!=''){
            ajaxJson(url,{"asesor":asesor},"POST","",function(result){
                if(result.length!=0){
                    $("#fecha").empty();
                    $("#fecha").removeAttr("disabled");
                    result=JSON.parse(result);
                    $("#fecha").append("<option value=''>-- Selecciona --</option>");
                    $.each(result,function(i,item){
                        var fecha_separada = result[i].fecha.split('-');
                        $("#fecha").append("<option value= '"+result[i].fecha+"'>"+fecha_separada[2]+'/'+fecha_separada[1]+'/'+fecha_separada[0]+"</option>");
                    });
                }else{
                    $("#fecha").empty();
                    $("#fecha").append("<option value='0'>No se encontraron datos</option>");
                }
            });
        }else{
            $("#fecha").empty();
            $("#fecha").append("<option value=''>-- Selecciona --</option>");
            $("#fecha").attr("disabled",true);

      $("#tecnicos").empty();
      $("#tecnicos").append("<option value=''>-- Selecciona --</option>");
      $("#tecnicos").attr("disabled",true);
      $("#hora_inicio").val('');
      $("#hora_fin").val('');
        }
    }); 

    $("#fecha").on("change",function(){
        var url=site_url+"/bodyshop/getHorarios";
        fecha=$(this).val();
        asesor=$("#asesor").val();
    $("#hora_inicio").val('');
      $("#hora_fin").val('');
        if(fecha!='' && asesor!=''){
            ajaxJson(url,{"asesor":asesor,"fecha":fecha,"id_horario":$("#id_horario").val()},"POST","",function(result){
                if(result.length!=0){
                    $("#horario").empty();
                    $("#horario").removeAttr("disabled");
                    result=JSON.parse(result);
                    $("#horario").append("<option value=''>-- Selecciona --</option>");
                    $.each(result,function(i,item){
                        $("#horario").append("<option value= '"+result[i].id+"'>"+result[i].hora.substring(0,5)+"</option>");
                    });
          var id_cita = $("#id").val();
          if(id_cita ==0){
            getTecnicos();
           
          }
                }else{
                    $("#horario").empty();
                    $("#horario").append("<option value='0'>No se encontraron datos</option>");
                }
            });
        }else{

            $("#horario").empty();
            $("#horario").append("<option value=''>-- Selecciona --</option>");
            $("#horario").attr("disabled",true);

      $("#tecnicos").empty();
      $("#tecnicos").append("<option value=''>-- Selecciona --</option>");
      $("#tecnicos").attr("disabled",true);
      $("#hora_inicio").val('');
      $("#hora_fin").val('');

      $("#tecnicos_dias").empty();
      $("#tecnicos_dias").append("<option value=''>-- Selecciona --</option>");
      $("#tecnicos_dias").attr("disabled",true);
        }
    }); 
    $("#tablero").on('change',function(){
        if(!$(this).prop('checked')){
            $(".div_tablero").hide('slow');
        }else{
            $(".div_tablero").show('slow');
        }
    });
$("[name='my-checkbox']").bootstrapSwitch({
    onColor:"success",
    offColor:'danger',
    onText:"Si",
    offText: "No"
});
  $("[name='my-checkbox']").on('switchChange.bootstrapSwitch', function(event, state) {
    var transito = '';
    if(state){
      transito = 1;
    }else{
       transito = 0;
    }
    $("#transito").val(transito);
    
  });
</script>
