
<script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>

<script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/general.js"></script>

<script src="<?php echo base_url();?>statics/js/custom/jquery.numeric.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Tiempos por técnico</h2>
    </div>
    <div class="col-sm-2 pull-right">
        <a style="font-size: 18px;" href="{{site_url('bodyshop/tablero/cerrar_sesion_estadisticas')}}">Cerrar sesión</a>
    </div>
</div>


<div class="row">
	<div class="col-sm-4">
		<label>Técnico mecánica</label>
		{{$drop_tecnicos_mecanicos}}
	</div>
	<div class='col-sm-2'>
        <label for="">Fecha inicio</label>
        <div class='input-group date'>
            <input type="text" name="fecha_inicio_mecanicos" id="fecha_inicio_mecanicos" class="form-control date">
            <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </span>
        </div>
    </div>
    <div class='col-sm-2'>
        <label for="">Fecha Fin</label>
        <div class='input-group date' >
             <input type="text" name="fecha_fin_mecanicos" id="fecha_fin_mecanicos" class="form-control date">
            <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </span>
        </div>
    </div>
	<div style="margin-top: 20px;" class="col-sm-2">
		<button class="btn btn-success js_buscar_mecanica" data-status="6" data-titulo="Gráfica por técnico (Mecánica)">Buscar</button>
	</div>
</div>
<br>
<div class="row">
	<div class="col-sm-12">
		<div id="div_mecanica">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<label>Técnico Laminado</label>
		{{$drop_tecnicos_lamineros}}
	</div>
	<div class='col-sm-2'>
        <label for="">Fecha inicio</label>
        <div class='input-group date'>
            <input type="text" name="fecha_inicio_lamineros" id="fecha_inicio_lamineros" class="form-control date">
            <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </span>
        </div>
    </div>
    <div class='col-sm-2'>
        <label for="">Fecha Fin</label>
        <div class='input-group date' >
             <input type="text" name="fecha_fin_lamineros" id="fecha_fin_lamineros" class="form-control date">
            <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </span>
        </div>
    </div>
	<div style="margin-top: 20px;" class="col-sm-2">
		<button class="btn btn-success js_buscar_laminado" data-status="7" data-titulo="Gráfica por técnico (Laminado)">Buscar</button>
	</div>
</div>
<br>
<div class="row">
	<div class="col-sm-12">
		<div id="div_laminado">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<label>Técnico Pintura</label>
		{{$drop_tecnicos_pintores}}
	</div>
	<div class='col-sm-2'>
        <label for="">Fecha inicio</label>
        <div class='input-group date'>
            <input type="text" name="fecha_inicio_pintores" id="fecha_inicio_pintores" class="form-control date">
            <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </span>
        </div>
    </div>
    <div class='col-sm-2'>
        <label for="">Fecha Fin</label>
        <div class='input-group date' >
             <input type="text" name="fecha_fin_pintores" id="fecha_fin_pintores" class="form-control date">
            <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
            </span>
        </div>
    </div>
	<div style="margin-top: 20px;" class="col-sm-2">
		<button class="btn btn-success js_buscar_pintura" data-status="8" data-titulo="Gráfica por técnico (Pintura)">Buscar</button>
	</div>
</div>
<br>
<div class="row">
	<div class="col-sm-12">
		<div id="div_pintura">
		</div>
	</div>
</div>

<script>
	var site_url = "{{site_url()}}";

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
	$("body").on('click','.js_buscar_mecanica',function(){
		var status = $(this).data('status');
		var titulo = $(this).data('titulo');
		if($("#id_tecnico_mecanico").val()==''){
				alert('Es necesario seleccionar al técnico')
		}else{
			ajaxLoad(site_url+"/bodyshop/tiempos_tecnicos",{"id_tecnico":$("#id_tecnico_mecanico").val(),"status":status,'titulo':titulo,"fecha_inicio":$("#fecha_inicio_mecanicos").val(),"fecha_fin":$("#fecha_fin_mecanicos").val()},"div_mecanica","POST",function(){

	        });
		}
		
	});
	$("body").on('click','.js_buscar_laminado',function(){
		var status = $(this).data('status');
		var titulo = $(this).data('titulo');
		if($("#id_tecnico_laminero").val()==''){
				alert('Es necesario seleccionar al técnico')
		}else{
			ajaxLoad(site_url+"/bodyshop/tiempos_tecnicos",{"id_tecnico":$("#id_tecnico_laminero").val(),"status":status,'titulo':titulo,"fecha_inicio":$("#fecha_inicio_lamineros").val(),"fecha_fin":$("#fecha_fin_lamineros").val()},"div_laminado","POST",function(){

	        });
		}
		
	});
	$("body").on('click','.js_buscar_pintura',function(){
		var status = $(this).data('status');
		var titulo = $(this).data('titulo');
		if($("#id_tecnico_pintor").val()==''){
				alert('Es necesario seleccionar al técnico')
		}else{
			ajaxLoad(site_url+"/bodyshop/tiempos_tecnicos",{"id_tecnico":$("#id_tecnico_pintor").val(),"status":status,'titulo':titulo,"fecha_inicio":$("#fecha_inicio_pintores").val(),"fecha_fin":$("#fecha_fin_pintores").val()},"div_pintura","POST",function(){

	        });
		}
		
	});
</script>