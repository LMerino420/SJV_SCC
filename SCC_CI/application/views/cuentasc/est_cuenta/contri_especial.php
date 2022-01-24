<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SCA-SJV | CONTRIBUCIÓN ESPECIAL</title>
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

            <a class="logo mr-auto" href="<?php echo base_url("index.php/cnt_cuentasc/contribuyentes"); ?>">
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
                <h2>Estado de cuenta | Contribución Especial</h2>
                <h3><?php if (isset($get_rpagos)) {
                        echo $get_rpagos->anio;
                    } ?></h3>
            </div>

            <form method="POST" data-aos="fade-up" data-aos-delay="100">

                <div class="form-row">
                    <div class="col-md-2 form-group">
                        <label class="titu">Emisión #</label>
                        <input readonly type="text" name="numEstCuenta" id="numEstCuenta" class="form-control" value="<?php if (isset($nroEmision)) {
                                                                                                                            echo $nroEmision;
                                                                                                                        } else {
                                                                                                                            echo $nro_cuenta->nro + 1;
                                                                                                                        } ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="titu">NC</label>
                        <input readonly type="text" name="nis" id="nis" class="form-control" value="<?php echo $contri->nc; ?>">
                    </div>
                    <div class="col-md-2 form-group" id="divAnio">
                        <label class="titu">Año</label>
                        <select class="form-control d-xl-flex" style="font-family: 'Asap Condensed', sans-serif;" name="anio" required>
                            <option value="<?php if (isset($get_rpagos->anio)) {
                                                echo $get_rpagos->anio;
                                            } ?>" selected="selected"><?php if (isset($get_rpagos->anio)) {
                                                                            echo $get_rpagos->anio;
                                                                        } else {
                                                                            echo "Seleccione uno";
                                                                        } ?></option>
                            <?php foreach ($get_anio as $anio) { ?>
                                <option value="<?php echo $anio["anio"]; ?>">
                                    <?php echo $anio["anio"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <button type="submit" name="obtener" class="btn-primario btn_act">Consultar tasas de cobro</button>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md form-group">
                        <label class="titu">Contribuyente</label>
                        <input readonly type="text" name="contri" id="contri" class="form-control" value="<?php echo $contri->titular; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md form-group">
                        <label class="titu">Propietario</label>
                        <input readonly type="text" name="prop" id="prop" class="form-control" value="<?php if ($contri->propietario == null) {
                                                                                                            echo $contri->titular;
                                                                                                        } else {
                                                                                                            echo $contri->propietario;
                                                                                                        }
                                                                                                        ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3 form-group">
                        <label class="titu">Ubicación</label>
                        <input readonly type="text" name="ubi" id="ubi" class="form-control" value="<?php if ($contri->poblacion == null) {
                                                                                                        echo 'No se ha establecido ubicacion';
                                                                                                    } else {
                                                                                                        echo $contri->poblacion;
                                                                                                    } ?>">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titu">Colonia</label>
                        <input readonly type="text" name="col" id="col" class="form-control" value="<?php echo $contri->distrito; ?>">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titu">Calle/pasaje</label>
                        <input readonly type="text" name="calle_pje" id="calle_pje" class="form-control" value="<?php echo $contri->calle; ?>">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titu">Casa</label>
                        <input readonly type="text" name="casa" id="casa" class="form-control" value="<?php echo $contri->n_casa; ?>">
                    </div>
                </div>

                <div class="form-row" id="divTCobros">
                    <div class="col-md-3 form-group">
                        <label class="titu">Tasa mensual</label>
                        <input readonly type="text" name="mensual" id="mensual" class="form-control" value="<?php if (isset($get_tcobros)) {
                                                                                                                echo $get_tcobros->mensualidad;
                                                                                                            }
                                                                                                            ?>">
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="titu">Aseo</label>
                        <input readonly type="text" name="aseo" id="aseo" class="form-control" value="<?php if (isset($get_tcobros)) {
                                                                                                            echo $get_tcobros->aseo;
                                                                                                        }
                                                                                                        ?>">
                    </div>
                </div>
                <hr>

                <div class="table-wrap table-hover">
                    <label class="titu">Registro de pagos</label>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr>
                                <th>ENE</th>
                                <th>FEB</th>
                                <th>MAR</th>
                                <th>ABR</th>
                                <th>MAY</th>
                                <th>JUN</th>
                                <th>JUL</th>
                                <th>AGO</th>
                                <th>SEP</th>
                                <th>OCT</th>
                                <th>NOV</th>
                                <th>DIC</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($get_rpagos)) { ?>
                                <tr>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->ene) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->ene) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->feb) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->feb) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->mar) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->mar) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->abr) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->abr) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->may) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->may) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->jun) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->jun) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->jul) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->jul) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->ago) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->ago) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->sep) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->sep) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->oct) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->oct) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->nov) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->nov) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                    <td id="m_cancel">
                                        <?php if (($get_rpagos->dic) > 0) { ?>
                                            <i style="color: green;" class="icofont-verification-check"></i>
                                        <?php } else if (($get_rpagos->dic) == null) { ?>
                                            <i style="color: black;" class="icofont-minus"></i>
                                        <?php } else { ?>
                                            <i style="color: red;" class="icofont-error"></i>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="12"><i class="icofont-search-folder"></i>&nbsp;Sin registros</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><br>

                <div>
                    <label class="titu">Meses a calcular</label>
                    <div class="form-row" style="margin-left: 7%; margin-right: 7%; margin-bottom:2%">
                        <input type="checkbox" name="ene" id="ene" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->ene == null || $get_rpagos->ene > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="ene">Enero</label>

                        <input type="checkbox" name="feb" id="feb" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->feb == null || $get_rpagos->feb > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="feb">Febrero</label>

                        <input type="checkbox" name="mar" id="mar" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->mar == null || $get_rpagos->mar > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="mar">Marzo</label>

                        <input type="checkbox" name="abr" id="abr" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->abr == null || $get_rpagos->abr > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="abr">Abril</label>

                        <input type="checkbox" name="may" id="may" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->may == null || $get_rpagos->may > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="may">Mayo</label>

                        <input type="checkbox" name="jun" id="jun" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->jun == null || $get_rpagos->jun > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="jun">Junio</label>

                        <input type="checkbox" name="jul" id="jul" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->jul == null || $get_rpagos->jul > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="jul">Julio</label>

                        <input type="checkbox" name="ago" id="ago" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->ago == null || $get_rpagos->ago > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="ago">Agosto</label>

                        <input type="checkbox" name="sep" id="sep" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->sep == null || $get_rpagos->sep > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="sep">Septiembre</label>

                        <input type="checkbox" name="oct" id="oct" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->oct == null || $get_rpagos->oct > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="oct">Octubre</label>

                        <input type="checkbox" name="nov" id="nov" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->nov == null || $get_rpagos->nov > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="nov">Noviembre</label>

                        <input type="checkbox" name="dic" id="dic" <?php if (isset($get_rpagos)) {
                                                                        if ($get_rpagos->dic == null || $get_rpagos->dic > 0) {
                                                                            echo "disabled";
                                                                        } else {
                                                                            echo "checked";
                                                                        }
                                                                    } ?>>
                        <label class="radio-container" for="dic">Diciembre</label>
                    </div>
                </div>

                <hr><label class="titu">Calculo de cobro</label>
                <div class="form-row">
                    <div class="col-md-2 form-group">
                        <label>Desde:</label>
                        <input type="date" name="periodo_desde" id="periodo_desde" class="form-control" value="<?php if (isset($desde)) {
                                                                                                                    echo $desde;
                                                                                                                } ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Hasta:</label>
                        <input type="date" name="periodo_hasta" id="periodo_hasta" class="form-control" value="<?php if (isset($hasta)) {
                                                                                                                    echo $hasta;
                                                                                                                } ?>">
                    </div>
                    <div class="col-md-1 form-group">
                        <label>Transcurridos</label>
                        <input readonly type="number" name="meses" id="meses" class="form-control" value="<?php if (isset($MesesPeriodo)) {
                                                                                                                echo $MesesPeriodo;
                                                                                                            } ?>">
                    </div>
                    <div class="col-md-1 form-group">
                        <label>Con recargo</label>
                        <input readonly type="number" name="meses" id="meses" class="form-control" value="<?php if (isset($MesesRetraso)) {
                                                                                                                echo $MesesRetraso;
                                                                                                            } ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Sub-total</label>
                        <input readonly type="number" name="subtotal" id="subtotal" class="form-control" value="<?php if (isset($SubTotPeriodo)) {
                                                                                                                    echo $SubTotPeriodo;
                                                                                                                } ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Multa parcial</label>
                        <input readonly type="number" name="multa_parcial" id="multa_parcial" class="form-control" value="<?php if (isset($multa_par)) {
                                                                                                                                echo $multa_par;
                                                                                                                            } ?>">
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Interes parcial</label>
                        <input readonly type="number" name="interes_parcial" id="interes_parcial" class="form-control" value="<?php if (isset($interes_par)) {
                                                                                                                                    echo $interes_par;
                                                                                                                                } ?>">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="calcular" class="btn-primario btn_act">Calcular</button>
                    <button type="submit" name="agregar" title="Agregar periodo de tributación" class="btn-primario"><i class="icofont-ui-add"></i></button>
                </div>
                <hr>

                <div class="table-wrap table-hover">
                    <label class="titu">Detalle del estado de cuenta</label>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr>
                                <th>Año</th>
                                <th>Meses</th>
                                <th>Periodo</th>
                                <th>Aseo</th>
                                <th>Mensualidad</th>
                                <th>Sub-total</th>
                                <th>Multa parcial</th>
                                <th>Interes parcial</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($detalle_cuenta)) {
                                foreach ($detalle_cuenta as $detalle) { ?>
                                    <tr>
                                        <td><?php echo $detalle->anio ?></td>
                                        <td><?php echo $detalle->cnt_meses ?></td>
                                        <td><input class="input-periodo" type="text" value="<?php echo $detalle->periodo ?>" name="periodo_td"></td>
                                        <td><?php echo $detalle->aseo_ec ?></td>
                                        <td><?php echo $detalle->mensualidad_ec ?></td>
                                        <td><?php echo $detalle->cobro_periodo ?></td>
                                        <td><?php echo $detalle->multa_parcial ?></td>
                                        <td><?php echo $detalle->interes_parcial ?></td>
                                        <td align="center">
                                            <button type="submit" name="eliminar" value="<?php echo $detalle->periodo ?>" class="btn-del"><i class="icofont-ui-delete"></i></button>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="11"><i class="icofont-search-folder"></i>&nbsp;Sin registros</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><br>
                <hr>

                <div>
                    <label class="titu">Montos de cobro totales</label>
                    <div class="form-row">
                        <div class="col-md-2 form-group">
                            <label>Meses transcurridos</label>
                            <input readonly type="number" name="tot_meses" id="tot_meses" class="form-control" value="<?php if (isset($suma_meses)) {
                                                                                                                            echo $suma_meses;
                                                                                                                        } ?>">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Total parcial</label>
                            <input readonly type="number" name="tot_calculo" id="tot_calculo" class="form-control" value="<?php if (isset($suma_cobros)) {
                                                                                                                                echo $suma_cobros;
                                                                                                                            } ?>">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>5% (Fiesta)</label>
                            <input readonly type="number" name="tot_fiesta" id="tot_fiesta" class="form-control" value="<?php if (isset($fiesta)) {
                                                                                                                            echo $fiesta;
                                                                                                                        } ?>">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Mora/Multa</label>
                            <input readonly type="number" name="tot_mora" id="tot_mora" class="form-control" value="<?php if (isset($suma_mora)) {
                                                                                                                        echo $suma_mora;
                                                                                                                    } ?>">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Intereses</label>
                            <input readonly type="number" name="tot_interes" id="tot_interes" class="form-control" value="<?php if (isset($suma_interes)) {
                                                                                                                                echo $suma_interes;
                                                                                                                            } ?>">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Total a pagar</label>
                            <input readonly type="number" name="tot_pagar" id="tot_pagar" class="form-control" value="<?php if (isset($total)) {
                                                                                                                            echo $total;
                                                                                                                        } ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <textarea class="form-control" name="observacion" id="observacion" maxlength="250" placeholder="Observaciones (Campo opcional)"><?php if (isset($observaciones)) {
                                                                                                                                                        echo $observaciones;
                                                                                                                                                    } ?></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" name="cobro_total" class="btn-primario btn_act">Calcular cobro total</button>
                    <a href="<?php echo base_url(''); ?>index.php/cnt_cuentasc/especial_pdf/<?php if (isset($nroEmision)) {
                                                                                                echo $nroEmision;
                                                                                            } ?>" class="btn-primario" target="_blank"><i class="icofont-print"></i></a>
                    <!-- <button type="submit" name="imprimir" class="btn-primario" title="Imprimir estado de cuenta"><i class="icofont-print"></i></button> -->
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