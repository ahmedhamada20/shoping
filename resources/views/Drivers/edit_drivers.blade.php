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
                        <form class="form form-horizontal" action="{{ route('drivers.update') }}" method="post" enctype="multipart/form-data">

                            @csrf
                            <div class="media profil-cover-details w-100">
                                <div class="media-left pl-2 pt-2">
                                    <a href="#" class="profileImage">
                                        @if($driverDetails->profile )
                                        <img src="{{asset('storage/driver/profile/').'/'.$driverDetails->profile}}" class="rounded-circle img-border height-100" style="max-width: 100px !important;" alt="Profile" id="preview-image">
                                        @else
                                        <img src="{{URL::asset('admin/images/portrait/small/profile.png')}}" class="rounded-circle img-border height-100" style="max-width: 100px !important;" alt="Profile" id="preview-image">
                                        @endif
                                    </a>
                                </div>
                                <div class="media-body pt-3 px-2">
                                    <div class="row">
                                        <div class="col">
                                            <!-- <input type="file" id="upload-file" style="display:none" onchange="checkFile('upload-file')" /> -->
                                            <label id="label-upload" for="profileImage">Upload profile image</label>
                                            <input accept="image/png, image/jpeg, image/jpg" type="file" id="profileImage" style="display:none" class="form-control border-primary" placeholder="Image Upload" name="profileImage">
                                            @if ($errors->has('profile'))
                                            <span class="text-danger">{{ $errors->first('profile') }}</span>
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
                                                @if( $firstname )
                                                <input type="text" id="firstname" class="form-control border-primary" placeholder="First Name" name="firstname" value="{{$firstname}}">
                                                @else
                                                <input type="text" id="firstname" class="form-control border-primary" placeholder="First Name" name="firstname">
                                                @endif

                                                @if($driverDetails->id)
                                                <input type="hidden" id="driver_id" class="form-control " name="driver_id" value="{{$driverDetails->id}}">
                                                @endif

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
                                                @if( $lastname )
                                                <input type="text" id="lastname" class="form-control border-primary" placeholder="Last Name" name="lastname" value="{{$lastname}}">
                                                @else
                                                <input type="text" id="lastname" class="form-control border-primary" placeholder="Last Name" name="lastname">
                                                @endif

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
                                                    @if( $driverDetails->dob )
                                                    <input type="date" id="date" class="form-control" name="date" value="{{ $driverDetails->dob }}">
                                                    @else
                                                    <input type="date" id="date" class="form-control" name="date">
                                                    @endif
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
                                            <label class="col-md-3 label-control" for="imageFile">License Upload</label>
                                            <div class="col-md-9">
                                                <input accept="image/png, image/jpeg, image/jpg" type="file" id="licenseImage" class="form-control border-primary" placeholder="Image Upload" name="licenseImage[]" multiple>
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
                                                @if( $driverDetails->gender )
                                                <div>
                                                    <input type="radio" id="male" name="gender" value="1" {{ $driverDetails->gender==1 ? 'checked' : '' }}>
                                                    <label for="male" class="mr-1">Male</label>
                                                    <input type="radio" id="female" name="gender" value="2" {{ $driverDetails->gender==2 ? 'checked' : '' }}>
                                                    <label for="female" class="mr-1">Female</label>
                                                    <input type="radio" id="other" name="gender" value="3" {{ $driverDetails->gender==3 ? 'checked' : '' }}>
                                                    <label for="other">Other</label>
                                                </div>
                                                @else
                                                <div>
                                                    <input type="radio" id="male" name="gender" value="1">
                                                    <label for="male" class="mr-1">Male</label>
                                                    <input type="radio" id="female" name="gender" value="2">
                                                    <label for="female" class="mr-1">Female</label>
                                                    <input type="radio" id="other" name="gender" value="3">
                                                    <label for="other">Other</label>
                                                </div>
                                                @endif
                                                @if ($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Contact Number <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                @if( $driverDetails->phone )
                                                <input class="form-control border-primary" type="tel" placeholder="Contact Number" id="phone" name="phone" value="{{$driverDetails->phone}}">
                                                @else
                                                <input class="form-control border-primary" type="tel" placeholder="Contact Number" id="phone" name="phone">
                                                @endif @if ($errors->has('phone'))
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
                                                    @foreach ($companies as $company)
                                                    @if($driverDetails->company_id == $company->id )
                                                    <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
                                                    @else
                                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                    @endif
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
                                                @if( $driverDetails->distance )
                                                <input class="form-control border-primary" type="distance" placeholder="Enter distance that can deliver (in Kilometer)" id="distance" name="distance" value="{{ $driverDetails->distance }}">
                                                @else
                                                <input class="form-control border-primary" type="distance" placeholder="Enter distance that can deliver (in Kilometer)" id="distance" name="distance">
                                                @endif
                                                @if ($errors->has('distance'))
                                                <span class="text-danger">{{ $errors->first('distance') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput8">Address</label>
                                            <div class="col-md-9">
                                                @if( $driverDetails->address )
                                                <textarea id="address" rows="6" class="form-control border-primary" name="address" placeholder="Enter address">{{$driverDetails->address}}</textarea>
                                                @else
                                                <textarea id="address" rows="6" class="form-control border-primary" name="address" placeholder="Enter address"></textarea>
                                                @endif
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
                                                @if( $driverDetails->email )
                                                <input class="form-control border-primary" type="email" placeholder="email" id="email" name="email" value="{{$driverDetails->email}}">
                                                @else
                                                <input class="form-control border-primary" type="email" placeholder="email" id="email" name="email">
                                                @endif
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
                                                @if( $driverDetails->password )
                                                <input class="form-control border-primary" type="password" placeholder="Enter Password" id="password" name="password" value="{{$driverDetails->show_password}}">
                                                @else
                                                <input class="form-control border-primary" type="password" placeholder="Enter Password" id="password" name="password">
                                                @endif
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
                                            <label class="col-md-3 label-control" for="vehicle_type">Vehicle type {{$vehicles_details->type}}<span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <select class="form-control" id="vehicle_type" name="vehicle_type">
                                                    @if($vehicles_details->type == 'van' )
                                                    <option value="{{ $vehicles_details->type}}" selected>{{ $vehicles_details->type }}</option>
                                                    <option value="bike">Bike</option>
                                                    <option value="car">Car</option>
                                                    @elseif($vehicles_details->type == 'bike')
                                                    <option value="{{ $vehicles_details->type}}" selected>{{ $vehicles_details->type }}</option>
                                                    <option value="van">Van</option>
                                                    <option value="car">Car</option>

                                                    @elseif($vehicles_details->type == 'car')
                                                    <option value="{{ $vehicles_details->type}}" selected>{{ $vehicles_details->type }}</option>
                                                    <option value="van">Van</option>
                                                    <option value="bike">Bike</option>
                                                    @else
                                                    <option>Select Option</option>
                                                    <option value="van">Van</option>
                                                    <option value="bike">Bike</option>
                                                    <option value="car">Car</option>

                                                    @endif

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
                                                @if($vehicles_details->model)
                                                <input class="form-control border-primary" type="text" placeholder="Vehicle model" id="model" name="model" value="{{ $vehicles_details->model }}">
                                                @else
                                                <input class="form-control border-primary" type="text" placeholder="Vehicle model" id="model" name="model">
                                                @endif

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
                                                @if($vehicles_details->model)
                                                <input class="form-control border-primary" type="text" placeholder="Vehicle number" id="vehicle_number" name="vehicle_number" value="{{ $vehicles_details->vehicle_number }}">
                                                @else
                                                <input class="form-control border-primary" type="text" placeholder="Vehicle number" id="vehicle_number" name="vehicle_number">
                                                @endif

                                                @if ($errors->has('vehicle_number'))
                                                <span class="text-danger">{{ $errors->first('vehicle_number') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="vehicleFile">Vehicle Doc Upload</label>
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
                                    <i class="fa fa-check-square-o"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="image-gallery" class="card">
    <div class="card-header">
        <h4 class="card-title">LICENCE FILEs</h4>
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
        <div class="card-body">
            <div class="card-text">
            </div>
        </div>
        <div class="card-body  my-gallery" itemscope="" itemtype="http://schema.org/ImageGallery" data-pswp-uid="1">
            <div class="row">
                @if(!empty($licences))
                @foreach($licences as $licence)
                <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                    <a href="{{asset('storage/driver/license/').'/'.$licence}}" itemprop="contentUrl" data-size="480x360">
                        <img class="img-thumbnail img-fluid" src="{{asset('storage/driver/license/').'/'.$licence}}" itemprop="thumbnail" alt="Image description">
                    </a>
                </figure>
                @endforeach
                @else
                <p>No files available</p>
                @endif


            </div>
        </div>
    </div>
    <!--/ PhotoSwipe -->
</section>
<section id="image-gallery" class="card">
    <div class="card-header">
        <h4 class="card-title">Vehicle FILEs</h4>
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
        <div class="card-body">
            <div class="card-text">
            </div>
        </div>
        <div class="card-body  my-gallery" itemscope="" itemtype="http://schema.org/ImageGallery" data-pswp-uid="1">
            <div class="row">
                @if(!empty($vehicles))
                @foreach($vehicles as $vehicle)
                <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">
                    <a href="{{asset('storage/driver/vehicle/').'/'.$vehicle}}" itemprop="contentUrl" data-size="480x360">
                        <img class="img-thumbnail img-fluid" src="{{asset('storage/driver/vehicle/').'/'.$vehicle}}" itemprop="thumbnail" alt="">
                    </a>
                </figure>
                @endforeach
                @else
                <p>No files available</p>
                @endif

            </div>
        </div>
    </div>
    <!--/ PhotoSwipe -->
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
</script>
@endsection