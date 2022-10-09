@extends('layouts.site.master')
@section('content')
<div id="wrapper">
  @if($society != NULL)
    <!-- content-->
    <div class="content">
                   <section>
      <div class="ct-site--map">
        <div class="container">
            <ul id="breadcrumbs" class="breadcrumbs">
              <li class="item-home">

                <a class="bread-link bread-home" href="#" title="Homepage">Homepage</a>

              </li>
              <li class="item-home">
                <a class="bread-link bread-home" href="#" title="Homepage">Society </a>
              </li>
              <li class="item-current item-1005">
              	<strong class="bread-current bread-1005">{{ $society->name ?? "Unknown"}}</strong>

              </li>

            </ul>        

        </div>

    </div>

</section>

<section>

      <div class="single-mediaSection">

          <div class="container">

            <div class="single-heading--main">

                  <h2 class="text-white text-uppercase">{{ $society->name ?? "Unknown"}}</h2>
                  <span class="d-inline-block textspan">Property ID: {{ sHelper::societyID($society->id) }}</span>

            </div>

          </div>

      </div>

</section>

<section class="section section-lg bg-gray-lighter novi-background bg-cover">

    <div class="container">

        <div class="row">
                    <div class="col-lg-8 my-5">
                        <div class="entry2image">
                           @if($societyMap != NULL)
                            <img src="{{ $societyMap->image_name_url }}" alt="Image" class="img-fluid">
                            
                           @endif
                        </div>
                    </div>
        </div>

    </div>

</section>





  <!-- The Modal -->

  <div class="modal" id="myModal">

    <div class="modal-dialog">

      <div class="modal-content">

      

        <!-- Modal Header -->

        <div class="modal-header">

          <h4 class="modal-title">Detox Formula Detox Supplement 1</h4>

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        

        <!-- Modal body -->

        <div class="modal-body">

          <form>

              <div class="row">

                    <div class="col-sm-6">

                        <div class="form-group">

                            <input type="text" name="" placeholder="Name" class="form-control" />

                        </div>

                    </div>

                    <div class="col-sm-6">

                        <div class="form-group">

                            <input type="text" name="" placeholder="Last Name" class="form-control" />

                        </div>

                    </div>

              </div>

               <div class="row">

                    <div class="col-sm-6">

                        <div class="form-group">

                            <input type="Email" name="" placeholder="Email" class="form-control" />

                        </div>

                    </div>

                    <div class="col-sm-6">

                        <div class="form-group">

                            <input type="Number" name="" placeholder="Mobile No." class="form-control" />

                        </div>

                    </div>

              </div>

               <div class="row">

                    <div class="col-sm-12">

                        <div class="form-group">

                            <textarea type="text" rows="2" class="form-control" placeholder="Message"></textarea>

                        </div>

                    </div>

              </div>

              <div class="">

                  <button type="Submit" class="btn weight--semibold login-button btn--green">Submit</button>

              </div>

          </form>

        </div>

      </div>

    </div>

  </div>

                    <!-- section end -->

                </div>
  @else
    <h2>Something went wrong , please try again !!!</h2>
  @endif           
</div>

@stop