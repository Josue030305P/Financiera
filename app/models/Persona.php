<?php

require_once '../config/Database.php';

class Persona {

    private $conexion;

    public function __construct()
    {
        $this->conexion = Database::getConexion();
    }


    public function addConyuge($params = []) : array {
        try {
          
            $sql = "CALL  sp_add_conyuge(?,?,?,?,?,?,?,?)";
            $smt = $this->conexion->prepare($sql);
            $smt->execute([
                $params['idpais'],
                $params['apellidos'],
                $params['nombres'],
                $params['tipodocumento'],
                $params['numdocumento'],
                $params['email'],
                $params['telprincipal'],
                $params['domicilio'],
            ]);
            $result = $smt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset( $result['idconyuge'] )) {
                return ['success'=> true,'idconyuge'=> $result['idconyuge']];
            } else {
                return ['success'=> false,'message'=> 'Error al obtener el ID conyuge'];
            }

        

        }
        catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

}


// $c = new Persona();
// $datos = [
//     'idpais'=> 1,
//     'apellidos' => 'Flores Fuentes',
//     'nombres'=> 'Rosa Andrea',
//     'tipodocumento'=> 'DNI',
//     'numdocumento'=> '85858585',
//     'email' => 'floresfuentesros@gmail.com',
//     'telprincipal' => '985854210',
//     'domicilio' => 'sdsdsd'
// ];

// var_dump($c->addConyuge($datos));   