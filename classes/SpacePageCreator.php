<?php

// Class to create dynamic pages.

Class SpacePageCreator {

	/**
	 * Boot the create pages function.
	 * 
	 * @since 1.0.0
	 */
	public function boot() {
		add_action( 'init', array( $this, 'create_pages' ) );
	}

	/**
	 * Create pages.
	 * 
	 * @since 1.0.0
	 */
	public function create_pages() {
		$pages = [
			[
				'title'   => 'History',
				'content' => '',
			],
			[
				'title'   => 'Launches',
				'content' => '[spacex]',
			],

		];

		foreach ( $pages as $page ) {
			$hasPage = get_page_by_title( $page['title'], 'OBJECT', 'page' );
			// Check if the page already exists
			if( empty( $hasPage ) ) {
				$page_id = wp_insert_post(
					[
						'post_title'     => ucwords( $page['title'] ),
						'post_name'      => sanitize_title( $page['title'] ),
						'post_status'    => 'publish',
						'post_content'   => $page['content'],
						'post_type'      => 'page',
					]
				);
			}
		}
	}


}