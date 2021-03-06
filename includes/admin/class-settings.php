<?php

/**
 * Settings Class
 *
 * @since 1.1
 */
class weDocs_Settings {

    public function __construct() {
        $this->settings_api = new WeDevs_Settings_API();

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    /**
     * Initialize the settings
     *
     * @return void
     */
    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    /**
     * Register the admin settings menu
     *
     * @return void
     */
    function admin_menu() {
        add_submenu_page( 'wedocs', __( 'weDocs Settings', 'wedocs' ), __( 'Settings', 'wedocs' ), 'manage_options', 'wedocs-settings', array( $this, 'plugin_page' ) );
    }

    /**
     * Plugin settings sections
     *
     * @return array
     */
    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'wedocs_settings',
                'title' => __( 'Plugin Settings', 'wedocs' )
            )
        );

        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'wedocs_settings' => array(
                array(
                    'name'    => 'email',
                    'label'   => __( 'Email feedback', 'wedocs' ),
                    'desc'    => __( 'Enable Email feedback form', 'wedocs' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),
                array(
                    'name'              => 'email_to',
                    'label'             => __( 'Email Address', 'wedevs' ),
                    'desc'              => __( 'The email address where the feedbacks should sent to', 'wedevs' ),
                    'type'              => 'text',
                    'default'           => get_option( 'admin_email' ),
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'    => 'helpful',
                    'label'   => __( 'Helpful feedback', 'wedocs' ),
                    'desc'    => __( 'Enable helpful feedback links', 'wedocs' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),
                array(
                    'name'    => 'print',
                    'label'   => __( 'Print article', 'wedocs' ),
                    'desc'    => __( 'Enable article printing', 'wedocs' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),
            ),
        );

        return $settings_fields;
    }

    /**
     * The plguin page handler
     *
     * @return void
     */
    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        $this->scripts();

        echo '</div>';
    }

    /**
     * JS snippets
     *
     * @return void
     */
    public function scripts() {
        ?>
        <script type="text/javascript">
            jQuery(function($) {
                $('input[name="wedocs_settings[email]"]:checkbox').on( 'change', function() {

                    if ( $(this).is(':checked' ) ) {
                        $('tr.email_to').show();
                    } else {
                        $('tr.email_to').hide();
                    }

                }).change();
            });
        </script>
        <?php
    }

}
