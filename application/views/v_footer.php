            </div>
            </section>
        </section>
    </body>
</html>
<script src="statics/template/js/bootstrap.min.js"></script>
<script src="statics/template/vendors/flot/jquery.flot.min.js"></script>
<script src="statics/template/vendors/flot/jquery.flot.resize.min.js"></script>
<script src="statics/template/vendors/flot/plugins/curvedLines.js"></script>
<script src="statics/template/vendors/sparklines/jquery.sparkline.min.js"></script>
<script src="statics/template/vendors/easypiechart/jquery.easypiechart.min.js"></script>
<script src="statics/template/vendors/simpleWeather/jquery.simpleWeather.min.js"></script>
<script src="statics/template/vendors/auto-size/jquery.autosize.min.js"></script>
<script src="statics/template/vendors/nicescroll/jquery.nicescroll.min.js"></script>
<script src="statics/template/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
<script src="statics/template/vendors/sweet-alert/sweet-alert.min.js"></script>
<script src="statics/template/js/flot-charts/curved-line-chart.js"></script>
<script src="statics/template/js/flot-charts/line-chart.js"></script>
<script src="statics/template/js/charts.js"></script>
<script src="statics/template/vendors/waves/waves.min.js"></script>
<script src="statics/template/js/functions.js"></script>
<script>
/*$(document).ready(function(){
	$('#modal-perfil').modal('show');
	if(Notification.permission !== "granted") {
		Notification.requestPermission()
	}

	$('.modal').on('hidden.bs.modal',function(){
		$('html').getNiceScroll().resize();
		$('.sidebar-inner').getNiceScroll().resize();
	});

	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-63615829-1', 'auto');
	ga('send', 'pageview');

	$('.borrarNoti').click(function(e){
		e.preventDefault();
		$.ajax({
			url: 'index.php/notificaciones/update_all',
			type: 'POST',
			async: true,
			dataType: 'json',
			timeout: 3000,
			success: function(data){
				if(data){
					$('.notificacion, .lv-body.c-overflow.n-none').remove();
					var html = '<div class="lv-body c-overflow n-none">'+
									'<img src="statics/img/icons/aldia.png" alt="" />'+
								'</div>';
		           	$('.noti-header').after(html);
					$('.n-count').text('0');
				}
			}
		});
	});
	$('.noti-even').click(function(e){
		e.preventDefault();
		var id = $(this).parents('.notificacion').data('id');
		var url = $(this).parents('.notificacion').data('url');
		$.ajax({
			url: 'index.php/notificaciones/update',
			type: 'POST',
			async: true,
			data: {id:id},
			dataType: 'json',
			timeout: 3000,
			success: function(data){
				if(data){
					window.location = url;
				}
			}
		});
	});
	setInterval(function(){
		$.ajax({
			url: 'index.php/notificaciones/get',
			type: 'POST',
			async: true,
			dataType: 'json',
			timeout: 3000,
			success: function(data){
				if(data.noti){
					$.each(data.notificaciones,function(index,value){
						notificacion(value.titulo,value.texto,value.idnoti,value.url,value.idnoti);
					});
	           	}
	           	if(data.wnoti){
	           		$.each(data.web,function(index,value){
	           			var existe = false;
	           			if($('.notificacion').length == 0){
	           				$('.n-none').remove();
	           			}
	           			if($('.notificacion').length > 0){
			           		$('.notificacion').each(function(){
			           			if(value.idnoti == $(this).data('id')){
			           				existe = true;
			           			}
			           		});
			           	}
		           		if(!existe){
		           			var html = '<div class="lv-body c-overflow notificacion" data-id="'+value.idnoti+'">'+
		                                    '<a class="noti-even lv-item" name="'+value.idnoti+'" href="'+value.url+'" >'+
		                                        '<div class="media">'+
		                                            '<div class="media-body">'+
		                                                '<div class="lv-title col-lg-5 pull-left p-l-0">'+value.titulo+'</div>'+
		                                                '<i class="c-red fa fa-bell-o pull-right" style="font-size: 15px;"></i>'+
		                                                '<small class="lv-small">'+value.texto+'</small>'+
		                                            '</div>'+
		                                        '</div>'+
		                                    '</a>'+
		                                '</div>';
		           			$('.noti-header').after(html);
		           			$('.n-count').text(parseInt($('.n-count').text())+1);
		           		}
	           		});
	           	}
			}
		});
	},60000);
});*/
/*function notificacion(titulo,texto,id,url,idN){
	if (Notification) {
		if(Notification.permission !== "granted") {
			Notification.requestPermission();
		}
		var title = titulo;
		var extra = {
			icon: "https://cdn2.iconfinder.com/data/icons/amazon-aws-stencils/100/Deployment__Management_copy_AWS_CloudFormation_Template-256.png",
			body: texto
		};
		var noti = new Notification(title, extra);
		noti.onclick = function(){
			window.open(url, '_blank');
		}
		noti.onclose = function(){
		// Al cerrar
		}
		setTimeout(function(){
			noti.close();
		}, 30000);
	}
}*/
</script>
