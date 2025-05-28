<?php

include('libreria/main.php');

$id = $_GET['id'];
$cedula = $_GET['cedula'];

$obra = new Obra();
$ruta = 'datos/'.$id.'.json';
if (is_file($ruta)){
        plantilla::aplicar();
        echo "<div class='text-center'><div class='alert alert-danger'>Error al cargar la obra</div>";
        echo "<a href='index.php' class='btn btn-primary'>Volver</a></div>";
        exit();
}

$json = file_get_contents($ruta);
$obra = json_decode($json);

$personaje = null;

foreach($obra->personajes as $p){
    if($p->cedula == $cedula){
        $personaje = $p;
        break;
    }
}

if ($personaje == null){
        plantilla::aplicar();
        echo "<div class='text-center'><div class='alert alert-danger'>Error al cargar el personaje</div>";
        echo "<a href='index.php' class='btn btn-primary'>Volver</a></div>";
        exit();
}

$obra->personajes = array_filter(array: $obra->personajes, callback: function($p) use ($cedula): bool {
    return $p->cedula != $cedula;
});

file_put_contents($ruta, json_decode(value: $obra));
plantilla::aplicar();

echo "<div class='text-center'><div class='alert alert-danger'>Personaje eliminado correctamente</div>";
        echo "<a href='personajes.php?id=".$obra->codigo."' class='btn btn-primary'>Volver</a></div>";
        exit();
