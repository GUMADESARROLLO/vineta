<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('cookie');
		$this->load->helper("url");
	}

    public function index() {
        $ApplicationVersion = new git_version();
        $data = [
            'appVersion' => $ApplicationVersion::get(),
        ];

        $this->load->view('header/header_login');
		$this->load->view('login/login',$data);
		$this->load->view('footer/footer_login');
    }

    public function validandoCuenta() {
        if($this->input->post('submit')){
            $this->form_validation->set_rules('usuario', 'Usuario', 'required|min_length[3]');
            $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[3]');
             
            $this->form_validation->set_message('required','El campo %s es obligatorio');
             
             if($this->form_validation->run()!=false){

	            $data['user']=$this->login_model->login($this->input->get_post('usuario'),$this->input->get_post('password'));
	            
	            if ($data['user']==0){
	                redirect('?error=2');
	            } else {
	            	$this->login_model->log_session($data['user'][0]['idUser']);
	                
	                $sessiondata = array(
	                    'idUser' => $data['user'][0]['idUser'],
	                    'userName' => $data['user'][0]['userName'],
	                    'nombre' => $data['user'][0]['nombre'],
	                    'rol'=>$data['user'][0]['rol'],
                        'Permisos'=>$data['user'][0]['Cuentas'],
	                    'logged' => 1
	                );
	                $this->session->set_userdata($sessiondata);

	                if($this->session->userdata){	                    
	                    redirect('main');
	                }
	            }   
             }else{
                $datos["mensaje"]="¡Datos vacíos!";
		        $this->load->view('header/header_login');
				$this->load->view('login/login', $datos);
				$this->load->view('footer/footer_login');
             }
         }
    }

    public function salir() {
        $this->session->sess_destroy();
        $sessiondata = array('logged' => 0);
        $this->session->unset_userdata($sessiondata);
        redirect(base_url().'index.php');
    }
}
