<div class="card-header">
                     <h5 class="m-0">Manage Plots Payment Details</h5>
                  </div>
                  <div class="card-body">
                     @if(Session::has('msg'))
                     {!!  Session::get("msg") !!}
                     @endif
                     @if ($errors->any())
                     @foreach ($errors->all() as $error)
                     <div class="notice notice-danger notice">
                        {{  $error }}
                     </div>
                     @endforeach
                     @endif
                    <form method="POST" action="{{ route('admin.plots.savePlotPayment') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="plotNumberID" id="plotNumberID" value="{{ $plotsDetails->id ?? 0 }}" readonly="readonly" />
                            <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select booking Status <span class="text-danger">*</span> </label>
                                        <div class="input-group">
                                            <select class="form-control booking_status" name="booking_status">
                                                @foreach($plotsDetails->plotsBookingStatusArr as $key=>$bookingStatus)
                                                   <option value="{{$key}}" {{ ($plotsDetails->booking_status == $key) ? 'selected' : "" }}>{{ $bookingStatus }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select booking Date <span class="text-danger">*</span> </label>
                                        <div class="input-group">
                                           <input type="date" class="form-control" placeholder="Select date" name="booking_date" value="{{ old('booking_date') }}">
                                        </div>
                                    </div>
                                 </div>
                            </div>
                            <div class="row">   
                                  <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Select Broker Name  </label>
                                       <div class="input-group">
                                          <select class="form-control broker" name="broker" id="broker">
                                          <option value="0">Select Broker </option>
                                             @foreach($plotsDetails->brokers as $broker)
                                             <option value="{{$broker->id}}" {{ ($plotsDetails->broker_id == $broker->id) ? 'selected' : "" }} >{{$broker->f_name}}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Broker Commision <span class="text-danger"> *</span></label>
                                       <div class="input-group">
                                          <input type="text" class="form-control" placeholder="Broker Commission" name="broker_commision" id="broker_commision" required="required" value="{{ $plotsDetails->broker_commision }}" />
                                       </div>
                                    </div>
                                 </div>
                           </div>
                           <div class="row">     
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                       <label>Select Buyer <span class="text-danger">*</span></label>
                                       <div class="input-group">
                                            <select class="form-control buyer" name="buyer" id="buyer">
                                             @foreach($plotsDetails->buyers as $buyer)
                                                <option value="{{$buyer->id}}">{{$buyer->f_name}}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                           </div>
                         
                        @if($plotsDetails->emi_status == 1)
                        <div style="margin-top:50px;">
                           <div class="colo-sm-12">
                              <label>EMI Details</label>
                              <hr />
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Down Payment Amount <span class="text-danger">*</span> </label>
                                       <div class="input-group">
                                          <input type="number" class="form-control" placeholder="Down Payment Amount" name="down_payment_amount" id="down_payment_amount" value="{{ old('down_payment_amount') }}" />
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label> Number of EMI in Month </label>
                                       <div class="input-group">
                                           <input type="number" class="form-control" placeholder="Number of EMI" name="number_of_emi" id="number_of_emi" value="{{ old('number_of_emi') }}" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                       <label>EMI Payment Amount <span class="text-danger">*</span> </label>
                                       <div class="input-group">
                                          <input type="number" class="form-control" placeholder="EMI Payment Amount" name="emi_payment_amount" id="emi_payment_amount" value="{{ old('emi_payment_amount') }}" />
                                       </div>
                                    </div>
                                 </div>
                               
                              </div>
                           </div>
                           <hr />
                        </div>
                        @endif
                        <div style="margin-top:50px;">
                           <div class="colo-sm-12">
                              <label>Payment Details</label>
                              <hr />
                              
                              <div class="row">     
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Select Payment Holder Name <span class="text-danger">*</span> </label>
                                        <div class="input-group">
                                            <select class="form-control payment_holder_name" name="payment_holder_name">
                                            @foreach($plotsDetails->mainOwners as $owner)
                                              <option value="{{ $owner->id }}">{{ $owner->f_name }} </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Select Payment Method<span class="text-danger">*</span></label>
                                       <div class="input-group">
                                          <select class="form-control payment_type" name="payment_type" id="payment_type">
                                             <option value="0">Select Payment Method </option>
                                             <option value="1"> Cheque </option>
                                             <option value="2"> Cash </option>
                                             <option value="3"> Net Banking </option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label> Plot Value <span class="text-danger">*</span> </label>
                                       <div class="input-group">
                                          <input type="number" class="form-control" placeholder="Total Plot Amount" name="total_plot_amount" id="total_plot_amount" value="{{ $plotsDetails->plot_value ?? 0 }}" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row" style="display:none;" id="referenceNumberDiv">
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Enter the Check/ Net Banking Reference Number </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder=" Check/ Net Banking Reference Number" name="reference_number" id="reference_number" />
                                        </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Branch Name </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Branch Name" name="branch_name" id="branch_name" value="{{ old('branch_name') }}" />
                                        </div>
                                    </div>
                                 </div>

                            </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Pay Amount <span class="text-danger">*</span> </label>
                                       <div class="input-group">
                                          <input type="number" class="form-control" placeholder="Payment Amount" name="payment_amount" id="payment_amount" value="{{ old('payment_amount') }}" />
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Remain Payment Amount </label>
                                       <div class="input-group">
                                           <input type="number" class="form-control" placeholder="Remain Payment Amount" name="remain_payment_amount" id="remain_payment_amount" value="{{$plotsDetails->remainAmount ?? 0 }}" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Select Date  <span class="text-danger">*</span></label>
                                       <div class="input-group">
                                          <input type="date" class="form-control" placeholder="Select date" name="payment_date" value="{{ old('payment_date') }}" />
                                       </div>
                                    </div>
                                 </div>


                                 <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Choose File Cheque / Payment Screenshots </label>
                                       <div class="input-group">
                                          <input type="file" class="form-control" name="file" />
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label>Comments </label>
                                 <textarea name="bank_details" id="bank_details" class="form-control" placeholder="Comments" rows="5"></textarea>
                              </div>
                              <div class="form-group">
                                 <div class="input-group">
                                    <button type="submit" name="save_category" class="btn btn-success">Save </button>
                                 </div>
                              </div>
                           </div>
                           <hr />
                        </div>
                     </form>
                  </div>
