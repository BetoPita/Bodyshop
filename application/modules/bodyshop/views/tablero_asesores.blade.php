<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <base href="{{base_url()}}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Tablero asesores</title>
  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url();?>statics/css/tema/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url();?>statics/css/tema/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/timeline.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/clockpicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/c3.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/jquery.dataTables.min.css" rel="stylesheet">
    <?php echo link_tag('statics/css/jquery.confirm.css'); ?>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'statics/js/libraries/confirm.jquery.js'; ?>"></script>
    <script src="<?php echo base_url();?>/statics/css/tema/js/plugins/Dynatable/jquery.dynatable.js "></script>
    <script src="<?php echo base_url();?>/statics/js/modules/jquery.maskMoney.js"></script>

    <script src="<?php echo base_url();?>/statics/js/modules/jquery.mask.min.js"></script>
    <script src="<?php echo base_url();?>/statics/js/modules/jspdf.min.js"></script>
    <script src="<?php echo base_url();?>/statics/js/custom/moment.js"></script>
    <script src="<?php echo base_url();?>/statics/js/custom/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo base_url();?>/statics/js/custom/clockpicker.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/jquery.numeric.js"></script>
    <script src="<?php echo base_url();?>statics/css/tema/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/general.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/jquery.dataTables.min.js"></script>
  <style>
		.gris{
			color: #000;
		}
		.verde{
			color: #1F7D31;
			background-color: transparent
		}
		body{
			background-color: #BDBDBD;
			font-weight: bold;
		}
		.container-fluid{
			color: #000;
		}
		.desactivado{
			background-color: #7576F6;
			color: #FFF;
			font-weight: bold;
		}
		.activo{
			background-color: white;
			color: #000;
			font-weight: bold;
		}
		.fa{
			font-size: 20px;
			margin-right: 10px;
		}
	</style>
</head>

<body class="sticky-footer" id="page-top">
  <div class="content-wrapper" style="background-color:#BDBDBD ">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
		<div class="row">
			<div class="col-sm-12">
				<span style="font-size: 30px;font-weight: bold;text-align: center;">Tablero de asesores</span>
				<a style="color: #000;" href="bodyshop/cerrar_sesion_asesor" class="pull-right cerrar_sesion">Cerrar Sesión</a>
			</div>
		</div>
		<br>
		<div class="row form-group">
		        <div class='col-sm-3'>
		        	<label for="">Selecciona la fecha</label>
		            <div class="form-group1">
		                <div class='input-group date' id='datetimepicker1'>
		                    <input id="fecha" name="fecha" type='text' class="form-control" value="{{date_eng2esp_1($fecha)}}" />
		                    <span class="input-group-addon">
		                        <span class="fa fa-calendar"></span>
		                    </span>
		                </div>
		            </div>
		             <span class="error_fecha"></span>
		        </div>
		        <div class="col-sm-2">
		        	<br>
		        	<button id="buscar" style="margin-top: 8px;" class="btn btn-success">Buscar</button>
		        </div>
		</div>
		<br>
		<div id="div_tabla">
			<div class="row">
				<div class="col-sm-6">
					{{$tabla1}}
				</div> <!-- col-md-6 -->

				<div class="col-sm-6">
					{{$tabla2}}
				</div> <!-- col-md-6 -->
			</div>
		</div>
    </div>

   
       <script type="text/javascript">
    	var site_url = "{{site_url()}}";
    	var id = '' ; 
		var status = '' ;
		var aPos = '';
		var fecha_cita = $("#fecha").val();
  		var fecha_comparar = "{{date('d/m/Y')}}";
            $(function () {
                $('#datetimepicker1').datetimepicker({
                	//minDate: moment(),
                	format: 'DD/MM/YYYY',
                	icons: {
	                    time: "fa fa-clock-o",
	                    date: "fa fa-calendar",
	                    up: "fa fa-arrow-up",
	                    down: "fa fa-arrow-down"
                	},
                	 locale: 'es'
                });
                $("#buscar").on('click',buscar);
            });
           if(fecha_cita==fecha_comparar){
           		 $("body").on('click','.js_cambiar_status',function(e){
		          	e.preventDefault();
	          		id = $(this).data('id')
	          		status = $(this).data('status')
	          		aPos = $(this);
	       			ConfirmCustom("¿Está seguro de cambiar el estatus a la cita?", callbackCambiarStatus,"", "Confirmar", "Cancelar");
		          });
           }else{
           		$("body").on('click','.js_cambiar_status',function(e){
		          	e.preventDefault();
	          		ErrorCustom("Sólo puedes hacer check-in el día actual de la cita.")
		          });
           }
         
      	function buscar(){
		var url =site_url+"/bodyshop/tabla_horarios_asesores";
	        ajaxLoad(url,{"fecha":$("#fecha").val()},"div_tabla","POST",function(){
	      });
		} 
		function callbackCambiarStatus(){
		var url =site_url+"/bodyshop/cambiar_status_cita/";
		ajaxJson(url,{"id":id,"status":status},"POST","",function(result){
			if(result ==0){
					ErrorCustom('No se pudo cambiar el estatus, por favor intenta de nuevo');
				}else{
					ExitoCustom("Estatus cambiado correctamente",function(){
						//buscar();
						$(".elemento_"+id).removeClass('verde');
						$(aPos).addClass('verde');
					});	
				}
		});
	}  
</script>
  </div>
</body>

</html>
