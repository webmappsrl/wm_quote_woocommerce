<?php

function preventivi_json_to_text(){
    
    global $woocommerce;
    $departure_date = '';
    $nightsBefore = '';
    $nightsAfter = '';
    $insurance_name = '';
    $club_name = '';
    $place = '';
    $place_s = '';
    $from = '';
    $to = '';
    $discountText = '';
    $routeid = '';
    $routCode = '';
    $routName = '';
    $routePermalink = '';
    $medical_insurance = true;
    $coupon_id = WC()->cart->get_coupons();
    foreach ($coupon_id as $val ){
        $json =  $val;
    }   
    $json_output = json_decode($json, JSON_PRETTY_PRINT); 
    $description = $json_output['description'];
    $desc = json_decode($description, JSON_PRETTY_PRINT);
    foreach ($desc as $val => $key){
        if ($val == 'routeId') { 
			$routeid = $key;
			// $routCode = get_field('n7webmapp_route_cod',$routeid);
			$routName = get_the_title($routeid);
			$routePermalink = get_permalink($routeid);
		}
        if ($val == 'boat_trip') { //check if the route is in boat or not
			$place = __('cabin','wm-child-verdenatura'); 
			$place_s = __('cabins','wm-child-verdenatura'); 
		} else {
			$place = __('room','wm-child-verdenatura');
			$place_s = __('rooms','wm-child-verdenatura');
        }
        if ($val == 'from'){
            $from = $key;
        }
        if ($val == 'to'){
            $to = $key;
        }
        if ($val == 'discountText'){
            if(isset($_GET['lang']) && $_GET['lang'] == 'en') {
                $discountText = $key['en'];
            } else {
                $discountText = $key['it'];
            }
        }
    }
    
    ?>
    <h2><?php echo sprintf(__('%s and Travelers\' details: ' ,'wm-child-verdenatura'), $place_s);?></h2>
    <?php
    
    ?>
    <div class="rooms-composition"> <!------- rooms composition -- ---->
    <?php
    foreach ($desc as $val => $key){
        
        if ($val == 'departureDate') {
            $date = $key;
            $departure_date = date("d-m-Y", strtotime($date));
        }
        if ($val == 'nightsBefore') {
            $nightsBefore = $key;
        }
        if ($val == 'nightsAfter') {
            $nightsAfter = $key;
        }
        if ($val == 'insurance') {
            $insurance_name = $key['name'];
        }
        if ($val == 'club') {
            $club_name = $key['name'];
        }
    }
    foreach ($desc as $val => $key){
        if ($val == 'rooms') {
            $rooms = $key;?>
            <?php 
                echo '<div class="tour-general-info"><p><strong>';
                echo __('Departure date:' ,'wm-child-verdenatura').' </strong>';
                echo $departure_date.'</p>';
				echo '<p><strong>'.__('Route name:','wm-child-verdenatura').'</strong> <a target="_blank" href="'.$routePermalink.'">'.$routName.'</a></p>';
            if ( $nightsBefore ) {
                echo '<p><strong>';
                echo __('Nights Before:' ,'wm-child-verdenatura').' </strong>';
                echo $nightsBefore.'</p>';
            }
            if ( $nightsAfter ) {
                echo '<p><strong>';
                echo __('Nights After:' ,'wm-child-verdenatura').' </strong>';
                echo $nightsAfter.'</p>';
            }
            if ( $insurance_name ) { 
                echo '<p><strong>';
                echo __('Cancellation insurance:' ,'wm-child-verdenatura').' </strong>';
                echo $insurance_name.'</p>';
            }
            if ( $club_name ) {
                echo '<p><strong>';
                echo __('Club:' ,'wm-child-verdenatura').' </strong>';
                echo $club_name.'</p>';
            }
            if ( $discountText ) {
                echo '<p style="color:#7AB400;"><strong>';
                echo $discountText.' </strong>';
                echo '</p>';
            }
            if ( $medical_insurance ) {
                echo '<p><strong>';
                echo __('Medical and Baggage Insurance Included' ,'wm-child-verdenatura').' </strong>';
                echo '</p>';
            }
            echo '</div>';
            ?>
            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <?php
            foreach ($rooms as $val2 => $room){
                ?>
                <thead> <!--  table head  -->
                    <tr> <!--  table row head  -->
                        <th><?php $room_number = $val2 + 1; echo sprintf(__('%s number %s' ,'wm-child-verdenatura'),$place, $room_number);?></th>
                        <th><?php echo __('Name' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Rent bike' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Bike extras' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Bike Warranty' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Extras' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Share' ,'wm-child-verdenatura');?></th>
                    </tr>
                </thead> <!-- END table head  -->
                <tbody>
                <?php
                    foreach ($room as $val3 => $pax){
                        $firsName = $pax['firstName'];
                        $lastName = $pax['lastName'];
                        $price = number_format((float)$pax['price'], 2, ',', '.');
                        $rentBike = '';
                        $babyseat = '';
                        $tagalong = '';
                        $trail = '';
                        $trailgator = '';
                        $bikeWarranty = '';
                        $normalWarranti = '';
                        $eWarranti = '';
                        $kidbikeWarranti = '';
                        $tandemWarranti = '';
                        $roadbikeWarranti = '';
                        $helmet = '';
                        $kidhelmet = '';
                        $roadbook = '';
                        $halfboard = '';
                        $cookingClass = '';
                        $transferBefore = '';
                        $transferAfter = '';
                        $doubleBed = '';
                        $boardingtax = '';
                        $shareRoom = '';
                        ?>
                        <tr>
                        <td></td>
                        <td><?php echo $firsName.' '.$lastName; ?></td>
                        
                        <?php
                        foreach ($pax as $val4 => $extra){
                            if ($val4 == 'rentBike'){
                                foreach ($extra as $val5 => $bikename){
                                    if ($val5 == 'name'){
                                        $rentBike = $bikename;
                                    }
                                }
                            }
                            if ($val4 == 'babySeat'){
                                $babyseat = true;
                            }
                            if ($val4 == 'tagAlong'){
                                $tagalong = true;
                            }
                            if ($val4 == 'trailer'){
                                $trail = true;
                            }
                            if ($val4 == 'trailgator'){
                                $trailgator = true;
                            }
                            if ($val4 == 'bikeWarranty'){
                                $bikeWarranty = true;
                            }
                            if ($val4 == 'helmet'){
                                $helmet = true;
                            }
                            if ($val4 == 'kidhelmet'){
                                $kidhelmet = true;
                            }
                            if ($val4 == 'roadbook'){
                                $roadbook = true;
                            }
                            if ($val4 == 'halfboard'){
                                $halfboard = true;
                            }
                            if ($val4 == 'cookingClass'){
                                $cookingClass = true;
                            }
                            if ($val4 == 'transferBefore'){
                                $transferBefore = true;
                            }
                            if ($val4 == 'transferAfter'){
                                $transferAfter = true;
                            }
                            if ($val4 == 'doubleBed'){
                                $doubleBed = true;
                            }
                            if ($val4 == 'boardingtax'){
                                $boardingtax = true;
                            }
                            if ($val4 == 'shareRoom'){
                                $shareRoom = true;
                            }
                        }
                        ?>
                        <td><?php if($rentBike): switch ($rentBike) {
                            case 'bike':
                                echo __('Supplement for bike rental' ,'wm-child-verdenatura');
                                $normalWarranti = true; 
                                break;
                            case 'eBike':
                                echo __('Supplement for e-bike rental' ,'wm-child-verdenatura');
                                $eWarranti = true; 
                                break;
                            case 'kidBike':
                                echo __('Supplement for children bike' ,'wm-child-verdenatura');
                                $kidbikeWarranti = true; 
                                break;
                            case 'tandem':
                                echo __('Supplement for tandem rental' ,'wm-child-verdenatura');
                                $tandemWarranti = true; 
                                break;
                            case 'roadbike':
                                echo __('Supplement for road bike rental' ,'wm-child-verdenatura');
                                $roadbikeWarranti = true;
                                break;
                                
                        } endif;?></td>
                        <td>
                            <?php if($babyseat): echo __('Supplement for child back seat rental' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($tagalong): echo __('Supplement for follow-me rental' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($trail): echo __('Supplement for children trailer rental' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($trailgator): echo __('Supplement for children trailgator' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                        </td>
                        <td>
                            <?php if($bikeWarranty):?>
                                <?php if($normalWarranti):?>
                                    <?php echo __('Bike Coverage' ,'wm-child-verdenatura');?>
                                <?php endif;?>
                                <?php if($eWarranti):?>
                                    <?php echo __('E-bike Coverage' ,'wm-child-verdenatura');?>
                                <?php endif;?>
                                <?php if($kidbikeWarranti):?>
                                    <?php echo __('kid bike Coverage' ,'wm-child-verdenatura');?>
                                <?php endif;?>
                                <?php if($tandemWarranti):?>
                                    <?php echo __('Tandem bike Coverage' ,'wm-child-verdenatura');?>
                                <?php endif;?>
                                <?php if($roadbikeWarranti):?>
                                    <?php echo __('Road bike Coverage' ,'wm-child-verdenatura');?>
                                <?php endif;?>
                            <?php endif;?>
                        </td>
                        <td>
                            <?php if($helmet): echo __('Supplement for adult helmet rental' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($kidhelmet): echo __('Supplement for kid helmet rental' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($roadbook): echo __('Printed road book maps' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($halfboard): echo __('Supplement for half board' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($cookingClass): echo __('Supplement for cooking class' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($transferBefore): echo __('Supplement for transfer before the trip' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($transferAfter): echo __('Supplement for transfer after the trip' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($doubleBed): echo __('Double Bed' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($boardingtax): echo __('Port charges (to be paid in advance)' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($shareRoom): echo __('Shared room' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                        </td>
                        <td><?php echo $price.'€'; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody> 
                <?php
            }
            ?></table><?php
        }
    }
    ?>
    </div><!-- END rooms composition  --> 
    <h2><?php echo __('Cart detail: ' ,'wm-child-verdenatura');?></h2>
    <?php
    
}