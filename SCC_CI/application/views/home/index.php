<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>SCA-SJV | LOGIN</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap+Condensed">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/Login-Form-Dark.css') ?>">
</head>

<body>
    <div class="login-dark" style="background: url(&quot;<?php echo base_url('assets/img/bkLog.jpg&quot;') ?>);">
        <form method="POST">
            <div class="illustration">
                <img data-bss-hover-animate="rubberBand" src="<?php echo base_url('assets/img/unnamed.png') ?>" style="width: 180px;">
            </div>
            <?php echo validation_errors('<div class= "alert alert-danger">', '</div>'); ?>
            <div class="form-group">
                <input class="form-control" type="text" id="usuario" name="usuario" placeholder="Usuario" autofocus="" style="font-family: 'Asap Condensed', sans-serif;" required="">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" id="pwd" name="pwd" placeholder="Contraseña" style="font-family: 'Asap Condensed', sans-serif;" required="">
            </div>
            <div class="form-group d-xl-flex justify-content-xl-center">
                <input type="submit" name="login" class="btn btn-success btn-block btn-lg d-xl-flex justify-content-xl-center" data-bss-hover-animate="jello" style="font-family: 'Asap Condensed', sans-serif;" value="Ingresar">
                <!-- <button name="login" class="btn btn-success btn-block btn-lg d-xl-flex justify-content-xl-center" data-bss-hover-animate="jello" type="submit" style="font-family: 'Asap Condensed', sans-serif;">Ingresar</button> -->
            </div>
            <a class="forgot" href="#" style="font-family: 'Asap Condensed', sans-serif;">Sistema de Control Administrativo&nbsp;<br>SCA-SJV</a>
        </form>
    </div>
    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bs-init.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>