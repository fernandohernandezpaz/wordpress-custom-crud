<?php

function dashboard()
{
    return '<h2>Hola bienvenidos</h2>';
}

//menu items
add_action('admin_menu', 'agregarNuevasOpcionesMenu');
function agregarNuevasOpcionesMenu()
{
    $configMenu = [
        'menu' => [
            [
                'page_title' => 'Dashboard',
                'menu_title' => 'Dashboard',
                'menu_slug' => 'dashboard',
                'function' => 'dashboard',
            ]
        ],
        'sub_menu' => [
            [
                'parent_slug' => 'dashboard',
                'page_title' => 'Causas muerte',
                'menu_title' => 'Causas muerte',
                'menu_slug' => 'lista_estadisticas',
                'function' => 'list_causas_muerte',
            ],
            [
                'parent_slug' => 'dashboard',
                'page_title' => 'Género',
                'menu_title' => 'Género',
                'menu_slug' => 'lista_generos',
                'function' => 'list_generos',
            ],
            [
                'parent_slug' => 'dashboard',
                'page_title' => 'Persona',
                'menu_title' => 'Persona',
                'menu_slug' => 'lista_personas',
                'function' => 'list_personas',
            ],
            [
                'parent_slug' => 'Crear causas muerte',
                'page_title' => 'Crear causas muerte',
                'menu_title' => 'Crear causas muerte',
                'menu_slug' => 'crear_causa_muerte',
                'function' => 'formulario_registro_causas_muerte',
            ],
            [
                'parent_slug' => 'Actualizar causas muerte',
                'page_title' => 'Actualizar causas muerte',
                'menu_title' => 'Actualizar causas muerte',
                'menu_slug' => 'actualizar_causa_muerte',
                'function' => 'formulario_actualizar_causas_muerte',
            ],
            [
                'parent_slug' => 'Eliminar causas muerte',
                'page_title' => 'Eliminar causas muerte',
                'menu_title' => 'Eliminar causas muerte',
                'menu_slug' => 'eliminar_causa_muerte',
                'function' => 'formulario_eliminar_causas_muerte',
            ],
            [
                'parent_slug' => 'Crear género',
                'page_title' => 'Crear género',
                'menu_title' => 'Crear género',
                'menu_slug' => 'crear_genero',
                'function' => 'formulario_registro_genero',
            ],
            [
                'parent_slug' => 'Actualizar género',
                'page_title' => 'Actualizar género',
                'menu_title' => 'Actualizar género',
                'menu_slug' => 'actualizar_genero',
                'function' => 'formulario_actualizar_genero',
            ],
            [
                'parent_slug' => 'Eliminar género',
                'page_title' => 'Eliminar género',
                'menu_title' => 'Eliminar género',
                'menu_slug' => 'eliminar_genero',
                'function' => 'formulario_eliminar_genero',
            ],
            [
                'parent_slug' => 'Crear persona',
                'page_title' => 'Crear persona',
                'menu_title' => 'Crear persona',
                'menu_slug' => 'crear_persona',
                'function' => 'formulario_registro_persona',
            ],
            [
                'parent_slug' => 'Actualizar persona',
                'page_title' => 'Actualizar persona',
                'menu_title' => 'Actualizar persona',
                'menu_slug' => 'actualizar_persona',
                'function' => 'formulario_actualizar_persona',
            ],
            [
                'parent_slug' => 'Eliminar persona',
                'page_title' => 'Eliminar persona',
                'menu_title' => 'Eliminar persona',
                'menu_slug' => 'eliminar_persona',
                'function' => 'formulario_eliminar_persona',
            ],
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

