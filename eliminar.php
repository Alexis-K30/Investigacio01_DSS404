<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Filtrar la lista de productos para excluir el que tiene el ID proporcionado
    if (isset($_SESSION['productos'])) {
        $_SESSION['productos'] = array_filter($_SESSION['productos'], function ($producto) use ($id) {
            return $producto['id'] != $id;
        });

        // Re-indexar el array para evitar huecos en los índices si fuera necesario, 
        // aunque aquí estamos usando IDs internos en los datos.
        $_SESSION['productos'] = array_values($_SESSION['productos']);

        $_SESSION['success'] = "Producto eliminado correctamente.";
    }
}

header('Location: index.php');
exit;
