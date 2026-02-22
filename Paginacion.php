<?php

class Paginacion {

    private $limit;
    private $paginaActual;
    private $totalRegistros;

    public function __construct($limit, $paginaActual, $totalRegistros) {
        $this->limit = $limit;
        $this->paginaActual = max(1, $paginaActual);
        $this->totalRegistros = $totalRegistros;
    }

    public function getOffset() {
        return ($this->paginaActual - 1) * $this->limit;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getPaginaActual() {
        return $this->paginaActual;
    }

    public function getTotalPaginas() {
        return ceil($this->totalRegistros / $this->limit);
    }

    public function tienePaginaAnterior() {
        return $this->paginaActual > 1;
    }

    public function tienePaginaSiguiente() {
        return $this->paginaActual < $this->getTotalPaginas();
    }

    public function getPaginaAnterior() {
        return $this->paginaActual - 1;
    }

    public function getPaginaSiguiente() {
        return $this->paginaActual + 1;
    }

    public function getPrimeraPagina() {
        return 1;
    }

    public function getUltimaPagina() {
        return $this->getTotalPaginas();
    }

    public function getPaginaAnterior5() {
        return ($this->paginaActual - 5 > 0) ? $this->paginaActual - 5 : null;
    }

    public function getPaginaSiguiente5() {
        return ($this->paginaActual + 5 <= $this->getTotalPaginas()) ? $this->paginaActual + 5 : null;
    }

    public function getRangoPaginas($rango = 2) {
        $inicio = max(1, $this->paginaActual - $rango);
        $fin = min($this->getTotalPaginas(), $this->paginaActual + $rango);
        return range($inicio, $fin);
    }
}