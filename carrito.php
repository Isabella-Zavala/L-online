<?php
session_start();

require 'funciones.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
    require 'vendor/autoload.php';
    $libro = new libreon\Libro;
    $resultado = $libro->mostrarPorId($id);
    
    if(!$resultado)
       header('Location: index.php');

       

    if(isset($_SESSION['carrito'])){ //SI EL CARRITO EXISTE
        //SI EL PELICULA EXISTE EN EL CARRITO
        if(array_key_exists($id,$_SESSION['carrito'])){
            actualizarLibro($id);
        }else{
            //  SI EL CARRITO NO EXISTE EN EL CARRITO
            agregarLibro($resultado, $id);
        }

    }else{
        //  SI EL CARRITO NO EXISTE
        agregarLibro($resultado, $id);

    }

   

}  



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Libreria Online</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Libreria Online</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav pull-right">
            <li>
              <a href="carrito.php" class="btn">CARRITO <span class="badge"><?php print cantidadLibros(); ?></span></a>
            </li> 
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>    

    <div class="container" id="main">
        <table class="table table-bordered table-hover" >
            <thead>
                <tr>
                   <th>#</th>
                    <th>Libro</th>
                    <th>Foto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody> 
            <?php
                if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])){
                    $c=0;
                    foreach($_SESSION['carrito'] as $indice => $value){
                            $c++;
                            $total = $value['precio'] * $value['cantidad'];
                    ?>       
                    <tr>
                        <form action="actualizar_carrito.php" method="post" >
                            <td><?php print $c?></td>
                            <td><?php print $value['titulo']?> </td>
                            <td>
                                <?php
                                    $foto = 'upload/'.$value['foto'];
                                    if(file_exists($foto)){
                                    ?>
                                    <img src="<?php print $foto; ?>" width="35">
                                <?php }else{?>
                                    <img src="assets/imagenes/not-found.jpg" width="35">
                                <?php }?>
                            </td>
                            <td><?php print $value['precio']?> MX </td>
                            <td>
                                <input type="hidden" name="id"  value="<?php print $value['id'] ?>">
                                <input type="text" name="cantidad" class="form-control u-size-100" value="<?php print $value['cantidad'] ?>">
                            </td>
                            <td>
                                <?php print $total ?>  MX
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success btn-xs">
                                    <span class="glyphicon glyphicon-refresh"></span>
                                </button>

                                <a href="eliminar_carrito.php?id=<?php print $value['id'] ?>" class="btn btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>

                            </td>
                        </form>
                    </tr>
                    <?php 
                        }
                        }else{
                    ?>
                        <tr>
                            <td colspan="t"> NO HAY PRODUCTOS EN EL CARRITO </td>
                        </tr>
                    <?php   
                        }
                    ?>
            </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right">Total</td>
                        <td><?php print calcularTotal(); ?>MX</td>
                        <td></td>
                    </tr>
                </tfoot>
        </table>
        <hr>
        <?php
            if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        ?>
        <div class="row">
            <div class="col text-right">
                <a href="index.php" class="btn btn-info">Seguir Comprando</a>
                <a href="finalizar.php" class="btn btn-success">Finalizar Compra</a>
            </div>
        </div>
        <?php
            }
        ?>

    </div> <!-- /container -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>