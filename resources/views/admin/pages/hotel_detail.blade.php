@extends('admin.component.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img height="100" width="100" class="profile-user-img img-fluid img-circle"
                       src="@if(!empty($primary_image)) {{ $primary_image->image_name_url }} @else {{ asset('public/admin_webu/dist/img/hotel-default.jpg') }} @endif"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $hotel->name }}</h3>

                <p class="text-muted text-center">{{ $hotel->city_name }}</p>

                <!-- <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>
 -->
                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Basic Information</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Location</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Facilities</a></li>
                  <li class="nav-item"><a class="nav-link" href="#social-link" data-toggle="tab">Social Link</a></li>
                  <li class="nav-item"><a class="nav-link" href="#gallery" data-toggle="tab">Gallery</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <form class="form-horizontal">
                      <div class="card-body">
                      <strong><i class="fas fa-book mr-1"></i> Hotel Title</strong>

                <p class="text-muted">
                  {{ $hotel->name }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Keywords</strong>

                <p class="text-muted">
                  {{ $hotel->meta_key_word }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Description</strong>

                <p class="text-muted">
                  {{ $hotel->description }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Email</strong>

                <p class="text-muted">
                  {{ $hotel->email }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Phone</strong>

                <p class="text-muted">
                  {{ $hotel->phone_number }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Website</strong>

                <p class="text-muted">
                  {{ $hotel->website_link }}
                </p>
                <hr>
              </div>
                      
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <form class="form-horizontal">
                      <div class="card-body">
                      <strong><i class="fas fa-book mr-1"></i> Address</strong>

                <p class="text-muted">
                  {{ $hotel->address }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Latitude</strong>

                <p class="text-muted">
                  {{ $hotel->address_lat }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Longitude</strong>

                <p class="text-muted">
                  {{ $hotel->address_lang }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> City</strong>

                <p class="text-muted">
                  {{ $hotel->city_name }}
                </p>
                <hr>
              </div>
                      
                    </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="card-body">
                      <strong><i class="fas fa-book mr-1"></i> Features</strong>

                <p class="text-muted">
                  @forelse($features as $feature)
                      {{ $loop->iteration.'. '.$feature->hotel_restaurant_features->name }}<br>
                  @empty

                  @endforelse
                </p>
                <hr>
                
              </div>
                      
                    </form>
                  </div>

                  <div class="tab-pane" id="social-link">
                    <form class="form-horizontal">
                      <div class="card-body">
                      <strong><i class="fas fa-book mr-1"></i> Facebook</strong>

                <p class="text-muted">
                  {{ $hotel->facebook_page_link }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Youtube</strong>

                <p class="text-muted">
                  {{ $hotel->instagram_link }}
                </p>
                <hr>
                <strong><i class="fas fa-book mr-1"></i> Instagram</strong>

                <p class="text-muted">
                  {{ $hotel->yt_channel_link }}
                </p>
                <hr>
                
              </div>
                      
                    </form>
                  </div>




                  <div class="tab-pane" id="gallery">
                    <form class="form-horizontal">
                      <div class="card-body">
                        @forelse($gallery as $img)
                            <img src='{{ $img->image_name_url }}'  alt="" height="100" width="100">
                        @empty

                        @endforelse
                        
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @stop