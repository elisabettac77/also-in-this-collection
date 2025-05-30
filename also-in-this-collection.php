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
		require_once plugin_dir_path( __file__ ) . 'also-in-this-collection-admin.php';
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

function also_in_this_series_uninstall() {
	add_option( 'alsointhiscollection_deactivate', true );
}

function also_in_this_collection_maintenance() {
	if( get_option( 'alsointhiscollection_activate' ) ) {
        flush_rewrite_rules();
        delete_option( 'alsointhiscollection_activate' );
    }

	if( get_option( 'alsointhiscollection_deactivate' ) ) {
		define('SERIES_SLUG', 'series_slug');
		delete_option( 'alsointhiscollection_deactivate' );
	}
}

register_activation_hook( __FILE__, 'also_in_this_collection_activate' );
register_uninstall_hook( __FILE__, 'also_in_this_collection_uninstall' );
add_action( 'init', 'also_in_this_collection_maintenance', 11 );
