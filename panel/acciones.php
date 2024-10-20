<?php
require '../vendor/autoload.php';

$libro = new libreon\Libro;

if($_SERVER['REQUEST_METHOD'] ==='POST'){

    if ($_POST['accion']==='Registrar'){

        if(empty($_POST['titulo']))
            exit('Completar titulo');

        if(empty($_POST['autor']))
            exit('Completar autor');
        
        if(empty($_POST['descripcion']))
            exit('Completar titulo');

        if(empty($_POST['categoria_id']))
            exit('Selecciona una Categoria');

        if(!is_numeric($_POST['categoria_id']))
            exit('Selecciona una Categoria válida');

        
        $_params = array(
            'titulo'=>$_POST['titulo'],
            'autor'=>$_POST['autor'],
            'descripcion'=>$_POST['descripcion'],
            'foto'=> subirFoto(),
            'precio'=>$_POST['precio'],
            'categoria_id'=>$_POST['categoria_id'],
            'fecha'=> date('Y-m-d')
        );

        $rpt = $libro->registrar($_params);
        if($rpt)
            header('Location: libros/index.php');
        else
            print 'Error al registrar un libro';    

    }
    if ($_POST['accion']==='Actualizar'){
        if(empty($_POST['titulo']))
            exit('Completar titulo');

        if(empty($_POST['autor']))
            exit('Completar autor');
        
        if(empty($_POST['descripcion']))
            exit('Completar titulo');

        if(empty($_POST['categoria_id']))
            exit('Selecciona una Categoria');

        if(!is_numeric($_POST['categoria_id']))
            exit('Selecciona una Categoria válida');

        
        $_params = array(
            'titulo'=>$_POST['titulo'],
            'autor'=>$_POST['autor'],
            'descripcion'=>$_POST['descripcion'],
            'precio'=>$_POST['precio'],
            'categoria_id'=>$_POST['categoria_id'],
            'fecha'=> date('Y-m-d'),
            'id'=>$_POST['id'],
        );

        if(!empty($_POST['foto_temp']))
        $_params['foto'] = $_POST['foto_temp'];
    
        if(!empty($_FILES['foto']['name']))
            $_params['foto'] = subirFoto();

        $rpt = $libro->actualizar($_params);
        if($rpt)
            header('Location: libros/index.php');
        else
            print 'Error al actualizar un libro';

    }
}
if($_SERVER['REQUEST_METHOD'] ==='GET'){

    $id = $_GET['id'];

    $rpt = $libro->eliminar($id);
    
    if($rpt)
        header('Location: libros/index.php');
    else
        print 'Error al eliminar un libro';


}

function subirFoto(){

    $carpeta = __DIR__.'/../upload/';

    $archivo = $carpeta.$_FILES['foto']['name'];

    move_uploaded_file($_FILES['foto']['tmp_name'],$archivo);

    return $_FILES['foto']['name'];

}






