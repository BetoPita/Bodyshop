<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ford Plasencia</title>

    <link href="<?php echo base_url();?>statics/css/tema/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url();?>statics/css/tema/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"><img src="<?php echo base_url()?>statics/img/ford.png" width="300"/></h1>

            </div>
            <h3>Bienvenido </h3>
            <!--p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.

            </p-->
            <p>Selecciona una sucursal</p>

            <?php //print_r($sucursales);?>
            <?php //if(is_object($sucursales)):?>
            <ul class="list-group">

                <?php foreach($sucursales as $row):?>
                  <a href="<?php echo base_url()?>index.php/login/update_sucursal/<?php echo $row->suIdSucursal;?>" class="list-group-item"><?php echo nombre_sucursal($row->suIdSucursal);?> </a>

                <?php endforeach;?>


          </ul>
          <?php //endif;?>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url();?>statics/css/tema/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url();?>statics/css/tema/js/bootstrap.min.js"></script>

</body>

</html>
