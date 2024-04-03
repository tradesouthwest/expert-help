<?php

// Step 1: Create the Upload Form
function expert_help_display_upload_form() {
    ?>
    <form method="post" enctype="multipart/form-data" action="options.php">
        <label for="file">Upload Text File:</label>
        <input type="file" name="file" id="file">
        <input type="submit" name="textupload_submit" value="Upload File">
    </form>
    <?php
}

// Step 2: Handle File Upload
function expert_help_handle_file_upload() {
    if (isset($_POST['textupload_submit'])) {
        $uploaded_file = $_FILES['file'];
        
        // Check if file is uploaded successfully
        if ($uploaded_file['error'] === UPLOAD_ERR_OK) {
            $upload_dir = wp_upload_dir(); // Get uploads directory
            $file_path = $upload_dir['path'] . '/' . $uploaded_file['name'];
            
            // Move the uploaded file to the uploads folder
            move_uploaded_file($uploaded_file['tmp_name'], $file_path);
            
            // Save the file path in the database for future reference
            update_option('expert_help_uploaded_file_path', $file_path);
        }
    }
}

// Step 3: Display the Uploaded File
function expert_help_display_uploaded_file() {
    $file_path = get_option('expert_help_uploaded_file_path');
    
    if ($file_path) {
        $file_content = file_get_contents($file_path);
        echo '<pre>' . $file_content . '</pre>';
    }
}

// Hook functions to appropriate actions
add_action('admin_menu', 'expert_help_display_upload_form');
add_action('admin_init', 'expert_help_handle_file_upload');
add_action('admin_menu', 'expert_help_display_uploaded_file');
add_action( 'expert_help_helptext', 'expert_help_render_helptext' );
function expert_help_render_helptext(){

ob_start(); ?>
<div class="wrap">
    <hr>
    <?php expert_help_display_uploaded_file(); ?>
    <br><hr>
<?php expert_help_display_uploaded_file(); ?>
<br><hr>
<?php expert_help_display_upload_form(); ?>
</div>

<?php
echo ob_get_clean();

}