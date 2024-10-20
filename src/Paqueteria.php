<?php

namespace libreon;

class Paqueteria {

    private $config;
    private $cn = null;

    public function __construct(){
        // Cargar configuración de la conexión desde el archivo config.ini
        $this->config = parse_ini_file(__DIR__.'/../config.ini');
        
        // Crear la conexión a la base de datos
        $this->cn = new \PDO($this->config['dns'], $this->config['usuario'], $this->config['clave'], array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ));
    }

    // Función para mostrar todas las paqueterías
    public function mostrar(){
        $sql = "SELECT * FROM paqueterias";
        $resultado = $this->cn->prepare($sql);
        $resultado->execute();
        return $resultado->fetchAll(\PDO::FETCH_ASSOC);
    }
}
