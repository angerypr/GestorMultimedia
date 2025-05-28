<?php
include('libreria/main.php');
plantilla::aplicar();

$codigoObra = $_GET['id'] ?? null;

if (!$codigoObra) {
    echo "<div class='alert alert-danger'>Código de obra no especificado.</div>";
    exit;
}

$archivoObras = 'datos/obras.json';
$archivoPersonajes = 'datos/personajes.json';

$obras = file_exists($archivoObras) ? json_decode(file_get_contents($archivoObras)) : [];
$personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes)) : [];

// Buscar la obra
$obra = null;
foreach ($obras as $o) {
    if ($o->codigo === $codigoObra) {
        $obra = $o;
        break;
    }
}

if (!$obra) {
    echo "<div class='alert alert-danger'>No se encontró la obra.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_cedula'])) {
    $cedulaEliminar = $_POST['eliminar_cedula'];
    $personajes = array_filter($personajes, fn($p) => $p->cedula !== $cedulaEliminar);
    file_put_contents($archivoPersonajes, json_encode(array_values($personajes), JSON_PRETTY_PRINT));
    echo "<div class='alert alert-success'>Personaje eliminado correctamente.</div>";
}

$personajesObra = array_filter($personajes, fn($p) => $p->codigo_obra === $codigoObra);
?>

<h2>Personajes de la obra: <?= htmlspecialchars($obra->nombre) ?></h2>

<a href="ver_obras.php" class="btn btn-secondary mb-3">Volver</a>
<a href="agregar_personaje.php?id=<?= urlencode($codigoObra) ?>" class="btn btn-success mb-3">Agregar personaje</a>

<?php if (empty($personajesObra)): ?>
    <div class="alert alert-info">Esta obra aún no tiene personajes registrados.</div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($personajesObra as $p): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= $p->foto_url ?>" class="img-fluid rounded mx-auto d-block" style="max-height: 120px; object-fit: cover;" alt="<?= $p->nombre ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($p->nombre . ' ' . $p->apellido) ?></h5>
                        <p class="card-text">
                            <strong>Cédula:</strong> <?= htmlspecialchars($p->cedula) ?><br>
                            <strong>Fecha de nacimiento:</strong> <?= htmlspecialchars($p->fecha_nacimiento) ?><br>
                            <strong>Sexo:</strong> <?= htmlspecialchars($p->sexo) ?><br>
                            <strong>Habilidades:</strong> <?= htmlspecialchars(implode(', ', $p->habilidades)) ?><br>
                            <strong>Comida favorita:</strong> <?= htmlspecialchars($p->comida_favorita) ?>
                        </p>
                        <form method="post" onsubmit="return confirm('¿Está seguro de eliminar este personaje?');">
                            <input type="hidden" name="eliminar_cedula" value="<?= htmlspecialchars($p->cedula) ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
