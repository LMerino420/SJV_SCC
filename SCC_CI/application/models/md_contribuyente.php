<?php
class md_contribuyente extends CI_Model
{
    //metodo constructor
    public function __construct()
    {
        parent::__construct();
    }

    //metodo para obtener la cantidad de contribuyentes registrados
    function countContri($bus)
    {
        if ($bus == '') {
            $qusr = $this->db->select('*')
                ->from('contribuyente C')
                ->join('propiedad P', 'C.idcontribuyente = P.idcontribuyente');
        } else {
            $qusr =  $this->db->select('*')
                ->from('contribuyente C')
                ->join('propiedad P', 'C.idcontribuyente = P.idcontribuyente', 'left')
                ->join('tributacion T', 'C.idtributo = T.idtributo', 'left')
                ->like('nc', $bus)
                ->or_like('n_nc', $bus)
                ->or_like('titular', $bus, 'both')
                ->or_like('distrito', $bus)
                ->or_like('n_casa', $bus);
        }

        return $qusr->get()->num_rows();
    }

    //metodo para la busqueda y paginacion de los contribuyentes
    function pagContri($pag_size, $offset, $bus)
    {
        $this->db->select('*')
            ->from('contribuyente C')
            ->join('propiedad P', 'C.idcontribuyente = P.idcontribuyente', 'left')
            ->join('tributacion T', 'C.idtributo = T.idtributo', 'left')
            ->like('nc', $bus)
            ->or_like('n_nc', $bus)
            ->or_like('titular', $bus, 'both')
            ->or_like('distrito', $bus)
            ->or_like('n_casa', $bus)
            ->limit($pag_size, $offset);

        $query = $this->db->get()->result();
        return $query;
    }

    //metodo para obtener la informacion de un contribuyente especifico
    function get_Contri(int $idContri)
    {
        return $this->db->query("SELECT *
                                    FROM contribuyente AS C
                                    INNER JOIN propiedad AS P ON C.idcontribuyente = P.idcontribuyente
                                    WHERE C.idcontribuyente = $idContri")->row();
    }

    //metodo para obtener la lista de los años de los registros de pago de un contribuyente especifico
    function get_anio($id)
    {
        return $this->db->query("SELECT DISTINCT anio 
                                    FROM registro_pagos
                                    WHERE idcontribuyente = $id")->result_array();
    }

    //metodo para obtener las tasas de cobro de un contribuyente especifico
    function get_tcobros(int $idcontri, $anio)
    {
        return $this->db->query("SELECT *
                                    FROM tasas_cobro
                                    WHERE idcontribuyente = $idcontri AND anio = $anio")->row();
    }

    //metodo para obtener los registros de pago de un contribuyente especifico
    function get_rpagos(int $idcontri, int $anio)
    {
        return $this->db->query("SELECT *
                                FROM registro_pagos
                                WHERE idcontribuyente = $idcontri AND anio = $anio")->row();
    }

    //metodo para asignar el tipo de tributacion de un contribuyente
    function upd_tributacion(int $idContri, $valor)
    {
        $edit = null;
        if ($this->db->query("UPDATE contribuyente SET idtributo = '$valor' WHERE idcontribuyente = '$idContri'")) {
            $edit = 1;
        }
        return $edit;
    }

    //metodo para obtener el id del contribuyente
    function get_idcontri(int $nc)
    {
        $query = $this->db->query("SELECT idcontribuyente
                                    FROM contribuyente
                                    WHERE nc = $nc")->row();
        return $query;
    }
}
