<?php

# Gets routes ID or --all (for all routes) to update wm_route_price from null to 9999
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Gets routes ID or --all (for all routes) to update wm_route_price from null to 9999
 *
 *
 * @when after_wp_load
 */
$wm_cy_update_route_null_price_to_max = function( $args, $assoc_args )
{
    $all_routes = isset( $assoc_args['all'] ) ? $assoc_args['all'] : false;
    if ($all_routes){
        $the_query = array(
            'posts_per_page'   => -1,
            'post_type'        => 'route',
            'fields' => 'ids'
        );
        $args = get_posts($the_query);

        WP_CLI::line( 'Searching all routes ...');
    } else {
        $args = $args;
    }
    $num = 1;
    foreach ($args as $count => $route_id) {
        //get post language
        $post_lang = apply_filters( 'wpml_post_language_details', NULL, $route_id );
        //WP_CLI::line( 'Route language is: '.$post_lang['language_code'].'');
        
        if ( $post_lang['language_code'] == 'it') {

            //check if route is coming soon
            $coming_soon = get_field('not_salable',$route_id);
            
            if ($coming_soon) {
                // get the route price
                $price = get_field('wm_route_price',$route_id);
                if ( $price == null || $price == '9.99') {
                    update_field('wm_route_price', '9999', $route_id);
                    WP_CLI::success( $num .' '.$route_id.' - '.$price.' -> 9999');
                    $num += 1;
                }
            }
        }
    
    }

};

WP_CLI::add_command( 'wm-cy-update-route-null-price-to-max', $wm_cy_update_route_null_price_to_max );
