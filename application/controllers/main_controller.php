<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class main_controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('persona');

        if($this->session->userdata('logged')==0){
            redirect(base_url().'index.php/login','refresh');
        }
    }

    public function index() {
        $this->load->view('header/header');
        $this->load->view('pages/Main/main');
        $this->load->view('footer/footer');
        $this->load->view('jsView/js_main');
    }
    public function inweb() {
        $this->load->view('header/header');
        $this->load->view('pages/Main/inweb');
        $this->load->view('footer/footer');
        $this->load->view('jsView/js_inweb');
    }
    public function getInfoCuenta($id){
        $this->main_model->getInfoCuenta($id);
    }
    public function Load_factura($id,$Accion){
        $this->main_model->Load_factura($id,$Accion);
    }
    public function save_log_factura($id,$Accion,$Razon){
        $this->main_model->save_log_factura($id,$Accion,$Razon);
    }

    public function getResumen(){
        $this->main_model->getResumen();
    }
    public function getInweb(){
        $this->main_model->getInweb();
    }
    public function BuscarSolicitud(){
        $this->main_model->BuscarSolicitud($_POST['f1'],$_POST['f2']);
    }
    public function reset_sku(){
        $this->main_model->reset_sku();
    }



}
?>