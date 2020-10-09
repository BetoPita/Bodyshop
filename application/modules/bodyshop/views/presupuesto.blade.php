<div class="tab-pane" id="tab-8">
    <div class="feed-element">
            <a href="<?php echo base_url();?>index.php/bodyshop/pdf_presupuesto/<?php echo $id_proyecto;?>" class="btn btn-sm btn-primary pull-right m-t-n-xs" target="_blank">Exportar PDF</a>
        </div>
    <form role="form" id="frm" method="post">
    <input type="hidden" class="form-control" id="idproyectosave" name="idproyectosave" value="<?php echo $id_proyecto;?>">
      <div class="row">
        <div class="col-sm-3">
          <label>Fecha:</label>
           <div class="form-group1">
                <div class='input-group date' id='datetimepicker2'>
                    <?php echo $input_fecha; ?>
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
          <label>Torre:</label>
          <?php echo $input_torre ?>
        </div>
        <div class="col-sm-3">
          <label>Tipo de vehículo:</label>
          <?php echo $input_tipo_vehiculo ?>
        </div>
        <div class="col-sm-3">
          <label>Placas:</label>
          <?php echo $input_placas ?>
        </div>
      </div>
       <div class="row">
        <div class="col-sm-3">
          <label>Serie:</label>
          <?php echo $input_serie ?>
        </div>
        <div class="col-sm-3">
          <label>Orden de reparación:</label>
          <?php echo $input_orden_reparacion ?>
        </div>
        <div class="col-sm-3">
          <label>Color:</label>
          <?php echo $drop_color ?>
        </div>
        <div class="col-sm-3">
          <label>Modelo:</label>
          <?php echo $drop_vehiculo_modelo ?>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <label>Aseguradora:</label>
          <?php echo $input_aseguradora ?>
        </div>
        <div class="col-sm-3">
          <label>Arribaron refacciones:</label><br>
          <?php echo $input_llegaron_refacciones ?>
        </div>
      </div>
      <table id="tlb-presupuesto" width="70%" class="table table-striped table-hover table-responsive">
        <thead>
          <tr class="text-center">
            <th>Parte</th>
            <th>Tipo</th>
            <th># Parte</th>
            <th>Precio</th>
            <th>Existencia</th>
            <th>Pintura</th>
          </tr>
        </thead>
        <tbody>
          @foreach($datos as $d => $primero)
            <tr class="text-right">
              <td colspan="6"><strong><h1><?php echo $d ?></h1></strong></td>
            </tr>
              @foreach($primero as $p => $segundo)
              <tr class="text-center">
                <td colspan="6"><strong><h2><?php echo $p ?></h2></strong></td>
              </tr>
                  @foreach($segundo as $s => $tercero)
                   
                    <?php
                    $datos_presupuesto = $this->mp->getDatosDetalle($id_proyecto,$tercero->id_subcategoria);
                    //print_r($datos_presupuesto);die();
                    if(count($datos_presupuesto)>0){
                      $tipo_select = $datos_presupuesto[0]->tipo;
                      $noparte_select = $datos_presupuesto[0]->noparte;
                      $precio_select = $datos_presupuesto[0]->precio;
                      $existencia_select = $datos_presupuesto[0]->existencia;
                       $pintura = $datos_presupuesto[0]->pintura;
                    }else{
                      $tipo_select = '';
                      $noparte_select = '';
                      $precio_select = '';
                      $existencia_select = '';
                      $pintura = 0;
                    }

                  ?>
                  @if(count($datos_presupuesto)>0)
                  <tr class="tr-cat-{{$tercero->id}}">
                    <td width="25%"><?php echo $tercero->subcategoria ?></td>
                    <td width="15%">
                      <select name="tipo[<?php echo $tercero->id_subcategoria ?>]"  class="form-control tipo" data-tipo="{{$tercero->id_subcategoria}}">
                        <option value="">-- Selecciona --</option>
                        <option value="C" <?php echo ($tipo_select=='C')?'selected':'' ?>>C</option>
                        <option value="R" <?php echo ($tipo_select=='R')?'selected':'' ?>>R</option>
                        <option value="P" <?php echo ($tipo_select=='P')?'selected':'' ?>>P</option>
                      </select>
                      <span class="error error_tipo_{{$tercero->id_subcategoria}}"></span>
                    </td>
                    <td  width="20%">
                      <input type="text" name="noparte[<?php echo $tercero->id_subcategoria ?>]" class="form-control" value="<?php echo $noparte_select ?>" placeholder="#parte">
                    </td>
                    <td  width="20%">
                      <input type="text" name="precio[<?php echo $tercero->id_subcategoria ?>]" class="form-control positive" value="<?php echo $precio_select ?>" placeholder="Precio">
                    </td>
                    <td>
                      <input type="text" name="existencia[<?php echo $tercero->id_subcategoria ?>]" class="form-control positive" value="<?php echo $existencia_select ?>" placeholder="Existencia">
                      <!--<i class="fa fa-minus"></i>-->
                    </td>
                    <td>
                        @if($pintura)
                        <?php $checked = 'checked'; ?>
                        @else
                            <?php $checked = ''; ?>
                        @endif
                        <input type="checkbox" name="pintura[<?php echo $tercero->id_subcategoria ?>]" {{$checked}} value="<?php echo $tercero->id_subcategoria ?>" >
                    </td>
                  </tr>
                @else
                @endif
                  @endforeach
                    <tr class="tr-cat-{{$tercero->id}}">
                        <td colspan="6"></td>
                    </tr>
                  <tr class="text-right">
                      <td colspan="6">
                          <button type="button" data-idcategoria="{{$tercero->id}}" data-principal="{{$d}}" class="btn btn-info addFieldByCategory">Agregar</button>
                      </td>
                  </tr>
              @endforeach
          @endforeach
        </tbody>
      </table>
      </form>
      <div class="row text-right">
        <div class="col-sm-12">
          <button id="addfield" class="btn btn-info">Agregar parte</button>
           <button id="guardar" class="btn btn-success">Guardar</button>
        </div>
      </div>
</div>