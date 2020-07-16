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
        WP_CLI::line( 'Route language is: '.$post_lang['language_code'].'');
        
        //get wpml default language
        $default_lang = apply_filters('wpml_default_language', NULL );
        WP_CLI::line( 'WPML default languages is: '.$default_lang.'');
        
        // Route default language Id
        $post_default_language_id = apply_filters( 'wpml_object_id', $route_id, 'route', FALSE, $default_lang );
        WP_CLI::line( 'Route default language ID: '.$post_default_language_id.'');

        //This route image ID
        $this_post_thumb_id = get_post_thumbnail_id( $route_id );
        WP_CLI::line( 'Route featured image ID: '.$this_post_thumb_id.'');

        //get post language
        $image_lang = apply_filters( 'wpml_post_language_details', NULL, $this_post_thumb_id );
        WP_CLI::line( 'Route featured image language is: '.$image_lang['language_code'].'');

        // ID of the Featured image in the language of current route 
        //$featured_image_id_current_lang = apply_filters( 'wpml_object_id', $this_post_thumb_id, 'attachment', FALSE, $post_lang['language_code'] );
        //WP_CLI::line( 'ID of featured image in route current language: '.$featured_image_id_current_lang.'');

        $calendar_json = site_url().'/wp-json/wp/v2/media/'.$this_post_thumb_id;
        $featured_image_json = json_decode(file_get_contents($calendar_json),TRUE);
        if ($featured_image_json['wpml_translations']){
            foreach ($featured_image_json['wpml_translations'] as $c) {
                foreach ($c as $d) {
                    if ($d == 'it_IT') {
                        $featured_image_id_current_lang = $c['id'];
                    }
                }
            }
            WP_CLI::line( 'ID of featured image in route current language: '.$featured_image_id_current_lang.'');
        } else {
            WP_CLI::line( 'No translation present for image ID: '.$this_post_thumb_id.'');
        }
        WP_CLI::line( ' ');

    }    

};

WP_CLI::add_command( 'wm-cy-cli-find-route-media', $wm_cy_find_route_media );
