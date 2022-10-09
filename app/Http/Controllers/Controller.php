<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController{


    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
   public $image_ext = array("jpeg" , "png" , "jpg" , "JPEG" , "PNG" ,"JPG");
   public $document_ext = array("jpeg" , "png" , "jpg" , "JPEG" , "PNG" ,"JPG");
   public $docsExtArr = array("jpeg" , "png" , "jpg" , "JPEG" , "PNG" ,"JPG","DOC" ,"PDF","pdf" , "docx");



    public function societyPdfMap($request){
		$image_arr = [];
		$image_path = public_path('storage/society/pdfMap');
		$image_path_2 = url("public/storage/society/pdfMap");
		if(!is_dir($image_path)){ mkdir($image_path, 0755 , true); }
		if(!empty($request->society_pdf_map)){
			$image = $request->society_pdf_map;
			$ext = $image->getClientOriginalExtension();
			 
			if($ext == "pdf") {
				$file_name = md5(microtime().uniqid().rand(9 , 9999)).".".$image->getClientOriginalExtension();
				$image->move($image_path  , $file_name);
				$file_name_path = $image_path_2."/".$file_name;
				$image_arr = [200 , $file_name , $file_name_path];
				return $image_arr;
			  }else{
				  return [100];
			  }
		 } 
	}
   
	
   /*Country city image*/
    public function upload_hotels_offer_image($request){
	   	$image_arr = [];
		$image_path = public_path('storage/hotel/offers');
		$image_path_2 = url("public/storage/hotel/offers");
		if(!is_dir($image_path)){ mkdir($image_path, 0755 , true); }
		if(!empty($request->image)){
			$image = $request->image;
			$ext = $image->getClientOriginalExtension();
			 if(in_array($ext , $this->image_ext)) {
				$file_name = md5(microtime().uniqid().rand(9 , 9999)).".".$image->getClientOriginalExtension();
				$image->move($image_path  , $file_name);
				$file_name_path = $image_path_2."/".$file_name;
				$image_arr = [$file_name , $file_name_path];
				return $image_arr;
			  }
		 } else{ 
			return $image_arr; 
		 }  
	}

	/*Country city image*/
    public function society($request){
	   	$image_arr = [];
		$image_path = public_path('storage/society/');
		$image_path_2 = url('public/storage/society/');
		if(!is_dir($image_path)){ mkdir($image_path, 0755 , true); }
		if(!empty($request->image)){
			$image = $request->image;
			$ext = $image->getClientOriginalExtension();
			 if(in_array($ext , $this->docsExtArr)) {
				$file_name = md5(microtime().uniqid().rand(9 , 9999)).".".$image->getClientOriginalExtension();
				$image->move($image_path  , $file_name);
				$file_name_path = $image_path_2."/".$file_name;
				$image_arr = [200 , $file_name , $file_name_path];
				return $image_arr;
			  }else{
				return [100 , NULL , NULL];
			  }
		 } else{ 
			return $image_arr; 
		 }  
	}

    public function upload_image($request){
	   	$image_arr = [];
		$image_path = public_path('storage/proof/');
		$image_path_2 = url('public/storage/proof/');
		if(!is_dir($image_path)){ mkdir($image_path, 0755 , true); }
		if(!empty($request->image)){
			$image = $request->image;
			$ext = $image->getClientOriginalExtension();
			 if(in_array($ext , $this->image_ext)) {
				$file_name = md5(microtime().uniqid().rand(9 , 9999)).".".$image->getClientOriginalExtension();
				$image->move($image_path  , $file_name);
				$file_name_path = $image_path_2."/".$file_name;
				$image_arr = [$file_name , $file_name_path];
				return $image_arr;
			  }
		 } else{ 
			return $image_arr; 
		 }  
	}


	/*upload hotel images */
	public function societyImage($request){
		$main_image_arr = [];
		$image_path = public_path('storage/society/societyImage/');
		$image_path_2 = url('public/storage/society/societyImage/');
		if(!is_dir($image_path)){ mkdir($image_path, 0755 , true); }
		if(count($request->spcity_photos) > 0){
			foreach($request->spcity_photos as $image){
				//$image = $photo->photos;
				$ext = $image->getClientOriginalExtension();
				 if(in_array($ext , $this->image_ext)) {
					$file_name = md5(microtime().uniqid().rand(9 , 9999)).".".$image->getClientOriginalExtension();
					$image->move($image_path  , $file_name);
					$file_name_path = $image_path_2."/".$file_name;
					$main_image_arr[] = [$file_name , $file_name_path];
				}
			}
		}
		return $main_image_arr;
	}
	/*End*/

	/*upload hotel images */
	public function paymentScreenShots($request){
		$main_image_arr = [];
		$image_path = public_path('storage/society/paymentScreenShots');
		$image_path_2 = url('public/storage/society/paymentScreenShots/');
		if(!is_dir($image_path)){ mkdir($image_path, 0755 , true); }
		if(!empty($request->file)){
			$image = $request->file;
			$ext = $image->getClientOriginalExtension();
			 if(in_array($ext , $this->image_ext)) {
				$file_name = md5(microtime().uniqid().rand(9 , 9999)).".".$image->getClientOriginalExtension();
				$image->move($image_path  , $file_name);
				$file_name_path = $image_path_2."/".$file_name;
				$image_arr = [$file_name , $file_name_path];
				return $image_arr;
			  }
		 } else{ 
			return NULL; 
		 }  
	}
	/*End*/
}
