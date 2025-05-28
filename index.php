<?php
include('libreria/main.php');
plantilla::aplicar();
?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title">Ver Obras</h5>
                        <p class="card-text">Consultar las películas y series registradas.</p>
                        <a href="ver_obras.php" class="btn btn-primary mt-3">Ver Obras Registradas</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title">Registrar Obra</h5>
                        <p class="card-text">Añadir una nueva película o serie a la colección.</p>
                        <a href="registrar_obra.php" class="btn btn-success mt-3">Registrar Nueva Obra</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h5 class="card-title">Agregar Personaje</h5>
                        <p class="card-text">Asociar personajes a las obras ya vistas.</p>
                        <a href="agregar_personaje.php" class="btn btn-info mt-3">Agregar Personaje</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
