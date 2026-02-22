// Validaciones en tiempo real para el formulario de agregar producto
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productoForm');
    if (form) {
        const nombre = document.getElementById('nombre');
        const descripcion = document.getElementById('descripcion');
        const precio = document.getElementById('precio');
        const stock = document.getElementById('stock');
        const categoria = document.getElementById('categoria');

        // Validar nombre
        nombre.addEventListener('input', function() {
            const errorNombre = document.getElementById('error-nombre');
            if (this.value.trim().length < 3) {
                errorNombre.textContent = 'El nombre debe tener al menos 3 caracteres';
                errorNombre.classList.remove('hidden');
            } else {
                errorNombre.classList.add('hidden');
            }
        });

        // Validar descripción
        descripcion.addEventListener('input', function() {
            const errorDesc = document.getElementById('error-descripcion');
            if (this.value.trim().length < 10) {
                errorDesc.textContent = 'La descripción debe tener al menos 10 caracteres';
                errorDesc.classList.remove('hidden');
            } else {
                errorDesc.classList.add('hidden');
            }
        });

        // Validar precio
        precio.addEventListener('input', function() {
            const errorPrecio = document.getElementById('error-precio');
            const valor = parseFloat(this.value);
            if (isNaN(valor) || valor <= 0) {
                errorPrecio.textContent = 'El precio debe ser un número positivo';
                errorPrecio.classList.remove('hidden');
            } else {
                errorPrecio.classList.add('hidden');
            }
        });

        // Validar stock
        stock.addEventListener('input', function() {
            const errorStock = document.getElementById('error-stock');
            const valor = parseInt(this.value);
            if (isNaN(valor) || valor < 0) {
                errorStock.textContent = 'El stock debe ser un número no negativo';
                errorStock.classList.remove('hidden');
            } else {
                errorStock.classList.add('hidden');
            }
        });

        // Validar categoría
        categoria.addEventListener('change', function() {
            const errorCategoria = document.getElementById('error-categoria');
            if (this.value === '') {
                errorCategoria.textContent = 'Seleccione una categoría';
                errorCategoria.classList.remove('hidden');
            } else {
                errorCategoria.classList.add('hidden');
            }
        });

        // Validar formulario antes de enviar
        form.addEventListener('submit', function(e) {
            let valido = true;
            
            if (nombre.value.trim().length < 3) {
                document.getElementById('error-nombre').textContent = 'El nombre debe tener al menos 3 caracteres';
                document.getElementById('error-nombre').classList.remove('hidden');
                valido = false;
            }
            
            if (descripcion.value.trim().length < 10) {
                document.getElementById('error-descripcion').textContent = 'La descripción debe tener al menos 10 caracteres';
                document.getElementById('error-descripcion').classList.remove('hidden');
                valido = false;
            }
            
            const precioVal = parseFloat(precio.value);
            if (isNaN(precioVal) || precioVal <= 0) {
                document.getElementById('error-precio').textContent = 'El precio debe ser un número positivo';
                document.getElementById('error-precio').classList.remove('hidden');
                valido = false;
            }
            
            const stockVal = parseInt(stock.value);
            if (isNaN(stockVal) || stockVal < 0) {
                document.getElementById('error-stock').textContent = 'El stock debe ser un número no negativo';
                document.getElementById('error-stock').classList.remove('hidden');
                valido = false;
            }
            
            if (categoria.value === '') {
                document.getElementById('error-categoria').textContent = 'Seleccione una categoría';
                document.getElementById('error-categoria').classList.remove('hidden');
                valido = false;
            }
            
            if (!valido) {
                e.preventDefault();
            }
        });
    }
});

// Validaciones adicionales para el modal de venta
document.addEventListener('DOMContentLoaded', function() {
    const ventaCantidad = document.getElementById('ventaCantidad');
    
    if (ventaCantidad) {
        ventaCantidad.addEventListener('blur', function() {
            const valor = parseInt(this.value);
            const stock = parseInt(document.getElementById('ventaStockDisponible').textContent);
            
            if (this.value === '' || isNaN(valor)) {
                this.value = '';
            } else if (valor < 1) {
                this.value = 1;
            } else if (valor > stock) {
                this.value = stock;
                alert(`La cantidad máxima disponible es ${stock}`);
            }
        });
    }
});
