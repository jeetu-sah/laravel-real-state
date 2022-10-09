<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title }}</title>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('public/admin_webu/plugins/fontawesome-free/css/all.min.css') }}" />
   <link rel="stylesheet" href="{{ asset('public/admin_webu/adminnew.css') }}">
  <!-- Theme style -->
  <!--Data table js file -->
  <link rel="stylesheet" href="{{ url('public/admin_webu/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" href="{{ url('public/admin_webu/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <!--End--->
  <link rel="stylesheet" href="{{ asset('public/admin_webu/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/admin_webu/plugins/select2/css/select2.min.css') }}">
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
  <script>
var base_url = "{{ url('') }}";
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
<style>
.header_margin{ margin-top:25px;}
.notice {
    padding: 15px;
    background-color: #fafafa;
    border-left: 6px solid #7f7f84;
    margin-bottom: 10px;
    -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
       -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
}
.notice-sm {
    padding: 10px;
    font-size: 80%;
}
.notice-lg {
    padding: 35px;
    font-size: large;
}
.notice-success {
    border-color: #80D651;
}
.notice-success>strong {
    color: #80D651;
}
.notice-info {
    border-color: #45ABCD;
}
.notice-info>strong {
    color: #45ABCD;
}
.notice-warning {
    border-color: #FEAF20;
}
.notice-warning>strong {
    color: #FEAF20;
}
.notice-danger {
    border-color: #d73814;
}
.notice-danger>strong {
    color: #d73814;
}
</style>
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('admin/dashboard') }}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown readNotification">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{ $notifications->count() ?? 0 }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">{{ $notifications->count() ?? 0 }} Notifications</span>
          @forelse($notifications as $notification)
          <div class="dropdown-divider"></div>
          <a href="<?php if(!empty($notification->data['url'])) echo $notification->data['url']; else echo "javascript::void();" ?>" class="dropdown-item">
            <i class="fas fa-bullhorn mr-2"></i>
           {{ !empty($notification->data['msg']) ? substr($notification->data['msg'] , 0 ,25) : '' }}
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          @empty
           <div class="dropdown-divider"></div>
           <a href="<?php echo url('admin/notification') ?>" class="dropdown-item">
            <i class="fas fa-bullhorn mr-2"></i>
            No Notification available !!!
            <span class="float-right text-muted text-sm"></span>
          </a>
          @endforelse
          <div class="dropdown-divider"></div>
          <a href="<?php echo url('admin/notification') ?>" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> 
    </ul> 
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @if(Auth::check())
      <a href="{{ url('admin/dashboard') }}" class="brand-link">
        <img src="{{ asset('public/admin_webu/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity:.8">
        <span class="brand-text font-weight-light">Lakhmanis</span>
      </a>
    @endif
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('public/admin_webu/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info" style="text-color:#ffff;">
          <strong style="text-color:#ffff;">
            <a href="javascript::void();">
          {{ sHelper::getFullName(Auth::user()) }}
            </a>
          </strong>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @role('admin')
          <li class="nav-item has-treeview menu-open">
            <a href="{{ url('admin/dashboard') }}" class="nav-link {{ sHelper::activeSideBar(Request::path() , ['admin/dashboard','admin','admin/dashboard/latest_payment','admin/dashboard/plots']) }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview {{ sHelper::openSideBar([Request::path() ,Route::current()->uri] , 
            ['admin/partner_list','admin/users_allocation','admin/partner/add_partner','customer/create_customer','admin/partner/{page?}/{p1?}']) }}">
            
              <a href="#" class="nav-link {{ sHelper::activeSideBar([Request::path() , Route::current()->uri],
              ['admin/partner_list','admin/users_allocation','admin/partner/add_partner','customer/create_customer','admin/partner/{page?}/{p1?}']) }} ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Manage User <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
            <ul class="nav nav-treeview">
              <li class="nav-item active">
                <a href="{{ url('admin/partner/add_partner') }}" class="nav-link {{ sHelper::activeSideBar(Request::path() , ['admin/partner/add_partner']) }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
              <li class="nav-item active">
                <a href="{{ url('customer/create_customer') }}" class="nav-link {{ sHelper::activeSideBar(Request::path() , ['customer/create_customer']) }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Customer</p>
                </a>
              </li>
              <li class="nav-item active">
                <a href="{{ url('admin/partner_list') }}" class="nav-link {{ sHelper::activeSideBar([Request::path() , Route::current()->uri], ['admin/partner_list','admin/users_allocation']) }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User  List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview {{ sHelper::openSideBar([Request::path(),Route::current()->uri] ,
          ['admin/society','admin/plots/{p1}']) }}">
            <a href="{{ url('admin/society') }}" class="nav-link {{ sHelper::activeSideBar([Request::path(),Route::current()->uri] , ['admin/society','admin/plots/{p1}']) }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Manage Society
              </p>
            </a>
          </li>
            @permission('admin-manage-roles')
              <li class="nav-item has-treeview {{ sHelper::openSideBar([Request::path(),Route::current()->uri] ,
          ['admin/roles/{page?}/{p1?}']) }}">
                <a href="#" class="nav-link {{ sHelper::activeSideBar([Request::path(),Route::current()->uri] ,
          ['admin/roles/{page?}/{p1?}']) }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Manage Roles
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/roles/manage-roles') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Users List </p>
                    </a>
                  </li>
                </ul>
              </li>
            @endpermission
              <li class="nav-item has-treeview {{ sHelper::openSideBar([Request::path(),Route::current()->uri] ,
          ['admin/notification']) }}">
                <a href="{{ url('admin/notification') }}" class="nav-link {{ sHelper::activeSideBar([Request::path(),Route::current()->uri] , ['admin/notification']) }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Notification
                  </p>
                </a>
              </li>
            <!---Super admin roles start--->
            @role('super-admin')
              @permission('manage-roles')
              <li class="nav-item has-treeview {{ sHelper::openSideBar(Request::path() , ['admin/roles','admin/roles/roles_list','admin/roles/permission_list']) }}">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Manage Roles
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/roles') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Users List </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('admin/roles/roles_list') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Roles List </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('admin/roles/permission_list') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Permission List </p>
                    </a>
                  </li>
                </ul>
              </li>
              @endpermission
            @endrole
            <!---Super admin roles management--->
          @endrole
          <!--Head Agent Strat-->
          @role('head-agent')
           <li class="nav-item has-treeview  {{ sHelper::openSideBar(Request::path() , ['partner/societies']) }}">
              <a href="#" class="nav-link {{ sHelper::activeSideBar(Request::path() , ['partner/societies']) }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Alloted Society
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('partner/societies') }}" class="nav-link {{ sHelper::activeSideBar(Request::path() , ['partner/societies','partner/block/:id']) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Societies </p>
                  </a>
                </li>
              </ul>
            </li>
           <li class="nav-item has-treeview {{ sHelper::openSideBar(Request::path() , ['head_agent/agents']) }}">
              <a href="#" class="nav-link {{ sHelper::activeSideBar(Request::path() , ['head_agent/agents']) }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Alloted Agents
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('head_agent/agents') }}" class="nav-link {{ sHelper::activeSideBar(Request::path() , ['head_agent/agents']) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Agent List </p>
                  </a>
                </li>
              </ul>
            </li>
          @endrole
          @role('agent')
           <li class="nav-item has-treeview  {{ Request::path() == 'partner/add_partner' ? 'menu-open' : '' }} ">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Alloted Society
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('partner/societies') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Societies </p>
                  </a>
                </li>
              </ul>
            </li>
          @endrole
          <!--Head Agent roles End--->
          <li class="nav-item">
            <a href="{{ url('logout') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  @yield('content')
  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a  target="_blank" href="https://jswebsolutions.in/">jswebsolutions.in</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- jQuery -->
<script src="{{ asset('public/admin_webu/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/admin_webu/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/admin_webu/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin_webu/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/admin_webu/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/admin_webu/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/admin_webu/dist/js/adminlte.min.js') }}"></script>
 @section('script')
 @show
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
  /*read and unread msg*/
  $(document).ready(function(e) {
    $(document).on('click','.readNotification',function(e){
	  $.ajax({
      url:"{{ route('markNotification') }}",
      type: "GET",
      success: function (data) {
         console.log(data);
      },
      error: function(xhr, error){
        //$("#otp_result_response").html("<div class='notice notice-danger notice'><strong>Wrong </strong> Something went wrong , please try again  !!! </div>");
        //$("#otp_div").show();
      },
      complete: function(){
        //$('#send_otp_btn').html('Submit').attr('disabled' , false);
      }
    }); 
	});
  });
  /*End*/
});
</script>
@stack('scripts')
</body>
</html>
