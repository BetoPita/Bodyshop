<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>De</th>
					<th>A</th>
					<th>Fecha estatus anterior</th>
					<th>Fecha estatus nuevo</th>
					<th>Tiempo por estatus</th>
					<th>Tiempo transcurrido</th>
					<th>Estatus</th>
				</tr>
			</thead>
			<tbody>
				@foreach($diferencias as $d => $value)
					<tr>
						<td>{{$value->estatus_anterior}}</td>
						<td>{{$value->estatus_nuevo}}</td>
						<td>{{$value->fecha_estatus_anterior}}</td>
						<td>{{$value->fecha}}</td>
						<td>{{$value->tiempo_estatus}} hora(s)</td>
						<td>{{$value->tiempo_transcurrido}}</td>
						<td>
							<?php $tiempo_estatus = $value->tiempo_estatus*60 ?>
							@if($tiempo_estatus==0)
								<span class="label label-success">A tiempo</span>
							@else
								@if($tiempo_estatus>=$value->minutos_pasados)
									<span class="label label-success">A tiempo</span>
								@else
									<span class="label label-warning">Atrasado</span>

								@endif
							@endif
							
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>