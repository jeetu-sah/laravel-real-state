
<div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Plots List</h5>
                 <a style="margin-bottom:10px; margin-top:-15px;" href='javascript::void();' data-toggle="tooltip" title="Create New Plots" class="btn btn-success float-right" style="margin-right:5px;" id="CreateNewPlots">
                 Create New Plots
                <i class="fas fa-plus"></i> 
                </a>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <table class="table table-bordered table-striped" id="plotNumberList">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>EMI Based</th>
                          <th>Plot Number </th>
                          <th>Plot Value </th>
                          <th>Booking Status</th>
                          <th>Plot Size (in Gaj) </th>
                          <th>Plot Area (in Gaj)</th>
                          <th>Priority</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

<!--Add new Plots ---> 
<div class="modal" id="AddPlotDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
        <h4 class="modal-title">Create New plots</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
                 <!-- <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="text-danger fa fa-times"></i></button>
                    <h4 class="modal-title" id="myModalLabel">
                    <strong>Create New plots</strong> </h4>
                  </div>-->
                    <form id="addPlotsValue">
                      @csrf
                      <input type="hidden" name="roomID" id="roomID" value="{{ $plotDetails->id ?? 0 }}" />
                      <div class="modal-body">
                        <div class="form-group">
                            <label>Plot Number&nbsp;<span class="text-danger">*</span> </label>
                             <input type="text" class="form-control" placeholder="Plot Number" name="plot_number" id="plot_number" required="required" /> 
                        </div>
								      	<div class="row">
                            <div class="col-md-12 form-group">
                                <label>Plot Value&nbsp;</label>
                                <input type="text" class="form-control" placeholder="Plot Value" name="plot_value" id="plot_value" /> 
                            </div>
                        </div>
								      	<div class="row">
                            <div class="col-md-12 form-group">
                                <label>Booking Status &nbsp;<span class="text-danger">*</span></label>
                                  <select class="form-control" name="booking_status" id="booking_status">
                                      @foreach($plotDetails->plotsBookingStatusArr as $key=>$bookingStatus)
                                        <option value="{{$key}}">{{ $bookingStatus }} </option>
                                      @endforeach
                                  </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Plot Size &nbsp;<span class="text-danger">* IN GAJ</span></label>
                                   <input type="text" class="form-control" placeholder="Plot Size" name="plot_size" id="plot_size" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Plot Area &nbsp;<span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" placeholder="Plot Area" name="plot_area" id="plot_area" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Priority &nbsp;<span class="text-danger">*</span></label>
                                   <input type="number" class="form-control" placeholder="Plot Priority" name="priority" id="priority" />
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <div id="savePlotsResponse"></div>
                          <div class="form-check form-check-inline">
                            <button type="submit" id="savePlotsBtn" class="btn bg-blue ml-3">Save Plots</button>
                          </div>
                        </div>
			            	  </div>
			              </form>
                  <div class="modal-footer">       
                </div>
              </div>
            </div>
            </div>
<!--End--> 

<!-- edit plots  Modal -->
 <div class="modal" id="editPlotDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog molal-md">
                <div class="modal-content">
                    <div class="modal-header">
        <h4 class="modal-title">Edit Plot Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
                    <form id="editPlotsForm">
                      @csrf
                      <input type="hidden" name="plotID" id="plotID" value="" />
                      <div class="modal-body">
                        <div class="form-group">
                            <label>Plot Number&nbsp;<span class="text-danger">*</span> </label>
                             <input type="text" class="form-control" placeholder="Plot Number" name="plot_number" id="plot_number" required="required" /> 
                        </div>
								      	<div class="row">
                            <div class="col-md-12 form-group">
                                <label>Plot Value&nbsp;<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Plot Value" name="plot_value" id="plot_value" required="required" /> 
                            </div>
                        </div>
								      	<div class="row">
                            <div class="col-md-12 form-group">
                                <label>Booking Status &nbsp;<span class="text-danger">*</span></label>
                                  <select class="form-control" name="booking_status" id="booking_status">
                                      @foreach($plotDetails->plotsBookingStatusArr as $key=>$bookingStatus)
                                        <option value="{{$key}}">{{ $bookingStatus }} </option>
                                      @endforeach
                                  </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Plot Size &nbsp;<span class="text-danger">* IN GAJ</span></label>
                                   <input type="text" class="form-control" placeholder="Plot Size" name="plot_size" id="plot_size" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Plot Area &nbsp;<span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" placeholder="Plot Area" name="plot_area" id="plot_area" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Priority &nbsp;<span class="text-danger">*</span></label>
                                   <input type="number" class="form-control" placeholder="Plot Priority" name="priority" id="priority" />
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                          <div id="editPlotsResponse"></div>
                          <div class="form-check form-check-inline">
                            <button type="submit" id="editPlotsBtn" class="btn bg-blue ml-3">Edit Plots</button>
                          </div>
                        </div>
			            	  </div>
			              </form>
                  <div class="modal-footer">       
                </div>
              </div>
            </div>
            </div>
<!-- fim Modal-->    