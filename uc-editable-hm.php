<?php
/*
Plugin Name: Editable Contextual Help Manager
Description: This plugin helps you to add, edit and save information in tabs into contextual help panel of Wordpress.
Version: 1.0
Author: Dmitriy Derkach
*/




function main_identification_superadmin() {

    $check_user = wp_get_current_user();

    if( is_super_admin( $check_user )){
        //require_once(ABSPATH . 'wp-includes/pluggable.php');
        require __DIR__.'/functions.php';
        require __DIR__.'/uc-editable-hm-modal.php';

        add_action('admin_enqueue_scripts', 'uc_editable_hm_scripts');

        add_thickbox();

        add_action( 'admin_head', 'new_tabs_creating_window');
        add_action( 'wp_ajax_add_help_tabs_to_db', 'add_help_tabs_to_db' );


    }

}

add_action( 'plugins_loaded', 'main_identification_superadmin' );

