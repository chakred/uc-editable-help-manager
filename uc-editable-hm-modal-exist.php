<?php

namespace uConnect\HelpManager\EditTabs;

function tabs_editing_window(){

    echo '<div class="window-edit-modal-bg">
	<div id="window-edit-modal-wrap">
		<button type="button" class="close-window-modal">
			 <span class="dashicons dashicons-no tb-close-icon"></span>
		</button>
        <div class="hm-window">
            <h3>Help menu: ';
        echo get_admin_page_title();
        echo '</h3>
            <div class="hm-tabs-wrap">
                <ul class="tabs">
                    <span>Tabs</span>
                    <li class="active tab1-1"><a href="#tab1-1" class="show-tab-name">Create a new tab</a></li>
                    <span>Sidebar</span>
                    <li class="tab2-2"><a href="#tab2-2">Sidebar</a></li>
                </ul>
                <div class="tab-container">
                    <div id="tab1-1" class="tab-content">
                        <form id="form-for-tab-exist">
                            <input type="text" name="title2" placeholder="Name of tab" id="tabs_title_edit" >';
                            wp_editor('', 'edit_created_tabs', array(
                                'wpautop'       => 1,
                                'media_buttons' => 0,
                                'textarea_name' => 'tabs_content',
                                'textarea_rows' => get_option('default_post_edit_rows', 80),
                                'tabindex'      => null,
                                'editor_css'    => '',
                                'editor_class'  => '',
                                'teeny'         => 0,
                                'dfw'           => 0,
                                'tinymce'       => array( 
                                'content_css' => plugins_url('css/style.css', __FILE__),
                                'resize' => false),
                                'quicktags'     => 0,
                                'drag_drop_upload' => false
                            ) );
        echo '
                    <br>
                    <div class="control-buttons">
                        <input name="cansel" type="button" class="button button-large" class="button-large button" value="Cancel">
                        <input name="save_tab" type="submit" class="button button-primary button-large" id ="save-new-tab" class="button button-primary button-large" value="Save">
                    </div>
                    </form>
                    </div>
                    <div id="tab2-2" class="tab-content">
                    <h4>SIDEBAR</h4>
                    <form id="form-for-sidebar-exist">';
                            wp_editor('', 'edit_created_sidebar', array(
                                'wpautop'       => 1,
                                'media_buttons' => 0,
                                'textarea_name' => 'edit_created_sidebar',
                                'textarea_rows' => 20,
                                'tabindex'      => null,
                                'editor_css'    => '',
                                'editor_class'  => '',
                                'teeny'         => 0,
                                'dfw'           => 0,
                                'tinymce'       => array(
                                'content_css' => plugins_url('css/style.css', __FILE__),
                                'resize' => false),
                                'quicktags'     => 0,
                                'drag_drop_upload' => false
                            ) );
        echo '
                <br>
                <div class="control-buttons">
                    <input name="cansel" type="button" class="button button-large" class="button-large button" value="Cancel">
                    <input name="save" type="submit" class="button button-primary button-large" id ="save-new-sidebar" class="button button-primary button-large" value="Save">
                </div>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>';

}

;?>
