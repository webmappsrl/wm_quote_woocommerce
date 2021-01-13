<?php

# Gets routes ID seperated by space and outputs the original featured image ID and its translations
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Gets routes ID seperated by space and outputs the original featured image ID and its translations
 *
 *
 * @when after_wp_load
 */
$wm_product_variation = function( $args, $assoc_args )
{
    $the_query = array(
        'posts_per_page'   => -1,
        'post_type'        => 'product',
        'fields' => 'ids'
    );
    $args = get_posts($the_query);
    $attributes_all = array ();
    foreach ($args as $count => $product_id) {
            $product_attr = get_post_meta( $product_id, '_product_attributes' );
            foreach ($product_attr as $attr) {
                foreach ($attr as $attribute) {
                    array_push($attributes_all,$attribute['name']);
                }
            }
            // WP_CLI::success( $count.' - '.'product #'.$product_id .'label ' . $_product);

    }
    print_r(array_count_values($attributes_all));
};

WP_CLI::add_command( 'product-variation', $wm_product_variation );
