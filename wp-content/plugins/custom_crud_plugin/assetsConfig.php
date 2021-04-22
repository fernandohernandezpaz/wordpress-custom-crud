<?php

function renderCSS()
{
    $css = [
        'cdn' => [
            [
                'href' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css',
                'integrity' => 'sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6',
                'crossorigin' => 'anonymous',
            ]
        ],
        'localfiles' => [
            [
                'href' => WP_PLUGIN_URL.'/custom_crud_plugin/assets/css/admin_css.css'
            ]
        ]
    ];
    $llaves = array_keys($css);
    $link = '';
    foreach ($llaves as $llave) {
        foreach ($css[$llave] as $attr) {
            $link = '<link href="' . $attr['href'] . '" rel="stylesheet"';
            if ($llave === 'cdn') {
                $link .= ' integrity="' . $attr['integrity'] . '"';
                $link .= ' crossorigin="' . $attr['crossorigin'] . '"';
            }
            $link .= '>';
        }
        echo $link;
    }
    unset($link);
    unset($llaves);
}


function renderJS()
{
    $js = [
        'cdn' => [
            [
                'src' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js',
                'integrity' => 'sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf',
                'crossorigin' => 'anonymous',
            ]
        ],
        'localfiles' => [

        ]
    ];
    $llaves = array_keys($js);
    $script = '';
    foreach ($llaves as $llave) {
        foreach ($js[$llave] as $attr) {
            $script = '<script src="' . $attr['src'] . '" rel="stylesheet"';
            if ($llave === 'cdn') {
                $script .= ' integrity="' . $attr['integrity'] . '"';
                $script .= ' crossorigin="' . $attr['crossorigin'] . '"';
            }
            $script .= '></script>';
        }
        echo $script;
    }
    unset($script);
    unset($llaves);
}
