<?php
/*
Plugin Name: Editable Contextual Help Manager
Description: This plugin helps you to add, edit and save information in tabs into contextual help panel of Wordpress.
Version: 1.0
Author: Dmitriy Derkach
*/


function init_role() {


    global $user_ID;
    require __DIR__.'/functions.php';
    require __DIR__.'/uc-editable-hm-modal.php';
    require __DIR__.'/uc-editable-hm-modal-exist.php';

    add_action('admin_enqueue_scripts', 'uc_editable_hm_scripts');
    add_thickbox();
    add_action( 'in_admin_header', 'uConnect\HelpManager\AddTabs\\tabs_creating_window');
    add_action( 'in_admin_header', 'uConnect\HelpManager\EditTabs\\tabs_editing_window');
    add_action('admin_head', 'show_editable_tabs');
    add_action( 'wp_ajax_add_tabs_to_db', 'add_tabs_to_db' );
    add_action( 'wp_ajax_add_sidebar_to_db', 'add_sidebar_to_db' );
    add_action( 'wp_ajax_edit_tabs_in_db', 'edit_tabs_in_db' );
    add_action( 'wp_ajax_remove_tabs_in_db', 'remove_tabs_in_db' );
    add_action( 'wp_ajax_tabs_to_publish', 'tabs_to_publish' );
    add_action( 'wp_ajax_tabs_to_unpublish', 'tabs_to_unpublish' );
    add_action('in_admin_header', 'help_tabs_activation');
    wp_enqueue_editor();

    if( is_super_admin( $user_ID )){
        wp_enqueue_editor();
    }else{
        add_action('admin_head', 'hide_native_tabs');
    };

};
add_action( 'plugins_loaded', 'init_role' );

function remove_table_db(){

    global $wpdb;
    $table_tabs_name = $wpdb->prefix.'editable_help_tabs';
    $sql_tab = "DROP TABLE IF EXISTS $table_tabs_name";
    $wpdb->query($sql_tab);

    $table_sidebar_name = $wpdb->prefix.'editable_help_sidebar';
    $sql_sidebar = "DROP TABLE IF EXISTS $table_sidebar_name";
    $wpdb->query($sql_sidebar);

};

register_deactivation_hook(__FILE__, 'remove_table_db');
