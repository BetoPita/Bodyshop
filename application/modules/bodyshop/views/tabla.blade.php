<table width="70%" class="table table-striped table-hover table-responsive">
  <thead>
    <tr class="text-center">
      <th>Parte</th>
      <th>Tipo</th>
      <th># Parte</th>
      <th>Precio</th>
      <th>Existencia</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($datos as $d => $primero) { ?>
      <tr class="text-right">
        <td colspan="5"><strong><h1><?php echo $d ?></h1></strong></td>
      </tr>
        <?php foreach($primero as $p => $segundo) { ?>
        <tr class="text-center">
          <td colspan="5"><strong><h2><?php echo $p ?></h2></strong></td>
        </tr>
            <?php foreach($segundo as $s => $tercero){
            

              $datos_presupuesto = $this->mp->getDatosDetalle($id_proyecto,$tercero->id_subcategoria);
              //print_r($datos_presupuesto);die();
              if(count($datos_presupuesto)>0){
                $tipo_select = $datos_presupuesto[0]->tipo;
                $noparte_select = $datos_presupuesto[0]->noparte;
                $precio_select = $datos_presupuesto[0]->precio;
                $existencia_select = $datos_presupuesto[0]->existencia;
              }else{
                $tipo_select = '';
                $noparte_select = '';
                $precio_select = '';
                $existencia_select = '';
              }

            ?>
            <tr class="">
              <td width="25%"><?php echo $tercero->subcategoria ?></td>
              <td width="15%">
                <select name="tipo[<?php echo $tercero->id_subcategoria ?>]"  class="form-control">
                  <option value="">-- Selecciona --</option>
                  <option value="C" <?php echo ($tipo_select=='C')?'selected':'' ?>>C</option>
                  <option value="R" <?php echo ($tipo_select=='R')?'selected':'' ?>>R</option>
                  <option value="P" <?php echo ($tipo_select=='P')?'selected':'' ?>>P</option>
                </select>
              </td>
              <td  width="20%">
                <input type="text" name="noparte[<?php echo $tercero->id_subcategoria ?>]" class="form-control" value="<?php echo $noparte_select ?>" placeholder="#parte">
              </td>
              <td  width="20%">
                <input type="text" name="precio[<?php echo $tercero->id_subcategoria ?>]" class="form-control positive" value="<?php echo $precio_select ?>" placeholder="Precio">
              </td>
              <td>
                <input type="text" name="existencia[<?php echo $tercero->id_subcategoria ?>]" class="form-control positive" value="<?php echo $existencia_select ?>" placeholder="Existencia">
              </td>
            </tr>
            <?php } ?>
        <?php } ?>
    <?php } ?>
  </tbody>
</table>  