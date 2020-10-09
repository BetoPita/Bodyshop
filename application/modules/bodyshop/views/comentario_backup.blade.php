<form id="frm-comentario-backup" role="form" action="<?php echo base_url();?>index.php/bodyshop/save_cronograma" method="post">
	<input type="hidden" name="idp" id="idp" value="{{$proyectoId}}">
	<div class="row">
		<div class="col-sm-12">
			<label for="">Comentario</label>
			{{$input_comentario}}
			<span class="error error_comentario"></span>
		</div>
	</div>
	<br>
	<div class="form-group">
		<label>Titulo</label>
		<input class="form-control" name="cronoTitulo" />
	</div>
	<div class="row">
		<div class="col-sm-6">
			<label for="">Fecha inicio</label>
            <div class='input-group date' id='datetimepicker2'>
                <input type="text" class="form-control" value="{{date('d/m/Y')}}" name="cronoFecha">
                <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span>
            </div>
		</div>
		<div class="col-lg-6">
			<label for="">Hora</label>
			<div class="input-group clockpicker" data-autoclose="true">
				<input type="text" class="form-control" value="" name="cronoHora">
				<span class="input-group-addon">
					<span class="fa fa-clock-o"></span>
				</span>
			</div>
		</div>
	</div>
</form>
<script>
	$('.clockpicker').clockpicker();
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
</script>