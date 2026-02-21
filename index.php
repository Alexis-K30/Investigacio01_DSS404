<?php require 'productos.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilo manual por si Tailwind tarda en cargar */
        .hidden { display: none; }
    </style>
</head>

<body class="bg-gray-100 p-6">

    <h1 class="text-2xl font-bold mb-4">Agregar Producto</h1>

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

    <form method="POST" id="form-agregar" class="bg-white p-6 rounded shadow-md space-y-4">
        <div>
            <label class="block font-semibold">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="w-full border rounded p-2" required>
            <p id="error-nombre" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        <div>
            <label class="block font-semibold">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="w-full border rounded p-2" required></textarea>
            <p id="error-descripcion" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        <div>
            <label class="block font-semibold">Precio</label>
            <input type="number" step="0.01" name="precio" id="precio" class="w-full border rounded p-2" required>
            <p id="error-precio" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        <div>
            <label class="block font-semibold">Stock</label>
            <input type="number" name="stock" id="stock" class="w-full border rounded p-2" required>
            <p id="error-stock" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        <div>
            <label class="block font-semibold">Categoría</label>
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
            <p id="error-categoria" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Agregar Producto
        </button>
    </form>

    <h2 class="text-xl font-bold mt-8 mb-4">Lista de Productos</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border text-left">ID</th>
                    <th class="py-2 px-4 border text-left">Nombre</th>
                    <th class="py-2 px-4 border text-left">Descripción</th>
                    <th class="py-2 px-4 border text-left">Precio</th>
                    <th class="py-2 px-4 border text-left">Stock</th>
                    <th class="py-2 px-4 border text-left">Categoría</th>
                    <th class="py-2 px-4 border text-center">Acciones</th>
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
                        
                        <a href="editar.php?id=<?= $producto['id'] ?>"
                           class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 w-full inline-block text-center">
                           Editar
                        </a>

                        <a href="eliminar.php?id=<?= $producto['id'] ?>"
                           onclick="return confirm('¿Seguro que deseas eliminar este producto?')"
                           class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 w-full inline-block text-center">
                           Eliminar
                        </a>

                        <form method="POST" action="vender.php" class="flex flex-col gap-1 mt-1 form-vender">
                            <div class="flex gap-1">
                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                <input type="number" name="cantidad" class="border w-20 p-1 rounded input-vender" placeholder="Cant." required>
                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                                    Vender
                                </button>
                            </div>
                            <p class="text-red-500 text-xs error-vender hidden">Mínimo 1 unidad</p>
                        </form>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // 1. Tu código de validación para el formulario de Agregar
        document.addEventListener("DOMContentLoaded", () => {
            const inputs = {
                nombre: document.getElementById("nombre"),
                descripcion: document.getElementById("descripcion"),
                precio: document.getElementById("precio"),
                stock: document.getElementById("stock"),
                categoria: document.getElementById("categoria")
            };

            // Validación dinámica mientras se escribe
            inputs.nombre.addEventListener("input", () => validarCampo(inputs.nombre, "error-nombre", "El nombre es obligatorio."));
            inputs.descripcion.addEventListener("input", () => validarCampo(inputs.descripcion, "error-descripcion", "La descripción es obligatoria."));
            
            inputs.precio.addEventListener("input", () => {
                const error = document.getElementById("error-precio");
                if (parseFloat(inputs.precio.value) <= 0 || inputs.precio.value === "") {
                    error.textContent = "El precio debe ser un número positivo.";
                    error.classList.remove("hidden");
                } else {
                    error.classList.add("hidden");
                }
            });

            inputs.stock.addEventListener("input", () => {
                const error = document.getElementById("error-stock");
                if (parseInt(inputs.stock.value) < 0 || inputs.stock.value === "") {
                    error.textContent = "El stock no puede ser negativo.";
                    error.classList.remove("hidden");
                } else {
                    error.classList.add("hidden");
                }
            });

            inputs.categoria.addEventListener("change", () => {
                const error = document.getElementById("error-categoria");
                if (inputs.categoria.value === "") {
                    error.textContent = "Seleccione una categoría.";
                    error.classList.remove("hidden");
                } else {
                    error.classList.add("hidden");
                }
            });

            function validarCampo(input, idError, mensaje) {
                const error = document.getElementById(idError);
                if (input.value.trim() === "") {
                    error.textContent = mensaje;
                    error.classList.remove("hidden");
                } else {
                    error.classList.add("hidden");
                }
            }

            // 2. Validación extra para los formularios de VENTA en la tabla
            document.querySelectorAll('.form-vender').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const input = this.querySelector('.input-vender');
                    const errorMsg = this.querySelector('.error-vender');
                    if (parseInt(input.value) <= 0 || input.value === "") {
                        e.preventDefault();
                        errorMsg.classList.remove('hidden');
                        alert("⚠️ Cantidad inválida para la venta.");
                    } else {
                        errorMsg.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>