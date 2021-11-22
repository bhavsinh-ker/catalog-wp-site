<?php
/**
 * Template part for displaying product sidebar in products page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package catalog_site
 */
 
$filter_url_args = $args;

if ( is_tax( array( "product-category", "product-color", "product-size" ) ) ) {
    $queried_object = get_queried_object();
    if( ! empty( $queried_object ) ) {
        $product_tax_name = str_replace("-", "_", $queried_object->taxonomy);
        $filter_url_args[$product_tax_name][] = $queried_object->slug;
    }
}

/* get product categories, color and size in one function */
$product_terms = get_terms( array(
    'taxonomy' => array(
        'product-category',
        'product-size',
        'product-color'
    )
) );
$product_category = $product_size = $product_color = array();
if ( !is_wp_error( $product_terms ) && !empty( $product_terms ) ) {
    foreach ($product_terms as $product_term) {
        if ( isset($product_term->taxonomy) ) {
            switch ($product_term->taxonomy) {
                case 'product-category':
                    $product_category[] = $product_term;
                break;
                case 'product-size':
                    $product_size[] = $product_term;
                break;
                case 'product-color':
                    $product_color[] = $product_term;
                break;
            }
        }
    }
}
/* EOF get product categories, color and size in one function */
 
$page_url = get_page_url_by_template( "templates/template-products.php" );
?>

<h3 class="mb-4"><?php _e( 'Filter By', 'kit_theme' ); ?></h3>

<form action="<?php echo $page_url; ?>" method="get">

    <!-- Product Search -->
    <div class="card mb-3 rounded-0">
        <div class="card-header bg-light"><?php _e( 'Product Search', 'kit_theme' ); ?></div>
        <div class="card-body">
            <input type="text" class="form-control" name="product_search" placeholder="<?php _e( 'Enter Product Search', 'kit_theme' ); ?>" value="<?php echo ( isset($filter_url_args['product_search']) ) ? $filter_url_args['product_search'] : ''; ?>" >
        </div>
        </div>
    <!-- EOF Product Search -->

    <!-- Price Filter -->
    <div class="card mb-3 rounded-0">
        <div class="card-header bg-light">
        <?php _e( 'Price', 'kit_theme' ); ?>
        </div>
        <div class="card-body">
            <div class="input-group">
                <input type="number" class="form-control" name="price_min" placeholder="<?php _e( 'Min', 'kit_theme' ); ?>" value="<?php echo ( isset($filter_url_args['price_min']) ) ? $filter_url_args['price_min'] : ''; ?>">
                <input type="number" class="form-control" name="price_max" placeholder="<?php _e( 'Max', 'kit_theme' ); ?>" value="<?php echo ( isset($filter_url_args['price_max']) ) ? $filter_url_args['price_max'] : ''; ?>">
            </div>
        </div>
        </div>
    <!-- EOF Price Filter -->

    <?php if ( isset( $product_category ) && !empty( $product_category ) ) { ?>
    <!-- Category Filter -->
    <div class="card mb-3 rounded-0">
        <div class="card-header bg-light">
            <?php _e( 'Category', 'kit_theme' ); ?>
        </div>
        <ul class="list-group list-group-flush">
            <?php 
                foreach ($product_category as $term) {
                    $is_checked = "";
                    if ( isset( $filter_url_args['product_category'] ) && in_array( $term->slug, $filter_url_args['product_category'] )) {
                        $is_checked = 'checked="checked"';
                    }
            ?>
            <li class="list-group-item">
                <input class="form-check-input me-1" type="checkbox" name="product_category[]" value="<?php echo $term->slug ?>" <?php echo $is_checked; ?>>
                <?php echo $term->name ?>
            </li>
            <?php } ?>
        </ul>
    </div>
    <!-- EOF Category Filter -->
    <?php } if ( isset( $product_color ) && !empty( $product_color ) ) { ?>
    <!-- Color Filter -->
    <div class="card mb-3 rounded-0">
        <div class="card-header bg-light"><?php _e( 'Color', 'kit_theme' ); ?></div>
        <ul class="list-group list-group-flush">
            <?php 
                foreach ($product_color as $term) {
                    $is_checked = "";
                    if ( isset( $filter_url_args['product_color'] ) && in_array( $term->slug, $filter_url_args['product_color'] )) {
                        $is_checked = 'checked="checked"';
                    }
            ?>
            <li class="list-group-item">
                <input class="form-check-input me-1" type="checkbox" name="product_color[]" value="<?php echo $term->slug ?>" <?php echo $is_checked; ?>>
                <?php echo $term->name ?>
            </li>
            <?php } ?>
        </ul>
    </div>
    <!-- EOF Color Filter -->
    <?php } if ( isset( $product_size ) && !empty( $product_size ) ) { ?>
    <!-- Size Filter -->
    <div class="card mb-3 rounded-0">
        <div class="card-header bg-light"><?php _e( 'Size', 'kit_theme' ); ?></div>
        <ul class="list-group list-group-flush">
            <?php 
                foreach ($product_size as $term) {
                    $is_checked = "";
                    if ( isset( $filter_url_args['product_size'] ) && in_array( $term->slug, $filter_url_args['product_size'] )) {
                        $is_checked = 'checked="checked"';
                    }
            ?>
            <li class="list-group-item">
                <input class="form-check-input me-1" type="checkbox" name="product_size[]" value="<?php echo $term->slug ?>" <?php echo $is_checked; ?>>
                <?php echo $term->name ?>
            </li>
            <?php } ?>
        </ul>
    </div>
    <!-- EOF Size Filter -->
    <?php } ?>

    <button type="submit" class="btn btn-outline-primary"><?php _e( 'Apply Filter', 'kit_theme' ); ?></button>
    <input type="hidden" name="product_filter" value="1">
    <?php 
        foreach ($_GET as $key => $value) {
            $not_allowed_url_keys = array(
                'product_filter',
                'product_search',
                'price_min',
                'price_max',
                'product_category',
                'product_color',
                'product_size',
                'post_type'
            );
            if ( in_array( $key, $not_allowed_url_keys ) ) {
                continue;
            }
            echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
        }
    ?>
</form>