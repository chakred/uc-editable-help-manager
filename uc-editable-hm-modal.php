<?php


function new_tabs_creating_window(){

	echo '<div class="window-modal-bg">
	<div id="window-modal-wrap">
		<button type="button" class="close-window-modal">
			<span class="tb-close-icon"></span>
		</button>
		<div class="hm-window">
			<h3>Help menu: ';
			echo get_admin_page_title();
			echo '</h3>
			<div class="hm-tabs-wrap">
				<ul class="tabs">
					<span>Tabs</span>
					<li><a href="#tab1" class="show-tab-name">New tab</a></li>
					<a href="#">+ Create a new tab</a>
					<span>Sidebar</span>
					<li><a href="#tab2">Sidebar</a></li>
				</ul>
				<div class="tab-container">
					<div id="tab1" class="tab-content">
						<form id="form-for-tab">
							<input type="text" name="title" placeholder="Name of tab" id="tabs_title">
							<input type="text" name="screen_id"  id="screen_id" style ="display:none;" value ="';
							echo get_current_screen()->id;
							echo'">

							';
								wp_editor('', 'create_tabs', array(
									'wpautop'       => 1,
									'media_buttons' => 0,
									'textarea_name' => 'tabs_content',
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
						<input name="cansel" type="button" class="button button-large cansel-tab" value="Cancel">
						<input name="save_tab" type="submit" class="button button-primary button-large" value="Save">
					</div>
					</form>
					</div>
					<div id="tab2" class="tab-content">
					<h4>SIDEBAR</h4>
					<form id="form-for-sidebar">';
					wp_editor('', 'create_sidebar', array(
									'wpautop'       => 1,
									'media_buttons' => 0,
									'textarea_name' => 'create_sidebar',
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
					<input name="cansel" type="button" class="button button-large cansel-tab"" value="Cancel">
					<input name="save" type="submit" class="button button-primary button-large"value="Save">
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
