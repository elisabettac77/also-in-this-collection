<?php

namespace elicawebservices\wordpress\also_in_this_collection;

function init_taxonomies() {
    $taxonomy = [
        'labels' => [
            'name' => _x( 'Collection', 'Collection', 'also-in-this-collection' ),
            'singular_name' => _x( 'Collection', 'Collection', 'also-in-this-collection' ),
            'all_items' => __( 'All Collections', 'also-in-this-collection' ),
            'edit_item' => __( 'Edit Collection', 'also-in-this-collection' ),
            'view_item' => __( 'View Collection', 'also-in-this-collection' ),
            'update_item' => __( 'Update Collection', 'also-in-this-collection' ),
            'add_new_item' => __( 'Add New Collection', 'also-in-this-collection' ),
            'new_item_name' => __( 'New Collection Name', 'also-in-this-collection' ),
            'search_items' => __( 'Search Collections', 'also-in-this-collection' ),
            'popular_items' => __( 'Popular Collections', 'also-in-this-collection' ),
            'add_or_remove_items' => __( 'Add or remove collections', 'also-in-this-collection' ),
            'choose_from_most_used' => __( 'Choose from the most used collections', 'also-in-this-collection' ),
            'not_found' => __( 'No collections found', 'also-in-this-collection' )
        ],
        'show_admin_column' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite' => [ 'with_front' => false ]
    ];

    register_taxonomy( COLLECTION_TAXONOMY, null, $taxonomy );
    register_taxonomy_for_object_type( COLLECTION_TAXONOMY, 'post' );
}

add_action( 'init', __NAMESPACE__ . '\init_taxonomies' );
