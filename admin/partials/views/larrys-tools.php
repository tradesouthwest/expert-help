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
         * Leaving i18n English. 
         * May not be suitable for client view.
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
            
            echo '<em>' . esc_attr( $da ) . '</em><br>';
            ?>
            <?php
            echo '<hr>'; 
            include plugin_dir_path( __FILE__ ) . 'docs/index.html'; 
            ?>
            </td>
        </tr>
        </tbody>
    </table>