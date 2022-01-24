<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SCA-SJV | PAGO TOTAL</title>
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

        .titu {
            font-weight: bold;
        }

        label,
        input,
        textarea,
        td,
        th,
        .btn_act {
            font-family: 'Asap Condensed', sans-serif;
        }

        .radio-container {
            padding-left: 5px;
            padding-top: 10px;
            margin-right: 1em;
        }

        .btn-primario {
            background: #2e5ab9;
            border: 0;
            padding: 10px 35px;
            color: #fff;
            transition: 0.4s;
            border-radius: 50px;
        }

        .btn-primario:hover {
            background: #65BEF3;
            color: #000;
        }
    </style>

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

            <a class="logo mr-auto" href="<?php echo base_url("index.php/cnt_cuentasc/contri_pagos"); ?>">
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
                <h2>Registro de pago | Total</h2>
            </div>

            <form method="POST" data-aos="fade-up" data-aos-delay="100">
                <div class="form-row">
                    <div class="col-md-2 form-group">
                        <label class="titu">NC</label>
                        <input readonly type="text" name="nis" id="nis" class="form-control" value="<?php echo $contri->nc; ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">Emision</label>
                        <select class="form-control d-xl-flex" style="font-family: 'Asap Condensed', sans-serif;" name="emision" id="emision" required>
                            <option value="<?php if (isset($emision->idestadocuenta)) {
                                                echo $emision->idestadocuenta;
                                            } ?>" selected="selected">
                                <?php if (isset($emision->idestadocuenta)) {
                                    echo $emision->idestadocuenta;
                                } else {
                                    echo "Seleccione uno";
                                } ?>
                            </option>
                            <?php foreach ($emision as $em) { ?>
                                <option value="<?php echo $em->idestadocuenta; ?>">
                                    <?php echo $em->idestadocuenta; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">Año</label>
                        <select class="form-control d-xl-flex" style="font-family: 'Asap Condensed', sans-serif;" name="anio" id="anio" required>
                            <option value="">Seleccione uno</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label class="titu">Contribuyente</label>
                        <input readonly type="text" name="contri" id="contri" class="form-control" value="<?php echo $contri->contribuyente; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="titu">Propietario</label>
                        <input readonly type="text" name="prop" id="prop" class="form-control" value="<?php echo $contri->propietario; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label class="titu">Dirección</label>
                        <input readonly type="text" name="direc" id="direc" class="form-control" value="<?php echo $contri->direccion; ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="titu">Tributación</label>
                        <input readonly type="text" name="trib" id="trib" class="form-control" value="<?php echo $tributo->nombre; ?>">
                    </div>
                </div>
                
                <hr>
                <div class="table-wrap table-hover">
                    <label class="titu">Detalle del estado de cuenta</label>
                    <table class="table" name="detalle" id="detalle">
                        <thead class="thead-primary">
                            <tr>
                                <th>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="icofont-search-folder" style="font-size: 1.7em;"></i>&emsp;
                                    Seleccione el número de emision
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="table-wrap table-hover">
                    <label class="titu">Registro de pagos</label>
                    <table class="table" name="r_pagos" id="r_pagos">
                        <thead class="thead-primary">
                            <tr>
                                <th>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="icofont-search-folder" style="font-size: 1.7em;"></i>&emsp;
                                    Seleccione un año
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div>
                    <label class="titu">Meses cancelados</label>
                    <div class="form-row" style="margin-left: 7%; margin-right: 7%; margin-bottom:2%">
                        <input type="checkbox" name="ene" id="ene">
                        <label class="radio-container" for="ene">Enero</label>

                        <input type="checkbox" name="feb" id="feb">
                        <label class="radio-container" for="feb">Febrero</label>

                        <input type="checkbox" name="mar" id="mar">
                        <label class="radio-container" for="mar">Marzo</label>

                        <input type="checkbox" name="abr" id="abr">
                        <label class="radio-container" for="abr">Abril</label>

                        <input type="checkbox" name="may" id="may">
                        <label class="radio-container" for="may">Mayo</label>

                        <input type="checkbox" name="jun" id="jun">
                        <label class="radio-container" for="jun">Junio</label>

                        <input type="checkbox" name="jul" id="jul">
                        <label class="radio-container" for="jul">Julio</label>

                        <input type="checkbox" name="ago" id="ago">
                        <label class="radio-container" for="ago">Agosto</label>

                        <input type="checkbox" name="sep" id="sep">
                        <label class="radio-container" for="sep">Septiembre</label>

                        <input type="checkbox" name="oct" id="oct">
                        <label class="radio-container" for="oct">Octubre</label>

                        <input type="checkbox" name="nov" id="nov">
                        <label class="radio-container" for="nov">Noviembre</label>

                        <input type="checkbox" name="dic" id="dic">
                        <label class="radio-container" for="dic">Diciembre</label>
                    </div>
                </div>
                <hr>

                <div class="form-row">
                    <div class="col-md-2 form-group">
                        <label class="titu">Cnt. meses</label>
                        <input type="text" name="cnt_meses" id="cnt_meses" class="form-control" readonly value="-------">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">Sub-Total</label>
                        <input type="text" name="sub_t" id="sub_t" class="form-control" readonly value="-------">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">5% Fiesta</label>
                        <input type="text" name="fiest" id="fiest" class="form-control" readonly value="-------">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">Mora</label>
                        <input type="text" name="mora" id="mora" class="form-control" readonly value="-------">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">Interes</label>
                        <input type="text" name="interes" id="interes" class="form-control" readonly value="-------">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">TOTAL</label>
                        <input type="text" name="total_ap" id="total_ap" class="form-control" readonly value="-------">
                    </div>
                </div>

                <div class="form-group">
                    <textarea class="form-control" name="comentarios" id="comentarios" maxlength="250" placeholder="Comentarios (Campo opcional)"><?php if (isset($observaciones)) {
                                                                                                                                                        echo $observaciones;
                                                                                                                                                    } ?></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" name="cobro_total" class="btn-primario btn_act">Registrar pago</button>
                    <!-- <a href="<?php echo base_url(''); ?>index.php/cnt_cuentasc/tasas_pdf/<?php if (isset($nroEmision)) {
                                                                                                    echo $nroEmision;
                                                                                                } ?>" class="btn-primario" target="_blank"><i class="icofont-print"></i></a> -->
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
    <script src="<?php echo base_url(''); ?>assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/counterup/counterup.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/venobox/venobox.min.js"></script>
    <script src="<?php echo base_url(''); ?>assets/vendor/aos/aos.js"></script>

    <!-- Template Main JS File -->
    <script src="<?php echo base_url(''); ?>assets/js/main.js"></script>

</body>

</html>


<!-- SCRIPT PARA LLENAR TABLA SEGUN ESTADO DE CUENTA -->
<script>
    $(document).ready(function() {
        //funcion para generar el detalle total del estado de cuenta
        $('#emision').change(function() {
            var idcuenta = $('#emision').val();
            if (idcuenta != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/detalle_tasas",
                    method: "POST",
                    data: {
                        idcuenta: idcuenta
                    },
                    success: function(data) {
                        $('#detalle').html(data);
                    }
                })
            }
        });

        //funcion para listar los años registraedos en un estado de cuenta especifico
        $('#emision').change(function() {
            var idcuenta = $('#emision').val();
            if (idcuenta != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/tasas_anio",
                    method: "POST",
                    data: {
                        idcuenta: idcuenta
                    },
                    success: function(data) {
                        $('#anio').html(data);
                    }
                })
            }
        });

        //funcion para obtener el detalle del estado de cuenta segun el año seleccionado
        $('#anio').change(function() {
            var idcuenta = $('#emision').val();
            var anio = $('#anio').val();
            if (anio != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/detalleT_anio",
                    method: "POST",
                    data: {
                        idcuenta: idcuenta,
                        anio: anio
                    },
                    success: function(data) {
                        $('#detalle').html(data);
                    }
                })
            }
        });

        //funcion para obtener el registro de pagos segun el año seleccionado
        $('#anio').change(function() {
            var nis = $('#nis').val();
            var anio = $('#anio').val();
            if (anio != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/rp_anio",
                    method: "POST",
                    data: {
                        nis: nis,
                        anio: anio
                    },
                    success: function(data) {
                        $('#r_pagos').html(data);
                    }
                })
            }
        });

        //funcion para obtener la suma de meses segun el año seleccionado
        $('#anio').change(function() {
            var idcuenta = $('#emision').val();
            var anio = $('#anio').val();
            if (anio != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/dtts_meses",
                    method: "POST",
                    data: {
                        idcuenta: idcuenta,
                        anio: anio
                    },
                    success: function(data) {
                        $('#cnt_meses').val(data);
                    }
                })
            }
        });

        //funcion para obtener la suma del subtotal segun el año seleccionado
        $('#anio').change(function() {
            var idcuenta = $('#emision').val();
            var anio = $('#anio').val();
            if (anio != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/dtts_sub",
                    method: "POST",
                    data: {
                        idcuenta: idcuenta,
                        anio: anio
                    },
                    success: function(data) {
                        $('#sub_t').val(data);
                    }
                })
            }
        });

        //funcion para obtener la suma de los intereses segun el año seleccionado
        $('#anio').change(function() {
            var idcuenta = $('#emision').val();
            var anio = $('#anio').val();
            if (anio != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/dtts_interes",
                    method: "POST",
                    data: {
                        idcuenta: idcuenta,
                        anio: anio
                    },
                    success: function(data) {
                        $('#interes').val(data);
                    }
                })
            }
        });

        //funcion para obtener el 5% de fiesta segun el año seleccionado
        $('#anio').change(function() {
            var idcuenta = $('#emision').val();
            var anio = $('#anio').val();
            if (anio != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/dtts_fiesta",
                    method: "POST",
                    data: {
                        idcuenta: idcuenta,
                        anio: anio
                    },
                    success: function(data) {
                        $('#fiest').val(data);
                    }
                })
            }
        });

        //funcion para obtener el calculo de mora segun el año seleccionado
        $('#anio').change(function() {
            var idcuenta = $('#emision').val();
            var anio = $('#anio').val();
            if (anio != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/dtts_mora",
                    method: "POST",
                    data: {
                        idcuenta: idcuenta,
                        anio: anio
                    },
                    success: function(data) {
                        $('#mora').val(data);
                    }
                })
            }
        });

        //funcion para obtener el cobro total segun el año seleccionado
        $('#anio').change(function() {
            var idcuenta = $('#emision').val();
            var anio = $('#anio').val();
            if (anio != '') {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/cnt_cuentasc/dtts_total",
                    method: "POST",
                    data: {
                        idcuenta: idcuenta,
                        anio: anio
                    },
                    success: function(data) {
                        $('#total_ap').val(data);
                    }
                })
            }
        });
        
    });
</script>