<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Comentario</th>
				</tr>
			</thead>
			<tbody>
				@if(count($historial)>0)
					@foreach($historial as $h => $value)
					<tr>
						<td>{{$value->created_at}}</td>
						<td>{{$value->comentario}}</td>
					</tr>
					@endforeach
				@else
					<tr>
						<td colspan="2">Aún no se han registrado comentarios</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>