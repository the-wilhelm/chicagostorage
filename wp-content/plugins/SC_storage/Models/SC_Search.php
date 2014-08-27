<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Search
 *
 * @author Charles
 */
class SC_Search
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
   
    public function getLocation($search_location)
    {
                  
        $params = array("UserLogin"=>$this->sc_ws_login,
                        "UserPassword"=>$this->sc_ws_password,
                        "Location"=>$search_location);
         
       try
       {
           $soap_client = new SoapClient($this->sc_ws_url);
                   
           $location_result = $soap_client->geoCodeLocation($params);  
          
       }
       catch (Exception $e) {
       echo 'Caught exception: ',  $e->getMessage(), "\n";
       }       

       return $location_result;
    }
    
}


