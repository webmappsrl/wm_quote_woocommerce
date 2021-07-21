<?php

# Removes those products that were created from Onclick form, Accepts one numeric argument as the number of post_per_page 
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Removes those products that were created from Onclick form, Accepts one numeric argument as the number of post_per_page 
 *
 *
 * @when after_wp_load
 */
$wm_product_remove = function( $args, $assoc_args )
{
    if (isset($args[0]) && is_numeric($args[0]) && $args[0] > 0) {
        $post_per_page = $args[0];
    } else {
        $post_per_page = 200;
    }
    $the_query = array(
        'posts_per_page'   => $post_per_page,
        'post_type'        => 'product',
        'fields'           => 'ids',
        'date_query' => array(
            'before' => date('Y-m-d', strtotime('-1 days')) 
        )
    );
    $args = get_posts($the_query);
    foreach ($args as $count => $product_id) {
        $product = wc_get_product( $product_id );
        if ( preg_match('/^[0-9]*$/',$product->get_name())) {
            WP_CLI::line( $count . ' - '. $product->get_name(). ' deleting');
            shell_exec('wp post delete '. $product_id. ' --force');
        }
    }
};

WP_CLI::add_command( 'products-remove', $wm_product_remove);
