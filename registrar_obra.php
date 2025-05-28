<?php
include('libreria/main.php');

$obra = new Obra();

$obras = [];
$rutaObras = 'datos/obras.json';

if (file_exists($rutaObras)) {
    $jsonData = file_get_contents($rutaObras);
    $obras = json_decode($jsonData, true); // true = arreglo asociativo
}

if (isset($_GET['id'])) {
    foreach ($obras as $item) {
        if ($item['codigo'] === $_GET['id']) {
            $obra = (object) $item;
            break;
        }
    }
}

if ($_POST) {
    $nuevaObra = [
        'codigo' => $_POST['codigo'],
        'foto_url' => $_POST['foto_url'],
        'tipo' => $_POST['tipo'],
        'nombre' => $_POST['nombre'],
        'descripcion' => $_POST['descripcion'],
        'pais' => $_POST['pais'],
        'autor' => $_POST['autor']
    ];

    $actualizada = false;
    foreach ($obras as $key => $item) {
        if ($item['codigo'] === $nuevaObra['codigo']) {
            $obras[$key] = $nuevaObra;
            $actualizada = true;
            break;
        }
    }

    if (!$actualizada) {
        $obras[] = $nuevaObra;
    }

    if (!is_dir('datos')) {
        mkdir('datos');
    }

    file_put_contents($rutaObras, json_encode($obras, JSON_PRETTY_PRINT));

    plantilla::aplicar();
    echo "<div class='alert alert-success'>Obra guardada correctamente</div>";
    echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
    exit();
}

plantilla::aplicar();
?>

<form method="post" action="registrar_obra.php">
    <div class="mb-3">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" class="form-control" id="codigo" name="codigo" value="<?= $obra->codigo ?? '' ?>" required>
    </div>

    <div class="mb-3">
        <label for="foto_url" class="form-label">Foto</label>
        <input type="text" class="form-control" id="foto_url" name="foto_url" value="<?= $obra->foto_url ?? '' ?>" required>
    </div>

    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="tipo" name="tipo">
            <option value="">Seleccione</option>
            <?php
            $selected = $obra->tipo ?? '';
            foreach (Datos::Tipos_de_Obra() as $key => $value) {
                $isSelected = ($key == $selected) ? 'selected' : '';
                echo "<option value='$key' $isSelected>$value</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $obra->nombre ?? '' ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= $obra->descripcion ?? '' ?></textarea>
    </div>

    <div class="mb-3">
        <label for="pais" class="form-label">País</label>
        <input type="text" class="form-control" id="pais" name="pais" value="<?= $obra->pais ?? '' ?>" required>
    </div>

    <div class="mb-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" class="form-control" id="autor" name="autor" value="<?= $obra->autor ?? '' ?>" required>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="ver_obras.php" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
