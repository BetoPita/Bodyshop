<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ford Plasencia</title>

    <link href="<?php echo base_url();?>statics/css/tema/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>statics/css/tema/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"><img src="<?php echo base_url()?>statics/img/ford.png" width="300"/></h1>

            </div>
            <h3>Registro </h3>
            <!--p>Create account to see it in action.</p-->
            <form class="m-t" role="form" action="<?php echo base_url();?>index.php/login/saveregistro" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nombre completo" required="" name="save[adminNombre]">
                </div>
                <!--div class="form-group">
                    <input type="text" class="form-control" placeholder="Domicilio" required="" name="save[AdminDomicilio]">
                </div-->
                <!--div class="form-group">
                    <input type="text" class="form-control" placeholder="Teléfono" required="" name="save[adminTelefono]">
                </div-->
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required="" name="save[adminEmail]">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Teléfono" required="" name="save[adminTelefono]">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" required="" name="save[adminUsername]">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" name="save[adminPassword]">
                </div>
                <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Acepto los <a href="http://planificadorempresarial.com/terminos_condiciones.html" target="_blank">términos y condiciones</a> </label></div>
                        <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Acepto las <a href="http://planificadorempresarial.com/politica_privacidad.html" target="_blank">Pol&iacute;ticas de Privacidad</a> </label></div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Registrar</button>

                <!--p class="text-muted text-center"><small>Ya cuentas con una cuenta?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="login.html">Login</a-->
            </form>
            <p class="m-t"> <small>Planificador Empresarial &copy; 2016</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url();?>statics/css/tema/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url();?>statics/css/tema/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>statics/css/tema/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>

</html>
