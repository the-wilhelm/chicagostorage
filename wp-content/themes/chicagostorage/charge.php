<?php
/**
* Template Name: Charge
 */
require_once 'reservation.php';

//    $facID = get_query_var('scid');
//    $uID =  get_query_var('scuid');
// 
//    $clsFacility = new SC_Facility;
//    $returned_facility = $clsFacility->getFacility($facID);
//    $facility = $returned_facility->getFacilityResult;
//    $images = $facility->Images->string;
//    
//    $clsCosts = new SC_Costs;
//    $returned_move_costs = $clsCosts->getUnitMoveInCosts($facID, $uID);
//    $move_costs = $returned_move_costs->getUnitMoveInCostResult->getUnitMoveInCost_Response;
//
//    $returned_reserve_costs = $clsCosts->getUnitReserveCost($facID, $uID);
//    $reserve_costs = $returned_reserve_costs->getUnitReserveCostResult;
    
    if(isset($_POST["submit"]))
        {
         
           $retrieved_nonce = $_REQUEST['step-one-nonce'];
           if (!wp_verify_nonce($retrieved_nonce, 'reserve-step-one' ) )
           {
                   die( 'Failed security check' );
           }
           
           $wp_session = WP_Session::get_instance();
           
           $reservation = $wp_session['reservation'];
           
           $clsCosts = new SC_Costs;
           $returned_move_costs = $clsCosts->getUnitMoveInCosts($reservation['FacilityID'], $reservation['UnitTypeID']);
           $move_costs = $returned_move_costs->getUnitMoveInCostResult->getUnitMoveInCost_Response;

//           $returned_reserve_costs = $clsCosts->getUnitReserveCost($reservation['FacilityID'], $reservation['UnitTypeID']);
//           $reserve_costs = $returned_reserve_costs->getUnitReserveCostResult;
          
           $facility = $wp_session['facility'];
           $unit = $wp_session['unit']; 
            
           $reservation['FirstName'] = (!empty($_POST["scFirstName"])) ?  esc_attr($_POST["scFirstName"]) : "";
           $reservation['LastName'] = (!empty($_POST["scLastName"])) ?  esc_attr($_POST["scLastName"]) : "";
      //     $reservation['Address'] = (!empty($_POST["scAddress"])) ?  esc_attr($_POST["scAddress"]) : "";
      //     $reservation['City'] = (!empty($_POST["scCity"])) ?  esc_attr($_POST["scCity"]) : "";
      //     $reservation['State'] = (!empty($_POST["scState"])) ?  esc_attr($_POST["scState"]) : "";
      //     $reservation['PostalCode'] = (!empty($_POST["scZipCode"])) ?  esc_attr($_POST["scZipCode"]) : "";
           $reservation['Email'] = (!empty($_POST["scEmail"])) ?  esc_attr($_POST["scEmail"]) : "";
           $reservation['PhoneNumber'] = (!empty($_POST["scPhone"])) ?  esc_attr($_POST["scPhone"]) : "";
           $reservation['ReserveUntilDate'] = (!empty($_POST["scMoveInDate"])) ?  esc_attr($_POST["scMoveInDate"]) : "";
            
           
           
           if ($reservation['ResDeposit'] == 0)
           {
                $reservation['scCardType'] = "VI";
                $reservation['CCExpMonth'] = "12";
                $reservation['CCExpYear'] = date('Y', strtotime('+1 years'));;
                $reservation['CCNumber'] = "4444111144441111";
                $reservation['CCCVVcode'] = "123";
                
                $wp_session['reservation'] = $reservation;
                
                wp_redirect("/index.php/confirm");
                exit();

                     
                   
           }   
           
           $wp_session['reservation'] = $reservation;

        }
?>


<?php get_header(); ?>
<script>
    jQuery(document).ready(function($){
        "use strict";
        $("#scCheckout2").validate();
        $("#scCardNumber").mask("9999-9999-9999-9999");
        
         
    });
	</script>
    <style>
     .error { border: 1px solid #b94a48!important; background-color: #fee!important; }
</style>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <div class="checkout">
  <h1><?php _e('Reserve Now','chicagostorage'); ?></h1>
<div class="container">
            <div id="left"  style="float: left;">
              <form method="post" id="scCheckout2" role="form" action="/index.php/confirm/">
              <div  class="row">
                  <div class="col-md-6">
                        <div class="form-group">
                                <label for="scCardType">Card Type</label>
                                 <select id="scCardType" name="scCardType" class="form-control">
                                     <?php if ($facility->AcceptVisa): ?>
                                        <option value="VI">Visa</option>
                                     <?php endif; ?> 
                                     <?php if ($facility->AcceptMC): ?>
                                        <option value="MC">Master Card</option>
                                     <?php endif; ?>
                                     <?php if ($facility->AcceptDiscover): ?>     
                                        <option value="DI">Discover</option>
                                     <?php endif; ?>
                                     <?php if ($facility->Amex): ?>      
                                        <option value="AE">American Express</option>
                                     <?php endif; ?>
                                 </select>
                         </div>
                  </div>
                  <div class="col-md-4">
                       <div class="form-group">
                                <label for="scExpMonth">Expiration</label>
                                <select id="scExpMonth" name="scExpMonth" class="form-control">
                                        <option value="01">01 - Jan</option>
                                        <option value="02">02 - Feb</option>
                                        <option value="03">03 - Mar</option>
                                        <option value="04">04 - Apr</option>
                                        <option value="05">05 - May</option>
                                        <option value="06">06 - Jun</option>
                                        <option value="07">07 - Jul</option>
                                        <option value="08">08 - Aug</option>
                                        <option value="09">09 - Sep</option>
                                        <option value="10">10 - Oct</option>
                                        <option value="11">11 - Nov</option>
                                        <option value="12">12 - Dec</option>
                                 </select>
                         </div>
                  </div>
                  <div class="col-md-3">
                       <div class="form-group">
                                <label for="scExpYear">Year</label>
                                <select id="scExpYear" name="scExpYear" class="form-control">
                                   <option value="2014">2014</option>
                                   <option value="2015">2015</option>
                                   <option value="2016">2016</option>
                                   <option value="2017">2017</option>
                                   <option value="2018">2018</option>
                                   <option value="2019">2019</option>
                                </select>
                         </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                        <div class="form-group">
                                <label for="scCardNumber">Card Number</label>
                                <input type="text" class="form-control" id="scCardNumber" name="scCardNumber" placeholder="Enter your card number" data-rule-required="true" data-rule-creditcard="true" data-msg-required="Please enter your Credit Card Number.">
                         </div>
                  </div>
                  <div class="col-md-4">
                       <div class="form-group">
                                <label for="scCWV">CWV Code</label>
                                <input type="text" class="form-control" id="scCWV" name="scCWV" data-rule-required="true" data-rule-minlength="3" data-rule-maxlength="3" data-rule-number="true" data-msg-required="Please enter your CWV Number.">
                         </div>
                  </div>
                  <div class="col-md-3">
                      
                  </div>
              </div>
          </div><!-- #left --> 
         </div><!-- #container -->
<hr>
<div class="btn-holder">
<!--	<div class="col">
		
	</div>-->
	<div class="col">
		<button type="submit" name='submit'><span>rent now</span></button>
	</div>
</div>
<hr class="blue">
<?php $ch_title = get_field('checkout_title','options'); ?>
<?php $ch_text = get_field('checkout_text','options'); ?>
<?php if($ch_title || checkout_text): ?>
    <section>
        <?php if ($ch_title): ?>
        <h2><?php echo $ch_title; ?></h2>
        <?php endif; ?>
        <?php echo wpautop($ch_text,false); ?>
    </section>
<?php endif; ?>
  </div>
	  <?php wp_nonce_field('reserve-step-two', 'step-two-nonce'); ?>
</form>	
</div>
<aside id="sidebar" class="pull-left">
			<section class="product-info">
				<?php if (has_post_thumbnail()): ?>
						<div class="photo"><?php the_post_thumbnail('checkout-thumbnail'); ?></div>
				<?php endif; ?>
                        
				<strong class="size"><?php echo $unit->Width . "x" . $unit->Length; ?></strong>	
                        
				<?php 
                        $price = '$' . number_format($reservation['RentalRate'], 0);
                        if(!empty($price )): ?>
						<span class="price"><strong><?php echo $price; ?></strong> <?php echo  __('per month','chicagostorage'); ?></span>
				<?php endif; ?>
				<?php if (!empty($facility->Branding)): ?>
						<strong class="title"><?php _e($facility->Branding,'chicagostorage'); ?></strong>
						  <?php echo "<br/>" .  $facility->Address . "<br/>";
                        echo $facility->City. " , " . $facility->StateAbbreviation . " " . $facility->PostalCode . "<br /><br />";?>
				<?php endif; ?>
                <?php if (!empty($facility->OfficeHours)): ?>
						<strong class="title"><?php _e('Office Hours','chicagostorage'); ?></strong>
						<?php echo "<br />" . $facility->OfficeHours . "<br />"; ?>
				<?php endif; ?>
				<?php if (!empty($facility->GateHours)):?>
						<strong class="title"><?php _e('Gate Hours','chicagostorage'); ?></strong>
						<?php echo "<br />" . $facility->GateHours; ?>
				<?php endif; ?>
                        
                <h3>Costs</h3>
                <table border="0">
                <?php
                   
                    foreach ($move_costs as $costs)
                    {
                        if ($costs->ReplyCode == '0')
                        {
                            if ($costs->Name == "CHG")
                            {
                                echo "<tr><td>" . $costs->Description . "</td><td>" . '$' . $costs->Amount . "</td></tr>";
                                $total_costs += floatval($costs->Amount);
                            }
                        }
                    }
                    if ($reserve_costs->Amount > 0)
                    {
                         echo "<tr><td>Reservation Deposit</td><td>" . '$' . number_format($reserve_costs->Amount, 2) . "</td></tr>";
                         $total_costs += floatval($costs->Amount);
                    }
                    
                    echo "<tr><td>Total Costs</td><td>" . '$' . number_format($total_costs, 2) . "</td></tr>";
                ?>
                </table>
			</section>
		</aside>
<?php 
    
    get_footer(); ?>

