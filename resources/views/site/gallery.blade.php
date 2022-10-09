@extends('layouts.site.master')
@section('content')
<section>
      <div class="ct-site--map">
        <div class="container">
            <ul id="breadcrumbs" class="breadcrumbs">
              <li class="item-home">
                <a class="bread-link bread-home" href="#" title="Homepage">Homepage</a>
              </li>
              <li class="separator separator-home"> 
              </li>
              <li class="item-current item-1005"><strong class="bread-current bread-1005"> Gallery Us</strong>
              </li>
            </ul>        
        </div>
    </div>
</section>
<section>
      <div class="single-mediaSection">
          <div class="container">
            <div class="single-heading--main">
                  <h2 class="text-white text-uppercase">Gallery Us</h2>
                  <span class="d-inline-block textspan">Gallery Page</span>
            </div>
          </div>
      </div>
</section>
<section class="my-5">
<div class="container">	
	<div class="row">
		<div class="col-md-12"> 
			<div class="py-3">
				<ul class="nav nav-tabs" role="tablist">
					@foreach($societies as $society)
					<li class="nav-item">
						<a class="<?php if($society->id == $mainSociety->id) echo "active"; ?>" data-toggle="tab" href="#<?php if(!empty($society->id)) echo $society->id; ?>">{{ $society->name ?? "" }}</a>
					</li>
					@endforeach
		        </ul>
                <div class="tab-content">
                 @forelse($societies as $society)
                  <div id="<?php if(!empty($society->id)) echo $society->id; ?>" class="container tab-pane <?php if($society->id == $mainSociety->id) echo "active"; ?>">
                   <div class="gallery-grids">
					<div class="gallery-top-grids">
                      @php
                        $societyImages = $society->society_map->where('type',2);
                      @endphp
                      @forelse($societyImages as $sImage)
                       @if($sImage->image_name_url)
                       	<div class="col-sm-4 gallery-grids-left">
						<div class="gallery-grid">
						   <a class="example-image-link" href="{{ $sImage->image_name_url }}" data-lightbox="example-set" data-title="lakhmani">
							<img src="{{ $sImage->image_name_url }}" alt="lakhmani">
							<div class="w3captn-agileits">
								<h4>Our Gallery</h4>
								<p>lakhmani</p>
							</div>
						</a>
					</div>
					  </div>
                       @endif
                      @empty 
                        <div class="col-sm-4 gallery-grids-left">
							<div class="gallery-grid">
						   		<h2>No Image Available !!!</h2>
							</div>
					  </div>
                      @endforelse
                      
			        </div>
				 </div>
                 
                  </div>
                 @empty
                   <h2>No Image Found !!!</h2>
                 @endforelse
                </div>
			</div>
		</div>
	</div>
</div>	
</section>
@stop