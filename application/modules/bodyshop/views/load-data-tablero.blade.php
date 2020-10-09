<div id="postList">
    <?php if(!empty($data)){ foreach($data as $key => $value){ ?>
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
    <?php } ?>
    <?php if($RegNum > $postLimit){ ?>
        <div class="load-more" lastID="<?php echo $post['id']; ?>" style="display: none;">
            <img src="<?php echo base_url('assets/images/loading.gif'); ?>"/> Loading more posts...
        </div>
    <?php }else{ ?>
        <div class="load-more" lastID="0">
            That's All!
        </div>
    <?php } ?>    
<?php }else{ ?>    
    <div class="load-more" lastID="0">
            That's All!
    </div>    
<?php } ?>