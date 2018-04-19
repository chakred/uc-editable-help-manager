<?php


function uc_editable_hm_scripts(){
    global $user_ID;

    if(is_super_admin( $user_ID )) {
        wp_enqueue_script('uc_editable_hm_scripts', plugins_url('js/main.js', __FILE__), array('jquery'));
    };
    wp_enqueue_script('uc_editable_hm_scripts_ajax', plugins_url('js/forms-ajax.js', __FILE__), array('jquery'));
    wp_enqueue_style('uc_editable_hm_styles', plugins_url('css/style.css', __FILE__));
};


//=======================Checking if we already have a needed table in DB, if not, we create it=============================
global $wpdb;
$table_tabs_name = $wpdb->prefix.'editable_help_tabs';

if($wpdb->get_var("SHOW TABLES LIKE '$table_tabs_name'") != $table_tabs_name){
    $sql = "CREATE TABLE IF NOT EXISTS `$table_tabs_name`(
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
        $status_trash = 'trash';
        $current_screen_id = $_POST['screen_id'];

        $wpdb->insert( wp_editable_help_tabs, array( 'title_tab' =>  $title_tab, 'text_tab' => $text_tab, 'text_sidebar' => '',  'tab_status' => $status_trash, 'screen_id' => $current_screen_id) );

};
//================ Add data to DB ==================================


//================ Edit data in DB ==================================
function editing_existed_help_tabs_from_db (){
    global $wpdb;
    $title_tab = $_POST['title_tab'];
    $text_tab = $_POST['content_tab'];
    $current_tab_id = $_POST['current_tab_id'];
    $status_trash = 'trash';

    $wpdb->update( wp_editable_help_tabs, array( 'title_tab' =>  $title_tab, 'text_tab' => $text_tab, 'text_sidebar' => '',  'tab_status' => $status_trash), array( 'id_tab' => $current_tab_id ) );
};
//================ Edit data in DB ==================================


//================ Delete tabs in DB ==================================
function remove_existed_help_tabs_from_db (){
    global $wpdb;
    $current_tab_id = $_POST['current_tab_id'];

    $wpdb->delete( wp_editable_help_tabs, array( 'id_tab' => $current_tab_id ) );

};
//================ Delete tabs in DB ==================================


//================ Add data to DB Table -  sidebar ==================================

function add_help_tabs_sidebar_to_db(){

    global $wpdb;
    $text_sidebar = $_POST['content_sidebar'];
    $current_screen_id = $_POST['screen_id'];

    $wpdb->update( wp_editable_help_tabs, array( 'text_sidebar' =>  $text_sidebar), array( 'screen_id' => $current_screen_id ) );

};
//================ Add data to DB Table - sidebar ==================================


//======================= Show up info from DB table to the HM PANEL ==================================
function show_all_editable_tabs(){

    $screen = get_current_screen();
    $define_screen_id = $screen->id;

    global $status_trash;
    global $wpdb;
    global $user_ID;

    if(is_super_admin( $user_ID )){
        $screen->remove_help_tabs();

        $screen->add_help_tab(array(
            'id' => "hidden_tab",
            'title' => "hidden_tab"
        ));


        $screen->set_help_sidebar(
            '<p style ="text-align:center;"><a href ="#" class="edit_sidebar">Edit sidebar</a></p>'
        );
        $tabs = $wpdb->get_results("SELECT * FROM wp_editable_help_tabs WHERE screen_id = '$define_screen_id'");
    }else{
        $tabs = $wpdb->get_results("SELECT * FROM wp_editable_help_tabs WHERE screen_id = '$define_screen_id' AND tab_status = 'publish'");
        $screen->remove_help_tabs();
    };
//    $screen->remove_help_tabs();
    foreach ($tabs as $value) {
//        $screen->remove_help_tabs();
        if(!is_super_admin( $user_ID )) {

        $screen->add_help_tab(array(
            'id' => "hidden_tab",
            'title' => "hidden_tab",
        ));

        };
        $screen->add_help_tab(array(
            'id' => $value->id_tab,
            'title' => $value->title_tab,
            'content' => $value->text_tab
        ));

        if($value->text_sidebar != NULL){
            $screen->set_help_sidebar(
                $value->text_sidebar
            );
        };

        $status_trash = $value->tab_status;

    };
};
//======================= Show up info from DB table to the HM PANEL ==================================

//======================= PUBLISH / UNPUBLISH ==================================
function tubs_to_publish(){

    global $wpdb;
    $current_screen_id = $_POST['screen_id'];
    $status_publish = 'publish';

    $wpdb->update( wp_editable_help_tabs, array( 'tab_status' => $status_publish), array( 'screen_id' => $current_screen_id ) );

};
function tubs_to_unpublish(){

    global $wpdb;
    global $status_trash;
    $current_screen_id = $_POST['screen_id'];
    $status_trash = 'trash';

    $wpdb->update( wp_editable_help_tabs, array( 'tab_status' => $status_trash), array( 'screen_id' => $current_screen_id ) );

};
//======================= PUBLISH / UNPUBLISH ==================================


//======================= Content of activation / deactivation  ==================================
function help_tabs_activation(){
    global $status_trash;
//    var_dump($status_trash);
    if($status_trash == "trash"){
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
    }else {
        echo '<p class="to-unpublish" style="display:none;"><svg width="33.00000000000006" height="15" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><path d="M 207.375,425.00c-10.875,0.00-21.175-5.075-27.775-13.825L 90.25,293.225c-11.625-15.35-8.60-37.20, 6.75-48.825 c 15.375-11.65, 37.20-8.60, 48.825,6.75l 58.775,77.60l 147.80-237.275c 10.175-16.325, 31.675-21.325, 48.025-11.15 c 16.325,10.15, 21.325,31.675, 11.125,48.00L 236.975,408.575c-6.075,9.775-16.55,15.90-28.025,16.40C 208.425,425.00, 207.90,425.00, 207.375,425.00z" ></path></svg>The help menu has been published. To unpublish, <a href=\'#\'> Click here</a></p>';
    };
};
//======================= Content of activation / deactivation  ==================================
