@extends('layouts.app')
@section('header_extends')

@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Driver Details</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">driver Details</a>
                </li>
            </ol>
        </div>
    </div>
</div>
@if($driver)
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <!-- <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a> -->
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                </ul>
            </div>
            <div class="media profil-cover-details w-100">
                <div class="media-left pl-2 pt-2">
                    <a href="#" class="profile-image">
                        @if($driver->profile )
                        <img src="{{asset('storage/driver/profile/thumbnail/').'/'.$driver->profile}}" class="rounded-circle img-border height-100" style="max-width: 100px !important;" alt="Profile" id="preview-image">
                        @else
                        <img src="{{URL::asset('admin/images/portrait/small/profile.png')}}" class="rounded-circle img-border height-100" style="max-width: 100px !important;" alt="Profile" id="preview-image">
                        @endif
                    </a>
                </div>
                <div class="media-body pt-3 px-2">
                    <div class="row">
                        <div class="col">
                            <h3 class="card-title">{{$driver->fullname}}</h3>
                            <p>Email : {{$driver->email}} <br> Company : {{$company->name}}</p>
                            <!-- <p>Company : {{$company->name}}</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endif
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <!-- <h4 class="card-title">Order History</h4> -->
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                </ul>
            </div>

        </div>
        <div class="card-content collapse show">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12" style="  margin-left: 20px;">
                    <h3 class="mb-2">Details</h3>
                    @if( $driver->id)

                    <p class="mt-1"><b>Fullname : </b> {{$driver->fullname}}</p>
                    <p><b>Phone : </b> {{$driver->phone}}</p>
                    <p><b>Email : </b> {{$driver->email}}</p>
                    <p><b>Offers : </b> {{$driver->offer->offers}} $</p>
                    <p><b>Date of birth : </b> {{$driver->dob}}</p>
                    <p><b>Gender : </b> @if($driver->gender == 1) Male @elseif($driver->gender == 2) Female @else Other @endif</p>
                    <p><b>Distance he can cover : </b> {{$driver->distance}} KM</p>
                    <p><b>Address : </b> {{$driver->address}}</p>
                    <p><b>Password:</b></p>
                    <input type="password" name="password" id="password" class="form-control" value="{{$driver->show_password}}" readonly />
                    <input type="checkbox" onclick="showPassword()"> Show Password
                    @if( isset($vehicle) )
                    <h3 class="mt-3 mb-2">Vehicle Details</h3>

                    <p class="mt-1"><b>Type : </b> {{$vehicle->type}}</p>
                    <p><b>Model : </b> {{$vehicle->model}}</p>
                    <p><b>Number : </b> {{$vehicle->vehicle_number}}</p>
                    @else
                    <p class="mb-2"><b>Vehicle details not available</b> </p>
                    @endif

                    @endif


                </div>
                
            </div>
        </div>
    </div>
</div>

@if($orders)
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <h4 class="card-title">Order History</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                </ul>
            </div>

        </div>
        <div class="card-content collapse show">
            <div class="row">
                @foreach($orders as $row)
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card card-width border-primary ml-2 mr-2">

                        <div class="card-body advert-body-height">
                            <h4 class="card-title text-center">@if($row->order_id) {{$row->order_id}} @else Orders @endif</h4>
                            <ul class="list-group list-group-flush career-add-list">
                                <li class="list-group-item profile-view-item"><i class="fa fa-male mx-2"></i><b>Order date : </b>{{$row->package->order_date}}</li>
                                <li class="list-group-item profile-view-item"><i class="fa fa-tags mx-2"></i><b>Order time : </b>{{$row->package->order_time}}</li>
                                <li class="list-group-item profile-view-item"><i class="fa fa-trophy mx-2"></i><b>Order type : </b>{{$row->package->order_type}}</li>
                                <a href="{{ url('admin/package/view/' . $row->package->id) }}" class="btn btn-primary" style="padding: 5px !important;"><i class="ft-eye"></i> View Details</a>
                            </ul>

                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <section id="image-gallery" class="card">
            <div class="card-header">
                <h4 class="card-title">Driver License File</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body  my-gallery" itemscope itemtype="">
                    <div class="row">
                        @if(!empty($licences))
                        @foreach($licences as $licence)
                        <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia" itemscope itemtype="">
                            <a href="{{asset('storage/driver/license/').'/'.$licence}}" itemprop="contentUrl" data-size="480x360">
                                <img class="img-thumbnail img-fluid" src="{{asset('storage/driver/license/thumbnail/').'/'.$licence}}" itemprop="thumbnail" alt="Licence Images" />
                            </a>
                        </figure>
                        @endforeach
                        @else
                        <p>Images not available</p>
                        @endif


                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <section id="image-gallery" class="card">
            <div class="card-header">
                <h4 class="card-title">Emirates ID's</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body  my-gallery" itemscope itemtype="">
                    <div class="row">
                        @if(!empty($emirates))
                        @foreach($emirates as $emiratesImage)
                        <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia" itemscope itemtype="">
                            <a href="{{asset('storage/driver/emirates').'/'.$emiratesImage}}" itemprop="contentUrl" data-size="480x360">
                                <img class="img-thumbnail img-fluid" src="{{asset('storage/driver/emirates/thumbnail').'/'.$emiratesImage}}" itemprop="thumbnail" alt="emirates Images" />
                            </a>
                        </figure>
                        @endforeach
                        @else
                        <p>Images not available</p>
                        @endif


                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <section id="image-gallery" class="card">
            <div class="card-header">
                <h4 class="card-title">Vehicle Images</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body  my-gallery" itemscope itemtype="">
                    <div class="row">
                        @if(!empty($vehicleImage))
                        @foreach($vehicleImage as $image)
                        <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia" itemscope itemtype="">
                            <a href="{{asset('storage/driver/vehicle').'/'.$image}}" itemprop="contentUrl" data-size="480x360">
                                <img class="img-thumbnail img-fluid" src="{{asset('storage/driver/vehicle/thumbnail/').'/'.$image}}" itemprop="thumbnail" alt="vehicle Images" />
                            </a>
                        </figure>
                        @endforeach
                        @else
                        <p>Images not available</p>
                        @endif


                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
@section('footer_extends')
<script type="text/javascript">
    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@endsection