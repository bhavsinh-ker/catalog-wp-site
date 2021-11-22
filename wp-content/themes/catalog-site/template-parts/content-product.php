<?php
/**
 * Template part for displaying product list page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package catalog_site
 */
global $wp_query;
$products = (isset($args['query_obj'])) ? $args['query_obj'] : $wp_query;
$filter_url_args = (isset($args['filter_url_args'])) ? $args['filter_url_args'] : array();
$product_sort = (isset($args['product_sort'])) ? $args['product_sort'] : $wp_query;
$banner_args = array();
if ( is_tax( array( "product-category", "product-color", "product-size" ) ) ) {
    $queried_object = get_queried_object();
    if( ! empty( $queried_object ) ) {
        $product_tax_name = ucwords(str_replace("-", " ", $queried_object->taxonomy));
        $product_term = $queried_object->name;
        $banner_args['banner_title'] = $product_tax_name.": ".$product_term;
    }
} elseif( is_post_type_archive( 'product' ) ) {
    $banner_args['banner_title'] = __( "Products", "kit_theme" );
}
get_template_part( 'template-parts/page', 'banner', $banner_args );
?>

<!-- Page Content -->
<section id="pageContent" class="page-content py-5">
    <div class="container">
        <div class="row">
            <!-- Products Sidebar -->
            <div class="col-md-3 mb-5 mb-md-0">
                <?php get_template_part( 'template-parts/product', 'sidebar', $filter_url_args ); ?>
            </div>
            <!-- EOF Products Sidebar -->

            <!-- Products List Section -->
            <div class="col-md-9">
                <!-- Sort by -->
                <h3 class="mb-4 d-inline-block"><?php _e( 'Short By', 'kit_theme' ); ?></h3>
                <div class="d-inline-block float-end">
                <?php get_template_part( 'template-parts/product', 'sortby', $product_sort ); ?>
                </div>
                <!-- EOF Sort by -->

                <!-- Products List Section -->
                <div class="row">
                    <?php 
                        if( $products->have_posts() ) {
                            $product_image_args = array(
                                "class" => "card-img-top rounded-0"
                            );
                            $product_default_image = get_field( 'product_default_image', 'option' );
                            if ( $product_default_image!="" ) {
                                $product_default_image = wp_get_attachment_image( $product_default_image, 'product-small-thumb', false, $product_image_args );
                            }
    
                            $product_title_length = get_field( 'product_title_length', 'option' );
                            $product_excerpt_length = get_field( 'product_excerpt_length', 'option' );
                            $product_currency = get_field( 'product_currency', 'option' );
    
                            $args = array(
                                "product_image_args" => $product_image_args,
                                "product_default_image" => $product_default_image,
                                "product_title_length" => $product_title_length,
                                "product_excerpt_length" => $product_excerpt_length,
                                "product_currency" => $product_currency,
                                "product_col_class" => "col-md-6 col-lg-4 mb-4"
                            );
    
                            while( $products->have_posts() ) { 
                                $products->the_post();
                                get_template_part( 'template-parts/product', 'card', $args );
                            } 
                        } else {
                            get_template_part( 'template-parts/content', 'none' );
                        }
                        wp_reset_postdata(); 
                    ?>
                </div>
                <!-- EOF Products List Section -->

                <!-- Pagination -->
                <?php 
                    get_template_part( 'template-parts/content', 'pagination', array(
                        "max_num_pages" => $products->max_num_pages
                    ) );
                ?>
                <!-- EOF Pagination -->
            </div>
            <!-- EOF Products List Section -->
        </div>
    </div>
</section>
<!-- EOF Page Content -->