<?php
// wp_redirect("http://local.b2i_storage.com/?pagename=search-results");
// header("Location: http://local.b2i_storage.com/?pagename=search-results");

   if(isset($_POST['btnSubmit']))
   {
    
       $search_string = htmlspecialchars($_POST["txtSearch"]);
       
//       if ($search_string == "Nashville, TN")
//       {
//           header("Location: http://local.b2i_storage.com/68127-self-storage/radius-10");
//           exit();
//       }
       if (!empty($search_string))
       {
           $location_result = getLocation($search_string);
           $location = $location_result->geoCodeLocationResult->geoCodeLocation_Response;
           if ( $location->ReplyCode == '1')
           {
              if(!is_null($location->City && !is_null($location->State)))
              {
                  $url = "http://local.b2i_storage.com/" . strtolower($location->City) . "-self-storage/" . strtolower($location->State) . "-self-storage";
                  header("Location:" . $url );
             //     header("Location: http://local.b2i_storage.com/68127-self-storage/radius-10");
                  exit();
              }
           }
       }
  
 else {
          $url = htmlspecialchars($_POST["hdnURL"]);
      $url = $url . "?status=1";
  //              echo "It worked";
  //              echo $_SESSION['error'];
//         //     wp_redirect("http://local.b2i_storage.com/68127-self-storage/radius-10");

 //           $wp_session['search_status'] = array('status'=>'1','error'=>'Address Not Found');
            header("Location: $url");
            exit();  
       }
     
  
   }
    function getLocation($search_location)
    {
        
        $UserLogin = "DotStorage";
        $UserPassword = "test";
    //    $Location = "Nashville, TN";
        
                
        $params = array("UserLogin"=>$UserLogin,"UserPassword"=>$UserPassword,"Location"=>$search_location);
         
       try
       {
           $soap_client = new SoapClient("http://pmsservice.b2interactive.com/WebService.svc?wsdl");
                   
           $location_result = $soap_client->geoCodeLocation($params);  
           
//           if ( $location->ReplyCode == '1')
//           {
//               echo $location_values->geoCodeLocationResult->geoCodeLocation_Response->ReplyCode;
//           }
       }
       catch (Exception $e) {
       echo 'Caught exception: ',  $e->getMessage(), "\n";
}

            return $location_result;
    }
// header("Location: http://local.b2i_storage.com/68127-self-storage/radius-10");

// header("Location: http://local.b2i_storage.com/?page_id=31"); /* Redirect browser */


// $_SESSION['error'] = 'Address Not Found';


?>
