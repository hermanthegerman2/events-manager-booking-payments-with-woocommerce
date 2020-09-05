<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class blz_eventwoo_settings_tab {

    public static function init(){
        $plugin = BLZ_EVENTWOO_PLUGIN;
        add_filter( "plugin_action_links_$plugin", __CLASS__ . '::settings_link' );
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_blz_eventwoo', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_blz_eventwoo', __CLASS__ . '::update_settings' );
    }
    
    /**
     * Add the link to the settings page on the Plugins screen
     *
     * @param array $links
     * @return array
     */
    public static function settings_link( $links ) {
        $settings_link = '<a href="admin.php?page=wc-settings&tab=settings_tab_blz_eventwoo">' . __( 'Einstellungen', 'eventwoo' ) . '</a>';
        array_push( $links, $settings_link );
        return $links;
    }

    /**
     * Add the Events settings tab to the WooCommerce Settings screen
     *
     * @param array $settings_tabs
     * @return array
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_blz_eventwoo'] = __( 'Veranstaltungen', 'eventwoo' );
        return $settings_tabs;
    }


    /**
    * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
    *
    * @uses woocommerce_admin_fields()
    * @uses self::get_settings()
    */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }


    /**
    * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
    *
    * @uses woocommerce_update_options()
    * @uses self::get_settings()
    */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }


    /**
     * Get all the settings for this plugin to generate the Settings Page in WooCommerce.
     * @see woocommerce_admin_fields() function.
     * @return array Array of settings. 
     */
    public static function get_settings() {
        $settings = array(
            'blz_eventwoo_booking_recommendation' => array(
                'name' => __( 'Empfehlungen', 'eventwoo' ),
                'type' => 'title',
                'desc' => __( 'Für die Bezahlung von Veranstaltungen ist es derzeit erforderlich, dass die Benutzer eingeloggt sind. Wir empfehlen daher, die Option Gastbuchungen zulassen (in Veranstaltungen -> Einstellungen -> Buchungen -> Allgemeine Optionen) auf Nr. <br/> Wir empfehlen außerdem, die Registrierung von Benutzern zuzulassen (in Einstellungen -> Allgemein -> Mitgliedschaft).', 'eventwoo' ),
                'id'   => 'blz_eventwoo_booking_recommendation',
            ),
            'section_title_events_page' => array(
                'name'     => __( 'Einstellungen der Ereignisseite', 'eventwoo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'blz_eventwoo_title'
            ),
            'blz_eventwoo_product_added_message' => array(
                'name' => __( 'Nachricht zum Produkt hinzugefügt', 'eventwoo' ),
                'type' => 'textarea',
                'desc' => __( 'Die Nachricht, die dem Benutzer angezeigt wird, wenn er eine Buchung auf der Veranstaltungsseite vornimmt', 'eventwoo' ),
                'id'   => 'blz_eventwoo_product_added_message',
                'default' => 'Sie haben eine ausstehende Buchung für diese Veranstaltung, wir haben Ihrem Warenkorb eine Veranstaltungsbuchung hinzugefügt.',
            ),
            'blz_eventwoo_product_added_link_to_cart' => array(
                'name' => __( 'Link zur Warenkorb-Nachricht', 'eventwoo' ),
                'type' => 'textarea',
                'desc' => __( 'Der Text, der auf dem Warenkorb-Link angezeigt wird, wenn sie eine Buchung auf der Veranstaltungsseite vornehmen', 'eventwoo' ),
                'id'   => 'blz_eventwoo_product_added_link_to_cart',
                'default' => 'Bitte gehen Sie zur Kasse, wenn Sie bereit sind.',
            ),
            'section_end_events_page' => array(
                'type' => 'sectionend',
                'id' => 'blz_eventwoo_section_end_events_page'
            ),

            'section_title_events_cart' => array(
                'name'     => __( 'Warenkorb-Einstellungen', 'eventwoo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'blz_eventwoo_events_cart_title'
            ),
            'blz_eventwoo_hide_product_name_in_cart' => array(
                'name' => __( 'Produktname im Warenkorb ausblenden', 'eventwoo' ),
                'type' => 'checkbox',
                'desc' => __( 'Dadurch wird der Produktname auf der Warenkorbseite und im Miniwagen ausgeblendet.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_hide_product_name_in_cart'
            ),
            'blz_eventwoo_disable_spaces_if_logged_out' => array(
                'name' => __( 'Deaktivieren Sie die Dropdown-Listenfelder Spaces, wenn Sie abgemeldet sind', 'eventwoo' ),
                'type' => 'checkbox',
                'desc' => __( 'Dadurch werden die Dropdown-Listenfelder Spaces deaktiviert, wenn der Besucher nicht angemeldet ist.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_disable_spaces_if_logged_out'
            ),
            'section_end_events_cart' => array(
                'type' => 'sectionend',
                'id' => 'blz_eventwoo_section_end_events_cart'
            ),

            'section_title_events_order' => array(
                'name'     => __( 'Auftrags-Einstellungen', 'eventwoo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'blz_eventwoo_order_title'
            ),
            'blz_eventwoo_set_event_orders_completed' => array(
                'name' => __( 'Aufträge auf erledigt setzen, wenn bezahlt', 'eventwoo' ),
                'type' => 'checkbox',
                'desc' => __( 'Dadurch wird der Status Verarbeitungsauftrag umgangen. Nicht empfehlenswert, wenn Sie auch physische Produkte verkaufen.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_set_event_orders_completed'
            ),
            'section_title_end_events_order' => array(
                'type' => 'sectionend',
                'id' => 'blz_eventwoo_section_title_events_cart'
            ),

            'blz_eventwoo_registration_section' => array(
                'name'     => __( 'Nachricht zur Registrierung', 'eventwoo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'blz_eventwoo_registration_section'
            ),
            'blz_eventwoo_display_registered_message_on_event_page' => array(
                'name' => __( 'Registrierungsnachricht anzeigen', 'eventwoo' ),
                'type' => 'checkbox',
                'desc' => __( 'Zeigen Sie die Meldung "Konto erstellt" auf der Ereignisseite an, wenn Sie sich gerade registriert haben.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_display_registered_message_on_event_page'
            ),
            'blz_eventwoo_registered_message' => array(
                'name' => __( 'Registrierte Nachricht', 'eventwoo' ),
                'type' => 'textarea',
                'desc' => __( 'Die Meldung, die angezeigt wird, wenn sich der Benutzer auf der Ereignisseite gerade registriert hat.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_registered_message',
                'default' => 'Ihr Konto wurde erstellt und wir haben Sie eingeloggt. Wir haben Ihnen eine E-Mail mit Ihrem Benutzernamen und Passwort geschickt.',
            ),

            'section_end_registration' => array(
                 'type' => 'sectionend',
                 'id' => 'blz_eventwoo_section_end_registration'
            )
        );
        return apply_filters( 'blz_eventwoo_settings_tab_settings', $settings );
    }


}

blz_eventwoo_settings_tab::init();
