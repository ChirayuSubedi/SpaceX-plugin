<?php

// Class to fetch data from api.
Class SpaceApiFetch {

	/**
	 * Boot the fetch function.
	 * 
	 * @since 1.0.0
	 */
	public function boot() {
		add_action( 'space_api_fetch_schedule', [ $this, 'fetch_data' ] );
	}

	/**
	 * Fetch data from api.
	 * 
	 * @since 1.0.0
	 */
	public function fetch_data() {
		$api_url = 'https://api.spacexdata.com/v3/launches';
		$response = wp_remote_get( $api_url );
		$launches = json_decode( wp_remote_retrieve_body( $response ) );
		$this->create_launches( $launches );
	}

	/**
	 * Create launches.
	 * 
	 * @since 1.0.0
	 */
	public function create_launches( $launches ) {
		foreach ( $launches as $launch ) {
			$hasLaunch = get_page_by_title( $launch->mission_name, 'OBJECT', 'launches' );
			// Check if the launch already exists.
			if( empty( $hasLaunch ) ) {
				$launch_id = wp_insert_post(
					[
						'post_title'     => wp_kses_post( ucwords( $launch->mission_name ) ),
						'post_name'      => sanitize_title( $launch->mission_name ),
						'post_status'    => 'publish',
						'post_content'   => wp_kses_post( $launch->details ),
						'post_type'      => 'launches',
					]
				);
				// Add meta data
				add_post_meta( $launch_id, 'rocket_details', $launch->rocket );
				add_post_meta( $launch_id, 'launch_site', $launch->launch_site );
			}
		}
	}

}