@extends('layouts.app')
@section('header_extends')

@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Company Details</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">Company Details</a>
                </li>
            </ol>
        </div>
    </div>
</div>
@if($company)
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <!-- <h4 class="card-title">{{$company->firstname}} {{$company->lastname}}</h4> -->
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
                        <img src="{{URL::asset('admin/images/company.png')}}" class="rounded-circle img-border height-100 border-primary" style="max-width: 100px !important;" alt="Card
                          image">
                    </a>
                </div>
                <div class="media-body pt-3 px-2">
                    <div class="row">
                        <div class="col">
                            <h3 class="card-title">{{$company->name}}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="form form-horizontal" action="{{ route('rate.discount') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            @if(Session::has('success-discount'))
                            <div class="alert alert-success alert-dismissible m-1">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>{{ Session::get('success-discount') }}</strong>
                            </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-3 label-control pr-0" for="discount">Discount (Percentage)<span class="required" style="color:red;">*</span> : </label>
                                <div class="col-md-9">
                                    @if($company)
                                    <input type="number" id="discount" min="0" step="any" class="form-control border-primary" placeholder="discount" name="discount" value="{{ $company->discount }}" autocomplete="off">
                                    @else
                                    <input type="number" id="discount" min="0" step="any" class="form-control border-primary" placeholder="discount" name="discount" value="" autocomplete="off">
                                    @endif
                                    <!-- company_id -->
                                    <input type="hidden" id="company_id" name="company_id" value="{{$company->id}}">
                                    @if ($errors->has('discount'))
                                    <span class="text-danger">{{ $errors->first('discount') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-actions right">
                                @if(isset($rates->discount))
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check-square-o"></i> Update
                                </button>
                                @else
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check-square-o"></i> Save
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <h4 class="card-title">Deliver Now</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                </ul>
            </div>
        </div>
        @if(Session::has('deliver_now'))
        <div class="alert alert-success alert-dismissible m-1">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ Session::get('deliver_now') }}</strong>
        </div>
        @endif
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="row">
                    <form class="form form-horizontal" action="{{ route('companies.rate.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="per_kilogram_rate">Per Kilogram Rate<span class="required" style="color:red;">*</span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="per_kilogram_rate" min="0" step="any" class="form-control border-primary" placeholder="Per Kilogram Rate" name="per_kilogram_rate" value="{{ $ratesNow ? $ratesNow->per_kilogram_rate : (old('deliver_type') == 'deliver_now' ?  old('per_kilogram_rate') : '') }}" autocomplete="off">
                                            @if($ratesNow)
                                            <input type="hidden" id="rate_id" name="rate_id" value="{{$ratesNow->id}}">
                                            @endif
                                            <!-- company_id -->
                                            <input type="hidden" id="company_id" name="company_id" value="{{$company->id}}">
                                            <!-- deliver_type -->
                                            <input type="hidden" id="deliver_type" name="deliver_type" value="deliver_now">
                                            @if ($errors->deliver_now->has('per_kilogram_rate'))
                                            <span class="text-danger">{{ $errors->deliver_now->first('per_kilogram_rate') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="air_condition_rate">Air Condition Rate <span class="required" style="color:red;"></span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="air_condition_rate" min="0" step="any" class="form-control border-primary" placeholder="Air Condition Rate" name="air_condition_rate" value="{{ $ratesNow ? $ratesNow->air_condition_rate : (old('deliver_type') == 'deliver_now' ?  old('air_condition_rate') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_now->has('air_condition_rate'))
                                            <span class="text-danger">{{ $errors->deliver_now->first('air_condition_rate') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h3 class="ml-1"><u><b>Van Rate</b></u></h3>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="special_city_rate_van">Special City Rate Van<span class="required" style="color:red;">*</span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="special_city_rate_van" min="0" step="any" class="form-control border-primary" placeholder="Special City Rate Van" name="special_city_rate_van" value="{{ $ratesNow ? $ratesNow->special_city_rate_van : (old('deliver_type') == 'deliver_now' ?  old('special_city_rate_van') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_now->has('special_city_rate_van'))
                                            <span class="text-danger">{{ $errors->deliver_now->first('special_city_rate_van') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="all_emirates_rate_van">All Emirates Rate Van<span class="required" style="color:red;">*</span> :</label>
                                        <div class="col-md-9">
                                            <input type="number" id="all_emirates_rate_van" min="0" step="any" class="form-control border-primary" placeholder="All Emirates Rate Van" name="all_emirates_rate_van" value="{{ $ratesNow ? $ratesNow->all_emirates_rate_van : (old('deliver_type') == 'deliver_now' ?  old('all_emirates_rate_van') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_now->has('all_emirates_rate_van'))
                                            <span class="text-danger">{{ $errors->deliver_now->first('all_emirates_rate_van') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <h3 class="ml-1"><u><b>Car Rate</b></u></h3>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="special_city_rate_car">Special City Rate Car<span class="required" style="color:red;">*</span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="special_city_rate_car" min="0" step="any" class="form-control border-primary" placeholder="Special City Rate Car" name="special_city_rate_car" value="{{ $ratesNow ? $ratesNow->special_city_rate_car : (old('deliver_type') == 'deliver_now' ?  old('special_city_rate_car') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_now->has('special_city_rate_car'))
                                            <span class="text-danger">{{ $errors->deliver_now->first('special_city_rate_car') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="all_emirates_rate_car">All Emirates Rate Car<span class="required" style="color:red;">*</span> :</label>
                                        <div class="col-md-9">
                                            <input type="number" id="all_emirates_rate_car" min="0" step="any" class="form-control border-primary" placeholder="All Emirates Rate Car" name="all_emirates_rate_car" value="{{ $ratesNow ? $ratesNow->all_emirates_rate_car : (old('deliver_type') == 'deliver_now' ?  old('all_emirates_rate_car') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_now->has('all_emirates_rate_car'))
                                            <span class="text-danger">{{ $errors->deliver_now->first('all_emirates_rate_car') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <h3 class="ml-1"><u><b>Bike Rate</b></u></h3>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="special_city_rate_bike">Special City Rate Bike<span class="required" style="color:red;">*</span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="special_city_rate_bike" min="0" step="any" class="form-control border-primary" placeholder="Special City Rate Bike" name="special_city_rate_bike" value="{{ $ratesNow ? $ratesNow->special_city_rate_bike : (old('deliver_type') == 'deliver_now' ?  old('special_city_rate_bike') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_now->has('special_city_rate_bike'))
                                            <span class="text-danger">{{ $errors->deliver_now->first('special_city_rate_bike') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="all_emirates_rate_bike">All Emirates Rate Bike<span class="required" style="color:red;">*</span> :</label>
                                        <div class="col-md-9">
                                            <input type="number" id="all_emirates_rate_bike" min="0" step="any" class="form-control border-primary" placeholder="All Emirates Rate Bike" name="all_emirates_rate_bike" value="{{ $ratesNow ? $ratesNow->all_emirates_rate_bike : (old('deliver_type') == 'deliver_now' ?  old('all_emirates_rate_bike') : '') }}" autocomplete="off">

                                            @if ($errors->deliver_now->has('all_emirates_rate_bike'))
                                            <span class="text-danger">{{ $errors->deliver_now->first('all_emirates_rate_bike') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions right m-1">
                            @if($ratesNow)
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check-square-o"></i> Update
                            </button>
                            @else
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check-square-o"></i> Save
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <h4 class="card-title">Deliver Later</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                </ul>
            </div>
        </div>
        @if(Session::has('deliver_later'))
        <div class="alert alert-success alert-dismissible m-1">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>{{ Session::get('deliver_later') }}</strong>
        </div>
        @endif
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="row">
                    <form class="form form-horizontal" action="{{ route('companies.rate.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="per_kilogram_rate">Per Kilogram Rate<span class="required" style="color:red;">*</span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="per_kilogram_rate" min="0" step="any" class="form-control border-primary" placeholder="Per Kilogram Rate" name="per_kilogram_rate" value="{{ $ratesLater ? $ratesLater->per_kilogram_rate : (old('deliver_type') == 'deliver_later' ?  old('per_kilogram_rate') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_later->has('per_kilogram_rate'))
                                            <span class="text-danger">{{ $errors->deliver_later->first('per_kilogram_rate') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="air_condition_rate">Air Condition Rate <span class="required" style="color:red;"></span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="air_condition_rate" min="0" step="any" class="form-control border-primary" placeholder="Air Condition Rate" name="air_condition_rate" value="{{ $ratesLater ? $ratesLater->air_condition_rate : (old('deliver_type') == 'deliver_later' ?  old('air_condition_rate') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_later->has('air_condition_rate'))
                                            <span class="text-danger">{{ $errors->deliver_later->first('air_condition_rate') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h3 class="ml-1"><u><b>Van Rate</b></u></h3>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="special_city_rate_van">Special City Rate Van<span class="required" style="color:red;">*</span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="special_city_rate_van" min="0" step="any" class="form-control border-primary" placeholder="Special City Rate Van" name="special_city_rate_van" value="{{ $ratesLater ? $ratesLater->special_city_rate_van : (old('deliver_type') == 'deliver_later' ?  old('special_city_rate_van') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_later->has('special_city_rate_van'))
                                            <span class="text-danger">{{ $errors->deliver_later->first('special_city_rate_van') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="all_emirates_rate_van">All Emirates Rate Van<span class="required" style="color:red;">*</span> :</label>
                                        <div class="col-md-9">
                                            <input type="number" id="all_emirates_rate_van" min="0" step="any" class="form-control border-primary" placeholder="All Emirates Rate Van" name="all_emirates_rate_van" value="{{ $ratesLater ? $ratesLater->all_emirates_rate_van : (old('deliver_type') == 'deliver_later' ?  old('all_emirates_rate_van') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_later->has('all_emirates_rate_van'))
                                            <span class="text-danger">{{ $errors->deliver_later->first('all_emirates_rate_van') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <h3 class="ml-1"><u><b>Car Rate</b></u></h3>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="special_city_rate_car">Special City Rate Car<span class="required" style="color:red;">*</span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="special_city_rate_car" min="0" step="any" class="form-control border-primary" placeholder="Special City Rate Car" name="special_city_rate_car" value="{{ $ratesLater ? $ratesLater->special_city_rate_car : (old('deliver_type') == 'deliver_later' ?  old('special_city_rate_car') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_later->has('special_city_rate_car'))
                                            <span class="text-danger">{{ $errors->deliver_later->first('special_city_rate_car') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="all_emirates_rate_car">All Emirates Rate Car<span class="required" style="color:red;">*</span> :</label>
                                        <div class="col-md-9">
                                            <input type="number" id="all_emirates_rate_car" min="0" step="any" class="form-control border-primary" placeholder="All Emirates Rate Car" name="all_emirates_rate_car" value="{{ $ratesLater ? $ratesLater->all_emirates_rate_car : (old('deliver_type') == 'deliver_later' ?  old('all_emirates_rate_car') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_later->has('all_emirates_rate_car'))
                                            <span class="text-danger">{{ $errors->deliver_later->first('all_emirates_rate_car') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <h3 class="ml-1"><u><b>Bike Rate</b></u></h3>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="special_city_rate_bike">Special City Rate Bike<span class="required" style="color:red;">*</span> : </label>
                                        <div class="col-md-9">
                                            <input type="number" id="special_city_rate_bike" min="0" step="any" class="form-control border-primary" placeholder="Special City Rate Bike" name="special_city_rate_bike" value="{{ $ratesLater ? $ratesLater->special_city_rate_bike : (old('deliver_type') == 'deliver_later' ?  old('special_city_rate_bike') : '') }}" autocomplete="off">
                                            @if ($errors->deliver_later->has('special_city_rate_bike'))
                                            <span class="text-danger">{{ $errors->deliver_later->first('special_city_rate_bike') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control pr-0" for="all_emirates_rate_bike">All Emirates Rate Bike<span class="required" style="color:red;">*</span> :</label>
                                        <div class="col-md-9">
                                            <input type="number" id="all_emirates_rate_bike" min="0" step="any" class="form-control border-primary" placeholder="All Emirates Rate Bike" name="all_emirates_rate_bike" value="{{ $ratesLater ? $ratesLater->all_emirates_rate_bike : (old('deliver_type') == 'deliver_later' ?  old('all_emirates_rate_bike') : '') }}" autocomplete="off">
                                            @if($ratesLater)
                                            <input type="hidden" id="rate_id" name="rate_id" value="{{$ratesLater->id}}">
                                            @endif
                                            <!-- company_id -->
                                            <input type="hidden" id="company_id" name="company_id" value="{{$company->id}}">
                                            <!-- deliver_type -->
                                            <input type="hidden" id="deliver_type" name="deliver_type" value="deliver_later">
                                            @if ($errors->deliver_later->has('all_emirates_rate_bike'))
                                            <span class="text-danger">{{ $errors->deliver_later->first('all_emirates_rate_bike') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions right m-1">
                            @if($ratesLater)
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check-square-o"></i> Update
                            </button>
                            @else
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check-square-o"></i> Save
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

@endsection