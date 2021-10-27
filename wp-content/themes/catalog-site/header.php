<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package catalog_site
 */

$catalog_site_operating_systems = get_terms( array( 'taxonomy' => 'operating-systems' ) );
$catalog_site_site_url          = get_bloginfo( 'url' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site py-5">
	<!-- Container -->
	<div class="container">
		<div class="row">
			<!-- Left side -->
			<div class="col-md-3">
				<header id="masthead" class="site-header">
					<div class="site-branding">
						<?php
						the_custom_logo();

						$catalog_site_description = get_bloginfo( 'description', 'display' );
						if ( $catalog_site_description || is_customize_preview() ) :
							?>
							<p class="catalog-site-site-description"><?php echo $catalog_site_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>
					</div><!-- .site-branding -->

					<?php if ( ! is_wp_error( $catalog_site_operating_systems ) && ! empty( $catalog_site_operating_systems ) ) { ?>
					<div id="operatingSystemsFilters" class="side-nav mt-5">
						<ul class="list-group">
							<li class="list-group-item border-0 <?php echo ( is_front_page() && ! isset( $_GET['operating_systems'] ) ) ? 'current-menu-item' : ''; ?>">
								<a href="<?php echo esc_url( $catalog_site_site_url ); ?>" data-slug=""><?php esc_html_e( 'All apps', 'kit_theme' ); ?></a>
							</li>
						<?php 
							$catalog_site_i = 0;
						foreach ( $catalog_site_operating_systems as $catalog_site_os ) {
							$catalog_site_os_url  = add_query_arg( 'operating_systems', esc_html( $catalog_site_os->slug ), $catalog_site_site_url );
							$catalog_site_active_menu_class = '';
							if ( isset( $_GET['operating_systems'] ) && esc_html( $catalog_site_os->slug ) === esc_html( $_GET['operating_systems'] ) ) {
								$catalog_site_active_menu_class = 'current-menu-item';
							}
							?>
							<li class="list-group-item border-0 <?php echo esc_html( $catalog_site_active_menu_class ); ?>">
								<a href="<?php echo esc_url( $catalog_site_os_url ); ?>" data-slug="<?php echo esc_html( $catalog_site_os->slug ); ?>"><?php echo esc_html( $catalog_site_os->name ); ?></a>
							</li>
							<?php
								$catalog_site_i++; 
						}
						?>
						</ul>
					</div>
					<?php } ?>

					<nav id="site-navigation" class="main-navigation">
						<button class="menu-toggle d-none" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'kit_theme' ); ?></button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
						?>
					</nav><!-- #site-navigation -->
				</header>
			</div>
			<!-- EOF Left side -->

			<!-- Right side -->
			<div class="col-md-9">