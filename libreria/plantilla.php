<?php
class plantilla {
    public static $instancia = null;

    public static function aplicar(): plantilla {
        if (self::$instancia == null) {
            self::$instancia = new plantilla();
        }
        return self::$instancia;
    }

    public function __construct() {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gestor de Multimedia</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        </head>
        <body>
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="index.php">
                   <img src="assets/logo.png" alt="Logo" height="40" class="me-2">
                    <span>Gestor de Multimedia</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="ver_obras.php"> Ver Obras</a></li>
                        <li class="nav-item"><a class="nav-link" href="registrar_obra.php"> Nueva Obra</a></li>
                        <li class="nav-item"><a class="nav-link" href="agregar_personaje.php"> Nuevo Personaje</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <div class="text-center mb-4">
                <h1>Gestor de Multimedia</h1>
                <p class="lead">Listado de películas y series en las que he invertido mi tiempo</p>
            </div>

            <div style="min-height: 500px;">
        <?php
    }

    public function __destruct() {
        ?>
            </div>
            <footer class="text-center mt-5 mb-3">
                <hr>
                <p class="text-muted">
                    &copy; <?= date('Y') ?> - Todos los derechos reservados | Gestor de Multimedia
                </p>
            </footer>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </div>
        </body>
        </html>
        <?php
    }
}
?>
