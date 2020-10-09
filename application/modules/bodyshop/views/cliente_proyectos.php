<?php

$notificaciones = $this->principal->getNotificaciones();

$notificaciones_cronogramas = $this->principal->getCronogramas();
$aux1 = $this->principal->get_sucu_id_user($this->session->userdata('id'));
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="-1">

    <title>Ford Plasencia</title>

    <link href="<?php echo base_url();?>statics/css/tema/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url();?>statics/css/tema/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/timeline.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/clockpicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/c3.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/custom/jquery.dataTables.min.css" rel="stylesheet">
    <?php echo link_tag('statics/css/jquery.confirm.css'); ?>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'statics/js/libraries/confirm.jquery.js'; ?>"></script>
    <script src="<?php echo base_url();?>/statics/css/tema/js/plugins/Dynatable/jquery.dynatable.js "></script>
    <script src="<?php echo base_url();?>/statics/js/modules/jquery.maskMoney.js"></script>

    <script src="<?php echo base_url();?>/statics/js/modules/jquery.mask.min.js"></script>
    <script src="<?php echo base_url();?>/statics/js/modules/jspdf.min.js"></script>
    <script src="<?php echo base_url();?>/statics/js/custom/moment.js"></script>
    <script src="<?php echo base_url();?>/statics/js/custom/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo base_url();?>/statics/js/custom/clockpicker.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/jquery.numeric.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/general.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/jquery.dataTables.min.js"></script>
    <?php if(isset($included_js)): ?>
        <?php foreach($included_js as $files_js): ?>
            <script type="text/javascript" src="<?php echo base_url().$files_js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

        <script>
         $(document).ready(function(){
           $("body").on('click','.navbar-minimalize',function(e){
                e.preventDefault();
                if($("body").hasClass('mini-navbar')){
                    $("body").removeClass('mini-navbar');
                }else{
                    $("body").addClass('mini-navbar');
                }
            });
          $( '#side-menu li' ).addClass( 'menu-items' );
          $(' #side-menu li a ').click(function(){
                $(this).parent().css("background-color", "#1ab394");
            });
      });
    </script>

    <style>

        #side-menu li a{
        padding:20px;
        padding-bottom:10px;
    
        color:#ffffff;
        text-decoration:none;
    }#side-menu li a:hover{
            background-color:#1ab394;
        color:white;
    }
    #side-menu .active{
         background-color:#0000ff;
         color:white;

    }



    </style>

</head>

<body>

    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">
                                    <?php echo ($this->session->userdata('idcliente')) != '' ? $this->session->userdata('nombre_cliente') :''; ?>
                                        
                                    </strong>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url()?>index.php/login/logout">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                        </div>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>index.php/bodyshop/proyectos"><i class="fa fa-diamond"></i> <span class="nav-label">Proyectos</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary "><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="<?php echo base_url()?>index.php/login/logout">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>
            </nav>    
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-sm-12 b-r">
                                            <?php if(isset($content)): ?>
                                                    <?php echo $content; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mainly scripts -->

    <script src="<?php echo base_url();?>statics/css/tema/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>statics/css/tema/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    
    <script>
    $(document).ready(function(){
         var site_url = "<?php echo site_url() ?>";
    	$('#modal-perfil').modal('show');
    	if(Notification.permission !== "granted") {
    		Notification.requestPermission()
    	}

      $('.noti-even').click(function(e){
    		e.preventDefault();
    		var id = $(this).parents('.notificacion').data('id');
    		var url = $(this).parents('.notificacion').data('url');
    		$.ajax({
    			url: '<?php echo base_url()?>index.php/notificaciones/update',
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
       $('.noti-even_stock').click(function(e){
            e.preventDefault();
            var id = $(this).parents('.notificacion').data('id');
            var url = $(this).parents('.notificacion').data('url');
             var tabla = $(this).parents('.notificacion').data('tabla');
            $.ajax({
                url: '<?php echo base_url()?>index.php/notificaciones/updateNotiItems',
                type: 'POST',
                async: true,
                data: {id:id,tabla:tabla},
                dataType: 'json',
                timeout: 3000,
                success: function(data){
                    if(data){
                       window.location = site_url+"/notificaciones/lista_notificaciones";
                    }
                }
            });
        });
    	setInterval(function(){
    		$.ajax({
    			url: '<?php echo base_url()?>index.php/notificaciones/get',
    			type: 'POST',
    			async: true,
    			dataType: 'json',
    			timeout: 3000,
    			success: function(data){
                    console.log(data);
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
                        var html = '<li class="notificacion" data-id="'+value.idnoti+'" data-url="'+value.url+'">'+
                                    '<a href="'+value.url+'"    class=" noti-even">'+
                                      '<div>'+
                                        '<i class="fa fa-envelope fa-fw"></i>'+value.titulo+''+
                                        '<span class="pull-right text-muted small">'+value.texto+'</span>'+
                                        '</div>'+
                                    '</a>'+
                                  '</li>';

    		           			$('.noti-header').append(html);

    		           			$('.n-count').text(parseInt($('.n-count').text())+1);
    		           		}
    	           		});
    	           	}
    			}
    		});
    	},60000);

    });
    function notificacion(titulo,texto,id,url,idN){
    	if (Notification) {
    		if(Notification.permission !== "granted") {
    			Notification.requestPermission();
    		}
            console.log('notificacion',titulo);
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
        else
            console.log('No tiene notificacion');
    }
    </script>



</body>

</html>
