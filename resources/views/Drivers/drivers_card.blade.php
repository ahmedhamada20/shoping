@extends('layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Driver Profiles</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">Driver Profile</a>
                </li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card card-width">
            <img class="card-img-top" src="{{asset('images/driver.jpg')}}" alt="Bologna">
            <div class="card-body advert-body-height">
                <h4 class="card-title text-center">Name</h4>
                <ul class="list-group list-group-flush career-add-list">
                    <li class="list-group-item profile-view-item"><i class="fa fa-male mx-2"></i>Licence</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-tags mx-2"></i>Experience</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-book mx-2"></i>Qualification : B.Sc</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-trophy mx-2"></i>Dob:</li>
                </ul>

            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card card-width">
            <img class="card-img-top" src="{{asset('images/driver.jpg')}}" alt="Bologna">
            <div class="card-body advert-body-height">
                <h4 class="card-title text-center">Name</h4>
                <ul class="list-group list-group-flush career-add-list">
                    <li class="list-group-item profile-view-item"><i class="fa fa-male mx-2"></i>Licence</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-tags mx-2"></i>Experience</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-book mx-2"></i>Qualification : B.Sc</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-trophy mx-2"></i>Dob:</li>
                </ul>

            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card card-width">
            <img class="card-img-top" src="{{asset('images/driver.jpg')}}" alt="Bologna">
            <div class="card-body advert-body-height">
                <h4 class="card-title text-center">Name</h4>
                <ul class="list-group list-group-flush career-add-list">
                    <li class="list-group-item profile-view-item"><i class="fa fa-male mx-2"></i>Licence</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-tags mx-2"></i>Experience</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-book mx-2"></i>Qualification : B.Sc</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-trophy mx-2"></i>Dob:</li>
                </ul>

            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card card-width">
            <img class="card-img-top" src="{{asset('images/driver.jpg')}}" alt="Bologna">
            <div class="card-body advert-body-height">
                <h4 class="card-title text-center">Name</h4>
                <ul class="list-group list-group-flush career-add-list">
                    <li class="list-group-item profile-view-item"><i class="fa fa-male mx-2"></i>Licence</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-tags mx-2"></i>Experience</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-book mx-2"></i>Qualification : B.Sc</li>
                    <li class="list-group-item profile-view-item"><i class="fa fa-trophy mx-2"></i>Dob:</li>
                </ul>

            </div>
        </div>
    </div>
</div>
@endsection