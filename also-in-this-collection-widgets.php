<?php

namespace elicawebservices\wordpress\also_in_this_collection;

use \WP_Widget;

class CollectionWidget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'alsointhiscollection_widget',
            __( 'Also In This Collection', 'also-in-this-collection' ),
            [ 'description' => __( 'Feature your collection anywhere that a widget can go.', 'also-in-this-collection' ) ]
        );
    }

    public function widget( $widget, $fields ) {
        $ffields = apply_filters( 'alsointhiscollection_widget_fields', $fields, $widget );

        $config = [
            'collection-slug' => $ffields['collection-slug'],
            'use-frame' => $ffields['collection-use-frame'],
            'frame-width' => $ffields['collection-frame-width'],
            'sort-order' => $ffields['collection-sort-order'],
            'title-wrap' => $ffields['collection-title-wrap'],
            'title-template' => $ffields['collection-title-template'],
            'hide-collection-listing' => $ffields['collection-hide-listing'],
            'always-link-collection' => $ffields['collection-always-link'],
        ];

        ob_start();
        displayCollection( $config );
        $collectionlisting = ob_get_contents();
        ob_end_clean();

        include 'views/widget-view.php';
    }

    public function form( $fields ) {
        $collectionslug = $fields['collection-slug'];
        $useframe = $fields['collection-use-frame'];
        $framewidth = $fields['collection-frame-width'];
        $sortorder = $fields['collection-sort-order'];
        $titlewrap = $fields['collection-title-wrap'];
        $titletemplate = $fields['collection-title-template'];
        $hidecollectionlisting = $fields['collection-hide-listing'];
        $alwayslinkcollection = $fields['collection-always-link'];

        $collections = get_terms( COLLECTION_TAXONOMY );

        include 'views/admin/widget-form.php';
    }

    public function update( $new_fields, $old_fields ) {
        $fields = [];
        $fields['collection-slug'] = !empty( $new_fields['collection-slug'] ) ? sanitize_text_field( $new_fields['collection-slug'] ) : '';
        $fields['collection-use-frame'] = !empty( $new_fields['collection-use-frame'] ) ? sanitize_text_field( $new_fields['collection-use-frame'] ) : '';
        $fields['collection-frame-width'] = !empty( $new_fields['collection-frame-width'] ) ? sanitize_text_field( $new_fields['collection-frame-width'] ) : '';
        $fields['collection-sort-order'] = !empty( $new_fields['collection-sort-order'] ) ? sanitize_text_field( $new_fields['collection-sort-order'] ) : '';
        $fields['collection-title-wrap'] = !empty( $new_fields['collection-title-wrap'] ) ? sanitize_text_field( $new_fields['collection-title-wrap'] ) : '';
        $fields['collection-title-template'] = !empty( $new_fields['collection-title-template'] ) ? sanitize_text_field( $new_fields['collection-title-template'] ) : '';
        $fields['collection-hide-listing'] = !empty( $new_fields['collection-hide-listing'] ) ? sanitize_text_field( $new_fields['collection-hide-listing'] ) : '';
        $fields['collection-always-link'] = !empty( $new_fields['collection-always-link'] ) ? sanitize_text_field( $new_fields['collection-always-link'] ) : '';

        return $fields;
    }
}

function widgets_init() {
    register_widget( CollectionWidget::class );
}

add_action( 'widgets_init', __NAMESPACE__ . '\widgets_init' );
