<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Comentario</th>
					<th>Estatus</th>
					<th>Usuario</th>
				</tr>
			</thead>
			<tbody>
				@if(count($historial)>0)
					@foreach($historial as $h => $value)
					<tr>
						<td>{{$value->fecha}}</td>
						<td>{{$value->comentario}}</td>
						<td>{{$value->status}}</td>
						<td>{{$value->usuario}}</td>
					</tr>
					@endforeach
				@else
					<tr>
						<td colspan="4">Aún no se han registrado comentarios</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>