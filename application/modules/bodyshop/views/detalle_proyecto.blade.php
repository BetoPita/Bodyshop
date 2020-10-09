<link href="<?php echo base_url();?>statics/css/bootstrap/css/bootstrap-switch.css" rel="stylesheet">
<script src="<?php echo base_url();?>statics/css/bootstrap/js/bootstrap-switch.js"></script>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>Detalle del proyecto</h2>
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
    <div class="row">
      <div class="col-sm-12 b-r">
          <form id="frmProyecto" role="form" action="<?php echo base_url()?>/index.php/bodyshop/save_proyecto" method="post" id="formulario">
            <input type="hidden" id="transito" name="save[transito]" value="{{$transito}}">
              <div class="row">
                  <div class="col-sm-4 form-group">
                      <label for="">Nombre del proyecto</label>
                      <?php echo $inputs['drop_proyectoNombre']; ?>
                      <input type="hidden" name="save[idproyecto]" value="<?php echo $inputs['id_proyecto']; ?>">
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Cliente</label>
                      <?php echo $inputs['proyectoCliente']; ?>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Descripción del proyecto</label>
                        <?php echo $inputs['proyectoDescripcion']; ?>
                  </div>
              </div>
               <div class="row">
                  <div class="col-sm-4 form-group">
                      <label for="">Número de siniestro</label>
                      <?php echo $inputs['numero_siniestro']; ?>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Número de póliza</label>
                      <?php echo $inputs['numero_poliza']; ?>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-4 form-group">
                      <label for="">Año del vehículo</label>
                      <?php echo $inputs['drop_vehiculo_anio']; ?>
                      <div class="error error_vehiculo_anio"></div>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Placas</label>
                      <?php echo $inputs['input_vehiculo_placas']; ?>
                      <div class="error error_vehiculo_placas"></div>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Color</label>
                       <?php echo $inputs['drop_color']; ?>
                      <div class="error error_id_color"></div>
                  </div>
              </div>
              <div class="row">
                  <div id="div_modelo" class="col-sm-3 form-group">
                      <label for="">Modelo</label>
                       <?php echo $inputs['drop_vehiculo_modelo']; ?>
                      <div class="error error_vehiculo_modelo"></div>
                  </div>
                  <div class="col-sm-1 form-group">
                      <br>
                      <button id="addModelo" type="button" class="btn btn-primary btn-sm">+</button>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Número de serie</label>
                       <?php echo $inputs['input_vehiculo_numero_serie']; ?>
                      <div class="error error_numero_serie"></div>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Asesor</label>
                      <?php echo $inputs['drop_asesor']; ?>
                      <div class="error error_asesor"></div>
                  </div>
              </div>
              <div class="row">
                   <div class="col-sm-4 form-group">
                      <label for="">Fecha</label>
                      <?php echo $inputs['drop_fecha']; ?>
                      <div class="error error_fecha"></div>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Horario</label>
                      <?php echo $inputs['drop_horario']; ?>
                      <div class="error error_horario"></div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-3 form-group">
                      <label for="">Estatus</label>
                      <?php echo $inputs['drop_id_status_color']; ?>
                  </div>
                  <div class='col-sm-3'>
                      <label for="">Fecha inicio</label>
                          <div class="form-group1">
                              <div class='input-group date' id='datetimepicker2'>
                                  <?php echo $inputs['input_fecha_inicio']; ?>
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
                                  <?php echo $inputs['input_fecha_fin']; ?>
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar"></span>
                                  </span>
                              </div>
                          </div>
                      </div>
                      <div class="col-sm-2 form-group">
                        <label for="">Tipo de golpe</label>
                        <?php echo $inputs['drop_tipo_golpe'] ?>
                        <div class="error error_tipo_golpe"></div>
                    </div>
              </div>
              <div id="div_completo">
                  <br>
              <div class="row">
                  <div class="col-sm-8">
                      <label for="">Comentarios</label>
                      <?php echo $inputs['input_comentarios']; ?>
                      <div class="error error_comentario"></div>
                  </div>
              </div>
              <br>
              <h3>Mis datos</h3>
              <div class="row">
                  <div class="col-sm-4 form-group">
                      <label for="">Nombre(s)</label>
                      <?php echo $inputs['input_datos_nombres']; ?>
                      <div class="error error_nombre"></div>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Apellido Paterno</label>
                      <?php echo $inputs['input_datos_apellido_paterno']; ?>
                      <div class="error error_apellido_paterno"></div>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Apellido Materno</label>
                      <?php echo $inputs['input_datos_apellido_materno']; ?>
                      <div class="error error_apellido_materno"></div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-sm-4 form-group">
                      <label for="">Teléfono</label>
                      <?php echo $inputs['input_datos_telefono']; ?>
                      <div class="error error_telefono"></div>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Teléfono</label>
                      <?php echo $inputs['input_datos_telefono2']; ?>
                      <div class="error error_telefono"></div>
                  </div>
              </div>
              <br>
              <h3>Asignar a usuarios</h3>
              <div class="row">
                  <div class="col-sm-4 form-group">
                      <label for="">Correo electrónico</label>
                      <?php echo $inputs['input_email']; ?>
                      <div class="error error_email"></div>
                  </div>
                  <div class="col-sm-4 form-group">
                      <label for="">Password</label>
                      <?php echo $inputs['datos_password']; ?>
                      <div class="error error_email"></div>
                  </div>
              </div>
          <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Actualizar</strong></button>
          </form>
      </div>
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
        var correo =  $("#datos_email").val();
        var pass   =  $("#datos_password").val();
        var nombres = $("#datos_nombres").val();

        if(correo == ''){
            alert("Ingresar un correo electrónico");
            return false;
        }

        if(pass == ''){
            alert("Ingresar una contraseña");
            return false;
        }
        if(nombres == ''){
            alert("Ingresar un nombre");
            return false;
        }

        $("#frmProyecto").submit();
        /* Act on the event */
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
            $("#div_tablero").hide('slow');
        }else{
            $("#div_tablero").show('slow');
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
