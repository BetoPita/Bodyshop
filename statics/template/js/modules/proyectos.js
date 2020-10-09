$(document).ready(function(){
	//-------Funciones de la vista plantilla------
	$.section('#section-plantilla',function(){
		$('#iconpicker1').on('change', function(e) {
			$('#icono').val(e.icon);
		});
		$('#modal-agregar, #modal-editar').on('click','.eliminar-etapa',function(){
			$(this).closest('li').remove();
		});
		$('#modal-agregar').on('shown.bs.modal',function(){
			$('#nombre_plantilla').focus();
		});
		$('#modal-agregar').on('hide.bs.modal',function(){
			$('#list-etapas').html('');
		});
		$('#agregar-etapa').click(function(event){
			var bandera = true,
			etapas = $('#list-etapas > li').length,
			html = '',
			nombre = $('#nombre_etapa'),
			icono = $('#icono');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(bandera){
				$('#alerta-etapas').hide();
				html = '<li class="list-group-item">'+
							'<i class="fa '+icono.val()+'"></i> '+nombre.val()+
							'<span class="action c-red">'+
								'<i class="fa fa-trash-o eliminar-etapa"></i>'+
							'</span>'+
							'<input type="hidden" name="etapa['+etapas+']" value="'+nombre.val()+'">'+
							'<input type="hidden" name="icono['+etapas+']" value="'+icono.val()+'">'+
						'</li>';
				nombre.val('');
				nombre.focus();
				$('#list-etapas').append(html);
			}
		});
		$('#form-nueva-plantilla').submit(function(event){
			event.preventDefault();
			var bandera = true,
			html = '',
			etapas = $('#list-etapas > li').length,
			nombre = $('#nombre_plantilla');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(etapas == 0){
				$('#alerta-etapas').show();
				bandera = false;
			}
			if(bandera){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						html = '<tr>'+
									'<td>'+data.datos.nombre+'</td>'+
									'<td>'+data.datos.etapas+'</td>'+
									'<td>'+
										'<ul class="actions" data-id="'+data.datos.id+'">'+
											'<li data-toggle="tooltip" title="Editar">'+
												'<i class="fa fa-edit editar-plantilla"></i>'+
											'</li>'+
											'<li data-toggle="tooltip" title="Eliminar">'+
												'<i class="fa fa-trash eliminar-plantilla"></i>'+
											'</li>'+
										'</ul>'+
									'</td>'+
								'</tr>';
						$('tbody').append(html);
						$('#modal-agregar').modal('hide');
						$('[data-toggle="tooltip"]').tooltip();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('tbody').on('click','.eliminar-plantilla',function(){
			var id = $(this).closest('ul').attr('data-id'),
			tr = $(this).closest('tr');
			swal({
				title: "¿Estas seguro de eliminar la plantilla?",
				text: "Eliminar la plantilla no afecta a los proyectos actuales",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/proyectos/eliminar_plantilla',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						tr.remove();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});

		var tr_edita;
		$('#modal-editar').on('shown.bs.modal',function(){
			$('#e_nombre_plantilla').focus();
		});
		$('#modal-editar').on('hide.bs.modal',function(){
			$('#e_list-etapas').html('');
			tr_edita = '';
		});
		$('#e_iconpicker2').on('change', function(e) {
			$('#e_icono').val(e.icon);
		});
		$('#e_agregar-etapa').click(function(event){
			var bandera = true,
			etapas = $('#e_list-etapas > li').length,
			html = '',
			nombre = $('#e_nombre_etapa'),
			icono = $('#e_icono');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(bandera){
				$('#e_alerta-etapas').hide();
				html = '<li class="list-group-item">'+
							'<i class="fa '+icono.val()+'"></i> '+nombre.val()+
							'<span class="action c-red">'+
								'<i class="fa fa-trash-o eliminar-etapa"></i>'+
							'</span>'+
							'<input type="hidden" name="etapa['+etapas+']" value="'+nombre.val()+'">'+
							'<input type="hidden" name="icono['+etapas+']" value="'+icono.val()+'">'+
						'</li>';
				nombre.val('');
				nombre.focus();
				$('#e_list-etapas').append(html);
			}
		});
		$('tbody').on('click','.editar-plantilla',function(){
			var id = $(this).closest('ul').attr('data-id'),
			html = '',
			etapas = 0;
			tr_edita = $(this).closest('tr');
			$.ajaxData({
				url: 'index.php/proyectos/get_plantilla',
				data:{id:id},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#e_nombre_plantilla').val(data.datos.plantilla.nombre);
					$('#e_nombre_plantilla').closest('.fg-line').addClass('fg-toggled');
					$('#e_id_plantilla').val(data.datos.plantilla.id);
					$.each(data.datos.etapas,function(index,value){
						html += '<li class="list-group-item">'+
							'<i class="fa '+value.icono+'"></i> '+value.nombre+
							'<span class="action c-red">'+
								'<i class="fa fa-trash-o eliminar-etapa"></i>'+
							'</span>'+
							'<input type="hidden" name="etapa['+etapas+']" value="'+value.nombre+'">'+
							'<input type="hidden" name="icono['+etapas+']" value="'+value.icono+'">'+
						'</li>';
						etapas++;
					});
					$('#e_list-etapas').append(html);
					$('#modal-editar').modal('show');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#form-edita-plantilla').submit(function(event){
			event.preventDefault();
			var bandera = true,
			html = '',
			etapas = $('#e_list-etapas > li').length,
			nombre = $('#e_nombre_plantilla');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(etapas == 0){
				$('#e_alerta-etapas').show();
				bandera = false;
			}
			if(bandera){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						html = '<td>'+data.datos.nombre+'</td>'+
								'<td>'+data.datos.etapas+'</td>'+
								'<td>'+
									'<ul class="actions" data-id="'+data.datos.id+'">'+
										'<li>'+
											'<i class="fa fa-edit editar-plantilla"></i>'+
										'</li>'+
										'<li>'+
											'<i class="fa fa-trash eliminar-plantilla"></i>'+
										'</li>'+
									'</ul>'+
								'</td>';
						tr_edita.html(html);
						$('#modal-editar').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
	});

	$.section('#section-proyectos',function(){
		var principal = $('#principal').val();
		var permiso = $('#permiso').val();
		var generales = $('#generales').val();
		var etapas = $('#etapas').val();
		var integrantes = $('#integrantes').val();
		$('#proyectos > .proyecto').each(function(){
			var fecha_compromiso = String($(this).attr('data-fecha'));
			var estado = parseInt($(this).attr('data-estado'));
			if(estado == 1 && fecha_compromiso != ''){
				if(moment().isAfter(fecha_compromiso)){
					$(this).find('.card-header').removeClass('bgm-bluegray').addClass('bgm-red');
				}
			}
		});
		$.extend($.expr[":"],{
			"contains-ci": function(elem, i, match, array) {
				return ($(elem).attr('data-nombre') || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
			}
		});
		$('#ordenar').change(function(){
			var opcion = $(this).val();
			$('#alert-no-results').hide();
			$('#proyectos > .proyecto').show();
			$('span.lider').remove();
			if(opcion == 0){
				$('#proyectos > .proyecto').sort(function(a, b) {
					var compA = $(a).attr('data-id');
					var compB = $(b).attr('data-id');
					return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
				}).each(function() {
					$('#proyectos').append(this);
				});
			}else if(opcion == 1){
				$('#proyectos > .proyecto').sort(function(a, b) {
					var compA = $(a).attr('data-nombre').toUpperCase();
					var compB = $(b).attr('data-nombre').toUpperCase();
					return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
				}).each(function() {
					$('#proyectos').append(this);
				});
			}else if(opcion == 2){
				$('#proyectos > .proyecto').sort(function(a, b) {
					var compA = $(a).attr('data-nombre').toUpperCase();
					var compB = $(b).attr('data-nombre').toUpperCase();
					return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
				}).each(function() {
					$('#proyectos').prepend(this);
				});
			}else if(opcion == 3){
				$('#proyectos > .proyecto').sort(function(a,b){
					return new Date($(a).attr("data-creado")) > new Date($(b).attr("data-creado"));
				}).each(function(){
					$('#proyectos').prepend(this);
				});
			}else if(opcion == 4){
				$('#proyectos > .proyecto').sort(function(a,b){
					return new Date($(a).attr("data-creado")) < new Date($(b).attr("data-creado"));
				}).each(function(){
					$('#proyectos').prepend(this);
				});
			}else if(opcion == 5){
				$('#proyectos > .proyecto').sort(function(a, b) {
					var compA = $(a).attr('data-lider').toUpperCase();
					var compB = $(b).attr('data-lider').toUpperCase();
					return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
				}).each(function() {
					$('#proyectos').append(this);
				});
				var new_lider = '';
				$('#proyectos > .proyecto').each(function(){
					var lider = $(this).attr('data-lider');
					if(new_lider != lider){
						$(this).before('<span class="col-sm-12 lider"><h4><i class="fa fa-user"></i> '+lider+'</h4></span>');
						new_lider = lider;
					}
				});
			}else if(opcion == 6){
				$('#proyectos > .proyecto').each(function(){
					if($(this).attr('data-estado') != 1){
						$(this).hide();
					}
				});
			}else if(opcion == 7){
				$('#proyectos > .proyecto').each(function(){
					if($(this).attr('data-estado') != 2){
						$(this).hide();
					}
				});
			}else if(opcion == 8){
				$('#proyectos > .proyecto').each(function(){
					if($(this).attr('data-estado') != 0){
						$(this).hide();
					}
				});
			}
			var count = 0;
			$('#proyectos > .proyecto').each(function(){
				if($(this).is(':visible')){
					count++;
				}
			});
			if(count == 0){
				$('#alert-no-results').show();
			}
		});
		$('#busqueda').keyup(function(){
			if( $(this).val() != ""){
				$('#proyectos > .proyecto').hide();
				$('#proyectos > .proyecto:contains-ci("'+$(this).val()+'")').show();
			}else{
				$('#proyectos > .proyecto').show();
			}
		});
		$('#modal-agregar, #modal-editar').on('click','.eliminar-etapa',function(){
			$(this).closest('li').remove();
		});
		$('#iconpicker').on('change', function(e) {
			$('#icono').val(e.icon);
		});
		$('#plantilla').change(function(){
			if($('#plantilla option:selected').val() != ''){
				$('#agregar-plantilla').prop('disabled',false);
			}else{
				$('#agregar-plantilla').prop('disabled',true);
			}
		});
		$('#modal-agregar').on('hide.bs.modal',function(){
			$('#list-etapas').html('');
			$('#plantilla option[value=""]').prop('selected',true);
			$('#agregar-plantilla').prop('disabled',true);
			$('input[name="integrante[]"]').prop('checked',false);
			$('#lider').html('<option value="">Agrega integrantes al proyecto</option>');
			$('.tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
			$('.tab-nav.wizard > li:nth-child(1), .tab-content > .tab-pane:nth-child(1)').addClass('active');
			$('#btn-guardar').hide();
			$('#btn-atras').hide();
			$('#btn-siguiente').show();
		});
		$('#btn-siguiente').click(function(){
			var bandera = true;
			if($('.tab-nav.wizard > li:nth-child(1)').hasClass('active')){
				var nombre = $('#nombre');
				if(!($.requerido(nombre))){
					bandera = false;
				}
				if(bandera){
					$('.tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
					$('.tab-nav.wizard > li:nth-child(2), .tab-content > .tab-pane:nth-child(2)').addClass('active');
					$('#btn-atras').show();
				}
			}else if($('.tab-nav.wizard > li:nth-child(2)').hasClass('active')){
				if($('#list-etapas > li').length == 0){
					bandera = false;
					$('#alerta-etapas').show();
				}
				if(bandera){
					$('.tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
					$('.tab-nav.wizard > li:nth-child(3), .tab-content > .tab-pane:nth-child(3)').addClass('active');
					$(this).hide();
					$('#btn-guardar').show();
				}
			}
		});
		$('#btn-atras').click(function(){
			if($('.tab-nav.wizard > li:nth-child(3)').hasClass('active')){
				$('.tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
				$('.tab-nav.wizard > li:nth-child(2), .tab-content > .tab-pane:nth-child(2)').addClass('active');
				$('#btn-guardar').hide();
				$('#btn-siguiente').show();
			}else if($('.tab-nav.wizard > li:nth-child(2)').hasClass('active')){
				$('.tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
				$('.tab-nav.wizard > li:nth-child(1), .tab-content > .tab-pane:nth-child(1)').addClass('active');
				$(this).hide();
				$('#btn-siguiente').show();
			}
		});
		$('#agregar-plantilla').click(function(){
			var etapas = $('#list-etapas > li').length,
			id = $('#plantilla option:selected').val(),
			html = '';
			$.ajaxData({
				url: 'index.php/proyectos/get_etapas',
				data:{id:id},
				method: 'post'
			},function(data){
				if(data.resp){
					$.each(data.datos,function(index,value){
						html += '<li class="list-group-item">'+
							'<i class="fa '+value.icono+'"></i> '+value.nombre+
							'<span class="action c-red">'+
								'<i class="fa fa-trash-o eliminar-etapa"></i>'+
							'</span>'+
							'<input type="hidden" name="etapa['+etapas+']" value="'+value.nombre+'">'+
							'<input type="hidden" name="icono['+etapas+']" value="'+value.icono+'">'+
						'</li>';
						etapas++;
					});
					$('#alerta-etapas').hide();
					$('#plantilla').val('');
					$('#agregar-plantilla').prop('disabled',true);
					$('#list-etapas').append(html);
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#agregar_etapa').click(function(event){
			var bandera = true,
			etapas = $('#list-etapas > li').length,
			html = '',
			nombre = $('#nombre_etapa'),
			icono = $('#icono');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(bandera){
				$('#alerta-etapas').hide();
				html = '<li class="list-group-item">'+
							'<i class="fa '+icono.val()+'"></i> '+nombre.val()+
							'<span class="action c-red">'+
								'<i class="fa fa-trash-o eliminar-etapa"></i>'+
							'</span>'+
							'<input type="hidden" name="etapa['+etapas+']" value="'+nombre.val()+'">'+
							'<input type="hidden" name="icono['+etapas+']" value="'+icono.val()+'">'+
						'</li>';
				nombre.val('');
				nombre.focus();
				$('#list-etapas').append(html);
			}
		});
		$('input[name="integrante[]"]').change(function(){
			var id = $(this).val(),
			nombre = $(this).closest('.perfil').find('.ts-label').text();
			if($(this).is(':checked')){
				$('#lider').append('<option value="'+id+'">'+nombre+'</option>');
			}else{
				$('#lider option[value="'+id+'"]').remove();
			}
			if($('#lider option').length > 1){
				$('#lider option[value=""]').text('Seleccionar líder');
			}else{
				$('#lider option[value=""]').text('Agrega integrantes al proyecto');
			}
		});
		$('#form-nuevo-proyecto').submit(function(event){
			event.preventDefault();
			var html = '',
			estado = '',
			color = '',
			fecha = '',
			acciones = '',
			editar = '';
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					$('#alert-no-proyectos').remove();
					$('#modal-agregar').modal('hide');
					$('#ordenar option[value="0"]').prop('selected',true);
					$('#proyectos > .proyecto').show();
					$('span.lider').remove();
					$('#proyectos > .proyecto').sort(function(a, b) {
						var compA = $(a).attr('data-id');
						var compB = $(b).attr('data-id');
						return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
					}).each(function() {
						$('#proyectos').append(this);
					});
					if(data.datos.estado == 0){
						estado = 'Terminado';
						color = 'c-green';
					}else if(data.datos.estado == 1){
						estado = 'Activo';
						color = 'c-blue';
					}else{
						estado = 'Suspendido';
						color = 'c-red';
					}
					if(data.datos.fecha_compromiso != null){
						fecha = moment(data.datos.fecha_compromiso).format('ll');
					}
					if(principal == 1 || generales == 1 || etapas == 1 || integrantes == 1){
						editar = '<button type="button" data-toggle="tooltip" title="Editar"'+
										'class="btn btn-info btn-icon waves-effect waves-circle waves-float editar-proyecto">'+
										'<i class="fa fa-pencil"></i>'+
									'</button>';
					}
					if(principal == 1){
						acciones = '<ul class="actions mini pull-right">'+
										'<li data-toggle="tooltip" title="Archivar"><i class="fa fa-folder m-r-5 archivar"></i></li>'+
										'<li data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash c-red m-r-5 eliminar"></i></li>'+
									'</ul>';
					}
					html = '<div class="col-xs-12 col-sm-6 col-md-4 proyecto"'+
								'data-id="'+data.datos.id+'"'+
								'data-nombre="'+data.datos.nombre+'"'+
								'data-estado="'+data.datos.estado+'"'+
								'data-lider="'+data.datos.lider+'"'+
								'data-creado="'+data.datos.fecha_creado+'"'+
								'data-fecha="'+data.datos.fecha_compromiso+'">'+
								'<div class="card">'+
									'<div class="card-header bgm-bluegray p-10">'+
										'<h2 data-link="index.php/proyectos/detalle/'+data.datos.id+'">'+data.datos.nombre+'<small>'+data.datos.descripcion+'&nbsp;</small></h2>'+
										editar+
									'</div>'+
									'<div class="card-body p-10">'+
										'<ul class="clist p-0">'+
											'<li><strong>Fecha creado: </strong>'+moment(data.datos.fecha_creado).format('ll')+'</li>'+
											'<li><strong>Fecha compromiso: </strong>'+fecha+'</li>'+
											'<li><strong>Líder de proyecto: </strong>'+data.datos.lider+'</li>'+
											'<li>'+
												'<strong>Estado: </strong><span class="'+color+'">'+estado+'</span>'+
											'</li>'+
										'</ul>'+
										acciones+
										'<div class="clearfix"></div>'+
									'</div>'+
								'</div>'+
							'</div>';
					$('#proyectos').append(html);
					$('[data-link]').on('click',function(){
						window.location.href = $(this).attr('data-link');
					});
					$('[data-toggle="tooltip"]').tooltip();
					swal(data.titulo, data.mensaje, "success");
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$(document).on('click','#proyectos > .proyecto .archivar',function(){
			var element = $(this).parents('.proyecto');
			var id = element.attr('data-id');
			swal({
				title: "¿Estas seguro de archivar el proyecto?",
				text: "Al archivar un proyecto su estado pasara como terminado",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, archivar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/proyectos/archivar_proyecto',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						element.remove();
						if($('#proyectos > .proyecto').length == 0){
							$('#alert-no-proyectos').show();
						}
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','#proyectos > .proyecto .eliminar',function(){
			var element = $(this).parents('.proyecto');
			var id = element.attr('data-id');
			swal({
				title: "¿Estas seguro de eliminar el proyecto?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/proyectos/eliminar_proyecto',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						element.remove();
						if($('#proyectos > .proyecto').length == 0){
							$('#alert-no-proyectos').show();
						}
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','#proyectos > .proyecto .editar-proyecto',function(){
			var element = $(this).parents('.proyecto');
			$.ajaxData({
				url: 'index.php/proyectos/get_proyecto',
				data:{id:element.attr('data-id')},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#e-id_proyecto').val(data.datos.id);
					$('#e-fecha_creacion').val(data.datos.fecha_creacion);
					$('#e-nombre').val(data.datos.nombre);
					$('#e-descripcion').val(data.datos.descripcion);
					if(data.datos.fecha_compromiso != null){
						$('#e-fecha_compromiso').val(moment(data.datos.fecha_compromiso).format('DD/MM/YYYY'));
					}
					$('#e-estado option[value="'+data.datos.estado+'"]').prop('selected', true);
					$('#e-generales input').each(function(){
						if($(this).val() != ''){
							$(this).closest('.fg-line').addClass('fg-toggled');
						}
					});
					var etapas = 0, html = '';
					$.each(data.etapas,function(index,value){
						html += '<li class="list-group-item">'+
							'<i class="fa '+value.icono+'"></i> '+value.nombre+
							' - <i class="fa fa-comment-o"></i> '+value.comentarios+
							'<span class="action c-red">'+
								'<i class="fa fa-trash-o eliminar-etapa-existente"></i>'+
							'</span>'+
							'<input type="hidden" name="id_etapa['+etapas+']" value="'+value.id+'">'+
							'<input type="hidden" name="etapa['+etapas+']" value="'+value.nombre+'">'+
							'<input type="hidden" name="icono['+etapas+']" value="'+value.icono+'">'+
							'<input type="hidden" name="existente['+etapas+']" value="1">'+
							'<input type="hidden" name="borrar['+etapas+']" value="0" class="borrar">'+
						'</li>';
						etapas++;
					});
					$('#e-list-etapas').append(html);
					if(data.integrantes.length > 0){
						$('#e-lider').append('<option value="">Seleccionar lider</option>');
						$.each(data.integrantes,function(index,value){
							$('#e-integrantes input[value="'+value.id_perfil+'"]').prop('checked',true);
							if(value.lider == 1){
								$('#e-lider').append('<option value="'+value.id_perfil+'" selected>'+value.nombre+'</option>');
							}else{
								$('#e-lider').append('<option value="'+value.id_perfil+'">'+value.nombre+'</option>');
							}
						});
					}else{
						$('#e-lider').append('<option value="">Agrega integrantes al proyecto</option>');
					}
					$('#modal-editar').modal('show');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#e-btn-siguiente').click(function(){
			var bandera = true;
			if($('#form-editar-proyecto .tab-nav.wizard > li:nth-child(1)').hasClass('active')){
				var nombre = $('#e-nombre');
				if(!($.requerido(nombre))){
					bandera = false;
				}
				if(bandera){
					$('#form-editar-proyecto .tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
					$('#form-editar-proyecto .tab-nav.wizard > li:nth-child(2), .tab-content > .tab-pane:nth-child(2)').addClass('active');
					$('#e-btn-atras').show();
				}
			}else if($('#form-editar-proyecto .tab-nav.wizard > li:nth-child(2)').hasClass('active')){
				if($('#e-list-etapas > li').length == 0){
					bandera = false;
					$('#e-alerta-etapas').show();
				}
				if(bandera){
					$('#form-editar-proyecto .tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
					$('#form-editar-proyecto .tab-nav.wizard > li:nth-child(3), .tab-content > .tab-pane:nth-child(3)').addClass('active');
					$(this).hide();
					$('#e-btn-guardar').show();
				}
			}
		});
		$('#e-btn-atras').click(function(){
			if($('#form-editar-proyecto .tab-nav.wizard > li:nth-child(3)').hasClass('active')){
				$('#form-editar-proyecto .tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
				$('#form-editar-proyecto .tab-nav.wizard > li:nth-child(2), .tab-content > .tab-pane:nth-child(2)').addClass('active');
				$('#e-btn-guardar').hide();
				$('#e-btn-siguiente').show();
			}else if($('#form-editar-proyecto .tab-nav.wizard > li:nth-child(2)').hasClass('active')){
				$('#form-editar-proyecto .tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
				$('#form-editar-proyecto .tab-nav.wizard > li:nth-child(1), .tab-content > .tab-pane:nth-child(1)').addClass('active');
				$(this).hide();
				$('#e-btn-siguiente').show();
			}
		});
		$('#e-iconpicker').on('change', function(e) {
			$('#e-icono').val(e.icon);
		});
		$('#e-list-etapas').on('click','.eliminar-etapa-existente',function(){
			var element = $(this).parents('li');
			swal({
				title: "¿Estas seguro de eliminar la etapa?",
				text: "Al borrar la etapa se borraran todos los datos relacionados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: true
			}, function(){
				element.hide();
				element.find('.borrar').val('1');
			});
		});
		$('#e-agregar_etapa').click(function(event){
			var bandera = true,
			etapas = $('#e-list-etapas > li').length,
			html = '',
			nombre = $('#e-nombre_etapa'),
			icono = $('#e-icono');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(bandera){
				$('#e-alerta-etapas').hide();
				html = '<li class="list-group-item">'+
							'<i class="fa '+icono.val()+'"></i> '+nombre.val()+
							'<span class="action c-red">'+
								'<i class="fa fa-trash-o eliminar-etapa"></i>'+
							'</span>'+
							'<input type="hidden" name="etapa['+etapas+']" value="'+nombre.val()+'">'+
							'<input type="hidden" name="icono['+etapas+']" value="'+icono.val()+'">'+
						'</li>';
				nombre.val('');
				nombre.focus();
				$('#e-list-etapas').append(html);
			}
		});
		$('#e-integrantes input[name="integrante[]"]').change(function(){
			var id = $(this).val(),
			nombre = $(this).closest('.perfil').find('.ts-label').text();
			if($(this).is(':checked')){
				$('#e-lider').append('<option value="'+id+'">'+nombre+'</option>');
			}else{
				$('#e-lider option[value="'+id+'"]').remove();
			}
			if($('#lider option').length > 1){
				$('#e-lider option[value=""]').text('Seleccionar lider');
			}else{
				$('#e-lider option[value=""]').text('Agrega integrantes al proyecto');
			}
		});
		$('#form-editar-proyecto').submit(function(event){
			event.preventDefault();
			var html = '',
			estado = '',
			color = '',
			fecha = '',
			editar = '',
			acciones = '';
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					$('#modal-editar').modal('hide');
					if(data.datos.estado == 0){
						estado = 'Terminado';
						color = 'c-green';
					}else if(data.datos.estado == 1){
						estado = 'Activo';
						color = 'c-blue';
					}else{
						estado = 'Suspendido';
						color = 'c-red';
					}
					if(data.datos.fecha_compromiso != null){
						fecha = moment(data.datos.fecha_compromiso).format('ll');
					}
					if(principal == 1 || generales == 1 || etapas == 1 || integrantes == 1){
						editar = '<button type="button" data-toggle="tooltip" title="Editar"'+
										'class="btn btn-info btn-icon waves-effect waves-circle waves-float editar-proyecto">'+
										'<i class="fa fa-pencil"></i>'+
									'</button>';
					}
					if(principal == 1){
						acciones = '<ul class="actions mini pull-right">'+
										'<li data-toggle="tooltip" title="Archivar"><i class="fa fa-folder m-r-5 archivar"></i></li>'+
										'<li data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash c-red m-r-5 eliminar"></i></li>'+
									'</ul>';
					}
					html = '<div class="col-xs-12 col-sm-6 col-md-4 proyecto"'+
								'data-id="'+data.datos.id+'"'+
								'data-nombre="'+data.datos.nombre+'"'+
								'data-estado="'+data.datos.estado+'"'+
								'data-lider="'+data.datos.lider+'"'+
								'data-creado="'+data.datos.fecha_creado+'"'+
								'data-fecha="'+data.datos.fecha_compromiso+'">'+
								'<div class="card">'+
									'<div class="card-header bgm-bluegray p-10">'+
										'<h2 data-link="index.php/proyectos/detalle/'+data.datos.id+'">'+data.datos.nombre+'<small>'+data.datos.descripcion+'&nbsp;</small></h2>'+
										editar+
										'</button>'+
									'</div>'+
									'<div class="card-body p-10">'+
										'<ul class="clist p-0">'+
											'<li><strong>Fecha creado: </strong>'+moment(data.datos.fecha_creado).format('ll')+'</li>'+
											'<li><strong>Fecha compromiso: </strong>'+fecha+'</li>'+
											'<li><strong>Líder de proyecto: </strong>'+data.datos.lider+'</li>'+
											'<li>'+
												'<strong>Estado: </strong><span class="'+color+'">'+estado+'</span>'+
											'</li>'+
										'</ul>'+
										acciones+
										'<div class="clearfix"></div>'+
									'</div>'+
								'</div>'+
							'</div>';
					var element;
					$('#proyectos .proyecto').each(function(){
						if($(this).attr('data-id') == data.datos.id){
							element =  $(this);
						}
					});
					element.before(html);
					element.remove();
					$('[data-link]').on('click',function(){
						window.location.href = $(this).attr('data-link');
					});
					$('[data-toggle="tooltip"]').tooltip();
					swal(data.titulo, data.mensaje, "success");
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#modal-editar').on('hide.bs.modal',function(){
			$('#e-list-etapas').html('');
			$('#e-plantilla option[value=""]').prop('selected',true);
			$('#e-agregar-plantilla').prop('disabled',true);
			$('input[name="integrante[]"]').prop('checked',false);
			$('#e-lider').html('');
			$('#form-editar-proyecto .tab-nav.wizard > li, .tab-content > .tab-pane').removeClass('active');
			$('#form-editar-proyecto .tab-nav.wizard > li:nth-child(1), .tab-content > .tab-pane:nth-child(1)').addClass('active');
			$('#e-btn-guardar').hide();
			$('#e-btn-atras').hide();
			$('#e-btn-siguiente').show();
		});
		$('#modal-usuarios').on('show.bs.modal',function(){
			$('#form-usuarios-permisos input').each(function(){
				if($(this).attr('data-permiso') == 1){
					$(this).prop('checked',true);
				}
			})
		});

		$('#form-usuarios-permisos').submit(function(event){
			event.preventDefault();
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					swal(data.titulo, data.mensaje, "success");
					$('#form-usuarios-permisos input').each(function(){
						if($(this).is(':checked')){
							$(this).attr('data-permiso','1');
						}else{
							$(this).attr('data-permiso','0');
						}
					});
					$('#modal-usuarios').modal('hide');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
	});

	$.section('#section-detalle',function(){
		var id_perfil = $('#id_perfil').val();
		/*$(window).scroll(function(){
			var $cache = $('.nav-detalle');
			if ($(window).scrollTop() > 350)
				$cache.css({
					'position': 'fixed',
					'top': '70px'
				});
			else
				$cache.css({
					'position': 'relative',
					'top': 'auto'
				});
		});*/
		$('.etapa').click(function(){
			$('.etapa').removeClass('active');
			$(this).addClass('active');
			$('#comments').show();
			$('#none-comments').hide();
			$('#load').show();
			$('#acciones-etapa > li').removeClass('active');
			$('#acciones-etapa > li:first-child').addClass('active');
			$('.card.post').remove();
			var id = $(this).attr('data-id');
			$('#id_etapa').val(id);
			$('#nombre').html($(this).attr('data-nombre'));
			$.ajaxData({
					url: 'index.php/proyectos/get_comentarios',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						if(data.datos.length > 0){
							var count_c = 0,
								count_i = 0,
								count_a = 0;
							$.each(data.datos,function(index,value){
								var html = '',
									imagen = '',
									archivo = '',
									acciones = '',
									respuestas = '';
								count_c++;
								if(value.imagen == '1'){
									imagen = '<figure>'+
												'<img src="'+value.url_imagen+'">'+
											'</figure>';
									count_i++;
								}
								if(value.archivo == '1'){
									archivo = '<ul class="list-group file">'+
													'<li class="list-group-item">'+
														'<a href="'+value.url_archivo+'" target="_self"><i class="fa fa-file-o"></i> <span>'+value.nombre_archivo+'</span></a>'+
													'</li>'+
												'</ul>';
									count_a++;
								}
								if(id_perfil == value.propietario){
									acciones = '<ul class="actions">'+
													'<li class="dropdown">'+
														'<a href="" data-toggle="dropdown" class="post-action">'+
															'<i class="fa fa-ellipsis-v"></i>'+
														'</a>'+
														'<ul class="dropdown-menu dropdown-menu-right">'+
															'<li>'+
																'<a href="javascript:;" class="editar-comentario">Editar</a>'+
															'</li>'+
															'<li>'+
																'<a href="javascript:;" class="eliminar-comentario">Eliminar</a>'+
															'</li>'+
														'</ul>'+
													'</li>'+
												'</ul>';
								}
								if(data.respuestas[value.id].length > 0){
									$.each(data.respuestas[value.id],function(ind,val){
										var acciones = '';
										if(id_perfil == val.id_perfil){
											acciones = '<ul class="actions">'+
															'<li data-toggle="tooltip" title="Eliminar respuesta"><i class="fa fa-times eliminar-respuesta"></i></li>'+
														'</ul>';
										}
										respuestas += '<div class="media" data-id="'+val.id+'">'+
														'<div class="pull-left">'+
															'<figure class="avatar">'+
																'<img class="media-object" src="statics/img/profile-pics/'+val.avatar+'">'+
															'</figure>'+
														'</div>'+
														'<div class="media-body">'+
															'<strong>'+val.nombre+'</strong> <small>'+moment(val.fecha).format('lll')+'</small>'+acciones+'<br>'+
															val.respuesta+
														'</div>'+
													'</div>';
									});
								}else{
									respuestas = '<div class="centered none-comments">'+
													'<h4>No hay comentarios</h4>'+
												'</div>';
								}
								html = '<div class="card post m-b-10"'+
										'data-id="'+value.id+'"'+
										'data-id_etapa="'+id+'"'+
										'data-imagen="'+value.imagen+'"'+
										'data-archivo="'+value.archivo+'">'+
											'<div class="card-header ch-alt p-10">'+
												'<div class="media">'+
													'<div class="pull-left">'+
														'<figure class="avatar">'+
															'<img class="media-object" src="statics/img/profile-pics/'+value.avatar+'" alt="">'+
														'</figure>'+
													'</div>'+
													'<div class="media-body">'+
														'<h4 class="media-heading">'+value.nombre+'</h4>'+
														'<small class="fecha-time">'+moment(value.fecha).format('lll')+'</small>'+acciones+
													'</div>'+
												'</div>'+
											'</div>'+
											'<div class="card-body p-l-5 p-r-5">'+
												'<span class="comentario-contenido">'+value.comentario+'</span>'+imagen+archivo+
												'<ul class="clist action footer">'+
													'<li><a data-toggle="collapse" data-target="#comentarios-'+value.id+'" data-id="'+value.id+'" data-comentarios="'+value.respuestas+'" data-open="1">Ver comentarios('+value.respuestas+')</a></li>'+
												'</ul>'+
											'</div>'+
											'<div class="card-footer">'+
												'<div class="comentarios collapse in p-5" id="comentarios-'+value.id+'">'+
													respuestas+
												'</div>'+
												'<form class="comment" action="index.php/proyectos/nueva_respuesta" target="_self" method="post">'+
													'<input type="hidden" name="id_comentario" value="'+value.id+'">'+
													'<input type="hidden" name="id_perfil" value="'+id_perfil+'">'+
													'<textarea placeholder="Escribe aquí" name="comentario"></textarea>'+
													'<button type="submit"><i class="md md-send"></i></button>'+
												'</form>'+
											'</div>'+
										'</div>';
								$('#datos').append(html);
							});
							//$('[data-toggle="tooltip"]').tooltip();
							$('#n-comentarios').text(count_c);
							$('#n-imagenes').text(count_i);
							$('#n-archivos').text(count_a);
						}else{
							$('#n-comentarios').text('0');
							$('#n-imagenes').text('0');
							$('#n-archivos').text('0');
							$('#none-comments').show();
						}
						$('#load').hide();
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				}
			);
		});
		$('.etapa.first').click().addClass('active');
		$('#adjunt-img').click(function(){
			$('#imagen').click();
		});
		$("#imagen").change(function(){
			if (this.files && this.files[0]) {
				if(this.files[0].size < 2*1048576){
					var reader = new FileReader();
					reader.onload = function (e) {
						$('#preview').attr('src', e.target.result);
						$('.preview').show();
					}
					reader.readAsDataURL(this.files[0]);
				}else{
					$("#imagen").val('');
					swal('Imagen muy grande', 'La imagen no debe de ser mayor a 2 MB', "warning");
				}
			}
		});
		$('#adjunt-file').click(function(){
			$('#file').click();
		});
		$("#file").change(function(){
			console.log(this.files)
			if (this.files && this.files[0]) {
				if(this.files[0].size < 2*1048576){
					$('#file-name').text(this.files[0].name);
					$('.file').show();
				}else{
					$("#file").val('');
					swal('Archivo muy grande', 'El archivo no debe de ser mayor a 2 MB', "warning");
				}
			}
		});
		$('#eliminar-imagen').click(function(){
			$('.preview').hide();
			$("#imagen").val('');
		});
		$('#eliminar-archivo').click(function(){
			$('.file').hide();
			$("#file").val('');
		});
		$('#form-nuevo-comentario').submit(function(event){
			event.preventDefault();
			$('#text-comentario').html($('.editor-nuevo-comentario').html());
			$('#acciones-etapa > li').removeClass('active');
			$('#acciones-etapa > li:first-child').addClass('active');
			if($('.editor-nuevo-comentario').html().trim() != '' || $("#file").val() != '' || $("#imagen").val() != ''){
				$.ajaxFormData($(this),function(data){
					if(data.resp){
						$('#none-comments').hide();
						$('.file').hide();
						$("#file").val('');
						$('.preview').hide();
						$("#imagen").val('');
						$('#text-comentario').html('');
						$('.editor-nuevo-comentario').html('');
						//$('#text-comentario').css('height','34px');
						var html = '',
						imagen = '',
						archivo = '';
						if(data.datos.imagen == '1'){
							imagen = '<figure>'+
										'<img src="'+data.datos.url_imagen+'">'+
									'</figure>';
						}else{
							imagen = '';
						}
						if(data.datos.archivo == '1'){
							archivo = '<ul class="list-group file">'+
											'<li class="list-group-item">'+
												'<a href="'+data.datos.url_archivo+'" target="_self"><i class="fa fa-file-o"></i> <span>'+data.datos.nombre_archivo+'</span></a>'+
											'</li>'+
										'</ul>';
						}else{
							archivo = '';
						}
						html = '<div class="card post m-b-10"'+
								'data-id="'+data.datos.id+'"'+
								'data-id_etapa="'+data.datos.id_etapa+'"'+
								'data-imagen="'+data.datos.imagen+'"'+
								'data-archivo="'+data.datos.archivo+'">'+
									'<div class="card-header ch-alt p-10">'+
										'<div class="media">'+
											'<div class="pull-left">'+
												'<figure class="avatar">'+
													'<img class="media-object" src="statics/img/profile-pics/'+data.datos.avatar+'" alt="">'+
												'</figure>'+
											'</div>'+
											'<div class="media-body">'+
												'<h4 class="media-heading">'+data.datos.nombre+'</h4>'+
												'<small class="fecha-time">'+moment(data.datos.fecha).format('lll')+'</small>'+
												'<ul class="actions">'+
													'<li class="dropdown">'+
														'<a href="" data-toggle="dropdown" class="post-action">'+
															'<i class="fa fa-ellipsis-v"></i>'+
														'</a>'+
														'<ul class="dropdown-menu dropdown-menu-right">'+
															'<li>'+
																'<a href="javascript:;" class="editar-comentario">Editar</a>'+
															'</li>'+
															'<li>'+
																'<a href="javascript:;" class="eliminar-comentario">Eliminar</a>'+
															'</li>'+
														'</ul>'+
													'</li>'+
												'</ul>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div class="card-body p-l-5 p-r-5">'+
										'<span class="comentario-contenido">'+data.datos.comentario+'</span>'+imagen+archivo+
										'<ul class="clist action footer">'+
											'<li><a data-toggle="collapse" data-target="#comentarios-'+data.datos.id+'" data-id="'+data.datos.id+'" data-comentarios="0" data-open="0">Ver comentarios(0)</a></li>'+
										'</ul>'+
									'</div>'+
									'<div class="card-footer">'+
										'<div class="comentarios collapse p-5" id="comentarios-'+data.datos.id+'">'+
											'<div class="centered load">'+
												'<i class="fa fa-spin fa-2x fa-spinner"></i>'+
											'</div>'+
											'<div class="centered none-comments" style="display:none;">'+
												'<h4>No hay comentarios</h4>'+
											'</div>'+
										'</div>'+
										'<form class="comment" action="index.php/proyectos/nueva_respuesta" target="_self" method="post">'+
											'<input type="hidden" name="id_comentario" value="'+data.datos.id+'">'+
											'<input type="hidden" name="id_perfil" value="'+id_perfil+'">'+
											'<textarea placeholder="Escribe aquí" name="comentario"></textarea>'+
											'<button type="submit"><i class="md md-send"></i></button>'+
										'</form>'+
									'</div>'+
								'</div>';
						$('#datos').prepend(html);
						var count_c = 0, count_i = 0, count_a = 0;
						$('#datos .post').each(function(){
							count_c++;
							if($(this).attr('data-imagen') == 1){
								count_i++;
							} if($(this).attr('data-archivo') == 1){
								count_a++;
							}
						});
						$('#n-comentarios').text(count_c);
						$('#n-imagenes').text(count_i);
						$('#n-archivos').text(count_a);
						$('.etapa').each(function(){
							if($(this).attr('data-id') == data.datos.id_etapa){
								$(this).find('.tmn-counts').text(count_c);
							}
						});
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('#datos').on('submit','form.comment',function(event){
			event.preventDefault();
			var element = $(this).parents('.post');
			var toogle = element.find('[data-toggle="collapse"]');
			$.ajaxSerialize($(this),function(data){
				element.find('.none-comments').hide();
				$('textarea').val('');
				$('textarea').css('height','34px');
				if(data.resp){
					if(toogle.attr('data-open') == 1){
						var html = '<div class="media">'+
										'<div class="pull-left">'+
											'<figure class="avatar">'+
												'<img class="media-object" src="statics/img/profile-pics/'+data.datos.avatar+'">'+
											'</figure>'+
										'</div>'+
										'<div class="media-body">'+
											'<strong>'+data.datos.nombre+'</strong> <small>'+moment(data.datos.fecha).format('lll')+'</small>'+
											'<ul class="actions">'+
												'<li data-toggle="tooltip" title="Eliminar respuesta"><i class="fa fa-times eliminar-respuesta"></i></li>'+
											'</ul>'+
											'<br>'+
											data.datos.respuesta+
										'</div>'+
									'</div>';
						element.find('.comentarios').append(html);
					}
					var comentarios = parseInt(toogle.attr('data-comentarios'));
					comentarios = comentarios+1;
					toogle.attr('data-comentarios',comentarios);
					toogle.text('Ver comentarios('+comentarios+')');
					swal(data.titulo, data.mensaje, "success");
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#datos').on('click','[data-toggle="collapse"]',function(){
			var element = $(this).parents('.post');
			if($(this).attr('data-open') == 0){
				if($(this).attr('data-comentarios') != 0){
					$.ajaxData({
						url: 'index.php/proyectos/get_respuestas',
						data:{id:$(this).attr('data-id')},
						method: 'post'
						},function(data){
							element.find('.load').hide();
							$.each(data.datos,function(index, value){
								var acciones = '';
								if(id_perfil == value.id_perfil){
									acciones = '<ul class="actions">'+
													'<li data-toggle="tooltip" title="Eliminar respuesta"><i class="fa fa-times eliminar-respuesta"></i></li>'+
												'</ul>';
								}
								var html = '<div class="media" data-id="'+value.id+'">'+
												'<div class="pull-left">'+
													'<figure class="avatar">'+
														'<img class="media-object" src="statics/img/profile-pics/'+value.avatar+'">'+
													'</figure>'+
												'</div>'+
												'<div class="media-body">'+
													'<strong>'+value.nombre+'</strong> <small>'+moment(value.fecha).format('lll')+'</small>'+acciones+'<br>'+
													value.respuesta+
												'</div>'+
											'</div>';
								element.find('.comentarios').append(html);
							});
							//$('[data-toggle="tooltip"]').tooltip();
						}
					);
				}else{
					element.find('.load').hide();
					element.find('.none-comments').show();
				}
				$(this).attr('data-open',1);
			}
		});
		$('#acciones-etapa > li').click(function(){
			var filtro = $(this).attr('data-filtro');
			$('#acciones-etapa > li').removeClass('active');
			$(this).addClass('active');
			$('#datos .post').show();
			if(filtro == 1){
				$('#datos .post').each(function(){
					if( $(this).attr('data-imagen') != 1){
						$(this).hide();
					}
				});
			}else if(filtro == 2){
				$('#datos .post').each(function(){
					if( $(this).attr('data-archivo') != 1){
						$(this).hide();
					}
				});
			}
		});
		$('#datos').on('click','.eliminar-comentario',function(){
			var element = $(this).parents('.post');
			var id = element.attr('data-id'),
			id_etapa = element.attr('data-id_etapa');
			swal({
				title: "¿Estas seguro de eliminar el comentario?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/proyectos/eliminar_comentario',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						element.remove();
						var count_c = 0, count_i = 0, count_a = 0;
						$('#datos .post').each(function(){
							count_c++;
							if($(this).attr('data-imagen') == 1){
								count_i++;
							} if($(this).attr('data-archivo') == 1){
								count_a++;
							}
						});
						if(count_c == 0){
							$('#none-comments').show();
						}
						$('#n-comentarios').text(count_c);
						$('#n-imagenes').text(count_i);
						$('#n-archivos').text(count_a);
						$('.etapa').each(function(){
							if($(this).attr('data-id') == id_etapa){
								$(this).find('.tmn-counts').text(count_c);
							}
						});
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		var edit_pre;
		$('#datos').on('click','.editar-comentario',function(){
			$('.dropdown.open').removeClass('open');
			$('span.comentario-contenido').show();
			$('form.edit-comment').remove();
			var element = $(this).parents('.post');
			edit_pre = element.find('span.comentario-contenido');
			var contenido = edit_pre.html()
			var html = '<form action="index.php/proyectos/editar_comentario" target="_self" method="post" class="edit-comment">'+
							'<div class="editor-comentario">'+contenido+'</div>'+
							'<textarea class="editar-contenido" name="contenido" style="display:none;">'+contenido+'</textarea>'+
							'<input type="hidden" name="id" value="'+element.attr('data-id')+'">'+
							'<div class="btns-editar-comentario">'+
								'<button type="button" class="btn bgm-gray waves-effect m-r-10 cancelar-edicion">Cancelar</button>'+
								'<button type="submit" class="btn btn-primary waves-effect">Guardar</button>'+
							'</div>'+
						'</form>';
			edit_pre.hide();
			edit_pre.after(html);
			$('.editor-contrato').summernote({
				lang: 'es-ES',
				disableDragAndDrop: true,
				placeholder: 'Aquí puedes escribir...',
				airMode: true,
			});
			$('.note-insert, .note-table, .note-para > button:nth-child(2), .note-font > button:nth-child(3), .note-color').hide();
			/*element.find('.editar-contenido').autogrow({onInitialize: true});
			element.find('.editar-contenido').focus();*/
		});
		$('#datos').on('click','.cancelar-edicion',function(){
			edit_pre.show();
			$('.editor-comentario').summernote('destroy');
			$(this).parents('form').remove();
		});
		$('#datos').on('submit','form.edit-comment',function(event){
			event.preventDefault();
			var codigo = $('.editor-comentario').html();
			$('.editar-contenido').html(codigo);
			var pre = $(this).parents('.card-body').find('pre'),
				// contenido = $(this).find('.editar-contenido').html(),
				form = $(this);
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					edit_pre.html(codigo).show();
					$('.editor-comentario').summernote('destroy');
					form.remove();
					swal(data.titulo, data.mensaje, "success");
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#datos').on('click','.eliminar-respuesta',function(){
			var element = $(this).parents('.media');
			var parent = element.parents('.comentarios');
			var toogle = element.parents('.post').find('[data-toggle="collapse"]');
			var id = element.attr('data-id');
			swal({
				title: "¿Estas seguro de eliminar la respuesta?",
				text: "Solo se eliminara esa respuesta",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/proyectos/eliminar_respuesta',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						var comentarios = parseInt(toogle.attr('data-comentarios'));
						comentarios = comentarios-1;
						toogle.attr('data-comentarios',comentarios);
						toogle.text('Ver comentarios('+comentarios+')');
						element.remove();
						if(comentarios == 0){
							parent.find('.none-comments').show();
						}
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','#datos .card-body figure img',function(){
			$('#modal-imagen img').attr('src', $(this).attr('src'));
			$('#modal-imagen').modal('show');
		});
	});


	$.section('#section-proyectos-archivados',function(){
		$.extend($.expr[":"],{
			"contains-ci": function(elem, i, match, array) {
				return ($(elem).attr('data-nombre') || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
			}
		});
		$('#ordenar').change(function(){
			var opcion = $(this).val();
			$('#alert-no-results').hide();
			$('#proyectos > .proyecto').show();
			$('span.lider').remove();
			if(opcion == 0){
				$('#proyectos > .proyecto').sort(function(a, b) {
					var compA = $(a).attr('data-id');
					var compB = $(b).attr('data-id');
					return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
				}).each(function() {
					$('#proyectos').append(this);
				});
			}else if(opcion == 1){
				$('#proyectos > .proyecto').sort(function(a, b) {
					var compA = $(a).attr('data-nombre').toUpperCase();
					var compB = $(b).attr('data-nombre').toUpperCase();
					return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
				}).each(function() {
					$('#proyectos').append(this);
				});
			}else if(opcion == 2){
				$('#proyectos > .proyecto').sort(function(a, b) {
					var compA = $(a).attr('data-nombre').toUpperCase();
					var compB = $(b).attr('data-nombre').toUpperCase();
					return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
				}).each(function() {
					$('#proyectos').prepend(this);
				});
			}else if(opcion == 3){
				$('#proyectos > .proyecto').sort(function(a,b){
					return new Date($(a).attr("data-creado")) > new Date($(b).attr("data-creado"));
				}).each(function(){
					$('#proyectos').prepend(this);
				});
			}else if(opcion == 4){
				$('#proyectos > .proyecto').sort(function(a,b){
					return new Date($(a).attr("data-creado")) < new Date($(b).attr("data-creado"));
				}).each(function(){
					$('#proyectos').prepend(this);
				});
			}else if(opcion == 5){
				$('#proyectos > .proyecto').sort(function(a, b) {
					var compA = $(a).attr('data-lider').toUpperCase();
					var compB = $(b).attr('data-lider').toUpperCase();
					return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
				}).each(function() {
					$('#proyectos').append(this);
				});
				var new_lider = '';
				$('#proyectos > .proyecto').each(function(){
					var lider = $(this).attr('data-lider');
					if(new_lider != lider){
						$(this).before('<span class="col-sm-12 lider"><h4><i class="fa fa-user"></i> '+lider+'</h4></span>');
						new_lider = lider;
					}
				});
			}else if(opcion == 6){
				$('#proyectos > .proyecto').each(function(){
					if($(this).attr('data-estado') != 1){
						$(this).hide();
					}
				});
			}else if(opcion == 7){
				$('#proyectos > .proyecto').each(function(){
					if($(this).attr('data-estado') != 2){
						$(this).hide();
					}
				});
			}else if(opcion == 8){
				$('#proyectos > .proyecto').each(function(){
					if($(this).attr('data-estado') != 0){
						$(this).hide();
					}
				});
			}
			var count = 0;
			$('#proyectos > .proyecto').each(function(){
				if($(this).is(':visible')){
					count++;
				}
			});
			if(count == 0){
				$('#alert-no-results').show();
			}
		});
		$('#busqueda').keyup(function(){
			if( $(this).val() != ""){
				$('#proyectos > .proyecto').hide();
				$('#proyectos > .proyecto:contains-ci("'+$(this).val()+'")').show();
			}else{
				$('#proyectos > .proyecto').show();
			}
		});
		$('#proyectos > .proyecto').on('click','.archivar',function(){
			var element = $(this).parents('.proyecto');
			var id = element.attr('data-id');
			swal({
				title: "¿Estas seguro de des-archivar el proyecto?",
				text: "Al des-archivar un proyecto su estado pasara como activo",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, des-archivar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/proyectos/desarchivar_proyecto',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						element.remove();
						if($('#proyectos > .proyecto').length == 0){
							$('#alert-no-proyectos').show();
						}
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$('#proyectos > .proyecto').on('click','.eliminar',function(){
			var element = $(this).parents('.proyecto');
			var id = element.attr('data-id');
			swal({
				title: "¿Estas seguro de eliminar el proyecto?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/proyectos/eliminar_proyecto',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						element.remove();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
	});

	$.section('#section-detalle-archivados',function(){
		$(window).scroll(function(){
			var $cache = $('.nav-detalle');
			if ($(window).scrollTop() > 350)
				$cache.css({
					'position': 'fixed',
					'top': '70px'
				});
			else
				$cache.css({
					'position': 'relative',
					'top': 'auto'
				});
		});

		$('.etapa').click(function(){
			$('.etapa').removeClass('active');
			$(this).addClass('active');
			$('#comments').show();
			$('#none-comments').hide();
			$('#load').show();
			$('#acciones-etapa > li').removeClass('active');
			$('#acciones-etapa > li:first-child').addClass('active');
			$('.card.post').remove();
			var id = $(this).attr('data-id'),
			id_perfil = $('#id_perfil').val();
			$('#id_etapa').val(id);
			$('#nombre').html($(this).attr('data-nombre'));
			$.ajaxData({
					url: 'index.php/proyectos/get_comentarios',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						if(data.datos.length > 0){
							var count_c = 0,
								count_i = 0,
								count_a = 0;
							$.each(data.datos,function(index,value){
								var html = '',
									imagen = '',
									archivo = '';
								count_c++;
								if(value.imagen == '1'){
									imagen = '<figure class="preview">'+
												'<img src="'+value.url_imagen+'">'+
											'</figure>';
									count_i++;
								}else{
									imagen = '';
								}
								if(value.archivo == '1'){
									archivo = '<ul class="list-group file">'+
													'<li class="list-group-item">'+
														'<a href="'+value.url_archivo+'" target="_self"><i class="fa fa-file-o"></i> <span>'+value.nombre_archivo+'</span></a>'+
													'</li>'+
												'</ul>';
									count_a++;
								}else{
									archivo = '';
								}
								html = '<div class="card post m-b-10"'+
										'data-id="'+value.id+'"'+
										'data-imagen="'+value.imagen+'"'+
										'data-archivo="'+value.archivo+'">'+
											'<div class="card-header ch-alt p-10">'+
												'<div class="media">'+
													'<div class="pull-left">'+
														'<figure class="avatar">'+
															'<img class="media-object" src="statics/img/profile-pics/'+value.avatar+'" alt="">'+
														'</figure>'+
													'</div>'+
													'<div class="media-body">'+
														'<h4 class="media-heading">'+value.nombre+'</h4>'+
														'<small class="fecha-time">'+moment(value.fecha).format('lll')+'</small>'+
													'</div>'+
												'</div>'+
											'</div>'+
											'<div class="card-body p-l-5 p-r-5">'+
												'<pre>'+value.comentario+'</pre>'+imagen+archivo+
												'<ul class="clist action footer">'+
													'<li><a data-toggle="collapse" data-target="#comentarios-'+value.id+'" data-id="'+value.id+'" data-comentarios="'+value.respuestas+'" data-open="0">Ver comentarios('+value.respuestas+')</a></li>'+
												'</ul>'+
											'</div>'+
											'<div class="card-footer">'+
												'<div class="comentarios collapse p-5" id="comentarios-'+value.id+'">'+
													'<div class="centered load">'+
														'<i class="fa fa-spin fa-2x fa-spinner"></i>'+
													'</div>'+
													'<div class="centered none-comments" style="display:none;">'+
														'<h4>No hay comentarios</h4>'+
													'</div>'+
												'</div>'+
											'</div>'+
										'</div>';
								$('#datos').append(html);
							});
							$('#n-comentarios').text(count_c);
							$('#n-imagenes').text(count_i);
							$('#n-archivos').text(count_a);
						}else{
							$('#n-comentarios').text('0');
							$('#n-imagenes').text('0');
							$('#n-archivos').text('0');
							$('#none-comments').show();
						}
						$('#load').hide();
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				}
			);
		});
		$('.etapa.first').click().addClass('active');
		$('#datos').on('click','[data-toggle="collapse"]',function(){
			var element = $(this).parents('.post');
			if($(this).attr('data-open') == 0){
				if($(this).attr('data-comentarios') != 0){
					$.ajaxData({
						url: 'index.php/proyectos/get_respuestas',
						data:{id:$(this).attr('data-id')},
						method: 'post'
						},function(data){
							element.find('.load').hide();
							$.each(data.datos,function(index, value){
								var html = '<div class="media">'+
												'<div class="pull-left">'+
													'<figure class="avatar">'+
														'<img class="media-object" src="statics/img/profile-pics/'+value.avatar+'">'+
													'</figure>'+
												'</div>'+
												'<div class="media-body">'+
													'<strong>'+value.nombre+'</strong> <small>'+moment(value.fecha).format('lll')+'</small><br>'+
													value.respuesta+
												'</div>'+
											'</div>';
								element.find('.comentarios').append(html);
							});
						}
					);
				}else{
					element.find('.load').hide();
					element.find('.none-comments').show();
				}
				$(this).attr('data-open',1);
			}
		});

		$('#acciones-etapa > li').click(function(){
			var filtro = $(this).attr('data-filtro');
			$('#acciones-etapa > li').removeClass('active');
			$(this).addClass('active');
			$('#datos .post').show();
			if(filtro == 1){
				$('#datos .post').each(function(){
					if( $(this).attr('data-imagen') != 1){
						$(this).hide();
					}
				});
			}else if(filtro == 2){
				$('#datos .post').each(function(){
					if( $(this).attr('data-archivo') != 1){
						$(this).hide();
					}
				});
			}
		});
	});
});