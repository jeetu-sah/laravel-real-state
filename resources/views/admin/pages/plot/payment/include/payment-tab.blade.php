@if(!empty($plotsDetails->buyer_id))
<a href='{{ route('admin.plot.payment.add',[$plotsDetails->id]) }}' 
        data-toggle="tooltip" 
        title="Add Payment Detail"
        class="btn btn-success float-right" 
        style="margin-right:5px;">
            <i class="fas fa-plus"></i> 
           	 Add Payment Detail
</a>
<a href='{{ route('admin.plot.plot-detail',[$plotsDetails->id]) }}' 
    data-toggle="tooltip" 
    title="Payment History" 
    class="btn btn-primary float-right" 
    style="margin-right:5px;">
<i class="fas fa-list"></i> 
Payment History
</a>
@endif