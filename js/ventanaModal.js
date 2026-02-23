// Variables para los modales
const deleteModal = document.getElementById('deleteModal');
const deleteOverlay = document.getElementById('modalOverlay');
const deletePanel = document.getElementById('modalPanel');

const ventaModal = document.getElementById('ventaModal');
const ventaOverlay = document.getElementById('ventaOverlay');
const ventaPanel = document.getElementById('ventaPanel');

const confirmarVentaModal = document.getElementById('confirmarVentaModal');
const confirmarVentaOverlay = document.getElementById('confirmarVentaOverlay');
const confirmarVentaPanel = document.getElementById('confirmarVentaPanel');

// Variables para almacenar datos de la venta
let datosVentaActual = null;
let formVentaActual = null;

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

// ===== FUNCIONES PARA MODAL DE CONFIRMACIÓN DE VENTA =====
function abrirConfirmarVentaModal() {
    confirmarVentaModal.classList.remove('hidden');
    setTimeout(() => {
        confirmarVentaOverlay.classList.remove('opacity-0');
        confirmarVentaPanel.classList.remove('scale-95', 'opacity-0');
        confirmarVentaPanel.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function cerrarConfirmarVentaModal() {
    confirmarVentaOverlay.classList.add('opacity-0');
    confirmarVentaPanel.classList.remove('scale-100', 'opacity-100');
    confirmarVentaPanel.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        confirmarVentaModal.classList.add('hidden');
    }, 300);
}

// ===== PROCESAR VENTA =====
function procesarVenta() {
    if (formVentaActual && datosVentaActual) {
        // Cerrar modal de confirmación
        cerrarConfirmarVentaModal();
        
        // Pequeña pausa para mejor experiencia visual
        setTimeout(() => {
            // Enviar el formulario
            formVentaActual.submit();
        }, 300);
    }
}

// ===== VALIDAR Y PREPARAR VENTA =====
function prepararVenta() {
    const cantidad = parseInt(document.getElementById('ventaCantidad').value);
    const stock = parseInt(document.getElementById('ventaStockDisponible').textContent);
    const productoId = document.getElementById('ventaProductoId').value;
    const productoNombre = document.getElementById('ventaProductoNombre').textContent;
    const precioUnitario = parseFloat(document.getElementById('ventaPrecioUnitario').textContent);
    const total = cantidad * precioUnitario;
    
    // Validar cantidad
    if (!cantidad || cantidad <= 0) {
        alert('Por favor ingresa una cantidad válida');
        return false;
    }
    
    if (cantidad > stock) {
        alert(`No hay suficiente stock. Disponible: ${stock}`);
        return false;
    }
    
    // Guardar datos para la confirmación
    datosVentaActual = {
        id: productoId,
        nombre: productoNombre,
        cantidad: cantidad,
        precioUnitario: precioUnitario,
        total: total,
        stock: stock
    };
    
    // Obtener el formulario
    formVentaActual = document.querySelector('#ventaModal form');
    
    // Llenar modal de confirmación
    document.getElementById('confirmarProductoNombre').textContent = productoNombre;
    document.getElementById('confirmarCantidad').textContent = cantidad;
    document.getElementById('confirmarPrecioUnitario').textContent = precioUnitario.toFixed(2);
    document.getElementById('confirmarTotal').textContent = total.toFixed(2);
    
    // Cerrar modal de venta
    cerrarModalVenta();
    
    // Pequeña pausa para mejor experiencia visual
    setTimeout(() => {
        // Abrir modal de confirmación
        abrirConfirmarVentaModal();
    }, 300);
    
    return false; // Prevenir envío del formulario
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
                // Disparar evento input para actualizar total
                this.dispatchEvent(new Event('input'));
            }
        });
    }
});

// ===== CERRAR MODALES CON TECLA ESCAPE =====
document.addEventListener('keydown', function (event) {
    if (event.key === "Escape") {
        if (confirmarVentaModal && !confirmarVentaModal.classList.contains('hidden')) {
            cerrarConfirmarVentaModal();
        } else if (ventaModal && !ventaModal.classList.contains('hidden')) {
            cerrarModalVenta();
        } else if (deleteModal && !deleteModal.classList.contains('hidden')) {
            cerrarModalEliminar();
        }
    }
});

// ===== CERRAR MODALES AL HACER CLICK FUERA (CORREGIDO) =====
document.addEventListener('click', function(event) {
    // Para modal de confirmación de venta
    if (confirmarVentaModal && !confirmarVentaModal.classList.contains('hidden')) {
        // Si el click fue en el overlay (fondo gris) y no en el panel
        if (event.target === confirmarVentaOverlay || event.target === confirmarVentaModal) {
            cerrarConfirmarVentaModal();
        }
    }
    
    // Para modal de venta
    if (ventaModal && !ventaModal.classList.contains('hidden')) {
        // Si el click fue en el overlay (fondo gris) y no en el panel
        if (event.target === ventaOverlay || event.target === ventaModal) {
            cerrarModalVenta();
        }
    }
    
    // Para modal de eliminación
    if (deleteModal && !deleteModal.classList.contains('hidden')) {
        // Si el click fue en el overlay (fondo gris) y no en el panel
        if (event.target === deleteOverlay || event.target === deleteModal) {
            cerrarModalEliminar();
        }
    }
});

// Prevenir que los clics dentro de los paneles se propaguen al overlay
document.addEventListener('DOMContentLoaded', function() {
    // Para panel de eliminación
    if (deletePanel) {
        deletePanel.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }
    
    // Para panel de venta
    if (ventaPanel) {
        ventaPanel.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }
    
    // Para panel de confirmación de venta
    if (confirmarVentaPanel) {
        confirmarVentaPanel.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }
});
