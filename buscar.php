<?php
session_start();
require 'vendor/autoload.php';

// Asegúrate de que el formulario de búsqueda envía una consulta 'query'
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Instancia de la clase Libro
    $libro = new libreon\Libro;

    // Obtener los resultados de la búsqueda
    $resultados = $libro->buscarPorTituloOCategoria($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Libreria Online</a>
            </div>
        </div>
    </nav>

    <div class="container" id="main">
        <h3>Resultados de búsqueda para "<?php echo htmlspecialchars($query); ?>"</h3>

        <div class="row">
            <?php
            if (!empty($resultados)) {
                foreach ($resultados as $item) {
                    ?>
                    <div class="col-md-2"> <!-- Cambiado de col-md-3 a col-md-2 para que coincida -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 class="text-center titulo-libro"><?php echo $item['titulo']; ?></h1>  
                            </div>
                            <div class="panel-body">
                                <?php
                                $foto = 'upload/' . $item['foto'];
                                if (file_exists($foto)) {
                                    ?>
                                    <img src="<?php echo $foto; ?>" class="img-responsive">
                                <?php } else { ?>
                                    <img src="assets/imagenes/not-found.jpg" class="img-responsive">
                                <?php } ?>
                            </div>
                            <div class="panel-footer">
                                <a href="carrito.php?id=<?php echo $item['id']; ?>" class="btn btn-success btn-block">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Comprar
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<h4>No se encontraron resultados.</h4>';
            }
            ?>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
