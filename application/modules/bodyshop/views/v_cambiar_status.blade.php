<div class="row">
<form role="form" action="<?php echo base_url();?>index.php/bodyshop/cambiar_status" method="post" id="frm-cambiar-status">
    <div class="form-group">
      <?php 
      $orden_actual = $this->principal->getOrder($pro->status); 
      $status_perfil = $this->session->userdata('statusPerfil'); 
      $id_usuario = $this->session->userdata('id'); 
      ?>
      <?php foreach ($estatus as $key => $value) {
          $disabled = '';
          
          if($value->orden > ($orden_actual + 1) || $value->orden<$orden_actual)
          {
            $disabled ="disabled='disabled'";
            //$disabled ="";
          }

          //Deshabilitar ciertos estatus cuando está en tránsito
          $disabled_transito = '';
          if($pro->transito && $value->orden>6)
          {
            $disabled_transito ="disabled='disabled'";
            //$disabled ="";
          }

          //Cuando sea revisión de calidad solo pueden hacerlo ciertos usuarios 
          if($value->estatusId==17){
              if($this->session->userdata('id')==80 || $this->session->userdata('id')==88 || $this->session->userdata('id')==1 || $this->session->userdata('id')==12 ){
                $disabled_revision = '';
            }else{
                $disabled_revision ="disabled='disabled'";                    
            }
          }else{
            $disabled_revision = '';
          }

          //Verificar si el perfil es 3 (contacto) los permisos del status
          $disabled_contacto = '';
            
          if($status_perfil==3){
            if($this->principal->getPermiso($id_usuario,$value->estatusId)){
              $disabled_contacto = '';
            }else{
              $disabled_contacto = "disabled='disabled'";
            }
          }
          
        ?>
        <div class="checkbox">
          
          <?php if($pro->status == $value->estatusId){?>
            <label><input type="radio" name="status" <?php echo $disabled; ?> <?php echo $disabled_transito; ?> <?php echo $disabled_revision; ?> <?php echo $disabled_contacto; ?> value="<?php echo $value->estatusId;  ?>" checked> <?php echo $value->nombre;  ?></label>
          <?php }else{?>
            <label><input type="radio" name="status" <?php echo $disabled; ?> <?php echo $disabled_transito; ?> <?php echo $disabled_revision; ?> <?php echo $disabled_contacto; ?> value="<?php echo $value->estatusId;  ?>"> <?php echo $value->nombre;  ?></label>
          <?php }?>
        </div>
      <?php } ?>
    </div>


      <input type="hidden" placeholder="Titulo" class="form-control" name="id_proyecto_estatus" value="<?php echo $id_proyecto;?>">
       <input type="hidden" name="tablero" value="1">
    <div>
    </div>
</form>
</div>