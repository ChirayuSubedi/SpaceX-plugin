<?php
/**
 * The template for displaying single Launch Sites.
 */

get_header();
?>

<main id="site-content test">

	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();
			?>
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<header class="entry-header has-text-align-center">
					<div class="entry-header-inner section-inner medium">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</div>
				</header><!-- .entry-header -->
				<div class="post-inner">

					<div class="entry-content">

						<?php
							the_content( __( 'Continue reading', 'space' ) );
						?>
						<table>
							<caption>More Info:</caption>
							<thead>
								<tr>
									<?php
									$rocket_details = get_post_meta( get_the_id(), 'rocket_details', true );
									foreach( $rocket_details as $key => $value ) {
										if( $key === 'rocket_id' || $key === 'rocket_name' || $key === 'rocket_type' ){
											echo '<th scope="col">' . sanitize_title( $key ) . '</th>';
										}
									}

									$rocket_info = get_post_meta( get_the_id(), 'launch_site', true );
									foreach( $rocket_info as $key => $value ) {
										if( $key === 'site_id' || $key === 'site_name_long' || $key === 'site_name' ) {
											echo '<th scope="col">' . sanitize_title( $key ) . '</th>';
										}
									}
									?>
								</tr>
							</thead>
							<tbody>

								<tr>
									<?php
									foreach( $rocket_details as $key => $value ) {
										if( $key === 'rocket_id' || $key === 'rocket_name' || $key === 'rocket_type' ){
											echo '<td>' . esc_html( $value ) . '</td>';
										}
									}
									foreach( $rocket_info as $key => $value ) {
										if( $key === 'site_id' || $key === 'site_name_long' || $key === 'site_name' ) {
											echo '<td>' . esc_html( $value ) . '</td>';
										}
									}
									?>
								</tr>
							</tbody>
						</table>
					</div><!-- .entry-content -->

				</div><!-- .post-inner -->

			</article><!-- .post -->
			<?php
		}
	}

	?>

</main><!-- #site-content -->

<?php get_footer(); ?>
