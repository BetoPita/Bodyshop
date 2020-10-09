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
$(document).ready(function(){
	Handlebars.registerHelper('moment', function(context, block) {
		if (window.moment) {
			var f = block.hash.format || "MMM DD, YYYY hh:mm:ss A";
			return moment(context).format(f); //had to remove Date(context)
		}else{
			return context;   //  moment plugin not available. return data as is.
		};
	});
	Handlebars.registerHelper('money', function(context) {
		if ($.isNumeric(context)) {
			return parseFloat(context).formatMoney(2, "$", ",", ".");
		}else{
			return context;
		};
	});
	Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {
		switch (operator) {
			case '==':
				return (v1 == v2) ? options.fn(this) : options.inverse(this);
			case '===':
				return (v1 === v2) ? options.fn(this) : options.inverse(this);
			case '!=':
				return (v1 != v2) ? options.fn(this) : options.inverse(this);
			case '<':
				return (v1 < v2) ? options.fn(this) : options.inverse(this);
			case '<=':
				return (v1 <= v2) ? options.fn(this) : options.inverse(this);
			case '>':
				return (v1 > v2) ? options.fn(this) : options.inverse(this);
			case '>=':
				return (v1 >= v2) ? options.fn(this) : options.inverse(this);
			case '&&':
				return (v1 && v2) ? options.fn(this) : options.inverse(this);
			case '||':
				return (v1 || v2) ? options.fn(this) : options.inverse(this);
			default:
				return options.inverse(this);
		}
	});
	$.section('#index',function(){
		$('#form-nueva-campana').submit(function(event){
			event.preventDefault();
			if($.requerido('#nombre') && $.requerido('#fecha_inicio')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('#modal-nueva-campana').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						$('.alert-warning').remove();
						$('#campanas').show();
						var source = $('#campana-template').html();
						var template = Handlebars.compile(source);
						var html = template(data.datos);
						$('#campanas').append(html);
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','.fa-trash',function(){
			var id = $(this).data('id'),
				element = $(this).closest('.c-campana');
			swal({
				title: '¿Estas seguro de eliminar la campaña?',
				text: 'Se eliminaran todos los datos relacionados',
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/campanas/eliminar_campana',
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
						element.remove();
						$('.prospecto').each(function(){
							if(id == $(this).data('campana')){
								$(this).remove();
							}
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$('.modal').on('show.bs.modal',function(){
			$('form input').each(function(){
				if($(this).val() != ''){
					$(this).closest('.fg-line').addClass('fg-toggled');
				}
			});
			$('form select').each(function(){
				if($(this).val() != ''){
					$(this).closest('.fg-line').addClass('fg-toggled');
				}
			});
		});
		$(document).on('click','.fa-edit',function(){
			var id = $(this).data('id'),
				element = $(this).closest('.c-campana');
			$.ajaxData({
				url: 'index.php/campanas/get_campana',
				data:{id:id},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#e-nombre').val(data.datos.nombre);
					$('#e-descripcion').val(data.datos.descripcion);
					$('#e-fecha_inicio').val(moment(data.datos.fecha_inicio).format('DD/MM/YYYY'));
					$('#e-lider > option[value="'+data.datos.lider+'"]').prop('selected',true);
					$('#e-id-campana').val(data.datos.id)
					$('#modal-editar-campana').modal('show');

					$('#form-editar-campana').submit(function(event){
						event.preventDefault();
						if($.requerido('#e-nombre') && $.requerido('#e-fecha_inicio')){
							$.ajaxSerialize($(this),function(data){
								if(data.resp){
									$('#modal-editar-campana').modal('hide');
									swal(data.titulo, data.mensaje, "success");
									element.find('h2').html(data.datos.nombre+' <small>'+data.datos.descripcion+'&nbsp;</small>');
									element.find('.fecha').text(moment(data.datos.fecha_inicio).format('ll'));
								}else{
									swal(data.titulo, data.mensaje, "warning");
								}
							});
						}
					});
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
	});
	$.section('#etapas',function(){
		$('.setup-panel > li').click(function(event){
			event.preventDefault();
			if(!$(this).hasClass('disabled')){
				$('.setup-panel > li, .setup-content').removeClass('active');
				$(this).addClass('active');
				$($(this).find('a').attr('href')).addClass('active');
			}
		});
		$('#form-nueva-estrategia').submit(function(event){
			event.preventDefault();
			if($.requerido('#nombre_estrategia') && $.requerido('#tiempo_estrategia') && $.requerido('#costo_estrategia')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('#modal-nueva-estrategia').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						var source = $('#estrategia-template').html();
						var template = Handlebars.compile(source);
						var html = template(data.datos);
						$('#list-estrategias').append(html);
						$('[data-toggle="tooltip"]').tooltip();
						$('#estrastegia_prospecto, #e_estrastegia_prospecto').append('<option value="'+data.datos.id+'">'+data.datos.nombre+'</option>');
						$('#cs-est').text(parseInt($('#cs-est').text())+1);
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','[data-detalle]',function(event){
			event.preventDefault();
			$.ajaxData({
				url: 'index.php/campanas/get_actividades',
				data:{prospecto:$(this).data('detalle')},
				method: 'post'
			},function(data){
				var source = $('#time-line-template').html();
				var template = Handlebars.compile(source);
				var html = template(data);
				$('#modal-detalle-prospecto').find('.modal-title').html(data.prospecto.nombre);
				$('#modal-detalle-prospecto').find('.modal-body').html(html);
				$('#modal-detalle-prospecto').modal('show');
			});
		});
		/*$('[data-eliminar]').click(function(event){
			event.preventDefault();
			$(this).closest('li').remove();
		});*/

		$('#form-nuevo-prospecto').submit(function(event){
			event.preventDefault();
			if($.requerido('#estrastegia_prospecto')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('#modal-nuevo-prospecto').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						var source = $('#prospecto-template').html();
						var template = Handlebars.compile(source);
						var html = template(data.datos);
						$('#list-prospectos').append(html);
						$('[data-toggle="tooltip"]').tooltip();
						var source = $('#oportunidad-template').html();
						var template = Handlebars.compile(source);
						var html = template(data.datos);
						if(data.datos.tipo == 1){
							$('#sortable1').append(html);
						}else if(data.datos.tipo == 2){
							$('#sortable2').append(html);
						}else if(data.datos.tipo == 3){
							$('#sortable3').append(html);
						}
						$('#cs-pros').text(parseInt($('#cs-pros').text())+1);
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$( "#sortable1, #sortable2 , #sortable3" ).sortable({
			connectWith: ".connectedSortable",
			handle: ".handle",
			placeholder: "sortable-placeholder",
			cancel: ".ui-state-disabled",
			start: function( event, ui ) {
				$('.connectedSortable').addClass('active');
			},
			stop: function( event, ui ) {
				$('.connectedSortable').removeClass('active');
				if($(ui.item[0]).data('tipo') != $(ui.item[0]).closest('ul').data('tipo')){
					$.ajaxData({
						url: 'index.php/campanas/cambiar_tipo',
						data:{prospecto:$(ui.item[0]).data('id'),tipo:$(ui.item[0]).closest('ul').data('tipo')},
						method: 'post'
					},function(data){
						if(data.resp){
							$(ui.item[0]).data('tipo',$(ui.item[0]).closest('ul').data('tipo'));
							swal(data.titulo, data.mensaje, "success");
						}else{
							swal(data.titulo, data.mensaje, "warning");
						}
					});
				}
			}
		}).disableSelection();
		$(document).on('click','.fa-trash',function(){
			var tipo = $(this).data('element'),
				id = $(this).data('id'),
				element = $(this).closest('tr'),
				titulo = '',
				mensaje = '';
			if(tipo == 'estrategias'){
				titulo = '¿Estas seguro de eliminar la estrategia?';
				mensaje = 'Los prospectos y datos relacionados se eliminaran';
			}else if(tipo == 'prospectos'){
				titulo = '¿Estas seguro de eliminar el prospecto?';
				mensaje = 'Todos los datos relacionados serán eliminados';
			}
			swal({
				title: titulo,
				text: mensaje,
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/campanas/eliminar/'+tipo,
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
						element.remove();
						if(tipo == 'estrategias'){
							$('#estrastegia_prospecto > option[value="'+id+'"], #e_estrastegia_prospecto > option[value="'+id+'"]').remove();
							$.each(data.datos,function(index,value){
								$('#list-prospectos > tr').each(function(){
									if(value.id == $(this).data('id')){
										$(this).remove();
									}
								});
								$('ul.prospectos > li').each(function(){
									if(value.id == $(this).data('id')){
										$(this).remove();
									}
								});
							});
							$('#cs-est').text(parseInt($('#cs-est').text())-1);
						}else if(tipo == 'prospectos'){
							$('ul.prospectos > li').each(function(){
								if($(this).data('id') == id){
									$(this).remove();
								}
							});
							$('#cs-pros').text(parseInt($('#cs-pros').text())-1);
						}
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$('.modal').on('show.bs.modal',function(){
			$('form input').each(function(){
				if($(this).val() != ''){
					$(this).closest('.fg-line').addClass('fg-toggled');
				}
			});
			$('form select').each(function(){
				if($(this).val() != ''){
					$(this).closest('.fg-line').addClass('fg-toggled');
				}
			});
		});
		$(document).on('click','.fa-edit',function(){
			var tipo = $(this).data('element'),
				id = $(this).data('id'),
				element = $(this).closest('tr');
			$.ajaxData({
					url: 'index.php/campanas/get_datos/'+tipo,
					data:{id:id},
					method: 'post'
				},function(data){
					if(data.resp){
						if(tipo == 'estrategias'){
							$('#e_nombre_estrategia').val(data.datos.nombre);
							$('#e_descripcion_estrategia').val(data.datos.descripcion);
							$('#e_unidad_estrategia > option[value="'+data.datos.unidad+'"]').prop('selected',true);
							$('#e_id_estrategia').val(data.datos.id);
							$('#modal-editar-estrategia').modal('show');
							$('#e_tiempo_estrategia').val(data.datos.tiempo);
							$('#e_costo_estrategia').val(parseFloat(data.datos.costo).toFixed(2));
							$('#form-editar-estrategia').submit(function(event){
								event.preventDefault();
								if($.requerido('#e_nombre_estrategia') && $.requerido('#e_tiempo_estrategia') && $.requerido('#e_costo_estrategia')){
									$.ajaxSerialize($(this),function(data){
										if(data.resp){
											$('#modal-editar-estrategia').modal('hide');
											swal(data.titulo, data.mensaje, "success");
											element.find('[tde-nombre]').text(data.datos.nombre);
											element.find('[tde-descripcion]').text(data.datos.descripcion);
											element.find('[tde-tiempo]').text(data.datos.tiempo+' '+data.datos.unidad);
											element.find('[tde-costo]').text(parseFloat(data.datos.costo).formatMoney(2, "$", ",", "."));
											var costoT = parseFloat(data.datos.costo) + parseFloat(element.find('[tde-rdi]').data('costos'));
											element.find('[tde-rdi]').text( (parseFloat(element.find('[tde-rdi]').data('ventas') - costoT)/costoT).toFixed(0)+'%' );
											$('#estrastegia_prospecto > option[value="'+id+'"], #e_estrastegia_prospecto > option[value="'+id+'"]').text(data.datos.nombre);
										}else{
											swal(data.titulo, data.mensaje, "warning");
										}
									});
								}
							});
						}else if(tipo == 'prospectos'){
							$('#e_nombre_prospecto').val(data.datos.nombre);
							$('#e_email_prospecto').val(data.datos.email);
							$('#e_telefono_prospecto').val(data.datos.telefono);
							$('#e_direccion_prospecto').val(data.datos.direccion);
							$('#e_estrastegia_prospecto > option[value="'+data.datos.id_estrategia+'"]').prop('selected',true);
							$('#e_asignado_prospecto > option[value="'+data.datos.asignado+'"]').prop('selected',true);
							$('#e_tipo_prospecto').val(data.datos.tipo);
							$('#e_id_prospecto').val(data.datos.id);
							$('#modal-editar-prospecto').modal('show');
							$('#form-editar-prospecto').submit(function(event){
								event.preventDefault();
								if($.requerido('#e_estrastegia_prospecto')){
									$.ajaxSerialize($(this),function(data){
										if(data.resp){
											$('#modal-editar-prospecto').modal('hide');
											swal(data.titulo, data.mensaje, "success");
											element.find('[tdp-nombre]').text(data.datos.nombre);
											element.find('[tdp-email]').text(data.datos.email);
											element.find('[tdp-tel]').text(data.datos.telefono);
											element.find('[tdp-asig]').text(data.datos.asignado);
											/*var source = $('#prospecto-template').html();
											var template = Handlebars.compile(source);
											var html = template(data.datos);
											element.replaceWith(html);*/
											$('ul.prospectos > li').each(function(){
												if(data.datos.id == $(this).data('id')){
													$(this).find('h4').text(data.datos.nombre);
													/*var source = $('#oportunidad-template').html();
													var template = Handlebars.compile(source);
													var html = template(data.datos);
													$(this).replaceWith(html);*/
												}
											});
										}else{
											swal(data.titulo, data.mensaje, "warning");
										}
									});
								}
							});
						}
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				}
			);
		});
		$(document).on('click','ul.prospectos .media-body, [data-resumen]',function(){
			var id_prospecto = 0;
			if($(this).is('div')){
				id_prospecto = $(this).closest('li').data('id');
			}else{
				id_prospecto = $(this).data('resumen');
			}
			$.ajaxData({
				url: 'index.php/campanas/get_prospecto',
				data:{id:id_prospecto},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#resumen-nombre').text(data.datos.prospecto.nombre);
					$('#resumen-email').text(data.datos.prospecto.email);
					$('#resumen-tel').text(data.datos.prospecto.telefono);
					$('#resumen-dir').text(data.datos.prospecto.direccion);
					$('#resumen-est').text(data.datos.prospecto.estrategia);

					$('#resumen-asig').text(data.datos.prospecto.asignado);
					$('#resumen-act').text(data.datos.actividades);
					$('#resumen-tiempo-act').text(data.datos.tiempo_actividad);
					$('#resumen-costo-act').text(data.datos.costo_actividad);
					$('#resumen-emails').text(data.datos.emails);
					$('#resumen-llamadas').text(data.datos.llamadas);
					$('#resumen-citas').text(data.datos.citas);

					if(data.datos.prospecto.tipo == 1){
						$('#resumen-oport').text('Baja');
					}else if(data.datos.prospecto.tipo == 2){
						$('#resumen-oport').text('Media');
					}else if(data.datos.prospecto.tipo == 3){
						$('#resumen-oport').text('Alta');
					}
					$('#resumen-prop').text(data.datos.propuestas);
					$('#resumen-prop1').text(data.datos.primer_p);
					$('#resumen-prop2').text(data.datos.ultima_p);
					$('#resumen-propdif').text(data.datos.dif_p);

					if(data.datos.prospecto.estatus == 1){
						$('#btn-finalizar-prospecto').attr('data-id',data.datos.prospecto.id);
						$('#btn-finalizar-prospecto').attr('data-nombre',data.datos.prospecto.nombre);
						$('#btn-finalizar-prospecto').show();
						$('#btn-finalizar-prospecto').prop('disabled',false);
					}else{
						$('#btn-finalizar-prospecto').hide();
						$('#btn-finalizar-prospecto').prop('disabled',true);
					}

					$('#modal-resumen-prospecto').modal('show');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#btn-finalizar-prospecto').click(function(){
			$('#input-proyecto').val($(this).attr('data-nombre'));
			$('#prospecto-finalizar').val($(this).attr('data-id'));
			$('#modal-finalizar-prospecto').modal('show');
			$('#check-proyecto').change(function(){
				if($(this).is(':checked')){
					$('#input-proyecto, #select-plantilla').prop('disabled',false);
					$('#proyecto').show();
				}else{
					$('#input-proyecto, #select-plantilla').prop('disabled',true);
					$('#proyecto').hide();
				}
			});
			$('#form-finalizar-prospecto').submit(function(event){
				event.preventDefault();
				if($.requerido('#input-proyecto') && $.requerido('#select-plantilla')){
					$.ajaxSerialize($(this),function(data){
						if(data.resp){
							$('.modal').modal('hide');
							swal(data.titulo, data.mensaje, "success");
							$('#list-prospectos > tr').each(function(){
								if(data.datos.id == $(this).data('id')){
									$(this).remove();
								}
							});
							$('ul.prospectos > li').each(function(){
								if(data.datos.id == $(this).data('id')){
									$(this).remove();
								}
							});
							var source = $('#prospecto-finalizado-template').html();
							var template = Handlebars.compile(source);
							var html = template(data.datos);
							$('#list-prospectos-finalizados').append(html);
							$('[data-toggle="tooltip"]').tooltip();
						}else{
							swal(data.titulo, data.mensaje, "warning");
						}
					});
				}
			});
			$('#modal-finalizar-prospecto').on('hidden.bs.modal',function(e){
				$('#input-proyecto, #select-plantilla').prop('disabled',true);
				$('#proyecto').hide();
			});
		});
		$('#btn-finalizar-campana').click(function(){
			var id_campana = $(this).data('id');
			swal({
				title: "¿Estas seguro de finalizar la campaña?",
				text: '',
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Cancelar",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, finalizar",
				closeOnConfirm: false
			}, function(){
				$.ajaxData({
					url: 'index.php/campanas/finalizar_campana',
					data:{id:id_campana},
					method: 'post'
				},function(data){
					if(data.resp){
						swal({
							title: data.titulo,
							text: data.mensaje,
							type: "success",
							showCancelButton: false,
							cancelButtonText: "Cancelar",
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "Ok",
							closeOnConfirm: true
						}, function(){
							location.href = 'index.php/campanas'
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','[data-info]',function(){
			var id_estrategia = $(this).data('info'),
				rdi = $(this).data('rdi');
			$.ajaxData({
				url: 'index.php/campanas/get_estrategia',
				data:{id:id_estrategia},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#info-nombre').text(data.datos.estrategia.nombre);
					$('#info-desc').text(data.datos.estrategia.descripcion);
					$('#info-tiempo').text(data.datos.estrategia.tiempo+' '+data.datos.estrategia.unidad);
					$('#info-costo').text(parseFloat(data.datos.estrategia.costo).formatMoney(2, "$", ",", "."));
					$('#info-pgen').text(data.datos.pgen);
					$('#info-pexis').text(data.datos.pexis);
					$('#info-rdi').text(rdi);
					$('#modal-resumen-estrategia').modal('show');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
	});
	$.section('#actividad',function(){
		$('.modal').on('show.bs.modal',function(){
			$('.date-picker').val(moment().format('L'));
			$('form input').each(function(){
				if($(this).val() != ''){
					$(this).closest('.fg-line').addClass('fg-toggled');
				}
			});
			$('form select').each(function(){
				if($(this).val() != ''){
					$(this).closest('.fg-line').addClass('fg-toggled');
				}
			});
		});
		$('#form-agregar-actividad').submit(function(event){
			event.preventDefault();
			if($.requerido('#accion') && $.requerido('#fecha') && $.requerido('#tiempo') && $.requerido('#costo')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('#modal-agregar-actividad').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						$('.alert-info').remove();
						$('#actividades').show();
						var source = $('#line-template').html();
						var template = Handlebars.compile(source);
						var html = template(data.datos);
						$('#actividades').prepend(html);
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('#form-agregar-propuesta').submit(function(event){
			event.preventDefault();
			if($.requerido('#descripcion_propuesta') && $.requerido('#costo_propuesta')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('#modal-agregar-propuesta').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						$('.alert-info').remove();
						$('#actividades').show();
						var source = $('#line-template').html();
						var template = Handlebars.compile(source);
						var html = template(data.datos);
						$('#actividades').prepend(html);
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
	});
	$.section('#finalizada',function(){
		$('#prospectos').highcharts({
			chart: {
				type: 'pie',
			},
			title: {
				text: 'Prospectos'
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
				name: 'Cantidad',
				data: [{
					name: "Exitosos",
					y: Number($('#prospectos').data('exitosos')),
					color: '#4CAF50'
				}, {
					name: "No concretados",
					y: Number($('#prospectos').data('concretados')),
					color: '#F44336'
				}]
			}]
		});
		$('#gastos_ventas').highcharts({
			chart: {
				type: 'pie',
			},
			title: {
				text: 'Gastos vs Ventas'
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
					name: "Ventas",
					y: Number(parseFloat($('#gastos_ventas').data('ventas')).toFixed(2)),
					color: '#4CAF50'
				}, {
					name: "Gastos",
					y: Number(parseFloat($('#gastos_ventas').data('gastos')).toFixed(2)),
					color: '#F44336'
				}]
			}]
		});
		$('#actividades').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: 'Actividades'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				type: 'category'
			},
			yAxis: {
				title: {
					text: 'Total de actividades'
				}

			},
			legend: {
				enabled: false
			},
			series: [{
				name: 'Actividades',
				colorByPoint: true,
				data: [{
					name: 'Emails',
					y: Number($('#actividades').data('emails')),
				}, {
					name: 'Llamadas',
					y: Number($('#actividades').data('llamadas')),
				}, {
					name: 'Citas',
					y: Number($('#actividades').data('citas')),
				}]
			}],
		});
		$('#estrategias').highcharts({
			chart: {
				type: 'column'
			},
			title: {
				text: 'Prospectos por estrategias'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				type: 'category'
			},
			yAxis: {
				title: {
					text: 'Total de prospectos'
				}

			},
			legend: {
				enabled: false
			},
			series: [{
				name: 'Prospectos',
				colorByPoint: true,
				data: a_estrategias
			}],
		});
		$('[data-detalle]').click(function(event){
			event.preventDefault();
			$.ajaxData({
				url: 'index.php/campanas/get_actividades',
				data:{prospecto:$(this).data('detalle')},
				method: 'post'
			},function(data){
				var source = $('#time-line-template').html();
				var template = Handlebars.compile(source);
				var html = template(data);
				$('#modal-detalle-prospecto').find('.modal-title').html(data.prospecto.nombre);
				$('#modal-detalle-prospecto').find('.modal-body').html(html);
				$('#modal-detalle-prospecto').modal('show');
			});
		});
		$('#btn-finalizar-prospecto').remove();
		$('[data-resumen]').click(function(){
			var id_prospecto = $(this).data('resumen');
			$.ajaxData({
				url: 'index.php/campanas/get_prospecto',
				data:{id:id_prospecto},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#resumen-nombre').text(data.datos.prospecto.nombre);
					$('#resumen-email').text(data.datos.prospecto.email);
					$('#resumen-tel').text(data.datos.prospecto.telefono);
					$('#resumen-dir').text(data.datos.prospecto.direccion);
					$('#resumen-est').text(data.datos.prospecto.estrategia);

					$('#resumen-asig').text(data.datos.prospecto.asignado);
					$('#resumen-act').text(data.datos.actividades);
					$('#resumen-tiempo-act').text(data.datos.tiempo_actividad);
					$('#resumen-costo-act').text(data.datos.costo_actividad);
					$('#resumen-emails').text(data.datos.emails);
					$('#resumen-llamadas').text(data.datos.llamadas);
					$('#resumen-citas').text(data.datos.citas);

					if(data.datos.prospecto.tipo == 1){
						$('#resumen-oport').text('Baja');
					}else if(data.datos.prospecto.tipo == 2){
						$('#resumen-oport').text('Media');
					}else if(data.datos.prospecto.tipo == 3){
						$('#resumen-oport').text('Alta');
					}
					$('#resumen-prop').text(data.datos.propuestas);
					$('#resumen-prop1').text(data.datos.primer_p);
					$('#resumen-prop2').text(data.datos.ultima_p);
					$('#resumen-propdif').text(data.datos.dif_p);

					$('#modal-resumen-prospecto').modal('show');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('[data-info]').click(function(){
			var id_estrategia = $(this).data('info');
			$.ajaxData({
				url: 'index.php/campanas/get_estrategia',
				data:{id:id_estrategia},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#info-nombre').text(data.datos.estrategia.nombre);
					$('#info-desc').text(data.datos.estrategia.descripcion);
					$('#info-tiempo').text(data.datos.estrategia.tiempo+' '+data.datos.estrategia.unidad);
					$('#info-costo').text(parseFloat(data.datos.estrategia.costo).formatMoney(2, "$", ",", "."));
					$('#info-pgen').text(data.datos.pgen);
					$('#info-pexis').text(data.datos.pexis);
					$('#info-rdi').text(data.datos.rdi);
					$('#modal-resumen-estrategia').modal('show');
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
	});
});