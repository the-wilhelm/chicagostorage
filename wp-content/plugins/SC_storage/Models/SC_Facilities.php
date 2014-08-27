<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Facilities
 *
 * @author Charles
 */
class SC_Facilities 
{
    private $sc_storage_options = array();
    private $sc_ws_login;
    private $sc_ws_password;
    private $sc_ws_url;
    
    function __construct() {
        
       $this->sc_storage_options = get_option('sc_storage_options');
       $this->sc_ws_login = esc_attr($this->sc_storage_options['option_ws_login']);
       $this->sc_ws_password = esc_attr($this->sc_storage_options['option_ws_password']);
       $this->sc_ws_url = esc_attr($this->sc_storage_options['option_ws_url']);
       
    }
   
    public function getFacilities($city, $state, $zip, $latitude, $longitude, $radius, $sizeids, $featureids, $typeids, $orderby, $returncount)
    {
      
       
            
        $params = array("UserLogin"=>$this->sc_ws_login,
                        "UserPassword"=>$this->sc_ws_password,
                        "City"=>$city,
                        "State"=>$state,
                        "Zip"=>$zip,
                        "Latitude"=>$latitude,
                        "Longitude"=>$longitude,
                        "Radius"=>$radius,
                        "SizeIDs"=>$sizeids,
                        "FeatureIDs"=>$featureids,
                        "TypeIDs"=>$typeids,
                        "OrderBy"=>$orderby,
                        "ReturnCount"=>$returncount);
         
       try
       {
           
           $soap_client = new SoapClient($this->sc_ws_url);
                   
           $facilities_result = $soap_client->searchFacilities($params);  
           
       }
       catch (Exception $e) {
       echo 'Caught exception: ',  $e->getMessage(), "\n";
}
                               
        return $facilities_result;
    }
    public function getFacilitiesSizes($size)
    {
        
        $UserLogin = $this->sc_ws_login;
        $UserPassword = $this->sc_ws_password;
        $City = "Chicago";
        $State = "Il";
        $Zip = "";
        $Latitude = "";
        $Longitude = "";
        $Radius = "";
        $SizeIDs = $size;
        $FeatureIDs = "";
        $TypeIDs = "";
                
        $params = array("UserLogin"=>$UserLogin,
                        "UserPassword"=>$UserPassword,
                        "City"=>$City,
                        "State"=>$State,
                        "Zip"=>$Zip,
                        "Latitude"=>$Latitude,
                        "Longitude"=>$Longitude,
                        "Radius"=>$Radius,
                        "SizeIDs"=>$SizeIDs,
                        "FeatureIDs"=>$FeatureIDs,
                        "TypeIDs"=>$TypeIDs,
                        "OrderBy"=>"R",
                        "ReturnCount"=>0);
         
       try
       {
           
           $soap_client = new SoapClient($this->sc_ws_url);
                   
           $facilities_result = $soap_client->searchFacilities($params);  
           
       }
       catch (Exception $e) {
       echo 'Caught exception: ',  $e->getMessage(), "\n";
}
                               
        return $facilities_result;
    }
    
}
