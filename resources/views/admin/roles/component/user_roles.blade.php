    <!-- Main content -->
    <div class="content header_margin">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">User roles list  </h5>
              </div>
                <div class="card-body">
                  @if(Session::has('msg'))
                  {!!  Session::get("msg") !!}
                  @endif
                  <table class="table table-bordered table-striped" id="roles-table">
                    <thead>
                        <tr>
                          <th>Select All<div class="form-group">
                           <input type="checkbox" class="select_all" name="select_all" />
                    </div></th>
                          <th>Name</th>
                          <th>Display Name</th>
                          <th>Description</th>
                        </tr>
                    </thead>
                    <tfoot>
                      <tr>
                         <th>Select All<div class="form-group">
                           <input type="checkbox" class="select_all" name="select_all" />
                    </div></th>
                          <th>Name</th>
                          <th>Display Name</th>
                          <th>Description</th>
                        </tr>
                  </tfoot>
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
  <!-- /.content-wrapper -->

