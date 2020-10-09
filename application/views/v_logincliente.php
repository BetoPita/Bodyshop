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
            <h3>Ford Plasencia</h3>
            <p>Login in.</p>
            <form class="m-t" role="form" action="<?php echo base_url()?>index.php/login/cliente_login" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" required="" name="username">
                    <input type="hidden" name="sololectura" value="1">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" name="password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Entrar</button>
            </form>
            <p class="m-t"> <small>Planificador Empresarial &copy; 2016</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url();?>statics/css/tema/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url();?>statics/css/tema/js/bootstrap.min.js"></script>

</body>

</html>
