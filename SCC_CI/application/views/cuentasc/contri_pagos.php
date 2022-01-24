<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SCA-SJV | CONTRIBUYENTES RP</title>
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

        tr {
            font-family: 'Asap Condensed', sans-serif;
        }

        .btn-primario {
            background: #2e5ab9;
            border: 0;
            padding: 6px 10px;
            color: #fff;
            transition: 0.4s;
            border-radius: 25px;
        }

        .btn-primario:hover {
            background: #65BEF3;
            color: #000;
        }
    </style>

    <script>
        function pulsar(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla == 13) return false;
        }
    </script>

</head>

<body>

    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="icofont-calendar"></i><?php setlocale(LC_TIME, "spanish");
                                                echo strftime("%A %d de %B de %Y"); ?>
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

            <a class="logo mr-auto" href="<?php echo base_url("index.php/cnt_home/menu"); ?>">
                <img src="<?php echo base_url(''); ?>assets/img/unnamed.png" alt="">
            </a>

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
                                <a href="<?php echo base_url("index.php/cnt_cuentasc/parametros"); ?>">Parámetros de cálculo</a>
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
                                <a href="<?php echo base_url('index.php/cnt_home/logout') ?>">Cerrar sesión</a>
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
                <h2>Lista de contribuyentes registrados </h2>
                <!-- <h3><?php echo $contrib; ?></h3> -->
            </div>
            <form action="<?php echo base_url() ?>index.php/cnt_cuentasc/buscar" method="GET" class="form" onkeypress="return pulsar(event)">
                <div class="input-group">
                    <button class="btn btn-primary" type="submit">
                        <i class="icofont-search-1"></i>
                    </button>
                    <!-- <input class="btn btn-primary" type="submit" value="Buscar"> -->
                    <input class="border rounded form-control" type="text" style="font-family: Open Sans, sans-serif;" placeholder="Buscar por NIS o nombre del contribuyente" name="busqueda" id="busqueda" value="<?php echo $busqueda ?>">
                </div>
            </form>
            <div style="padding-top: 1em;">
                <div class="table-wrap table-hover">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr>
                                <th>ID</th>
                                <th>NIS</th>
                                <th>Titular</th>
                                <th>Colonia</th>
                                <th>Calle</th>
                                <th>Casa</th>
                                <th>Tributación</th>
                                <th>Acciones</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($est_cuenta as $datos) { ?>
                                <tr>
                                    <td style="vertical-align:middle;"><?php echo $datos->idcontribuyente; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $datos->nc; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $datos->titular; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $datos->distrito; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $datos->calle; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $datos->n_casa; ?></td>
                                    <td style="vertical-align:middle;"><?php echo $datos->nombre; ?></td>
                                    <td style="vertical-align:middle;" colspan="2">
                                        <a href="<?php echo base_url('') ?>index.php/cnt_cuentasc/total_tasas/<?php echo $datos->nc; ?>">
                                            <button class="btn-primario" title="Pago total">
                                                <i class="icofont-dollar-plus" style="font-size: 1.3em;"></i>
                                            </button>
                                        </a> &emsp;
                                        <a href="<?php echo base_url('') ?>index.php/cnt_cuentasc/parcial_tasas/<?php echo $datos->nc; ?>">
                                            <button class="btn-primario" title="Pago parcial">
                                                <i class="icofont-page" style="font-size: 1.3em;"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <nav>
                    <ul class="pagination nav justify-content-center">
                        <?php
                        $prev = $current_pag--; //configuracion de boton PREV para navegar sobre la paginacion
                        $next = $prev + 2; //configuracion del botn NEXT para navegar sobre la paginacion

                        if ($prev <= 0) {
                            $prev = 1; //validacion paraque no existan numeracion negativa
                        }
                        if ($next > $last_page) {
                            $next = $last_page; //validacion para establecer limite de paginacion
                        }
                        ?>
                        <li class="page-item"><a class="page-link" href="<?php echo base_url('') . "index.php/cnt_cuentasc/contri_pagos/" . $prev ?>/?busqueda=<?php echo $busqueda ?>">&#8636;</a>
                        </li>
                        <?php
                        for ($i = 1; $i <= $last_page; $i++) {
                        ?>
                            <li class="page-item"><a class="page-link" href="<?php echo base_url('') . "index.php/cnt_cuentasc/contri_pagos/" . $i ?>/?busqueda=<?php echo $busqueda ?>"><?php echo $i ?></a></li>
                        <?php
                        }
                        ?>
                        <li class="page-item"><a class="page-link" href="<?php echo base_url('') . "index.php/cnt_cuentasc/contri_pagos/" . $next ?>/?busqueda=<?php echo $busqueda ?>">&#8640;</a></li>
                    </ul>
                </nav>
            </div>
        </div><!-- End Appointment Div -->
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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