<?php
namespace App\Traits;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\SocietyPlotsNumber;
use App\Society;
use App\SpcietyRooms;

trait HomeTraits {

    /**
     * Does very basic image validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @return $this|false|string
     */

    public function societies() {
          $societies= Society::with(['society_map'])->where([['status','=','A']])->get();
          return $societies;
    }

    public function societyBlocks($societySlug){
        $society = Society::with(['blocks'])->where([['slug_name','=',$societySlug]])->first();
        return $society;
    }

    public function societyBlocksPlots($blockId){
        $blockSocietyPlotNumber = NULL;
        if(!empty($blockId)){
            $plotNumberObj = new SocietyPlotsNumber;
            $blockSocietyPlotNumber = SpcietyRooms::with(['blockPlotsNumber','blocks'])->find($blockId);
            if($blockSocietyPlotNumber != NULL){
                $blockSocietyPlotNumber->bookingStatusArr = NULL;
                $blockSocietyPlotNumber->bookingStatusArr = $plotNumberObj->plotBookingStatuName;
            }
        }
        return $blockSocietyPlotNumber;
    }

}
