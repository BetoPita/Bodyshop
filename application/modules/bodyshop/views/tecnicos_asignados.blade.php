<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Técnico</th>
					<th>Tipo</th>
				</tr>
			</thead>
			<tbody>
				@if(count($datos)>0)
					@foreach($datos as $d => $value)
					<tr>
						<td>{{$value->tecnico}}</td>
						<td>{{$value->tipo}}</td>
					</tr>
					@endforeach
				@else
					<tr>
						<td colspan="2">Aún no se han asignado técnicos</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>