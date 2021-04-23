<?php

//menu items
add_action('admin_menu', 'agregarNuevasOpcionesMenu');
function agregarNuevasOpcionesMenu()
{
    $configMenu = [
        'menu' => [
            [
                'page_title' => 'Causas muerte',
                'menu_title' => 'Causas muerte',
                'menu_slug' => 'lista_estadisticas',
                'function' => 'list_causas_muerte',
            ]
        ],
        'sub_menu' => [
            [
                'parent_slug' => null,
                'page_title' => 'Crear causas muerte',
                'menu_title' => 'Crear causas muerte',
                'menu_slug' => 'crear_causa_muerte',
                'function' => 'formulario_registro_causas_muerte',
            ],
            [
                'parent_slug' => null,
                'page_title' => 'Actualizar causas muerte',
                'menu_title' => 'Actualizar causas muerte',
                'menu_slug' => 'actualizar_causa_muerte',
                'function' => 'formulario_actualizar_causas_muerte',
            ],
            [
                'parent_slug' => null,
                'page_title' => 'Eliminar causas muerte',
                'menu_title' => 'Eliminar causas muerte',
                'menu_slug' => 'eliminar_causa_muerte',
                'function' => 'formulario_eliminar_causas_muerte',
            ]
        ]
    ];
    $keys = array_keys($configMenu);
    $capability = 'manage_options';
    foreach ($keys as $key) {
        if ($key === 'menu') {
            foreach ($configMenu[$key] as $option) {
                add_menu_page(
                    $option['page_title'],
                    $option['menu_title'],
                    $capability,
                    $option['menu_slug'],
                    $option['function']
                );
            }
        } else {
            foreach ($configMenu[$key] as $option) {
                add_submenu_page(
                    $option['parent_slug'],
                    $option['page_title'],
                    $option['menu_title'],
                    $capability,
                    $option['menu_slug'],
                    $option['function']
                );
            }
        }
    }
}

