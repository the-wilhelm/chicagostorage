<?php
/**
* Template Name: Reserve
 */
    echo "HELLLOOOO!";

    require_once 'reservation.php';

    $facID = get_query_var('scid');
    $uID =  get_query_var('scuid');
    $res_error =  get_query_var('reserror');
 
    $clsFacility = new SC_Facility;
    $returned_facility = $clsFacility->getFacility($facID);
    $facility = $returned_facility->getFacilityResult;
    $images = $facility->Images->string;
    
    $clsCosts = new SC_Costs;
    $returned_move_costs = $clsCosts->getUnitMoveInCosts($facID, $uID);
    $move_costs = $returned_move_costs->getUnitMoveInCostResult->getUnitMoveInCost_Response;

    $returned_reserve_costs = $clsCosts->getUnitReserveCost($facID, $uID);
    $reserve_costs = $returned_reserve_costs->getUnitReserveCostResult;
    
    $clsUnit = new SC_Units;
    $returned_unit = $clsUnit->getUnit($uID);
    $unit = $returned_unit->getUnitResult;
    
    if ($res_error == 1)
    {
        $wp_session = WP_Session::get_instance();
        $reservation = $wp_session['reservation'];
        
        $first_name_value = $reservation['FirstName'];
        $last_name_value = $reservation['LastName'];
        $email_value =  $reservation['Email'];
        $phone_value =  $reservation['PhoneNumber'];
 //       $move_in_value = $reservation['ReserveUntilDate'];
//        $reservation['LastName'] = (!empty($_POST["scLastName"])) ?  esc_attr($_POST["scLastName"]) : "";
//        $reservation['Email'] = (!empty($_POST["scEmail"])) ?  esc_attr($_POST["scEmail"]) : "";
//        $reservation['PhoneNumber'] = (!empty($_POST["scPhone"])) ?  esc_attr($_POST["scPhone"]) : "";
//        $reservation['ReserveUntilDate'] = (!empty($_POST["scMoveInDate"])) ?  esc_attr($_POST["scMoveInDate"]) : "";
    }

?>


<?php get_header(); ?>
<script>
    jQuery(document).ready(function($){
        "use strict";
        $("#scCheckout1").validate();
        $("#scPhone").mask("(999) 999-9999");
         
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
    <div id="sidebar">
      <section class="product-info">
        <?php if (has_post_thumbnail()): ?>
          <div class="photo"><?php the_post_thumbnail('checkout-thumbnail'); ?></div>
        <?php endif; ?>
      
        <strong class="size"><?php echo $unit->Width . "x" . $unit->Length; ?></strong>      
        <?php 
          $price = '$' . number_format($reserve_costs->RentalRate, 0);
          if(!empty($price )): 
        ?>
            <span class="price"><strong><?php echo $price; ?></strong> <?php echo  __('per month','chicagostorage'); ?></span>
        <?php 
          endif;
        ?>
        <?php
          if (!empty($facility->Branding)):
        ?>
            <strong class="title"><?php _e($facility->Branding,'chicagostorage'); ?></strong>
            <?php
              echo "<br/>" .  $facility->Address . "<br/>";
              echo $facility->City. " , " . $facility->StateAbbreviation . " " . $facility->PostalCode . "<br /><br />";
            ?>
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
            <table style="border: none;">
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
      </div>
              <div id="left">
                <form method="post" id="scCheckout1" role="form" action="/index.php/charge/">
                <br />
               
                <div  class="row">
                    <div class="col-md-5">
                          <div class="form-group">
                                  <label for="scFirstName">First Name</label>
                                  <input type="text" class="form-control" id="scFirstName" name="scFirstName" placeholder="Enter your first name" value="<?php echo $first_name_value; ?>" data-rule-required="true" data-msg-required="Please enter your first name.">
                           </div>
                    </div>
                    <div class="col-md-5">
                          <div class="form-group">
                                  <label for="scEmail">Email</label>
                                  <input type="text" class="form-control" id="scEmail" name="scEmail" placeholder="Enter your email"  value="<?php echo $email_value; ?>" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email.">
                           </div>
                    </div>
                   
                </div>
                <div class="row">
                     <div class="col-md-5">
                         <div class="form-group">
                                  <label for="scLastName">Last Name</label>
                                  <input type="text" class="form-control" id="scLastName" name="scLastName" placeholder="Enter your last name" value="<?php echo $last_name_value; ?>" data-rule-required="true" data-msg-required="Please enter your last name.">
                           </div>
                    </div>
                    <div class="col-md-5">
                         <div class="form-group">
                                  <label for="scPhone">Phone</label>
                                  <input type="text" class="form-control" id="scPhone" name="scPhone" placeholder="Enter your phone" value="<?php echo $phone_value; ?>" data-rule-required="true" data-rule-phoneUS="true" data-msg-required="Please enter your phone.">
                           </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-5">
                         <div class="form-group">
                                  <label for="scMoveInDate">Expected Move In date</label>
                                  <select id="scMoveInDate" name="scMoveInDate" class="form-control">
                                      <option value="0">Select Date</option>
                                   <?php 
                                         if ($reserve_costs->ReplyCode == '0')
                                         {
                                              
                                              $wrkdate = new DateTime();
                                              $lastday = date_create_from_format("m/d/Y", $reserve_costs->LastDay);
                                               while ( $wrkdate <= $lastday)
                                               {
                                                   echo "<option value='" . $wrkdate->format("m/d/Y") . "'>" . $wrkdate->format("l m/d/Y") . "</option>";
                                                   $wrkdate->modify('+1 day');
                                               }
                                         }
                                      ?>  
                                  </select>
                           </div>
                    </div>
                    <div class="col-md-5">
                         <div class="form-group">
                                  <label>
                                      <input type="checkbox" > I'm not sure when me move in date will be.
                                  </label>
                           </div>
                    </div>
                    <div class="col-md-5">
                       
                    </div>
                </div>
            </div><!-- #left -->   
           </div><!-- #container -->
  <hr>
  <?php if ($res_error == 1): ?>
  <br /><span style="font-weight: bold; color: #CC0000;">Reservation Error</span><br />
  <?php endif; ?>
  <div class="btn-holder">
  	<div class="col">
  		<span class="label">Rental Conditions</span>
           <label>
               <input type="checkbox" id='scterms' name='scterms' value='a' data-rule-required="true"  data-msg-required="Please agree with the terms and conditions."> I agree to the <a href='<?php echo "/info.php/terms"; ?>'>term and conditions</a> of this rental.
           </label>
  	</div>
  	<div class="col">
  		<button type="submit" name='submit'><span>continue</span></button>
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
  	 <?php wp_nonce_field('reserve-step-one', 'step-one-nonce'); ?>
  </form>	
</div>

<?php 
    
     $wp_session = WP_Session::get_instance();
           
     $reservation['FacilityID'] = $facID;
     $reservation['UnitTypeID'] = $uID;
     $reservation['ResDeposit'] = (!empty($reserve_costs->Amount)) ?  $reserve_costs->Amount : 0; 
     $reservation['RentalRate'] = (!empty($reserve_costs->RentalRate)) ?  esc_attr($reserve_costs->RentalRate) : 0;
     $reservation['AmountToApply'] = (!empty($reserve_costs->Amount)) ?  esc_attr($reserve_costs->Amount) : 0;
     $wp_session['facility'] = $facility;
     $wp_session['unit'] = $unit;
     $wp_session['reservation'] = $reservation;

    get_footer(); 
    
?>