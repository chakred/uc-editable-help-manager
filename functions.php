<?php



function uc_editable_hm_scripts(){
    wp_enqueue_script('uc_editable_hm_scripts', plugins_url('js/main.js', __FILE__), array('jquery'));
    wp_enqueue_script('uc_editable_hm_scripts_ajax', plugins_url('js/forms-ajax.js', __FILE__), array('jquery'));
    wp_enqueue_style('uc_editable_hm_styles', plugins_url('css/style.css', __FILE__));   
};


//=======================Проверяем есть ли таблица в БД, если нет , то создаем ее=============================
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

//================ Вносим данные в таблицу ==================================
function add_help_tabs_to_db(){

        global $wpdb;
        $title_tab = $_POST['title_tab'];
        $text_tab = $_POST['content_tab'];
        $text_sidebar = $_POST['content_tab'];
        $text_sidebar = $_POST['content_tab'];
        $status_tab = 'trash';
//        $screen_id = $screen->id;
//        echo get_current_screen()->id;

    $wpdb = $wpdb->insert( wp_editable_help_tabs, array( 'title_tab' =>  $title_tab, 'text_tab' => $text_tab, 'text_sidebar' => '',  'tab_status' => $status_tab) );

};
//======================= Вносим данные в таблицу =============================



//======================= меняем данные в таблице по выбраному табу =============================



//======================= меняем данные в таблице по выбраному табу=============================






//======================= Выводим таб с БД ==================================

function show_all_edditable_tabs(){
    $screen = get_current_screen();

    $screen->remove_help_tabs();
    $screen_id = $screen->id;

    global $wpdb;
    $tabs = $wpdb->get_results("SELECT * FROM wp_editable_help_tabs");
    $help_buttons = '<br><hr><div class="tab-help-buttons">
					<a href ="/?TB_inline&inlineId=edit-existed-tab&width=600&height=550" class="thickbox button" class="edit-tub">Edit</a>
				</div>';

    foreach ($tabs as $value) {
        $screen->add_help_tab(array(
            'id' => $value->id_tab,
            'title' => $value->title_tab,
            'content' => $value->text_tab.$help_buttons
        ));

    }


    };
add_action('admin_head', 'show_all_edditable_tabs');

//=======================Выводим таб с БД =============================