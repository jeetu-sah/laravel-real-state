<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocietyPlotsNumber extends Model
 {
    protected $table = 'society_plots_numbers';

    protected $fillable = ['id',
    'society_id', 
    'society_plot_id',
    'plot_number',
    'plot_value',
    'plot_size_in_gaj', 
    'plot_area',
    'booking_status',
    'hold_date',
    'user_id',
    'broker_id',
    'buyer_id',
    'broker_commission',
    'buyer_name', 'buyer_mobile_number',
    'booking_date',
    'priority',
    'emi_status',
    'down_payment_amount',
    'number_of_emi',
    'payment_of_emi',
    'created_at',
    'updated_at'];

    public  $plotBookingStatuName = [1=>'Non Booked', 2=>'Hold', 3=>'Booked', 4=>'Registery'];

    public  $plotBookingStatuForAgent = [2=>'Hold', 3=>'Booked'];

    public function plotSociety() {
        return $this->belongsTo( 'App\Society', 'society_id' );
    }

    public function plotBlock() {
        return $this->belongsTo( 'App\SpcietyRooms', 'society_plot_id' );
    }

    public function plotPayments() {
        return $this->hasMany( 'App\SpcietyRooms' );
    }

    public function brokerDetails() {
        return $this->belongsTo( 'App\SocietyPlotsNumber' );
    }

    public function plotNumber() {
        return $this->belongsTo( 'App\User','user_id' );
    }

    public function plotPaymentHistory() {
        return $this->hasMany( 'App\PlotPaymentHistory', 'society_plots_number_id' );
    }

    public function buyerDetails() {
        return $this->belongsTo( 'App\User', 'buyer_id');
    }

    public function brokerDetail() {
        return $this->belongsTo( 'App\User', 'buyer_id');
    }

}
