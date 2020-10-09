<div id="modal-parcicipante" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                        <form role="form" action="<?php echo base_url();?>index.php/bodyshop/save_proy_parti" method="post">
                            <div class="form-group">
                              <label>Participantes</label>

                              <select class="form-control" name="id_parti">
                              <?php foreach($parti as $p):?>
                                <option value="<?php echo $p->adminId?>"><?php echo $p->adminNombre?></option>
                              <?php endforeach;?>
                             </select>
                            </div>


                              <input type="hidden" placeholder="Titulo" class="form-control" name="id_proyecto" value="<?php echo $id_proyecto;?>">
                            <div>
                                <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Agregar</strong></button>

                            </div>
                        </form>
                </div>

            </div>
        </div>
    </div>
</div>
