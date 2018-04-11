<?php


function new_tabs_creating_window(){

	echo '<div id="add-new-tab" style="display:none;">

	<div class="hm-window">
		<h3>Help menu:';
		echo get_admin_page_title();
		echo '</h3>
		<div class="hm-tabs-wrap">
			<ul class="tabs">
				<span>Tabs</span>
				<li><a href="#tab1">tab1</a></li>
				<a href="#">+ Create a new tab</a>
				<span>Sidebar</span>
				<li><a href="#tab2">Sidebar</a></li>
			</ul>
			<div class="tab-container">
				<div id="tab1" class="tab-content">
					<form id="form-for-tab">
						<input type="text" name="title" placeholder="Name of tab" id="tabs_title">';
							wp_editor('', 'create_tabs', array(
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
				<div class="control-buttons">
					<input name="save" type="submit" class="button" id ="cansel-tab" class="button-large button" value="Cancel">
					<input name="save_tab" type="submit" class="button button-primary button-large" id ="save-new-tab" class="button button-primary button-large" value="Save">
				</div>
				</form>
				</div>
				<div id="tab2" class="tab-content">
				<form id="form-for-sidebar">';
				wp_editor('', 'create_sidebar', array(
							    'wpautop'       => 1,
								'media_buttons' => 1,
								'textarea_name' => 'create_sidebar',
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
			<div class="control-buttons">
				<input name="save" type="submit" class="button" id ="cansel-sidebar" class="button-large button" value="Cancel">
				<input name="save" type="submit" class="button button-primary button-large" id ="save-new-sidebar" class="button button-primary button-large" value="Save">
			</div>
			</form>
			</div>
			</div>
		</div>
	</div>

</div>';

}


;?>
