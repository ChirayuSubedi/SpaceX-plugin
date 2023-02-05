<?php
// Shortcode class

// Class to create shortcode
class SpaceShortcode {

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 */
	function boot() {
		add_shortcode( 'spacex', array( $this, 'spacex_shortcode' ) );
	}

	/**
	 * Create shortcode
	 *
	 * @since  1.0.0
	 */
	function spacex_shortcode() {
		$launches = get_posts( array(
			'post_type' => 'launches',
			'posts_per_page' => -1,
		) );

		$html = '<div class="launches">';

		foreach ( $launches as $launch ) {
			$html .= '<div class="launch">';
			$html .= '<h2><a href="' . get_permalink( $launch->ID ) .'">' . $launch->post_title . '</a></h2>';
			$html .= '<p>' . $launch->post_content . '</p>';
			$html .= '</div>';
		}

		$html .= '</div>';

		return $html;
	}
}