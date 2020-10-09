<link href="<?php echo base_url();?>statics/css/tema/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

<link href="<?php echo base_url();?>statics/css/tema/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">

<!-- Color picker -->
<script src="<?php echo base_url();?>statics/css/tema/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- Clock picker -->
<script src="<?php echo base_url();?>statics/css/tema/js/plugins/clockpicker/clockpicker.js"></script>

<script src="<?php echo base_url();?>statics/css/tema/js/plugins/daterangepicker/daterangepicker.js"></script>

 <script src="<?php echo base_url();?>statics/css/tema/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script>

$(document).ready(function(){

$('.clockpicker').clockpicker();

$('#data_1 .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true
});

});
</script>

<div id="modal-cronograma" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                        <form role="form" action="<?php echo base_url();?>index.php/proyectos/save_cronograma" method="post">
                          <div class="form-group">
                            <label>Titulo</label>
                            <input class="form-control" name="crono[cronoTitulo]" />
                          </div>
                            <div class="form-group">
                              <label>Fecha</label>
                              <input class="form-control" name="crono[cronoFecha]" />
                            </div>

                            <div class="form-group" id="data_1">
                                <label class="font-noraml">Simple data input format</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                                </div>
                            </div>

                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" class="form-control" value="09:30" >
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>


                              <input type="hidden" placeholder="Titulo" class="form-control" name="crono[cronoIdProyecto]" value="<?php echo $id_proyecto;?>">
                            <div>
                                <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Agregar</strong></button>

                            </div>
                        </form>
                </div>

            </div>
        </div>
    </div>
</div>
