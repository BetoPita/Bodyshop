<div id="modal-status" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">

                    <!-- Anticipo, facturado, pagado, entregad-->
                        <form role="form" action="<?php echo base_url();?>index.php/bodyshop/cambiar_status" method="post">
                            <!-- <div class="form-group"> -->
                              <ul class="list-group">
                              <?php foreach ($estatus as $key => $value): ?>
                                  <?php if($pro->status == $value->estatusId): ?>
                                    <li class="list-group-item active">
                                      <span class="badge">Actual</span>
                                      <?php echo $value->nombre; ?></li>
                                    <?php else: ?>
                                      <li class="list-group-item"><?php echo $value->nombre; ?></li>
                                  <?php endif ?>
                                
                              <?php endforeach ?>
                              </ul>
                            <!-- </div> -->
                            <div>
                                <button style="margin-right: 5px;" id="btn_cancel" class="btn btn-sm btn-primary pull-right m-t-n-xs" type="button"><strong>Cerrar</strong></button>
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
