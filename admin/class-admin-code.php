<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/tradesouthwest
 * @since      1.0.0
 *
 * @package    Expert_Help
 * @subpackage Expert_Help/admin
 */
namespace Expert_Help;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Expert_Help
 * @subpackage Expert_Help/admin
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
class Admin_Code {

	/**
	 * Name of the plugin
	 * @var string
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
	 * The settings fields.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $settings    The array of settings fields.
	 */
	//private $settings;

    /**
	 * The settings option name.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $options The option name.
	 */
	private $options_slug;


    /**
	 * Name of the plugin
	 * @var string
	 */
	private $domain;

    private $options_get;

    /**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  string $
	 * @param  string $
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name  = $plugin_name;
		$this->version      = $version;
        $this->domain       = 'expert-help';
        $this->options_slug = 'expert_help';
        $this->options_get  = $this->options_get;

        add_action( 'admin_menu', [ $this, 'add_menu' ] );   
        add_action( 'admin_init', [ $this, 'initialize_options' ] );
        //add_action( 'expert_help_basic_info', [ $this, 'basic_debug_info' ]);
    }
	
    /**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * The Expert_Help_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name . '-admin-style', plugin_dir_url( __FILE__ ) . 'css/expert-help-admin.css', array(), $this->version, 'all' );

	}
    /**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * The Expert_Help_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name . '-admin-script', plugin_dir_url( __FILE__ ) . 'css/expert-help-admin.js', array(), $this->version, 'all' );
    }

    public function basic_debug_info( ) {
        global $wp_version, $wpdb;
        $html = true;
        $data = array(
            'WordPress Version'     => $wp_version,
            'PHP Version'           => phpversion(),
            'MySQL Version'         => $wpdb->db_version(),
            'WP_DEBUG'              => ( WP_DEBUG === true ) ?  
                                    'Enabled' : 'Disabled',
        );

        if ( $html ) {
            $html = '<ol>';
            foreach ( $data as $what_v => $v ) {
        $html .= '<li style="display: inline;"><strong>' . $what_v . '</strong>: ' . $v . ' </li>';
            }
            $html .= '</ol>';
            $html .= '<a href="https://tools.pingdom.com/" title="tools" target="_blank">Site speed tool <span title="opens in new window">[^]</span></a>';
        }

        echo $html;
    } 

    /**
     * Add the menu page.
     *
     * @since    1.0.0
     * string $page_title, string $menu_title, string $capability, 
     * string $menu_slug, callable $callback = ”, 
     * string $icon_url = ”, int|float $position = null ): string
     */
    public function add_menu(){
        add_menu_page(
            __( 'Expert Help', $this->domain ),
            __( 'ExpertHelp', $this->domain ),
            'manage_options',
            'expert-help',            
            [ $this, 'plugin_settings_page' ],
            'dashicons-plus',
            99
        );

    }

    /**
     * get_option('general_options')['workroom_uri'],
     */
    public function options_get( $opt, $fld ){

        if( false == get_option( 'expert_help' ) ) {
            add_option( 'expert_help' );
        }

        $options_get = ( empty( get_option( $opt )[ $fld ] ) ) 
                      ? '' : get_option( $opt )[ $fld ];

            return esc_attr( $options_get );
    }
    /**
     * Initializes the Sections, Field, and Settings
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initialize_options() {

        /* section
         * $id, $title, $callback, $page
         */  
        add_settings_section(
            'general_options',
            '',          
            [ $this, 'general_options_callback_a' ],
            'general_options' 
        );
    
        /* @option_name[array_key] = $option[$arg]
         * $id, $label, $callback, $page, $section, $args
         */ 
        add_settings_field(
            'workroom_uri', 					
            'Workroom Link',  					
            [ $this, 'expert_help_textinput' ],
            'general_options',
            'general_options',
            array( 
                'label_for'   => 'workroom_uri', 
                'name'        => 'workroom_uri', 
                'value'       => $this->options_get(
                                    'general_options',
                                    'workroom_uri'),
                'option_name' => 'general_options',
                'show_link'   => true
            )
        );
        add_settings_field(
            'referoo_link', 					
            'Referoo Link',  					
            [ $this, 'expert_help_textinput' ],
            'general_options',
            'general_options',
            array( 
                'label_for'   => 'referoo_link', 
                'name'        => 'referoo_link', 
                'value'       => $this->options_get(
                                    'general_options',
                                    'referoo_link'),
                'option_name' => 'general_options',
                'show_link'   => true
            )
        );
        add_settings_field(
            'instructions_uri', 					
            __( 'Link to instructions', $this->domain ),  					
            [ $this, 'expert_help_textinput' ],
            'general_options',
            'general_options',
            array( 
                'label_for'   => 'instructions_uri', 
                'name'        => 'instructions_uri', 
                'value'       => $this->options_get(
                                    'general_options',
                                    'instructions_uri'),
                'option_name' => 'general_options',
                'show_link'   => true
            )
        );
	    register_setting( 'general_options',
		    'general_options'
	    );

        /* 
         * second tab 
        */
        /* section
         * $id, $title, $callback, $page
         */  
        add_settings_section(
            'extra_options',
            '',          
            [ $this, 'extra_options_callback' ],
            'extra_options' 
        );
        /* field
         * $id, $label, $callback, $page, $section, $args
         */ 
        add_settings_field(
            'special_extra', 					
            __( 'Special field', $this->domain ),  					
            [ $this, 'expert_help_textinput' ],
            'extra_options',
            'extra_options',
            array( 
                'label_for'   => 'special_extra', 
                'name'        => 'special_extra', 
                'value'       => $this->options_get(
                                    'extra_options',
                                    'special_extra'),
                'option_name' => 'extra_options',
                'show_link'   => false
            )
        );
	    register_setting( 'extra_options',
		    'extra_options'
	    );
    }

    /**
     * Display the plugin settings page if the user has sufficient privileges.
     *
     * @since    1.0.0
     */
    public function plugin_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'Sorry! You don\'t have sufficient permissions to access this page.', $this->domain ) );
        }

        include( sprintf( "%s/partials/expert-help-admin-display.php", 
			dirname( __FILE__ ) ) 
		);
    }

    /**
     * Section Callbacks
     */

    /**
     * description for the General Options page.
     */
    public function general_options_callback_a() {
        echo '<p>' . esc_html__( 'General Options and Settings', $this->domain ) . '</p>';
    } 
    // extra options description
    public function extra_options_callback() {
        echo '<p>' . esc_html__( 'Content for this page heading', $this->domain ) . '</p>';
    } 
    // extra options description
    public function more_options_callback() {
        echo '<p>' . esc_html__( 'Content for this page heading', $this->domain ) . '</p>';
    } 

    /* ////////// FIELDs ////////// */
     /**
     * Path to input field render html.
     * Can be use as text, uri, number.
     */
    public function expert_help_textinput( $args ){
        if ( !$args['show_link'] || $args['show_link'] === '' ) {
        printf(
            '<input name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text">',
            $args['option_name'],
            $args['name'],
            $args['label_for'],
            $args['value'] 
        );
        } else {
            printf(
                '<input name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text">',
                $args['option_name'],
                $args['name'],
                $args['label_for'],
                $args['value'] 
            );
            printf(
                '&nbsp;<a href="%1$s" title="%2$s" target="%3$s">%1$s <span title="opens in new tab">&#x2197;</span></a>',
                $args['value'],
                $args['name'],
                esc_attr( '_blank' )
                 
            );
        }
    }

    /**
     * Display the date this plugin was activated, last.
     * 
     * @since 1.0.0
     * @param string $da Option added in \Activate
     */
    public function date_plugin_activated_field() {
        $da = ( empty ( get_option( 'expert_help_date_plugin_activated' ) ) ) 
                ? '' : get_option( 'expert_help_date_plugin_activated' );
        echo esc_attr( $da );
    }

    /**
     * validate and sanitize text input
     * 
     * @since 1.0.0
     */
    public function validate_input_general( $input ) {
        // The array in which the new, sanitized input will go
        $new_input = array();
        
        // Read the company name from the array of options
        $val = $input['name'];
        
        // Sanitize the information
        $val = strip_tags( stripslashes( $val ) );
        $new_input['name'] = sanitize_text_field( $val );
        
        return $new_input;
        
    }
}