findState = (country , state = null) =>{
  /*find state list*/
  $.ajax({
  url:findStateUrl,
  type: "GET",           
  data: {countryid:country , state:state},
  success: function(data){
	 var parseJson = jQuery.parseJSON(data); 
	  if(parseJson.status == 200){
		  $("#state").html(parseJson.state);
	  }else if(parseJson.status == 100){
		  
	  }
   },complete(e ,xhr , setting){
	   //$('.hidden_state').find("option[value='"+state+"']").attr('selected','selected');
	  //console.log(state);
	}
 });
  /*End*/
  return true;
}

$(document).ready(function(e) {
   /*Statte select on window load*/
    var country = $("#editcountry").val();
	var state= $(".hidden_state").val();
	stateResponse = findState(country ,state);
	if(stateResponse == true){
	 	
		//$(".hidden_state")
	 }
   /*End*/	
   $(document).on('change','#country', function(e){
	   var country = parseInt($(this).val());
	   if(country != 0){
		   findState(country);
		 }
	});
});