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


    <?php echo link_tag('statics/css/jquery.confirm.css'); ?>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'statics/js/libraries/confirm.jquery.js'; ?>"></script>
    <script src="<?php echo base_url();?>/statics/css/tema/js/plugins/Dynatable/jquery.dynatable.js "></script>
    <script src="<?php echo base_url();?>/statics/js/modules/jquery.maskMoney.js"></script>

    <script src="<?php echo base_url();?>/statics/js/modules/jquery.mask.min.js"></script>
    <script src="<?php echo base_url();?>/statics/js/modules/jspdf.min.js"></script>
    <?php if(isset($included_js)): ?>
        <?php foreach($included_js as $files_js): ?>
            <script type="text/javascript" src="<?php echo base_url().$files_js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

        <script>
      $(document).ready(function(){
          
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
                            <img alt="image" class="img-circle" src="<?php echo base_url().imagen_usuario($this->session->userdata('id'));?>" width="50" height="50" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo nombre_usuario($this->session->userdata('id'));?></strong>
                             </span> <span class="text-muted text-xs block">Opciones <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="<?php echo base_url()?>index.php/perfil">Perfil</a></li>
                            <!--li><a href="contacts.html">Contacts</a></li>
                            <li><a href="mailbox.html">Mailbox</a></li-->
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url()?>index.php/login/logout">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        Dharma
                    </div>
                </li>
                <!--li>
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Sucursales</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="<?php echo base_url();?>index.php/sucursales">Crear sucursal</a></li>
                        <li><a href="<?php echo base_url();?>index.php/lista_sucursales">Lista de sucursales</a></li>
                        <li><a href="dashboard_3.html">Asignar</a></li>
                    </ul>
                </li-->
                <?php //if(status_admin($this->session->userdata('id'))==1){?>
                <li>
                    <a href="<?php echo base_url();?>index.php/contactos"><i class="fa fa-diamond"></i> <span class="nav-label">Contactos</span></a>

                </li>
                <?php //}?>


                <li>
                    <a href="<?php echo base_url();?>index.php/prospectos"><i class="fa fa-diamond"></i> <span class="nav-label">Prospectos</span></a>

                </li>



                <li>
                    <a href="<?php echo base_url();?>index.php/proyectos"><i class="fa fa-diamond"></i> <span class="nav-label">Proyectos</span></a>

                </li>


                <?php if($this->session->userdata('adminStatus')==1 ) {?>
                <li>
                    <a href="<?php echo base_url();?>index.php/permisos"><i class="fa fa-diamond"></i> <span class="nav-label">Permisos</span></a>

                </li>
                <?php }?>


                

                <?php if($this->session->userdata('statusPerfil')==4){?>
                <li>
                    <a href="<?php echo base_url();?>index.php/permisos/permisos_gerente"><i class="fa fa-diamond"></i> <span class="nav-label">Permisos usuarios</span></a>

                </li>
                <?php }?>

                <?php if($this->session->userdata('statusPerfil')==1){?>
                <li>
                    <a href="<?php echo base_url();?>index.php/sucursales"><i class="fa fa-diamond"></i> <span class="nav-label">Sucursales</span></a>

                </li>
                <?php }?>

                <?php if($this->session->userdata('statusPerfil')==1 || $this->session->userdata('statusPerfil')==2) {?>
                <li>
                    <a href="<?php echo base_url();?>index.php/usuarios"><i class="fa fa-diamond"></i> <span class="nav-label">Usuarios</span></a>

                </li>
                <?php }?>

                <?php if($this->session->userdata('statusPerfil')==1 || $this->session->userdata('statusPerfil')==2){?>
                <li>
                    <a href="<?php echo base_url();?>index.php/proveedores"><i class="fa fa-diamond"></i> <span class="nav-label">Proveedores</span></a>

                </li>
                <?php }?>

                <?php if($this->session->userdata('statusPerfil')==1){?>
                <li>
                    <a href="<?php echo base_url();?>index.php/servicios"><i class="fa fa-diamond"></i> <span class="nav-label">Servicios</span></a>

                </li>
                <?php }?>

                <?php if($this->session->userdata('statusPerfil')==1 || $this->session->userdata('statusPerfil')==2){?>
                <li>
                    <a href="<?php echo base_url();?>index.php/productos"><i class="fa fa-diamond"></i> <span class="nav-label">Productos</span></a>

                </li>
                <?php }?>



                <?php /*if(status_admin($this->session->userdata('id'))==2){?>
                  <?php if($aux1 !=0){?>
                  <li>
                      <a href="<?php echo base_url();?>index.php/compras/solicitudes/<?php echo $aux1;?>"><i class="fa fa-diamond"></i> <span class="nav-label">Solicitudes de inventario</span></a>

                  </li>
                  <?php }?>
                <?php }*/?>

                <?php if($this->session->userdata('statusPerfil')==2){?>
                  <?php if($aux1 !=0){?>
                <li>
                    <a href="<?php echo base_url();?>index.php/compras/ventas/<?php echo $aux1;?>"><i class="fa fa-diamond"></i> <span class="nav-label">Ventas</span></a>

                </li>
                  <?php }?>
                <?php }?>


                <?php if($this->session->userdata('statusPerfil')==2){?>
                  <?php if($aux1 !=0){?>
                <li>
                    <a href="<?php echo base_url();?>index.php/compras/folios/<?php echo $aux1;?>"><i class="fa fa-diamond"></i> <span class="nav-label">Mis ventas</span></a>

                </li>
                  <?php }?>
                <?php }?>


                <li>
                    <a href="<?php echo base_url();?>index.php/proyectos/mis_numeros"><i class="fa fa-diamond"></i> <span class="nav-label">Contabilidad</span></a>

                </li>


                <?php if($this->session->userdata('statusPerfil')==1){?>
                <li>
                    <a href="<?php echo base_url();?>index.php/compras/facturas"><i class="fa fa-diamond"></i> <span class="nav-label">Generar facturas</span></a>

                </li>
                <?php }?>
                <?php if($this->session->userdata('statusPerfil')==1){?>
                <li>
                    <a href="#"><i class="fa fa-diamond"></i> <span class="nav-label">Facturación electrónica (actualizando)</span></a>

                </li>
                <?php }?>

                <?php if($this->session->userdata('statusPerfil')==1){?>
                <!--li>
                    <a href="<?php echo base_url();?>index.php/vinos/index"><i class="fa fa-diamond"></i> <span class="nav-label">Vinos</span></a>

                </li-->
                <?php }?>

                <?php $us =  $this->principal->get_row("adminId",$this->session->userdata('id'),"admin");?>

                <li>
                    <?php if($us->p_seguros == 1){?>
                     <a href="<?php echo base_url();?>index.php/bitacora_negocios"><i class="fa fa-diamond"></i> <span class="nav-label">Financiamiento y Seguros</span></a>
                    <?php }?>
                </li>

                <li>
                  <?php if($us->p_logistica == 1){?>
                    <a href="<?php echo base_url();?>index.php/logistica"><i class="fa fa-diamond"></i> <span class="nav-label">Logística</span></a>
                  <?php }?>
                </li>

                <li>
                  <?php if($us->p_recepcion == 1){?>
                    <a href="<?php echo base_url();?>index.php/recepcion"><i class="fa fa-diamond"></i> <span class="nav-label">Recepción</span></a>
                  <?php }?>
                </li>

                <!--<li>
                  <?php if($us->p_admin == 1){?>
                    <a href="<?php echo base_url();?>index.php/ventas"><i class="fa fa-diamond"></i> <span class="nav-label">Administración y Ventas</span></a>
                  <?php }?>
                </li>

                <li>
                  <?php if($us->p_facturacion == 1){?>
                    <a href="<?php echo base_url();?>index.php/facturacion"><i class="fa fa-diamond"></i> <span class="nav-label">Facturación</span></a>
                  <?php }?>
                </li>-->
                <li>
                  <?php if($us->p_facturacion == 1){?>
                    <a href="<?php echo base_url();?>index.php/ventas_facturacion"><i class="fa fa-diamond"></i> <span class="nav-label">Ventas y Facturación</span></a>
                  <?php }?>
                </li>
                 <li>
                  <?php if($us->p_facturacion == 1){?>
                    <a href="<?php echo base_url();?>index.php/asesores"><i class="fa fa-diamond"></i> <span class="nav-label">Asesores</span></a>
                  <?php }?>
                </li>
                <li>

                <?php if($us->p_citas == 1 || $this->session->userdata('statusPerfil')==4){?>
                    <a href="<?php echo base_url();?>index.php/operadores"><i class="fa fa-diamond"></i> <span class="nav-label">Citas Servicios</span></a>
                  <?php }?>
                </li>
                <!-- <li>
                    <a target="_blank" href="<?php echo base_url();?>tablero"><i class="fa fa-diamond"></i> <span class="nav-label">Trámites</span></a>
                </li> -->
                <?php if($us->p_oasis == 1 || $this->session->userdata('statusPerfil')==4){?>
                 <li>
                    <a href="<?php echo base_url();?>oasis"><i class="fa fa-diamond"></i> <span class="nav-label">Panel Oasis App</span></a>
                </li>
                <?php }?>
                 


              





            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <!--form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form-->
        </div>
            <ul class="nav navbar-top-links navbar-right">
              <li>
                  <span class="m-r-sm text-muted welcome-message"><a href="<?php echo base_url();?>index.php/tiket">Levantar Ticket</a></span>
              </li>
                <li>
                    <span class="m-r-sm text-muted welcome-message">Ford Plasencia</span>
                </li>






                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa  fa-clock-o"></i>  <span class="label label-warning"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">

                    </ul>
                </li>


                <?php if($this->session->userdata('statusPerfil')==1){
                    $cantidad = count($notificaciones);
                    
                }else{

                    $cantidad = count($notificaciones);
                } 
               
                $cantidad = $cantidad +count($notificaciones_cronogramas);
                ?>



                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" style="background:#ccc">
                      <i class="fa fa-envelope"></i>  <i class="fa fa-bell"></i>  <span class="label label-primary n-count"><?php echo $cantidad ?></span>
                    </a>
                   <ul class="dropdown-menu dropdown-alerts noti-header">
                      <?php if(count($notificaciones) > 0){ ?>
                      <?php foreach ($notificaciones as $n) { ?>
                        <li class="notificacion" data-id="<?php echo $n->idnoti; ?>" data-url="<?php echo $n->url; ?>">
                          <a href="<?php echo $n->url; ?>"    class="noti-even">
                            <div>
                              <i class="fa fa-envelope fa-fw"></i><?php echo $n->titulo ?>
                              <span class="pull-right text-muted small"><?php echo $n->texto; ?></span>
                              </div>
                          </a>
                        </li>
        
                        <?php } } ?>
                       <!-- NOTIFICACIONES DE CRONOGRAMA  -->
                        <?php if(count($notificaciones_cronogramas) > 0 && $this->session->userdata('id')!=''){ 
                            foreach ($notificaciones_cronogramas as $n) { ?>
                            <li class="notificacion" data-id="<?php echo $n->cronoId; ?>" data-url="" data-tabla="cronograma_contacto">
                                <a href="#"  class="noti-even_stock">
                                <div>
                                  <i class="fa fa-envelope fa-fw"></i><?php echo substr($n->cronoTitulo,0,20) ?>
                                  <span class="pull-right text-muted small"><?php echo $n->cronoFecha." ".$n->cronoHora ?></span>
                                  </div>
                              </a>
                            </li>
                        <?php } } ?>

                       <!-- !-->

                    </ul>
                </li>



                <li>
                    <a href="<?php echo base_url()?>index.php/login/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <!--div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Crear proyecto</h2>

                </div>
            </div-->

        <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">


            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12 b-r"><!--h3 class="m-t-none m-b">Sign in</h3-->

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
        <!--div class="footer">
            <div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Planificador Empresarial &copy; 2016
            </div>
        </div-->

        </div>
        </div>

    <!-- Mainly scripts -->

    <script src="<?php echo base_url();?>statics/css/tema/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>statics/css/tema/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <!--script src="<?php echo base_url();?>statics/css/tema/js/plugins/slimscroll/jquery.slimscroll.min.js"></script-->

    <!-- Custom and plugin javascript -->
    <!--script src="<?php echo base_url();?>statics/css/tema/js/inspinia.js"></script-->
    <!--script src="<?php echo base_url();?>statics/css/tema/js/plugins/pace/pace.min.js"></script-->

    <script>
    $(document).ready(function(){
         var site_url = "<?php echo site_url() ?>";
    	$('#modal-perfil').modal('show');
    	if(Notification.permission !== "granted") {
    		Notification.requestPermission()
    	}

    /*	$('.modal').on('hidden.bs.modal',function(){
    		$('html').getNiceScroll().resize();
    		$('.sidebar-inner').getNiceScroll().resize();
    	});



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
      */
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
    }
    </script>



</body>

</html>
