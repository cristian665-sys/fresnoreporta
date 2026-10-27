<?php
// app/helpers/helpers.php

function resolverRutaEvidencia($archivo)
{
    if (empty($archivo)) {
        return '';
    }
    if (preg_match('#^https?://#i', $archivo)) {
        return $archivo;
    }
    if (strpos($archivo, '/FresnoReporta/') === 0) {
        return $archivo;
    }
    $archivo = ltrim($archivo, '/');
    if (strpos($archivo, 'uploads/') === 0) {
        return '/FresnoReporta/public/' . $archivo;
    }
    return '/FresnoReporta/public/uploads/' . $archivo;
}

function categoriaIcon($nombre)
{
    $iconos = [
        'Acueducto' => 'fa-droplet',
        'Alcantarillado' => 'fa-water',
        'Alumbrado público' => 'fa-lightbulb',
        'Árboles caídos' => 'fa-tree',
        'Basuras' => 'fa-dumpster',
        'Deslizamientos' => 'fa-hill-rockslide',
        'Espacio público' => 'fa-landmark',
        'Huecos en la vía' => 'fa-road-circle-exclamation',
        'Inundaciones' => 'fa-house-flood-water',
        'Otro' => 'fa-circle-question',
        'Parques' => 'fa-seedling',
        'Puentes' => 'fa-route',
        'Semáforos' => 'fa-traffic-light',
        'Señalización vial' => 'fa-signs-post',
    ];
    return $iconos[$nombre] ?? 'fa-triangle-exclamation';
}

function estadoInfo($id_estado, $estados)
{
    foreach ($estados as $est) {
        if ((int)$est['id_estado'] === (int)$id_estado) {
            return ['nombre' => $est['nombre'], 'color' => $est['color'] ?? 'secondary'];
        }
    }
    return ['nombre' => 'Desconocido', 'color' => 'secondary'];
}
