<?php

// Class to create lauches post type

class SpaceLaunches {

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 */
	function boot() {
		add_action( 'init', array( $this, 'create_launches_post_type' ) );
	}

	/**
	 * Create launches post type
	 *
	 * @since  1.0.0
	 */
	function create_launches_post_type() {
		register_post_type( 'launches',
			array(
				'labels' => array(
					'name' => __( 'Launches', 'spacex' ),
					'singular_name' => __( 'Launch', 'spacex'  )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array( 'slug' => 'launches' ),
			)
		);
	}
}
