<?php

namespace Expert_Help;

/**
 * The Menu handle class - Add Menu item in wordpress admin
 * 
 * @return void
 */

class Menu {

    function __construct() {
        
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    public function admin_menu() {

        $parent_slug = 'expert-help';
        $capability = 'manage_options';

        add_menu_page( __( 'Expert Help Options', 'expert-help' ), __( 'DevNahid', 'expert-help' ), $capability, $parent_slug, [ $this, 'plugin_page'], 'dashicons-welcome-learn-more', 79 );

        add_submenu_page( $parent_slug, __( 'Add Help Tool', 'expert-help' ), __( 'Add Book', 'expert-help' ), $capability, $parent_slug, [ $this, 'plugin_page' ] );

        add_submenu_page( $parent_slug, __( 'Settings', 'expert-help' ), __( 'Settings', 'expert-help' ), $capability, 'add_book', [ $this, 'settings_page' ] );

    }

    public function plugin_page() {
        echo 'Add New Expert Tool';
    }
    public function settings_page() {
        echo 'Settings Page';
    }

 }