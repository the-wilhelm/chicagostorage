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
class SC_Costs 
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
    
    public function getUnitMoveInCosts($facility, $inventoryID)
    {       
                
        $params = array("UserLogin"=>$this->sc_ws_login,
                        "UserPassword"=>$this->sc_ws_password,
                        "ID"=>$facility,
                        "InventoryID"=>$inventoryID);
         
       try
       {
           
           $soap_client = new SoapClient($this->sc_ws_url);
                   
           $move_costs_result = $soap_client->getUnitMoveInCost($params);  
           
       }
            catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
       }
                               
        return $move_costs_result;
    }
    
    public function getUnitReserveCost($facility, $inventoryID)
    {        
                
        $params = array("UserLogin"=>$this->sc_ws_login,
                        "UserPassword"=>$this->sc_ws_password,
                        "ID"=>$facility,
                        "InventoryID"=>$inventoryID);
         
       try
       {
      
           $soap_client = new SoapClient($this->sc_ws_url);
                   
           $reserve_costs_result = $soap_client->getUnitReserveCost($params);  
           
       }
            catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
       }
                               
        return $reserve_costs_result;
    }
    
}


