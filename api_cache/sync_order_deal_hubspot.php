<?php
// {
//   "dealname": "Pedram Katanchi 4",
//   "dealstage": "presentationscheduled",
//   "dealtype": "newbusiness",
//   "hubspot_owner_id": "40292283",
//   "amount": "2555",
//   "createdate": "2020-08-07",
//   "data_di_partenza": "2020-12-07",
//   "descrizione": "#85493",
//   "nr_adulti": "3",
//   "nr_bambini": "2",
//   "amount_acconto": "550",
//   "url_route": "https://cyclando.com/route/lago-di-costanza-per-famiglie/"
// }

add_action( 'woocommerce_thankyou', 'wm_sync_order_deal_hubspot', 10, 1 ); 

function wm_sync_order_deal_hubspot( $order_get_id ) { 
  //Hubspot APIKEY location => wp-config.php
  $hapikey = HUBSPOTAPIKEY;

  //Get WC order obj
  $order = wc_get_order($order_get_id);

  // Check if the order has deposit (Parent) or is a single order with no deposit attached to it
  $order_parent_id = $order->get_parent_id();
  if ($order_parent_id) {
    $order_parent = new WC_Order($order_parent_id);
  }
  if ($order_parent) {
    $order_object = $order_parent;
  } else {
    $order_object = $order;
  }

  // Get the order_object ID
  $order_object_id = $order_object->get_id();

  // Get the deposit amount
  $order_has_deposit = $order_object->get_meta('_wc_deposits_order_has_deposit', true);
  if ($order_has_deposit === 'yes') {
    $deposit_amount = floatval($order_object->get_meta('_wc_deposits_deposit_amount', true));
  }
  
  // Get the issued date
  $order_issued_date = $order_object->get_date_created();
  $order_issued_date = date('Y-m-d',$order_issued_date);

  // Get the order total amount and billing name
  $order_total = $order_object->get_total();
  $billing_first_name = $order_object->get_billing_first_name();
  $billing_last_name = $order_object->get_billing_last_name();

  // Get the order coupon to extract the json 
  $coupon = $order_object->get_coupon_codes();
	$coupon_name = $coupon['0'];
	$coupon_obj = get_posts( array( 
		'name' => $coupon_name, 
		'post_type' => 'shop_coupon'
	) );
	foreach ( $coupon_obj as $info) {
		$description = $info->post_excerpt;
	}
	$desc = json_decode($description, JSON_PRETTY_PRINT);
  foreach ($desc as $val => $key){
    if ($val == 'routeId') { 
      $routeid = $key;
      $routName = get_the_title($routeid);
      $routePermalink = get_permalink($routeid);
    } 
    if ($val == 'departureDate') {
      $date = $key;
      $departure_date = date("Y-m-d", strtotime($date));
    }
    if ($val == 'rooms') {
      $rooms = $key;
      $adults_number = 0;
      $kids_number = 0;
      foreach ($rooms as $val2 => $room){
        foreach ($room as $val3 => $pax){
          $pax_type = $pax['type'];
          if ($pax_type == '0') {
            $adults_number ++;
          } else {
            $kids_number ++;
          }
        }
      }
    }
  }

  $CURLOPT_POSTFIELDS = array(
    "dealname"=> $billing_first_name.' '.$billing_last_name,
    "dealstage"=> "presentationscheduled",
    "dealtype"=> "newbusiness",
    "hubspot_owner_id"=> "40292283",
    "amount"=> $order_total,
    "createdate"=> $order_issued_date,
    "data_di_partenza"=> $departure_date,
    "descrizione"=> $order_object_id,
    "nr_adulti"=> $adults_number,
    "nr_bambini"=> $kids_number,
    "amount_acconto"=> $deposit_amount,
    "url_route"=> $routePermalink
  );
  
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.hubapi.com/crm/v3/objects/deals?hapikey=$hapikey",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
    CURLOPT_HTTPHEADER => array(
      "accept: application/json",
      "content-type: application/json"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);
}; 

