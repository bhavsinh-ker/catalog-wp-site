<?php
/**
 * Template part for displaying product sortby in products page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package catalog_site
 */
 
$product_sort = $args;
$page_url = get_page_url_by_template( "templates/template-products.php" );
?>

<div class="dropdown">
    <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        <?php 
            switch ($product_sort) {
                case 'price_low_to_high':
                    _e( 'Price Low to High', 'kit_theme' );
                break;
                case 'price_high_to_low':
                    _e( 'Price High to Low', 'kit_theme' );
                break;
                default:
                    _e( 'Newest First', 'kit_theme' ); 
                break;
            }
        ?>
    </a>
    <?php
        $sord_url_args = $_GET;
        unset($sord_url_args['post_type']);
        $sord_url_args['product_sort'] = 'price_low_to_high';
        $sord_url_price_low_to_high = add_query_arg( $sord_url_args, $page_url );
        $sord_url_args['product_sort'] = 'price_high_to_low';
        $sord_url_price_high_to_low = add_query_arg( $sord_url_args, $page_url );
    ?>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <li>
            <a class="dropdown-item" href="<?php echo $page_url; ?>">
                <?php _e( 'Newest First', 'kit_theme' ); ?>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="<?php echo $sord_url_price_low_to_high; ?>">
                <?php _e( 'Price Low to High', 'kit_theme' ); ?>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="<?php echo $sord_url_price_high_to_low; ?>">
                <?php _e( 'Price High to Low', 'kit_theme' ); ?>
            </a>
        </li>
    </ul>
</div>