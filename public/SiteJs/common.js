$(document).ready(function(e) {
	/*change the  status of plots*/
	$(document).on('submit','#changeBookingStatusForm', function(e) {
       $("#plotNumberInfomsg").html(" ");
	   $('#saveChangeBookingStatusBtn').html(' Please wait <i class="icon-spinner2 spinner"></i>').attr('disabled', true);
      e.preventDefault();
      $.ajax({
		url: saveStatusOfplots,
        type: "POST",
		headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
			var jsonDecode = jQuery.parseJSON(data);
			console.log(jsonDecode.msg);
			$("#plotNumberInfomsg").html(jsonDecode.msg);
			if(jsonDecode.status == 200){
			   setTimeout(function(){ location.reload(); }, 1000);
			 }
        },
		error:function(e , xhr , setting){
		  $("#plotNumberInfomsg").html(`<div class="notice notice-danger notice"><strong>Wrong </strong>  Something , went wrong please try again !!! </div>`);
		},
		complete: function(){
		   $("#saveChangeBookingStatusBtn").html(`Change Status`).attr('disabled', false);;
		}
      });
    });
	/*End*/
	/*set primary image for hotel*/
	 $(document).on('change','.booking_status', function(e){
		var bookingStatus = $(this);
		statusID = parseInt(bookingStatus.val());
		var plotNumber = bookingStatus.data('plotnumber');
		$("#statusID").val(statusID);
		$("#plotNumberID").val(plotNumber);
		if(statusID == 2){
		   $("#selectDateRow").show();
		 }
		else{
		  $("#selectDateRow").hide();
		 } 
		
		$('#changeStatusModal').modal({
			  backdrop:'static',
			  keyboard:false,
		  });
		  /*$.ajax({
			  url:setBookingStatus,
			  type: "GET",
			  data: {bookingStatus:bookingStatus.val() , plotNumberID:plotNumber},
			  success: function(data){
				  console.log(data);
				 var parseJson = jQuery.parseJSON(data);
				  if(parseJson.status == 200){
					  alert(parseJson.msg);
				  }else if(parseJson.status == 100){
					  alert(parseJson.msg);
				  }
			   }
			  });*/
    });
	/*End*/
});
