<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;
$cantidad = $_POST['cantidad'] ?? null;

// Validaciones básicas
if (!ctype_digit($cantidad) || $cantidad <= 0) {
    $_SESSION['error'] = "Cantidad inválida.";
    header('Location: index.php');
    exit;
}

foreach ($_SESSION['productos'] as &$producto) {

    if ($producto['id'] == $id) {

        // Validar stock suficiente
        if ($producto['stock'] < $cantidad) {
            $_SESSION['error'] = "No hay suficiente stock para vender.";
            header('Location: index.php');
            exit;
        }

        // Descontar stock
        $producto['stock'] -= $cantidad;

        $_SESSION['success'] = "Venta realizada correctamente.";
        header('Location: index.php');
        exit;
    }
}

$_SESSION['error'] = "Producto no encontrado.";
header('Location: index.php');