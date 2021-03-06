<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SCA-SJV | EDITAR USUARIO</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap+Condensed">

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url(''); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(''); ?>assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="<?php echo base_url(''); ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo base_url(''); ?>assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(''); ?>assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo base_url(''); ?>assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="<?php echo base_url(''); ?>assets/vendor/aos/aos.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo base_url(''); ?>assets/css/style.css" rel="stylesheet">

    <style>
        font {
            text-transform: uppercase;
        }

        label,
        input,
        textarea {
            font-family: 'Asap Condensed', sans-serif;
        }

        .radio-container {
            padding-left: 5px;
            padding-top: 10px;
            margin-right: 1em;
        }

        button[type="submit"] {
            background: #2e5ab9;
            border: 0;
            padding: 10px 35px;
            color: #fff;
            transition: 0.4s;
            border-radius: 50px;
        }

        button[type="submit"]:hover {
            background: #52c2c6;
        }
    </style>
</head>

<body>

    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="icofont-calendar"></i><?php setlocale(LC_TIME, "es_ES");
                                                echo date('d-M-Y'); ?>
            </div>
            <div class="d-flex align-items-center">
                <i class="icofont-clock-time"></i> Lunes - Viernes, 8:00 am - 5:00 pm &emsp;
                <i class="icofont-phone"></i>2349-6700
            </div>
        </div>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">

            <a href="<?php echo base_url("index.php/cnt_home/usuarios"); ?>" class="logo mr-auto">
                <img src="<?php echo base_url(''); ?>assets/img/unnamed.png" alt="">
            </a>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <h1 class="logo mr-auto"><a href="index.html">Medicio</a></h1> -->

            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li>
                        <a href="<?php echo base_url("index.php/cnt_home/menu"); ?>">Inicio</a>
                    </li>
                    <li class="drop-down"><a>Cuentas corrientes</a>
                        <ul>
                            <li>
                                <a href="<?php echo base_url("index.php/cnt_cuentasc/contribuyentes"); ?>">Lista de contribuyentes</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("index.php/cnt_cuentasc/parametros"); ?>">Par??metros de c??lculo</a>
                            </li>
                        </ul>
                    </li>
                    <li class="drop-down"><a>Admin</a>
                        <ul>
                            <li>
                                <a href="<?php echo base_url("index.php/cnt_home/registro"); ?>">Usuarios</a>
                            </li>
                            <li>
                                <a href="#">Permisos</a>
                            </li>
                        </ul>
                    </li>
                    <li class="drop-down">
                        <a>
                            <?php echo $this->session->userdata('usuario'); ?>
                            <i class="icofont-user-alt-4"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="<?php echo base_url('index.php/cnt_home/logout') ?>">Cerrar sesi??n</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- .nav-menu -->
        </div>
    </header><!-- End Header -->


    <!-- ======= Appointment Section ======= -->
    <section id="appointment" class="appointment section-bg" style="padding-top: 10em;">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Editar usuario</h2>
            </div>

            <form action="<?php echo base_url('index.php/cnt_home/update_usr'); ?>" method="POST" data-aos="fade-up" data-aos-delay="100">

                <?php
                if (isset($_SESSION['MSJ_UPD_USR'])) {
                ?>
                    <div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $_SESSION['MSJ_UPD_USR']; ?></div>
                <?php
                }
                ?>
                <input class="border rounded form-control" type="hidden" readonly="TRUE" style="margin-bottom: 15px;font-family: 'Asap Condensed', sans-serif;" value="<?php echo $get_User->iduser; ?>" id="idus" name="idus">

                <div class="form-row">
                    <div class="col-md-4 form-group">
                        <label>&ensp;Nombres</label>
                        <input type="text" name="nombres" id="nombres" class="form-control" value="<?php echo $get_User->u_nombre; ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>&ensp;Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php echo $get_User->u_apellidos; ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>&ensp;Usuario</label>
                        <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $get_User->usuario; ?>">
                    </div>
                </div>

                <!-- <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label>&ensp;Clave</label>
                        <input type="password" name="pwd" id="pwd" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>&ensp;Confirmar clave</label>
                        <input type="password" name="cpwd" id="cpwd" class="form-control">
                    </div>
                </div> -->

                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label>&ensp;Tipo de usuario</label>
                        <select class="form-control d-xl-flex" style="margin-bottom: 15px;font-family: 'Asap Condensed', sans-serif;" name="tipo">
                            <option value="<?php echo $get_User->idtipo; ?>" selected="selected"><?php echo $get_User->perfil; ?></option>
                            <option>---------------------------</option>
                            <?php foreach ($fc_tipo as $faq) { ?>
                                <option value="<?php echo $faq["idtipo"]; ?>">
                                    <?php echo $faq["perfil"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>&ensp;Estado</label>
                        <select class="form-control d-xl-flex" style="padding: 6px 12px;margin: 0px 0px 15px;font-family: 'Asap Condensed', sans-serif;" name="estado">
                            <option value="<?php echo $get_User->estado; ?>" selected="selected"><?php if ($get_User->estado == 0) {
                                                                                                        echo 'Inactivo';
                                                                                                    } else {
                                                                                                        echo 'Activo';
                                                                                                    } ?></option>
                            <option>---------------------------</option>
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" name="registrar">Actualizar</button>
                </div>
            </form>

        </div>
    </section><!-- End Appointment Section -->


    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                <strong><span>Alcaldia de San Jose Villanueva</span></strong>. Todos los derechos reservados
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?php echo base_url(''); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/php-email-form/validate.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/counterup/counterup.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/venobox/venobox.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/aos/aos.js"></script>

    <!-- Template Main JS File -->
    <script src="<?php echo base_url(''); ?>assets/js/main.js"></script>

</body>

</html>