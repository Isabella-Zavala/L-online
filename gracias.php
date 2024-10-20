<?php
  session_start();
  require 'funciones.php';
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
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Kawschool Store</a>
      </div>
    </div>
  </nav>

  <div class="container" id="main">
    <!-- Barra de seguimiento del pedido -->
    <div class="tracking-container">
      <div class="progress-line">
        <div class="progress-bar"></div>
      </div>

      <div class="tracking-step active">
        <img src="assets/icons/document.png" alt="Orden Documentada">
        <p>Orden Documentada</p>
      </div>
      <div class="tracking-step">
        <img src="assets/icons/sent.png" alt="Orden Enviada">
        <p>Orden Enviada</p>
      </div>
      <div class="tracking-step">
        <img src="assets/icons/in-transit.png" alt="En Tránsito">
        <p>En Tránsito</p>
      </div>
      <div class="tracking-step">
        <img src="assets/icons/out-for-delivery.png" alt="Salida para Entrega">
        <p>Salida para Entrega</p>
      </div>
      <div class="tracking-step">
        <img src="assets/icons/delivered.png" alt="Entregado">
        <p>Entregado</p>
      </div>
    </div>

    <!-- Jumbotron de agradecimiento -->
    <div class="jumbotron text-center">
      <p>Gracias por su compra</p>
      <p><a href="index.php">Regresar</a></p>
    </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>