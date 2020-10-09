<div id="modal-status_activi" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                        <form role="form" action="<?php echo base_url();?>index.php/proyectos/cambiar_status_actividad" method="post">
                            <div class="form-group">

                              <div class="checkbox">

                                  <!--label style="background:#ccc;"><input type="radio" name="status" value="1" checked>ACTIVA</label-->
                                  <label style="background:#fff;">Activdad  terminada</label>

                              </div>




                            </div>


                              <input type="hidden" placeholder="Titulo" class="form-control" name="id_actividad" value="" id="id_actividad">
                            <div>
                                <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Aceptar</strong></button>

                            </div>
                        </form>
                </div>

            </div>
        </div>
    </div>
</div>
