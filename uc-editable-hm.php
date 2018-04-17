<?php
/*
Plugin Name: Editable Contextual Help Manager
Description: This plugin helps you to add, edit and save information in tabs into contextual help panel of Wordpress.
Version: 1.0
Author: Dmitriy Derkach
*/



function main_identification_superadmin() {


    global $user_ID;
    require __DIR__.'/functions.php';
    require __DIR__.'/uc-editable-hm-modal.php';
    require __DIR__.'/uc-editable-hm-modal-exist.php';

    add_action('admin_enqueue_scripts', 'uc_editable_hm_scripts');

    add_thickbox();

    add_action( 'in_admin_header', 'new_tabs_creating_window');
    add_action( 'in_admin_header', 'exist_tabs_editing_window');
    add_action( 'wp_ajax_add_help_tabs_to_db', 'add_help_tabs_to_db' );
    add_action( 'wp_ajax_add_help_tabs_sidebar_to_db', 'add_help_tabs_sidebar_to_db' );
    add_action( 'wp_ajax_editing_existed_help_tabs_from_db', 'editing_existed_help_tabs_from_db' );
    add_action( 'wp_ajax_tubs_to_publish', 'tubs_to_publish' );
    add_action( 'wp_ajax_tubs_to_unpublish', 'tubs_to_unpublish' );
    wp_enqueue_editor();

    if( is_super_admin( $user_ID ) ){

        add_action('admin_head', 'show_all_editable_tabs');
        add_action('in_admin_header', 'help_tabs_activation');
//        add_action('in_admin_header', 'help_tabs_deactivation');

        wp_enqueue_editor();

    }else{
        add_action('admin_head', 'show_all_editable_tabs');
//        add_action('in_admin_header', 'help_tabs_activation');
//        add_action('in_admin_header', 'help_tabs_deactivation');

    }

};

add_action( 'plugins_loaded', 'main_identification_superadmin' );

