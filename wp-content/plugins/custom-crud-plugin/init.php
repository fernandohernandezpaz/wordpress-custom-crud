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

// agregando nuevas funciones
require_once(ROOTDIR . 'causas_muerte_list.php');

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
                'page_title' => 'Estadisticas',
                'menu_title' => 'Estadisticas',
                'menu_slug' => 'lista_estadisticas',
                'function' => 'list_causas_muerte',
            ]
        ],
        'sub_menu' => [

        ]
    ];
    $keys = array_keys($configMenu);
    foreach ($keys as $key) {
        if ($key === 'menu') {
            foreach ($configMenu[$key] as $option) {
                add_menu_page(
                    $option['page_title'],
                    $option['menu_title'],
                    'manage_options',
                    $option['menu_slug'],
                    $option['function']
                );
            }
        }
    }
    //this is the main item for the menu
//    add_menu_page('Schools', //page title
//        'Schools', //menu title
//        'manage_options', //capabilities
//        'sinetiks_schools_list', //menu slug
//        'sinetiks_schools_list' //function
//    );
//
//    //this is a submenu
//    add_submenu_page('sinetiks_schools_list', //parent slug
//        'Add New School', //page title
//        'Add New', //menu title
//        'manage_options', //capability
//        'sinetiks_schools_create', //menu slug
//        'sinetiks_schools_create'); //function
//
//    //this submenu is HIDDEN, however, we need to add it anyways
//    add_submenu_page(null, //parent slug
//        'Update School', //page title
//        'Update', //menu title
//        'manage_options', //capability
//        'sinetiks_schools_update', //menu slug
//        'sinetiks_schools_update'); //function
}


