<?php require 'productos.php'; ?>

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Productos</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

<h1 class="text-2xl font-bold mb-4">Agregar Producto</h1>

<!-- Mensajes -->

<?php if (isset($_SESSION['success'])): ?> 


<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    <?= is_string($_SESSION['success']) ? $_SESSION['success'] : "Operación realizada correctamente." ?>
</div> 
<?php unset($_SESSION['success']); ?>


<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>


<div class="bg-red-100 text-red-700 p-3 rounded mb-4">
    <?= $_SESSION['error']; ?>
</div>
<?php unset($_SESSION['error']); ?>


<?php endif; ?>

<!-- Formulario agregar -->

<form method="POST" class="bg-white p-6 rounded shadow-md space-y-4">

<div>
<label class="block font-semibold">Nombre</label>
<input type="text" name="nombre" class="w-full border rounded p-2" required>
</div>

<div>
<label class="block font-semibold">Descripción</label>
<textarea name="descripcion" class="w-full border rounded p-2" required></textarea>
</div>

<div>
<label class="block font-semibold">Precio</label>
<input type="number" step="0.01" name="precio" class="w-full border rounded p-2" required>
</div>

<div>
<label class="block font-semibold">Stock</label>
<input type="number" name="stock" class="w-full border rounded p-2" required>
</div>

<div>
<label class="block font-semibold">Categoría</label>
<select name="categoria" class="w-full border rounded p-2" required>
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
</div>

<button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
Agregar
</button>

</form>

<!-- Tabla -->

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
<td class="py-2 px-4 border font-bold <?= $producto['stock'] == 0 ? 'text-red-600' : '' ?>">
    <?= $producto['stock'] ?>
</td>
<td class="py-2 px-4 border"><?= htmlspecialchars($producto['categoria']) ?></td>

<td class="py-2 px-4 border space-y-1">

<!-- EDITAR -->

<a href="editar.php?id=<?= $producto['id'] ?>"
class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 w-full inline-block text-center">
Editar </a>

<!-- ELIMINAR (aún no creado) -->

<a href="eliminar.php?id=<?= $producto['id'] ?>"
onclick="return confirm('¿Seguro que deseas eliminar este producto?')"
class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 w-full inline-block text-center">
Eliminar </a>

<!-- VENDER -->

<form method="POST" action="vender.php" class="flex gap-1 mt-1">
<input type="hidden" name="id" value="<?= $producto['id'] ?>">
<input type="number" name="cantidad" min="1" class="border w-20 p-1 rounded" placeholder="Cant." required>

<button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
Vender
</button>
</form>

</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</body>
</html>
