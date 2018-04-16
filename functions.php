<?php


function uc_editable_hm_scripts(){
    wp_enqueue_script('uc_editable_hm_scripts', plugins_url('js/main.js', __FILE__), array('jquery'));
    wp_enqueue_script('uc_editable_hm_scripts_ajax', plugins_url('js/forms-ajax.js', __FILE__), array('jquery'));
    wp_enqueue_style('uc_editable_hm_styles', plugins_url('css/style.css', __FILE__));
};


//=======================Checking if we already have a needed table in DB, if not, we create it=============================
global $wpdb;
$table_name = $wpdb->prefix.'editable_help_tabs';

if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
    $sql = "CREATE TABLE IF NOT EXISTS `$table_name`(
            `id_tab` int(11) NOT NULL AUTO_INCREMENT,
            `title_tab` varchar(40) NOT NULL,
            `text_tab` text NOT NULL,
            `text_sidebar` text,
            `tab_status` varchar(20) NOT NULL,
            `screen_id` varchar(40) NOT NULL,
            UNIQUE KEY id  (id_tab)
        ) ;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
};
//=======================Checking if we already have a needed table in DB, if not, we create it=============================


//================ Add data to DB Table ==================================

function add_help_tabs_to_db(){

        global $wpdb;


        $title_tab = $_POST['title_tab'];
        $text_tab = $_POST['content_tab'];
        $text_sidebar = $_POST['content_tab'];
        $status_tab = 'trash';
        $current_screen_id = $_POST['screen_id'];


    $wpdb = $wpdb->insert( wp_editable_help_tabs, array( 'title_tab' =>  $title_tab, 'text_tab' => $text_tab, 'text_sidebar' => '',  'tab_status' => $status_tab, 'screen_id' => $current_screen_id) );

};
//================ Add data to DB ==================================


//================ Edit data in DB ==================================
function editing_existed_help_tabs_from_db (){
    global $wpdb;
    $title_tab = $_POST['title_tab'];
    $text_tab = $_POST['content_tab'];
    $text_sidebar = $_POST['content_tab'];
    $text_sidebar = $_POST['content_tab'];
    $current_tab_id = $_POST['current_tab_id'];
    $status_tab = 'trash';

    $wpdb = $wpdb->update( wp_editable_help_tabs, array( 'title_tab' =>  $title_tab, 'text_tab' => $text_tab, 'text_sidebar' => '',  'tab_status' => $status_tab), array( 'id_tab' => $current_tab_id ) );
};
//================ Edit data in DB ==================================


//======================= Show up info from DB table to the HM PANEL ==================================
function show_all_editable_tabs(){
    $screen = get_current_screen();
    $define_screen_id = $screen->id;
    $ddd = plugin_dir_url('/uc-editable-help-manager/images/no-tabs.png');
    $screen->remove_help_tabs();

    $screen->add_help_tab(array(
            'id' => "hidden_tab",
            'title' => "hidden_tab",
            'content' => "<img src=".$ddd."><p>NO TABS CREATED</p><br><span>Create a new help menu tab to publish content."
        ));
    global $wpdb;
    $tabs = $wpdb->get_results("SELECT * FROM wp_editable_help_tabs WHERE screen_id = '$define_screen_id'");
    $help_buttons = '<br><hr><div class="tab-help-buttons">
					<a href ="#" class="button edit_current_tab">Edit</a>
				</div>';
           
    foreach ($tabs as $value) {
        $screen->add_help_tab(array(
            'id' => $value->id_tab,
            'title' => $value->title_tab,
            'content' => $value->text_tab.$help_buttons
        ));
    };

 

};
add_action('admin_head', 'show_all_editable_tabs');
//======================= Show up info from DB table to the HM PANEL ==================================

