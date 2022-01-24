<?php
class md_regpago extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*******************************************/
    /********REGISTRO DE PAGOS EC_TASAS ********/
    /*******************************************/

    //metodo para obtener encabezao de estado de cuenta segun nc
    function EncTasas_rpago(int $nc)
    {
        return $this->db->query("SELECT *
                                    FROM enc_tasas
                                    WHERE nc = '$nc'
                                    LIMIT 1")->row();
    }

    //metodo para obtener los numeros de emision de los estados de cuenta de un conttibuyente
    function num_emision(int $nc)
    {
        return $this->db->query("SELECT idestadocuenta
                                    FROM enc_tasas
                                    WHERE nc = '$nc'")->result();
    }

    //metodo para obtener el tipo de tributacion
    function tributo(int $nc)
    {
        $query = $this->db->query("SELECT c.idtributo, t.nombre
                                    FROM contribuyente as c
                                    LEFT JOIN tributacion as t ON c.idtributo = t.idtributo
                                    WHERE nc = '$nc'")->row();
        return $query;
    }

    //metodo para obtener los años registrados en el estado de cuenta especifico
    function t_anio(int $idcuenta)
    {
        $query = $this->db->query("SELECT DISTINCT anio
                                    FROM detalle_tasas
                                    WHERE idestadocuenta = '$idcuenta'")->result();
        $out = '<option value="">Seleccione uno</option>';
        foreach ($query as $rw) {
            $out .= '<option value="' . $rw->anio . '">' . $rw->anio . '</option>';
        }
        return $out;
    }

    //metodo para obtener el detalle del estado de cuenta [PAGO TOTAL TASAS]
    function dtt_tasas(int $id)
    {
        $query = $this->db->query("SELECT *
                                    FROM detalle_tasas
                                    WHERE idestadocuenta = '$id'")->result();
        $out = '<thead class="thead-primary">
                    <tr>
                        <th>Año</th>
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
                <tbody>';

        foreach ($query as $rw) {
            $out .= '<tr>
                        <td>' . $rw->anio . '</td>
                        <td>' . $rw->cnt_meses . '</td>
                        <td>' . $rw->periodo . '</td>
                        <td>' . $rw->alumbrado_ec . '</td>
                        <td>' . $rw->aseo_ec . '</td>
                        <td>' . $rw->pavimento_ec . '</td>
                        <td>' . $rw->mensualidad_ec . '</td>
                        <td>' . $rw->cobro_periodo . '</td>
                        <td>' . $rw->multa_parcial . '</td>
                        <td>' . $rw->interes_parcial . '</td>
                    </tr>';
        }

        $out .= '</tbody>';
        return $out;
    }

    //metodo para obtener el detalle del estado de cuenta segun año
    function dtt_anio(int $id, int $anio)
    {
        $query = $this->db->query("SELECT * 
                                    FROM detalle_tasas
                                    WHERE idestadocuenta = $id AND anio = $anio")->result();

        $out = '<thead class="thead-primary">
                    <tr>
                        <th>Año</th>
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
                <tbody>';

        foreach ($query as $rw) {
            $out .= '<tr>
                        <td>' . $rw->anio . '</td>
                        <td>' . $rw->cnt_meses . '</td>
                        <td>' . $rw->periodo . '</td>
                        <td>' . $rw->alumbrado_ec . '</td>
                        <td>' . $rw->aseo_ec . '</td>
                        <td>' . $rw->pavimento_ec . '</td>
                        <td>' . $rw->mensualidad_ec . '</td>
                        <td>' . $rw->cobro_periodo . '</td>
                        <td>' . $rw->multa_parcial . '</td>
                        <td>' . $rw->interes_parcial . '</td>
                    </tr>';
        }
        $out .= '</tbody>';
        return $out;
    }

    //metodo para obtener la suma de meses segun el año seleccionado del estado de cuentas
    function dtt_smeses(int $id, int $anio)
    {
        $query = $this->db->query("SELECT sum(cnt_meses) as meses
                                    FROM detalle_tasas
                                    WHERE idestadocuenta = $id AND anio = $anio")->row();
        return $query;
    }

    //metodo para obtener la suma del subtotal del estado de cuenta segun el año que se regristara
    function dtt_subtot(int $id, int $anio)
    {
        $query = $this->db->query("SELECT sum(cobro_periodo) as sub
                                    FROM detalle_tasas
                                    WHERE idestadocuenta = $id AND anio = $anio")->row();
        return $query;
    }

    //metodo para obtener la suma de los intereses segun el año seleccionado del estado de cuenta
    function dtt_interes(int $id, int $anio)
    {
        $query = $this->db->query("SELECT sum(interes_parcial) as interes
                                    FROM detalle_tasas
                                    WHERE idestadocuenta = $id AND anio = $anio")->row();
        return $query;
    }

    //metodo para obtener la sumatoria del calculo de mora segun el año seleccionado del estado de cuenta
    function dtt_mora(int $id, int $anio)
    {
        $query = $this->db->query("SELECT sum(multa_parcial) as mora
                                    FROM detalle_tasas
                                    WHERE idestadocuenta = $id AND anio = $anio")->row();
        return $query;
    }

    //metodo paora obtener el registro de pagos por año
    function dtrp_anio(int $id, int $anio)
    {
        $query = $this->db->query("SELECT *
                                    FROM registro_pagos
                                    WHERE idcontribuyente = '$id' and anio = '$anio'")->result();
        $ene = '';
        $feb = '';
        $mar = '';
        $abr = '';
        $may = '';
        $jun = '';
        $jul = '';
        $ago = '';
        $sep = '';
        $oct = '';
        $nov = '';
        $dic = '';

        $out = '<thead class="thead-primary">
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
                <tbody>';
        
        foreach ($query as $rw) {
            
            if ($rw->ene > 0) {
                $ene = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->ene == null)
            {
                $ene = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $ene = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->feb > 0) {
                $feb = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->feb == null)
            {
                $feb = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $feb = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->mar > 0) {
                $mar = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->mar == null)
            {
                $mar = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $mar = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->abr > 0) {
                $abr = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->abr == null)
            {
                $abr = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $abr = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->may > 0) {
                $may = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->may == null)
            {
                $may = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $may = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->jun > 0) {
                $jun = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->jun == null)
            {
                $jun = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $jun = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->jul > 0) {
                $jul = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->jul == null)
            {
                $jul = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $jul = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->ago > 0) {
                $ago = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->ago == null)
            {
                $ago = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $ago = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->sep > 0) {
                $sep = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->sep == null)
            {
                $sep = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $sep = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->oct > 0) {
                $oct = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->oct == null)
            {
                $oct = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $oct = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->nov > 0) {
                $nov = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->nov == null)
            {
                $nov = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $nov = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }

            if ($rw->dic > 0) {
                $dic = '<i style="color: green; font-size: 1.3em;" class="icofont-verification-check"></i>';
            } else if ($rw->dic == null)
            {
                $dic = '<i style="color: black; font-size: 1.3em;" class="icofont-minus"></i>';
            }else {
                $dic = '<i style="color: red; font-size: 1.3em;" class="icofont-error"></i>';
            }
            $out .= '<tr>
                        <td>' . $ene . '</td>
                        <td>' . $feb . '</td>
                        <td>' . $mar . '</td>
                        <td>' . $abr . '</td>
                        <td>' . $may . '</td>
                        <td>' . $jun . '</td>
                        <td>' . $jul . '</td>
                        <td>' . $ago . '</td>
                        <td>' . $sep . '</td>
                        <td>' . $oct . '</td>
                        <td>' . $nov . '</td>
                        <td>' . $dic . '</td>
                    </tr>';
        }
        $out .= '</tbody>';
        return $out;
    }
}
