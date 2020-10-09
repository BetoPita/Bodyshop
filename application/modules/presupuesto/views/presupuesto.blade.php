<link href="<?php echo base_url();?>statics/css/tema/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
<link href="<?php echo base_url();?>statics/css/tema/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
<link href="<?php echo base_url();?>statics/css/bootstrap/css/bootstrap-switch.css" rel="stylesheet">

<!-- Color picker -->
<script src="<?php echo base_url();?>statics/css/tema/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- Clock picker -->
<script src="<?php echo base_url();?>statics/css/tema/js/plugins/clockpicker/clockpicker.js"></script>

<script src="<?php echo base_url();?>statics/css/tema/js/plugins/daterangepicker/daterangepicker.js"></script>

 <script src="<?php echo base_url();?>statics/css/tema/js/plugins/datapicker/bootstrap-datepicker.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>

<script src="<?php echo base_url();?>statics/js/modules/bootstrap-datetimepicker.js"></script>



<script src="<?php echo base_url();?>statics/js/custom/bootbox.min.js"></script>

<script src="<?php echo base_url();?>statics/js/custom/general.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/isloading.js"></script>
<script src="<?php echo base_url();?>statics/js/custom/jquery.numeric.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>






<h3>Presupuestos</h3>
<div class="row">
  <div class="col-sm-8">
    <div class="modal-dialog1">
      <div class="modal-content1">
        <div class="modal-body1">
          <form role="form" id="frm" method="post">
          <div class="row">
            <div class="col-sm-3">
              <label>Fecha:</label>
              {{$input_fecha}}
            </div>
            <div class="col-sm-3">
              <label>Torre:</label>
              {{$input_torre}}
            </div>
            <div class="col-sm-3">
              <label>Tipo de vehículo:</label>
              {{$input_tipo_vehiculo}}
            </div>
            <div class="col-sm-3">
              <label>Placas:</label>
              {{$input_placas}}
            </div>
          </div>
           <div class="row">
            <div class="col-sm-3">
              <label>Serie:</label>
              {{$input_serie}}
            </div>
            <div class="col-sm-3">
              <label>Orden de reparación:</label>
              {{$input_orden_reparacion}}
            </div>
            <div class="col-sm-3">
              <label>Color:</label>
              {{$drop_color}}
            </div>
            <div class="col-sm-3">
              <label>Modelo:</label>
              {{$drop_vehiculo_modelo}}
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <label>Aseguradora:</label>
              {{$input_aseguradora}}
            </div>
          </div>
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
              @foreach($datos as $d => $primero)
                <tr class="text-right">
                  <td colspan="5"><strong><h1>{{$d}}</h1></strong></td>
                </tr>
                  @foreach($primero as $p => $segundo)
                  <tr class="text-center">
                    <td colspan="5"><strong><h2>{{$p}}</h2></strong></td>
                  </tr>
                      @foreach($segundo as $s => $tercero)
                      <?php

                      $datos_presupuesto = $this->mp->getDatosDetalle(1,$tercero->id_subcategoria);
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
                        <td width="30%">{{$tercero->subcategoria}}</td>
                        <td width="20%">
                          <select name="tipo[{{$tercero->id_subcategoria}}]"  class="form-control">
                            <option value="">-- Selecciona --</option>
                            <option value="C" {{($tipo_select=='C')?'selected':''}}>C</option>
                            <option value="R" {{($tipo_select=='R')?'selected':''}}>R</option>
                            <option value="P" {{($tipo_select=='P')?'selected':''}}>P</option>
                          </select>
                        </td>
                        <td  width="20%">
                          <input type="text" name="noparte[{{$tercero->id_subcategoria}}]" class="form-control" value="{{$noparte_select}}">
                        </td>
                        <td  width="20%">
                          <input type="text" name="precio[{{$tercero->id_subcategoria}}]" class="form-control positive" value="{{$precio_select}}">
                        </td>
                        <td>
                          <input type="text" name="existencia[{{$tercero->id_subcategoria}}]" class="form-control positive" value="{{$existencia_select}}">
                        </td>
                      </tr>
                      @endforeach
                  @endforeach
              @endforeach
            </tbody>
          </table>
          </form>
          <div class="row text-right">
            <div class="col-sm-12">
              <button id="guardar" class="btn btn-success">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  var site_url = "{{site_url()}}";
  $(".numeric").numeric();
  $(".positive").numeric({ negative : false });
  $("#guardar").on('click',callback_guardar);
function callback_guardar()
    {
      $("[class*='error_']").empty();
      ajaxJson(site_url+"/presupuesto/savePresupuesto", $('#frm').serialize(), "POST", true, function(result){ 
        console.log(result);
          if(isNaN(result)){
                data = JSON.parse( result );
                //Se recorre el json y se coloca el error en la div correspondiente
                $.each(data, function(i, item) {
                    $(".error_"+i).empty();
                    $(".error_"+i).append(item);
                    $(".error_"+i).css("color","red");
                });
        }else{
            if(result==1){
              // ExitoCustom("Guardado correctamente",function(){
              //   window.location.href = site_url+'/ventas_facturacion/busquedas';
              // });
               ExitoCustom("Guardado correctamente");
            }else{
                  ErrorCustom('No se pudo guardar, intenta otra vez.');
            }
        }
      });
    }

</script>
