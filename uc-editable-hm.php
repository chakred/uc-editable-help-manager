<?php
/*
Plugin Name: Editable Contextual Help Manager
Description: This plugin helps you to add, edit and save information in tabs into contextual help panel of Wordpress.
Version: 1.0
Author: Dmitriy Derkach
*/
require __DIR__.'/functions.php';
require __DIR__.'/uc-editable-hm-modal.php';
require __DIR__.'/uc-editable-hm-modal-exist.php';


register_activation_hook(__FILE__, 'create_table_db');
register_uninstall_hook(__FILE__, 'remove_table_db');

function init_role() {

    global $user_ID;
    add_action('admin_head', 'uConnect\HelpManager\Functions\\show_editable_tabs');
    add_action('init','uConnect\HelpManager\Functions\\register_session');


    if( is_super_admin( $user_ID )){
        // wp_enqueue_editor();
        add_action('admin_enqueue_scripts', 'uConnect\HelpManager\Functions\\uc_editable_hm_scripts');
        add_action( 'in_admin_header', 'uConnect\HelpManager\AddTabs\\tabs_creating_window');
        add_action( 'in_admin_header', 'uConnect\HelpManager\EditTabs\\tabs_editing_window');
        add_action( 'wp_ajax_add_tabs_to_db', 'uConnect\HelpManager\Functions\\add_tabs_to_db' );
        add_action( 'wp_ajax_add_sidebar_to_db', 'uConnect\HelpManager\Functions\\add_sidebar_to_db' );
        add_action( 'wp_ajax_edit_tabs_in_db', 'uConnect\HelpManager\Functions\\edit_tabs_in_db' );
        add_action( 'wp_ajax_remove_tabs_in_db', 'uConnect\HelpManager\Functions\\remove_tabs_in_db' );
        add_action( 'wp_ajax_tabs_to_publish', 'uConnect\HelpManager\Functions\\tabs_to_publish' );
        add_action( 'wp_ajax_tabs_to_unpublish', 'uConnect\HelpManager\Functions\\tabs_to_unpublish' );
        add_action('in_admin_header', 'uConnect\HelpManager\Functions\\help_tabs_activation');
        wp_enqueue_editor();
    }else{
        add_action('admin_head', 'uConnect\HelpManager\Functions\\hide_native_tabs');
    };

};
add_action( 'plugins_loaded', 'init_role' );

/**
 * Checking if we already have a needed table in DB, if not, we create it
 */


function create_table_db(){

    global $wpdb;
    $table_tabs_name = $wpdb->base_prefix.'editable_help_tabs';
    $table_sidebar_name = $wpdb->base_prefix.'editable_help_sidebar';

    if($wpdb->get_var("SHOW TABLES LIKE '$table_tabs_name'") != $table_tabs_name){
        $sql = "CREATE TABLE IF NOT EXISTS `$table_tabs_name`(
                `id_tab` int(11) NOT NULL AUTO_INCREMENT,
                `id_wp` text NOT NULL,
                `title_tab` varchar(40) NOT NULL,
                `text_tab` text NOT NULL,
                `tab_status` varchar(20) NOT NULL,
                `screen_id` varchar(40) NOT NULL,
                UNIQUE KEY id  (id_tab)
            ) ;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    };

    if($wpdb->get_var("SHOW TABLES LIKE '$table_sidebar_name'") != $table_sidebar_name){
        $sql = "CREATE TABLE IF NOT EXISTS `$table_sidebar_name`(
                `id_sidebar` int(11) NOT NULL AUTO_INCREMENT,
                `text_sidebar` text,
                `tab_status` varchar(20) NOT NULL,
                `screen_id` varchar(40) NOT NULL,
                UNIQUE KEY id  (id_sidebar)
            ) ;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    };
};


/**
 * Uninstall
 */
function remove_table_db(){

    global $wpdb;
    $table_tabs_name = $wpdb->base_prefix.'editable_help_tabs';
    $sql_tab = "DROP TABLE IF EXISTS $table_tabs_name";
    $wpdb->query($sql_tab);

    $table_sidebar_name = $wpdb->base_prefix.'editable_help_sidebar';
    $sql_sidebar = "DROP TABLE IF EXISTS $table_sidebar_name";
    $wpdb->query($sql_sidebar);

};



