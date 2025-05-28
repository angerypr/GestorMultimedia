<?php
include('libreria/main.php');
plantilla::aplicar();

$obras = [];
$personajes = [];

if (file_exists('datos/obras.json')) {
    $jsonObras = file_get_contents('datos/obras.json');
    $obras = json_decode($jsonObras);
}

if (file_exists('datos/personajes.json')) {
    $jsonPersonajes = file_get_contents('datos/personajes.json');
    $personajes = json_decode($jsonPersonajes);
}
?>

<div class="text-end mb-3">
    <a href="registrar_obra.php" class="btn btn-primary">Agregar Obra</a>
</div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Código</th>
            <th>Foto</th>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Personajes</th>
            <th>País</th>
            <th>Autor</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($obras as $obra): ?>
            <tr>
                <td><?= $obra->codigo ?></td>
                <td><img src="<?= $obra->foto_url ?>" alt="<?= $obra->nombre ?>" height="100"></td>
                <td><?= Datos::Tipos_de_Obra()[$obra->tipo] ?? 'Otro' ?></td>
                <td><?= $obra->nombre ?></td>
                <td>
                    <?php
                    $contador = 0;
                    foreach ($personajes as $p) {
                        if ($p->codigo_obra === $obra->codigo) {
                            $contador++;
                        }
                    }
                    echo $contador;
                    ?>
                </td>
                <td><?= $obra->pais ?></td>
                <td><?= $obra->autor ?></td>
                <td>
                    <a href="registrar_obra.php?id=<?= $obra->codigo ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="personajes.php?id=<?= $obra->codigo ?>" class="btn btn-info btn-sm">Personajes</a>
                    <a href="detalle.php?id=<?= $obra->codigo ?>" class="btn btn-danger btn-sm">Detalle</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
