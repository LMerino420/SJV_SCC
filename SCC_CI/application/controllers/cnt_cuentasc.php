<?php
class cnt_cuentasc extends CI_Controller
{
    //metodo constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('md_parametros');
        $this->load->model('md_contribuyente');
        $this->load->model('md_estadocuenta');
        $this->load->model('md_parametros');
        $this->load->model('md_regpago');
    }

    //--------------------------------------------PARAMETROS--------------------------------------------//
    public function parametros()
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }
        $data['param'] = $this->md_parametros->get_parametros();
        $this->load->view('cuentasc/parametros', $data);
    }

    //--------------------------------------------ACTUALIZAR VALOR DEL PARAMETRO--------------------------------------------//
    public function update_param()
    {
        // echo "<script type='text/javascript'>alert('EJECUTO EL METODO');</script>";
        $id = $_POST['p_id'];
        $val = $_POST['p_value'];

        if ($this->md_parametros->upd_parametros($id, $val) != null) {
            redirect("cnt_cuentasc/parametros", "refresh");
        }
    }

    //--------------------------------------------CONTRIBUYENTES--------------------------------------------//
    public function contribuyentes($pag = 1)
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }

        //variables de configuracion para la paginacion
        $pag--;

        if ($pag < 0) {
            $pag = 0;
        }

        $page_size = 100;
        $offset = $pag * $page_size;

        $buscar = $this->input->get('busqueda');

        $data['contrib'] = $this->md_contribuyente->countContri($buscar);
        $data['est_cuenta'] = $this->md_contribuyente->pagContri($page_size, $offset, $buscar);
        $data['current_pag'] = $pag++;
        $data['busqueda'] = $buscar;
        $data['last_page'] = ceil($this->md_contribuyente->countContri($buscar) / $page_size);
        $this->load->view('cuentasc/contribuyentes', $data);
    }

    //--------------------------------------------CONTRIBUYENTES PARA REGISRTRO DE PAGO--------------------------------------------//
    public function buscar_lista()
    {
        redirect("cnt_cuentasc/contribuyentes/1/?busqueda=" . $this->input->get('busqueda'));
    }

    //--------------------------------------------ASIGNAR TIPO DE TRIBUTACION--------------------------------------------//
    public function update_tributacion()
    {

        $id = $_POST['trib_id'];
        $val = $_POST['trib_tipo'];
        if (!empty($val)) {
            if ($this->md_contribuyente->upd_tributacion($id, $val) != null) {
                redirect("cnt_cuentasc/contribuyentes", "refresh");
            }
            echo "<script type='text/javascript'>alert('No fue posible asignar el tipo de tributación');</script>";
        }
        redirect("cnt_cuentasc/contribuyentes", "refresh");
    }

    //--------------------------------------------EstCuenta TASAS MUNICIPALES--------------------------------------------//
    public function tasas($idcontri = null)
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }

        if ($idcontri !== null) //se verifica que se haya seleccionado un contribuyente
        {
            $idcontri = $this->db->escape((int)$idcontri); //obtener el id del contribuyente seleccionado

            //VARIABLES PARA CARGAR DATOS A LA VISTA detalle_cta
            $data['contri'] = $this->md_contribuyente->get_Contri($idcontri);
            $data['get_anio'] = $this->md_contribuyente->get_anio($idcontri);
            $data['nro_cuenta'] = $this->md_estadocuenta->max_EstadoCuenta();
            $data['detalle_cuenta'] = null;

            //VARIABLES PARA OBTENER TASAS DE COBRO Y PAGOS REGISTRADOS
            $data['get_tcobros'] = null;
            $data['get_rpagos'] = null;

            if (isset($_POST['obtener'])) {
                $anio = $this->input->POST('anio');
                $anioTC = 0;

                //obtener la tasa de cobros de 2010 a 2012 que se mantiene igual para todos los contribuyentes
                if ($anio >= 2010 && $anio <= 2012) {
                    $anioTC = 2012;
                } else {
                    $anioTC = $anio;
                }

                $data['get_tcobros'] = $this->md_contribuyente->get_tcobros($idcontri, $anioTC);
                $data['get_rpagos'] = $this->md_contribuyente->get_rpagos($idcontri, $anio);
                $data['nroEmision'] = null;

                //ARREGLO PARA ALMACENAR LOS DATOS DEL ENCABEZADO
                $encabezado_input = array();
                $validar = $this->db->query("SELECT * FROM enc_tasas WHERE idestadocuenta = ?", $_POST['numEstCuenta'])->result_array();

                if (empty($validar)) {
                    //VARIABLES PARA GENERAR LA DIRECCION
                    $a = "";
                    if ($this->input->POST('ubi') != "No se ha establecido ubicacion") {
                        $a = $this->input->POST('ubi');
                    }
                    $b = $this->input->POST('col');
                    $c = $this->input->POST('calle_pje');
                    $direc = $a . ' ' . $b . ' ' . $c;
                    $emitido = date('d-m-Y');

                    //DATOS DEL ENCABEZADO
                    $encabezado_input['nc'] = $this->input->POST('nis');
                    $encabezado_input['contribuyente'] = $this->input->POST('contri');
                    $encabezado_input['propietario'] = $this->input->POST('prop');
                    $encabezado_input['direccion'] = $direc;
                    $encabezado_input['emitido'] = $emitido;

                    $chk_Encabezado = $this->md_estadocuenta->add_EncEstadoCuentas($encabezado_input);
                    if ($chk_Encabezado > 0) {
                        $data['nroEmision'] = $this->md_estadocuenta->max_EstadoCuenta()->nro;
                        $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEstCuenta($this->md_estadocuenta->max_EstadoCuenta()->nro);
                    }
                } else {
                    $data['nroEmision'] = $this->md_estadocuenta->max_EstadoCuenta()->nro;
                    $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEstCuenta($this->md_estadocuenta->max_EstadoCuenta()->nro);
                }
            }

            //VARIABLES PARA GUARDAR LA CANTIDAD DE MESES TRANSCURRIDOS POR PERIODO Y EL SUBTOTAL GENERADO
            $data['MesesPeriodo'] = null;
            $data['SubTotPeriodo'] = null;

            if (isset($_POST['calcular'])) {
                //VARIABLES PARA NO PERDER LOS DATOS DE LAS TASAS COBRADAS
                $anio = $this->input->POST('anio');
                $anioTC = 0;

                //comparador para obtener la tasa de cobros de 2010 a 2012 que se mantiene igual para todos los contribuyentes
                if ($anio >= 2010 && $anio <= 2012) {
                    $anioTC = 2012;
                } else {
                    $anioTC = $anio;
                }

                $fch_desde = $this->input->post('periodo_desde');
                $fch_hasta = $this->input->post('periodo_hasta');
                $alum = $this->input->post('alum');
                $aseo = $this->input->post('aseo');
                $pavi = $this->input->post('pav');

                //VARIABLES PARA CALCULO DE MESES TRANSCURRIDOS
                $meses_transcurridos = $this->md_estadocuenta->get_MesesTranscurridos($fch_desde, $fch_hasta)->meses;
                $diferencia_meses = $this->md_estadocuenta->Diferencia_fechas($fch_desde)->meses;
                $meses_ciclo = $this->md_estadocuenta->Diferencia_fechas($fch_hasta)->meses;

                //VARIABLES PARA OBTENER LOS PORCENTAJES DE COBRO
                $tresM = $this->md_parametros->porcentaje_tresM()->tres_meses;
                $masTres = $this->md_parametros->porcentaje_MastresM()->mas_tres_meses;
                $por_interes = $this->md_parametros->porcentaje_interes()->interes;

                //CALCULO PARCIAL DE COBRO POR PERIODO
                $Mensualidad = $alum + $aseo + $pavi;
                $Mensual = $Mensualidad * ($meses_transcurridos + 1);

                $interes = null;
                $multa_parcial = null;
                $val_ciclo = null;
                $retraso_for = $diferencia_meses - 2;

                //VERIFICACION SI SON MAS DE # MESES DE RETRASO PARA HACER EL COBRO RESPECTIVO
                if ($diferencia_meses >= 3) {

                    //CONDICIONAL PARA ASIGNAR LAS VECES QUE SE REPETIRA EL CICLO FOR PARA LA SUMA DE INTERESES
                    if ($meses_ciclo == 0) {
                        $val_ciclo = $meses_transcurridos - 2;
                    } elseif ($meses_ciclo == 1) {
                        $val_ciclo = $meses_transcurridos - 1;
                    } elseif ($meses_ciclo >= 2) {
                        $val_ciclo = $meses_transcurridos + 1;
                    }

                    //VALIDACION PARA EL CALCULO DE MORA SEGUN LA CANTIDAD DE MESES DE RETRASO
                    if ($diferencia_meses >= 3 and $diferencia_meses <= 5) {
                        $multa_parcial = ($Mensualidad * $tresM) * $val_ciclo;
                    } elseif ($diferencia_meses >= 6) {
                        $multa_parcial = ($Mensualidad * $masTres) * $val_ciclo;
                    }

                    // //CALCULO SEGUN LEY GENERAL TRIBUTARIA MUNICIPAL
                    // if ($diferencia_meses >= 3 and $diferencia_meses <= 5) {
                    //     $multa = ($Mensualidad * $tresM) * $val_ciclo;
                    //     if ($multa <= 2.86) {
                    //         $multa_parcial = 2.86;
                    //     }
                    // } elseif ($diferencia_meses >= 6) {
                    //     $multa = ($Mensualidad * $masTres) * $val_ciclo;
                    //     if ($multa <= 2.86) {
                    //         $multa_parcial = 2.86;
                    //     }
                    // }

                    //LOOP PARA CALCULAR EL TOTAL DEL INTERES PARCIAL
                    for ($i = 1; $i <= $val_ciclo; $i++) {
                        $calculo = $Mensualidad * $retraso_for * $por_interes;
                        $interes = $interes + $calculo;
                        $retraso_for--;
                    }
                }

                //VARIABLES PARA CARGAR DATOS A LA VISTA detalle_cta
                $data['get_tcobros'] = $this->md_contribuyente->get_tcobros($idcontri, $anioTC);
                $data['get_rpagos'] = $this->md_contribuyente->get_rpagos($idcontri, $anio);
                $data['nroEmision'] = $this->md_estadocuenta->max_EstadoCuenta()->nro;
                $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEstCuenta($this->md_estadocuenta->max_EstadoCuenta()->nro);
                $data['MesesPeriodo'] = $meses_transcurridos + 1;
                $data['MesesRetraso'] = $val_ciclo;
                $data['SubTotPeriodo'] = $Mensual;
                $data['multa_par'] = bcdiv($multa_parcial, 1, 2);
                $data['interes_par'] = bcdiv($interes, 1, 2);
                $data['desde'] = $fch_desde;
                $data['hasta'] = $fch_hasta;
            }

            $detalle_input = array(); //ARREGLO PARA ALMACENAR LOS DATOS DEL DETALLE DEL ESTADO DE CUENTA

            if (isset($_POST['agregar'])) {

                $data['nroEmision'] = $this->md_estadocuenta->max_EstadoCuenta()->nro;

                //VARIABLES PARA ASIGNAR PERIODO
                $ene = "";
                $feb = "";
                $mar = "";
                $abr = "";
                $may = "";
                $jun = "";
                $jul = "";
                $ago = "";
                $sep = "";
                $oct = "";
                $nov = "";
                $dic = "";

                //VALIDACION PARA ESTABLECER PERIODO
                if ($this->input->POST('ene') != null) {
                    $ene = 'ENE-';
                }
                if ($this->input->POST('feb') != null) {
                    $feb = 'FEB-';
                }
                if ($this->input->POST('mar') != null) {
                    $mar = 'MAR-';
                }
                if ($this->input->POST('abr') != null) {
                    $abr = 'ABR-';
                }
                if ($this->input->POST('may') != null) {
                    $may = 'MAY-';
                }
                if ($this->input->POST('jun') != null) {
                    $jun = 'JUN-';
                }
                if ($this->input->POST('jul') != null) {
                    $jul = 'JUL-';
                }
                if ($this->input->POST('ago') != null) {
                    $ago = 'AGO-';
                }
                if ($this->input->POST('sep') != null) {
                    $sep = 'SEP-';
                }
                if ($this->input->POST('oct') != null) {
                    $oct = 'OCT-';
                }
                if ($this->input->POST('nov') != null) {
                    $nov = 'NOV-';
                }
                if ($this->input->POST('dic') != null) {
                    $dic = 'DIC';
                }

                //VARIABLE PARA REGISTRAR PERIODO
                $rango = $ene . $feb . $mar . $abr . $may . $jun . $jul . $ago . $sep . $oct . $nov . $dic;

                //DATOS DETALLE ESTADO DE CUENTA
                $detalle_input['idestadocuenta'] = $this->input->POST('numEstCuenta');
                $detalle_input['anio'] = $this->input->POST('anio');
                $detalle_input['cnt_meses'] = $this->input->POST('meses');
                $detalle_input['periodo'] = $rango;
                $detalle_input['alumbrado_ec'] = $this->input->POST('alum');
                $detalle_input['aseo_ec'] = $this->input->POST('aseo');
                $detalle_input['pavimento_ec'] = $this->input->POST('pav');
                $detalle_input['mensualidad_ec'] = $this->input->POST('tot');
                $detalle_input['cobro_periodo'] = $this->input->POST('subtotal');
                $detalle_input['multa_parcial'] = $this->input->POST('multa_parcial');
                $detalle_input['interes_parcial'] = $this->input->POST('interes_parcial');

                $chk_Detalle = $this->md_estadocuenta->add_DetalleEstadoCuenta($detalle_input);
                if ($chk_Detalle < 1) {
                    echo "<script type='text/javascript'>alert('Error al registrar el cobro');</script>";
                }
                $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEstCuenta($this->md_estadocuenta->max_EstadoCuenta()->nro);
            }

            if (isset($_POST['eliminar'])) {
                $id_EstCuenta = $this->input->POST('numEstCuenta');
                $anio_del = $this->input->POST('anio');
                $periodo = $this->input->POST('eliminar');

                if ($this->md_estadocuenta->del_DetalleEstCuenta($id_EstCuenta, $anio_del, $periodo) != null) {
                    $data['nroEmision'] = $this->md_estadocuenta->max_EstadoCuenta()->nro;
                    $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEstCuenta($this->md_estadocuenta->max_EstadoCuenta()->nro);
                }
            }

            $pie_input = array(); //ARREGLO PARA ASIGNAR LOS VALORES A INSERTAR EN LA TABLA estadocuenta_pie

            if (isset($_POST['cobro_total'])) {
                //VARIABLES PARA EL CALCULO
                $id_ECuenta = $this->input->POST('numEstCuenta');
                $observaciones = $this->input->POST('observacion');
                $por_fiesta = $this->md_parametros->porcentaje_fiesta()->fiesta;
                $suma_cobros = $this->md_estadocuenta->sum_cobros($id_ECuenta)->cobro;
                $suma_meses = $this->md_estadocuenta->sum_meses($id_ECuenta)->cantidad;
                $suma_mora = $this->md_estadocuenta->sum_mora($id_ECuenta)->mora;
                $suma_interes = $this->md_estadocuenta->sum_interes($id_ECuenta)->interes;

                //VALIDACION DE COBRO DE MORA SEGUN LA LEY
                if ($suma_mora <= 2.86) {
                    $suma_mora = 2.86;
                }

                //OPERACIONES PARA EL CALCULO DE COBROS
                $calc_fiesta = $suma_cobros * $por_fiesta;
                $total_pago = $suma_cobros + $calc_fiesta + $suma_mora + $suma_interes;

                //ASIGNANDO LOS VALORES QUE SE INSERTARAN EN LA TABLA estadocuenta_pie
                $pie_input['idestadocuenta'] = $id_ECuenta;
                $pie_input['meses_retraso'] = $suma_meses;
                $pie_input['total_calculo'] = $suma_cobros;
                $pie_input['fiesta_ec'] = bcdiv($calc_fiesta, 1, 2);
                $pie_input['multa_ec'] = $suma_mora;
                $pie_input['interes_ec'] = $suma_interes;
                $pie_input['total_pago'] = bcdiv($total_pago, 1, 2);
                $pie_input['observaciones'] = $observaciones;

                $verif_registro = $this->db->query("SELECT * FROM pie_tasas WHERE idestadocuenta = $id_ECuenta")->num_rows();

                if ($verif_registro == 0) {
                    $chk_Pie = $this->md_estadocuenta->add_PieEstadoCuenta($pie_input);
                    if ($chk_Pie == 0) {
                        echo "<script type='text/javascript'>alert('NO SE PUDO REGISTRAR EL PIE DEL ESTADO DE CUENTA');</script>";
                    }
                } else {
                    $chk_upd = $this->md_estadocuenta->upd_PieEstadoCuenta($id_ECuenta, $pie_input);
                    if ($chk_upd == 0) {
                        echo "<script type='text/javascript'>alert('NO SE PUDO ACTUALIZAR EL PIE DEL ESTADO DE CUENTA');</script>";
                    }
                }

                //ASIGNACION DE VALORES PARA MOSTRAR EN FRONT-END
                $data['suma_meses'] = $suma_meses;
                $data['suma_cobros'] =  $suma_cobros;
                $data['suma_mora'] =  $suma_mora;
                $data['suma_interes'] = $suma_interes;
                $data['fiesta'] = bcdiv($calc_fiesta, 1, 2);
                $data['total'] = bcdiv($total_pago, 1, 2);
                $data['observaciones'] = $observaciones;
                $data['nroEmision'] = $this->md_estadocuenta->max_EstadoCuenta()->nro;
                $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEstCuenta($this->md_estadocuenta->max_EstadoCuenta()->nro);
            }

            $this->load->view('cuentasc/est_cuenta/tasas', $data);
        } else {
            redirect("cnt_cuentasc/contribuyentes", "refresh");
        }
    }

    //--------------------------------------------PDF ESTADO DE CUENTA POR TASAS--------------------------------------------//
    public function tasas_pdf($idCuenta = null)
    {
        if ($idCuenta !== null) {

            $data['Encabezado'] = $this->md_estadocuenta->get_Encabezado($idCuenta);
            $data['Detalle'] = $this->md_estadocuenta->get_Detalle($idCuenta);
            $data['pie'] = $this->md_estadocuenta->get_Pie($idCuenta);

            $this->load->view('cuentasc/est_cuenta/reportes/ec_tasas', $data);
        }
    }

    //--------------------------------------------EstCuenta CONTRIBUCION ESPECIAL--------------------------------------------//
    public function contrib_especial($idcontri = null)
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }

        if ($idcontri != null) {
            $idcontri = $this->db->escape((int)$idcontri);

            //CARGAR DATOS DE LOS CONTRIBUYENTES A LA VISTA
            $data['contri'] = $this->md_contribuyente->get_Contri($idcontri);
            $data['get_anio'] = $this->md_contribuyente->get_anio($idcontri);
            $data['nro_cuenta'] = $this->md_estadocuenta->max_especial();
            $data['detalle_cuenta'] = null;

            //VARIABLES PARA OBTENER TASAS DE COBRO Y PAGOS REGISTRADOS
            $data['get_tcobros'] = null;
            $data['get_rpagos'] = null;

            if (isset($_POST['obtener'])) {
                $anio = $this->input->POST('anio');
                $anioTC = 0;

                //obtener la tasa de cobros de 2010 a 2012 que se mantiene igual para todos los contribuyentes
                if ($anio >= 2010 && $anio <= 2012) {
                    $anioTC = 2012;
                } else {
                    $anioTC = $anio;
                }

                $data['get_tcobros'] = $this->md_contribuyente->get_tcobros($idcontri, $anioTC);
                $data['get_rpagos'] = $this->md_contribuyente->get_rpagos($idcontri, $anio);
                $data['nroEmision'] = null;

                //ARREGLO PARA ALMACENAR LOS DATOS DEL ENCABEZADO
                $encabezado_input = array();
                $validar = $this->db->query("SELECT * FROM enc_especial WHERE idestadocuenta = ?", $_POST['numEstCuenta'])->result_array();

                if (empty($validar)) {
                    //VARIABLES PARA GENERAR LA DIRECCION
                    $a = "";
                    if ($this->input->POST('ubi') != "No se ha establecido ubicacion") {
                        $a = $this->input->POST('ubi');
                    }
                    $b = $this->input->POST('col');
                    $c = $this->input->POST('calle_pje');
                    $direc = $a . ' ' . $b . ' ' . $c;
                    $emitido = date('d-m-Y');

                    //DATOS DEL ENCABEZADO
                    $encabezado_input['nc'] = $this->input->POST('nis');
                    $encabezado_input['contribuyente'] = $this->input->POST('contri');
                    $encabezado_input['propietario'] = $this->input->POST('prop');
                    $encabezado_input['direccion'] = $direc;
                    $encabezado_input['emitido'] = $emitido;

                    $chk_Encabezado = $this->md_estadocuenta->add_EncEspecial($encabezado_input);
                    if ($chk_Encabezado > 0) {
                        $data['nroEmision'] = $this->md_estadocuenta->max_especial()->nro;
                        $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEspecial($this->md_estadocuenta->max_especial()->nro);
                    }
                } else {
                    $data['nroEmision'] = $this->md_estadocuenta->max_especial()->nro;
                    $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEspecial($this->md_estadocuenta->max_especial()->nro);
                }
            }

            //VARIABLES PARA GUARDAR LA CANTIDAD DE MESES TRANSCURRIDOS POR PERIODO Y EL SUBTOTAL GENERADO
            $data['MesesPeriodo'] = null;
            $data['SubTotPeriodo'] = null;

            if (isset($_POST['calcular'])) {
                //VARIABLES PARA NO PERDER LOS DATOS DE LAS TASAS COBRADAS
                $anio = $this->input->POST('anio');
                $anioTC = 0;

                //comparador para obtener la tasa de cobros de 2010 a 2012 que se mantiene igual para todos los contribuyentes
                if ($anio >= 2010 && $anio <= 2012) {
                    $anioTC = 2012;
                } else {
                    $anioTC = $anio;
                }

                $fch_desde = $this->input->post('periodo_desde');
                $fch_hasta = $this->input->post('periodo_hasta');
                $mes = $this->input->post('mensual');
                $aseo = $this->input->post('aseo');

                //VARIABLES PARA CALCULO DE MESES TRANSCURRIDOS
                $meses_transcurridos = $this->md_estadocuenta->get_MesesTranscurridos($fch_desde, $fch_hasta)->meses;
                $diferencia_meses = $this->md_estadocuenta->Diferencia_fechas($fch_desde)->meses;
                $meses_ciclo = $this->md_estadocuenta->Diferencia_fechas($fch_hasta)->meses;

                //VARIABLES PARA OBTENER LOS PORCENTAJES DE COBRO
                $tresM = $this->md_parametros->porcentaje_tresM()->tres_meses;
                $masTres = $this->md_parametros->porcentaje_MastresM()->mas_tres_meses;
                $por_interes = $this->md_parametros->porcentaje_interes()->interes;

                //CALCULO PARCIAL DE COBRO POR PERIODO
                if ($aseo == null || $aseo == 0.00) {
                    $aseo = 0;
                }
                $Mensualidad = $aseo + $mes;
                $Mensual = $Mensualidad * ($meses_transcurridos + 1);

                $interes = null;
                $multa_parcial = null;
                $val_ciclo = null;
                $retraso_for = $diferencia_meses - 2;

                //VERIFICACION SI SON MAS DE # MESES DE RETRASO PARA HACER EL COBRO RESPECTIVO
                if ($diferencia_meses >= 3) {

                    //CONDICIONAL PARA ASIGNAR LAS VECES QUE SE REPETIRA EL CICLO FOR PARA LA SUMA DE INTERESES
                    if ($meses_ciclo == 0) {
                        $val_ciclo = $meses_transcurridos - 2;
                    } elseif ($meses_ciclo == 1) {
                        $val_ciclo = $meses_transcurridos - 1;
                    } elseif ($meses_ciclo >= 2) {
                        $val_ciclo = $meses_transcurridos + 1;
                    }

                    //VALIDACION PARA EL CALCULO DE MORA SEGUN LA CANTIDAD DE MESES DE RETRASO
                    if ($diferencia_meses >= 3 and $diferencia_meses <= 5) {
                        $multa_parcial = ($Mensualidad * $tresM) * $val_ciclo;
                    } elseif ($diferencia_meses >= 6) {
                        $multa_parcial = ($Mensualidad * $masTres) * $val_ciclo;
                    }

                    // //CALCULO SEGUN LEY GENERAL TRIBUTARIA MUNICIPAL
                    // if ($diferencia_meses >= 3 and $diferencia_meses <= 5) {
                    //     $multa = ($Mensualidad * $tresM) * $val_ciclo;
                    //     if ($multa <= 2.86) {
                    //         $multa_parcial = 2.86;
                    //     }
                    // } elseif ($diferencia_meses >= 6) {
                    //     $multa = ($Mensualidad * $masTres) * $val_ciclo;
                    //     if ($multa <= 2.86) {
                    //         $multa_parcial = 2.86;
                    //     }
                    // }

                    //LOOP PARA CALCULAR EL TOTAL DEL INTERES PARCIAL
                    for ($i = 1; $i <= $val_ciclo; $i++) {
                        $calculo = $Mensualidad * $retraso_for * $por_interes;
                        $interes = $interes + $calculo;
                        $retraso_for--;
                    }
                }

                //VARIABLES PARA CARGAR DATOS A LA VISTA detalle_cta
                $data['get_tcobros'] = $this->md_contribuyente->get_tcobros($idcontri, $anioTC);
                $data['get_rpagos'] = $this->md_contribuyente->get_rpagos($idcontri, $anio);
                $data['nroEmision'] = $this->md_estadocuenta->max_especial()->nro;
                $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEspecial($this->md_estadocuenta->max_especial()->nro);
                $data['MesesPeriodo'] = $meses_transcurridos + 1;
                $data['MesesRetraso'] = $val_ciclo;
                $data['SubTotPeriodo'] = $Mensual;
                $data['multa_par'] = bcdiv($multa_parcial, 1, 2);
                $data['interes_par'] = bcdiv($interes, 1, 2);
                $data['desde'] = $fch_desde;
                $data['hasta'] = $fch_hasta;
            }

            $detalle_input = array(); //ARREGLO PARA ALMACENAR LOS DATOS DEL DETALLE DEL ESTADO DE CUENTA

            if (isset($_POST['agregar'])) {

                $data['nroEmision'] = $this->md_estadocuenta->max_especial()->nro;

                //VARIABLES PARA ASIGNAR PERIODO
                $ene = "";
                $feb = "";
                $mar = "";
                $abr = "";
                $may = "";
                $jun = "";
                $jul = "";
                $ago = "";
                $sep = "";
                $oct = "";
                $nov = "";
                $dic = "";

                //VALIDACION PARA ESTABLECER PERIODO
                if ($this->input->POST('ene') != null) {
                    $ene = 'ENE-';
                }
                if ($this->input->POST('feb') != null) {
                    $feb = 'FEB-';
                }
                if ($this->input->POST('mar') != null) {
                    $mar = 'MAR-';
                }
                if ($this->input->POST('abr') != null) {
                    $abr = 'ABR-';
                }
                if ($this->input->POST('may') != null) {
                    $may = 'MAY-';
                }
                if ($this->input->POST('jun') != null) {
                    $jun = 'JUN-';
                }
                if ($this->input->POST('jul') != null) {
                    $jul = 'JUL-';
                }
                if ($this->input->POST('ago') != null) {
                    $ago = 'AGO-';
                }
                if ($this->input->POST('sep') != null) {
                    $sep = 'SEP-';
                }
                if ($this->input->POST('oct') != null) {
                    $oct = 'OCT-';
                }
                if ($this->input->POST('nov') != null) {
                    $nov = 'NOV-';
                }
                if ($this->input->POST('dic') != null) {
                    $dic = 'DIC';
                }

                //VARIABLE PARA REGISTRAR PERIODO
                $rango = $ene . $feb . $mar . $abr . $may . $jun . $jul . $ago . $sep . $oct . $nov . $dic;

                //DATOS DETALLE ESTADO DE CUENTA
                $detalle_input['idestadocuenta'] = $this->input->POST('numEstCuenta');
                $detalle_input['anio'] = $this->input->POST('anio');
                $detalle_input['cnt_meses'] = $this->input->POST('meses');
                $detalle_input['periodo'] = $rango;
                $detalle_input['aseo_ec'] = $this->input->POST('aseo');
                $detalle_input['mensualidad_ec'] = $this->input->POST('mensual');
                $detalle_input['cobro_periodo'] = $this->input->POST('subtotal');
                $detalle_input['multa_parcial'] = $this->input->POST('multa_parcial');
                $detalle_input['interes_parcial'] = $this->input->POST('interes_parcial');

                $chk_Detalle = $this->md_estadocuenta->add_DetalleEspecial($detalle_input);
                if ($chk_Detalle < 1) {
                    echo "<script type='text/javascript'>alert('Error al registrar el cobro');</script>";
                }
                $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEspecial($this->md_estadocuenta->max_especial()->nro);
            }

            if (isset($_POST['eliminar'])) {

                $id_EstCuenta = $this->input->POST('numEstCuenta');
                $anio_del = $this->input->POST('anio');
                $periodo = $this->input->POST('eliminar');

                if ($this->md_estadocuenta->del_DetalleEspecial($id_EstCuenta, $anio_del, $periodo) != null) {
                    $data['nroEmision'] = $this->md_estadocuenta->max_especial()->nro;
                    $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEspecial($this->md_estadocuenta->max_especial()->nro);
                }
            }

            $pie_input = array(); //ARREGLO PARA ASIGNAR LOS VALORES A INSERTAR EN LA TABLA estadocuenta_pie

            if (isset($_POST['cobro_total'])) {
                //VARIABLES PARA EL CALCULO
                $id_ECuenta = $this->input->POST('numEstCuenta');
                $observaciones = $this->input->POST('observacion');
                $por_fiesta = $this->md_parametros->porcentaje_fiesta()->fiesta;
                $suma_cobros = $this->md_estadocuenta->cobros_esp($id_ECuenta)->cobro;
                $suma_meses = $this->md_estadocuenta->meses_esp($id_ECuenta)->cantidad;
                $suma_mora = $this->md_estadocuenta->mora_esp($id_ECuenta)->mora;
                $suma_interes = $this->md_estadocuenta->interes_esp($id_ECuenta)->interes;

                //VALIDACION DE COBRO DE MORA SEGUN LA LEY
                if ($suma_mora <= 2.86) {
                    $suma_mora = 2.86;
                }

                //OPERACIONES PARA EL CALCULO DE COBROS
                $calc_fiesta = $suma_cobros * $por_fiesta;
                $total_pago = $suma_cobros + $calc_fiesta + $suma_mora + $suma_interes;

                //ASIGNANDO LOS VALORES QUE SE INSERTARAN EN LA TABLA estadocuenta_pie
                $pie_input['idestadocuenta'] = $id_ECuenta;
                $pie_input['meses_retraso'] = $suma_meses;
                $pie_input['total_calculo'] = $suma_cobros;
                $pie_input['fiesta_ec'] = bcdiv($calc_fiesta, 1, 2);
                $pie_input['multa_ec'] = $suma_mora;
                $pie_input['interes_ec'] = $suma_interes;
                $pie_input['total_pago'] = bcdiv($total_pago, 1, 2);
                $pie_input['observaciones'] = $observaciones;

                $verif_registro = $this->db->query("SELECT * FROM pie_especial WHERE idestadocuenta = $id_ECuenta")->num_rows();

                if ($verif_registro == 0) {
                    $chk_Pie = $this->md_estadocuenta->add_PieEspecial($pie_input);
                    if ($chk_Pie == 0) {
                        echo "<script type='text/javascript'>alert('NO SE PUDO REGISTRAR EL PIE DEL ESTADO DE CUENTA');</script>";
                    }
                } else {
                    $chk_upd = $this->md_estadocuenta->upd_PieEspecial($id_ECuenta, $pie_input);
                    if ($chk_upd == 0) {
                        echo "<script type='text/javascript'>alert('NO SE PUDO ACTUALIZAR EL PIE DEL ESTADO DE CUENTA');</script>";
                    }
                }

                //ASIGNACION DE VALORES PARA MOSTRAR EN FRONT-END
                $data['suma_meses'] = $suma_meses;
                $data['suma_cobros'] =  $suma_cobros;
                $data['suma_mora'] =  $suma_mora;
                $data['suma_interes'] = $suma_interes;
                $data['fiesta'] = bcdiv($calc_fiesta, 1, 2);
                $data['total'] = bcdiv($total_pago, 1, 2);
                $data['observaciones'] = $observaciones;
                $data['nroEmision'] = $this->md_estadocuenta->max_especial()->nro;
                $data['detalle_cuenta'] = $this->md_estadocuenta->get_DetalleEspecial($this->md_estadocuenta->max_especial()->nro);
            }

            $this->load->view("cuentasc/est_cuenta/contri_especial", $data);
        } else {
            redirect("cnt_cuentasc/contribuyentes", "refresh");
        }
    }

    //--------------------------------------------PDF ESTADO DE CUENTA POR CONTRIBUCION ESPECIAL--------------------------------------------//
    public function especial_pdf($idCuenta = null)
    {
        if ($idCuenta !== null) {

            $data['Encabezado'] = $this->md_estadocuenta->enc_especial($idCuenta);
            $data['Detalle'] = $this->md_estadocuenta->detalle_especial($idCuenta);
            $data['pie'] = $this->md_estadocuenta->pie_especial($idCuenta);

            $this->load->view('cuentasc/est_cuenta/reportes/ec_especial', $data);
        }
    }

    //--------------------------------------------ASIGNAR ACCESO A LA VISTA SEGUN TIPO DE TRIBUTACION--------------------------------------------//
    public function tipo_estado_cuenta($id = null, $tributacion = null)
    {
        if ($id !== null) {
            if ($tributacion !== null) {
                switch ($tributacion) {
                    case 1:
                        redirect("cnt_cuentasc/tasas/$id", "refresh");
                        break;
                    case 2:
                        redirect("cnt_cuentasc/contrib_especial/$id", "refresh");
                        break;
                    case 3:
                        echo "<script type='text/javascript'>alert('Actividad económica');</script>";
                        break;
                }
            } else {
                echo "<script type='text/javascript'>alert('DEBE ASIGNAR EL TIPO DE TRIBUTACION DEL CONTRIBUYENTE');</script>";
                redirect("cont_cuentasc/est_cuenta", "refresh");
            }
        }
    }

    //--------------------------------------------CONTRIBUYENTES PARA REGISRTRO DE PAGO--------------------------------------------//
    public function contri_pagos($pag = 1)
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }

        //variables de configuracion para la paginacion
        $pag--;

        if ($pag < 0) {
            $pag = 0;
        }

        $page_size = 100;
        $offset = $pag * $page_size;

        $buscar = $this->input->get('busqueda');

        $data['contrib'] = $this->md_contribuyente->countContri($buscar);
        $data['est_cuenta'] = $this->md_contribuyente->pagContri($page_size, $offset, $buscar);
        $data['current_pag'] = $pag++;
        $data['busqueda'] = $buscar;
        $data['last_page'] = ceil($this->md_contribuyente->countContri($buscar) / $page_size);
        $this->load->view('cuentasc/contri_pagos', $data);
    }

    //--------------------------------------------CONTRIBUYENTES PARA REGISRTRO DE PAGO--------------------------------------------//
    public function buscar()
    {
        redirect("cnt_cuentasc/contri_pagos/1/?busqueda=" . $this->input->get('busqueda'));
    }

    //--------------------------------------------REGISRTRO DE PAGO PARCIAL TASAS--------------------------------------------//
    public function parcial_tasas($nc = null)
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }

        if ($nc != null) {
            $nc = $this->db->escape((int)$nc);
            $validar = $this->md_regpago->EncTasas_rpago($nc);

            //validacion de acceso al registro de pagos
            if ($validar != null) {
                //cargar datos que se muestan en la vista
                $data['contri'] = $validar;
                $data['emision'] = $this->md_regpago->num_emision($nc);
                $this->load->view('cuentasc/reg_pago/parcial_tasas', $data);
            } else {
                echo "<script type='text/javascript'>alert('El NC [$nc] aun no posee estados de cuenta registrados');</script>";
                redirect("cnt_cuentasc/contri_pagos", "refresh");
            }
        } else {
            redirect("cnt_cuentasc/contri_pagos", "refresh");
        }
    }

    //--------------------------------------------REGISRTRO DE PAGO TOTAL TASAS--------------------------------------------//
    public function total_tasas($nc = null)
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }

        if ($nc != null) {
            $nc = $this->db->escape((int)$nc);
            $validar = $this->md_regpago->EncTasas_rpago($nc);

            //validacion de acceso al registro de pagos
            if ($validar != null) {
                //cargar datos que se muestan en la vista
                $data['contri'] = $validar;
                $data['emision'] = $this->md_regpago->num_emision($nc);
                $data['tributo'] = $this->md_regpago->tributo($nc);
                $this->load->view('cuentasc/reg_pago/total_tasas', $data);
            } else {
                echo "<script type='text/javascript'>alert('El NC [$nc] aun no posee estados de cuenta registrados');</script>";
                redirect("cnt_cuentasc/contri_pagos", "refresh");
            }
        } else {
            redirect("cnt_cuentasc/contri_pagos", "refresh");
        }
    }

    //--------------------------------------------OBTENER EL DETALLE SEGUN EL ESTADO DE CUENTA SELECCIONADO--------------------------------------------//
    public function detalle_tasas()
    {
        if ($this->input->post('idcuenta')) {
            echo $this->md_regpago->dtt_tasas($this->input->post('idcuenta'));
        }
    }

    //--------------------------------------------OBTENER AÑOS SEGUN NUMERO DE ESTADO DE CUENTA--------------------------------------------//
    public function tasas_anio()
    {
        if ($this->input->post('idcuenta')) {
            echo $this->md_regpago->t_anio($this->input->post('idcuenta'));
        }
    }

    //--------------------------------------------OBTENER DETALLE SEGÚN EL AÑO SELECCIONADO--------------------------------------------//
    public function detalleT_anio()
    {
        if ($this->input->post('anio')) {
            $id = $this->input->post('idcuenta');
            $anio = $this->input->post('anio');
            echo $this->md_regpago->dtt_anio($id, $anio);
        }
    }

    //--------------------------------------------OBTENER EL REGISTRO DE PAGOS SEGUN EL AÑO SELECCIONADO--------------------------------------------//
    public function rp_anio()
    {
        if ($this->input->post('anio')) {
            $nc = $this->input->post('nis');
            $id = $this->md_contribuyente->get_idcontri($nc)->idcontribuyente;
            $anio = $this->input->post('anio');
            //echo "<script type='text/javascript'>alert('NC[$nc],ID[$id],AÑO[$anio]');</script>";
            echo $this->md_regpago->dtrp_anio($id,$anio);
        }
    }

    //--------------------------------------------OBTENER SUMA DE MESES SEGUN EL AÑO SELECCIONADO--------------------------------------------//
    public function dtts_meses()
    {
        if ($this->input->post('anio')) {
            $id = $this->input->post('idcuenta');
            $anio = $this->input->post('anio');
            $r = $this->md_regpago->dtt_smeses($id, $anio)->meses;
            echo $r;
        }
    }

    //--------------------------------------------OBTENER SUMA DEL SUBTOTAL SEGUN EL AÑO SELECCIONADO--------------------------------------------//
    public function dtts_sub()
    {
        if ($this->input->post('anio')) {
            $id = $this->input->post('idcuenta');
            $anio = $this->input->post('anio');
            $r = $this->md_regpago->dtt_subtot($id, $anio)->sub;
            echo $r;
        }
    }

    //--------------------------------------------OBTENER SUMA DEL SUBTOTAL SEGUN EL AÑO SELECCIONADO--------------------------------------------//
    public function dtts_interes()
    {
        if ($this->input->post('anio')) {
            $id = $this->input->post('idcuenta');
            $anio = $this->input->post('anio');
            $r = $this->md_regpago->dtt_interes($id, $anio)->interes;
            echo $r;
        }
    }

    //--------------------------------------------OBTENER 5% FIESTA SEGUN EL AÑO SELECCIONADO--------------------------------------------//
    public function dtts_fiesta()
    {
        if ($this->input->post('anio')) {
            $id = $this->input->post('idcuenta');
            $anio = $this->input->post('anio');
            $subt = $this->md_regpago->dtt_subtot($id, $anio)->sub;
            $por_fiesta = $this->md_parametros->porcentaje_fiesta()->fiesta;
            $r = $subt * $por_fiesta;
            echo bcdiv($r, 1, 2);
        }
    }

    //--------------------------------------------OBTENER EL CALCULO DE MORA SEGUN EL AÑO SELECCIONADO--------------------------------------------//
    public function dtts_mora()
    {
        if ($this->input->post('anio')) {
            $id = $this->input->post('idcuenta');
            $anio = $this->input->post('anio');
            $mora = $this->md_regpago->dtt_mora($id, $anio)->mora;
            $r = 0.00;

            if ($mora <= 2.86) {
                $r = 2.86;
            } else {
                $r = $mora;
            }

            echo bcdiv($r, 1, 2);
        }
    }

    //--------------------------------------------OBTENER EL COBRO TOTAL SEGUN EL AÑO SELECCIONADO--------------------------------------------//
    public function dtts_total()
    {
        if ($this->input->post('anio')) {
            $id = $this->input->post('idcuenta');
            $anio = $this->input->post('anio');

            $subt = $this->md_regpago->dtt_subtot($id, $anio)->sub;
            $por_fiesta = $this->md_parametros->porcentaje_fiesta()->fiesta;
            $fiesta = $subt * $por_fiesta;
            $mora_p = $this->md_regpago->dtt_mora($id, $anio)->mora;
            $interes = $this->md_regpago->dtt_interes($id, $anio)->interes;

            if ($mora_p <= 2.86) {
                $mora = 2.86;
            } else {
                $mora = $mora_p;
            }

            $total = $subt + $fiesta + $mora + $interes;
            echo bcdiv($total, 1, 2);
        }
    }
}
