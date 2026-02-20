<?php
session_start();

/* ===== VALIDAR QUE EXISTA ID ===== */
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$producto = null;
$indice = null;

/* ===== BUSCAR PRODUCTO EN SESSION ===== */
foreach ($_SESSION['productos'] as $i => $p) {
    if ($p['id'] == $id) {
        $producto = $p;
        $indice = $i;
        break;
    }
}

/* ===== SI NO EXISTE ===== */
if ($producto === null) {
    $_SESSION['error'] = "Producto no encontrado";
    header("Location: index.php");
    exit;
}

/* ===== GUARDAR CAMBIOS ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = trim($_POST['categoria']);

    if (
        $nombre == "" ||
        $descripcion == "" ||
        $categoria == "" ||
        !is_numeric($precio) || $precio <= 0 ||
        !ctype_digit($stock) || $stock < 0
    ) {
        $error = "Datos inválidos, revisa los campos.";
    } else {

        $_SESSION['productos'][$indice] = [
            'id' => $id,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'stock' => $stock,
            'categoria' => $categoria
        ];

        $_SESSION['success'] = "Producto actualizado correctamente";
        header("Location: index.php");
        exit;
    }
}
?><!DOCTYPE html><html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>
<script src="https://cdn.tailwindcss.com"></script>
</head><body class="bg-gray-100 p-6"><h1 class="text-2xl font-bold mb-4">Editar Producto</h1><?php if (isset($error)): ?><div class="bg-red-100 text-red-700 p-3 rounded mb-4">
    <?= $error ?>
</div>
<?php endif; ?><form method="POST" class="bg-white p-6 rounded shadow-md space-y-4"><div>
<label class="block font-semibold">Nombre</label>
<input type="text" name="nombre"
value="<?= htmlspecialchars($producto['nombre']) ?>"
class="w-full border rounded p-2" required>
</div><div>
<label class="block font-semibold">Descripción</label>
<textarea name="descripcion"
class="w-full border rounded p-2" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
</div><div>
<label class="block font-semibold">Precio</label>
<input type="number" step="0.01" name="precio"
value="<?= $producto['precio'] ?>"
class="w-full border rounded p-2" required>
</div><div>
<label class="block font-semibold">Stock</label>
<input type="number" name="stock"
value="<?= $producto['stock'] ?>"
class="w-full border rounded p-2" required>
</div><div>
<label class="block font-semibold">Categoría</label>
<input type="text" name="categoria"
value="<?= htmlspecialchars($producto['categoria']) ?>"
class="w-full border rounded p-2" required>
</div><div class="flex gap-4">
<button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
Guardar cambios
</button><a href="index.php" class="text-gray-700 underline">Cancelar</a>

</div></form></body>
</html>