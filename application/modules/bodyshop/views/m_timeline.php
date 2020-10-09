<div class="container">
	<div class="row">
        <?php if(count($transiciones)==0){?>
            <div class="col-sm-12">
                <h3>No se encontraron resultados.</h3>
            </div>
         <?php } else {?>
		<div class="timeline-centered">
            <?php foreach ($transiciones as $key => $value) { ?>
               <article class="timeline-entry">
                <div class="timeline-entry-inner">
                    <time class="timeline-time" datetime="<?php echo $value->fecha ?>"><span><?php echo date("Y-m-d",strtotime($value->fecha));  ?></span> <span><?php echo date("H:i",strtotime($value->fecha));  ?></span></time>
                    
                    <div class="timeline-icon bg-success">
                        <i class="entypo-feather"></i>
                    </div>
                    <div class="timeline-label">
                        <h2>Estatus: <?php echo $value->nombre ?></h2>
                        <p><strong>Usuario:</strong> <?php echo $value->adminNombre ?></p>
                    </div>
                </div>
                
            </article>
            <?php } ?>
        </div>
        <?php } ?>
	</div>
</div>