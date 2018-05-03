<?php
namespace uConnect\HelpManager\Functions;
/**
 * Register session
 */

function register_session(){
    if( !session_id() )
        session_start();
};



/**
 * Enqueue scrips/styles
 */
function uc_editable_hm_scripts(){

    global $user_ID;
    if(is_super_admin( $user_ID )) {
        wp_enqueue_script('uc_editable_hm_scripts', plugins_url('js/main.js', __FILE__), array('jquery'));
    };
    wp_enqueue_script('uc_editable_hm_scripts_ajax', plugins_url('js/forms-ajax.js', __FILE__), array('jquery'));
    wp_enqueue_style('uc_editable_hm_styles', plugins_url('css/style.css', __FILE__));

};

global $status;
$status = "trash";


/**
 * Add tabs to DB
 */
function add_tabs_to_db(){

    global $wpdb;
    global $cache_key_tab;
    global $group_tb;

    $table_tabs_name = $wpdb->base_prefix.'editable_help_tabs';
    $title_tab = $_POST['title_tab'];
    $text_tab = $_POST['content_tab'];
    $current_screen_id = $_POST['screen_id'];

    if($_SESSION['status-tabs-'.$current_screen_id] == "trash"){
        $status_change = "trash";
    }elseif ($_SESSION['status-tabs-'.$current_screen_id] == "publish"){
        $status_change = "publish";
    }
    else{
        $status_change = "";
    };
    if(!$add_tabs = wp_cache_get($cache_key_tab, $group_tb)){
        $insert_tab ="INSERT INTO $table_tabs_name (id_wp, title_tab, text_tab, tab_status, screen_id) VALUES ('%d', '%s', '%s','%s', '%s')";
        $query = $wpdb->prepare($insert_tab, $title_tab, $title_tab, $text_tab, $status_change, $current_screen_id);
        $add_tabs = $wpdb->query($query);

        if($add_tabs === false)
            die("Error DB - Cannot add a new tab!");

        wp_cache_set($cache_key_tab, $add_tabs, $group_tb );
    }
};



/**
 * Edit tabs in DB
 */

function edit_tabs_in_db (){

    global $wpdb;
    global $cache_key_tab;
    global $group_tb;

    $table_tabs_name = $wpdb->base_prefix.'editable_help_tabs';
    $title_tab = $_POST['title_tab'];
    $text_tab = $_POST['content_tab'];
    $current_tab_id = $_POST['current_tab_id'];

    if(!$edit_tabs = wp_cache_get($cache_key_tab, $group_tb)){
        $update_tab ="UPDATE $table_tabs_name SET title_tab = %s, text_tab = %s  WHERE id_tab = %d";
        $query = $wpdb->prepare($update_tab, $title_tab, $text_tab, $current_tab_id);
        $edit_tabs = $wpdb->query($query);

        if($edit_tabs === false)
            die("Error DB - Cannot edit tab!");

        wp_cache_set($cache_key_tab, $edit_tabs, $group_tb );
    }
};



/**
 * Delete tabs in DB
 */
function remove_tabs_in_db (){

    global $wpdb;
    global $cache_key_tab;
    global $group_tb;

    $table_tabs_name = $wpdb->base_prefix.'editable_help_tabs';
    $current_tab_id = $_POST['current_tab_id'];

    if(!$delete_tabs = wp_cache_get($cache_key_tab, $group_tb)){
        $delete_tabs = $wpdb->query(
            $wpdb->prepare("DELETE FROM $table_tabs_name WHERE id_tab = %d", $current_tab_id)
        );
        wp_cache_set($cache_key_tab, $delete_tabs, $group_tb );
    }

};



/**
 * Add sidebar to DB
 */
function add_sidebar_to_db(){

    global $wpdb;
    global $cache_key_sidebar;
    global $group_sb;

    $table_sidebar_name = $wpdb->base_prefix.'editable_help_sidebar';
    $text_sidebar = esc_sql($_POST['content_sidebar']);
    $current_screen_id = esc_sql($_POST['screen_id']);
    if($_SESSION['status-tabs-'.$current_screen_id] =="" || $_SESSION['status-tabs-'.$current_screen_id] ==null){
        $define_status = "trash";
    }else{
         $define_status = $_SESSION['status-tabs-'.$current_screen_id];
    };

    if(!$sidebar = wp_cache_get($cache_key_sidebar, $group_sb)){
        $recID = $wpdb->get_var( "SELECT id_sidebar FROM  $table_sidebar_name WHERE screen_id = '$current_screen_id'");
        $sidebar = $wpdb->replace( $table_sidebar_name, array('id_sidebar' =>  $recID, 'text_sidebar' =>  $text_sidebar, 'tab_status' => $define_status, 'screen_id' => $current_screen_id));
        $wpdb->insert_Id;

        wp_cache_set($cache_key_sidebar, $sidebar, $group_sb );
    }

};



/**
 * Show up info from DB table to the HM PANEL
 */

function show_editable_tabs(){

    global $wpdb;
    global $user_ID;
    global $status;
    global $cache_key_tab;
    global $cache_key_sidebar;
    global $group_tb;
    global $group_sb;

    $screen = get_current_screen();
    $define_screen_id = $screen->id;
    $table_tabs_name = $wpdb->base_prefix.'editable_help_tabs';
    $table_sidebar_name = $wpdb->base_prefix.'editable_help_sidebar';
    $cache_key_tab = $screen->id;
    $cache_key_sidebar = $screen->id;
    $group_tb = 'help_tb';
    $group_sb = 'help_sb';
    wp_cache_add_global_groups($group_tb);
    wp_cache_add_global_groups($group_sb);

    $native_tabs = $screen->get_help_tabs();

    $recId= $wpdb->get_col( "SELECT id_wp FROM $table_tabs_name WHERE screen_id = '$define_screen_id'");
    foreach($native_tabs as $base_key => $base_value) {

        if(!in_array($base_value['id'], $recId ) && !is_numeric($base_value['id'])){

            $insert_tab ="INSERT INTO $table_tabs_name (id_wp, title_tab, text_tab, screen_id) VALUES ('%s', '%s', '%s','%s')";
            $query = $wpdb->prepare($insert_tab, $base_value['id'], $base_value['title'], $base_value['content'], $define_screen_id);
            $result = $wpdb->query($query);

        if($result === false)
            die("Error DB - Cannot show editable tabs!");

        };
        if(!is_numeric( $base_value['id'])){
            $screen->remove_help_tab($base_value['id']);
        }
    };



    if(is_super_admin( $user_ID )){
        if(!$tabs = wp_cache_get($cache_key_tab, $group_tb)){
            $tabs = $wpdb->get_results("SELECT * FROM $table_tabs_name WHERE screen_id = '$define_screen_id'");
            wp_cache_set($cache_key_tab, $tabs, $group_tb );
            }
        if(!$sidebars = wp_cache_get($cache_key_sidebar, $group_sb)){
            $sidebars = $wpdb->get_results("SELECT * FROM $table_sidebar_name WHERE screen_id = '$define_screen_id'");
            wp_cache_set($cache_key_sidebar,  $sidebars, $group_sb );
        }
        $control_buttons = '<br><div class="tab-help-buttons delete"><a href ="#" class="button delete_current_tab">Delete</a></div><div class="tab-help-buttons"><a href ="#" class="button button-primary edit_current_tab">Edit</a></div>';
    }else{
        if(!$tabs = wp_cache_get($cache_key_tab, $group_tb)){
            $tabs = $wpdb->get_results("SELECT * FROM $table_tabs_name WHERE screen_id = '$define_screen_id' AND tab_status = 'publish'");

            wp_cache_set($cache_key_tab, $tabs, $group_tb );
            }
        if(!$sidebars = wp_cache_get($cache_key_sidebar, $group_sb)){
            $sidebars = $wpdb->get_results("SELECT * FROM $table_sidebar_name WHERE screen_id = '$define_screen_id' AND tab_status = 'publish'");
            wp_cache_set($cache_key_sidebar, $sidebars, $group_sb );
        }
        $control_buttons = "";
    };

//    var_dump(wp_cache_get($cache_key_tab, $group_tb).'<br>');
//    var_dump(wp_cache_get($cache_key_sidebar, $group_sb));

//    global $wp_object_cache;
//    var_export( $wp_object_cache );
//    global $cache_key_tab;
//    print_r($cache_key_tab);

    foreach (wp_cache_get($cache_key_tab, $group_tb) as $value) {

        $screen->add_help_tab(array(
            'id' => $value->id_tab,
            'title' => $value->title_tab,
            'content' => $value->text_tab.$control_buttons
        ));
        $status = $value->tab_status;

    };

    foreach (wp_cache_get($cache_key_sidebar, $group_sb) as $value) {

        if($value->text_sidebar){
            $screen->set_help_sidebar(
                $value->text_sidebar
            );
        };
        $status = $value->tab_status;

    }

};



/**
 * PUBLISH / UNPUBLISH
 */
function tabs_to_publish(){

    global $wpdb;
    global $status;

    $current_screen_id = $_POST['screen_id'];
    $status = 'publish';
    $table_tabs_name = $wpdb->base_prefix.'editable_help_tabs';
    $table_sidebar_name = $wpdb->base_prefix.'editable_help_sidebar';

    $update_tabs_status ="UPDATE $table_tabs_name SET tab_status = %s WHERE screen_id = %s";
    $query_tabs_status = $wpdb->prepare($update_tabs_status, $status, $current_screen_id);
    $result_tabs_status = $wpdb->query($query_tabs_status);

    if($result_tabs_status === false){
        die("Error DB - Cannot update tabs status!");
    };

    $update_sidebars_status ="UPDATE $table_sidebar_name SET tab_status = %s WHERE screen_id = %s";
    $query_sidebars_status = $wpdb->prepare($update_sidebars_status, $status, $current_screen_id);
    $result_sidebars_status = $wpdb->query($query_sidebars_status);

    if($result_sidebars_status === false){
        die("Error DB - Cannot update sidebar status!");
    };

    $_SESSION['status-tabs-'. $current_screen_id] =  $status;

};

function tabs_to_unpublish(){

    global $wpdb;
    global $status;

    $current_screen_id = $_POST['screen_id'];
    $status = 'trash';
    $table_tabs_name = $wpdb->base_prefix.'editable_help_tabs';
    $table_sidebar_name = $wpdb->base_prefix.'editable_help_sidebar';

    $update_tabs_status ="UPDATE $table_tabs_name SET tab_status = %s WHERE screen_id = %s";
    $query_tabs_status = $wpdb->prepare($update_tabs_status, $status, $current_screen_id);
    $result_tabs_status = $wpdb->query($query_tabs_status);

    if($result_tabs_status === false){
        die("Error DB - Cannot update tabs status!");
    };

    $update_sidebars_status ="UPDATE $table_sidebar_name SET tab_status = %s WHERE screen_id = %s";
    $query_sidebars_status = $wpdb->prepare($update_sidebars_status, $status, $current_screen_id);
    $result_sidebars_status = $wpdb->query($query_sidebars_status);

    if($result_sidebars_status === false){
        die("Error DB - Cannot update sidebar status!");
    };

    $_SESSION['status-tabs-'. $current_screen_id] =  $status;

};



/**
 * Content of activation / deactivation
 */
function help_tabs_activation(){

    global $status;

    if($status == "trash" || $status == "" || $status == "all"){
        echo '<p class="to-publish" style="display:none;"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="33px" height="19px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">
    <g>
        <g id="Attention">
            <g>
                <path d="M605.217,501.568l-255-442C341.394,44.302,324.887,34,306,34c-18.887,0-35.394,10.302-44.217,25.568l-255,442
                    C2.482,509.048,0,517.735,0,527c0,28.152,22.848,51,51,51h510c28.152,0,51-22.848,51-51
                    C612,517.735,609.535,509.048,605.217,501.568z M50.966,527.051L305.949,85H306l0.034,0.051L561,527L50.966,527.051z M306,408
                    c-18.768,0-34,15.232-34,34c0,18.785,15.215,34,34,34s34-15.232,34-34S324.785,408,306,408z M272,255
                    c0,1.938,0.17,3.859,0.476,5.712l16.745,99.145C290.598,367.897,297.585,374,306,374s15.402-6.103,16.762-14.144l16.745-99.145
                    C339.83,258.859,340,256.938,340,255c0-18.768-15.215-34-34-34C287.232,221,272,236.232,272,255z"/>
            </g>
        </g>
    </g>
</svg>The help menu has not been published. To publish, <a href=\'#\'> Click here</a></p>';

    }else{
        echo '<p class="to-unpublish" style="display:none;"><svg width="33.00000000000006" height="15" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><path d="M 207.375,425.00c-10.875,0.00-21.175-5.075-27.775-13.825L 90.25,293.225c-11.625-15.35-8.60-37.20, 6.75-48.825 c 15.375-11.65, 37.20-8.60, 48.825,6.75l 58.775,77.60l 147.80-237.275c 10.175-16.325, 31.675-21.325, 48.025-11.15 c 16.325,10.15, 21.325,31.675, 11.125,48.00L 236.975,408.575c-6.075,9.775-16.55,15.90-28.025,16.40C 208.425,425.00, 207.90,425.00, 207.375,425.00z" ></path></svg>The help menu has been published. To unpublish, <a href=\'#\'> Click here</a></p>';

    };
};


/**
 * Hide native tabs if you are not a superadmin (according  to status 'publish')
 */
function hide_native_tabs (){
    global $status;
    $screen = get_current_screen();
    if($status == "trash" || $status == null || $status == "all")
        return $screen->remove_help_tabs();
};

