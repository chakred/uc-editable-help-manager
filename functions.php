<?php



function uc_editable_hm_scripts(){
    wp_enqueue_script('uc_editable_hm_scripts', plugins_url('js/main.js', __FILE__), array('jquery'));
    wp_enqueue_script('uc_editable_hm_scripts_ajax', plugins_url('js/forms-ajax.js', __FILE__), array('jquery'));
    wp_enqueue_style('uc_editable_hm_styles', plugins_url('css/style.css', __FILE__));   
};



global $wpdb;
$table_name = $wpdb->prefix.'editable_help_tabs';

if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
    $sql = "CREATE TABLE IF NOT EXISTS `$table_name`(
            `id_tab` int(11) NOT NULL AUTO_INCREMENT,
            `title_tab` varchar(40) NOT NULL,
            `text_tab` text NOT NULL,
            `text_sidebar` text,
            `tab_status` varchar(20) NOT NULL,
            UNIQUE KEY id  (id_tab)
        ) ;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);



};

//================Прверяем есть ли таблица в БД, если нет , то создаем ее==================================
function add_help_tabs_to_db(){

        global $wpdb;
        $title_tab = $_POST['title_tab'];
        $text_tab = $_POST['content_tab'];
        $text_sidebar = $_POST['content_tab'];
        $status_tab = 'trash';



    $wpdb = $wpdb->insert( wp_editable_help_tabs, array( 'title_tab' =>  $title_tab, 'text_tab' => $text_tab, 'text_sidebar' => '',  'tab_status' => $status_tab) );


};
//=======================Прверяем есть ли таблица в БД, если нет , то создаем ее=============================


//======================= Выводим таб с БД ==================================

function show_all_edditable_tabs(){
    $screen = get_current_screen();
     $screen->remove_help_tabs();

    global $wpdb;
    $tabs = $wpdb->get_row("SELECT * FROM wp_editable_help_tabs");

    foreach ($tabs as  $value){
//        print_r($tabs);
        $screen->add_help_tab( array(
            'id'       => 'test',
            'title'    => __('test'),
            'content'  => 'test'
        ));
    }
    };
add_action('admin_head', 'show_all_edditable_tabs');

//=======================Выводим таб с БД =============================