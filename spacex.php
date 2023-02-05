<?php
/*
Plugin Name: SpaceX API Plugin
Description: Reads data from space X api.
Author: Chirayu
Version: 1.0.0
**/


// Auto load classes
spl_autoload_register(function ($class_name) {
	$file = __DIR__ . '/classes/' . $class_name . '.php';

	if ( file_exists( $file ) ){
		include $file;
	}
});


// Boot custom post type.
if ( ! class_exists( 'SpaceLaunches' ) || ! class_exists( 'SpacePageCreator' ) || ! class_exists( 'SpaceApiFetch' ) || ! class_exists( 'SpaceShortcode' ) ) {
	return;
}


$launches = new SpaceLaunches();
$launches->boot();

// Boot page creator.
$page = new SpacePageCreator();
$page->boot();


// Boot shortcode
$shortcode = new SpaceShortcode();
$shortcode->boot();

// Boot api fetch on activation.
$api = new SpaceApiFetch();
$api->boot();

add_filter('single_template', 'space_set_custom_template');

function space_set_custom_template( $single ) {

    global $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'launches' ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . '/templates/LaunchSingle.php' ) ) {
            return plugin_dir_path( __FILE__ ) . '/templates/LaunchSingle.php';
        }
    }

    return $single;

}

register_activation_hook( __FILE__, 'space_activation' );

function space_activation() {

	// Initial fetch on activation.
	$api = new SpaceApiFetch();
	$api->fetch_data();

	// Boot api fetch once daily for update.
	if ( ! wp_next_scheduled ( 'space_api_fetch_schedule' ) ) {
    	wp_schedule_event( time(), 'daily', 'space_api_fetch_schedule' );
    }
}

register_deactivation_hook( __FILE__, 'space_deactivation' );

function space_deactivation() {
    wp_clear_scheduled_hook( 'space_api_fetch_schedule' );
}

