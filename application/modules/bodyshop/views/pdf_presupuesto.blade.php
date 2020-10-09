<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Calidad</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="{{base_url()}}">
    

</head>
<body>
    <div class="container">
        
    
    <h1>PRESUPUESTO</h1>
    <h2><strong>VEHICULO:</strong> <?php echo $proyecto->vehiculo_modelo; ?></h2>
    <h2><strong>PLACAS:</strong> <?php echo $proyecto->vehiculo_placas; ?></h2>
    <table border="1" width="100%" class="table table-striped">
    <thead>
      <tr class="text-center">
        <th>Parte</th>
        <th>Tipo</th>
        <th># Parte</th>
        <th>Precio</th>
        <th>Existencia</th>
        <th>¿Pintura?</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($datos as $d => $primero) { ?>
        <tr class="text-right">
          <td colspan="6"><strong><h1><?php echo $d ?></h1></strong></td>
        </tr>
          <?php foreach($primero as $p => $segundo) { ?>
          <tr class="text-center">
            <td colspan="6"><strong><h2><?php echo $p ?></h2></strong></td>
          </tr>
              <?php foreach($segundo as $s => $tercero){
              

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
              <tr class="">
                <td width="25%"><?php echo $tercero->subcategoria ?></td>
                <td width="15%">
                    {{$tipo_select}}
                </td>
                <td  width="20%">
                    <?php echo $noparte_select ?>
                </td>
                <td  width="20%">
                 <?php echo $precio_select ?>
                </td>
                <td>
                    <?php echo $existencia_select ?>
                </td>
                <td>
                    {{($pintura==1)?'Si':'No' }}
                </td>
              </tr>

              <?php } ?>
          <?php } ?>
      <?php } ?>
    </tbody>
  </table>
  </div>
</body>
</html>