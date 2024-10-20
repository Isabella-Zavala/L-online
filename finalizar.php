<?php
  session_start();
  require 'funciones.php';
  require 'vendor/autoload.php'; // Asegúrate de cargar la clase adecuada para acceder a la base de datos
  
  // Instancia de la clase que maneja las paqueterías
  $paqueteria = new libreon\Paqueteria; // Supongamos que tienes esta clase para gestionar paqueterías
  $paqueterias = $paqueteria->mostrar(); // Obtenemos todas las paqueterías
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Libreria Online</title>

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
        </div>
      </div>
    </nav>    

    <div class="container" id="main">
        <div class="main-form">
            <div class="row">
                <div class="col-md-12">
                    <fieldset>
                        <legend>Completar Datos</legend>
                            <form action="completar_pedido.php" method="post">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label>Apellidos</label>
                                    <input type="text" class="form-control" name="apellidos" required>
                                </div>
                                <div class="form-group">
                                    <label>Correo</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="text" class="form-control" name="telefono" required>
                                </div>
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <textarea name="direccion" class="form-control" rows="4" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Comentario</label>
                                    <textarea name="comentario" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                  <label>Paquetería</label>
                                  <select name="paqueteria" class="form-control" required>
                                      <option value="">Seleccione una paquetería</option>
                                      <?php
                                      // Obtener la lista de paqueterías desde la base de datos
                                      $paqueteria = new libreon\Paqueteria();
                                      $lista_paqueterias = $paqueteria->mostrar();

                                      foreach ($lista_paqueterias as $item) {
                                          echo "<option value=\"{$item['id']}\">{$item['nombre']}</option>";
                                      }
                                      ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                <label>Método de Pago</label>
                                <select name="metodo_pago" class="form-control" required>
                                    <option value="">Selecciona un método de pago</option>
                                    <option value="tarjeta_credito">Tarjeta de Crédito</option>
                                    <option value="tarjeta_debito">Tarjeta de Débito</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>
                                <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                            </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>
