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
	  }
   }
 });
  /*End*/
}

/*find cities*/
findCity = (state , city = null) =>{
  /*find state list*/
  $.ajax({
  url:findCityUrl,
  type: "GET",           
  data: {state:state , city:city},
  success: function(data){
	 var parseJson = jQuery.parseJSON(data); 
	  if(parseJson.status == 200){
		  $("#city").html(parseJson.state);
	  }
   }
 });
  /*End*/
}
/*End*/

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
	
	/*find cities*/
	$(document).on('change','#state', function(e){
	   var state = parseInt($(this).val());
	   if(state != 0){
		   findCity(state);
		 }
	});
	/*end*/
});