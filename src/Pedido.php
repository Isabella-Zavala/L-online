<?php

namespace libreon;

class Pedido{

    private $config;
    private $cn = null;

    public function __construct(){

        $this->config = parse_ini_file(__DIR__.'/../config.ini') ;

        $this->cn = new \PDO( $this->config['dns'], $this->config['usuario'],$this->config['clave'],array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ));
        
    }

    public function registrar($_params) {
        $sql = "INSERT INTO `pedidos`(`cliente_id`, `total`, `fecha`, `paqueteria`, `metodo_pago`) 
                VALUES (:cliente_id, :total, :fecha, :paqueteria, :metodo_pago)";
        
        $resultado = $this->cn->prepare($sql);
        
        $_array = array(
            ":cliente_id" => $_params['cliente_id'],
            ":total" => $_params['total'],
            ":fecha" => $_params['fecha'],
            ":paqueteria" => $_params['paqueteria'],
            ":metodo_pago" => $_params['metodo_pago']
        );
        
        if ($resultado->execute($_array))
            return $this->cn->lastInsertId();
        
        return false;
    }    
   
    public function registrarDetalle($_params){
        if (!isset($_params['libros_id'])) {
            throw new \Exception("La clave 'libros_id' no está definida.");
        }

        $sql = "INSERT INTO `detalle_pedidos`(`pedido_id`, `libros_id`, `precio`, `cantidad`) 
            VALUES (:pedido_id,:libros_id,:precio,:cantidad)";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ":pedido_id" => $_params['pedido_id'],
            ":libros_id" => $_params['libros_id'],
            ":precio" => $_params['precio'],
            ":cantidad" => $_params['cantidad'],
        );
        if ($resultado->execute($_array)) {
            return true;
        }
    
        return false;
    }
    public function mostrar()
    {
        $sql = "SELECT p.id, nombre, apellidos, email, telefono, direccion, total, fecha FROM pedidos p 
        INNER JOIN clientes c ON p.cliente_id = c.id ORDER BY p.id DESC";

        $resultado = $this->cn->prepare($sql);

        if($resultado->execute())
            return  $resultado->fetchAll();

        return false;

    }
    public function mostrarUltimos()
    {
        $sql = "SELECT p.id, nombre, apellidos, email, telefono, direccion, total, fecha FROM pedidos p 
        INNER JOIN clientes c ON p.cliente_id = c.id ORDER BY p.id DESC LIMIT 10";

        $resultado = $this->cn->prepare($sql);

        if($resultado->execute())
            return  $resultado->fetchAll();

        return false;

    }

    public function mostrarPorId($id)
    {
        $sql = "SELECT p.id, c.nombre, c.apellidos, c.email, c.telefono, c.direccion, p.total, p.fecha, 
                    pa.nombre AS paqueteria, pa.costo AS costo_paqueteria, p.metodo_pago 
                FROM pedidos p 
                INNER JOIN clientes c ON p.cliente_id = c.id 
                INNER JOIN paqueterias pa ON p.paqueteria = pa.id
                WHERE p.id = :id";

        $resultado = $this->cn->prepare($sql);
        
        $_array = array(':id' => $id);

        if ($resultado->execute($_array)) {
            return $resultado->fetch();
        }

        return false;
    }

    public function mostrarDetallePorIdPedido($id)
    {
        $sql = "SELECT 
                dp.id,
                li.titulo,
                li.autor,
                dp.precio,
                dp.cantidad,
                li.foto
                FROM detalle_pedidos dp
                INNER JOIN libros li ON li.id= dp.libros_id
                WHERE dp.pedido_id = :id";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ':id'=>$id
        );

        if($resultado->execute( $_array))
            return  $resultado->fetchAll();

        return false;

    }
    public function obtenerCostoPaqueteria($paqueteria_id) {
        $sql = "SELECT costo FROM paqueterias WHERE id = :id";
        $resultado = $this->cn->prepare($sql);
        $resultado->execute([':id' => $paqueteria_id]);
        
        $paqueteria = $resultado->fetch();
        
        return $paqueteria ? $paqueteria['costo'] : 0;
    }    


}