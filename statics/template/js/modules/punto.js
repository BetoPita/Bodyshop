$(document).ready(function(){
	$.section('#section-categorias',function(){
		$('#form-nueva-categoria').submit(function(event){
			event.preventDefault();
			var bandera = true,
				nombre = $('#nombre');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(bandera){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						html = '<tr>'+
									'<td>'+data.datos.nombre+'</td>'+
									'<td>0</td>'+
									'<td>'+
										'<ul class="actions" data-id="'+data.datos.id+'">'+
											'<li data-toggle="tooltip" title="Editar">'+
												'<i class="fa fa-edit editar-categoria"></i>'+
											'</li>'+
											'<li data-toggle="tooltip" title="Eliminar">'+
												'<i class="fa fa-trash eliminar-categoria"></i>'+
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
		$(document).on('click','.eliminar-categoria',function(){
			var element = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			swal({
				title: "¿Estas seguro de eliminar la categoría?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/punto/eliminar_categoria',
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
		var element_edit;
		$(document).on('click','.editar-categoria',function(){
			element_edit = $(this).parents('tr');
			$('#e-id').val($(this).parents('ul').data('id'));
			$('#e-nombre').val($(this).parents('tr').find('td:first-child').text());
			$('#e-nombre').closest('.fg-line').addClass('fg-toggled');
			$('#modal-editar').modal('show');
		});
		$('#form-editar-categoria').submit(function(event){
			event.preventDefault();
			var bandera = true,
				nombre = $('#e-nombre');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(bandera){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						element_edit.find('td:first-child').text($('#e-nombre').val());
						$('#modal-editar').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
	});
	$.section('#section-productos',function(){
		var table = $('#productos').DataTable({
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
			"ordering": false,
			"bFilter": true,
			"paging": true,
			"sDom": '<"top"<"pull-left"f>>t<"bottom centered"p><"clear">'
		});
		$('select, input').addClass('form-control');
		$('.paginate_button').addClass('btn btn-primary');
		table.on( 'draw', function () {
			$('.paginate_button').addClass('btn btn-primary');
			$('.paginate_button.current').addClass('disabled');
		});
		$('#imagen').change(function(){
			if(this.files && this.files[0]) {
				if(this.files[0].size < 2*1048576){
					var reader = new FileReader();
					reader.onload = function (e) {
						$('#img-preview > img').attr('src', e.target.result).show();
						$('#img-preview > i').show();
					}
					reader.readAsDataURL(this.files[0]);
				}else{
					$("#imagen").val('');
					swal('Imagen muy grande', 'La imagen no debe de ser mayor a 2 MB', "warning");
				}
			}
		});
		$('#eliminar-imagen').click(function(){
			$('#img-preview > img').hide();
			$('#img-preview > i').hide();
			$("#imagen").val('');
		});
		$('#categoria').change(function(){
			if($(this).val() != ''){
				$(this).closest('.form-group').removeClass('has-error');
			}
		})
		$('#form-nuevo-producto').submit(function(event){
			event.preventDefault();
			var bandera = true,
				nombre = $('#nombre'),
				categoria = $('#categoria'),
				compra = $('#compra'),
				venta = $('#venta');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}if(categoria.val().trim() == ''){
				categoria.closest('.form-group').addClass('has-error');
				bandera = false;
			}if(compra.val().trim() == ''){
				compra.closest('.form-group').addClass('has-error');
				bandera = false;
			}if(venta.val().trim() == ''){
				venta.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(bandera){
				$.ajaxFormData($(this),function(data){
					if(data.resp){
						table.row.add([
							data.datos.nombre,
							data.datos.categoria,
							data.datos.compra,
							data.datos.venta,
							'<ul class="actions" data-id="'+data.datos.id+'">'+
								'<li data-toggle="tooltip" title="Editar">'+
									'<i class="fa fa-edit editar-producto"></i>'+
								'</li>'+
								'<li data-toggle="tooltip" title="Eliminar">'+
									'<i class="fa fa-trash eliminar-producto"></i>'+
								'</li>'+
							'</ul>'
						]).draw();
						$('#modal-agregar').modal('hide');
						$('[data-toggle="tooltip"]').tooltip();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('#modal-agregar').on('show.bs.modal',function(){
			$('#compra').closest('.fg-line').addClass('fg-toggled');
			$('#compra').val('0.00');
			$('#venta').closest('.fg-line').addClass('fg-toggled');
			$('#venta').val('0.00');
		});
		$(document).on('click','.eliminar-producto',function(){
			var element = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			swal({
				title: "¿Estas seguro de eliminar el producto?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/punto/eliminar_producto',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						table.row(element).remove().draw();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		var element_edit;
		$(document).on('click','.editar-producto',function(){
			element_edit = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			$.ajaxData({
				url: 'index.php/punto/obtener_producto',
				data:{id:id},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#e-id').val(data.datos.id);
					$('#e-nombre').val(data.datos.nombre);
					$('#e-compra').val(data.datos.compra);
					$('#e-venta').val(data.datos.venta);
					$('#e-descripcion').val(data.datos.descripcion);
					$('#form-editar-producto input').each(function(){
						if($(this).val() != ''){
							$(this).closest('.fg-line').addClass('fg-toggled');
						}
					});
					$('#e-categoria option[value="'+data.datos.id_categoria+'"]').prop('selected',true);
					$('#e-img-preview img').attr('src',data.datos.imagen).show();
					$('#e-img-preview > i').show();
					$('#modal-editar').modal('show');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#e-imagen').change(function(){
			if(this.files && this.files[0]) {
				if(this.files[0].size < 2*1048576){
					var reader = new FileReader();
					reader.onload = function (e) {
						$('#e-elimina-original').val('true');
						$('#e-img-preview > img').attr('src', e.target.result).show();
						$('#e-img-preview > i').show();
					}
					reader.readAsDataURL(this.files[0]);
				}else{
					$("#imagen").val('');
					swal('Imagen muy grande', 'La imagen no debe de ser mayor a 2 MB', "warning");
				}
			}
		});
		$('#e-eliminar-imagen').click(function(){
			$('#e-elimina-original').val('true');
			$('#e-img-preview > img').hide();
			$('#e-img-preview > i').hide();
			$("#e-imagen").val('');
		});
		$('#form-editar-producto').submit(function(event){
			event.preventDefault();
			var bandera = true,
				nombre = $('#e-nombre'),
				categoria = $('#e-categoria'),
				compra = $('#e-compra'),
				venta = $('#e-venta');
			if(nombre.val().trim() == ''){
				nombre.closest('.form-group').addClass('has-error');
				bandera = false;
			}if(categoria.val().trim() == ''){
				categoria.closest('.form-group').addClass('has-error');
				bandera = false;
			}if(compra.val().trim() == ''){
				compra.closest('.form-group').addClass('has-error');
				bandera = false;
			}if(venta.val().trim() == ''){
				venta.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(bandera){
				$.ajaxFormData($(this),function(data){
					if(data.resp){
						element_edit.find('td:nth-child(1)').text(data.datos.nombre);
						element_edit.find('td:nth-child(2)').text(data.datos.categoria);
						element_edit.find('td:nth-child(3)').text(data.datos.compra);
						element_edit.find('td:nth-child(4)').text(data.datos.venta);
						table.draw();
						$('#modal-editar').modal('hide');
						$('[data-toggle="tooltip"]').tooltip();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('#modal-editar').on('hide.bs.modal',function(){
			$('#e-elimina-original').val('false');
			$('#e-img-preview > img').show();
			$('#e-img-preview > i').show();
		});
	});
	$.section('#section-index',function(){
		$('.numero-decimales').each(function(){
			var num = parseFloat($(this).text())
			$(this).text(num.toFixed(2));
		});
		$.extend($.expr[":"],{
			"contains-ci": function(elem, i, match, array) {
				return ($(elem).find('.thumbnail').attr('data-nombre') || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
			}
		});
		$('#panel-flotante').click(function(){
			$(this).hide();
			$(this).parents('.panel').addClass('flotante');
			$('#panel-fijo').show();
		});
		$('#panel-fijo').click(function(){
			$(this).hide();
			$(this).parents('.panel').removeClass('flotante');
			$('#panel-flotante').show();
		});
		$('#select-categoria').change(function(){
			var categoria = $(this).val();
			$('#productos > .producto').show();
			if(categoria > 0){
				$('#productos > .producto').each(function(){
					if($(this).find('.thumbnail').data('categoria') != categoria){
						$(this).hide();
					}
				});
			}
		});
		$('#buscar').keyup(function(){
			$('#select-categoria option[value="0"]').prop('selected',true);
			if( $(this).val() != ""){
				$('#productos > .producto').hide();
				$('#productos > .producto:contains-ci("'+$(this).val()+'")').show();
			}else{
				$('#productos > .producto').show();
			}
		});
		$(document).on('click','.agregar-producto',function(){
			var element = $(this).parents('.thumbnail');
			var id = element.data('id'),
				nombre = element.data('nombre'),
				compra = element.data('compra'),
				venta = element.data('venta'),
				cantidad = element.find('.touchspin').val();
			var total = parseFloat(venta) * parseFloat(cantidad);
			var template = Handlebars.compile($('#plantilla-producto-venta').html());
			var html = template({nombre:nombre,cantidad:cantidad,compra:compra,venta:parseFloat(venta).toFixed(2),total:total.toFixed(2)});
			element.find('.touchspin').val('1');
			$('#productos-venta').append(html);
			$('[data-toggle="tooltip"]').tooltip();
			$('.panel-body').animate({ scrollTop: $('.panel-body').height() }, 1000);
			$.actualizaTotal();
		});
		$.actualizaTotal = function(){
			var total = 0;
			$('#productos-venta > tr').each(function(){
				total = parseFloat(total) + parseFloat($(this).data('total'));
			});
			$('#total-venta').text('$ '+total.toFixed(2));
			return total;
		}
		$(document).on('click','.elimina-producto-venta',function(){
			$(this).parents('tr').remove();
			$.actualizaTotal();
		});
		$('#realizar-venta').click(function(){
			var total = $.actualizaTotal()
			if(total == 0){
				swal({
					title: "No hay productos",
					text: "No se ha agregado ningun producto",
					type: "warning",
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "ok",
					closeOnConfirm: true
				});
			}else{
				var articulos = [];
				$('#productos-venta tr').each(function(){
					var articulo = {nombre:$(this).data('nombre'),
									compra:$(this).data('compra'),
									venta:$(this).data('venta'),
									cantidad:$(this).data('cantidad'),
									total:$(this).data('total')}
					articulos.push(articulo);
				});
				console.log(articulos);
				$.ajaxData({
					url: 'index.php/punto/agregar_venta',
					data:{total:total,articulos:articulos},
					method: 'post'
				},function(data){
					if(data.resp){
						$('#productos-venta > tr').remove();
						$('#total-venta').text('$ 0');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
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
	$.section('#section-ventas',function(){
		$('#total_en_ventas').text(parseFloat($('#total_en_ventas').text()).toFixed(2));
		$('#ganancias_en_ventas').text(parseFloat($('#ganancias_en_ventas').text()).toFixed(2));
		var table = $('#ventas').DataTable({
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
			"ordering": false,
			"bFilter": false,
			"paging": true,
			"sDom": 't<"bottom centered"p><"clear">'
		});
		$('#anio').datetimepicker({
			format: 'YYYY',
			viewMode: 'years'
		});
		$('#mes').datetimepicker({
			format: 'MMMM',
			viewMode: 'months'
		});
		$('select, input').addClass('form-control');
		$('.paginate_button').addClass('btn btn-primary');
		table.on( 'draw', function () {
			$('.paginate_button').addClass('btn btn-primary');
			$('.paginate_button.current').addClass('disabled');
		});
		$('#buscar').click(function(){
			var anio = $('#anio'),
				mes = $('#mes'),
				bandera =  true;
			if(anio.val().trim() == ''){
				anio.closest('.form-group').addClass('has-error');
				bandera = false;
			}
			if(bandera){
				$.ajaxData({
					url: 'index.php/punto/busqueda_ventas',
					data:{anio:anio.val(),mes:mes.val()},
					method: 'post'
				},function(data){
					var cabecera = 'Ventas de ';
					if(mes.val() != ''){
						cabecera += mes.val()+' de ';
					}
					cabecera += anio.val();
					$('#cabecera').text(cabecera);
					if(data.total_en_ventas == null){
						data.total_en_ventas = 0;
					}if(data.total_en_ventas_compra == null){
						data.total_en_ventas_compra = 0;
					}
					$('#total_de_ventas').text(data.total_de_ventas);
					$('#total_en_ventas').text(parseFloat(data.total_en_ventas).toFixed(2));
					$('#ganancias_en_ventas').text((parseFloat(data.total_en_ventas) - parseFloat(data.total_en_ventas_compra)).toFixed(2));
					table.clear();
					$.each(data.ventas,function(index,value){
						table.row.add([
							moment(value.fecha).format('lll'),
							value.articulos,
							value.total,
							'<ul class="actions" data-id="'+value.id+'">'+
								'<li data-toggle="tooltip" title="Detalle de la venta" class="detalle-venta">'+
									'<i class="fa fa-list"></i>'+
								'</li>'+
							'</ul>'
						]);
					});
					table.draw();
					$('[data-toggle="tooltip"]').tooltip();
				});
			}
		});
		$('#anio').click(function(){
			$(this).closest('.form-group').removeClass('has-error');
		});
		$(document).on('click','.detalle-venta',function(){
			var id = $(this).parents('ul').data('id');
			$.ajaxData({
				url: 'index.php/punto/detalle_venta',
				data:{id:id},
				method: 'post'
			},function(data){
				if(data.resp){
					data.venta.fecha = moment(data.venta.fecha).format('lll');
					var template = Handlebars.compile($('#plantilla-detalle-venta').html());
					var html = template({venta:data.venta,articulos:data.articulos,vendedor:data.vendedor});
					$('#modal-detalle .modal-body').html(html);
					$('#modal-detalle').modal('show');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
	});
});