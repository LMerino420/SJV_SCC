<?php
class md_usuario extends CI_Model
{
    //metodo constructor
    public function __construct()
    {
        parent::__construct();
    }

    //metodo para validar acceso al sistema
    function log_in($usr, $pwd)
    {
        $this->db->where('usuario', $usr); //comprobar si existe el usuario en la base de datos
        $this->db->where('pwd', $pwd); //comprobar que la clave coincide con el usuario

        $query = $this->db->get('usuario'); //consulta a la base de datos

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    //metodo para obtener el tipo de usuario
    function fc_tipo()
    {
        $qtipo = $this->db->query("SELECT idtipo, perfil 
                                    FROM tipo_usr")->result_array();
        return $qtipo;
    }

    //metodo para obtener la cantidad de usuarios registrados
    function countUsr()
    {
        $qusr = $this->db->query("SELECT u.iduser, u.u_nombre, u.u_apellidos, u.usuario, u.estado, t.perfil 
                                    FROM usuario as u, tipo_usr as t 
                                    WHERE u.idtipo = t.idtipo;");
        return $qusr->num_rows();
    }

    //metodo para la busqueda y paginacion de usuarios
    function pagUsr($pag_size, $offset, $bus) /*---------------[METODO PARA OBTENER Y PAGINAR LA LISTA DE USUARIOS]---------------*/
    {
        $this->db->select('*')
            ->from('usuario  u')
            ->join('tipo_usr  t', 'u.idtipo = t.idtipo')
            ->order_by('iduser')
            ->like('u.u_nombre', $bus)
            ->or_like('u.u_apellidos', $bus)
            ->or_like('u.usuario', $bus)
            ->limit($pag_size, $offset);

        $query = $this->db->get()->result();
        return $query;
    }

    //metodo para obtener los datos de un usuario en especifico
    function get_User(int $idusr)
    {
        return $this->db->query("SELECT u.iduser, u.u_nombre, u.u_apellidos, u.usuario, u.idtipo, u.estado, t.perfil, u.pwd 
                                    FROM usuario as u, tipo_usr as t 
                                    WHERE u.iduser = {$idusr}")->row();
    }

    //metodo para actualizar datos del usuario
    function upd_user(int $id, string $nom, string $apll, $tipo, string $us, $est)
    {
        return $this->db->query("UPDATE usuario 
                                    SET u_nombre = {$nom}, u_apellidos = {$apll}, idtipo = {$tipo}, usuario = {$us}, estado = {$est} 
                                    WHERE iduser = {$id}");
    }

    //metodo para eliminar el registro de un usuario
    function del_user(int $id)
    {
        return $this->db->query("DELETE FROM usuario 
                                    WHERE iduser = {$id}");
    }
}
