<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SCA-SJV | PAGO PARCIAL</title>
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

        #m_cancel {
            font-size: 1.2em;
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

        .btn-del {
            background: #FD4B4B;
            border: 0;
            padding: 5px 10px;
            color: #fff;
            transition: 0.4s;
            border-radius: 5px;
        }

        .btn-del:hover {
            background: #FF9696;
            color: #000;
        }

        .input-periodo {
            border: none;
            width: 6em;
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
                <h2>Pago parcial</h2>
            </div>

            <form method="POST" data-aos="fade-up" data-aos-delay="100">
                <div class="form-row">
                    <div class="col-md-2 form-group">
                        <label class="titu">NC</label>
                        <input readonly type="text" name="nis" id="nis" class="form-control" value="<?php echo $contri->nc; ?>">
                    </div>
                    <div class="col-md-2 form-group" id="divAnio">
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
                    <!-- BOTON PARA OBTENER DATOS SEGUN AÑO -->
                    <!-- <div class="col-md-2 form-group">
                        <button type="submit" name="obtener" class="btn-primario btn_act">Consultar tasas de cobro</button>
                    </div> -->
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
                    <div class="col-md form-group">
                        <label class="titu">Dirección</label>
                        <input readonly type="text" name="direc" id="direc" class="form-control" value="<?php echo $contri->direccion; ?>">
                    </div>
                </div>

                <div class="table-wrap table-hover">
                    <label class="titu">Registro de pagos</label>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr>
                                <th>Emisión</th>
                                <th># Meses</th>
                                <th>Periodo</th>
                                <th>Alum</th>
                                <th>Aseo</th>
                                <th>Pavi</th>
                                <th>Mensualidad</th>
                                <th>Sub-Total</th>
                                <th>Multa</th>
                                <th>Interes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="m_cancel">
                                    [IDESTADOCUENTA]
                                </td>
                                <td id="m_cancel">
                                    [CNT_MESES]
                                </td>
                                <td id="m_cancel">
                                    [PERIODO]
                                </td>
                                <td id="m_cancel">
                                    [ALUMBRADO_EC]
                                </td>
                                <td id="m_cancel">
                                    [ASEO_EC]
                                </td>
                                <td id="m_cancel">
                                    [PAVIMENTO_EC]
                                </td>
                                <td id="m_cancel">
                                    [MENSUALIDAD_EC]
                                </td>
                                <td id="m_cancel">
                                    [COBRO_PERIODO]
                                </td>
                                <td id="m_cancel">
                                    [MULTA_PARCIAL]
                                </td>
                                <td id="m_cancel">
                                    [INTERES_PARCIAL]
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>

                <div class="form-row">
                    <div class="col-md-2 form-group">
                        <label class="titu">Cantidad de meses</label>
                        <input type="text" name="cnt_meses" id="cnt_meses" class="form-control" value="PHP MESES CNT">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">Sub-Total</label>
                        <input type="text" name="sub_t" id="sub_t" class="form-control" value="PHP SUB-TOT">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">5% Fiesta</label>
                        <input type="text" name="fiest" id="fiest" class="form-control" value="PHP 5% FIESTA">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">Mora</label>
                        <input type="text" name="mora" id="mora" class="form-control" value="PHP MORA">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">Interes</label>
                        <input type="text" name="interes" id="interes" class="form-control" value="PHP INTERES">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">TOTAL</label>
                        <input type="text" name="total_ap" id="total_ap" class="form-control" value="PHP TOTAL">
                    </div>
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

<!-- SCRIPT PARA EL DROPDOWN O SELECT DINAMICO -->
<script>
    $(document).ready(function() {
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
    });
</script>