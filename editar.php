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
if (isset($_SESSION['productos'])) {
    foreach ($_SESSION['productos'] as $i => $p) {
        if ($p['id'] == $id) {
            $producto = $p;
            $indice = $i;
            break;
        }
    }
}

/* ===== SI NO EXISTE ===== */
if ($producto === null) {
    $_SESSION['error'] = "Producto no encontrado";
    header("Location: index.php");
    exit;
}

/* ===== GUARDAR CAMBIOS (SERVIDOR) ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = trim($_POST['categoria']);

    if (
        $nombre == "" || $descripcion == "" || $categoria == "" ||
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Editar Producto</h1>

        <div id="js-error-box" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 <?= !isset($error) ? 'hidden' : '' ?>" role="alert">
            <p class="font-bold">¡Atención!</p>
            <p id="js-error-msg"><?= $error ?? '' ?></p>
        </div>

        <form method="POST" id="form-editar" class="bg-white p-6 rounded shadow-md space-y-4">
            
            <div>
                <label class="block font-semibold">Nombre</label>
                <input type="text" name="nombre" id="nombre"
                    value="<?= htmlspecialchars($producto['nombre']) ?>"
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <p id="error-nombre" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <div>
                <label class="block font-semibold">Descripción</label>
                <textarea name="descripcion" id="descripcion"
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                    required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                <p id="error-descripcion" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <div>
                <label class="block font-semibold">Precio</label>
                <input type="number" step="0.01" name="precio" id="precio"
                    value="<?= $producto['precio'] ?>"
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <p id="error-precio" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <div>
                <label class="block font-semibold">Stock</label>
                <input type="number" name="stock" id="stock"
                    value="<?= $producto['stock'] ?>"
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <p id="error-stock" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <div>
                <label class="block font-semibold">Categoría</label>
                <input type="text" name="categoria" id="categoria"
                    value="<?= htmlspecialchars($producto['categoria']) ?>"
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <p id="error-categoria" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition shadow">
                    Guardar cambios
                </button>
                <a href="index.php" class="flex items-center text-gray-700 underline">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
    document.getElementById('form-editar').addEventListener('submit', function(e) {
        const precio = document.getElementById('precio');
        const stock = document.getElementById('stock');
        const errorBox = document.getElementById('js-error-box');
        const errorMsg = document.getElementById('js-error-msg');
        
        let errorEncontrado = false;
        let mensaje = "";

        // Validar Precio
        if (parseFloat(precio.value) <= 0 || precio.value === "") {
            mensaje = "❌ El precio debe ser un número positivo.";
            errorEncontrado = true;
            precio.focus();
        } 
        // Validar Stock
        else if (parseInt(stock.value) < 0 || stock.value === "") {
            mensaje = "❌ El stock no puede ser un valor negativo.";
            errorEncontrado = true;
            stock.focus();
        }

        if (errorEncontrado) {
            e.preventDefault(); // Detener envío
            errorMsg.textContent = mensaje; // Poner el texto específico
            errorBox.classList.remove('hidden'); // Mostrar el recuadro rojo
            // Scroll hacia arriba para ver el error
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
    </script>

</body>
</html>