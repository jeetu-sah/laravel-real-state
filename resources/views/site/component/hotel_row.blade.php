@forelse($hotels as $hotel)
<article class="geodir-category-listing fl-wrap"  style="margin-top:5px;">
<div class="geodir-category-img">
    @php
        $imageCollection = $hotel->hotels_restaurant_gallery->where('status',1)->first();
    @endphp
    <a href="{{ url('hotel') }}">
        <img src="{{ $imageCollection->image_name_url }}" alt="" />
    </a>
    <div class="sale-window">Sale 20%</div>
    <div class="geodir-category-opt">
        <div class="listing-rating card-popup-rainingvis" data-starrating2="5"></div>
        <div class="rate-class-name">
            <div class="score"><strong>Very Good</strong>27 Reviews </div>
            <span>5.0</span>                                             
        </div>
    </div>
</div>
<div class="geodir-category-content fl-wrap title-sin_item">
        <div class="geodir-category-content-title fl-wrap">
            <div class="geodir-category-content-title-item">
                <h3 class="title-sin_map">
                  <a href="{{ url('hotel') }}">{{ $hotel->name ?? "N/A" }}</a>
                </h3>
                <div class="geodir-category-location fl-wrap">
                    <a href="javascript::void()" class="map-item">
                        <i class="fas fa-map-marker-alt"></i> {{ sHelper::hotel_address($hotel) }}</a>
                </div>
                <div class="geodir-opt-right-heart">
                    <div class="geodir-opt-list">
                        <a href="#" class="geodir-js-favorite"><i class="fal fa-heart"></i><span class="geodir-opt-tooltip">Favourite</span></a>
                    </div>
                </div>
            </div>
        </div>
        <p>{{ $hotel->description ?? "N/A" }}</p>
        <ul class="facilities-list fl-wrap">
            @foreach($hotel->hotels_restaurant_features as $feature)
            <li>
                @if(!empty($feature->hotel_restaurant_features->icon_code))
                    <i class="fal fa-wifi"></i><span>{{ $feature->hotel_restaurant_features->name }}</span>
                @else
                     {{-- <i class="fal fa-wifi"></i><span>{{ $feature->hotel_restaurant_features->name }}</span> --}}
                @endif
            </li>
            @endforeach
        </ul>
        <div class="geodir-category-footer fl-wrap">
            <div class="booknowbtn">
            <a href="#">Book Now</a>
            <a class="ml-1" href="{{ url('hotel') }}"> View Details</a>
                <div class="hotelroomprice">
                    <span class="finalPriceroom">₹ 1000</span><span class="finalslashPriceroom">₹ 2026</span><span class="roompercentage">39% off</span>
                </div>
            </div>
            <div class="geodir-opt-list">
                <a href="#" class="single-map-item" data-newlatitude="40.72956781" data-newlongitude="-73.99726866"><i class="fal fa-map-marker-alt"></i><span class="geodir-opt-tooltip">On the map</span></a>
                <a href="#" class="geodir-js-booking"><i class="fal fa-exchange"></i><span class="geodir-opt-tooltip">Find Directions</span></a>
            </div>
        </div>
</div>
</article>                                            
@empty
@endforelse