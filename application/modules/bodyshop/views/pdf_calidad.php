<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Calidad</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>CHECK LIST DE CONTROL DE CALIDAD</h1>
    <h2><strong>VEHICULO:</strong> <?php echo $proyecto->vehiculo_modelo; ?></h2>
    <h2><strong>PLACAS:</strong> <?php echo $proyecto->vehiculo_placas; ?></h2>
    <?php foreach($preguntas as $item):?>
        <table border="1" width="100%" class="table table-striped">
            <thead>
                <tr>
                    <th align="left" width="60%"><?php echo $item['seccion']->idbodyshop_calidad_preguntas_seccion.' '.$item['seccion']->nombre; ?></th>
                    <th class="col-sm-1">SI</th>
                    <th class="col-sm-1">NO</th>
                    <th class="col-sm-2">AUTORIZO</th>
                    <th class="col-sm-2">OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($item['preguntas'] as $pregunta):?>
                    <tr>
                        <td><?php echo  $item['seccion']->idbodyshop_calidad_preguntas_seccion.'.'.$pregunta->numero.' '.$pregunta->pregunta; ?></td>
                        <td align="center">
                            <?php if($pregunta->respuesta == 1) {?>
                               X
                            <?php };?>
                        </td>
                        <td align="center">
                            <?php if($pregunta->respuesta == 0) {?>
                                X
                            <?php }; ?>
                                
                        </td>
                        <td>
                            <?php echo $pregunta->autorizo; ?>
                        </td>
                        <td>
                            <?php echo $pregunta->observaciones; ?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php endforeach;?>
    <?php if(count($conformidadesText)> 0){?>
        <table border="1" width="70%" class="table table-striped">
            <thead>
                <tr>
                    <th width="80%">REGISTRO DE NO CONFORMIDADES</th>
                    <th >NOMBRE /PROCESO</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($conformidadesText as $item):?>
                    <?php if(strlen($item->conformidad)> 0 || strlen($item->proceso)> 0){?>
                    <tr>
                        <td>
                            <?php echo $item->conformidad; ?>
                        </td>
                        <td>
                            <?php echo $item->proceso; ?>
                        </td>
                    </tr>
                     <?php }; ?>
                <?php endforeach;?>
            </tbody>
        </table>
        <br>
    <?php }; ?>
    <?php foreach($conformidades as $item):?>
        <table border="1" width="70%" class="table table-striped">
            <thead>
                <tr>
                    <th width="60%" class="col-sm-6"><?php echo $item['seccion']->nombre; ?></th>
                    <th class="col-sm-1">SI</th>
                    <th class="col-sm-1">NO</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($item['preguntas'] as $pregunta):?>
                    <tr>
                        <td><?php echo  $pregunta->pregunta; ?></td>
                        <td>
                            <?php if($pregunta->respuesta == 1) {?>
                               X
                            <?php };?>
                        </td>
                        <td>
                            <?php if($pregunta->respuesta == 0) {?>
                                X
                            <?php }; ?>
                                
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php endforeach;?>
</body>
</html>