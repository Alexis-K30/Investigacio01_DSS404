<?php
/**
 * Controles visuales de paginación
 * Requiere que exista la variable $paginacion
 */

if (!isset($paginacion)) {
    die("Error: Variable \$paginacion no definida");
}

if ($paginacion->getTotalPaginas() <= 1) {
    return; // No mostrar controles si solo hay 1 página
}
?>

<!-- Controles de Paginación -->
<div class="flex items-center justify-center gap-2 mt-6">

    <!-- Primera página -->
    <?php if ($paginacion->tienePaginaAnterior()): ?>
        <a href="?page=<?= $paginacion->getPrimeraPagina() ?>"
           class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-white hover:bg-gray-100 transition"
           title="Primera página">
            ⏮
        </a>
    <?php else: ?>
        <div class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-gray-100 opacity-50">
            ⏮
        </div>
    <?php endif; ?>

    <!-- -5 páginas -->
    <?php if ($paginacion->getPaginaAnterior5() !== null): ?>
        <a href="?page=<?= $paginacion->getPaginaAnterior5() ?>"
           class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-white hover:bg-gray-100 transition"
           title="Retroceder 5 páginas">
            ⏪
        </a>
    <?php else: ?>
        <div class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-gray-100 opacity-50">
            ⏪
        </div>
    <?php endif; ?>

    <!-- Página anterior -->
    <?php if ($paginacion->tienePaginaAnterior()): ?>
        <a href="?page=<?= $paginacion->getPaginaAnterior() ?>"
           class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-white hover:bg-gray-100 transition"
           title="Página anterior">
            ◀
        </a>
    <?php else: ?>
        <div class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-gray-100 opacity-50">
            ◀
        </div>
    <?php endif; ?>

    <!-- Números -->
    <div class="flex gap-1">
        <?php foreach ($paginacion->getRangoPaginas(2) as $num): ?>
            <?php if ($num == $paginacion->getPaginaActual()): ?>
                <span class="flex items-center justify-center w-10 h-10 rounded bg-blue-500 text-white font-bold">
                    <?= $num ?>
                </span>
            <?php else: ?>
                <a href="?page=<?= $num ?>"
                   class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-white hover:bg-gray-100 transition">
                    <?= $num ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Página siguiente -->
    <?php if ($paginacion->tienePaginaSiguiente()): ?>
        <a href="?page=<?= $paginacion->getPaginaSiguiente() ?>"
           class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-white hover:bg-gray-100 transition"
           title="Página siguiente">
            ▶
        </a>
    <?php else: ?>
        <div class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-gray-100 opacity-50">
            ▶
        </div>
    <?php endif; ?>

    <!-- +5 páginas -->
    <?php if ($paginacion->getPaginaSiguiente5() !== null): ?>
        <a href="?page=<?= $paginacion->getPaginaSiguiente5() ?>"
           class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-white hover:bg-gray-100 transition"
           title="Avanzar 5 páginas">
            ⏩
        </a>
    <?php else: ?>
        <div class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-gray-100 opacity-50">
            ⏩
        </div>
    <?php endif; ?>

    <!-- Última página -->
    <?php if ($paginacion->tienePaginaSiguiente()): ?>
        <a href="?page=<?= $paginacion->getUltimaPagina() ?>"
           class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-white hover:bg-gray-100 transition"
           title="Última página">
            ⏭
        </a>
    <?php else: ?>
        <div class="flex items-center justify-center w-10 h-10 rounded border border-gray-300 bg-gray-100 opacity-50">
            ⏭
        </div>
    <?php endif; ?>

</div>