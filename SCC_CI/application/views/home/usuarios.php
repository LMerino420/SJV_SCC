<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SCA-SJV | LISTA DE USUARIOS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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

    <link rel="stylesheet" href="css/style.css">

    <style>
        font {
            text-transform: uppercase;
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

            <a class="logo mr-auto" href="<?php echo base_url("index.php/cnt_home/registro"); ?>">
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
                <h2>Lista de usuarios registrados </h2>
            </div>
            <div class="container" style="padding: 20px 0px;">
                <form action="" method="POST" class="form">
                    <input class="border rounded form-control" type="text" style="font-family: 'Asap Condensed', sans-serif;" placeholder="Buscar por nombre de usuario" name="busqueda" id="busqueda">
                    <!--<input type="submit" value="Buscar">-->
                </form>
            </div>

            <div class="container" style="padding-top: 2em;">
                <div class="table-wrap table-hover">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Usuario</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista_usuarios as $datos) { ?>
                                <tr>
                                    <td><?php echo $datos->iduser; ?></td>
                                    <td><?php echo $datos->u_nombre; ?></td>
                                    <td><?php echo $datos->u_apellidos; ?></td>
                                    <td><?php echo $datos->usuario; ?></td>
                                    <td><?php echo $datos->perfil; ?></td>
                                    <td><?php 
                                            if($datos->estado == 1)
                                            {
                                                echo 'Activo';
                                            } else {
                                                echo 'Inactivo';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('') ?>index.php/cnt_home/edit_usr/<?php echo $datos->iduser; ?>">
                                            <button class="btn btn-success" value="editar" tittle="Editar">Editar</button>
                                        </a>
                                        <a href="<?php echo base_url('') ?>index.php/cnt_home/delete_usr/<?php echo $datos->iduser; ?>">
                                            <button class="btn btn-danger" value="eliminar" tittle="Eliminar">Eliminar</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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
                            <li class="page-item">
                                <a class="page-link" href="<?php echo base_url('') . "index.php/cnt_home/usuarios/" . $prev ?>">&#8636;</a>
                            </li>
                            <?php
                            for ($i = 1; $i <= $last_page; $i++) {
                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo base_url('') . "index.php/cnt_home/usuarios/" . $i ?>"><?php echo $i ?>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo base_url('') . "index.php/cnt_home/usuarios/" . $next ?>">&#8640;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
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