document.getElementById('form-editar').addEventListener('submit', function (e) {
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