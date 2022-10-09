
              <div class="card-header">
                <h5 class="m-0">Payment History </h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                <div class="table-responsive">
                  <!--include payment history from component folder--->
                  <table class="table table-bordered table-striped" id="paymentHistoryTable">
                    <thead>
                        <tr>
                          <th>Payment date</th>
                          <th>Paid Amount</th>
                          <th>Payment Method</th>
                          <th>Bank Details</th>
                          <th>Image</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @forelse($plotsDetails->paymentHistory as $payment)
                        <tr>
                          <td>{{  \Carbon\Carbon::parse($payment->paid_amount_date)->format(config('app.date_format')) }}</td>
                          <td>{{ $payment->paid_amount ?? 0 }}</td>
                          <td>
                            @if(array_key_exists($payment->payment_method , $plotsDetails->paymentMethodArr))
                               {{ $plotsDetails->paymentMethodArr[$payment->payment_method] }}
                            @endif
                            @if(!empty($payment->reference_number))
                              ( {{ $payment->reference_number }} )  
                            @endif
                          </td>
                          <td>{{ $payment->bank_detail ?? 0 }}</td>
                            <th>
                                @if(!empty($payment->payment_file))
                                  <a target="_blank" href="{{$payment->payment_file}}">Click To view<a/> 

                                @else
                                    {{ "N/A" }}
                                @endif
                            
                              </th>
                           <th>
                            @if(!empty($plotsDetails->emi_status))
                              <a href='{{ url("common/invoice/$payment->id") }}' target="_blank" data-toggle="tooltip" title="Print Invoice" class="btn btn-warning float-right" style="margin-right:5px;" onClick="confirm('Are you sure want to print invoice ?')" >
                              <i class="fas fa-print"></i>
                              </a>
                            @endif

                            <a href='{{ url("admin/plots/removePayemntHistory/$payment->id") }}' data-toggle="tooltip" title="Delete" class="btn btn-danger float-right" style="margin-right:5px;" onClick="confirm('Are you sure want to remove this ?')" >
                <i class="fas fa-trash"></i>
                		      	</a>
                          <a href='{{ url("admin/plots/editPlotPaymentDetail/$payment->id") }}' data-toggle="tooltip" title="Edit" class="btn btn-primary float-right" style="margin-right:5px;">
                <i class="fas fa-edit"></i>
                			    </a>
                			</th>
                        </tr>
                      @empty
                         <tr colspan="5">
                          <th>No history available !!!</th>
                        </tr>
                      @endforelse
                    </tbody>
                    <tfoot>
                      <tr>
                          <th>Payment date</th>
                          <th>Paid Amount</th>
                          <th>Payment Method</th>
                          <th>Bank Details</th>
                          <th>Action</th>
                        </tr>
                  </tfoot>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
          
