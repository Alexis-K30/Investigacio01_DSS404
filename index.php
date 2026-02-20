<?php require 'productos.php'; // Importa la lógica ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

    <h1 class="text-2xl font-bold mb-4">Agregar Producto</h1>

    <!-- Mensaje de éxito -->
    <?php if (isset($_SESSION['success'])): ?> 
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4"> Producto agregado correctamente. </div> 
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Formulario -->
    <form method="POST" class="bg-white p-6 rounded shadow-md space-y-4">
        <div> 
            <label for="nombre" class="block font-semibold">Nombre</label> 
            <input type="text" name="nombre" id="nombre" class="w-full border rounded p-2" required>
            <p id="error-nombre" class="text-red-600 font-bold mt-1 hidden"></p>
        </div>
        <div> 
            <label for="descripcion" class="block font-semibold">Descripción</label> 
            <textarea name="descripcion" id="descripcion" class="w-full border rounded p-2" required></textarea>
            <p id="error-descripcion" class="text-red-600 font-bold mt-1 hidden"></p>
        </div>
        <div> 
            <label for="precio" class="block font-semibold">Precio</label> 
            <input type="number" step="0.01" name="precio" id="precio" class="w-full border rounded p-2" required>
            <p id="error-precio" class="text-red-600 font-bold mt-1 hidden"></p>
        </div>
        <div> 
            <label for="stock" class="block font-semibold">Stock</label> 
            <input type="number" name="stock" id="stock" class="w-full border rounded p-2" required>
            <p id="error-stock" class="text-red-600 font-bold mt-1 hidden"></p>
        </div>
        <div> 
            <label for="categoria" class="block font-semibold">Categoría</label> 
            <select name="categoria" id="categoria" class="w-full border rounded p-2" required>
                <option value="">Seleccione una categoría</option>
                <option value="Computadoras">Computadoras</option>
                <option value="Smartphones">Smartphones</option>
                <option value="Tablets">Tablets</option>
                <option value="Accesorios">Accesorios</option>
                <option value="Software">Software</option>
                <option value="Hardware">Hardware</option>
                <option value="Redes">Redes</option>
                <option value="IoT">IoT</option>
                <option value="Inteligencia Artificial">Inteligencia Artificial</option>
                <option value="Gaming">Gaming</option>
            </select>
            <p id="error-categoria" class="text-red-600 font-bold mt-1 hidden"></p>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Agregar
        </button>
    </form>

    <!-- Tabla de productos -->
    <h2 class="text-xl font-bold mt-8 mb-4">Lista de Productos</h2>
    <table class="min-w-full bg-white border rounded shadow-md">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2 px-4 border">ID</th>
                <th class="py-2 px-4 border">Nombre</th>
                <th class="py-2 px-4 border">Descripción</th>
                <th class="py-2 px-4 border">Precio</th>
                <th class="py-2 px-4 border">Stock</th>
                <th class="py-2 px-4 border">Categoría</th>
                <th class="py-2 px-4 border">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td class="py-2 px-4 border"><?= $producto['id'] ?></td>
                    <td class="py-2 px-4 border"><?= htmlspecialchars($producto['nombre']) ?></td>
                    <td class="py-2 px-4 border"><?= htmlspecialchars($producto['descripcion']) ?></td>
                    <td class="py-2 px-4 border">$<?= number_format($producto['precio'], 2) ?></td>
                    <td class="py-2 px-4 border"><?= $producto['stock'] ?></td>
                    <td class="py-2 px-4 border"><?= htmlspecialchars($producto['categoria']) ?></td>
                    <td class="py-2 px-4 border">
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Editar</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script src="js/validaciones.js"></script>

</body>

</html>