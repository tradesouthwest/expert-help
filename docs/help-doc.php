<?php
// silence is purple
/*
    settings_fields($option_group);
    register_setting($option_group, $option_name, $sanitize_callback=“”);
    unregister_setting($option_group, $option_name, $sanitize_callback=“”);
    add_settings_section($id, $title, $callback, $page);
    add_settings_field($id, $title, $callback, $page, $section, $args = array());
    do_settings_sections($page)

    The parameters and what they do are listed next:

    $option_group – unique group name for option set
    $option_name – name of each option (more than one option in the same register_settings() function requires an array of options)
    $sanitize_callback=“” – section/field callback function to validate option data
    $id – unique ID for the section/field
    $title – the title of the section/field (displayed on options page)
    $callback – callback function to be executed
    $page – options page name (use __FILE__ if creating new options page)
    $section – ID of the settings section (needs to be the same as $id in add_settings_section)
    $args = array() – additional arguments

    function  setting_dropdown_fn() {
	$options = get_option('plugin_options');
	$items = array("Red", "Green", "Blue", "Orange", "White", "Violet", "Yellow");
	echo "<select id='drop_down1' name='plugin_options[dropdown1]'>";
	foreach($items as $item) {
		$selected = ($options['dropdown1']==$item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>";
    }
    function setting_textarea_fn() {
	$options = get_option('plugin_options');
	echo "<textarea id='plugin_textarea_string' name='plugin_options[text_area]' rows='7' cols='50' type='textarea'>{$options['text_area']}</textarea>";
    }
    function setting_string_fn() {
	$options = get_option('plugin_options');
	echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
    }
    function setting_pass_fn() {
	$options = get_option('plugin_options');
	echo "<input id='plugin_text_pass' name='plugin_options[pass_string]' size='40' type='password' value='{$options['pass_string']}' />";
    }
    function setting_chk1_fn() {
	$options = get_option('plugin_options');
	if($options['chkbox1']) { $checked = ' checked="checked" '; }
	echo "<input ".$checked." id='plugin_chk1' name='plugin_options[chkbox1]' type='checkbox' />";
    }
    function setting_radio_fn() {
	$options = get_option('plugin_options');
	$items = array("Square", "Triangle", "Circle");
	foreach($items as $item) {
		$checked = ($options['option_set1']==$item) ? ' checked="checked" ' : '';
		echo "<label><input ".$checked." value='$item' name='plugin_options[option_set1]' type='radio' /> $item</label><br />";
	}
    }

    // Step 1: Create the Upload Form
function display_upload_form() {
    ?>
    <form method="post" enctype="multipart/form-data">
        <label for="file">Upload Text File:</label>
        <input type="file" name="file" id="file">
        <input type="submit" name="submit" value="Upload File">
    </form>
    <?php
}
// Step 2: Handle File Upload
function handle_file_upload() {
    if (isset($_POST['submit'])) {
        $uploaded_file = $_FILES['file'];
        
        // Check if file is uploaded successfully
        if ($uploaded_file['error'] === UPLOAD_ERR_OK) {
            $upload_dir = wp_upload_dir(); // Get uploads directory
            $file_path = $upload_dir['path'] . '/' . $uploaded_file['name'];
            
            // Move the uploaded file to the uploads folder
            move_uploaded_file($uploaded_file['tmp_name'], $file_path);
            
            // Save the file path in the database for future reference
            update_option('uploaded_file_path', $file_path);
        }
    }
}
// Step 3: Display the Uploaded File
function display_uploaded_file() {
    $file_path = get_option('uploaded_file_path');
    
    if ($file_path) {
        $file_content = file_get_contents($file_path);
        echo '<pre>' . $file_content . '</pre>';
    }
}
// Hook functions to appropriate actions
add_action('admin_menu', 'display_upload_form');
add_action('admin_init', 'handle_file_upload');
add_action('admin_menu', 'display_uploaded_file');

*/