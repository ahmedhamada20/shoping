@extends('layouts.app')
@section('header_extends')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- CSS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Order Details</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">Order Details</a>
                </li>
            </ol>
        </div>
    </div>
</div>
<!-- modal starts here -->
<div class="modal" tabindex="-1" id="assign-Modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: transparent linear-gradient(167deg, #25365c 0%, #1c5997 100%) 0% 0% no-repeat padding-box !important;">
                <h4 class="modal-title" style="color: #fff;font-weight: bold;">Assign Driver</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- For defining autocomplete -->
                @if( isset($order_status->driver_id))
                <select id='selectDriver' style='width: 200px;'>
                    @foreach($drivers as $row)
                    @if($order_status->driver_id) == $row['id'] )
                    <option value="{{ $row['id']}}" selected>{{ $row['name'] }}</option>
                    @else
                    <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                    @endif


                    @endforeach
                </select>
                @else
                <!-- For defining autocomplete -->
                <select id='selectDriver' style='width: 200px;'>
                    <option >-- Select Driver --</option>
                    @foreach($drivers as $key => $row)
                    <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                    @endforeach
                </select>
                @endif


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-btn">Close</button>
                <button type="button" class="btn btn-success" id="btn-assign">Assign</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Ends here -->

<!-- address Book -->
<!-- <div class="col-sm-12">
    <div id="kick-start" class="card">
        <div class="card-header">
            <h4 class="card-title">Address Book</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                </ul>
            </div>

        </div>
        <div class="card-content collapse show">
            <div class="row">
                
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card card-width border-primary">

                        <div class="card-body advert-body-height">
                            <h4 class="card-title text-center"></h4>
                            <ul class="list-group list-group-flush career-add-list">
                                <li class="list-group-item profile-view-item"><i class="fa fa-male mx-2"></i></li>
                                <li class="list-group-item profile-view-item"><i class="fa fa-tags mx-2"></i></li>
                                <li class="list-group-item profile-view-item"><i class="fa fa-book mx-2"></i></li>
                            </ul>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
@if($package)
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
                <div class="col-xl-4 col-lg-6 col-12" style="  margin-left: 20px;">
                    <h3 class="mb-2">Order Details</h3>
                    <span id="order_id" style="display:none;">{{ $orders->id}}</span>
                    <p><b>Order ID: </b> <span id="">{{ $orders->order_id}}</span></p>
                    <p><b>Order date:</b> {{$package->order_date}}</p>
                    <p><b>Order time:</b> {{$package->order_time}}</p>
                    <p><b>Order type:</b> {{$package->order_type}}</p>

                    <p><b>Parcel weight:</b> {{$package->weight}} KG</p>
                    <p><b>Fragile: </b>{{$package->is_fragile ? 'YES' : 'NO' }}</p>

                    <p><b>Air cool:</b> {{ $package->need_aircool ? 'YES' : 'NO' }}</p>
                    <p><b>User Location:</b> {{$package->user_location}}</p>
                    <p><b>Vehicle Type:</b> {{$package->vehicle_type}}</p>
                    <p><b>Recipient Name:</b> {{$package->recipient_name}}</p>
                    <p><b>Recipient Phone:</b> {{$package->recipient_phone}}</p>
                    <p><b>Amount:</b> {{$package->amount}} AED</p>

                    <p><b>Sender Address:</b></p>
                    @if(isset($senderAddress))
                    <p>{{$senderAddress->recipient_name ? $senderAddress->recipient_name : ''}}</p>
                    <p>{{$senderAddress->address ? $senderAddress->address : ''}}<br>
                        {{$senderAddress->city ? $senderAddress->city : ''}}
                        {{$senderAddress->street ? $senderAddress->street : ''}}
                        {{$senderAddress->building ? $senderAddress->building : ''}}
                        {{$senderAddress->appartment ? $senderAddress->appartment : ''}}
                        <br>{{$senderAddress->recipient_phone ? $senderAddress->recipient_phone : ''}}<br>
                    </p>
                    @else
                    <p>No Sender Address</p>
                    @endif

                    <p><b>Delivery Address:</b></p>
                    @if(isset($deliverAddress))
                    <p>{{$deliverAddress->recipient_name ? $deliverAddress->recipient_name : ''}}</p>
                    <p>{{$deliverAddress->address ? $deliverAddress->address : ''}}<br>{{$deliverAddress->city ? $deliverAddress->city : ''}}
                        {{ $deliverAddress->street ? $deliverAddress->street : ''}}
                        {{$deliverAddress->building ? $deliverAddress->building : ''}}
                        {{$deliverAddress->appartment ? $deliverAddress->appartment : ''}}
                        <br>{{$deliverAddress->recipient_phone ? $deliverAddress->recipient_phone : ''}}<br>
                    </p>
                    @else
                    <p>No Delivery Address</p>
                    @endif


                    <p><b>Additional note:</b> {{$package->additional_notes ? $package->additional_notes : 'No additional notes available'}}</p>
                    <p>
                        <b>Parcel Description:</b>
                    </p>
                    <p>{{$package->parcel_description ? $package->parcel_description : 'No parcel description'}}</p>
                </div>
                <div class="col-xl-4 col-lg-6 col-12" style="  margin-left: 20px;">
                    <h3 class="mb-2">Company Details</h3>
                    @if(!empty($company))
                    <p><b>Company Name: </b> <span id="">{{ $company->name}}</span></p>
                    <p><b>Payment Type : </b> {{ $orders->payment_type }} </p>
                    <p><b>Payment Id : </b> {{ $orders->payment_id }} </p>
                    <p><b>Order Total : </b> {{$orders->total_amount }} AED</p>
                    @endif

                </div>
                <div class="col-xl-3 col-lg-6 col-12" style="  margin-left: 20px;">
                    @if( $order_status->driver_id)
                    
                        <h3 class="mb-2">Reassign Driver</h3>
                        <a class="btn btn-success" style="padding: 5px !important;" id="assign-driver"> Reassign Driver</a>
                        <h3 class="mt-3 mb-2">Driver Details</h3>
                        <!-- /*<p><b>Emirated ID : </b> //{{$driver_details->emirates_id}}</p>*/ -->
                        <p class="mt-1"><b>Fullname : </b> {{$driver_details->fullname}}</p>
                        <p><b>Phone : </b> {{$driver_details->phone}}</p>
                        <p><b>Email : </b> {{$driver_details->email}}</p>
                        <p><b>Distance he can cover : </b> {{$driver_details->distance}} KM</p>

                        @if( isset($vehicle) )
                        <h3 class="mt-3 mb-2">Vehicle Details</h3>

                        <p class="mt-1"><b>Type : </b> {{$vehicle->type}}</p>
                        <p><b>Model : </b> {{$vehicle->model}}</p>
                        <p><b>Number : </b> {{$vehicle->vehicle_number}}</p>
                        @else
                        <p><b>Vehicle details not available</b> </p>
                        @endif

                    @else
                    <h3>Assign Driver</h3>
                    <a class="btn btn-success" style="padding: 5px !important;" id="assign-driver"> Assign Driver</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <section id="image-gallery" class="card">
            <div class="card-header">
                <h4 class="card-title">Package Images</h4>
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
                        @if(!empty($images))
                        @foreach($images as $image)
                        <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia" itemscope itemtype="">
                            <a href="{{URL::asset('storage/packages/thumbnail/').'/'.$image}}" itemprop="contentUrl" data-size="480x360">
                                <img class="img-thumbnail img-fluid" src="{{URL::asset('storage/packages/thumbnail/').'/'.$image}}" itemprop="thumbnail" alt="Package Images" />
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
@if($user)
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <h4 class="card-title">User Details</h4>
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
                        <img src="@if($user->profile){{URL::asset('uploads/user_profile/thumb/'.$user->profile)}} @else {{URL::asset('admin/images/portrait/small/profile.png')}} @endif" class="rounded-circle img-border height-100" style="max-width: 100px !important;" alt="Card
                          image">
                    </a>
                </div>
                <div class="media-body pt-3 px-2">
                    <div class="row">
                        <div class="col">
                            <h3 class="card-title">{{$user->firstname}} {{$user->lastname}}</h3>
                            <p>{{$user->email}}</p>
                            <p>{{$user->phone}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="card-content collapse show">
            <div class="card-body">
                <div class="card-text">
                    <ul>
                    </ul>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endif
@endif
@endsection
@section('footer_extends')
<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script type="text/javascript">
    $('#assign-driver').click(function() {
        $('#assign-Modal').toggle();
    });
    $('#btn-assign').click(function() {
        $('#assign-Modal').toggle();
        var driver_id = $('#selectDriver option:selected').attr('value');
        var order_id = $('#order_id').html();
        $.ajax({
            url: "{{route('assign.driver')}}",
            method: 'post',
            data: {
                driverId: driver_id,
                orderId: order_id
            },
            dataType: 'json',
            success: function(data) {
                console.log(data.status);
                if (data.status == 'success') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                    location.reload();
                }
            }
        });
    });

    $('.close').click(function() {
        $('#assign-Modal').toggle();
    });
    $('#close-btn').click(function() {
        $('#assign-Modal').toggle();
    });
</script>
@endsection