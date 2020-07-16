<?php

/*
  Plugin Name: Webmapp - Custom Route Api (for product variations) and Quote calculator (Woocommerce extension)
  Description: Shows route products with their variations in a custom route - Use calculator to create a WC order
  Author: Marco Baroncini and Pedram Katanchi
  Version: 0.1
 */

include_once ('routes/route.php');
include_once ('api_cache/on_save.php');
include_once ('wmcli/WebMapp_wm-generate-route-api-cache.php');
include_once ('woocommerce/woocommerce.php');
include_once ('woocommerce/preventivi-json.php');
include_once ('route-acf-register/route-acf-register.php');
if ( defined( 'WP_CLI' ) && WP_CLI ) {
  require_once dirname( __FILE__ ) . '/wm-cli/wm-cy-cli-find-route-media.php';
}