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
class SC_Facility 
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
    
    public function getFacility($id)
    {
                      
        $params = array("UserLogin"=>$this->sc_ws_login,
                        "UserPassword"=>$this->sc_ws_password,
                        "ID"=>$id);
         
       try
       {
           
           $soap_client = new SoapClient($this->sc_ws_url);
            
           $facility_result = $soap_client->getFacility($params);  
                         
       }
       catch (Exception $e) {
       echo 'Caught exception: ',  $e->getMessage(), "\n";
}
                               
        return $facility_result;
    }
    
}