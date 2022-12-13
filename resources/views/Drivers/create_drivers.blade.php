@extends('layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Drivers Form</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a> </li> -->
                <li class="breadcrumb-item active"><a href="">Drivers Forms</a>
                </li>
            </ol>
        </div>
    </div>
</div>
<section id="horizontal-form-layouts">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="horz-layout-colored-controls">Driver Profile</h4>
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
                <div class="card-content collpase show">
                    <div class="card-body">
                        @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                            Session::forget('success');
                            @endphp
                        </div>
                        @endif
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <strong>{{ $message }}</strong>
                        </div>

                        @endif
                        <form class="form form-horizontal" action="{{ route('drivers.store') }}" method="post" enctype="multipart/form-data">

                            @csrf
                            <div class="media profil-cover-details w-100">
                                <div class="media-left pl-2 pt-2">
                                    <a href="#" class="profileImage">
                                        <img src="{{URL::asset('admin/images/portrait/small/profile.png')}}" class="rounded-circle img-border height-100" style="max-width: 100px !important;" alt="Profile" id="preview-image">
                                    </a>
                                </div>
                                <div class="media-body pt-3 px-2">
                                    <div class="row">
                                        <div class="col">
                                            <!-- <input type="file" id="upload-file" style="display:none" onchange="checkFile('upload-file')" /> -->
                                            <label id="label-upload" for="profileImage">Upload profile image</label>
                                            <input accept="image/png, image/jpeg, image/jpg" type="file" id="profileImage" style="display:none" class="form-control border-primary" placeholder="Image Upload" name="profileImage">
                                            @if ($errors->has('profileImage'))
                                            <span class="text-danger">{{ $errors->first('profileImage') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <h4 class="form-section"><i class="fa fa-eye"></i>
                                    About</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="firstname">Fist Name <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" id="firstname" class="form-control border-primary" placeholder="First Name" name="firstname" value="{{ old('firstname') }}">
                                                @if ($errors->has('firstname'))
                                                <span class="text-danger">{{ $errors->first('firstname') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="lastname">Last Name <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" id="lastname" class="form-control border-primary" placeholder="Last Name" name="lastname" value="{{ old('lastname') }}">
                                                @if ($errors->has('lastname'))
                                                <span class="text-danger">{{ $errors->first('lastname') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="date">DOB <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <div class="position-relative has-icon-left">
                                                    <input type="date" id="date" class="form-control" name="date" value="{{ old('date') }}">
                                                    <div class="form-control-position">
                                                        <i class="ft-message-square"></i>
                                                    </div>
                                                    @if ($errors->has('date'))
                                                    <span class="text-danger">{{ $errors->first('date') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="imageFile">License Upload <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input accept="image/png, image/jpeg, image/jpg" type="file" id="licenseImage" class="form-control border-primary" placeholder="Licence Image Upload" name="licenseImage[]" multiple>
                                                @if ($errors->has('licenseImage'))
                                                <span class="text-danger">{{ $errors->first('licenseImage') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                    <img src="#" id="preview-image" />
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="gender">Gender <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <div>
                                                    <input type="radio" id="male" name="gender" value="1">
                                                    <label for="male" class="mr-1">Male</label>
                                                    <input type="radio" id="female" name="gender" value="2">
                                                    <label for="female" class="mr-1">Female</label>
                                                    <input type="radio" id="other" name="gender" value="3">
                                                    <label for="other">Other</label>
                                                </div>
                                                @if ($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Contact Number <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input class="form-control border-primary" type="tel" placeholder="Enter Contact Number eg : +971 501842930" id="phone" name="phone" value="{{ old('phone') }}">
                                                @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="emirates_id">Emirates ID <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input accept="image/png, image/jpeg, image/jpg" class="form-control border-primary" type="file" placeholder="upload Emirates id file" id="emirates_id" name="emirates_id[]" multiple>
                                                @if ($errors->has('emirates_id'))
                                                <span class="text-danger">{{ $errors->first('emirates_id') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="company">Company <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" id="company" name="company">
                                                    <option value="">--- Select Company ---</option>
                                                    @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('company'))
                                                <span class="text-danger">{{ $errors->first('company') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Delivery Distance (in Kilometer) <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input class="form-control border-primary" type="distance" placeholder="Enter distance that can deliver (in Kilometer)" id="distance" name="distance" value="{{ old('distance') }}">
                                                @if ($errors->has('distance'))
                                                <span class="text-danger">{{ $errors->first('distance') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="address">Address <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <textarea id="address" rows="6" class="form-control border-primary" name="address" placeholder="Enter address">{{ old('address') }}</textarea>
                                                @if ($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                                @endif
                                            </div>
                                        </div>


                                    </div>


                                    <!-- Account details -->
                                    <h4 class="form-section"><i class="ft-mail"></i>
                                        Account signup</h4>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="email">Email <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input class="form-control border-primary" type="email" placeholder="email" id="email" name="email" value="{{ old('email') }}" autocomplete="off">
                                                @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Password <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input class="form-control border-primary" type="password" placeholder="Enter Password" id="password" name="password" autocomplete="off">
                                                <input type="checkbox" onclick="showPassword()"> Show Password
                                                @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Vehicle details -->
                                <h4 class="form-section"><i class="ft-life-buoy"></i>
                                    Vehicle details</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="vehicle_type">Vehicle type <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" id="vehicle_type" name="vehicle_type">
                                                <option value="">--- Select Vehicle ---</option>
                                                    <option value="van">Van</option>
                                                    <option value="bike">Bike</option>
                                                    <option value="car">Car</option>
                                                </select>
                                                @if ($errors->has('vehicle_type'))
                                                <span class="text-danger">{{ $errors->first('vehicle_type') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Model <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input class="form-control border-primary" type="text" placeholder="Vehicle model" id="model" name="model" value="{{ old('model') }}">
                                                @if ($errors->has('model'))
                                                <span class="text-danger">{{ $errors->first('model') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Vehicle number <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input class="form-control border-primary" type="text" placeholder="Vehicle number" id="vehicle_number" name="vehicle_number" value="{{ old('vehicle_number') }}">
                                                @if ($errors->has('vehicle_number'))
                                                <span class="text-danger">{{ $errors->first('vehicle_number') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="vehicleFile">Vehicle Doc Upload <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input accept="image/png, image/jpeg, image/jpg" type="file" id="vehicleImage" class="form-control border-primary" placeholder="vehicle doc Upload" name="vehicleImage[]" multiple>
                                                @if ($errors->has('vehicleImage'))
                                                <span class="text-danger">{{ $errors->first('vehicleImage') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions right">
                                <button type="button" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check-square-o"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer_extends')
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview-image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#profileImage").change(function() {
        readURL(this);
    });

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