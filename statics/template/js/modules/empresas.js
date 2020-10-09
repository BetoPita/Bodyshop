$(document).ready(function(){
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
		$('.dotdotdot').dotdotdot();
		$('[js-propuesta]').click(function(){
			var id_insumo = $(this).attr('js-propuesta');
			$.ajaxData({
				url: 'index.php/empresas/obtener_alianza',
				data:{id:id_insumo},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#prop-empresa').text(data.empresa);
					$('#prop-nombre').text(data.datos.nombre);
					$('#prop-espec').text(data.datos.descripcion);
					$('#prop-id').val(data.datos.id);
					$('#modal-propuesta-alianza').modal('show');
					$('#form-propuesta-alianza').off('submit');
					$('#form-propuesta-alianza').submit(function(event){
						event.preventDefault();
						if($.requerido('#prop-propuesta')){
							$.ajaxSerialize($(this),function(data){
								if(data.resp){
									$('#modal-propuesta-alianza').modal('hide');
									swal(data.titulo, data.mensaje, "success");
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
		$('#form-agregar-insumo').submit(function(event){
			event.preventDefault();
			if($.requerido('#in-nombre') && $.requerido('#in-espec')){
				$.ajaxFormData($(this),function(data){
					if(data.resp){
						$('#modal-agregar-insumo').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('#form-agregar-alianza').submit(function(event){
			event.preventDefault();
			if($.requerido('#al-nombre') && $.requerido('#al-desc')){
				$.ajaxFormData($(this),function(data){
					if(data.resp){
						$('#modal-agregar-alianza').modal('hide');
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
	});
	$.section('#perfil-empresa',function(){
		$('form input, form select, form textarea').each(function(){
			if($(this).val() != ''){
				$(this).closest('.fg-line').addClass('fg-toggled');
			}
		});
		$('#form-perfil').submit(function(event){
			event.preventDefault();
			if($.requerido('#nombre') && $.requerido('#descripcion') && $.requerido('#giro')){
				$.ajaxFormData($(this),function(data){
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
							if(data.reload){
								location.reload();
							}
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('#btn-logo').click(function(){
			$('#logo').click();
		});
		$("#logo").change(function(){
			if (this.files && this.files[0]) {
				if(this.files[0].size < 2*1048576){
					var reader = new FileReader();
					reader.onload = function (e) {
						$('.portada > img').attr('src', e.target.result);
					}
					reader.readAsDataURL(this.files[0]);
				}else{
					$("#logo").val('');
					swal('Imagen muy grande', 'La imagen no debe de ser mayor a 2 MB', "warning");
				}
			}
		});
		$('#form-agregar-insumo').submit(function(event){
			event.preventDefault();
			if($.requerido('#in-nombre') && $.requerido('#in-espec')){
				$.ajaxFormData($(this),function(data){
					if(data.resp){
						$('#modal-agregar-insumo').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						var source = $('#insumo-template').html();
						var template = Handlebars.compile(source);
						var html = template(data.datos);
						$('[data-toggle="tooltip"]').tooltip();
						$('#insumos').append(html);
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','#insumos .ts-helper[disabled]',function(){
			swal('Completa el perfil de la empresa', 'Insumos no disponibles, completa el perfil de la empresa para poder activar insumos', "warning");
		});
		$(document).on('change','#insumos input[type="checkbox"]',function(){
			var id_insumo = $(this).data('id'),
				check = $(this),
				elemento = $(this).closest('.item'),
				activo = false;
			if($(this).is(':checked')){
				$.ajaxData({
					url: 'index.php/empresas/obtener_insumo',
					data:{id:id_insumo},
					method: 'post'
				},function(data){
					if(data.resp){
						$('#modal-activar-insumo').find('.modal-title').text('Activar '+data.datos.nombre);
						$('#ain-espec').val(data.datos.especificacion);
						$('#ain-id').val(data.datos.id);
						$('#form-activar-insumo input, #form-activar-insumo textarea, #form-activar-insumo select').each(function(){
							if($(this).val() != ''){
								$(this).closest('.fg-line').addClass('fg-toggled');
							}
						});
						$('#modal-activar-insumo').modal('show');
						$('#form-activar-insumo').off('submit');
						$('#form-activar-insumo').submit(function(event){
							event.preventDefault();
							if($.requerido('#ain-espec')){
								$.ajaxSerialize($(this),function(data){
									if(data.resp){
										activo = true;
										$('#modal-activar-insumo').modal('hide');
										swal(data.titulo, data.mensaje, "success");
										var source = $('#insumo-template').html();
										var template = Handlebars.compile(source);
										var html = template(data.datos);
										elemento.replaceWith(html);
										$('[data-toggle="tooltip"]').tooltip();
									}else{
										swal(data.titulo, data.mensaje, "warning");
									}
								});
							}
						});
						$('#modal-activar-insumo').on('hide.bs.modal',function(){
							if(!activo){
								check.prop('checked',false);
							}
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
						check.prop('checked',false);
					}
				});
			}else{
				$.ajaxData({
					url: 'index.php/empresas/desactivar_insumo',
					data:{id:id_insumo},
					method: 'post'
				},function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
						check.prop('checked',true);
					}
				});
			}
		});
		$(document).on('click','#insumos .fa-trash',function(){
			var id_insumo = $(this).data('id'),
				elemento = $(this).closest('.item');
			swal({
				title: '¿Estas seguro de eliminar el insumo?',
				text: '',
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "No",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: true
			}, function(){
				$.ajaxData({
					url: 'index.php/empresas/eliminar_insumo',
					data:{id:id_insumo},
					method: 'post'
				},function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
						elemento.remove();
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','#insumos .fa-edit',function(){
			var id_insumo = $(this).data('id'),
				elemento = $(this).closest('.item');
			$.ajaxData({
				url: 'index.php/empresas/obtener_insumo',
				data:{id:id_insumo},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#ein-id').val(data.datos.id);
					$('#ein-nombre').val(data.datos.nombre);
					$('#ein-espec').val(data.datos.especificacion);
					$('#ein-categoria option[value="'+data.datos.categoria+'"]').prop('selected',true);
					if(data.datos.estatus == 1){
						$('#ein-estatus').prop('checked',true);
					}else{
						$('#ein-estatus').prop('checked',false);
					}
					$('#form-editar-insumo input, #form-editar-insumo textarea, #form-editar-insumo select').each(function(){
						if($(this).val() != ''){
							$(this).closest('.fg-line').addClass('fg-toggled');
						}
					});
					$('#modal-editar-insumo').modal('show');
					$('#form-editar-insumo').off('submit');
					$('#form-editar-insumo').submit(function(event){
						event.preventDefault();
						if($.requerido('#ein-nombre') && $.requerido('#ein-espec') && $.requerido('#ein-categoria')){
							$.ajaxSerialize($(this),function(data){
								if(data.resp){
									activo = true;
									$('#modal-editar-insumo').modal('hide');
									swal(data.titulo, data.mensaje, "success");
									var source = $('#insumo-template').html();
									var template = Handlebars.compile(source);
									var html = template(data.datos);
									elemento.replaceWith(html);
									$('[data-toggle="tooltip"]').tooltip();
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
		$('#form-agregar-alianza').submit(function(event){
			event.preventDefault();
			if($.requerido('#al-nombre') && $.requerido('#al-desc')){
				$.ajaxFormData($(this),function(data){
					if(data.resp){
						$('#modal-agregar-alianza').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						var source = $('#alianza-template').html();
						var template = Handlebars.compile(source);
						var html = template(data.datos);
						$('#alianzas').append(html);
						$('[data-toggle="tooltip"]').tooltip();
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$(document).on('click','#alianzas .fa-trash',function(){
			var id_insumo = $(this).data('id'),
				elemento = $(this).closest('.item');
			swal({
				title: '¿Estas seguro de eliminar la alianza?',
				text: '',
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "No",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: true
			}, function(){
				$.ajaxData({
					url: 'index.php/empresas/eliminar_alianza',
					data:{id:id_insumo},
					method: 'post'
				},function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
						elemento.remove();
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$(document).on('click','#alianzas .fa-edit',function(){
			var id_alianza = $(this).data('id'),
				elemento = $(this).closest('.item');
			$.ajaxData({
				url: 'index.php/empresas/obtener_alianza',
				data:{id:id_alianza},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#ale-id').val(data.datos.id);
					$('#ale-nombre').val(data.datos.nombre);
					$('#ale-desc').val(data.datos.descripcion);
					$('#form-editar-alianza input, #form-editar-alianza textarea').each(function(){
						if($(this).val() != ''){
							$(this).closest('.fg-line').addClass('fg-toggled');
						}
					});
					$('#modal-editar-alianza').modal('show');
					$('#form-editar-alianza').off('submit');
					$('#form-editar-alianza').submit(function(event){
						event.preventDefault();
						if($.requerido('#ale-nombre') && $.requerido('#ale-desc')){
							$.ajaxSerialize($(this),function(data){
								if(data.resp){
									activo = true;
									$('#modal-editar-alianza').modal('hide');
									swal(data.titulo, data.mensaje, "success");
									var source = $('#alianza-template').html();
									var template = Handlebars.compile(source);
									var html = template(data.datos);
									elemento.replaceWith(html);
									$('[data-toggle="tooltip"]').tooltip();
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
		$(document).on('change','#alianzas input[type="checkbox"]',function(){
			var id_alianza = $(this).data('id'),
				check = $(this),
				elemento = $(this).closest('.item'),
				activo = false;
			if($(this).is(':checked')){
				$.ajaxData({
					url: 'index.php/empresas/obtener_alianza',
					data:{id:id_alianza},
					method: 'post'
				},function(data){
					if(data.resp){
						$('#modal-activar-alianza').find('.modal-title').text('Activar '+data.datos.nombre);
						$('#aali-desc').val(data.datos.descripcion);
						$('#aali-id').val(data.datos.id);
						$('#form-activar-alianza input, #form-activar-alianza textarea').each(function(){
							if($(this).val() != ''){
								$(this).closest('.fg-line').addClass('fg-toggled');
							}
						});
						$('#modal-activar-alianza').modal('show');
						$('#form-activar-alianza').off('submit');
						$('#form-activar-alianza').submit(function(event){
							event.preventDefault();
							if($.requerido('#aali-espec')){
								$.ajaxSerialize($(this),function(data){
									if(data.resp){
										activo = true;
										$('#modal-activar-alianza').modal('hide');
										swal(data.titulo, data.mensaje, "success");
										var source = $('#alianza-template').html();
										var template = Handlebars.compile(source);
										var html = template(data.datos);
										elemento.replaceWith(html);
										$('[data-toggle="tooltip"]').tooltip();
									}else{
										swal(data.titulo, data.mensaje, "warning");
									}
								});
							}
						});
						$('#modal-activar-alianza').on('hide.bs.modal',function(){
							if(!activo){
								check.prop('checked',false);
							}
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
						check.prop('checked',false);
					}
				});
			}else{
				$.ajaxData({
					url: 'index.php/empresas/desactivar_alianza',
					data:{id:id_alianza},
					method: 'post'
				},function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
						check.prop('checked',true);
					}
				});
			}
		});
	});
	$.section('#perfil',function(){
		$('#video').click(function(event){
			event.preventDefault();
			$('.embed-responsive-item').attr('src','https://www.youtube.com/embed/'+$(this).data('video')+'?rel=0');
			$('#modal-video').modal('show');
		});
		$('#modal-video').on('hide.bs.modal',function(){
			$('.embed-responsive-item').attr('src','');
		});
		$('#insumos .card').click(function(){
			var id_insumo = $(this).data('id'),
				estatus = $(this).data('estatus');
			if(estatus == 0){
				swal({
					title: 'El insumo no esta activo',
					text: '¿Le gustaría registrarse como futuro proveedor del insumo?',
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "No",
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Si, registrarme",
					closeOnConfirm: true
				}, function(){
					$.ajaxData({
						url: 'index.php/empresas/registrar_proveedor',
						data:{id_insumo:id_insumo},
						method: 'post'
					},function(data){
						if(data.resp){
							swal(data.titulo, data.mensaje, "success");
						}else{
							swal(data.titulo, data.mensaje, "warning");
						}
					});
				});
			}else if(estatus == 1){
				$.ajaxData({
					url: 'index.php/empresas/obtener_insumo',
					data:{id:id_insumo},
					method: 'post'
				},function(data){
					if(data.resp){
						$('#prop-nombre').text(data.datos.nombre);
						$('#prop-espec').text(data.datos.especificacion);
						$('#prop-id').val(data.datos.id);
						$('#modal-propuesta-insumo').modal('show');
						$('#form-propuesta-insumo').off('submit');
						$('#form-propuesta-insumo').submit(function(event){
							event.preventDefault();
							if($.requerido('#prop-propuesta')){
								$.ajaxSerialize($(this),function(data){
									if(data.resp){
										$('#modal-propuesta-insumo').modal('hide');
										swal(data.titulo, data.mensaje, "success");
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
			}
		});
		$('#alianzas .card').click(function(){
			var id_alianza = $(this).data('id');
			$.ajaxData({
				url: 'index.php/empresas/obtener_alianza',
				data:{id:id_alianza},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#modal-propuesta-alianza').find('#prop-empresa').text(data.empresa);
					$('#modal-propuesta-alianza').find('#prop-nombre').text(data.datos.nombre);
					$('#modal-propuesta-alianza').find('#prop-espec').text(data.datos.descripcion);
					$('#modal-propuesta-alianza').find('#prop-id').val(data.datos.id);
					$('#modal-propuesta-alianza').modal('show');
					$('#form-propuesta-alianza').off('submit');
					$('#form-propuesta-alianza').submit(function(event){
						event.preventDefault();
						if($.requerido('#prop-propuesta')){
							$.ajaxSerialize($(this),function(data){
								if(data.resp){
									$('#modal-propuesta-alianza').modal('hide');
									swal(data.titulo, data.mensaje, "success");
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
	/*$.section('#buscar',function(){
		$('.dotdotdot').dotdotdot();
	});*/
	$.section('#proveedores',function(){
		$('[js-proveedores]').click(function(){
			var id_insumo = $(this).attr('js-proveedores');
			$.ajaxData({
				url: 'index.php/empresas/obtener_proveedores',
				data:{id:id_insumo},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#modal-proveedores').find('.modal-title').text('Listado de proveedores del insumo '+data.datos.insumo.nombre);
					$('#modal-proveedores').find('ul.proveedores').empty();
					$.each(data.datos.proveedores,function(index, value){
						$('#modal-proveedores').find('ul.proveedores').append('<li>'+value.nombre+'<button type="button" data-toggle="tooltip" title="Eliminar proveedor" class="btn btn-primary" js-eliminar="'+value.id+'"><i class="fa fa-times"></i></button></li>');
					});
					$('[data-toggle="tooltip"]').tooltip();
					$('#modal-proveedores').modal('show');
					$(document).off('click','[js-eliminar]');
					$(document).on('click','[js-eliminar]',function(){
						var empresa = $(this).attr('js-eliminar'),
							element = $(this).closest('li');
						swal({
							title: '¿Esta seguro de eliminar el proveedor?',
							text: 'Se eliminaran todas las propuestas activas de ese proveedor',
							type: "warning",
							showCancelButton: true,
							cancelButtonText: "No",
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "Si, eliminar",
							closeOnConfirm: true
						}, function(){
							$.ajaxData({
								url: 'index.php/empresas/eliminar_proveiduria',
								data:{id:empresa},
								method: 'post'
							},function(data){
								if(data.resp){
									swal(data.titulo, data.mensaje, "success");
									element.remove();
									var proveedores = $('ul.proveedores > li').length;
									if(proveedores == 0){
										$('#modal-proveedores').modal('hide');
										$('#insumos > .item').each(function(){
											if(id_insumo == $(this).data('insumo')){
												$(this).remove();
											}
										});
									}
								}else{
									swal(data.titulo, data.mensaje, "warning");
								}
							});
						});
					});
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
	});
	$.section('#propuestas',function(){
		var tipo_p = '';
		tipo_p = $('#tipo-p').val();
		$('.propuestas-r > .item').click(function(){
			var id_propuesta = $(this).data('id')
				tipo = $(this).data('tipo');
			if(tipo == 'insumo'){
				$.ajaxData({
						url: 'index.php/empresas/obtener_propuesta',
						data:{id:id_propuesta},
						method: 'post'
					},function(data){
						if(data.resp){
							$('#emp-nombre').text(data.datos.empresa.nombre);
							$('#emp-ciudad').text(data.datos.empresa.ciudad);
							$('#emp-desc').text(data.datos.empresa.descripcion);

							$('#ins-nombre').text(data.datos.insumo.nombre);
							$('#ins-esp').text(data.datos.insumo.especificacion);

							$('#prop-fecha').text(moment(data.datos.propuesta.fecha).format('ll'));
							$('#prop-prop').text(data.datos.propuesta.propuesta);

							if(tipo_p == 'aceptadas'){
								$('.acept').show();
								$('#con-nombre').text(data.datos.empresa.contacto);
								$('#con-tel').text(data.datos.empresa.telefono);
								$('#con-email').text(data.datos.empresa.email);
							}

							$('[js-declinar]').attr('js-declinar',data.datos.propuesta.id);
							$('[js-aceptar]').attr('js-aceptar',data.datos.propuesta.id);
							$('#modal-propuesta').modal('show');
						}else{
							swal(data.titulo, data.mensaje, "warning");
						}
					}
				);
			}else if(tipo == 'alianza'){
				$.ajaxData({
						url: 'index.php/empresas/obtener_propuesta_a',
						data:{id:id_propuesta},
						method: 'post'
					},function(data){
						if(data.resp){
							$('#aemp-nombre').text(data.datos.empresa.nombre);
							$('#aemp-ciudad').text(data.datos.empresa.ciudad);
							$('#aemp-desc').text(data.datos.empresa.descripcion);

							$('#ains-nombre').text(data.datos.alianza.nombre);
							$('#ains-esp').text(data.datos.alianza.descripcion);

							$('#aprop-fecha').text(moment(data.datos.propuesta.fecha).format('ll'));
							$('#aprop-prop').text(data.datos.propuesta.propuesta);

							if(tipo_p == 'aceptadas'){
								$('.acept').show();
								$('#acon-nombre').text(data.datos.empresa.contacto);
								$('#acon-tel').text(data.datos.empresa.telefono);
								$('#acon-email').text(data.datos.empresa.email);
							}

							$('[js-declinar-a]').attr('js-declinar-a',data.datos.propuesta.id);
							$('[js-aceptar-a]').attr('js-aceptar-a',data.datos.propuesta.id);
							$('#modal-propuesta-a').modal('show');
						}else{
							swal(data.titulo, data.mensaje, "warning");
						}
					}
				);
			}
		});
		$('.propuestas-e > .item').click(function(){
			var id_propuesta = $(this).data('id'),
				tipo = $(this).data('tipo');
			if(tipo == 'insumo'){
				$.ajaxData({
						url: 'index.php/empresas/obtener_mi_propuesta',
						data:{id:id_propuesta},
						method: 'post'
					},function(data){
						if(data.resp){
							$('#m-emp-nombre').text(data.datos.empresa.nombre);
							$('#m-emp-ciudad').text(data.datos.empresa.ciudad);
							$('#m-emp-desc').text(data.datos.empresa.descripcion);

							$('#m-ins-nombre').text(data.datos.insumo.nombre);
							$('#m-ins-esp').text(data.datos.insumo.especificacion);

							$('#m-prop-fecha').text(moment(data.datos.propuesta.fecha).format('ll'));
							$('#m-prop-prop').text(data.datos.propuesta.propuesta);

							if(tipo_p == 'aceptadas'){
								$('.acept').show();
								$('#con-nombre').text(data.datos.empresa.contacto);
								$('#con-tel').text(data.datos.empresa.telefono);
								$('#con-email').text(data.datos.empresa.email);
							}

							$('[js-eliminar]').attr('js-eliminar',data.datos.propuesta.id);
							$('#modal-mi-propuesta').modal('show');
						}else{
							swal(data.titulo, data.mensaje, "warning");
						}
					}
				);
			}else if(tipo == 'alianza'){
				$.ajaxData({
						url: 'index.php/empresas/obtener_mi_alianza',
						data:{id:id_propuesta},
						method: 'post'
					},function(data){
						if(data.resp){
							$('#am-emp-nombre').text(data.datos.empresa.nombre);
							$('#am-emp-ciudad').text(data.datos.empresa.ciudad);
							$('#am-emp-desc').text(data.datos.empresa.descripcion);

							$('#am-ins-nombre').text(data.datos.alianza.nombre);
							$('#am-ins-esp').text(data.datos.alianza.descripcion);

							$('#am-prop-fecha').text(moment(data.datos.propuesta.fecha).format('ll'));
							$('#am-prop-prop').text(data.datos.propuesta.propuesta);

							if(tipo_p == 'aceptadas'){
								$('.acept').show();
								$('#acon-nombre').text(data.datos.empresa.contacto);
								$('#acon-tel').text(data.datos.empresa.telefono);
								$('#acon-email').text(data.datos.empresa.email);
							}

							$('[js-eliminar-a]').attr('js-eliminar-a',data.datos.propuesta.id);
							$('#modal-mi-propuesta-a').modal('show');
						}else{
							swal(data.titulo, data.mensaje, "warning");
						}
					}
				);
			}
		});
		$('[js-declinar]').click(function(){
			$('#dec-id').val($(this).attr('js-declinar'));
			$('#modal-declinar-propuesta').modal('show');
		});
		$('[js-aceptar]').click(function(){
			$('#acep-id').val($(this).attr('js-aceptar'));
			$('#modal-aceptar-propuesta').modal('show');
		});
		$('[js-declinar-a]').click(function(){
			$('#adec-id').val($(this).attr('js-declinar-a'));
			$('#modal-declinar-propuesta-a').modal('show');
		});
		$('[js-aceptar-a]').click(function(){
			$('#aacep-id').val($(this).attr('js-aceptar-a'));
			$('#modal-aceptar-propuesta-a').modal('show');
		});
		$('#form-declinar-propuesta').submit(function(event){
			event.preventDefault();
			var id_propuesta = $('#dec-id').val();
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					$('.modal').modal('hide');
					swal(data.titulo, data.mensaje, "success");
					$('.propuestas-r > .item').each(function(){
						if($(this).data('tipo') == 'insumo' && id_propuesta == $(this).data('id')){
							$(this).remove();
						}
					})
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#form-aceptar-propuesta').submit(function(event){
			event.preventDefault();
			var id_propuesta = $('#acep-id').val();
			if($.requerido('#a-mensaje')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('.modal').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						$('.propuestas-r > .item').each(function(){
							if($(this).data('tipo') == 'insumo' && id_propuesta == $(this).data('id')){
								$(this).remove();
							}
						})
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('#form-declinar-propuesta-a').submit(function(event){
			event.preventDefault();
			var id_propuesta = $('#adec-id').val();
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					$('.modal').modal('hide');
					swal(data.titulo, data.mensaje, "success");
					$('.propuestas-r > .item').each(function(){
						if($(this).data('tipo') == 'alianza' && id_propuesta == $(this).data('id')){
							$(this).remove();
						}
					})
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#form-aceptar-propuesta-a').submit(function(event){
			event.preventDefault();
			var id_propuesta = $('#aacep-id').val();
			if($.requerido('#aa-mensaje')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('.modal').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						$('.propuestas-r > .item').each(function(){
							if($(this).data('tipo') == 'alianza' && id_propuesta == $(this).data('id')){
								$(this).remove();
							}
						})
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
		$('[js-eliminar]').click(function(){
			var propuesta = $(this).attr('js-eliminar');
			swal({
				title: '¿Esta seguro de eliminar la propuesta?',
				text: '',
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "No",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: true
			}, function(){
				$.ajaxData({
					url: 'index.php/empresas/eliminar_propuesta',
					data:{id:propuesta},
					method: 'post'
				},function(data){
					if(data.resp){
						$('#modal-mi-propuesta').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						$('.propuestas-e > .item').each(function(){
							if($(this).data('tipo') == 'insumo' && propuesta == $(this).data('id')){
								$(this).remove();
							}
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
		$('[js-eliminar-a]').click(function(){
			var propuesta = $(this).attr('js-eliminar-a');
			swal({
				title: '¿Esta seguro de eliminar la propuesta?',
				text: '',
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "No",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, eliminar",
				closeOnConfirm: true
			}, function(){
				$.ajaxData({
					url: 'index.php/empresas/eliminar_propuesta_a',
					data:{id:propuesta},
					method: 'post'
				},function(data){
					if(data.resp){
						$('#modal-mi-propuesta-a').modal('hide');
						swal(data.titulo, data.mensaje, "success");
						$('.propuestas-e > .item').each(function(){
							if($(this).data('tipo') == 'alianza' && propuesta == $(this).data('id')){
								$(this).remove();
							}
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
	});
	$.section('#notificacion',function(){
		$('[js-declinar]').click(function(){
			$('#dec-id').val($(this).attr('js-declinar'));
			$('#modal-declinar-propuesta').modal('show');
		});
		$('[js-aceptar]').click(function(){
			$('#acep-id').val($(this).attr('js-aceptar'));
			$('#modal-aceptar-propuesta').modal('show');
		});
		$('#form-declinar-propuesta').submit(function(event){
			event.preventDefault();
			var id_propuesta = $('#dec-id').val();
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					$('.modal').modal('hide');
					swal({
						title: data.titulo,
						text: data.mensaje,
						type: "success",
						showCancelButton: false,
						cancelButtonText: "No",
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Ok",
						closeOnConfirm: true
					},function(){
						window.location.href = 'index.php/empresas/propuestas';
					});
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#form-aceptar-propuesta').submit(function(event){
			event.preventDefault();
			var id_propuesta = $('#acep-id').val();
			if($.requerido('#a-mensaje')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('.modal').modal('hide');
						swal({
							title: data.titulo,
							text: data.mensaje,
							type: "success",
							showCancelButton: false,
							cancelButtonText: "No",
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "Ok",
							closeOnConfirm: true
						},function(){
							window.location.href = 'index.php/empresas/propuestas';
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
	});
	$.section('#empresas-insumo',function(){
		$('[js-propuesta]').click(function(){
			var id_insumo = $(this).attr('js-propuesta');
			$.ajaxData({
				url: 'index.php/empresas/obtener_insumo',
				data:{id:id_insumo},
				method: 'post'
			},function(data){
				if(data.resp){
					$('#prop-empresa').text(data.empresa);
					$('#prop-nombre').text(data.datos.nombre);
					$('#prop-espec').text(data.datos.especificacion);
					$('#prop-id').val(data.datos.id);
					$('#modal-propuesta-insumo').modal('show');
					$('#form-propuesta-insumo').off('submit');
					$('#form-propuesta-insumo').submit(function(event){
						event.preventDefault();
						if($.requerido('#prop-propuesta')){
							$.ajaxSerialize($(this),function(data){
								if(data.resp){
									$('#modal-propuesta-insumo').modal('hide');
									swal(data.titulo, data.mensaje, "success");
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
		$('[js-proveedor]').click(function(){
			var id_insumo = $(this).attr('js-proveedor');
			swal({
				title: 'Registrarse como proveedor',
				text: '¿Le gustaría registrarse como futuro proveedor del insumo?',
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "No",
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si, registrarme",
				closeOnConfirm: true
			}, function(){
				$.ajaxData({
					url: 'index.php/empresas/registrar_proveedor',
					data:{id_insumo:id_insumo},
					method: 'post'
				},function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			});
		});
	});
	$.section('#notificacion-2',function(){
		$('#notificacion-2').submit(function(event){
			event.preventDefault();
			if($.requerido('#prop-propuesta')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
	});
	$.section('#notificacion-a',function(){
		$('[js-declinar]').click(function(){
			$('#adec-id').val($(this).attr('js-declinar'));
			$('#modal-declinar-propuesta-a').modal('show');
		});
		$('[js-aceptar]').click(function(){
			$('#aacep-id').val($(this).attr('js-aceptar'));
			$('#modal-aceptar-propuesta-a').modal('show');
		});
		$('#form-declinar-propuesta-a').submit(function(event){
			event.preventDefault();
			var id_propuesta = $('#adec-id').val();
			$.ajaxSerialize($(this),function(data){
				if(data.resp){
					$('.modal').modal('hide');
					swal({
						title: data.titulo,
						text: data.mensaje,
						type: "success",
						showCancelButton: false,
						cancelButtonText: "No",
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Ok",
						closeOnConfirm: true
					},function(){
						window.location.href = 'index.php/empresas/propuestas';
					});
				}else{
					swal(data.titulo, data.mensaje, "warning");
				}
			});
		});
		$('#form-aceptar-propuesta-a').submit(function(event){
			event.preventDefault();
			var id_propuesta = $('#aacep-id').val();
			if($.requerido('#aa-mensaje')){
				$.ajaxSerialize($(this),function(data){
					if(data.resp){
						$('.modal').modal('hide');
						swal({
							title: data.titulo,
							text: data.mensaje,
							type: "success",
							showCancelButton: false,
							cancelButtonText: "No",
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "Ok",
							closeOnConfirm: true
						},function(){
							window.location.href = 'index.php/empresas/propuestas';
						});
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
	});
	$.section('#v-perfil-empresa',function(){
		$('form input, form select, form textarea').each(function(){
			if($(this).val() != ''){
				$(this).closest('.fg-line').addClass('fg-toggled');
			}
		});
		var ban_logo = false;
		$('#btn-emp-logo').click(function(){
			$('#emp-logo').click();
		});
		$("#emp-logo").change(function(){
			if (this.files && this.files[0]) {
				if(this.files[0].size < 2*1048576){
					var reader = new FileReader();
					reader.onload = function (e) {
						$('.logo > img').attr('src', e.target.result);
					}
					reader.readAsDataURL(this.files[0]);
					ban_logo = true;
				}else{
					$("#emp-logo").val('');
					$('.logo > img').attr('src','');
					ban_logo = false;
					swal('Imagen muy grande', 'La imagen no debe de ser mayor a 2 MB', "warning");
				}
			}
		});
		$('input[name="empresa[comision]"]').change(function(){
			if($(this).val() == 1){
				$('#com-entrada').show();
			}else{
				$('#com-entrada').hide();
			}
		});
		$('#v-perfil-empresa').submit(function(event){
			event.preventDefault();
			var bandera = true,
				nombre = $.requerido('#emp-nombre')
				desc = $.requerido('#emp-desc')
				ciudad = $.requerido('#emp-ciudad')
				estado = $.requerido('#emp-estado')
				giro = $.requerido('#emp-giro')
				tamano = $.requerido('#emp-tamano')
				contacto = $.requerido('#emp-cont')
				tel = $.requerido('#emp-tel')
				email = $.requerido('#emp-email');
			if($('#com-si').is(':checked')){
				bandera = $.requerido('#com_val');
			}
			if(bandera && nombre && desc && ciudad && estado && giro && tamano && contacto && tel && email){
				$.ajaxFormData($(this),function(data){
					if(data.resp){
						swal(data.titulo, data.mensaje, "success");
					}else{
						swal(data.titulo, data.mensaje, "warning");
					}
				});
			}
		});
	});
});