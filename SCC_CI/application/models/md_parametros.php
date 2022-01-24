<?php
class md_parametros extends CI_Model
{
    //metodo constructor
    public function __construct()
    {
        parent::__construct();
    }

    //metodo para obtener el porcentaje de interes
    function porcentaje_interes()
    {
        return $this->db->query("SELECT valor AS interes FROM parametros WHERE idparametro=1")->row();
    }

    //metodo para obtener el porcentaje de las fiestas
    function porcentaje_fiesta()
    {
        return $this->db->query("SELECT valor AS fiesta FROM parametros WHERE idparametro=2")->row();
    }

    //metodo para obtener el porcentaje de cobro de mora de los primeros 3 meses
    function porcentaje_tresM()
    {
        return $this->db->query("SELECT valor AS tres_meses FROM parametros WHERE idparametro=3")->row();
    }

    //metodo para obtener el porcentaje de cobro de mora de mas de 3 meses
    function porcentaje_MastresM()
    {
        return $this->db->query("SELECT valor AS mas_tres_meses FROM parametros WHERE idparametro=4")->row();
    }

    //metodo para obtener los parametros de calculo
    function get_parametros()
    {
        $query = $this->db->get('parametros');
        return $query->result();
    }

    //metodo para modificar el valor del parametro
    function upd_parametros(int $idParam, $valor)
    {
        $edit = null;
        if ($this->db->query("UPDATE parametros SET valor = $valor WHERE idparametro = $idParam")) {
            $edit = 1;
        }
        return $edit;
    }
}
