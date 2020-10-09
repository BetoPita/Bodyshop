$(document).ready(function(){
	$.section('#index',function(){
		$('select.colorpicker').simplecolorpicker({picker: true, theme: 'glyphicons'});
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		var cId = $('#calendar');
		cId.fullCalendar({
			header: {
				right: '',
				center: 'prev, title, next',
				left: ''
			},
			theme: true,
			selectable: false,
			selectHelper: true,
			editable: false,
			eventLimit: false,
			contentHeight: 400,
			lang: 'es',
			eventClick: function(calEvent, jsEvent, view) {
				$.ajaxData({
					url: 'index.php/equipo/obtener_tarea',
					data:{id:calEvent.id},
					method: 'post'
				},function(data){
					$('#tarea-perfil').text(data.nombre);
					$('#tarea-fecha').text(moment(data.fecha).format('ll'));
					$('#tarea-nombre').text(data.titulo);
					$('#tarea-desc').text(data.contenido);
					$('#modal-detalle-tarea').modal('show');
				});
			}
		});
		$('#form-indicadores').submit(function(event){
			event.preventDefault();
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					swal({
						title: data.titulo,
						text: data.mensaje,
						type: "success",
						showCancelButton: false,
						cancelButtonText: "Cancelar",
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Ok",
						closeOnConfirm: false
					}, function(){
						location.reload();
					});
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#modal-permisos').on('show.bs.modal',function(){
			$('#form-permisos input').each(function(){
				if($(this).attr('data-permiso') == 1){
					$(this).prop('checked',true);
				}
			})
		});
		$('#form-permisos').submit(function(event){
			event.preventDefault();
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					swal(data.titulo, data.mensaje, "success");
					$('#form-permisos input').each(function(){
						if($(this).is(':checked')){
							$(this).attr('data-permiso','1');
						}else{
							$(this).attr('data-permiso','0');
						}
					});
					$('#modal-permisos').modal('hide');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});

		$.ajaxData({
			url: 'index.php/equipo/obtener_tareas',
			data:{},
			method: 'post'
		},function(data){
			cId.fullCalendar('removeEvents');
			cId.fullCalendar('addEventSource', data);
		});
	});
	$.section('#integrante',function(){
		$('#modal-nueva-tarea').on('show.bs.modal',function(){
			$('#id_perfil').val($('#id_perfil_integrante').val());
		});
		$('#form-nueva-tarea').submit(function(event){
			event.preventDefault();
			var nombre = $.requerido('#nombre'),
				fecha = $.requerido('#fecha');
			if(nombre && fecha){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('#modal-nueva-tarea').modal('hide');
						var tr = '<tr>'+
									'<td>'+data.datos.nombre+'</td>'+
									'<td class="fecha">'+moment(data.datos.fecha).format('ll')+'</td>'+
									'<td>'+data.datos.contenido+'</td>'+
									'<td>'+
										'<ul class="actions" data-id="'+data.datos.id+'">'+
											'<li data-toggle="tooltip" title="Completada"><i class="fa fa-check"></i></li>'+
											'<li data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash"></i></li>'+
										'</ul>'+
									'</td>'+
								'</tr>';
						$('tbody').append(tr)
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','.fa-check',function(){
			var id = $(this).closest('ul').data('id');
			var element = $(this).closest('tr');
			swal({
				title: "¿Marcar tarea como completada?",
				text: "",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/equipo/completar_tarea',
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
		$(document).on('click','.fa-trash',function(){
			var id = $(this).closest('ul').data('id');
			var element = $(this).closest('tr');
			swal({
				title: "¿Eliminar la tarea?",
				text: "",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/equipo/eliminar_tarea',
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
		})
	});
});