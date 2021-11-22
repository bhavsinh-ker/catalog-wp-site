<?php
/**
 * Template Name: Products Page
 * 
 * The template for displaying products page
 *
 * This is the template that displays products page by default.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package catalog_site
 */

get_header();

    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$args = array(
		"post_type" => "product",
        "orderby"   => "ID",
        "order"     => "DESC",
        "paged"     => $paged
	);

    /* Filter process */
    $is_product_filter = ( isset( $_GET['product_filter'] ) && $_GET['product_filter'] == "1" ) ? true : false;
    $filter_url_args = array();
    if( $is_product_filter ) {

        /* Product Search args */
        $product_search = ( isset( $_GET['product_search'] ) && $_GET['product_search'] != "" ) ? $_GET['product_search'] : false;
        if ( $product_search !== false ) {
            $args["s"] = $product_search;
            $filter_url_args['product_search'] = $product_search;
        }
        /* EOF Product Search args */

        /* Product price filter args */
        $price_min = ( isset( $_GET['price_min'] ) && $_GET['price_min'] != "" ) ? $_GET['price_min'] : false;
        $price_max = ( isset( $_GET['price_max'] ) && $_GET['price_max'] != "" ) ? $_GET['price_max'] : false;

        if ( $price_min !== false || $price_max !== false ) {
            $args["meta_query"] = array(
                array(
                    'key'       => 'price',
                    'type'      => 'numeric',
                )
            );

            if ( $price_min !== false && $price_max === false ) {
                $args["meta_query"][0]["value"] = $price_min;
                $args["meta_query"][0]["compare"] = '<=';
                $filter_url_args['price_min'] = $price_min;
            } elseif( $price_min === false && $price_max !== false ) {
                $args["meta_query"][0]["value"] = $price_max;
                $args["meta_query"][0]["compare"] = '>=';
                $filter_url_args['price_max'] = $price_max;
            } elseif( $price_min !== false && $price_max !== false ) {
                $args["meta_query"][0]["value"] = array(
                    $price_min,
                    $price_max
                );
                $args["meta_query"][0]["compare"] = 'BETWEEN';
                $filter_url_args['price_min'] = $price_min;
                $filter_url_args['price_max'] = $price_max;
            }
        }
        /* EOF Product price filter args */

        /* Product categories filter args */
        $product_category_filter = ( isset( $_GET['product_category'] ) && ! empty( $_GET['product_category'] ) ) ? $_GET['product_category'] : false;
        $product_category_tax_query = array();
        if ( $product_category_filter !== false ) {
            $product_category_tax_query = array(
                'taxonomy' => 'product-category',
                'field'    => 'slug',
                'terms'    => $product_category_filter
            );
            $filter_url_args['product_category'] = $product_category_filter;
        }
        /* EOF Product categories filter args */

        /* Product color filter args */
        $product_color_filter = ( isset( $_GET['product_color'] ) && ! empty( $_GET['product_color'] ) ) ? $_GET['product_color'] : false;
        $product_color_tax_query = array();
        if ( $product_color_filter !== false ) {
            $product_color_tax_query = array(
                'taxonomy' => 'product-color',
                'field'    => 'slug',
                'terms'    => $product_color_filter
            );
            $filter_url_args['product_color'] = $product_color_filter;
        }
        /* EOF Product color filter args */

        /* Product size filter args */
        $product_size_filter = ( isset( $_GET['product_size'] ) && ! empty( $_GET['product_size'] ) ) ? $_GET['product_size'] : false;
        $product_size_tax_query = array();
        if ( $product_size_filter !== false ) {
            $product_size_tax_query = array(
                'taxonomy' => 'product-size',
                'field'    => 'slug',
                'terms'    => $product_size_filter
            );
            $filter_url_args['product_size'] = $product_size_filter;
        }
        /* EOF Product size filter args */

        /* Apply tax query in args */
        if ( ! empty( $product_category_tax_query ) || ! empty( $product_color_tax_query ) || ! empty( $product_size_tax_query ) ) {
            if ( ! empty( $product_category_tax_query ) ) {
                $args['tax_query'][] = $product_category_tax_query;
            }

            if ( ! empty( $product_color_tax_query ) ) {
                $args['tax_query'][] = $product_color_tax_query;
            }

            if ( ! empty( $product_size_tax_query ) ) {
                $args['tax_query'][] = $product_size_tax_query;
            }
            
            if ( count( $args['tax_query'] ) > 1 ) {
                $args['tax_query']['relation'] = 'AND';
            }
        }
        /* EOF Apply tax query in args */

    }
    /* EOF Filter process */

    /* Sorting process */
    $product_sort = ( isset( $_GET['product_sort'] ) && ( $_GET['product_sort'] == "price_low_to_high" || $_GET['product_sort'] == "price_high_to_low" ) ) ? $_GET['product_sort'] : false;
    if ( $product_sort !== false ) {
        $args['orderby'] = "meta_value_num";
        $args['meta_key'] = "price";
        $args['order'] = ( $product_sort == "price_high_to_low" ) ? 'DESC' : 'ASC';
    }
    /* EOF Sorting process */

	$products = new WP_Query( $args );

	while ( have_posts() ) :
		the_post();
        get_template_part( 'template-parts/content', 'product', array(
            "query_obj" => $products,
            "filter_url_args" => $filter_url_args,
            "product_sort" => $product_sort
        ) );
	endwhile;
get_footer();
