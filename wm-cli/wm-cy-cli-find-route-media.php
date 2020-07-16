<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Gets routes ID seperated by space and outputs the original featured image ID and its translations
 *
 *
 * @when after_wp_load
 */
$wm_cy_find_route_media = function( $args, $assoc_args )
{
    foreach ($args as $route_id) {
        //get post language
        $post_lang = apply_filters( 'wpml_post_language_details', NULL, $route_id );
        WP_CLI::line( 'Route language is: '.$post_lang.'');
        
        //get wpml default language
        $default_lang = apply_filters('wpml_default_language', NULL );
        WP_CLI::line( 'WPML default languages is: '.$default_lang.'');

        //This route image
        $this_post_thumb = get_post_thumbnail_id( $route_id );
        WP_CLI::line( 'Route featured image ID: '.$this_post_thumb.'');

        // Route default language Id
        $post_default_language_id = apply_filters( 'wpml_object_id', $route_id, 'route', FALSE, $default_lang );
        WP_CLI::line( 'Route default language ID: '.$post_default_language_id.'');

    }    

};

WP_CLI::add_command( 'wm-cy-cli-find-route-media', $wm_cy_find_route_media );
