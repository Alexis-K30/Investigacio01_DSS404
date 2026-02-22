// Variables para el modal de eliminación
const deleteModal = document.getElementById('deleteModal');
const deleteOverlay = document.getElementById('modalOverlay');
const deletePanel = document.getElementById('modalPanel');

// Variables para el modal de venta
const ventaModal = document.getElementById('ventaModal');
const ventaOverlay = document.getElementById('ventaOverlay');
const ventaPanel = document.getElementById('ventaPanel');

// ===== FUNCIONES PARA MODAL DE ELIMINACIÓN =====
function abrirModalEliminar(id) {
    document.getElementById('confirmDeleteBtn').href = 'eliminar.php?id=' + id;

    deleteModal.classList.remove('hidden');
    setTimeout(() => {
        deleteOverlay.classList.remove('opacity-0');
        deletePanel.classList.remove('scale-95', 'opacity-0');
        deletePanel.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function cerrarModalEliminar() {
    deleteOverlay.classList.add('opacity-0');
    deletePanel.classList.remove('scale-100', 'opacity-100');
    deletePanel.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        deleteModal.classList.add('hidden');
    }, 300);
}

// ===== FUNCIONES PARA MODAL DE VENTA =====
function abrirModalVenta(id, nombre, stock, precio) {
    // Llenar datos del producto
    document.getElementById('ventaProductoId').value = id;
    document.getElementById('ventaProductoNombre').textContent = nombre;
    document.getElementById('ventaStockDisponible').textContent = stock;
    document.getElementById('ventaPrecioUnitario').textContent = precio.toFixed(2);
    
    // Resetear campos
    document.getElementById('ventaCantidad').value = '';
    document.getElementById('ventaTotal').textContent = '$0.00';
    document.getElementById('ventaError').classList.add('hidden');
    
    // Establecer máximo según stock
    document.getElementById('ventaCantidad').max = stock;
    
    // Mostrar modal
    ventaModal.classList.remove('hidden');
    setTimeout(() => {
        ventaOverlay.classList.remove('opacity-0');
        ventaPanel.classList.remove('scale-95', 'opacity-0');
        ventaPanel.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function cerrarModalVenta() {
    ventaOverlay.classList.add('opacity-0');
    ventaPanel.classList.remove('scale-100', 'opacity-100');
    ventaPanel.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        ventaModal.classList.add('hidden');
    }, 300);
}

// ===== CÁLCULO DE TOTAL EN VENTA =====
document.addEventListener('DOMContentLoaded', function() {
    const cantidadInput = document.getElementById('ventaCantidad');
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function() {
            const cantidad = parseInt(this.value) || 0;
            const stock = parseInt(document.getElementById('ventaStockDisponible').textContent);
            const precio = parseFloat(document.getElementById('ventaPrecioUnitario').textContent);
            const errorElement = document.getElementById('ventaError');
            
            // Validar cantidad
            if (cantidad > stock) {
                errorElement.textContent = `No puedes vender más de ${stock} unidades`;
                errorElement.classList.remove('hidden');
            } else if (cantidad <= 0) {
                errorElement.textContent = 'La cantidad debe ser mayor a 0';
                errorElement.classList.remove('hidden');
            } else {
                errorElement.classList.add('hidden');
            }
            
            // Calcular total
            if (cantidad > 0 && cantidad <= stock) {
                const total = cantidad * precio;
                document.getElementById('ventaTotal').textContent = '$' + total.toFixed(2);
            } else {
                document.getElementById('ventaTotal').textContent = '$0.00';
            }
        });

        // Validar solo números
        cantidadInput.addEventListener('keypress', function(e) {
            if (e.key < '0' || e.key > '9') {
                e.preventDefault();
            }
        });

        // Ajustar valor al perder foco
        cantidadInput.addEventListener('blur', function() {
            const valor = parseInt(this.value);
            const stock = parseInt(document.getElementById('ventaStockDisponible').textContent);
            
            if (this.value === '' || isNaN(valor)) {
                this.value = '';
            } else if (valor < 1) {
                this.value = 1;
            } else if (valor > stock) {
                this.value = stock;
            }
        });
    }
});

// ===== VALIDAR VENTA ANTES DE ENVIAR =====
function validarVenta() {
    const cantidad = parseInt(document.getElementById('ventaCantidad').value);
    const stock = parseInt(document.getElementById('ventaStockDisponible').textContent);
    
    if (!cantidad || cantidad <= 0) {
        alert('Por favor ingresa una cantidad válida');
        return false;
    }
    
    if (cantidad > stock) {
        alert(`No hay suficiente stock. Disponible: ${stock}`);
        return false;
    }
    
    return confirm('¿Confirmar la venta por ' + document.getElementById('ventaTotal').textContent + '?');
}

// ===== CERRAR MODALES CON TECLA ESCAPE =====
document.addEventListener('keydown', function (event) {
    if (event.key === "Escape") {
        if (ventaModal && !ventaModal.classList.contains('hidden')) {
            cerrarModalVenta();
        }
        if (deleteModal && !deleteModal.classList.contains('hidden')) {
            cerrarModalEliminar();
        }
    }
});
