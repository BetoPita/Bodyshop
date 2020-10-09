<div class="tab-pane" id="tab-7">
    <form role="form" id="frm-guardar-calidad" action="<?php echo base_url();?>index.php/bodyshop/save_calidad" method="post" enctype="multipart/form-data">
        <input type="hidden" placeholder="Titulo" class="form-control" name="pregunta[idProyecto]" value="<?php echo $id_proyecto;?>">
        <div class="feed-element">
            <a href="<?php echo base_url();?>index.php/bodyshop/pdf_calidad/<?php echo $id_proyecto;?>" class="btn btn-sm btn-primary pull-right m-t-n-xs" target="_blank">Exportar PDF</a>
            
        </div>
        <div class="feed-element">
            <?php foreach($preguntas as $item):?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-sm-6"><?php echo $item['seccion']->idbodyshop_calidad_preguntas_seccion.' '.$item['seccion']->nombre; ?></th>
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
                                <td>
                                    <?php if($pregunta->respuesta == 1) {?>
                                        <input checked="checked" type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="1">
                                    <?php } else  {?>
                                        <input type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="1">
                                    <?php }; ?>
                                </td>
                                <td>
                                    <?php if($pregunta->respuesta == 1) {?>
                                        <input type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="0">
                                    <?php } else  {?>
                                        <input checked="checked" type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="0">
                                    <?php }; ?>
                                    
                                </td>
                                <td>
                                    <?php echo form_input('pregunta[item]['.$pregunta->idbodyshop_calidad_preguntas.'][autorizo]',set_value('autorizo',exist_obj($pregunta,'autorizo')),'class="form-control" '); ?>
                                </td>
                                <td>
                                    <?php echo form_input('pregunta[item]['.$pregunta->idbodyshop_calidad_preguntas.'][observaciones]',set_value('observaciones',exist_obj($pregunta,'observaciones')),'class="form-control" '); ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endforeach;?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-sm-6">REGISTRO DE NO CONFORMIDADES</th>
                            <th class="col-sm-2">NOMBRE /PROCESO</th>
                            <th class="col-sm-1"></th>
                            <th class="col-sm-1"></th>
                            <th class="col-sm-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($conformidadesText as $item):?>
                            <tr>
                                <td>
                                    <?php echo form_input('conformidad[item]['.$item->idbodyshop_conformidades.'][conformidad]',set_value('conformidad',exist_obj($item,'conformidad')),'class="form-control" '); ?>
                                </td>
                                <td>
                                    <?php echo form_input('conformidad[item]['.$item->idbodyshop_conformidades.'][proceso]',set_value('proceso',exist_obj($item,'proceso')),'class="form-control" '); ?>
                                </td>
                                <td></td>
                                <td>
                                    
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php foreach($conformidades as $item):?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-sm-6"><?php echo $item['seccion']->nombre; ?></th>
                            <th class="col-sm-1">SI</th>
                            <th class="col-sm-1">NO</th>
                            <th class="col-sm-2"></th>
                            <th class="col-sm-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($item['preguntas'] as $pregunta):?>
                            <tr>
                                <td><?php echo  $pregunta->pregunta; ?></td>
                                <td>
                                    <?php if($pregunta->respuesta == 1) {?>
                                        <input checked="checked" type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="1">
                                    <?php } else  {?>
                                        <input type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="1">
                                    <?php }; ?>
                                </td>
                                <td>
                                    <?php if($pregunta->respuesta == 1) {?>
                                        <input type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="0">
                                    <?php } else  {?>
                                        <input checked="checked" type="radio" name="pregunta[item][<?php echo $pregunta->idbodyshop_calidad_preguntas; ?>][si]" value="0">
                                    <?php }; ?>
                                    
                                </td>
                                <td>
                                   
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            <?php endforeach;?>
        </div>
        <div class="feed-element">
            <button id="btn-guardar-calidad" class="btn btn-sm btn-primary pull-right m-t-n-xs" type="button"><strong>Guardar</strong></button>
        </div>
    </form>
</div>
