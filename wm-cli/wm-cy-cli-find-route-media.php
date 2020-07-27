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
    foreach ($args as $count => $route_id) {
        //get post language
        $post_lang = apply_filters( 'wpml_post_language_details', NULL, $route_id );
        // WP_CLI::line( 'Route language is: '.$post_lang['language_code'].'');
        
        //get wpml default language
        $default_lang = apply_filters('wpml_default_language', NULL );
        // WP_CLI::line( 'WPML default languages is: '.$default_lang.'');
        
        // Route default language Id
        $post_default_language_id = apply_filters( 'wpml_object_id', $route_id, 'route', FALSE, $default_lang );
        // WP_CLI::line( 'Route default language ID: '.$post_default_language_id.'');

        //This route image ID
        $this_post_thumb_id = get_post_thumbnail_id( $route_id );
        // WP_CLI::line( 'Route featured image ID: '.$this_post_thumb_id.'');

        //get route image language
        $image_lang = apply_filters( 'wpml_post_language_details', NULL, $this_post_thumb_id );
        if (is_array($image_lang)){
            $image_lang_code = $image_lang['language_code'];
            // WP_CLI::line( 'Route featured image language is: '.$image_lang_code.'');

            // ID of the Featured image in the language of current route 
            //$featured_image_id_current_lang = apply_filters( 'wpml_object_id', $this_post_thumb_id, 'attachment', FALSE, $post_lang['language_code'] );
            //WP_CLI::line( 'ID of featured image in route current language: '.$featured_image_id_current_lang.'');

            $calendar_json = site_url().'/wp-json/wp/v2/media/'.$this_post_thumb_id;
            $featured_image_json = json_decode(file_get_contents($calendar_json),TRUE);
            if (is_array($featured_image_json)) {

                if ( $image_lang_code && $image_lang_code == $post_lang['language_code']) {
                    // success if the route language is equal to it's featured image language
                    WP_CLI::Success( $count.' - '.'Route #'.$route_id.' -> OKEY');
                } elseif ( $featured_image_json['wpml_translations']) {
                    $mod = false;
                    foreach ($featured_image_json['wpml_translations'] as $c) {
                        foreach ($c as $d) {
                            $lang = $post_lang['language_code'].'_'.strtoupper($post_lang['language_code']);
                            if ($d == $lang) {
                                $featured_image_id_current_lang = $c['id'];
                                $mod = true;
                            }
                        }
                    }
                    if ($mod) {
                        shell_exec('wp media regenerate '. $featured_image_id_current_lang);
                        set_post_thumbnail( $route_id, $featured_image_id_current_lang );
                        WP_CLI::success( $count.' - '.'Route #'.$route_id.' -> MOD: new image ID: '.$featured_image_id_current_lang );
                    } else {
                        WP_CLI::warning( $count.' - '.'Route #'.$route_id.' -> NO');
                    }
    
                } else {
                    WP_CLI::success( $count.' - '.'Route #'.$route_id.' -> OK');
                }
            } else {
                WP_CLI::warning( $count.' - '.'Route #'.$route_id.' -> ERROR UNAUTHORIZED');
            }
        } else {
            WP_CLI::warning( $count.' - '.'Route #'.$route_id.' -> NO IMAGE');
        }
    }

};

WP_CLI::add_command( 'wm-cy-cli-find-route-media', $wm_cy_find_route_media );
