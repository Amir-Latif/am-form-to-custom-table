<?php

/**
 * Plugin Name: Form To Custom Table
 * Plugin URI: https://amir-latif.github.io/portfolio/wp-plugins/amftut
 * Description: Captures data from the reader and stores it to a custom databse table
 * Version: 1.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Amir Latif
 * Author URI: https://amir-latif.github.io/portfolio/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: WordPress Plugins
 */
?>
<?php

/*
=======================================================
Add admin page to create & display the custom table
=======================================================
*/

function addAdminMenuPage()
{
    add_menu_page(
        'AMFTUT Table',
        'AMFTUT Table',
        'manage_options',
        'AMFTUT',
        'amftutCreateTableDisplay',
        'dashicons-editor-table',
        null
    );

    add_submenu_page(
        'AMFTUT',
        'AMFTUT Data',
        'Data Retrieval',
        'manage_options',
        'data-retrieval',
        'amftutReadTable'
    );
}
add_action('admin_menu', 'addAdminMenuPage');

function amftutCreateTableDisplay()
{ ?>
    <div class="wrap" id="amftut-react"></div>
<?php
}

function amftutCreateTableCallback()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'amftut_custom_table';
    $table_columns = "id INTEGER NOT NULL AUTO_INCREMENT,";
    $charset_collate = $wpdb->get_charset_collate();

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    for ($i = 1; $i <= (count($_POST) - 1) / 3; $i++) {
        $table_columns .= "\n" . strtolower(str_replace(' ', '_', $_POST["field-$i-name"]));

        switch ($_POST["field-$i-type"]) {
            case 'Short Text':
                $table_columns .= " TINYTEXT ";
                break;
            case 'Long Text':
                $table_columns .= " LONGTEXT";
                break;
            case 'Email':
                $table_columns .= " VARCHAR(255) ";
                break;
            case 'Checkbox':
                $table_columns .= " BOOLEAN ";
                break;
            case 'Number':
                $table_columns .= " INTEGER ";
                break;

            default:
                break;
        };
        $table_columns .= $_POST["field-$i-mandatory"] ? "NOT NULL," : "NULL,";
    }

    $sql = "CREATE TABLE $table_name (
$table_columns
PRIMARY KEY (id)
    ) $charset_collate;";
    dbDelta($sql);

    wp_die();
}
add_action('wp_ajax_nopriv_amftutCreateTable', 'amftutCreateTableCallback');
add_action('wp_ajax_amftutCreateTable', 'amftutCreateTableCallback');


function amftutReadTable()
{ ?>
    <div class="wrap" id="amftut-react"></div>
<?php }


/* =======================================================
 Display the form in the front-end using a shortcode
======================================================= */

function amftutDisplayForm()
{
    ob_start();
    include('templates/amftut-visitor-form.php');
    return ob_get_clean();
}
add_shortcode('amftut_display_form', 'amftutDisplayForm');


/* =======================================================
 Form Action
======================================================= */

function amftutPostDataCallback()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'amftut_custom_table';
    $table_columns = $wpdb->get_results("SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name';");

    $insertion_array = array();
    for ($i = 1; $i < count($table_columns); $i++) {
        $field = $table_columns[$i]->COLUMN_NAME;
        $insertion_array[$field] = $_POST[$field];
    }

    $data_type_array = array();
    for ($i = 1; $i < count($table_columns); $i++) {
        $type = $table_columns[$i]->DATA_TYPE;
        if ($type === 'int' || $type === 'tinyint') {
            array_push($data_type_array, '%d');
        } elseif ($type === 'tinytext' || $type === 'mediumtext' || $type === 'longtext') {
            array_push($data_type_array, '%s');
        }
    }

    $wpdb->insert($table_name, $insertion_array, $data_type_array);
}
add_action('wp_ajax_nopriv_amftutPostData', 'amftutPostDataCallback');
add_action('wp_ajax_amftutPostData', 'amftutPostDataCallback');


/* =======================================================
 Post drafts to WP posts
======================================================= */

function amftutPostToWP()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'amftut_custom_table';
    foreach ($_POST as $key => $value) {
        if ($value) $wpdb->update($table_name, array('posted' => 1), array('id' => $key));
    }
}
add_action('wp_ajax_nopriv_amftutReadTable', 'amftutPostToWP');
add_action('wp_ajax_amftutReadTable', 'amftutPostToWP');


/* =======================================================
Adding the CSS/JS
======================================================= */

function amftutAddScripts()
{
    $plugin_path = plugin_dir_url(__FILE__);
    global $wpdb;
    $table_name = $wpdb->prefix . 'amftut_custom_table';
    $table_columns = $wpdb->get_results("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name';");
    $table_records = $wpdb->get_results("SELECT * FROM $table_name");

    if (is_singular() && has_shortcode($GLOBALS['post']->post_content, 'amftut_display_form')) {
        wp_enqueue_style('amftutFormCss', $plugin_path . 'assets/amftut-form.css', array(), time());
        wp_enqueue_script('amftutFormJs', $plugin_path . 'assets/amftut-form.js', null, time(), true);
        wp_localize_script('amftutFormJs', 'object', array('ajaxUrl' => admin_url('admin-ajax.php')));
    } elseif (is_admin()) {
        wp_enqueue_style('amftutCss', $plugin_path . 'build/index.css', null, time());
        wp_enqueue_script('amftutReactJs', $plugin_path . 'build/index.js', array('wp-element'), time(), true);
        wp_localize_script('amftutReactJs', 'passedObject', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'tableRecords' => $table_records,
            'tableColumns' => $table_columns
        ));
    }
}
add_action('admin_enqueue_scripts', 'amftutAddScripts');
add_action('wp_enqueue_scripts', 'amftutAddScripts');

?>