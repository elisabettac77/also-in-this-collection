<?php

namespace elicawebservices\wordpress\also_in_this_collection;

const COLLECTION_SETTINGS_PAGE = 'also-in-this-collection-settings';

class AlsoInThisCollectionAdmin {
    private static $registeredfields = [];

    // To be hooked into admin_init
    static function admin_init() {
        register_setting( COLLECTION_SLUG, COLLECTION_SLUG, [ __CLASS__, 'validateFields' ] );
        self::addSection( 'general-settings-section', __( 'General Settings', 'also-in-this-collection' ) );

        // Add theme options here
        self::addField( 'select', 'title-wrap', __( 'Title heading level', 'also-in-this-collection' ), [ 'h1', 'h2', 'h3', 'span' ], [ 'h1', 'h2', 'h3', 'span' ] );
        self::addField( 'select', 'title-template', __( 'Title template', 'also-in-this-collection' ), [ 'also-in', 'ordinal', 'none' ], [ 'Also In Collection Name', 'This is part n of m in Collection Name', 'No Title' ] );
        self::addField( 'radiobutton', 'insert-in-content', __( 'Automatically display collection listing on post?', 'also-in-this-collection' ), [ '', 'append', 'prepend' ], [ 'No', 'After Content', 'Before Content' ] );
        self::addField( 'radiobutton', 'archive-sort-order', __( 'Order of collection display', 'also-in-this-collection' ), [ '', 'asc', 'desc' ], [ 'Default', 'Oldest First', 'Newest First' ] );
        self::addField( 'textfield', 'window-collection-listing', __( 'Window collection listing display', 'also-in-this-collection' ), '^[[:digit:]]*$', 'number of surrounding posts' );
        self::addField( 'checkbox', 'hide-collection-listing', __( 'Do not display collection listing', 'also-in-this-collection' ), 'yes', 'If checked, the collection listing will not be shown.' );
        self::addField( 'checkbox', 'always-link-collection', __( 'Always show collection link', 'also-in-this-collection' ), 'yes', 'If unchecked, a link to the collection will only be shown when windowing is active.' );
    }

    // To be hooked into admin_menu.
    static function admin_menu() {
        $pagehook = add_options_page(
            __( 'Also In This Collection settings', 'also-in-this-collection' ),
            __( 'Also In This Collection', 'also-in-this-collection' ),
            'manage_options',
            COLLECTION_SETTINGS_PAGE,
            [ __CLASS__, 'showPluginSettings' ]
        );
    }

    // Use this for adding sections to the admin page.
    static function addSection( $id, $title ) {
        add_settings_section( $id, $title,[ __CLASS__, 'sectionHeader' ], COLLECTION_SETTINGS_PAGE );
    }

    // Use this for adding theme options to the admin page. See code below for available types (renderers).
    static function addField( $type, $id, $title, $value = 1, $label = null, $args = [], $section = 'general-settings-section' ) {
        self::_addFieldFilter( $type, $id, $title, $value, $args );
        add_settings_field( $id, $title, [ __CLASS__, $type . 'Renderer' ], COLLECTION_SETTINGS_PAGE, $section, compact( 'type', 'id', 'value', 'label', 'args', 'section' ) );
    }

    // Callback for loading the admin view.
    static function showPluginSettings() {
        include 'views/admin/settings.php';
    }

    // Callback for displaying a section header.
    static function sectionHeader( $args ) {

    }

    // Renders a textfield.
    static function textfieldRenderer( $args ) {
        $setting = config( $args['id'] );

        $id = COLLECTION_SLUG . '_' . $args['id'];
        $name = COLLECTION_SLUG . "[{$args['id']}]";
        $value = $setting;
        $label = $args[ 'label' ];

        self::_fieldRenderer( 'textfield', compact( 'id', 'name', 'value', 'label' ) );
    }

    // Renders a checkbox. If multiple values are provided, an option group will be rendered.
    static function checkboxRenderer( $args ) {
        $multivalue = is_array( $args['value'] );
        $settings = (array) config( $args['id'] );

        $id = COLLECTION_SLUG . '_' . $args['id'];
        $name = COLLECTION_SLUG . "[{$args['id']}]" . ( $multivalue ? '[]' : '' );
        $values = array_map( 'esc_attr', (array) $args['value'] );
        $labels = (array) $args[ 'label' ];
        $checked = [];

        foreach( $settings as $index => $setting )
            $checked[$index] = checked( 1, $setting ? 1 : 0, false );

        self::_fieldRenderer( 'checkbox', compact( 'id', 'name', 'values', 'labels', 'checked' ) );
    }

    // Renders a radiobox. More than one value should be provided as an option group.
    static function radiobuttonRenderer( $args ) {
        $setting = config( $args['id'] );

        $id = COLLECTION_SLUG . '_' . $args['id'];
        $name = COLLECTION_SLUG . "[{$args['id']}]";
        $values = array_map( 'esc_attr', (array) $args['value'] );
        $labels = (array) $args[ 'label' ];
        $checked = [];

        foreach( $values as $index => $value )
            $checked[$index] = checked( $value, $setting, false );

        self::_fieldRenderer( 'radiobutton', compact( 'id', 'name', 'values', 'labels', 'checked' ) );
    }

    // Renders a radiobox. More than one value should be provided as an option group.
    static function selectRenderer( $args ) {
        $setting = config( $args['id'] );

        $id = COLLECTION_SLUG . '_' . $args['id'];
        $name = COLLECTION_SLUG . "[{$args['id']}]";
        $values = array_map( 'esc_attr', (array) $args['value'] );
        $labels = (array) $args[ 'label' ];
        $selected = [];

        foreach( $values as $index => $value )
            $selected[$index] = selected( $value, $setting, false );

        self::_fieldRenderer( 'select', compact( 'id', 'name', 'values', 'labels', 'selected' ) );
    }

    // Validates raw input from option submission.
    static function validateFields( $fields ) {
        $validated = [];

        foreach( $fields as $field => $value ) {
            if( ! $sanction = isset( self::$registeredfields[ $field ] ) ? self::$registeredfields[ $field ] : false ) {
                continue;
            }

            $valid = true;
            if( !empty( $sanction['args']['raw'] ) ) {
                ;// allow raw
            }
            elseif( is_scalar( $value ) ) {
                $value = sanitize_text_field( $value );
            }
            elseif( is_array( $value ) ) {
                $value = array_map( 'sanitize_text_field', $value );
            }

            switch( $sanction['type'] ) {
                case 'textfield' :

                if( $sanction['value'] && ! preg_match( "/{$sanction['value']}/", $value ) ) {
                    add_settings_error( COLLECTION_SLUG, 'invalid-value', "'{$sanction['title']}' <strong>Invalid input</strong>" );
                    $valid = false;
                    break;
                }
                break;

                case 'select':
                case 'checkbox' :
                case 'radiobox' :

                if( is_scalar( $sanction['value'] ) && $value != $sanction['value'] ) {
                    $valid = false;
                    add_settings_error( COLLECTION_SLUG, 'invalid-value', "'{$sanction['title']}' <strong>Invalid input</strong>" );
                }
                elseif( is_array( $sanction['value'] ) && array_diff( (array) $value, $sanction['value'] ) ) {
                    $valid = false;
                    add_settings_error( COLLECTION_SLUG, 'invalid-value', "'{$sanction['title']}' <strong>Invalid input</strong>" );
                }

                default :
            }

            if( $valid ) {
                $validated[ $field ] = $value;
            }
        }

        return apply_filters( 'alsointhiscollection_validate_fields', $validated, $fields );
    }

    // Adds option to sanctioned list. Should be called when a field is added.
    private static function _addFieldFilter( $type, $id, $title, $value, $args ) {
        self::$registeredfields[ $id ] = compact( 'type', 'title', 'value', 'args' );
    }

    // Delegates UI rendering to the template fragment loader.
    private static function _fieldRenderer( $type, $params ) {
    $id = isset($params['id']) ? $params['id'] : '';
    $name = isset($params['name']) ? $params['name'] : '';
    $value = isset($params['value']) ? $params['value'] : '';
    $label = isset($params['label']) ? $params['label'] : '';
    $values = isset($params['values']) ? $params['values'] : [];
    $labels = isset($params['labels']) ? $params['labels'] : [];
    $checked = isset($params['checked']) ? $params['checked'] : [];
    $selected = isset($params['selected']) ? $params['selected'] : [];
    
    include "views/admin/optionsfield-{$type}.php";
}
}

// Register admin functionality.
add_action( 'admin_menu', [ AlsoInThisCollectionAdmin::class, 'admin_menu' ] );
add_action( 'admin_init', [ AlsoInThisCollectionAdmin::class, 'admin_init' ] );
