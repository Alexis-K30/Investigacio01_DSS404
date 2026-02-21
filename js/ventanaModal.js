const modal = document.getElementById('deleteModal');
const overlay = document.getElementById('modalOverlay');
const panel = document.getElementById('modalPanel');

function abrirModal(id) {
    document.getElementById('confirmDeleteBtn').href = 'eliminar.php?id=' + id;

    modal.classList.remove('hidden');
    setTimeout(() => {
        overlay.classList.remove('opacity-0');
        panel.classList.remove('scale-95', 'opacity-0');
        panel.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function cerrarModal() {
    overlay.classList.add('opacity-0');
    panel.classList.remove('scale-100', 'opacity-100');
    panel.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

document.addEventListener('keydown', function (event) {
    if (event.key === "Escape" && !modal.classList.contains('hidden')) {
        cerrarModal();
    }
});