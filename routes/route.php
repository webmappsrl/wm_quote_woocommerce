<?php

add_action( 'rest_api_init', function () {
    register_rest_route( 'webmapp/v2', '/route/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => function( WP_REST_Request $request )
        {
            $param = $request->get_url_params();
            $error = new WP_Error();


            if ( ! isset( $param['id'] ) )
            {
                $error->add(400,"Missing id parameter.", 400);
                return $error;
            }

            $route_id = $param['id'];
            $route = get_post( $route_id );

            if ( ! $route instanceof WP_Post)
            {
                $error->add(400,"Impossible found a post with this id.", 400);
                return $error;
            }

            if ( $route->post_type !== 'route' )
            {
                $error->add(400,"Id provided isn't of a route post.", 400);
                return $error;
            }

            $route = (array) $route;

            //add all acf
            $route['acf'] = get_fields( $route_id );

            if ( isset($route['acf']['product']) && is_array($route['acf']['product']) )
            {
                $found_products = $route['acf']['product'];

                $route['acf']['product'] = webmapp_vn_route_api_format_products( $found_products );
            }


            if ( isset($route['acf']['model_season']) && is_array($route['acf']['model_season']) )
            {
                $model_season = $route['acf']['model_season'];
                foreach ( $model_season as $key => $val )
                {
                    if ( isset($val['product']) && is_array($val['product']) )
                    {
                        $route['acf']['model_season'][$key]['product'] = webmapp_vn_route_api_format_products($val['product']);
                    }
                }

            }

            $route = webmapp_vn_route_api_route_object_customization($route);


            return new WP_REST_Response( $route, 200 );
        },
    ) );
} );



function webmapp_vn_route_api_format_products( $found_products )
{
    $products = [];
    foreach ( $found_products as $key => $product_id )
    {
        $product_o = wc_get_product($product_id);
        $product =  $product_o->get_data();
        $product['attributes'] = array_map(function($i){
            return $i->get_data();
        },$product_o->get_attributes());

        $handle = new WC_Product_Variable($product_id);
        $variations_ids = $handle->get_children();
        if ( ! empty ($variations_ids) )
        {
            $variations = [];
            foreach( $variations_ids as $variations_id)
            {
                $single_variation = new WC_Product_Variation($variations_id);
                $variations[] = $single_variation->get_data();
            }
            $product['variations'] = $variations;

        }

        $products[ $product_id ] = $product;

    }

    return $products;
}


function webmapp_vn_route_api_route_object_customization( $route )
{
    $route_id = $route['ID'];
    $route['id'] = $route_id;
    //unset( $route['ID'] );
    // $route['promotion_value'] = $route['acf']['promotion_value'] = get_field($route_id,'promotion_value');
    // $route['promotion_name'] = $route['acf']['promotion_name'] = get_field($route_id,'promotion_name');

    // PATCH da sistemare
    global $wpdb;
    $query="SELECT meta_value from vn_postmeta where post_id=$route_id and meta_key='promotion_value'";
    $res = $wpdb->get_results($query,ARRAY_A);
    $route['promotion_value'] = $route['acf']['promotion_value'] = $res[0]['meta_value'];

    $query="SELECT meta_value from vn_postmeta where post_id=$route_id and meta_key='promotion_name'";
    $res = $wpdb->get_results($query,ARRAY_A);
    $route['promotion_name'] = $route['acf']['promotion_name'] = $res[0]['meta_value'];



    return $route;
}