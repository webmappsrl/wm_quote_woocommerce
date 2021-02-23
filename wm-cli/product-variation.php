<?php

# Shows number of occurance of the all products attribute names
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Shows number of occurance of the all products attribute names
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
        if ($count < 1) {
            $product_attr = get_post_meta( $product_id, '_product_attributes' );
            foreach ($product_attr as $attr) {
                foreach ($attr as $key => $attribute) {
                    echo $attribute['name'];
                    echo $attribute['value'];
                    // $attribute['name'] = 'CatB';
                    // array_push($attributes_all,$attribute['name']);
                    // $attributes[ sanitize_title( $attribute['name'] ) ] = array(
                    //     'name'          => wc_clean( $attribute['name'] ),
                    //     'value'         => $attribute['value'],
                    //     'position'      => $attribute['position'],
                    //     'is_visible'    => $attribute['is_visible'],
                    //     'is_variation'  => $attribute['is_variation'],
                    //     'is_taxonomy'   => $attribute['is_taxonomy'] 
                    // );
                    // update_post_meta( $product_id, '_product_attributes', $attributes );
                }
            }
            // $product_attr = get_post_meta( $product_id, '_product_attributes' );
            echo $product_id;
            print_r($product_attr);
        }
    }
    // print_r(array_count_values($attributes_all));
};

WP_CLI::add_command( 'product-variation', $wm_product_variation );
