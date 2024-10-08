<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/treadesouthwest
 * @since      1.0.0
 *
 * @package    Expert_Help
 * @subpackage Expert_Help/admin/partials
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! current_user_can('manage_options')) {
	return;
}

        ?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<!-- Add the icon to the page -->
			<div id="icon-themes" class="icon32"></div>
			<h2><?php echo esc_html__( 'Expert Help', $this->domain ); ?></h2>

			<!-- make a call to the WordPress function for rendering errors when settings are saved. -->
			<?php settings_errors(); ?>

			<?php
			$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] 
						: 'general_options'; 
			?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=expert-help&tab=general_options" 
				class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?> ">
                <?php esc_html_e( 'General', $this->domain ); ?></a>
				<a href="?page=expert-help&tab=extra_options" class="nav-tab <?php echo $active_tab == 'extra_options' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Extra', $this->domain ); ?></a>
				<a href="?page=expert-help&tab=more_options" class="nav-tab <?php echo $active_tab == 'more_options' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'More', $this->domain ); ?></a>
			</h2>

			<form method="post" action="options.php">

            <?php
            if( $active_tab == 'general_options' ) {
                settings_fields( 'general_options' );
                do_settings_sections( 'general_options' );
				submit_button();
            }
            elseif( $active_tab == 'extra_options' ) {
				settings_fields( 'extra_options' );
                do_settings_sections( 'extra_options' );
				submit_button();
            }
            else { 
				/* There are no settings sections or options registered with expert_help
				 * base release. Please envoke and register options in \Admin_Code as more_options
				 */
				include( sprintf( "%s/views/larrys-tools.php", 
				dirname( __FILE__ ) ) 
			);  
			} ?>
		
        </form>
        </div><!-- end .wrap -->
	<?php 
    /**
	 * Print jQuery script for tabbed navigation
	 * @return void
	 */

		// Very simple jQuery logic for the tabbed navigation.
		// Delete this function if you don't need it.
		// If you have other JS assets you may merge this there.
		?>
		<script>
		jQuery(document).ready(function($) {
			var headings = jQuery('.settings-container > h2, .settings-container > h3');
			var paragraphs  = jQuery('.settings-container > p');
			var tables      = jQuery('.settings-container > table');
			var triggers = jQuery('.settings-tabs a');
			var saving = jQuery('.submit #submit');

			triggers.each(function(i){
				triggers.eq(i).on('click', function(e){
					e.preventDefault();
					triggers.removeClass('nav-tab-active');
					headings.hide();
					paragraphs.hide();
					tables.hide();

					triggers.eq(i).addClass('nav-tab-active');
					headings.eq(i).show();
					paragraphs.eq(i).show();
					tables.eq(i).show();
				});
			})

			triggers.eq(0).click();
		});
		</script>
	<?php 
