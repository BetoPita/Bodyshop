<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tablero BodyShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url();?>statics/css/custom/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url().'statics/js/libraries/confirm.jquery.js'; ?>"></script>
    <script src="<?php echo base_url();?>statics/css/tema/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/general.js"></script>
    <script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
</head>
<body>
    <div class="container">
        <h1>Tablero BodyShop</h1>
        <hr><br>
        <div id="postList">
        <?php foreach ($data as $key => $value) {?>
           <div class="column">
                <div class="column-header" style="background-color:<?php echo $value['estatus']->color ?>">
                    <label><?php echo $value['estatus']->nombre ?></label>
                </div>
                <?php foreach ($value['proyectos'] as $key2 => $value2) {?>
                    <div class="column-item <?php if(!is_null($value['estatus']->horas) && !is_null($value2->fecha_estatus))
                                                    { 
                                                        if(get_tiempo_laboral($value2->fecha_estatus,$value['estatus']->horas)){
                                                            echo 'atrasado';
                                                        }
                                                    } ?>">
                        <label class="text-center"><?php echo $value2->proyectoNombre ?></label><br>
                        <hr>
                        <br>
                        <label>Placas: </label>
                        <small><?php echo $value2->vehiculo_placas ?></small><br><br>
                        <label>Modelo: </label> 
                        <small><?php echo $value2->vehiculo_modelo ?></small><br><br>
                        <label>Fecha de creación:</label><br>
                        <small><?php echo $value2->proyectoFechaCreacion ?></small><br><br>
                        <label>Fecha estatus:</label><br>
                        <small><?php echo $value2->fecha_estatus ?></small><br><br>
                        <?php if($value2->status == 5 && $value2->llegaron_refacciones!=1){ ?>
                            <div class="line pendiente-refacciones"></div>
                        <?php }?>
                        <br>
                        <?php if($value['estatus']->estatusId<$total && ($value2->status != 5 || ($value2->status == 5 && $value2->llegaron_refacciones==1))){ ?>
                            <button class="btn jsCambiarStatus" data-id="<?php echo $value2->proyectoId ?>" data-estatusid="<?php echo $data[$key+1]['estatus']->estatusId ?>" 
                            data-estatusname="<?php echo $data[$key+1]['estatus']->nombre ?>">Cambiar estatus</button>
                        <?php }?>
                    </div>
                 <?php }?>
           </div>
        <?php }?>
          <div class="load-more" lastID="<?php echo $value2->proyectoId; ?>" style="display: none;">
                <img src="<?php echo base_url('assets/images/loading.gif'); ?>"/> Loading more posts...
            </div>
        </div>
    </div>
    <script>
        var site_url = "<?php echo site_url();?>";
        var loginUrl =site_url+"/bodyshop/tablero/login";
        var $current = '';
        alert($('.load-more').attr('lastID'));
        $(document).on('ready',function(){
            $('.jsCambiarStatus').on('click',function(){
                $current=$(this);
                customModal(
                    loginUrl,
                        {},
                    "GET",
                    'md',
                    callbackLogIn,
                    "",
                    "Iniciar",
                    "",
                    "Iniciar sesión",
                    "modalModelo"
                );
            });
        //     $(window).scroll(function(){
        //         var lastID = $('.load-more').attr('lastID');
        //         if(($(window).scrollTop() == $(document).height() - $(window).height()) && (lastID != 0)){
        //             $.ajax({
        //                 type:'POST',
        //                 url:site_url+'/bodyshop/tablero/loadMoreDataTablero',
        //                 data:'id='+lastID,
        //                 beforeSend:function(){
        //                     $('.load-more').show();
        //                 },
        //                 success:function(html){
        //                     $('.load-more').remove();
        //                     $('#postList').append(html);
        //                 }
        //             });
        //         }
        //     });
        // });
        var callbackLogIn = function (response){
            
			//var url =site_url+"/citas/login_editar_cita";
			ajaxJson(loginUrl,{"usuario":$("#usuario").val(),"password":$("#password").val()},"POST","",function(response){
                console.log(response);
				//var res = confirm('¿Está seguro que quiere cambiar el proyecto a estatus '+$(this).data('estatusname')+'?');
                if(response.success){
                    jQuery.ajax({
                        type: 'POST',
                        url: site_url+'/bodyshop/tablero/cambiar_status',
                        datatype: "JSON",
                        async: true,
                        cache: false,
                        data: {id_proyecto:$($current).data('id'),status:$($current).data('estatusid'),tablero:true,id_usuario:response.id_usuario},
                        statusCode: {
                            200: function (result) {
                                location.reload();
                            }
                        }
                    });
                }else{
                    if(response.validation)
                    {
                        $.each(response.errors, function(i, item) {
                            $(".error_"+i).empty();
                            $(".error_"+i).append(item);
                            $(".error_"+i).css("color","red");
                        });
                    }
                    else
                        alert(response.message);
                }
			});
            
        };
    </script>
</body>
</html>