<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/tradesouthwest
 * @since      1.0.0
 *
 * @package    Expert_Help
 * @subpackage Expert_Help/includes
 */
namespace Expert_Help;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Expert_Help
 * @subpackage Expert_Help/includes
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
class Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option( 'expert_help_date_plugin_activated' );
		return false;
	}

}
