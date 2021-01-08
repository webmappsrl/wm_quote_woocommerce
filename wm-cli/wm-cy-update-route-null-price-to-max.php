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
            'post_status' => 'publish',
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
                update_field('wm_route_price', '3999', $route_id);
                WP_CLI::success( $num .' '.$route_id.' - '.$price.' -> 3999');
                $num += 1;
            } else {
                //var
                $attributes_name_hotel = array();
                $variations_name_price = array();
                $list_all_variations_name = array();

                $attributes_name_hotel_seasonal = array();
                $variations_name_price_seasonal = array();
                $list_all_variations_name_seasonal = array();

                $lowest_price_list = array();

                $products = get_field('product',$route_id);
                

                if( $products ){
                    foreach( $products as $p ){ // variables of each product
                    $product = wc_get_product($p); 
                        if($product->is_type('variable')){
                            $product_with_variables = wc_get_product( $p );
                            $category = $product_with_variables->get_categories();
                            $attributes_list = $product_with_variables->get_variation_attributes();
                            foreach ($attributes_list as $value => $key ) {
                                $product_attribute_name = $value;
                            }
                            if(strip_tags($category) == 'hotel'){
                                array_push($attributes_name_hotel,$product_attribute_name);
                                $product_variation_name_price = array();
                                foreach($product->get_available_variations() as $variation ){

                                    // hotel Name
                                    $attributes = $variation['attributes'];
                                    $variation_name = '';
                                    foreach($attributes as $name_var){
                                        $variation_name = $name_var;
                                    }
                                    // Prices
                                    if ($variation['display_price'] == 0){
                                        $price = __('Free' ,'wm-child-verdenatura');
                                    } 
                                    elseif (!empty($variation['price_html'])){
                                        $price = $variation['price_html'];
                                    } else {
                                        $price = $variation['display_price'].'€';
                                    }
                                    $variation_name_price = array($variation_name => $price);
                                    $list_all_variations_name += array($variation_name => $variation['price_html']);
                                    $product_variation_name_price += $variation_name_price;
                                }
                                $variations_name_price += array( $product_attribute_name =>$product_variation_name_price);
                            }
                        }
                    }
                }
                while( have_rows('model_season',$route_id) ): the_row();
                    $season_products = get_sub_field('wm_route_quote_model_season_product',$route_id); 
                    if ($season_products){  //----------- start hotel product table
                        $attributes_name_hotel_seasonal = array();
                        $variations_name_price_seasonal = array();
                        $list_all_variations_name_seasonal = array();
                        foreach( $season_products as $p ){ // variables of each product
                        $product = wc_get_product($p); 
                            if($product->is_type('variable')){
                                $product_with_variables = wc_get_product( $p );
                                $category = $product_with_variables->get_categories();
                                $attributes_list = $product_with_variables->get_variation_attributes();
                                foreach ($attributes_list as $value => $key ) {
                                    $product_attribute_name = $value;
                                }
                                if(strip_tags($category) == 'hotel'){
                                    array_push($attributes_name_hotel_seasonal,$product_attribute_name);
                                    $product_variation_name_price = array();
                                    foreach($product->get_available_variations() as $variation ){

                                        // hotel Name
                                        $attributes = $variation['attributes'];
                                        $variation_name = '';
                                        foreach($attributes as $name_var){
                                            $variation_name = $name_var;
                                        }
                                        // Prices
                                        if (!empty($variation['price_html'])){
                                            $price = $variation['price_html'];
                                        } else {
                                            $price = $variation['display_price'].'€';
                                        }
                                        $variation_name_price = array($variation_name => $price);
                                        $list_all_variations_name_seasonal += array($variation_name => $variation['price_html']);
                                        $product_variation_name_price += $variation_name_price;
                                    }
                                    $variations_name_price_seasonal += array( $product_attribute_name =>$product_variation_name_price);
                                }
                            }
                        }
                        foreach ( $variations_name_price_seasonal as $var ) {
                            $price = preg_replace('/&.*?;/', '', $var['adult']);
                            $price = strip_tags($price);
                            $price = str_replace('€', '', $price);
                            $price_e = explode(',',$price);
                            $price_e = str_replace('.', '', $price_e[0]);
                            array_push($lowest_price_list , $price_e);
                        }
                    }
                endwhile;

                //  add the lowest price to vn_prezzp ACF : price from... 
                foreach ( $variations_name_price as $var ) {
                    $price = preg_replace('/&.*?;/', '', $var['adult']);
                    $price = strip_tags($price);
                    $price = str_replace('€', '', $price);
                    $price_e = explode(',',$price);
                    $price_e = str_replace('.', '', $price_e[0]);
                    array_push($lowest_price_list , $price_e);
                }
                if ($lowest_price_list) {
                    $lowest_price = min($lowest_price_list);
                    update_field('wm_route_price', $lowest_price,$route_id);
                }
                WP_CLI::success( $num .' '.$route_id.' - '.$lowest_price);
                $num += 1;
            }
        }
    }

};

WP_CLI::add_command( 'wm-cy-update-route-null-price-to-max', $wm_cy_update_route_null_price_to_max );
