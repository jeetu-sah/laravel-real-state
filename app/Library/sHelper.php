<?php
namespace App\Library;
use Auth;
use Illuminate\Support\Facades\Route;
use App\PlotPaymentHistory;

class sHelper{
  
    static $notifications = null;

	public static function activeSideBar($requestPath , $urlArr){
		if(is_array($requestPath)){
			if(!empty($requestPath[0])){
				if(in_array($requestPath[0] , $urlArr)){
			  		 return "active";
				}
			}
			if(!empty($requestPath[1])){
				if(in_array($requestPath[1] , $urlArr)){
			  		 return "active";
				}
			}
		}else{
			if(in_array($requestPath , $urlArr)){
			   return "active";
			 }
		}
	 return false;
	}
	
	public static function openSideBar($requestPath , $urlArr){
		if(is_array($requestPath)){
			if(!empty($requestPath[0])){
				if(in_array($requestPath[0] , $urlArr)){
			  		 return "menu-open";
				}
			}
			if(!empty($requestPath[1])){
				if(in_array($requestPath[1] , $urlArr)){
			  		 return "menu-open";
				}
			}
		}else{
			if(in_array($requestPath , $urlArr)){
			   return "menu-open";
			}
		}
	 return false;
	
	}
	
	
	public static function getBookingFullName($booking){
		return $booking->first_name." ".$booking->last_name;
    }
	
	public static function returnBookingColor($bookingStatus){
		if($bookingStatus == 1){
		   	return ['label label-default'];
		 }
		 if($bookingStatus == 2){
		   	return ['label label-primary'];
		 }
		if($bookingStatus == 3){
		   	return ['label label-success'];
		 }
		if($bookingStatus == 4){
		   	return ['label label-warning'];
		}
		
		
    }

	public static function getFullName($user){
		return $user->f_name." ".$user->l_name;
    }

	public static function customerID($id){
		return date('mdY')."00".$id;
	}

	public static function partnerID($id){
		return "LAKHANIS-".$id;
	}

	public static function societyID($id){
		return "SOCIETY-".$id;
	}

	public static function user_id($id){
		return "DOYCSUSR-".$id;
	}

	public static function hotel_address($hotel){
		return $hotel->address;
	}

	public static function image_url($status , $image_name = NULL){
		if(!empty($image_name)){
			switch ($status) {
				case 2:
				return url("storage/profile_image/$image_name");;
				break;
				case 'C':
				return '<span class="badge badge-danger">Closed</span>';
				break;
				default:
				return '';
			 }
		}
		else{
			return "http://services.officinetop.com/public/storage/products_image/no_image.jpg";
		}
	}

	 public static function send_otp($mobile , $otp){
        if(!empty($mobile)){
            //$action = "http://cdn.softica.in/sendsms/sendsms.php?username=STsetcar&password=carset&type=TEXT&sender=SETCAR&mobile=".$mobile."&message=".$otp;
            $action = "http://cdn.softica.in/sendsms/sendsms.php?username=STdoyca&password=DOYC123&type=TEXT&sender=RDOYCA&mobile=".$mobile."&message=".$otp;

           //$action = "http://sms.prowtext.com/sendsms/sendsms.php?username=STFRMSTP&password=Farm123&type=TEXT&sender=FRMSTP&mobile=8887603331&message=FSCRWDP";
			$ret = file($action);
			$sess = explode(":",$ret[0]);
			if ($sess[0] != "OK"){    
				$result = $ret[0];
				return $result;
			}
			else{
				echo "Authentication failure: ". $ret[0];
			}
    	}
	}
	


	public static function brokerCommision($plotValue , $brokerCommision){
		$plotBrokerCommision = ($plotValue * $brokerCommision) / 100;
		return $plotBrokerCommision;
	}

	public static function tableTrClass($bookingStatus){
		if($bookingStatus == 3){
			return "table-danger";
		}

		if($bookingStatus == 1){
			return "table-default";
		}

		if($bookingStatus == 4){
			return "table-success";
		}
		if($bookingStatus == 2){
			return "table-warning";
		}
		return FALSE;
	}



	public static function returnPlotDescription($plotDetail){
		return $plotDetail->plot_area." ".$plotDetail->plot_size_in_gaj." Gaj ".$plotDetail->plot_number;
	}


	public static function returnPaymentMethodStatus(PlotPaymentHistory $plotPayment){
		$paymentObj = new PlotPaymentHistory;
		if(!empty($plotPayment->payment_method)){
			if(array_key_exists($plotPayment->payment_method, $paymentObj->paymentMethodStatus)){
				$plotPayment->PaymentMethodStatus = $paymentObj->paymentMethodStatus[$plotPayment->payment_method];
			}
		}
		return $plotPayment;
	}

	

	  
}