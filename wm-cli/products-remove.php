<?php

# Removes those products that were created from Onclick form 
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Removes those products that were created from Onclick form 
 *
 *
 * @when after_wp_load
 */
$wm_product_remove = function( $args, $assoc_args )
{
    $the_query = array(
        'posts_per_page'   => 200,
        'post_type'        => 'product',
        'fields' => 'ids'
    );
    $args = get_posts($the_query);
    foreach ($args as $count => $product_id) {
        $product = wc_get_product( $product_id );
        if ( preg_match('/^[0-9]*$/',$product->get_name())) {
            WP_CLI::line( $product->get_name(). ' deleting');
            shell_exec('wp post delete '. $product_id. ' --force');
        }
    }
};

WP_CLI::add_command( 'products-remove', $wm_product_remove);
