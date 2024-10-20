<?php

namespace libreon;

class Cliente{

    private $config;
    private $cn = null;

    public function __construct(){

        $this->config = parse_ini_file(__DIR__.'/../config.ini') ;

        $this->cn = new \PDO( $this->config['dns'], $this->config['usuario'],$this->config['clave'],array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ));
        
    }

    public function registrar($_params) {
        $sql = "INSERT INTO `clientes`(`nombre`, `apellidos`, `email`, `telefono`, `direccion`, `comentarios`) 
                VALUES (:nombre, :apellidos, :email, :telefono, :direccion, :comentarios)";
    
        $resultado = $this->cn->prepare($sql);
    
        // Asignar un valor por defecto a 'comentarios' si no está definido
        $_params['comentarios'] = $_params['comentarios'] ?? ''; // Asigna '' si 'comentarios' no está definido
    
        $_array = array(
            ":nombre" => $_params['nombre'],
            ":apellidos" => $_params['apellidos'],
            ":email" => $_params['email'],
            ":telefono" => $_params['telefono'],
            ":direccion" => $_params['direccion'],
            ":comentarios" => $_params['comentarios']
        );
    
        if ($resultado->execute($_array)) {
            return $this->cn->lastInsertId();
        }
    
        return false;
    }
    

}