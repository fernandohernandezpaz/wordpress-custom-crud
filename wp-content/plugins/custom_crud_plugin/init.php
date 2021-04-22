<?php
/*
Plugin Name: Custom crud plugin
Description: Plugin para crear nuevas tablas en la base de datos y crear un crud de estas.
Version: 1.0.0
Author: Fernando Hernández Paz
Author URI: -
*/

// definiendo directorio en base al archivo init
define('ROOTDIR', plugin_dir_path(__FILE__));
// wp-content/plugins/custom-crud-plugin/
// agregando nuevas funciones
require_once(ROOTDIR . 'modulos/causas_muerte/CausasMuerte.php');

// if you want to check in debug log
// require_once(ROOTDIR . 'write_in_log.php');

// function to create the DB / Options / Defaults
function creating_news_tables()
{
    global $wpdb;
    $path = ROOTDIR . '/script.sql';
    $file = fopen($path, 'r');
    $sql_file = fread($file, filesize($path));
    fclose($file);
    $sql = str_replace('{prefix}', $wpdb->prefix, $sql_file);
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'creating_news_tables');

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


