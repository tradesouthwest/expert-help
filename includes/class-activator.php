<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/tradesouthwest
 * @since      1.0.0
 *
 * @package    Expert_Help
 * @subpackage Expert_Help/includes
 */
namespace Expert_Help;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Expert_Help
 * @subpackage Expert_Help/includes
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
class Activator {

	/**
	 * Sets otion to save activation datetime.
	 *
	 * Adds a start time when activated and then removes if deactivate is ran.
	 *
	 * @param string $timeact Time plugin is activated.
	 * @since    1.0.0
	 */
	public static function activate() {
		$format    = get_option('date_format');
		$timestamp = get_the_time();
		$timeact   = date_i18n($format, $timestamp, true);
		add_option( 'expert_help_date_plugin_activated' );
		update_option( 'expert_help_date_plugin_activated', $timeact );
	}

}
