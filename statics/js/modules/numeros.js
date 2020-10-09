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
	$.section('#tabs-section',function(){
		var tabs = [];
		tabs['1'] = {ajax:true,reload:true,url:'index.php/numeros/tablero',callback:crear_graficas};
		tabs['2'] = {ajax:true,reload:true,url:'index.php/numeros/gastos_fijos',callback:tab_gastos_fijos};
		tabs['3'] = {ajax:true,reload:false,url:'index.php/numeros/sueldos',callback:tab_sueldos};
		tabs['4'] = {ajax:false,reload:false,url:'index.php/numeros/',callback:''};
		tabs['5'] = {ajax:true,reload:false,url:'index.php/numeros/obtener_proveedores',callback:llena_proveedores};
		tabs['6'] = {ajax:false,reload:false,url:'index.php/numeros/',callback:''};
		tabs['7'] = {ajax:false,reload:false,url:'index.php/numeros/',callback:''};
		$('.tab-nav > li').click(function(){
			var tab = $(this).data('tab')
			if(tabs[tab].ajax){
				$.ajaxData({
					url: tabs[tab].url,
					data:{},
					method: 'post'
				},function(data){
					if(!tabs[tab].reload){
						tabs[tab].ajax = false;
					}
					if (tabs[tab].callback != "") {
						var call = $.Callbacks();
						call.add(tabs[tab].callback);
						call.fire(data);
					}
				});
			}
		});
		//-------Funciones de gastos fijos-------
		var tabla_gastos_fijos  = $('#tabla-gastos-fijos').DataTable();
		$('#tabla-gastos-fijos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
		$('#tabla-gastos-fijos').parents('.table-responsive').find('select, input').addClass('form-control');
		tabla_gastos_fijos.on('draw',function(){
			$('#tabla-gastos-fijos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
			$('#tabla-gastos-fijos').parents('.table-responsive').find('.paginate_button.current').addClass('disabled');
		});
		function tab_gastos_fijos(data){
			tabla_gastos_fijos.clear();
			add_row_gasto_fijo(data.gastos);
			tabla_gastos_fijos.row.add([
				'Sueldos',
				parseFloat(data.sueldos).formatMoney(2, "$ ", ",", "."),
				'$ 0.00',
				parseFloat(data.sueldos).formatMoney(2, "$ ", ",", "."),
				''
			]);
			tabla_gastos_fijos.order([0,'asc']).draw();
			calcular_totales();
		}
		function add_row_gasto_fijo(data){
			$.each(data,function(index,value){
				var c_iva,
					c_importe;
				if(value.iva == 1){
					c_iva = parseFloat(value.importe) * parseFloat(0.16);
					c_importe = parseFloat(value.importe) - parseFloat(c_iva);
				}else{
					c_iva = parseFloat(0.00);
					c_importe = parseFloat(value.importe);
				}
				tabla_gastos_fijos.row.add([
					value.nombre,
					c_importe.formatMoney(2, "$ ", ",", "."),
					c_iva.formatMoney(2, "$ ", ",", "."),
					parseFloat(value.importe).formatMoney(2, "$ ", ",", "."),
					'<ul class="actions" data-id="'+value.id+'">'+
						'<li data-toggle="tooltip" title="Editar">'+
							'<i class="fa fa-edit editar-gasto-fijo"></i>'+
						'</li>'+
						'<li data-toggle="tooltip" title="Eliminar">'+
							'<i class="fa fa-trash eliminar-gasto-fijo"></i>'+
						'</li>'+
					'</ul>'
				]);
			});
			tabla_gastos_fijos.order([0,'asc']).draw();
			$('#tabla-gastos-fijos [data-toggle="tooltip"]').tooltip();
		}
		function calcular_totales(){
			var total_importe = parseFloat(0),
				total_iva = parseFloat(0),
				total_total = parseFloat(0);
			tabla_gastos_fijos.rows().every(function(rowIdx,tableLoop,rowLoop){
				var row = this.data();
				total_importe = total_importe + parseFloat(Number(row[1].replace(/[^0-9\.]+/g,"")));
				total_iva = total_iva + parseFloat(Number(row[2].replace(/[^0-9\.]+/g,"")));
				total_total = total_total + parseFloat(Number(row[3].replace(/[^0-9\.]+/g,"")));
			});
			$('#total-importe-gastos-fijos').text(total_importe.formatMoney(2, "$ ", ",", "."));
			$('#total-iva-gastos-fijos').text(total_iva.formatMoney(2, "$ ", ",", "."));
			$('#total-total-gastos-fijos').text(total_total.formatMoney(2, "$ ", ",", "."));
		}
		$('#form-agregar-gasto-fijo').submit(function(event){
			event.preventDefault();
			var bandera = true,
				nombre = $.requerido('#nombre-gasto-fijo'),
				importe = $.requerido('#importe-gasto-fijo');
			if(importe && nombre){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						add_row_gasto_fijo([data.datos]);
						calcular_totales();
						$('#modal-agregar-gasto-fijo').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','.eliminar-gasto-fijo',function(){
			var element = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			swal({
				title: "¿Estas seguro de eliminar el gasto fijo?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/numeros/eliminar_gasto_fijo',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						tabla_gastos_fijos.row(element).remove().draw();
						calcular_totales();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		var element_edit;
		$(document).on('click','.editar-gasto-fijo',function(){
			element_edit = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			$.ajaxData({
				url: 'index.php/numeros/obtener_gasto_fijo',
				data:{id:id},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#e-id-gasto-fijo').val(data.datos.id);
					$('#e-nombre-gasto-fijo').val(data.datos.nombre);
					$('#e-importe-gasto-fijo').val(data.datos.importe);
					$('#form-editar-gasto-fijo input').each(function(){
						if($(this).val() != ''){
							$(this).closest('.fg-line').addClass('fg-toggled');
						}
					});
					if(data.datos.iva == 1){
						$('#e-con-iva').prop('checked',true);
					}else{
						$('#e-sin-iva').prop('checked',true);
					}
					$('#modal-editar-gasto-fijo').modal('show');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#form-editar-gasto-fijo').submit(function(event){
			event.preventDefault();
			var bandera = true,
				nombre = $.requerido('#e-nombre-gasto-fijo'),
				importe = $.requerido('#e-importe-gasto-fijo');
			if(importe && nombre){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						tabla_gastos_fijos.row(element_edit).remove().draw();
						add_row_gasto_fijo([data.datos]);
						calcular_totales();
						$('#modal-editar-gasto-fijo').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		//-------Funciones de sueldos-------
		var tabla_sueldos  = $('#tabla-sueldos').DataTable();
		$('#tabla-sueldos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
		$('#tabla-sueldos').parents('.table-responsive').find('select, input').addClass('form-control');
		tabla_sueldos.on('draw',function(){
			$('#tabla-sueldos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
			$('#tabla-sueldos').parents('.table-responsive').find('.paginate_button.current').addClass('disabled');
		});
		function tab_sueldos(data){
			tabla_sueldos.clear();
			add_row_sueldos(data);
		}
		function add_row_sueldos(data){
			$.each(data,function(index,value){
				var tipo = '',
					prestaciones = 'No';
				if(value.prestaciones == 1){
					prestaciones = 'Si';
				}
				if(value.tipo == 1){
					tipo = 'Diario';
				}else if(value.tipo == 2){
					tipo = 'Semanal';
				}else if(value.tipo == 3){
					tipo = 'Quincenal';
				}else if(value.tipo == 4){
					tipo = 'Mensual';
				}

				tabla_sueldos.row.add([
					value.empleado,
					parseFloat(value.importe).formatMoney(2, "$ ", ",", "."),
					tipo,
					prestaciones,
					'<ul class="actions" data-id="'+value.id+'">'+
						'<li data-toggle="tooltip" title="Editar">'+
							'<i class="fa fa-edit editar-sueldo"></i>'+
						'</li>'+
						'<li data-toggle="tooltip" title="Eliminar">'+
							'<i class="fa fa-trash eliminar-sueldo"></i>'+
						'</li>'+
					'</ul>'
				]);
			});
			tabla_sueldos.order([0,'asc']).draw();
			$('#tabla-sueldos [data-toggle="tooltip"]').tooltip();
		}
		$('#ver-tipo-sueldo').change(function(){
			$('#pdf-sueldos').attr('data-link','index.php/numeros/reporte_sueldos/'+$(this).val());
			$.ajaxData({
				url: 'index.php/numeros/obtener_sueldo_tipo',
				data:{tipo:$(this).val()},
				method: 'post'
			},function(data){
				tabla_sueldos.clear();
				add_row_sueldos(data);
			});
		});
		$('#form-agregar-sueldo').submit(function(event){
			event.preventDefault();
			var bandera = true,
				nombre = $.requerido('#empleado-sueldo'),
				tipo = $.requerido('#tipo-sueldo'),
				importe = $.requerido('#importe-sueldo');
			if(importe && nombre && tipo){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						add_row_sueldos([data.datos]);
						$('#modal-agregar-sueldo').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','.eliminar-sueldo',function(){
			var element = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			swal({
				title: "¿Estas seguro de eliminar el empleado?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/numeros/eliminar_sueldo',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						tabla_sueldos.row(element).remove().draw();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		var sueldo_edit;
		$(document).on('click','.editar-sueldo',function(){
			sueldo_edit = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			$.ajaxData({
				url: 'index.php/numeros/obtener_sueldo',
				data:{id:id},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#modal-editar-sueldo').modal('show');
					$('#e-id-sueldo').val(data.datos.id);
					$('#e-empleado-sueldo').val(data.datos.empleado);
					$('#e-importe-sueldo').val(parseFloat(data.datos.importe).toFixed(2));
					$('#form-editar-sueldo input').each(function(){
						if($(this).val() != ''){
							$(this).closest('.fg-line').addClass('fg-toggled');
						}
					});
					$('#e-tipo-sueldo option[value="'+data.datos.tipo+'"]').prop('selected',true);
					$('#e-tipo-sueldo').closest('.fg-line').addClass('fg-toggled');
					if(data.datos.prestaciones == 1){
						$('#e-con-pres').prop('checked',true);
					}else{
						$('#e-sin-pres').prop('checked',true);
					}
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#form-editar-sueldo').submit(function(event){
			event.preventDefault();
			var nombre = $.requerido('#e-empleado-sueldo'),
				tipo = $.requerido('#e-tipo-sueldo'),
				importe = $.requerido('#e-importe-sueldo');
			if(importe && nombre && tipo){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						tabla_sueldos.row(element_edit).remove().draw();
						add_row_sueldos([data.datos]);
						$('#modal-editar-sueldo').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		//-------Funciones de Relacion de ventas-------
		$('#anio-venta').datetimepicker({
			format: 'YYYY',
			viewMode: 'years'
		});
		$('#mes-venta').datetimepicker({
			format: 'MMMM',
			viewMode: 'months'
		});
		$('#fecha-venta, #fecha-abono-venta, #e-fecha-venta').datetimepicker({
			format: 'DD/MM/YYYY',
			viewMode: 'days'
		});
		$('#anio-venta, #mes-venta, #fecha-venta, #fecha-abono-venta, #e-fecha-venta').click(function(){
			$(this).closest('.form-group').removeClass('has-error');
		});
		var tabla_ventas  = $('#tabla-ventas').DataTable();
		$('#tabla-ventas').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
		$('#tabla-ventas').parents('.table-responsive').find('select, input').addClass('form-control');
		tabla_ventas.on('draw',function(){
			$('#tabla-ventas').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
			$('#tabla-ventas').parents('.table-responsive').find('.paginate_button.current').addClass('disabled');
		});
		function add_row_ventas(data){
			$.each(data,function(index,value){
				var acciones = '',
					abonar = '';
				if(value.id_abono == null){
					if(parseFloat(value.vf_credito)+parseFloat(value.vp_credito) > 0){
						abonar = '<li data-toggle="tooltip" title="Abonar">'+
									'<i class="fa fa-plus-square abonar-venta"></i>'+
								'</li>';
					}
					acciones = '<ul class="actions" data-id="'+value.id+'">'+
									'<li data-toggle="tooltip" title="Detalle">'+
										'<i class="fa fa-bars detalle-venta"></i>'+
									'</li>'+
									abonar+
									'<li data-toggle="tooltip" title="Editar">'+
										'<i class="fa fa-edit editar-venta"></i>'+
									'</li>'+
									'<li data-toggle="tooltip" title="Eliminar">'+
										'<i class="fa fa-trash eliminar-venta"></i>'+
									'</li>'+
								'</ul>';
				}else{
					acciones = '<ul class="actions" data-id="'+value.id+'">'+
									'<li data-toggle="tooltip" title="Detalle">'+
										'<i class="fa fa-bars detalle-venta"></i>'+
									'</li>'+
									'<li data-toggle="tooltip" title="Eliminar">'+
										'<i class="fa fa-trash eliminar-venta"></i>'+
									'</li>'+
								'</ul>';
				}
				var total = parseFloat(value.vp_total) + parseFloat(value.vf_total);
				var total_cobrado = parseFloat(value.vp_efectivo) + parseFloat(value.vp_cheque) + parseFloat(value.vf_efectivo) + parseFloat(value.vf_cheque);
				var total_sin = parseFloat(value.vp_efectivo) + parseFloat(value.vp_cheque) +  parseFloat(value.vp_credito);
				var total_con = parseFloat(value.vf_efectivo) + parseFloat(value.vf_cheque) +  parseFloat(value.vf_credito);
				tabla_ventas.row.add([
					'<span style="display:none">'+moment(value.fecha).format('x')+'</span>'+moment(value.fecha).format('ll'),
					total_cobrado.formatMoney(2, "$ ", ",", "."),
					parseFloat(total_sin).formatMoney(2, "$ ", ",", "."),
					parseFloat(total_con).formatMoney(2, "$ ", ",", "."),
					parseFloat(value.sin_iva).formatMoney(2, "$ ", ",", "."),
					parseFloat(value.con_iva).formatMoney(2, "$ ", ",", "."),
					total_cobrado.formatMoney(2, "$ ", ",", "."),
					acciones
				]);
			});
			tabla_ventas.order([0,'asc']).draw();
			$('#tabla-ventas [data-toggle="tooltip"]').tooltip();
		}
		function calcular_totales_ventas(){
			var total_ventas = parseFloat(0),
				sin_factura = parseFloat(0),
				con_factura = parseFloat(0),
				sin_iva = parseFloat(0),
				con_iva = parseFloat(0),
				ingresos = parseFloat(0);
			tabla_ventas.rows().every(function(rowIdx,tableLoop,rowLoop){
				var row = this.data();
				total_ventas = total_ventas + parseFloat(Number(row[1].replace(/[^0-9\.]+/g,"")));
				sin_factura = sin_factura + parseFloat(Number(row[2].replace(/[^0-9\.]+/g,"")));
				con_factura = con_factura + parseFloat(Number(row[3].replace(/[^0-9\.]+/g,"")));
				sin_iva = sin_iva + parseFloat(Number(row[4].replace(/[^0-9\.]+/g,"")));
				con_iva = con_iva + parseFloat(Number(row[5].replace(/[^0-9\.]+/g,"")));
				ingresos = ingresos + parseFloat(Number(row[6].replace(/[^0-9\.]+/g,"")));
			});
			$('#total-ventas-venta').text(total_ventas.formatMoney(2, "$ ", ",", "."));
			$('#total-sin-venta').text(sin_factura.formatMoney(2, "$ ", ",", "."));
			$('#total-con-venta').text(con_factura.formatMoney(2, "$ ", ",", "."));
			$('#sin-iva-venta').text(sin_iva.formatMoney(2, "$ ", ",", "."));
			$('#con-iva-venta').text(con_iva.formatMoney(2, "$ ", ",", "."));
			$('#ingresos-venta').text(ingresos.formatMoney(2, "$ ", ",", "."));
		}
		var anio_selected = '',
			mes_selected = '';
		function llenar_tabla_ventas(){
			if(anio_selected != '' && mes_selected != ''){
				$.ajaxData({
					url: 'index.php/numeros/busqueda_ventas',
					data:{anio:anio_selected,mes:mes_selected},
					method: 'post'
				},function(data){
					tabla_ventas.clear().draw();
					add_row_ventas(data);
					calcular_totales_ventas();
				});
			}
		}
		$('#form-busqueda-venta').submit(function(event){
			event.preventDefault();
			var	anio = $.requerido('#anio-venta'),
				mes = $.requerido('#mes-venta');
			if(anio && mes ){
				anio_selected = $('#anio-venta').val();
				mes_selected = $('#mes-venta').val();
				$('#pdf-ventas').attr('data-link','index.php/numeros/reporte_ventas/'+anio_selected+'/'+mes_selected);
				$.ajaxSerialize($(this),function(data){
					$('#ventas-view').show();
					tabla_ventas.clear().draw();
					add_row_ventas(data);
					calcular_totales_ventas();
				});
			}
		});
		$('#form-agregar-venta').submit(function(event){
			event.preventDefault();
			var fecha = $.requerido('#fecha-venta'),
				concepto = $.requerido('#concepto-venta'),
				vp_efectivo = $.requerido('#efectivo-sin-factura'),
				vp_cheque = $.requerido('#cheque-sin-factura'),
				vp_credito = $.requerido('#credito-sin-factura'),
				vf_efectivo = $.requerido('#efectivo-con-factura'),
				vf_cheque = $.requerido('#cheque-con-factura'),
				vf_credito = $.requerido('#credito-con-factura'),
				facturado = parseFloat($('#efectivo-con-factura').val()) + parseFloat($('#cheque-con-factura').val()) + parseFloat($('#credito-con-factura').val());
				bandera_factura = true;
			if(facturado > 0.0){
				bandera_factura = $.requerido('#folio-factura-venta');
			}else{
				$('#folio-factura-venta').closest('.form-group').removeClass('has-error');
			}
			if(fecha && concepto && vp_efectivo && vp_cheque && vp_credito && vf_efectivo && vf_cheque && vf_credito && bandera_factura){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						llenar_tabla_ventas();
						$('#modal-agregar-venta').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','.detalle-venta',function(){
			var id = $(this).parents('ul').data('id');
			$.ajaxData({
				url: 'index.php/numeros/obtener_venta',
				data:{id:id},
				method: 'post'
			},function(data){
				$('#fecha-detalle-venta').text(moment(data.datos.fecha).format('ll'));
				$('#concepto-detalle-venta').text(data.datos.concepto);
				$('#efectivo-sin-detalle-venta').text(parseFloat(data.datos.vp_efectivo).formatMoney(2, "$ ", ",", "."));
				$('#efectivo-con-detalle-venta').text(parseFloat(data.datos.vf_efectivo).formatMoney(2, "$ ", ",", "."));
				$('#cheque-sin-detalle-venta').text(parseFloat(data.datos.vp_cheque).formatMoney(2, "$ ", ",", "."));
				$('#cheque-con-detalle-venta').text(parseFloat(data.datos.vf_cheque).formatMoney(2, "$ ", ",", "."));
				$('#credito-sin-detalle-venta').text(parseFloat(data.datos.vp_credito).formatMoney(2, "$ ", ",", "."));
				$('#credito-con-detalle-venta').text(parseFloat(data.datos.vf_credito).formatMoney(2, "$ ", ",", "."));
				$('#notas-detalle-venta').text(data.datos.notas);
				$('#folio-detalle-venta').text(data.datos.factura);
				$('#modal-detalle-venta').modal('show');
			});
		});
		$(document).on('click','.eliminar-venta',function(){
			var element = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			swal({
				title: "¿Estas seguro de eliminar la venta?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/numeros/eliminar_venta',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						llenar_tabla_ventas();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','.abonar-venta',function(){
			var id = $(this).parents('ul').data('id');
			$.ajaxData({
				url: 'index.php/numeros/obtener_venta',
				data:{id:id},
				method: 'post'
			},function(data){
				$('#concepto-abono-venta').val('Abono a: '+data.datos.concepto);
				$('#id-venta-abono').val(data.datos.id);
				$('#total-sin-venta-abono').val(data.datos.vp_credito);
				$('#total-con-venta-abono').val(data.datos.vf_credito);
				$('#total-credito-sin-abono').text(parseFloat(data.datos.vp_credito).toFixed(2));
				$('#total-credito-con-abono').text(parseFloat(data.datos.vf_credito).toFixed(2));
				$('#form-agregar-abono-venta input').each(function(){
						if($(this).val() != ''){
							$(this).closest('.fg-line').addClass('fg-toggled');
						}
					});
				$('#abono-sin-abono').trigger('touchspin.updatesettings',{max:data.datos.vp_credito});
				$('#abono-con-abono').trigger('touchspin.updatesettings',{max:data.datos.vf_credito});
				$('#modal-abonar-venta').modal('show');
			});
		});
		$('#form-agregar-abono-venta').submit(function(event){
			event.preventDefault();
			var fecha = $.requerido('#fecha-abono-venta');
			if(fecha && ($('#abono-sin-abono').val() > 0 || $('#abono-con-abono').val() > 0)){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						llenar_tabla_ventas();
						$('#modal-abonar-venta').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','.editar-venta',function(){
			var id = $(this).parents('ul').data('id');
			$.ajaxData({
				url: 'index.php/numeros/obtener_venta',
				data:{id:id},
				method: 'post'
			},function(data){
				$('#modal-editar-venta').modal('show');
				$('#e-fecha-venta').val(moment(data.datos.fecha).format('DD/MM/YYYY'));
				$('#e-concepto-venta').val(data.datos.concepto);
				$('#e-id-venta').val(data.datos.id);
				$('#e-efectivo-sin-factura').val(data.datos.vp_efectivo);
				$('#e-cheque-sin-factura').val(data.datos.vp_cheque);
				$('#e-credito-sin-factura').val(data.datos.vp_credito);
				$('#e-efectivo-con-factura').val(data.datos.vf_efectivo);
				$('#e-cheque-con-factura').val(data.datos.vf_cheque);
				$('#e-credito-con-factura').val(data.datos.vf_credito);
				$('#e-notas-venta').val(data.datos.notas);
				$('#e-folio-factura-venta').val(data.datos.factura);
				$('#e-factura-actual-venta').val(data.datos.factura);
				$('#form-editar-venta input').each(function(){
					if($(this).val() != ''){
						$(this).closest('.fg-line').addClass('fg-toggled');
					}
				});
			});
		});
		$('#form-editar-venta').submit(function(event){
			event.preventDefault();
			var fecha = $.requerido('#e-fecha-venta'),
				concepto = $.requerido('#e-concepto-venta'),
				vp_efectivo = $.requerido('#e-efectivo-sin-factura'),
				vp_cheque = $.requerido('#e-cheque-sin-factura'),
				vp_credito = $.requerido('#e-credito-sin-factura'),
				vf_efectivo = $.requerido('#e-efectivo-con-factura'),
				vf_cheque = $.requerido('#e-cheque-con-factura'),
				vf_credito = $.requerido('#e-credito-con-factura')
				facturado = parseFloat($('#efectivo-con-factura').val()) + parseFloat($('#cheque-con-factura').val()) + parseFloat($('#credito-con-factura').val());
				bandera_factura = true;
			if(facturado > 0.0){
				bandera_factura = $.requerido('#folio-factura-venta');
			}else{
				$('#folio-factura-venta').closest('.form-group').removeClass('has-error');
			}
			if(fecha && concepto && vp_efectivo && vp_cheque && vp_credito && vf_efectivo && vf_cheque && vf_credito && bandera_factura){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						llenar_tabla_ventas();
						$('#modal-editar-venta').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		//-------Funciones de Relacion de gastos-------
		$('#anio-gasto').datetimepicker({
			format: 'YYYY',
			viewMode: 'years'
		});
		$('#mes-gasto').datetimepicker({
			format: 'MMMM',
			viewMode: 'months'
		});
		$('#fecha-gasto, #e-fecha-gasto').datetimepicker({
			format: 'DD/MM/YYYY',
			viewMode: 'days'
		});
		$('#anio-gasto, #mes-gasto, #fecha-gasto, #e-fecha-gasto').click(function(){
			$(this).closest('.form-group').removeClass('has-error');
		});
		var tabla_gastos  = $('#tabla-gastos').DataTable();
		$('#tabla-gastos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
		$('#tabla-gastos').parents('.table-responsive').find('select, input').addClass('form-control');
		tabla_gastos.on('draw',function(){
			$('#tabla-gastos').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
			$('#tabla-gastos').parents('.table-responsive').find('.paginate_button.current').addClass('disabled');
		});
		$('#ir-proveedores').click(function(){
			$('#sec-gastos').hide();
			$('#sec-proveedores').show();
		});
		function llena_proveedores(data){
			$('#proveedor-gasto, #tabla-proveedores > tbody').empty();
			$('#proveedor-gasto, #e-proveedor-gasto').append('<option value="">Seleccionar proveedor</option>');
			$.each(data,function(index,value){
				var html = '<option value="'+value.id+'">'+value.nombre+'</option>';
				$('#proveedor-gasto, #e-proveedor-gasto').append(html);
			});
			agrega_proveedor_tabla(data);
		}
		function agregar_row_pago(data){
			$.each(data,function(index,value){
				var concepto = 'Pago de salarios ';
				if(value.tipo == 1){
					concepto += 'diarios';
				}if(value.tipo == 2){
					concepto += 'semanales';
				}if(value.tipo == 3){
					concepto += 'quincenales';
				}if(value.tipo == 4){
					concepto += 'mensuales';
				}
				tabla_gastos.row.add([
					'<span style="display:none">'+moment(value.fecha).format('x')+'</span>'+moment(value.fecha).format('ll'),
					concepto,
					'',
					parseFloat(value.importe).formatMoney(2, "$ ", ",", "."),
					'$ 0.00',
					parseFloat(value.importe).formatMoney(2, "$ ", ",", "."),
					'Compra',
					'<ul class="actions" data-id="'+value.id+'">'+
						'<li data-toggle="tooltip" title="Eliminar">'+
							'<i class="fa fa-trash eliminar-pago-nomina"></i>'+
						'</li>'+
					'</ul>'
				]);
			});
			tabla_gastos.order([0,'asc']).draw();
			$('#tabla-gastos [data-toggle="tooltip"]').tooltip();
		}
		function agregar_row_gasto(data){
			$.each(data,function(index,value){
				var concepto = '',
					tipo = '';
				if(value.tipo == 1){
					concepto = 'Pago a '+value.nombre;
					tipo = 'Gasto';
				}if(value.tipo == 2){
					concepto = 'Compra a '+value.nombre;
					tipo = 'Compra';
				}
				tabla_gastos.row.add([
					'<span style="display:none">'+moment(value.fecha).format('x')+'</span>'+moment(value.fecha).format('ll'),
					concepto,
					value.rfc,
					parseFloat(value.importe).formatMoney(2, "$ ", ",", "."),
					parseFloat(value.iva).formatMoney(2, "$ ", ",", "."),
					parseFloat(value.total).formatMoney(2, "$ ", ",", "."),
					tipo,
					'<ul class="actions" data-id="'+value.id+'">'+
						'<li data-toggle="tooltip" title="Editar">'+
							'<i class="fa fa-edit editar-gasto"></i>'+
						'</li>'+
						'<li data-toggle="tooltip" title="Eliminar">'+
							'<i class="fa fa-trash eliminar-gasto"></i>'+
						'</li>'+
					'</ul>'
				]);
			});
			tabla_gastos.order([0,'asc']).draw();
			$('#tabla-gastos [data-toggle="tooltip"]').tooltip();
		}
		function calcular_totales_gastos(){
			var total_importe_gasto = parseFloat(0),
				total_iva_gasto = parseFloat(0),
				total_total_gasto = parseFloat(0);
			tabla_gastos.rows().every(function(rowIdx,tableLoop,rowLoop){
				var row = this.data();
				total_importe_gasto = total_importe_gasto + parseFloat(Number(row[3].replace(/[^0-9\.]+/g,"")));
				total_iva_gasto = total_iva_gasto + parseFloat(Number(row[4].replace(/[^0-9\.]+/g,"")));
				total_total_gasto = total_total_gasto + parseFloat(Number(row[5].replace(/[^0-9\.]+/g,"")));
			});
			$('#total-importe-gasto').text(total_importe_gasto.formatMoney(2, "$ ", ",", "."));
			$('#total-iva-gasto').text(total_iva_gasto.formatMoney(2, "$ ", ",", "."));
			$('#total-total-gasto').text(total_total_gasto.formatMoney(2, "$ ", ",", "."));
		}
		var anio_selected_gasto = '',
			mes_selected_gasto = '';
		$('#form-busqueda-gastos').submit(function(event){
			event.preventDefault();
			var	anio = $.requerido('#anio-gasto'),
				mes = $.requerido('#mes-gasto');
			if(anio && mes ){
				anio_selected_gasto = $('#anio-gasto').val();
				mes_selected_gasto = $('#mes-gasto').val();
				$('#pdf-gastos').attr('data-link','index.php/numeros/reporte_gastos/'+anio_selected_gasto+'/'+mes_selected_gasto);
				$.ajaxSerialize($(this),function(data){
					$('#gastos-view').show();
					$('#anio-pago-nomina, #anio-agregar-gasto, #e-anio-agregar-gasto').val(anio_selected_gasto);
					$('#mes-pago-nomina, #mes-agregar-gasto, #e-mes-agregar-gasto').val(mes_selected_gasto);
					tabla_gastos.clear().draw();
					agregar_row_gasto(data.gastos);
					agregar_row_pago(data.nomina);
					calcular_totales_gastos();
				});
			}
		});
		$('#pagar-nomina').click(function(){
			$.ajaxData({
				url: 'index.php/numeros/obtener_sueldos',
				data:{},
				method: 'post'
			},function(data){
				$('#monto-total-diario').text(parseFloat(data.dias).formatMoney(2, "$ ", ",", "."));
				$('#monto-total-semanal').text(parseFloat(data.semanal).formatMoney(2, "$ ", ",", "."));
				$('#monto-total-quincenal').text(parseFloat(data.quincenal).formatMoney(2, "$ ", ",", "."));
				$('#monto-total-mensual').text(parseFloat(data.mensual).formatMoney(2, "$ ", ",", "."));

				$('#check-monto-total-diario').val(data.dias);
				$('#check-monto-total-semanal').val(data.semanal);
				$('#check-monto-total-quincenal').val(data.quincenal);
				$('#check-monto-total-mensual').val(data.mensual);

				$('#modal-pagar-nomina').modal('show');
				/*
				if(data.resp){
					swal(data.titulo, data.mensaje, "success");
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}*/
			});
		});
		$('#form-pagar-nomina').submit(function(event){
			event.preventDefault();
			var bandera = false;
			$('#tabla-nominas input[type="checkbox"]').each(function(){
				if($(this).is(':checked')){
					bandera = true;
				}
			});
			if(bandera){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('#modal-pagar-nomina').modal('hide');
						tabla_gastos.clear().draw();
						agregar_row_gasto(data.datos.gastos);
						agregar_row_pago(data.datos.nomina);
						calcular_totales_gastos();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}else{
				$('#modal-pagar-nomina').modal('hide');
			}
		});
		$('#form-agregar-gasto').submit(function(event){
			event.preventDefault();
			var fecha = $.requerido('#fecha-gasto'),
				proveedor = $.requerido('#proveedor-gasto'),
				importe = $.requerido('#importe-gasto');
				//factura = $.requerido('#factura-gasto');
			if(fecha && proveedor && importe){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						tabla_gastos.clear().draw();
						agregar_row_gasto(data.datos.gastos);
						agregar_row_pago(data.datos.nomina);
						calcular_totales_gastos();
						$('#modal-agregar-gasto').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','.eliminar-gasto',function(){
			var element = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			swal({
				title: "¿Estas seguro de eliminar el gasto/compra?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/numeros/eliminar_gasto',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						tabla_gastos.row(element).remove().draw();
						calcular_totales_gastos();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','.eliminar-pago-nomina',function(){
			var element = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			swal({
				title: "¿Estas seguro de eliminar el gasto/compra?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/numeros/eliminar_pago_nomina',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						tabla_gastos.row(element).remove().draw();
						calcular_totales_gastos();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','.editar-gasto',function(){
			var id = $(this).parents('ul').data('id');
			$.ajaxData({
				url: 'index.php/numeros/obtener_gasto',
				data:{id:id},
				method: 'post'
			},function(data){
				$('#modal-editar-gasto').modal('show');
				$('#e-fecha-gasto').val(moment(data.datos.fecha).format('DD/MM/YYYY'));
				$('#e-importe-gasto').val(parseFloat(data.datos.total).toFixed(2));
				$('#e-factura-gasto').val(data.datos.factura);
				$('#e-notas-gasto').val(data.datos.notas);
				$('#e-id-gasto').val(data.datos.id);
				$('#e-proveedor-gasto option[value="'+data.datos.id_proveedor+'"]').prop('selected',true);
				if(data.datos.iva == 0){
					$('#e-sin-iva-gasto').prop('checked',true);
				}else{
					$('#e-con-iva-gasto').prop('checked',true);
				}
				if(data.datos.tipo == 1){
					$('#e-gasto-gasto').prop('checked',true);
				}else{
					$('#e-compra-gasto').prop('checked',true);
				}
				$('#form-editar-gasto input, #form-editar-gasto select').each(function(){
					if($(this).val() != ''){
						$(this).closest('.fg-line').addClass('fg-toggled');
					}
				});
			});
		});
		$('#form-editar-gasto').submit(function(event){
			event.preventDefault();
			var fecha = $.requerido('#e-fecha-gasto'),
				proveedor = $.requerido('#e-proveedor-gasto'),
				importe = $.requerido('#e-importe-gasto'),
				factura = $.requerido('#e-factura-gasto');
			if(fecha && proveedor && importe && factura){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('#modal-editar-gasto').modal('hide');
						tabla_gastos.clear().draw();
						agregar_row_gasto(data.datos.gastos);
						agregar_row_pago(data.datos.nomina);
						calcular_totales_gastos();
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		//********Funciones de proveedores**********
		$('#ir-gastos').click(function(){
			$('#sec-proveedores').hide();
			$('#sec-gastos').show();
		});
		var r_rfc = 0;
		$('input[name="r_rfc"]').change(function(){
			if($(this).val() == 0 ){
				$('#input-rfc').hide();
				r_rfc = 0;
			}else{
				$('#input-rfc').show();
				r_rfc = 1;
			}
			$('#rfc-proveedor').closest('.form-group').removeClass('has-error');
		});
		var e_r_rfc = 0;
		$('input[name="e_r_rfc"]').change(function(){
			if($(this).val() == 0 ){
				$('#e-input-rfc').hide();
				e_r_rfc = 0;
			}else{
				$('#e-input-rfc').show();
				e_r_rfc = 1;
			}
			$('#rfc-proveedor').closest('.form-group').removeClass('has-error');
		});
		function agrega_proveedor_tabla(data){
			$.each(data,function(index,value){
				var html = '<tr><td>'+value.nombre+'</td><td>'+value.rfc+'</td><td>'+
							'<ul class="actions" data-id="'+value.id+'">'+
								'<li data-toggle="tooltip" title="Editar">'+
									'<i class="fa fa-edit editar-proveedor"></i>'+
								'</li>'+
								'<li data-toggle="tooltip" title="Eliminar">'+
									'<i class="fa fa-trash eliminar-proveedor"></i>'+
								'</li>'+
							'</ul></td></tr>';
				$('#tabla-proveedores').append(html);
			});
			$('#tabla-proveedores [data-toggle="tooltip"]').tooltip();
		}
		$('#form-agregar-proveedor').submit(function(event){
			event.preventDefault();
			var nombre = $.requerido('#nombre-proveedor'),
				rfc = true;
			if(r_rfc == 1){
				rfc = $.requerido('#rfc-proveedor');
			}else{
				$('#rfc-proveedor').closest('.form-group').removeClass('has-error');
			}
			if(nombre && rfc){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						llena_proveedores(data.datos);
						$('#modal-agregar-proveedor').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('#modal-agregar-proveedor').on('hide.bs.modal',function(){
			$('#input-rfc').hide();
		});
		$(document).on('click','.eliminar-proveedor',function(){
			var element = $(this).parents('tr');
			var id = $(this).parents('ul').data('id');
			swal({
				title: "¿Estas seguro de eliminar el proveedor?",
				text: "Todos los datos relacionados serán eliminados",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/numeros/eliminar_proveedor',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						llena_proveedores(data.datos);
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','.editar-proveedor',function(){
			var id = $(this).parents('ul').data('id');
			$.ajaxData({
				url: 'index.php/numeros/obtener_proveedor',
				data:{id:id},
				method: 'post'
			},function(data){
				$('#e-nombre-proveedor').val(data.datos.nombre);
				$('#e-rfc-proveedor').val(data.datos.rfc);
				$('#e-id-proveedor').val(data.datos.id);
				if(data.datos.rfc != ''){
					$('#e-radio-con-rfc-prov').prop('checked',true);
					$('#e-input-rfc').show();
					e_r_rfc = 1;
				}else{
					$('#e-radio-sin-rfc-prov').prop('checked',true);
					$('#e-input-rfc').hide();
					e_r_rfc = 0;
				}
				$('#form-editar-proveedor input').each(function(){
					if($(this).val() != ''){
						$(this).closest('.fg-line').addClass('fg-toggled');
					}
				});
				$('#modal-editar-proveedor').modal('show');
			});
		});
		$('#form-editar-proveedor').submit(function(event){
			event.preventDefault();
			var nombre = $.requerido('#e-nombre-proveedor'),
				rfc = true;
			if(e_r_rfc == 1){
				rfc = $.requerido('#e-rfc-proveedor');
			}else{
				$('#e-rfc-proveedor').closest('.form-group').removeClass('has-error');
			}
			if(nombre && rfc){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						llena_proveedores(data.datos);
						$('#modal-editar-proveedor').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		//-------Funciones de Libro de bancos-------
		$('#anio-libro').datetimepicker({
			format: 'YYYY',
			viewMode: 'years'
		});
		$('#mes-libro').datetimepicker({
			format: 'MMMM',
			viewMode: 'months'
		});
		$('#anio-libro, #mes-libro').click(function(){
			$(this).closest('.form-group').removeClass('has-error');
		});
		var tabla_libro = $('#tabla-libro').DataTable({"ordering": false});
		$('#tabla-libro').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
		$('#tabla-libro').parents('.table-responsive').find('select, input').addClass('form-control');
		tabla_libro.on('draw',function(){
			$('#tabla-libro').parents('.table-responsive').find('.paginate_button').addClass('btn btn-primary');
			$('#tabla-libro').parents('.table-responsive').find('.paginate_button.current').addClass('disabled');
		});
		var saldo_inicial_mes = 0;
		function add_row_libro(data){
			$.each(data,function(index,value){
				saldo_inicial_mes = saldo_inicial_mes + parseFloat(value.ingreso) - parseFloat(value.egreso);
				var html_saldo = '';
				if(saldo_inicial_mes >= 0){
					html_saldo = '<span class="c-green">'+saldo_inicial_mes.formatMoney(2, "$ ", ",", ".")+'</span>';
					//html_saldo = '<span class="c-green">'+saldo_inicial_mes.toFixed(2)+'</span>';
				}else{
					html_saldo = '<span class="c-red">'+saldo_inicial_mes.formatMoney(2, "$ ", ",", ".")+'</span>';
					//html_saldo = '<span class="c-red">'+saldo_inicial_mes.toFixed(2)+'</span>';
				}
				tabla_libro.row.add([
					'<span style="display:none">'+moment(value.fecha).format('x')+'</span>'+moment(value.fecha).format('ll'),
					value.concepto,
					value.factura,
					parseFloat(value.ingreso).formatMoney(2, "$ ", ",", "."),
					parseFloat(value.egreso).formatMoney(2, "$ ", ",", "."),
					html_saldo
				]);
			});
			tabla_libro.order([0,'asc']).draw();
		}
		function add_row_saldo(ingresos,egresos,saldo_inicial){
			if(ingresos == null){
				ingresos = 0;
			}if(egresos == null){
				egresos = 0;
			}
			var saldo = parseFloat(ingresos) + parseFloat(saldo_inicial) - parseFloat(egresos);
			saldo_inicial_mes = saldo;
			var html_saldo = '';
			if(saldo >= 0){
				html_saldo = '<span class="c-green">'+saldo.formatMoney(2, "$ ", ",", ".")+'</span>';
				//html_saldo = '<span class="c-green">'+saldo.toFixed(2)+'</span>';
			}else{
				html_saldo = '<span class="c-red">'+saldo.formatMoney(2, "$ ", ",", ".")+'</span>';
				//html_saldo = '<span class="c-red">'+saldo.toFixed(2)+'</span>';
			}
			tabla_libro.row.add([
				'',
				'Saldo inicial',
				'',
				'',
				'',
				html_saldo
			]).draw();
		}
		var saldo_inicial = 0;
		$('#modal-saldo-inicial').on('shown.bs.modal',function(){
			$('#saldo-inicial').val(parseFloat(saldo_inicial).toFixed(2));
		});
		$('#form-busqueda-libro').submit(function(event){
			event.preventDefault();
			var	anio = $.requerido('#anio-libro'),
				mes = $.requerido('#mes-libro');
			if(anio && mes){
				$('#pdf-libros').attr('data-link','index.php/numeros/reporte_libro/'+$('#anio-libro').val()+'/'+$('#mes-libro').val());
				$('#anio-libro-saldo').val($('#anio-libro').val());
				$('#mes-libro-saldo').val($('#mes-libro').val());
				$.ajaxSerialize($(this),function(data){
					$('#libro-view').show();
					saldo_inicial = data.saldo_inicial;
					tabla_libro.clear().draw();
					add_row_saldo(data.ingresos,data.egresos,data.saldo_inicial);
					add_row_libro(data.registros);
				});
			}
		});
		$('#form-saldo-inicial').submit(function(event){
			event.preventDefault();
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					$('#modal-saldo-inicial').modal('hide');
					saldo_inicial = data.datos.saldo_inicial;
					tabla_libro.clear().draw();
					add_row_saldo(data.datos.ingresos,data.datos.egresos,data.datos.saldo_inicial);
					add_row_libro(data.datos.registros);
					swal(data.titulo, data.mensaje, "success");
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		//-------Funciones de Estado de resultados-------
		$('#anio-resultado').datetimepicker({
			format: 'YYYY',
			viewMode: 'years'
		});
		$('#form-busqueda-resultado').submit(function(event){
			event.preventDefault();
			var	anio = $.requerido('#anio-resultado')
			if(anio){
				$('#pdf-resultado').attr('data-link','index.php/numeros/reporte_resultado/'+$('#anio-resultado').val());
				$.ajaxSerialize($(this),function(data){
					//-----------Ventas-----------
					$('#ventas-estado-resultado, #total-ventas-estado-resultado').empty();
					$('#ventas-estado-resultado').append('<td>Ventas</td>');
					$('#total-ventas-estado-resultado').append('<td>Total de ingresos</td>');
					var total_ventas = parseFloat(0);
					$.each(data.ventas,function(index,value){
						var valor = parseFloat(0.00);
						if(value.total != null){
							valor = parseFloat(value.total);
							total_ventas = total_ventas + valor;
						}
						$('#ventas-estado-resultado, #total-ventas-estado-resultado').append('<td>'+valor.formatMoney(2, "$", ",", ".")+'</td>');
					});
					$('#ventas-estado-resultado, #total-ventas-estado-resultado').append('<td>'+total_ventas.formatMoney(2, "$", ",", ".")+'</td>');
					//-------------Compras----------
					$('#compras-estado-resultado').empty();
					$('#compras-estado-resultado').append('<td>Compras</td>');
					var total_compras = parseFloat(0);
					$.each(data.compras,function(index,value){
						var valor = parseFloat(0.00);
						if(value.total != null){
							valor = parseFloat(value.total);
							total_compras = total_compras + valor;
						}
						$('#compras-estado-resultado').append('<td>'+valor.formatMoney(2, "$", ",", ".")+'</td>');
					});
					$('#compras-estado-resultado').append('<td>'+total_compras.formatMoney(2, "$", ",", ".")+'</td>');
					//-------------Gastos----------
					$('#gastos-estado-resultado').empty();
					$('#gastos-estado-resultado').append('<td>Gastos</td>');
					var total_gastos = parseFloat(0);
					$.each(data.gastos,function(index,value){
						var valor = parseFloat(0.00);
						if(value.total != null){
							valor = parseFloat(value.total);
							total_gastos = total_gastos + valor;
						}
						$('#gastos-estado-resultado').append('<td>'+valor.formatMoney(2, "$", ",", ".")+'</td>');
					});
					$('#gastos-estado-resultado').append('<td>'+total_gastos.formatMoney(2, "$", ",", ".")+'</td>');
					//-------------sueldos----------
					$('#sueldos-estado-resultado').empty();
					$('#sueldos-estado-resultado').append('<td>Sueldos</td>');
					var total_sueldos = parseFloat(0);
					$.each(data.sueldos,function(index,value){
						var valor = parseFloat(0.00);
						if(value.total != null){
							valor = parseFloat(value.total);
							total_sueldos = total_sueldos + valor;
						}
						$('#sueldos-estado-resultado').append('<td>'+valor.formatMoney(2, "$", ",", ".")+'</td>');
					});
					$('#sueldos-estado-resultado').append('<td>'+total_sueldos.formatMoney(2, "$", ",", ".")+'</td>');
					//-------------Total de egresos----------
					$('#total-egresos-estado-resultado, #total-unidad-estado-resultado').empty();
					$('#total-egresos-estado-resultado').append('<td>Total de egresos</td>');
					$('#total-unidad-estado-resultado').append('<td>Unidad o perdida</td>');
					var total_egresos = parseFloat(0.00),
						total_u_p = parseFloat(0.00);
					for(var i = 0;i < 12;i++){
						var total_mes = parseFloat(0.00),
							compra = parseFloat(0.00),
							gasto = parseFloat(0.00),
							sueldo = parseFloat(0.00);
						if(data.compras[i].total != null){
							compra = data.compras[i].total;
						}if(data.gastos[i].total != null){
							gasto = data.gastos[i].total;
						}if(data.sueldos[i].total != null){
							sueldo = data.sueldos[i].total;
						}
						total_mes = parseFloat(compra) + parseFloat(gasto) + parseFloat(sueldo);
						$('#total-egresos-estado-resultado').append('<td>'+total_mes.formatMoney(2, "$", ",", ".")+'</td>');
						total_egresos = total_egresos + total_mes;
						//-------------unidad o perdida----------
						var ingreso_mes = parseFloat(0.00),
							total_u_p_m = parseFloat(0.00);
						if(data.ventas[i].total != null){
							ingreso_mes = data.ventas[i].total;
						}
						total_u_p_m = parseFloat(ingreso_mes) - parseFloat(total_mes);
						$('#total-unidad-estado-resultado').append('<td>'+total_u_p_m.formatMoney(2, "$", ",", ".")+'</td>');
						total_u_p = total_u_p + total_u_p_m;
					}
					$('#total-egresos-estado-resultado').append('<td>'+total_egresos.formatMoney(2, "$", ",", ".")+'</td>');
					$('#total-unidad-estado-resultado').append('<td>'+total_u_p.formatMoney(2, "$", ",", ".")+'</td>');
					//----------Mostrar tablas--------------
					$('#tabla-resultado').show();
				});
			}
		});
		//-------Funciones de Tablero-------
		function crear_graficas(data){
			var ventas_totales = parseFloat(0.00),
				ventas_a = [],
				gastos_totales = parseFloat(0.00),
				gastos_a = [],
				compras_totales = parseFloat(0.00),
				compras_a = [],
				sueldos_totales = parseFloat(0.00),
				sueldos_a = [],
				total_gastos_compras_sueldos = parseFloat(0.00),
				total_g_c_s = [];
			$.each(data.ventas,function(index,value){
				if(value.total != null){
					ventas_totales = ventas_totales + parseFloat(value.total);
					ventas_a.push(parseInt(value.total));
				}else{
					ventas_a.push(parseInt('0'));
				}
			});
			$.each(data.gastos,function(index,value){
				if(value.total != null){
					gastos_totales = gastos_totales + parseFloat(value.total);
					gastos_a.push(parseInt(value.total));
				}else{
					gastos_a.push(parseInt('0'));
				}
			});
			$.each(data.compras,function(index,value){
				if(value.total != null){
					compras_totales = compras_totales + parseFloat(value.total);
					compras_a.push(parseInt(value.total));
				}else{
					compras_a.push(parseInt('0'));
				}
			});
			$.each(data.sueldos,function(index,value){
				if(value.total != null){
					sueldos_totales = sueldos_totales + parseFloat(value.total);
					sueldos_a.push(parseInt(value.total));
				}else{
					sueldos_a.push(parseInt('0'));
				}
			});
			for(var i = 0;i <= 11;i++){
				total_g_c_s.push(gastos_a[i]+compras_a[i]+sueldos_a[i]);
			}
			total_gastos_compras_sueldos = gastos_totales + compras_totales + sueldos_totales;
			//ventas_totales =  parseFloat(ventas_totales).toFixed(2);
			//total_gastos_compras_sueldos = parseFloat(total_gastos_compras_sueldos).toFixed(2);
			//console.log(parseFloat(total_gastos_compras_sueldos).toFixed(2));
			//console.log(Number(total_gastos_compras_sueldos.toFixed(2)));
			$('#ventas_gastos').highcharts({
				title: {
					text: 'Relación de Ventas y Gastos',
					x: -20 //center
				},
					subtitle: {
					text: '',
					x: -20
				},
				xAxis: {
					categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
				},
				yAxis: {
					title: {
						text: ''
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					valueSuffix: ''
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					borderWidth: 0
				},
				series: [{
					name: 'Ventas',
					data: ventas_a,
					color: '#FF9800'
					},{
					name: 'Compras y Gastos',
					data: total_g_c_s,
					color: '#2196F3'
				}]
			});
			$('#gastos_compras').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				title: {
					text: 'Relación de Gastos y Compras'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
						enabled: false
					},
					showInLegend: false
					}
				},
				series: [{
					name: "Porciento",
					colorByPoint: true,
					data: [{
						name: "Compras",
						y: compras_totales,
						color: '#8BC34A'
					}, {
						name: "Gastos",
						y: gastos_totales,
						color: '#00BCD4',
						sliced: true,
						selected: true
					}]
				}]
			});
			$('#ingresos_egresos').highcharts({
				chart: {
					type: 'pie',
					/*options3d: {
					enabled: true,
					alpha: 45
					}*/
				},
				title: {
					text: 'Ingresos vs Egresos'
				},
				subtitle: {
					text: ''
				},
				plotOptions: {
					pie: {
						innerSize: 100,
						depth: 45
					}
				},
				series: [{
					name: '$',
					data: [{
						name: "Ingresos",
						y: Number(ventas_totales.toFixed(2)),
						color: '#4CAF50'
					}, {
						name: "Egresos",
						y: Number(total_gastos_compras_sueldos.toFixed(2)),
						color: '#F44336'
					}]
				}]
			});
		}
		$.ajaxData({
			url: 'index.php/numeros/tablero',
			data:{},
			method: 'post'
			},function(data){
				crear_graficas(data);
			});
		});
	Number.prototype.formatMoney = function(places, symbol, thousand, decimal) {
		places = !isNaN(places = Math.abs(places)) ? places : 2;
		symbol = symbol !== undefined ? symbol : "$";
		thousand = thousand || ",";
		decimal = decimal || ".";
		var number = this,
		    negative = number < 0 ? "-" : "",
		    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
		    j = (j = i.length) > 3 ? j % 3 : 0;
		return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
	};
});