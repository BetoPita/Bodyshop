$(document).ready(function(){
	$('html').on({
		dragenter: function(e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).css('background-color', 'lightBlue');
		},dragleave: function(e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).css('background-color', 'white');
		},drop: function(e) {
			e.preventDefault();
			e.stopPropagation();
		}
	});
	$('#content > .container').removeClass('container').addClass('container-fluid');
	$('[data-modal]').click(function(){
		$($(this).attr('data-modal')).modal('show');
	});
	if ($('.date-time-picker')[0]) {
	   $('.date-time-picker').datetimepicker();
	}
	$(document).on('click','[data-link]',function(){
		window.location.href = $(this).attr('data-link');
	});
	if($('.sortable')[0]){
		$('.sortable').sortable();
	}
	if($('.touchspin')[0]){
		$('.touchspin').TouchSpin({
			min: 1,
			max: 9999999,
			buttondown_class: "btn btn-link",
            buttonup_class: "btn btn-link"
		});
		$('.bootstrap-touchspin-down').html('<i class="fa fa-minus"></i>');
		$('.bootstrap-touchspin-up').html('<i class="fa fa-plus"></i>');
		$('.modal').on('show.bs.modal',function(){
			$('.touchspin').val('0');
			$('.touchspin').closest('.fg-line').addClass('fg-toggled');
		});
	}
	if($('.touchspin-decimales')[0]){
		$('.touchspin-decimales').TouchSpin({
			min: 0,
			max: 9999999,
			decimals: 2,
			step: 0.01,
			buttondown_class: "btn btn-link",
            buttonup_class: "btn btn-link"
		});
		$('.bootstrap-touchspin-down').html('<i class="fa fa-minus"></i>');
		$('.bootstrap-touchspin-up').html('<i class="fa fa-plus"></i>');
		$('.modal').on('show.bs.modal',function(){
			$('.touchspin-decimales').val('0.00');
			$('.touchspin-decimales').closest('.fg-line').addClass('fg-toggled');
		});
	}
	if($('.editor-airmod-lite')[0]){
		$('.editor-airmod-lite').summernote({
			lang: 'es-ES',
			disableDragAndDrop: true,
			placeholder: 'Aquí puedes escribir...',
			airMode: true,
			popover: {
			  air: [
			    ['color', ['color']],
			    ['font', ['bold', 'underline']],
			    ['para', ['ul', 'paragraph']],
			  ]
			}
		});
		$('.note-insert, .note-table, .note-para > button:nth-child(2), .note-font > button:nth-child(3), .note-color').hide();
	}
	$('.iconpicker').iconpicker({
		align: 'center',
		arrowPrevIconClass: 'fa fa-chevron-left',
		arrowNextIconClass: 'fa fa-chevron-right',
		iconset: 'fontawesome',
		search: false,
		footer: false,
		cols: 6,
		rows: 6
	});
	$('input, textarea').keyup(function(){
		$(this).closest('.form-group').removeClass('has-error');
	});
	$('select').change(function(){
		$(this).closest('.form-group').removeClass('has-error');
	});
	$('textarea').autogrow({onInitialize: true});
	$('.modal').on('hide.bs.modal',function(){
		var modal = $(this),
			form = $(this).find('form');
		modal.find('.alert-warning').hide();
		modal.find('.alert-danger').hide();
		form.trigger('reset');
		form.find('.form-group').removeClass('has-error');
		form.find('.fg-line').removeClass('fg-toggled');
	});
	$('.fecha').each(function(){
		if($(this).text() != ''){
			$(this).text(moment($(this).text()).format('ll'));
		}
	});
	$('.fecha-time').each(function(){
		if($(this).text() != ''){
			$(this).text(moment($(this).text()).format('lll'));
		}
	});
	$('img').error(function(){
		$(this).attr('src','statics/img/imagen-no-disponible.gif');
	})
	$.ajaxSerialize = function(form,callback){
		$.ajax({
			url: form.attr('action'),
			type: form.attr('method'),
			async: true,
			data: form.serialize(),
			dataType: 'json',
			timeout: 4000,
			beforeSend: function(){
				$('.s-loading').show();
				form.find('button:submit').prop('disabled',true);
			},complete:function(){
				$('.s-loading').hide();
				form.find('button:submit').prop('disabled',false);
			},error: function(jqXHR, exception){
				ajaxError(jqXHR, exception);
			},success: function(data){
				if(ajaxSuccess(data)){
					callback(data);
				}
			}
		});
	}
	$.ajaxFormData = function(form,callback){
		var formData = new FormData(form[0]);
		$.ajax({
			url: form.attr('action'),
			type: form.attr('method'),
			async: true,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			timeout: 10000,
			beforeSend: function(){
				$('.s-loading').show();
				form.find('button:submit').prop('disabled',true);
			},complete:function(){
				$('.s-loading').hide();
				form.find('button:submit').prop('disabled',false);
			},error: function(jqXHR, exception){
				ajaxError(jqXHR, exception);
			},success: function(data){
				if(ajaxSuccess(data)){
					callback(data);
				}
			}
		});
	}
	$.ajaxData = function(datos,callback){
		$.ajax({
			url: datos.url,
			type: datos.method,
			async: true,
			data: datos.data,
			dataType: 'json',
			timeout: 4000,
			beforeSend: function(){
				$('.s-loading').show();
			},complete:function(){
				$('.s-loading').hide();
			},error: function(jqXHR, exception){
				ajaxError(jqXHR, exception);
			},success: function(data){
				if(ajaxSuccess(data)){
					callback(data);
				}
			}
		});
	}
	$.requerido = function(target){
		if($(target).is(':visible')){
			if($(target).val().trim() == ''){
				$(target).closest('.form-group').addClass('has-error');
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	$.section = function(target,callback){
		if($(target)[0]){
			callback();
		}
	}
});
function ajaxError(jqXHR, exception){
	var msg = '';
	if (jqXHR.status === 0) {
		msg = 'Not connect.\n Verify Network.';
	} else if (jqXHR.status == 404) {
		msg = 'Requested page not found. [404]';
	} else if (jqXHR.status == 500) {
		msg = 'Internal Server Error [500].';
	} else if (exception === 'parsererror') {
		msg = 'Requested JSON parse failed.';
	} else if (exception === 'timeout') {
		msg = 'Time out error.';
	} else if (exception === 'abort') {
		msg = 'Ajax request aborted.';
	} else {
		msg = 'Uncaught Error.\n' + jqXHR.responseText;
	}
	swal({
		title: "Ocurrió un error",
		text: msg,
		type: "warning",
		showCancelButton: false,
		cancelButtonText: "Cancelar",
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Cerrar",
		closeOnConfirm: true
	});
	console.log(msg);
}
function ajaxSuccess(data){
	if(typeof data.error_code !== 'undefined'){
		var mensaje = '',
		title = '',
		error;
		if(data.error_code == 'sess_no_valida'){
			title = 'Sesión caducada';
			mensaje = 'Su sesión caduco, vuelva a iniciar sesión';
			error = 1;
		}else if(data.error_code == 'no_ajax_request'){
			title = 'Acceso denegado';
			mensaje = 'La operación no se pudo completar';
			error = 2;
		}
		swal({
			title: title,
			text: mensaje,
			type: "warning",
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "OK",
			closeOnConfirm: true
		}, function(){
			if(error == 1){
				window.location.href = 'index.php/inicio/iniciar';
			}
		});
		return false;
	}else{
		return true;
	}
}
function setModalMaxHeight(element) {
	this.$element     = $(element);
	this.$content     = this.$element.find('.modal-content');
	var borderWidth   = this.$content.outerHeight() - this.$content.innerHeight();
	var dialogMargin  = $(window).width() < 768 ? 20 : 60;
	var contentHeight = $(window).height() - (dialogMargin + borderWidth);
	var headerHeight  = this.$element.find('.modal-header').outerHeight() || 0;
	var footerHeight  = this.$element.find('.modal-footer').outerHeight() || 0;
	var maxHeight     = contentHeight;

	this.$content.css({
	  'overflow': 'hidden'
	});

	this.$element
	.find('.modal-content').css({
	  'max-height': maxHeight,
	  'overflow-y': 'hidden'
	});
}
;(function($){
	//pass in just the context as a $(obj) or a settings JS object
	$.fn.autogrow = function(opts) {
		var that = $(this).css({overflow: 'hidden', resize: 'none'}) //prevent scrollies
			, selector = that.selector
			, defaults = {
				context: $(document) //what to wire events to
				, animate: true //if you want the size change to animate
				, speed: 200 //speed of animation
				, fixMinHeight: true //if you don't want the box to shrink below its initial size
				, cloneClass: 'autogrowclone' //helper CSS class for clone if you need to add special rules
				, onInitialize: false //resizes the textareas when the plugin is initialized
			}
		;
		opts = $.isPlainObject(opts) ? opts : {context: opts ? opts : $(document)};
		opts = $.extend({}, defaults, opts);
		that.each(function(i, elem){
			var min, clone;
			elem = $(elem);
			//if the element is "invisible", we get an incorrect height value
			//to get correct value, clone and append to the body.
			if (elem.is(':visible') || parseInt(elem.css('height'), 10) > 0) {
				min = parseInt(elem.css('height'), 10) || elem.innerHeight();
			} else {
				clone = elem.clone()
					.addClass(opts.cloneClass)
					.val(elem.val())
					.css({
						position: 'absolute'
						, visibility: 'hidden'
						, display: 'block'
					})
				;
				$('body').append(clone);
				min = clone.innerHeight();
				clone.remove();
			}
			if (opts.fixMinHeight) {
				elem.data('autogrow-start-height', min); //set min height
			}
			elem.css('height', min);

			if (opts.onInitialize && elem.length) {
				resize.call(elem[0]);
			}
		});
		opts.context
			.on('keyup paste', selector, resize)
		;

		function resize (e){
			var box = $(this)
				, oldHeight = box.innerHeight()
				, newHeight = this.scrollHeight
				, minHeight = box.data('autogrow-start-height') || 0
				, clone
			;
			if (oldHeight < newHeight) { //user is typing
				this.scrollTop = 0; //try to reduce the top of the content hiding for a second
				opts.animate ? box.stop().animate({height: newHeight}, opts.speed) : box.innerHeight(newHeight);
			} else if (!e || e.which == 8 || e.which == 46 || (e.ctrlKey && e.which == 88)) { //user is deleting, backspacing, or cutting
				if (oldHeight > minHeight) { //shrink!
					//this cloning part is not particularly necessary. however, it helps with animation
					//since the only way to cleanly calculate where to shrink the box to is to incrementally
					//reduce the height of the box until the $.innerHeight() and the scrollHeight differ.
					//doing this on an exact clone to figure out the height first and then applying it to the
					//actual box makes it look cleaner to the user
					clone = box.clone()
						//add clone class for extra css rules
						.addClass(opts.cloneClass)
						//make "invisible", remove height restriction potentially imposed by existing CSS
						.css({position: 'absolute', zIndex:-10, height: ''})
						//populate with content for consistent measuring
						.val(box.val())
					;
					box.after(clone); //append as close to the box as possible for best CSS matching for clone
					do { //reduce height until they don't match
						newHeight = clone[0].scrollHeight - 1;
						clone.innerHeight(newHeight);
					} while (newHeight === clone[0].scrollHeight);
					newHeight++; //adding one back eliminates a wiggle on deletion
					clone.remove();
					box.focus(); // Fix issue with Chrome losing focus from the textarea.

					//if user selects all and deletes or holds down delete til beginning
					//user could get here and shrink whole box
					newHeight < minHeight && (newHeight = minHeight);
					oldHeight > newHeight && opts.animate ? box.stop().animate({height: newHeight}, opts.speed) : box.innerHeight(newHeight);
				} else { //just set to the minHeight
					box.innerHeight(minHeight);
				}
			}
		}
		return that;
	}
})(jQuery);