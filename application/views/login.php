<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ford plasencia</title>

    <link href="<?php echo base_url();?>statics/css/tema/css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url();?>statics/css/tema/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/css/style.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url()?>statics/img/so.png"/>

</head>

<body class="gray-bg">

    <div class="middle-box text-center  animated fadeInDown" style="padding-top: 20px">
        <div>
           <div>
                <h2 style="font-size: 40px;" class="">BIENVENIDOS A:</h2>
                <img src="<?php echo base_url()?>statics/img/sohex.png" width="400"/>
                <h2>ESTAMOS CAMBIANDO Y TRABAJANDO POR TI!</h2>
            </div>
            <!--<h3>Ford Plasencia</h3>
            <p>Login in.</p>-->
            <form class="m-t" role="form" action="<?php echo base_url()?>index.php/login/mainView" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" required="" name="username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" name="password">
                    <input type="hidden" name="sololectura" value="0">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Entrar</button>

                <a href="#"><small>¿Se te olvidó tu contraseña?</small></a>
                <p class="text-muted text-center"><small>¿No tiene una cuenta?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="<?php echo base_url();?>index.php/login/registro">Crear una cuenta</a>
            </form>
            <p class="m-t"> <small>Planificador Empresarial &copy; <?php echo date('Y') ?></small> </p>
             <div>
                <img src="<?php echo base_url()?>statics/img/ford.png" width="400"/>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url();?>statics/css/tema/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url();?>statics/css/tema/js/bootstrap.min.js"></script>

</body>

</html>
