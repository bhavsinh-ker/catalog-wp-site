<?php
/**
 * Template Name: Home Page
 * 
 * The template for displaying home page
 *
 * This is the template that displays home page by default.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package catalog_site
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>
		<div class="home-phone-apps-list">
			<?php get_template_part( 'template-parts/content', 'phone-apps-list' ); ?>
		</div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
