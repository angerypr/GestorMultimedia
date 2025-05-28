<?php
include_once 'libreria/plantilla.php';
plantilla::aplicar();

$archivoObras = 'datos/obras.json';
$archivoPersonajes = 'datos/personajes.json';

$obras = file_exists($archivoObras) ? json_decode(file_get_contents($archivoObras), true) : [];
$personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes), true) : [];

$codigoObraSeleccionada = $_GET['id'] ?? null;  

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo = [
        'cedula' => $_POST['cedula'],
        'foto_url' => $_POST['foto_url'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
        'sexo' => $_POST['sexo'],
        'habilidades' => array_map('trim', explode(',', $_POST['habilidades'])),
        'comida_favorita' => $_POST['comida_favorita'],
        'codigo_obra' => $_POST['codigo_obra']
    ];

    foreach ($personajes as $p) {
        if ($p['cedula'] === $nuevo['cedula']) {
            $mensaje = "<div class='alert alert-danger'>Ya existe un personaje con esa cédula.</div>";
            break;
        }
    }

    if (!$mensaje) {
    $personajes[] = $nuevo;
    file_put_contents($archivoPersonajes, json_encode($personajes, JSON_PRETTY_PRINT));
    
    header("Location: personajes.php?id=" . $nuevo['codigo_obra']);
    exit;
}
}
?>

<h2>Agregar Personaje</h2>
<?= $mensaje ?>

<form method="post">
    <div class="mb-3">
        <label>Cédula</label>
        <input type="text" name="cedula" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>URL de la Foto</label>
        <input type="url" name="foto_url" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Apellido</label>
        <input type="text" name="apellido" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Fecha de nacimiento</label>
        <input type="date" name="fecha_nacimiento" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Sexo</label>
        <select name="sexo" class="form-control" required>
            <option value="">Seleccione</option>
            <option>Masculino</option>
            <option>Femenino</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Habilidades (separadas por comas)</label>
        <input type="text" name="habilidades" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Comida favorita</label>
        <input type="text" name="comida_favorita" class="form-control" required>
    </div>

    <?php if ($codigoObraSeleccionada): 
        $obraSeleccionada = null;
        foreach ($obras as $obra) {
            if ($obra['codigo'] === $codigoObraSeleccionada) {
                $obraSeleccionada = $obra;
                break;
            }
        }
        if ($obraSeleccionada): ?>
            <div class="mb-3">
                <label>Obra asociada</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($obraSeleccionada['nombre']) ?>" disabled>
                <input type="hidden" name="codigo_obra" value="<?= htmlspecialchars($codigoObraSeleccionada) ?>">
            </div>
        <?php else: ?>
            <div class="mb-3">
                <label>Obra asociada</label>
                <select name="codigo_obra" class="form-control" required>
                    <option value="">Seleccione una obra</option>
                    <?php foreach ($obras as $obra): ?>
                        <option value="<?= $obra['codigo'] ?>">
                            <?= htmlspecialchars($obra['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="mb-3">
            <label>Obra asociada</label>
            <select name="codigo_obra" class="form-control" required>
                <option value="">Seleccione una obra</option>
                <?php foreach ($obras as $obra): ?>
                    <option value="<?= $obra['codigo'] ?>">
                        <?= htmlspecialchars($obra['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary">Agregar</button>
    <a href="ver_obras.php" class="btn btn-secondary">Cancelar</a>
</form>
