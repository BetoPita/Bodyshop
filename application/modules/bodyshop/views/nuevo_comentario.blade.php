<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<input type="hidden" name="idp" id="idp" value="{{$id_proyecto}}">
<div class="row">
	<div class="col-sm-12">
		<label for="">Comentario</label>
		{{$input_comentario}}
		<span class="error error_comentario_cambio"></span>
	</div>
</div>
<br>
<div class="row pull-right">
	<div class="col-sm-12">
		<a href="#" class="js_historial_status" data-idproyecto="{{$id_proyecto}}">historial de cambio de estatus</a>
	</div>
</div>
<br>