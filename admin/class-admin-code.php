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
	 * Name of the plugin
	 * @var string
	 */
	private $domain;

    /**
	 * Options getter of the plugin
	 * @var string
	 */
    private $options_get;
    
    /**
	 * Options getter of the plugin
	 * @var string
	 */
    private $checkbox_get;

    /**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  string $
	 * @param  string $
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name   = $plugin_name;
		$this->version       = $version;
        $this->domain        = 'expert-help';
        $this->options_get   = $this->options_get;
        $this->checkbox_get  = $this->checkbox_get;

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
        // for js-code-editor init
		wp_enqueue_script( $this->plugin_name . '-admin-script', plugin_dir_url( __FILE__ ) . 'js/expert-help-admin.js', array(), $this->version, 'all' );

    }

    /**
     * Called from loader \Core
     * 
     * @since 1.0.0
     * @return HTML
     */
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

        $options_get = ( empty( get_option( $opt )[ $fld ] ) ) 
                      ? '' : get_option( $opt )[ $fld ];

            return esc_attr( $options_get );
    }

    /**
     * get_option('general_options')['workroom_uri'],
     */
    public function checkbox_get( $opt, $fld ){

        $checkbox_get = ( empty( get_option( $opt )[ $fld ] ) ) 
                      ? 0 : get_option( $opt )[ $fld ];

            return esc_attr( $checkbox_get );
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
        
        /* ///// second tab ///// */
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
            '<span class="eh-caution">'. esc_html__( 'Special field', $this->domain ) . '</span>',
            [ $this, 'expert_help_textinput' ],
            'extra_options',
            'extra_options',
            array( 
                'label_for'   => 'special_extra', 
                'name'        => 'special_extra', 
                'value'       => $this->options_get( 'extra_options', 'special_extra'),
                'option_name' => 'extra_options',
                'show_link'   => false
            )
        );
        add_settings_field(
            'radio_extra', 					
            esc_html__( 'Use Checkbox', $this->domain ),  					
            [ $this, 'expert_help_radio' ],
            'extra_options',
            'extra_options',
            array( 
                'label_for'   => 'radio_extra', 
                'name'        => 'radio_extra', 
                'value'       => $this->checkbox_get( 'extra_options', 'radio_extra'),
                'option_name' => 'extra_options',
                'description' => esc_html__( 'unassigned', $this->domain ),
                'checked'     => ( 0 != $this->checkbox_get( 'extra_options', 'radio_extra') )
                                    ? 'checked' : ''
            )
        );

        /* ///// second tab ///// */ 
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

    /* ////////// Section Callbacks ////////// */
    /**
     * description for the General Options page.
     */
    public function general_options_callback_a() {
        echo '<p>' . esc_html__( 'General Options and Settings', $this->domain ) . '</p>';
    } 
    // extra options description
    public function extra_options_callback() {
        echo '<p>' . esc_html__( 'Content for Extra page heading', $this->domain ) . '</p>';
    } 
    // extra options description
    public function more_options_callback() {
        echo '<p>' . esc_html__( 'Content for More page heading', $this->domain ) . '</p>';
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

    public function expert_help_editor( $args ) {
        printf(
            '<label for="%3$s">%3$s</label>
            <textarea id="%1$s" class="widefat textarea expert-help-textarea" name="%1$s[%2$s]" cols="40" rows="5">%4$s</textarea>
            </fieldset>',
                $args['option_name'],
                $args['name'],
                $args['label_for'],
                $args['value'],
            );
    }
    public function expert_help_radio($args) {
        printf(
            '<input type="hidden" name="%2$s[%1$s]" value="0">
            <input id="%1$s" type="checkbox" name="%2$s[%1$s]" value="1"  
            class="regular-checkbox" %5$s />
            <span>%4$s </span> v=%3$s',
                $args['name'],
                $args['option_name'],
                $args['value'],
                $args['description'],
                $args['checked']
            );
    }

    /* ////////// Admin specific methods ////////// */
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
