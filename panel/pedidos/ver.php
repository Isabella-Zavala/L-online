<?php

session_start();

if(!isset($_SESSION['usuario_info']) OR empty($_SESSION['usuario_info']))
  header('Location: ../index.php');
  $costo_paqueteria = isset($info_pedido['paqueteria']) ? $pedido->obtenerCostoPaqueteria($info_pedido['paqueteria']) : 0;
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
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css">
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
          <a class="navbar-brand" href="../dashboard.php">Libreria Online</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav pull-right">
            <li class="active">
              <a href="index.php" class="btn">Pedidos</a>
            </li> 
            <li>
              <a href="../libros/index.php" class="btn">Libros</a>
            </li> 
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php print $_SESSION['usuario_info'] ['nombre_usuario']?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="../cerrar_session.php">Salir</a></li>
                </ul>
            </li>
          </ul>


        </div><!--/.nav-collapse -->
      </div>
    </nav>    

    <div class="container" id="main">
    <div class="row">
            <div class="col-md-12">
               <fieldset>
               <?php
                  require '../../vendor/autoload.php';
                  $id = $_GET['id'];
                  $pedido = new libreon\Pedido;
                  $info_pedido = $pedido->mostrarPorId($id);
                  $info_detalle_pedido = $pedido->mostrarDetallePorIdPedido($id);
                  ?>
                    <legend>Información de la compra</legend>
                    <div class="form-group">
                        <label>Nombre del cliente</label>
                        <input value="<?php print $info_pedido ['nombre'] ?>" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input value="<?php print $info_pedido ['apellidos'] ?>" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input value="<?php print $info_pedido ['email'] ?>" type="text" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                      <label>Teléfono</label>
                      <input value="<?php print isset($info_pedido['telefono']) ? $info_pedido['telefono'] : 'No disponible'; ?>" type="text" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                      <label>Dirección</label>
                      <input value="<?php print isset($info_pedido['direccion']) ? $info_pedido['direccion'] : 'No disponible'; ?>" type="text" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                      <label>Paquetería</label>
                      <input value="<?php print isset($info_pedido['paqueteria']) ? $info_pedido['paqueteria'] : 'No disponible'; ?>" type="text" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                      <label>Costo de Paquetería</label>
                      <input value="<?php print number_format($info_pedido['costo_paqueteria'], 2); ?>" type="text" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                      <label>Total</label>
                      <input value="<?php print number_format($info_pedido['total'] + $costo_paqueteria, 2); ?>" type="text" class="form-control" readonly>
                  </div>
                <div class="form-group">
                    <label>Fecha</label>
                    <input value="<?php print $info_pedido['fecha'] ?>" type="text" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Método de Pago</label>
                    <input value="<?php print isset($info_pedido['metodo_pago']) ? $info_pedido['metodo_pago'] : 'No disponible'; ?>" type="text" class="form-control" readonly>
                </div>
                    <hr>
                        Productos comprados
                    <hr>  
                    <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Titulo</th>
                        <th>Autor</th>
                        <th>Foto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                        $cantidad = count($info_detalle_pedido);
                        if($cantidad > 0){
                          $c=0;
                        for($x =0; $x < $cantidad; $x++){
                          $c++;
                          $item = $info_detalle_pedido[$x];
                          $total = $item ['precio'] * $item ['cantidad'];


                      ?>
                        <tr>
                        <td><?php print $c?></td>
                        <td><?php print $item['titulo']?></td>
                        <td><?php print $item['autor']?></td>
                        <td> <?php
                            $foto = '../../upload/'.$item['foto'];
                            if(file_exists($foto)){
                            ?>
                            <img src="<?php print $foto; ?>" width="35">
                            <?php }else{?>
                                SIN FOTO
                            <?php }?>
                        </td>
                        <td><?php print $item['precio']?></td>
                        <td><?php print $item['cantidad']?></td>
                        <td><?php print $total?></td>
                        
                        </tr>

                        <?php
                            }
                        }else {
                        ?>
                        <tr>
                            <td colspan="6">NO HAY REGISTROS</td>
                        </tr>
                        <?php } 
                        ?>

                      </tbody>
                    
                  </table>
                  <div class= "col-md-3">
                  <div class="form-group">
                        <label>Total de la compra</label>
                        <input value="<?php print $info_pedido ['total'] ?>" type="text" class="form-control" readonly>
                    </div>
                    </div>               
                        <div class="clearfix"></div>
                        <div class="text-right"> 
                        <a href="index.php" class="btn btn-default hidden-print">Cancelar</a>
                        <a href="javascript:;" id="btnImprimir" class="btn btn-danger hidden-print">Imprimir</a>
                        </div>
               </fieldset>
            </div>
        </div>

    </div> 
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script>
        $('#btnImprimir').on('click',function(){
            window.print();
            return false;
        })
    </script>

  </body>
</html>
