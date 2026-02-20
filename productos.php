<?php
session_start(); 
// Inicializar la matriz de productos en sesión si no existe
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [
        [
            'id' => 1,
            'nombre' => 'Laptop',
            'descripcion' => 'Laptop de demostración',
            'precio' => 1200.50,
            'stock' => 5,
            'categoria' => 'Electrónica'
        ]
    ];
}

// Validaciones y agregar producto
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = trim($_POST['categoria']);

    // Validaciones
    if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
    if (empty($descripcion)) $errores[] = "La descripción es obligatoria.";
    if (!is_numeric($precio) || $precio <= 0) $errores[] = "El precio debe ser un número positivo.";
    if (!ctype_digit($stock) || $stock < 0) $errores[] = "El stock debe ser un número entero no negativo.";
    if (empty($categoria)) $errores[] = "La categoría es obligatoria.";

    // Si no hay errores, agregar producto
    if (empty($errores)) {
        $nuevoId = count($_SESSION['productos']) + 1;
        $_SESSION['productos'][] = [
            'id' => $nuevoId,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'stock' => $stock,
            'categoria' => $categoria
        ];

        // Redirigir para limpiar el formulario (POST-REDIRECT-GET)
        $_SESSION['success'] = true;
        header('Location: index.php');
        exit;
    }
}

// Exportar variables para la vista
$productos = $_SESSION['productos'];
