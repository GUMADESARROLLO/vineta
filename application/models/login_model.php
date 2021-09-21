<?php

class Login_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function login($userName, $pass) {
        if($userName != FALSE && $pass != FALSE) {
            $this->db->where('userName', $userName);
            $this->db->where('password', $pass);
            $this->db->where('estado', 1);
            
            $query = $this->db->get('usuarios');

            if($query->num_rows()>0){
                return $query->result_array();
            }
            return 0;
        }
    }

    public function log_session($idUser) {
        $this->db->insert('log_sesion',array(
            'idUser' => $idUser,
            'fecha' => date('Y-m-d H:i:s')
        ));       
    }

    public function info_cliente($idUser) {
        $this->db->where('idUser', $idUser);
        $info_cliente=$this->db->get('usuarios');

        if ($info_cliente->num_rows()>0) {
            return $info_cliente->result_array();
        }else {
            return false;
        }
    }

    public function ultimoAcceso($idUser) {
        $ultimo_acceso=$this->db->query("SELECT * FROM log_sesion WHERE idUser='".$idUser."' ORDER BY id_log DESC LIMIT 1, 2;");

        if ($ultimo_acceso->num_rows()>0) {
            return $ultimo_acceso->result_array();
        }else {
            return false;
        }
    }
}