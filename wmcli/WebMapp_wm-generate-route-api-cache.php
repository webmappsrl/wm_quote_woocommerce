<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Update all routes and writes API cache
 *
 *
 * @when after_wp_load
 */
$wm_generate_route_api = function( $args, $assoc_args )
{

	WP_CLI::line("\n\nAll routes api cache will be generated\n\n");

	// Retrieve routes
	$args = array('post_type' => 'route','posts_per_page' => -1,);
    $routes = get_posts($args);

	$base_url = home_url() . "/wp-json/webmapp/v2/route/";
    foreach ( $routes as $route )
    {
        $route_id = $route->ID;
        $url = $base_url . $route_id;
        $json = wm_get_curl_content( $url );
        WP_CLI::line("Creating cache file for ROUTE: $route->post_title ($route->ID)");
        if ( $json )
            wm_vn_writeRestApi($json,$route_id);
        else
            trigger_error("Impossible write rest api cache for route with id: $route_id. Impossible get: $base_url");
    }



};
if ( class_exists( 'WP_CLI' ) ) {
   WP_CLI::add_command( 'wm-generate-route-api-cache', $wm_generate_route_api );
}

