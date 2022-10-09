<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlotPaymentHistory extends Model
 {

    use SoftDeletes;

    protected $table = 'plot_payment_histories';

    protected $fillable = ['id',
    'society_plots_number_id',
    'payment_holder_id',
    'buyer_name', 'buyer_mobile_number',
    'payment_method',
    'reference_number', 'branch_name',
    'paid_amount', 'remain_amount',
    'paid_amount_date',
    'payment_file',
    'bank_detail',
    'emai_status',
    'installment_number',
    'deleted_at',
    'created_at',
    'updated_at'];

    public $paymentMethodStatus = [1=>'Cheque', 2=>'Cash', 3=>'Net Banking'];

    public function plotNumber() {
        return $this->belongsToMany( 'App\SocietyPlotsNumber', 'society_plots_number_id', 'id' );
    }

    public function plotPayments() {
        return $this->belongsToMany( 'App\SocietyPlotsNumber', 'society_plots_number_id', 'id' );
    }

    public function plotNumberDetail() {
        return $this->belongsToMany( 'App\SocietyPlotsNumber', 'society_plots_number_id', 'id' );
    }

    public function plotPaymentHistory() {
        return $this->belongsTo( 'App\SocietyPlotsNumber', 'society_plots_number_id', 'id' );
    }

    public function setFirstNameAttribute( $value ) {
        return 'society_plots_number_id';
    }

}
