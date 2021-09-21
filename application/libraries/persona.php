<?php 
class persona {
    public $idUser;
    public $userName;
    public $password;
    public $nombre;
    public $rol;
    public $activo;

     
    //Metodos get 
    public function get_identificacion() {
        return $this->identificacion;
    }

    //Metodos set
    public function set_idUser($idUser) { 
        $this->idUser = $idUser;
    }

    public function set_userName($userName) {        
        $this->userName = $userName;
    }

    public function set_password($password) {        
        $this->password = $password;
    }

    public function set_nombre($nombre) {        
        $this->nombre = $nombre;
    }

    public function set_rol($rol) {        
        $this->rol = $rol;
    }

    public function set_activo($activo) {        
        $this->activo = $activo;
    }
}

class materias {
    public $nombreMateria;

    public function get_materia() {
        return $this->nombreMateria;
    }

    public function set_materia($materia) {
        $this->nombreMateria = $materia;
    }
}