<?php
include_once('libreria/main.php');

$archivoObras = 'datos/obras.json';
$archivoPersonajes = 'datos/personajes.json';

function calcularEdad($fecha_nacimiento) {
    $nacimiento = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    return $hoy->diff($nacimiento)->y;
}

function obtenerSignoZodiacal($fecha) {
    $mes_dia = date('md', strtotime($fecha));
    $zodiacos = [
        ['120', '218', 'Acuario'],
        ['219', '320', 'Piscis'],
        ['321', '419', 'Aries'],
        ['420', '520', 'Tauro'],
        ['521', '620', 'Géminis'],
        ['621', '722', 'Cáncer'],
        ['723', '822', 'Leo'],
        ['823', '922', 'Virgo'],
        ['923', '1022', 'Libra'],
        ['1023', '1121', 'Escorpio'],
        ['1122', '1221', 'Sagitario'],
        ['1222', '119', 'Capricornio']
    ];

    foreach ($zodiacos as [$inicio, $fin, $signo]) {
        if ($inicio <= $fin && $mes_dia >= $inicio && $mes_dia <= $fin) {
            return $signo;
        } elseif ($inicio > $fin && ($mes_dia >= $inicio || $mes_dia <= $fin)) {
            return $signo;
        }
    }
    return 'Desconocido';
}

plantilla::aplicar();
?>

<!-- CSS para evitar scroll horizontal al imprimir -->
<style>
@media print {
    .table-responsive {
        overflow-x: visible !important;
    }

    .personajes-table {
        width: 100% !important;
        table-layout: auto !important;
    }

    th, td {
        white-space: normal !important;
    }

    img {
        max-width: 100% !important;
        height: auto !important;
    }

    .btn, .text-end {
        display: none !important;
    }
}
</style>

<?php

$codigoObra = $_GET['id'] ?? null;
if (!$codigoObra) {
    echo "<div class='alert alert-danger text-center'>Código de obra no especificado.</div>";
    exit;
}

$obras = file_exists($archivoObras) ? json_decode(file_get_contents($archivoObras)) : [];
$personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes)) : [];

$obra = null;
foreach ($obras as $o) {
    if ($o->codigo === $codigoObra) {
        $obra = $o;
        break;
    }
}

if (!$obra) {
    echo "<div class='alert alert-danger text-center'>No se encontró la obra.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_cedula'])) {
    $cedulaEliminar = $_POST['eliminar_cedula'];
    $personajes = array_filter($personajes, fn($p) => $p->cedula !== $cedulaEliminar);
    file_put_contents($archivoPersonajes, json_encode(array_values($personajes), JSON_PRETTY_PRINT));
    echo "<div class='alert alert-success text-center'>Personaje eliminado correctamente.</div>";
}

$personajesObra = array_filter($personajes, fn($p) => $p->codigo_obra === $codigoObra);
?>

<div class="text-end mb-3">
    <a href="ver_obras.php" class="btn btn-secondary">Volver</a>
    <a href="agregar_personaje.php?id=<?= urlencode($codigoObra) ?>" class="btn btn-success">Agregar personaje</a>
    <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
</div>

<div class="mb-4">
    <h2><?= htmlspecialchars($obra->nombre) ?></h2>
    <img src="<?= htmlspecialchars($obra->foto_url) ?>" class="img-fluid rounded mb-2" height="200" alt="<?= htmlspecialchars($obra->nombre) ?>">
    <p><strong>Tipo:</strong> <?= Datos::Tipos_de_Obra()[$obra->tipo] ?? $obra->tipo ?></p>
    <p><strong>Autor:</strong> <?= htmlspecialchars($obra->autor) ?></p>
    <p><strong>País:</strong> <?= htmlspecialchars($obra->pais) ?></p>
    <p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($obra->descripcion)) ?></p>
</div>

<div>
    <h3>Personajes</h3>

    <?php if (empty($personajesObra)): ?>
        <div class="alert alert-info">No hay personajes registrados para esta obra.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped personajes-table">
                <thead class="table-dark">
                    <tr>
                        <th>Cédula</th>
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Edad</th>
                        <th>Signo</th>
                        <th>Sexo</th>
                        <th>Habilidades</th>
                        <th>Comida Favorita</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personajesObra as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p->cedula) ?></td>
                            <td><img src="<?= htmlspecialchars($p->foto_url) ?>" alt="Foto" height="60" class="rounded"></td>
                            <td><?= htmlspecialchars($p->nombre) ?></td>
                            <td><?= htmlspecialchars($p->apellido) ?></td>
                            <td><?= htmlspecialchars($p->fecha_nacimiento) ?></td>
                            <td><?= calcularEdad($p->fecha_nacimiento) ?> años</td>
                            <td><?= obtenerSignoZodiacal($p->fecha_nacimiento) ?></td>
                            <td><?= htmlspecialchars($p->sexo) ?></td>
                            <td><?= htmlspecialchars(implode(', ', $p->habilidades)) ?></td>
                            <td><?= htmlspecialchars($p->comida_favorita) ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('¿Está seguro de eliminar este personaje?');">
                                    <input type="hidden" name="eliminar_cedula" value="<?= htmlspecialchars($p->cedula) ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

