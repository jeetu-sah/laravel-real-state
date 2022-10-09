<?php
namespace App\Traits;

use Illuminate\Http\Request;
use DB;
use Auth;

trait AdminTraits {

    /**
     * Does very basic image validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @return $this|false|string
     */
    public function allNotification() {
       return  DB::table('notifications')->where([['notifiable_id','=',Auth::user()->id]])->orderBy('created_at','DESC')->get();
    }

}
