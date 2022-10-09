 <div class="content header_margin">
    	<div class="container-fluid">
          <div class="row">
          	<div class="col-lg-12">
              	 <a href='{{ url("admin/plots/$societyDetails->id") }}' data-toggle="tooltip" title="Society Plots List" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-list"></i> 
                     Blocks List
                  </a>
                  <a href='{{ url("admin/plots/add_plots/$societyDetails->id") }}' data-toggle="tooltip" title="Create New Blocks" class="btn btn-warning float-right" style="margin-right: 5px;">
                    <i class="fas fa-plus"></i> 
                    Create New Blocks
                 </a>
                 <a href='{{ url("admin/allocate_society/$societyDetails->id") }}' data-toggle="tooltip" title="Allocate Society to Users" class="btn btn-success float-right" style="margin-right: 5px;">
                  <i class="fas fa-list"></i> 
                  Allocate Society to Users
                </a> 
            </div>
          </div>
        </div>
    </div>