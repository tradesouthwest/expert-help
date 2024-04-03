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
	global $active_tab;
				if( isset( $_GET[ 'tab' ] ) ) {
					$active_tab = $_GET[ 'tab' ];
				} else if( $active_tab == 'extra_options' ) {
					$acitve_tab = 'extra_options';
				} else if( $active_tab == 'more_options' ) {
					$active_tab == 'more_options';
				} else {
					$active_tab = 'general_options';
				} // end if/else

			?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=expert-help&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?> ">
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
            }
            elseif( $active_tab == 'extra_options' ) {
				settings_fields( 'extra_options' );
                do_settings_sections( 'extra_options' );
            }
            else { 
				/* There are no settings sections or options registered with expert_help
				 * base release. Please envoke and register options in \Admin_Code as more_options
				 */ 
			?>

				<p><?php esc_html_e( 'This section edited in file. Not settings options.', $this->domain ); ?></p>

				<table class="form-table" role="presentation">
					<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'Info', $this->domain ); ?></th>
						<td>
					<?php
					global $wpdb;

					$postmeta_count = $wpdb->get_var("SELECT COUNT(*) 
										FROM $wpdb->postmeta");
					$options_count = $wpdb->get_var("SELECT COUNT(*) 
										FROM $wpdb->options");

					/* Show number of entries in table.
					 * Leaving i18n English 
					 */
					echo 'Number of entries in wp_postmeta table: ' 
						. esc_html( $postmeta_count ) . "<br>";
					echo 'Number of entries in wp_options table: ' 
						. esc_html( $options_count );
					
					//clean query
					$postmeta_count = $options_count = null; 		
					?>
						<p><?php 
						do_action( 'expert_help_basic_info' );
						?></p>
						</td>
					</tr>

					<tr>
						<th scope="row"><?php esc_html_e( 'Date plugin last activated', $this->domain ); ?></th>
						<td>
						<?php 
						$da = ( empty ( get_option( 'expert_help_date_plugin_activated' ) ) ) 
								? '' : get_option( 'expert_help_date_plugin_activated' );
						
						echo '<em>' . esc_attr( $da ) . '</em>';
						?>
						</td>
					</tr>
					</tbody>
				</table>
			
            <?php 
			} ?>
			<?php
        		submit_button();

        ?>
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

