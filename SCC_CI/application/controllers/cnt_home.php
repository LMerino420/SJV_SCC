<?php
class cnt_home extends CI_Controller
{
    //metodo constructor
    public function __construct()
    {
        parent::__construct();
        $this->load->model('md_usuario'); //instanciar modelo
    }

    //--------------------------------------------LOGIN--------------------------------------------//
    public function index($usuario = null, $clave = null)
    {
        $usuario = $this->input->POST('usuario'); //asignar valor ingresado por el usuario
        $clave = md5($this->input->POST('pwd')); //asignar valor ingresado por el usuario

        $res = $this->md_usuario->log_in($usuario, $clave); //metodo para validar acceso desde el modelo

        //asignacion de variables de sesion
        if ($res) {
            $dt_sesion = array(
                'iduser' => $res->iduser,
                'u_nombre' => $res->u_nombre,
                'u_apellidos' => $res->u_apellidos,
                'idtipo' => $res->idtipo,
                'usuario' => $res->usuario,
                'estado' => $res->estado,
                'login' => TRUE
            );

            $this->session->set_userdata($dt_sesion);
            redirect('cnt_home/menu');
        }

        $this->load->view('home/index', 'refresh');
    }

    //--------------------------------------------LOGOUT--------------------------------------------//
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    //--------------------------------------------HOME--------------------------------------------//
    public function menu()
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }
        $this->load->view('home/menu', 'refresh');
    }

    //--------------------------------------------REGISTRO DE USUARIOS--------------------------------------------//
    public function registro()
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }

        if (isset($_POST['registrar'])) {
            //validacion de campos obligatorios
            $this->form_validation->set_rules('nombres', 'Nombres', 'required');
            $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
            $this->form_validation->set_rules('usuario', 'Usuario', 'required');
            $this->form_validation->set_rules('pwd', 'Contraseña', 'required|min_length[4]');
            $this->form_validation->set_rules('cpwd', 'Confirmar contraseña', 'required|min_length[4]|matches[pwd]');

            if ($this->form_validation->run() == TRUE) {
                //arreglo para insertar datos a la base de datos
                $ar_data = array(
                    'u_nombre' => $_POST['nombres'],
                    'u_apellidos' => $_POST['apellidos'],
                    'idtipo' => $_POST['tipo'],
                    'usuario' => $_POST['usuario'],
                    'pwd' => md5($_POST['pwd']),
                    'estado' => $_POST['estado']
                );

                $user = $this->db->query('SELECT * FROM usuario WHERE usuario = ?', $_POST['usuario'])->result_array();

                //validacion para que los usuarios sean unicos
                if (!empty($user)) {
                    $this->session->set_flashdata("MSJ_USR", "El usuario que intenta registrar ya existe");
                } else {
                    $this->db->INSERT('usuario', $ar_data);
                    $this->session->set_flashdata("MSJ_USR", "El usuario ha sido registrado correctamente");
                }
            }
        }

        if (isset($_POST['lista'])) {
            redirect("cnt_home/usuarios", "refresh");
        }

        $data_tip['fc_tipo'] = $this->md_usuario->fc_tipo();
        $this->load->view('home/registro', $data_tip);
    }

    //--------------------------------------------LISTA DE USUARIOS--------------------------------------------//
    public function usuarios($pag = 1)
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }

        //variables de configuracion para la paginacion de los usuarios
        $pag--;
        if ($pag < 0) {
            $pag = 0;
        }
        
        $page_size = 5;
        $offset = $pag * $page_size;

        //busqueda de usuarios
        if ($_POST) {
            $buscar = $this->input->post('busqueda');
        } else {
            $buscar = '';
        }
        $data['lista_usuarios'] = $this->md_usuario->pagUsr($page_size, $offset, $buscar); //metodo para busqueda y paginacion de la lista
        $data['current_pag'] = $pag++; //obtener valor de la pagina en la que se encuenta
        $data['last_page'] = ceil($this->md_usuario->countUsr() / $page_size); //obtencion del total de paginacion
        $this->load->view("home/usuarios", $data); //cargar datos a la vista
    }

    //--------------------------------------------EDITAR USUARIO--------------------------------------------//
    public function edit_usr($idusr = null)
    {
        //validar que debe estar logeado para poder acceder a la vista
        if ($this->session->userdata('login') == FALSE) {
            redirect(base_url());
        }

        if ($idusr !== null) {
            $idusr = $this->db->escape((int)$idusr);
            $data_tip['fc_tipo'] = $this->md_usuario->fc_tipo();
            $data_tip['get_User'] = $this->md_usuario->get_User($idusr);

            $this->load->view('home/edit_usr', $data_tip);
        } else {
            redirect("cnt_home/usuarios", "refresh");
        }
    }

    //--------------------------------------------ACTUALIZAR USUARIO--------------------------------------------//
    public function update_usr()
    {
        if ($this->input->POST()) {

            $id = $this->db->escape((int)$_POST['idus']);
            $nom = $this->db->escape($_POST['nombres']);
            $apll = $this->db->escape($_POST['apellidos']);
            $tipo = $this->db->escape($_POST['tipo']);
            $us = $this->db->escape($_POST['usuario']);
            $est = $this->db->escape($_POST['estado']);

            if ($this->md_usuario->upd_user($id, $nom, $apll, $tipo, $us, $est)) {
                $this->session->set_flashdata("MSJ_UPD_USR", "Datos actualizados correctamente");
                redirect('cnt_home/edit_usr/' . $id);
            } else {
                $this->session->set_flashdata("MSJ_UPD_USR", "No se pudieron actualizar los datos");
                redirect('cnt_home/edit_usr/' . $id);
            }
        }
    }

    //--------------------------------------------ELIMINAR USUARIO--------------------------------------------//
    public function delete_usr(int $id)
    {
        if ($this->md_usuario->del_user($id)) {
            $this->session->set_flashdata("MSJ_DEL_USR", "Se elimino un usuario");
            redirect('cnt_home/usuarios');
        }
    }
}
