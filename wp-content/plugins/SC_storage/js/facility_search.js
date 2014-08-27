/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function($){
    $("#s").click(function() {
        $(this).val('');
    });
    $("#s").blur(function() {
        if ($(this).val() == '')
        {
            $(this).val('Enter City, State or Zip');
        }
    });
    
   $('#search_form').validate({
 
    rules: {
      txtSearch: {
        notEqual: 'Enter City, State or Zip'
      }
    },

//    messages: {
//      txtSearch: "Please enter a search location."
//    },

    errorElement: "div",
    errorPlacement: function(error, element) {
      element.before(error);
    }
 
});
jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value != param;
}, "Please enter a search location.");
    
});



