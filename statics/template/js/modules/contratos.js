$(document).ready(function(){
	$.extend( $.fn.dataTable.defaults, {
		"language":{
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			    "sFirst":    "Primero",
			    "sLast":     "Último",
			    "sNext":     "Siguiente",
			    "sPrevious": "Anterior"
			},
			"oAria": {
			    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		"ordering": true,
		"bFilter": true,
		"paging": true,
		"sDom": '<"top"<"pull-left"f>>t<"bottom centered"p><"clear">'
    });
	$.section('#v-contratos',function(){
		var tabla_contratos  = $('#tabla-contratos').DataTable();
		$('#tabla-contratos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
		$('#tabla-contratos').parents('.table-responsive').find('select, input').addClass('form-control');
		tabla_contratos.on('draw',function(){
			$('#tabla-contratos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
			$('#tabla-contratos').parents('.table-responsive').find('.paginate_button.current').addClass('disabled');
		});
		$('.card-body').find('input').addClass('form-control');
		$('.card-body').find('select').addClass('form-control');
		$('table').on('click','.btn-reenviar',function(){
			var id = $(this).attr('data-id');
			$.ajax({
				url: 'index.php/contratos/reenviar',
				type: 'post',
				data: {id:id},
				async: true,
				dataType: 'json',
				success: function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				}
			});
		});
		$('table').on('click','.btn-editar',function(){
			var id = $(this).attr('data-id');
			window.location.href = 'index.php/contratos/edita/'+id;
		});
		$('table').on('click','.btn-aprobar',function(){
			var id = $(this).attr('data-id');
			window.location.href = 'index.php/contratos/aprobar/'+id;
		});
		$('table').on('click','.btn-eliminar',function(){
			var id = $(this).attr('data-id'),
				element = $(this).closest('tr');
			swal({
				title: "¿Estas seguro de eliminar el contrato?",
				text: "",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/contratos/eliminar',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						tabla_contratos.row(element).remove().draw();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$('table').on('click','.btn-descargar',function(){
			var id = $(this).attr('data-id');
		});
		$('table').on('click','.btn-reenviar-aprobacion',function(){
			var id = $(this).attr('data-id');
			$.ajax({
				url: 'index.php/contratos/reenviar_aprobacion',
				type: 'post',
				data: {id:id},
				async: true,
				dataType: 'json',
				success: function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				}
			});
		});
	});
	$.section('#v-contratos-archivados',function(){
		var tabla_contratos  = $('#tabla-contratos').DataTable();
		$('#tabla-contratos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
		$('#tabla-contratos').parents('.table-responsive').find('select, input').addClass('form-control');
		tabla_contratos.on('draw',function(){
			$('#tabla-contratos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
			$('#tabla-contratos').parents('.table-responsive').find('.paginate_button.current').addClass('disabled');
		});
		$('table').on('click','.btn-download',function(){
			var form = $('#form-contrato');
			$('#id-contrato').val($(this).attr('data-id'));
			form.attr('action','index.php/contratos/genera_pdf');
			form.submit();
		});
		$('table').on('click','.btn-preview',function(){
			var form = $('#form-contrato');
			$('#id-contrato').val($(this).attr('data-id'));
			form.attr('action','index.php/contratos/vista_previa');
			form.submit();
		});
		$('table').on('click','.btn-delete',function(){
			var id = $(this).attr('data-id'),
				element = $(this).closest('tr');
			swal({
				title: "¿Estas seguro de eliminar el contrato?",
				text: "",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/contratos/eliminar',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						tabla_contratos.row(element).remove().draw();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
	});
	$.section('#v-nuevo-contrato',function(){
		$('input[name="remitente"]').change(function(){
			if($(this).val() == 3){
				$('#remitente-externo').show();
			}else{
				$('#remitente-externo').hide();
			}
		});
		$('#preview').click(function(){
			var form = $('#form-contrato')
				contrato = $.requerido('#nombre'),
				nombre = $.requerido('#nombre_destinatario'),
				correo = $.requerido('#correo_destinatario'),
				nombre2 = $.requerido('#nombre_remitente'),
				correo2 = $.requerido('#correo_remitente');
			$('#contenido').html($('.html-editor-airmod').html());
			form.attr('action','index.php/contratos/preview');
			form.attr('target','_blank');
			if(contrato && nombre && correo && nombre2 && correo2){
				form.submit();
			}
		});
		$('#save').click(function(){
			//event.preventDefault();
			var form = $('#form-contrato'),
				contrato = $.requerido('#nombre'),
				nombre = $.requerido('#nombre_destinatario'),
				correo = $.requerido('#correo_destinatario'),
				nombre2 = $.requerido('#nombre_remitente'),
				correo2 = $.requerido('#correo_remitente');
			$('#contenido').html($('.html-editor-airmod').html());
			form.attr('action','index.php/contratos/guarda_contrato');
			form.attr('target','_self');
			if(contrato && nombre && correo && nombre2 && correo2){
				$.ajaxSerialize($('#form-contrato'),function(data){
					if(data.resp){
						swal({
							title: data.titulo,
							text: data.mensaje,
							type: "success",
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "OK",
							closeOnConfirm: true
						}, function(){
							window.location.href = 'index.php/contratos';
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}else{
				$("html, body").animate({scrollTop: 0}, "slow");
			}
		});
	});
	$.section('#v-edita-contrato',function(){
		$('#edit').click(function(){
			$(this).hide();
			$('#acept').hide();
			$('.contenedor-texto').removeClass('view');
			$('.element-editor').show();
			$('#editor').summernote({
				lang: 'es-ES',
				disableDragAndDrop: true,
				airMode: true,
			});
		});
		$('#cancel').click(function(){
			location.reload();
		});
		$('#save').click(function(event){
			$('#contenido').html($('.editor-contrato').html());
			var form = $('#form-contrato');
			form.attr('action','index.php/contratos/edita_contrato');
			$.ajaxSerialize(form,function(data){
				if(data.resp){
					swal({
						title: data.titulo,
						text: data.mensaje,
						type: "success",
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "OK",
						closeOnConfirm: true
					}, function(){
						window.location.href = 'index.php/contratos';
					});
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#acept').click(function(event){
			var form = $('#form-contrato');
			form.attr('action','index.php/contratos/aceptar_contrato');
			$.ajaxSerialize(form,function(data){
				if(data.resp){
					swal({
						title: data.titulo,
						text: data.mensaje,
						type: "success",
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "OK",
						closeOnConfirm: true
					}, function(){
						window.location.href = 'index.php/contratos';
					});
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
	});
	$.section('#v-aprobar-contrato',function(){
		$('#signature').jSignature();
		var $sigdiv = $('#signature');
		var datapair = $sigdiv.jSignature('getData', 'svgbase64');
		var bandera = false;

		$('#signature').bind('change', function(e) {
			var data = $('#signature').jSignature('getData');
			$("#hk").attr('src',data);
			bandera = true;
		});
		$('#reset').click(function(e){
			$('#signature').jSignature('clear');
			var data = $('#signature').jSignature('getData');
			$("#hk").attr('src',data);
			bandera = false;
			e.preventDefault();
		});
		$('#save').click(function(event){
			var form = $('#form-contrato');
			form.attr('action','index.php/contratos/aprobar_contrato');
			if(bandera){
				$('#firma').val($('#hk').attr('src'));
				$.ajaxSerialize(form,function(data){
					if(data.resp){
						swal({
							title: data.titulo,
							text: data.mensaje,
							type: "success",
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "OK",
							closeOnConfirm: true
						}, function(){
							window.location.href = 'index.php/contratos';
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
	});
});