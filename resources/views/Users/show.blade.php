@extends('layouts.app')
@section('header_extends')

@endsection
@section('content')

<!-- Modal -->
<div class="modal fade" id="walletModal" tabindex="-1" role="dialog" aria-labelledby="walletModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="walletModalLabel">Wallet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="walletForm">
                    @csrf
                    <input type="text" name="wallet" id="wallet" placeholder="Enter Amount" class="form-control" />
                    <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}" class="form-control" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-wallet">Save Wallet</button>
            </div>
        </div>
    </div>
</div>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Users Details</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">User Details</a>
                </li>
            </ol>
        </div>
    </div>
</div>
@if($user)
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <!-- <h4 class="card-title">{{$user->firstname}} {{$user->lastname}}</h4> -->
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
                        @if($user->profile)
                        <img src="{{URL::asset('uploads/user_profile/thumb/'.$user->profile)}}" class="rounded-circle img-border height-100" style="max-width: 100px !important;" alt="profile image">
                        @else
                        <img src="{{URL::asset('admin/images/portrait/small/profile.png')}}" class="rounded-circle img-border height-100" style="max-width: 100px !important;" alt="Profile" id="preview-image">
                        @endif
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
            <div class="media-left pl-2 pt-2">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success wallet-btn" data-toggle="modal" data-target="#walletModal">Wallet</button>
                    <h4 class="card-title mt-2">@if(!empty($user->wallet)) Wallet Amount : {{$user->wallet}} AED @endif</h4>
            </div>
        </div>
        <!-- <div class="card-content collapse show">
            <div class="card-body">
                <div class="card-text">
                    <ul>
                        <li>@if($user->address_type) {{$user->address_type}}@endif</li>
                        <li>@if($user->address) {{$user->address}}@endif</li>
                        <li>@if($user->city) {{$user->city}}@endif</li>
                    </ul>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endif
@if($address)
<!-- address Book -->
<!-- <div class="col-sm-12">-->
<!-- Kick start -->
<!--<div id="kick-start" class="card">
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
                @foreach($address as $row)
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card card-width border-primary">

                        <div class="card-body advert-body-height">
                            <h4 class="card-title text-center">@if($row->address_type) {{$row->address_type}} @else HOME @endif</h4>
                            <ul class="list-group list-group-flush career-add-list">
                                <li class="list-group-item profile-view-item"><i class="fa fa-male mx-2"></i>{{$row->recipient_name}}</li>
                                <li class="list-group-item profile-view-item"><i class="fa fa-tags mx-2"></i>{{$row->recipient_phone}}</li>
                                <li class="list-group-item profile-view-item"><i class="fa fa-book mx-2"></i>{{$row->address}}</li>
                            </ul>

                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div> -->
@endif
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
                                <li class="list-group-item profile-view-item"><i class="fa fa-male mx-2"></i>{{$row->package->recipient_name}}</li>
                                <li class="list-group-item profile-view-item"><i class="fa fa-tags mx-2"></i>{{$row->package->recipient_phone}}</li>
                                <!-- <li class="list-group-item profile-view-item"><i class="fa fa-book mx-2"></i>{{$row->status}}</li> -->
                                <li class="list-group-item profile-view-item"><i class="fa fa-trophy mx-2"></i>{{$row->package->order_date}}</li>
                                <li class="list-group-item profile-view-item"><i class="fa fa-trophy mx-2"></i>{{$row->package->order_time}}</li>
                                <a href="{{ url('admin/package/view/' . $row->package->id) }}" class="btn btn-primary" style="padding: 5px !important;"><i class="ft-eye"></i> View</a>
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
@endsection
@section('footer_extends')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script type="text/javascript">
    // $(document).ready(function() {};
    $("#save-wallet").click(function() {
        // alert($('#walletForm').serialize());
        $.ajax({
            url: "{{route('users.wallet')}}",
            method: 'post',
            data:$('#walletForm').serialize(),
            dataType: 'json',
            success: function(response) {
                console.log(response.status);
                if (response.status == 'success') {
                    alert(response.message);
                    location.reload();
                    $('#walletForm')[0].reset();
                } else {
                    alert(response.message);
                    // location.reload();
                }
            }
        });
    });
    // )
</script>
@endsection