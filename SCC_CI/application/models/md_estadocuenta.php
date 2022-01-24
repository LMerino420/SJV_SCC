<?php
class md_estadocuenta extends CI_Model
{
    //metodo constructor
    public function __construct()
    {
        parent::__construct();
    }

    //metodo para obtener los meses transcurridos entre dos fechas
    function get_MesesTranscurridos($Desde, $Hasta)
    {
        return $this->db->query("SELECT TIMESTAMPDIFF(MONTH, '{$Desde}', '{$Hasta}') AS meses")->row();
    }

    //metodo para obtener los meses transcurridos desde el ultimo pago hasta la actualidad
    function Diferencia_fechas($Desde)
    {
        return $this->db->query("SELECT TIMESTAMPDIFF(MONTH, '{$Desde}', now()) AS meses")->row();
    }

    /*******************************************/
    /********ESTADO DE CUENTAS POR TASAS********/
    /*******************************************/

    //metodo para obtener el ultimo estado de cuentas emitido
    function max_EstadoCuenta()
    {
        return $this->db->query("SELECT MAX(idestadocuenta) AS nro
                                FROM enc_tasas")->row();
    }

    //metodo para insertar el encabezado del estado de cuentas
    function add_EncEstadoCuentas($encabezado)
    {
        $this->db->insert('enc_tasas', $encabezado);
        $estCuenta_id = $this->db->insert_id();
        return $estCuenta_id;
    }

    //metodo para insertar el detalle del estado de cuenta
    function add_DetalleEstadoCuenta($detalle)
    {
        $estCuenta_id = 0;
        if ($this->db->insert('detalle_tasas', $detalle)) {
            $estCuenta_id = 1;
        }
        return $estCuenta_id;
    }

    //metodo para insertar el pie del estado de cuenta
    function add_PieEstadoCuenta($pie)
    {
        $estCuenta_id = 0;
        if ($this->db->insert('pie_tasas', $pie)) {
            $estCuenta_id = 1;
        }
        return $estCuenta_id;
    }

    //metodo para actualizar el pie del estado de cuenta
    function upd_PieEstadoCuenta($id, $datos)
    {
        $upd = 0;
        $this->db->where('idestadocuenta', $id);
        if ($this->db->update('pie_tasas', $datos)) {
            $upd = 1;
        }
        return $upd;
    }

    //metodo para obtener el detalle del estadon de cuenta
    function get_DetalleEstCuenta(int $nemision)
    {
        return $this->db->query("SELECT * FROM detalle_tasas WHERE idestadocuenta=$nemision")->result();
    }

    //metodo para eliminar el detalle del estado de cuenta
    function del_DetalleEstCuenta(int $id, int $anio, $periodo)
    {
        $eliminado = null;
        if ($this->db->query("DELETE FROM detalle_tasas WHERE idestadocuenta = $id AND anio = $anio AND periodo = '$periodo'")) {
            $eliminado = 1;
        }
        return $eliminado;
    }

    //metodo para obtener la suma de meses que se estan cobrando o calculando
    function sum_meses(int $id_Cuenta)
    {
        return $this->db->query("SELECT SUM(cnt_meses) AS cantidad FROM  detalle_tasas WHERE idestadocuenta = $id_Cuenta")->row();
    }

    //metodo para obtener la suma de los cobros por periodo calculado
    function sum_cobros(int $id_Cuenta)
    {
        return $this->db->query("SELECT SUM(cobro_periodo) AS cobro FROM  detalle_tasas WHERE idestadocuenta = $id_Cuenta")->row();
    }

    //metodo para obtener la suma de la multa o mora
    function sum_mora(int $id_Cuenta)
    {
        return $this->db->query("SELECT SUM(multa_parcial) AS mora FROM  detalle_tasas WHERE idestadocuenta = $id_Cuenta")->row();
    }

    //metodo para obtener la suma de los intereses calculados
    function sum_interes(int $id_Cuenta)
    {
        return $this->db->query("SELECT SUM(interes_parcial) AS interes FROM  detalle_tasas WHERE idestadocuenta = $id_Cuenta")->row();
    }

    //metodo para obtener el encabezado del estado de cuenta
    function get_Encabezado(int $idEstado)
    {
        return $this->db->query("SELECT *
                                    FROM enc_tasas
                                    WHERE idestadocuenta = $idEstado")->row();
    }

    //metodo para obtener el detalle del estado de cuenta
    function get_Detalle(int $idEstado)
    {
        return $this->db->query("SELECT *
                                    FROM detalle_tasas
                                    WHERE idestadocuenta = $idEstado")->result();
    }

    //metodo para obtener el pie del estado de cuenta
    function get_Pie(int $idEstado)
    {
        return $this->db->query("SELECT *
                                    FROM pie_tasas
                                    WHERE idestadocuenta = $idEstado")->row();
    }

    /*******************************************/
    /********ESTADO DE CUENTAS CNTRI_ESP********/
    /*******************************************/

    //metodo para obtener el ultimo registro de estado de cuenta de contribucion especial
    function max_especial()
    {
        return $this->db->query("SELECT MAX(idestadocuenta) AS nro
                                FROM enc_especial")->row();
    }

    //metodo para insertar el encabezado del estado de cuentas
    function add_EncEspecial($encabezado)
    {
        $this->db->insert('enc_especial', $encabezado);
        $estCuenta_id = $this->db->insert_id();
        return $estCuenta_id;
    }

    //metodo para obtener el detalle del estadon de cuenta
    function get_DetalleEspecial(int $nemision)
    {
        return $this->db->query("SELECT * FROM detalle_especial WHERE idestadocuenta=$nemision")->result();
    }

    //metodo para insertar el detalle del estado de cuenta
    function add_DetalleEspecial($detalle)
    {
        $estCuenta_id = 0;
        if ($this->db->insert('detalle_especial', $detalle)) {
            $estCuenta_id = 1;
        }
        return $estCuenta_id;
    }

    //metodo para eliminar el detalle del estado de cuenta
    function del_DetalleEspecial(int $id, int $anio, $periodo)
    {
        $eliminado = null;
        if ($this->db->query("DELETE FROM detalle_especial WHERE idestadocuenta = $id AND anio = $anio AND periodo = '$periodo'")) {
            $eliminado = 1;
        }
        return $eliminado;
    }

    //metodo para obtener la suma de los cobros por periodo calculado
    function cobros_esp(int $id_Cuenta)
    {
        return $this->db->query("SELECT SUM(cobro_periodo) AS cobro FROM  detalle_especial WHERE idestadocuenta = $id_Cuenta")->row();
    }

    //metodo para obtener la suma de meses que se estan cobrando o calculando
    function meses_esp(int $id_Cuenta)
    {
        return $this->db->query("SELECT SUM(cnt_meses) AS cantidad FROM  detalle_especial WHERE idestadocuenta = $id_Cuenta")->row();
    }

    //metodo para obtener la suma de la multa o mora
    function mora_esp(int $id_Cuenta)
    {
        return $this->db->query("SELECT SUM(multa_parcial) AS mora FROM  detalle_especial WHERE idestadocuenta = $id_Cuenta")->row();
    }

    //metodo para obtener la suma de los intereses calculados
    function interes_esp(int $id_Cuenta)
    {
        return $this->db->query("SELECT SUM(interes_parcial) AS interes FROM  detalle_especial WHERE idestadocuenta = $id_Cuenta")->row();
    }

    //metodo para insertar el pie del estado de cuenta
    function add_PieEspecial($pie)
    {
        $estCuenta_id = 0;
        if ($this->db->insert('pie_especial', $pie)) {
            $estCuenta_id = 1;
        }
        return $estCuenta_id;
    }

    //metodo para actualizar el pie del estado de cuenta
    function upd_PieEspecial($id, $datos)
    {
        $upd = 0;
        $this->db->where('idestadocuenta', $id);
        if ($this->db->update('pie_especial', $datos)) {
            $upd = 1;
        }
        return $upd;
    }

    //metodo para obtener el encabezado del estado de cuenta
    function enc_especial(int $idEstado)
    {
        return $this->db->query("SELECT *
                                    FROM enc_especial
                                    WHERE idestadocuenta = $idEstado")->row();
    }

    //metodo para obtener el detalle del estado de cuenta
    function detalle_especial(int $idEstado)
    {
        return $this->db->query("SELECT *
                                    FROM detalle_especial
                                    WHERE idestadocuenta = $idEstado")->result();
    }

    //metodo para obtener el pie del estado de cuenta
    function pie_especial(int $idEstado)
    {
        return $this->db->query("SELECT *
                                    FROM pie_especial
                                    WHERE idestadocuenta = $idEstado")->row();
    }
}
