document.addEventListener("DOMContentLoaded", () => {
    // Nombre
    const nombre = document.getElementById("nombre");
    nombre.addEventListener("input", () => {
        const error = document.getElementById("error-nombre");
        if (nombre.value.trim() === "") {
            error.textContent = "El nombre es obligatorio.";
            error.classList.remove("hidden");
        } else {
            error.classList.add("hidden");
        }
    });

    // Descripción
    const descripcion = document.getElementById("descripcion");
    descripcion.addEventListener("input", () => {
        const error = document.getElementById("error-descripcion");
        if (descripcion.value.trim() === "") {
            error.textContent = "La descripción es obligatoria.";
            error.classList.remove("hidden");
        } else {
            error.classList.add("hidden");
        }
    });

    // Precio
    const precio = document.getElementById("precio");
    precio.addEventListener("input", () => {
        const error = document.getElementById("error-precio");
        const valor = parseFloat(precio.value);
        if (isNaN(valor) || valor <= 0) {
            error.textContent = "El precio debe ser un número positivo.";
            error.classList.remove("hidden");
        } else {
            error.classList.add("hidden");
        }
    });

    // Stock
    const stock = document.getElementById("stock");
    stock.addEventListener("input", () => {
        const error = document.getElementById("error-stock");
        const valor = stock.value;
        if (!/^\d+$/.test(valor) || parseInt(valor) < 0) {
            error.textContent = "El stock debe ser un número entero no negativo.";
            error.classList.remove("hidden");
        } else {
            error.classList.add("hidden");
        }
    });

    // Categoría
    const categoria = document.getElementById("categoria");
    categoria.addEventListener("change", () => {
        const error = document.getElementById("error-categoria");
        if (categoria.value === "") {
            error.textContent = "Debe seleccionar una categoría.";
            error.classList.remove("hidden");
        } else {
            error.classList.add("hidden");
        }
    });
});
