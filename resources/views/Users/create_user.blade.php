@extends('layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Users Form</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">Users Forms</a>
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
                    <h4 class="card-title" id="horz-layout-colored-controls">Customer Profile</h4>
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
                        <form class="form form-horizontal" action="{{ route('drivers.store') }}" method="post" enctype="multipart/form-data">

                            @csrf

                            <div class="form-body">
                                <h4 class="form-section"><i class="fa fa-eye"></i>
                                    About User</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="firstname">Fist Name</label>
                                            <div class="col-md-9">
                                                <input type="text" id="firstname" class="form-control border-primary" placeholder="First Name" name="firstname">
                                                @if ($errors->has('firstname'))
                                                <span class="text-danger">{{ $errors->first('firstname') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="lastname">Last Name</label>
                                            <div class="col-md-9">
                                                <input type="text" id="lastname" class="form-control border-primary" placeholder="Last Name" name="lastname">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="date">DOB</label>
                                            <div class="col-md-9">
                                                <div class="position-relative has-icon-left">
                                                    <input type="date" id="date" class="form-control" name="date">
                                                    <div class="form-control-position">
                                                        <i class="ft-message-square"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="nickname">Nick Name</label>
                                            <div class="col-md-9">
                                                <input type="text" id="nickname" class="form-control border-primary" placeholder="Nick Name" name="nickname">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="form-section"><i class="ft-mail"></i>
                                    Contact Info & Bio</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="email">Email</label>
                                            <div class="col-md-9">
                                                <input class="form-control border-primary" type="email" placeholder="email" id="email" name="email">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="gender">Gender</label>
                                            <div class="col-md-9">
                                                <!-- <div> -->
                                                <input type="radio" id="male" name="male" value="0" checked>
                                                <label for="male">Male</label>
                                                <input type="radio" id="female" name="female" value="1">
                                                <label for="female">Female</label>
                                                <!-- </div> -->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Contact Number</label>
                                            <div class="col-md-9">
                                                <input class="form-control border-primary" type="tel" placeholder="Contact Number" id="phone" name="phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Password</label>
                                            <div class="col-md-9">
                                                <input class="form-control border-primary" type="password" placeholder="Contact Number" id="password" name="password" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput8">Bio</label>
                                            <div class="col-md-9">
                                                <textarea id="about" rows="4" class="form-control border-primary" name="about" placeholder="Bio"></textarea>
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