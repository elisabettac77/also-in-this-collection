<?php
/*
Plugin Name: Also In This Collection
Plugin URI: https://elica-webservices.it/
Description: Group related posts in a collection with a custom Collection taxonomy. and a list of all posts in the collection in your content.
Version: 1.0
Requires CP: 2.0
Requires PHP: 8.0
Tested up to: 2.4.1
Author: Elisabetta Carrara
Author URI: https://elica-webservices.it
Textdomain: also-in-this-collection
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if( also_in_this_collection_meets_requirements() ) {
	require_once 'also-in-this-collection-core.php';
	require_once 'also-in-this-collection-taxonomies.php';
	require_once 'also-in-this-collection-widgets.php';
	require_once 'also-in-this-collection-shortcodes.php';
	
	if( !wp_doing_ajax() && is_admin() ) {
		require_once plugin_dir_path( __FILE__ ) . 'also-in-this-collection-admin.php';
	}
}
else {
	add_action( 'admin_notices', 'also_in_this_collection_requirements_notice' );
	return;
}

function also_in_this_collection_requirements_notice() {
	echo '<div class="error"><p>' . esc_html__( 'Also In This Collection requires PHP 8.0 or later to run. Please update your server.', 'also-in-this-collection' ) . '</p></div>';
}

function also_in_this_collection_meets_requirements() {
	return version_compare( PHP_VERSION, '8.0' ) >= 0;
}

function also_in_this_collection_activate() {
    add_option( 'alsointhiscollection_activate', true );
}

function also_in_this_collection_uninstall() {
	// Clean up plugin data immediately during uninstall
	delete_option( 'also-in-this-collection' );
	delete_option( 'alsointhiscollection_activate' );
	delete_option( 'alsointhiscollection_deactivate' );
	
	// Remove any custom taxonomies and flush rewrite rules
	flush_rewrite_rules();
	
	// If you need to remove taxonomy terms or other data, do it here
	// Example: Remove all terms from your custom taxonomy
	$terms = get_terms(array('taxonomy' => 'collection', 'hide_empty' => false));
	foreach($terms as $term) {
	wp_delete_term($term->term_id, 'collection');
	}
}

function also_in_this_collection_deactivate() {
	// Clean up on deactivation (optional)
	flush_rewrite_rules();
}

function also_in_this_collection_maintenance() {
	if( get_option( 'alsointhiscollection_activate' ) ) {
        flush_rewrite_rules();
        delete_option( 'alsointhiscollection_activate' );
    }
}

register_activation_hook( __FILE__, 'also_in_this_collection_activate' );
register_deactivation_hook( __FILE__, 'also_in_this_collection_deactivate' );
register_uninstall_hook( __FILE__, 'also_in_this_collection_uninstall' );
add_action( 'init', 'also_in_this_collection_maintenance', 11 );
