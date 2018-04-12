<?php


function exist_tabs_editing_window(){

    echo '<div id="edit-existed-tab" style="display:none;">

	<div class="hm-window">
		<h3>Help menu:';
    echo get_admin_page_title();
    echo '</h3>
		<div class="hm-tabs-wrap">
			<ul class="tabs">
				<span>Tabs</span>
				<li><a href="#tab1-1" class="show-tab-name">tab1</a></li>
				<a href="#">+ Create a new tab</a>
				<span>Sidebar</span>
				<li><a href="#tab2-2">Sidebar</a></li>
			</ul>
			<div class="tab-container">
				<div id="tab1-1" class="tab-content">
					<form id="form-for-tab-exist">
						<input type="text" name="title2" placeholder="Name of tab" id="tabs_title_edit" >';
                        wp_editor('', 'edit_created_tabs', array(
                            'wpautop'       => 1,
                            'media_buttons' => 1,
                            'textarea_name' => 'tabs_content',
                            'textarea_rows' => 10,
                            'tabindex'      => null,
                            'editor_css'    => '',
                            'editor_class'  => '',
                            'teeny'         => 0,
                            'dfw'           => 0,
                            'tinymce'       => 0,
                            'quicktags'     => 1,
                            'drag_drop_upload' => false
                        ) );

    echo '
				<br>
				<!--<div class="control-buttons">
					<input name="save" type="submit" class="button" id ="cansel-tab1" class="button-large button" value="Cancel">
					<input name="save_tab" type="submit" class="button button-primary button-large" id ="save-new-tab" class="button button-primary button-large" value="Save">
				</div>-->
				</form>
				</div>
				<div id="tab2-2" class="tab-content">
				<form id="form-for-sidebar1">';

    echo '
			<br>
			<!--<div class="control-buttons">
				<input name="save" type="submit" class="button" id ="cansel-sidebar" class="button-large button" value="Cancel">
				<input name="save" type="submit" class="button button-primary button-large" id ="save-new-sidebar" class="button button-primary button-large" value="Save">
			</div>-->
			</form>
			</div>
			</div>
		</div>
	</div>

</div>';

}

;?>
