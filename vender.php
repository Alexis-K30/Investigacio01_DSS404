<?php
// vender.php
session_start();

// Verificar que sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Obtener y validar datos
$id = $_POST['id'] ?? null;
$cantidad = $_POST['cantidad'] ?? null;

// Validaciones básicas
if (!$id || !$cantidad) {
    $_SESSION['error'] = "Datos incompletos para la venta.";
    header('Location: index.php');
    exit;
}

// Validar que la cantidad sea un número entero positivo
if (!ctype_digit($cantidad) || $cantidad <= 0) {
    $_SESSION['error'] = "La cantidad debe ser un número entero positivo.";
    header('Location: index.php');
    exit;
}

$cantidad = (int)$cantidad;
$producto_encontrado = false;

// Verificar que exista la sesión de productos
if (!isset($_SESSION['productos'])) {
    $_SESSION['error'] = "No hay productos en el inventario.";
    header('Location: index.php');
    exit;
}

// Buscar el producto y realizar la venta
foreach ($_SESSION['productos'] as &$producto) {
    if ($producto['id'] == $id) {
        $producto_encontrado = true;
        
        // Validar stock suficiente
        if ($producto['stock'] < $cantidad) {
            $_SESSION['error'] = "Stock insuficiente. Disponible: {$producto['stock']} unidades.";
            header('Location: index.php');
            exit;
        }
        
        // Calcular total antes de descontar
        $total_venta = $producto['precio'] * $cantidad;
        $nombre_producto = $producto['nombre'];
        
        // Descontar stock
        $producto['stock'] -= $cantidad;
        
        // Mensaje de éxito con detalles
        $_SESSION['success'] = sprintf(
            "¡Venta realizada con éxito! Producto: %s, Cantidad: %d, Total: $%.2f",
            $nombre_producto,
            $cantidad,
            $total_venta
        );
        
        header('Location: index.php');
        exit;
    }
}

// Si no se encontró el producto
if (!$producto_encontrado) {
    $_SESSION['error'] = "Producto no encontrado.";
    header('Location: index.php');
    exit;
}
?>
