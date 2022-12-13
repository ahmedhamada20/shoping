@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-xl-3 col-lg-6 col-12">
    <div class="card">
      <div class="card-content">
        <a href="{{route('drivers.index')}}"> 
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-primary bg-darken-2">
              <i class="icon-camera font-large-2 white"></i>
            </div>
            <div class="p-2 bg-gradient-x-primary white media-body">
              <h5>Drivers</h5>
              <h5 class="text-bold-400 mb-0"><i class="ft-users"></i> {{$drivers}}</h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-12">
    <div class="card">
      <div class="card-content">
        <a href="{{route('users.index')}}">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-danger bg-darken-2">
              <i class="icon-user font-large-2 white"></i>
            </div>
            <div class="p-2 bg-gradient-x-danger white media-body">
              <h5>New Users</h5>
              <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i>{{$users}}</h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-12">
    <div class="card">
      <div class="card-content">
        <a href="{{route('packages.view')}}">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-warning bg-darken-2">
              <i class="icon-basket-loaded font-large-2 white"></i>
            </div>
            <div class="p-2 bg-gradient-x-warning white media-body">
              <h5>New Orders</h5>
              <h5 class="text-bold-400 mb-0"><i class="ft-arrow-down"></i> {{$orders}}</h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-12">
    <div class="card">
      <div class="card-content">
        <a href="{{route('contact.view')}}">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-success bg-darken-2">
              <i class="icon-wallet font-large-2 white"></i>
            </div>
            <div class="p-2 bg-gradient-x-success white media-body">
              <h5>Total Enquries</h5>
              <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i> {{$contacts}}</h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- <div class="row match-height">
  <div class="col-xl-4 col-lg-12">
    <div class="card bg-gradient-x-danger">
      <div class="card-content">
        <div class="card-body">
          <div class="animated-weather-icons text-center float-left">
            <svg version="1.1" id="cloudHailAlt2" class="climacon climacon_cloudHailAlt climacon-blue-grey climacon-darken-2 height-100" viewBox="15 15 70 70">
              <g class="climacon_iconWrap climacon_iconWrap-cloudHailAlt">
                <g class="climacon_wrapperComponent climacon_wrapperComponent-hailAlt">
                  <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-left">
                    <circle cx="42" cy="65.498" r="2"></circle>
                  </g>
                  <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-middle">
                    <circle cx="49.999" cy="65.498" r="2"></circle>
                  </g>
                  <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-right">
                    <circle cx="57.998" cy="65.498" r="2"></circle>
                  </g>
                  <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-left">
                    <circle cx="42" cy="65.498" r="2"></circle>
                  </g>
                  <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-middle">
                    <circle cx="49.999" cy="65.498" r="2"></circle>
                  </g>
                  <g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-right">
                    <circle cx="57.998" cy="65.498" r="2"></circle>
                  </g>
                </g>
                <g class="climacon_wrapperComponent climacon_wrapperComponent-cloud">
                  <path class="climacon_component climacon_component-stroke climacon_component-stroke_cloud" d="M63.999,64.941v-4.381c2.39-1.384,3.999-3.961,3.999-6.92c0-4.417-3.581-8-7.998-8c-1.602,0-3.084,0.48-4.334,1.291c-1.23-5.317-5.974-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.998c0,3.549,1.55,6.728,3.999,8.924v4.916c-4.776-2.768-7.998-7.922-7.998-13.84c0-8.835,7.162-15.997,15.997-15.997c6.004,0,11.229,3.311,13.966,8.203c0.663-0.113,1.336-0.205,2.033-0.205c6.626,0,11.998,5.372,11.998,12C71.998,58.863,68.656,63.293,63.999,64.941z"></path>
                </g>
              </g>
            </svg>
          </div>
          <div class="weather-details text-center">
            <span class="block white darken-1">Snow</span>
            <span class="font-large-2 block white darken-4">-5&deg;</span>
            <span class="font-medium-4 text-bold-500 white darken-1">London, UK</span>
          </div>
        </div>
        <div class="card-footer bg-gradient-x-danger border-0">
          <div class="row">
            <div class="col-4 text-center display-table-cell white">
              <i class="me-wind font-large-1 lighten-3 align-middle"></i> <span class="align-middle">2MPH</span>
            </div>
            <div class="col-4 text-center display-table-cell white">
              <i class="me-sun2 font-large-1 lighten-3 align-middle"></i> <span class="align-middle">2%</span>
            </div>
            <div class="col-4 text-center display-table-cell white">
              <i class="me-thermometer font-large-1 lighten-3 align-middle"></i> <span class="align-middle">13.0&deg;</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-12">
    <div class="card bg-gradient-x-info white">
      <div class="card-content">
        <div class="card-body text-center">
          <div class="mb-2">
            <i class="fa fa-twitter font-large-2"></i>
          </div>
          <div class="tweet-slider">
            <ul>
              <li>Congratulations to Rob Jones in accounting for winning our <span class="yellow">#NFL</span> football pool!
                <p class="text-italic pt-1">- John Doe</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-12">
    <div class="card bg-gradient-x-primary white">
      <div class="card-content">
        <div class="card-body text-center">
          <div class="mb-2">
            <i class="fa fa-facebook font-large-2"></i>
          </div>
          <div class="fb-post-slider">
            <ul>
              <li>Congratulations to Rob Jones in accounting for winning our #NFL football pool!
                <p class="text-italic pt-1">- John Doe</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
@endsection