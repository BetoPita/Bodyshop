<form id="frmModelo" role="form" action="<?php echo base_url();?>index.php/bodyshop/cambiar_status" method="post">
    <div class="row">
        <div class="col-sm-12 form-group">
            <label for="">Modelo</label>
            <?php echo $input_modelo; ?>
            <div class="error error_modelo"></div>
        </div>
    </div>
</form>