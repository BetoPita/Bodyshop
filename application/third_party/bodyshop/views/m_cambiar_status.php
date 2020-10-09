<div id="modal-status" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">

                    <!-- Anticipo, facturado, pagado, entregad-->
                        <form role="form" action="<?php echo base_url();?>index.php/bodyshop/cambiar_status" method="post">
                            <div class="form-group">
                              <?php foreach ($estatus as $key => $value) {
                                  $disabled = '';
                                  if($value->estatusId > ($pro->status + 1))
                                  {
                                    $disabled ="disabled='disabled'";
                                  }
                                ?>
                                <div class="checkbox">
                                  <?php if($pro->status == $value->estatusId){?>
                                    <label><input type="radio" name="status" <?php echo $disabled; ?> value="<?php echo $value->estatusId;  ?>" checked> <?php echo $value->nombre;  ?></label>
                                  <?php }else{?>
                                    <label><input type="radio" name="status" <?php echo $disabled; ?> value="<?php echo $value->estatusId;  ?>"> <?php echo $value->nombre;  ?></label>
                                  <?php }?>
                                </div>
                              <?php } ?>
                            </div>


                              <input type="hidden" placeholder="Titulo" class="form-control" name="id_proyecto" value="<?php echo $id_proyecto;?>">
                            <div>
                                <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Cambiar</strong></button>
                                <button style="margin-right: 5px;" id="btn_cancel" class="btn btn-sm btn-primary pull-right m-t-n-xs" type="button"><strong>Cancelar</strong></button>
                            </div>
                        </form>
                </div>

            </div>
        </div>
    </div>
</div>
<<script>
    $('#btn_cancel').on('click',function(){
        location.reload();
    })
</script>
