<?php

add_action( 'woocommerce_thankyou', 'wm_ajax_update_deal_hubspot', 20, 1 ); 

function wm_ajax_update_deal_hubspot( $order_get_id ) { 
  ?>
  <script type="text/javascript">
    jQuery(document).ready(function(){
      var res; 
        // ajax on route purchase / pay button that creates a new hubspot deal 
        function ajaxUpdateHubspotDeal(){
            var ocCookies = ocmCheckCookie();
            var data = {
                'action': 'oc_ajax_update_hs_deal',
                'orderid':  <?= $order_get_id ?>,
                'cookies':  ocCookies,
            };
            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php',
                type : 'post',
                data: data,
                beforeSend: function(){
                },
                success : function( response ) {
                },
                complete:function(response){
                    obj = JSON.parse(response.responseText);
                    res = JSON.parse(obj);
                    console.log(res);
                }
            });
        }
        ajaxUpdateHubspotDeal();
    })
    
  </script>
  <?php

}

// action that process ajax call : webmapp_anypost-cy_route_advancedsearch-oneclick.php to update HS Deals after payment
add_action( 'wp_ajax_nopriv_oc_ajax_update_hs_deal', 'oc_ajax_update_hs_deal' );
add_action( 'wp_ajax_oc_ajax_update_hs_deal', 'oc_ajax_update_hs_deal' );
function oc_ajax_update_hs_deal(){
    $cookies = $_POST['cookies'];
    $order_id = $_POST['orderid']; 
    $result =  wm_sync_update_deal_hubspot($cookies,$order_id);    
    
    echo json_encode($result);
    wp_die();
}

function wm_sync_update_deal_hubspot( $cookies,$order_id ) { 
  //Hubspot APIKEY location => wp-config.php
  $hapikey = HUBSPOTAPIKEY;

  $hsdealid = $cookies['hsdealid'];
  $hs_status = '';
  if ($cookies['deposit'] && $cookies['deposit'] > 0) {
    // identifier for Acconto Pagato
    $hs_status = 'contractsent';
  } else {
    // identifier for Saldo Pagato
    $hs_status = '2051528';
  }
  $CURLOPT_POSTFIELDS_ARRAY = "{\"properties\":{
    \"dealstage\": \"$hs_status\"
  }}";

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.hubapi.com/crm/v3/objects/deals/$hsdealid?hapikey=$hapikey",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PATCH",
    CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS_ARRAY,
    CURLOPT_HTTPHEADER => array(
      "accept: application/json",
      "content-type: application/json"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);
  if ($err) {
    $err_log = $hsdealid . '->' . $hs_status . ' = ' . $err;
    wm_write_log_file($err_log,'a+','dealHS_update_error');
    return "cURL Error #:" . $err;
  } else {
    $response_log = $hsdealid . '->' . $hs_status . ' = ' . $response;
    wm_write_log_file($response_log,'a+','dealHS_update_success');
    return $response;
  }
}; 

