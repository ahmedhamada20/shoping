@extends('layouts.app')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Notification Form</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a> </li> -->
                <li class="breadcrumb-item active"><a href="">Notification Forms</a>
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
                    <h4 class="card-title" id="horz-layout-colored-controls">Notification Center</h4>
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
                        @if(Session::has('error'))
                        <div class="alert alert-error">
                            {{ Session::get('error') }}
                            @php
                            Session::forget('error');
                            @endphp
                        </div>
                        @endif
                        <form class="form form-horizontal" action="{{ route('notification.create') }}" method="post">

                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="ft-server"></i>
                                    Notification</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="send_message">Message <span class="required" style="color:red;">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" id="send_message" class="form-control border-primary" placeholder="Type message" name="send_message" value="{{ old('send_message') }}">
                                                @if ($errors->has('send_message'))
                                                <span class="text-danger">{{ $errors->first('send_message') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions right">
                                    <button type="button" class="btn btn-warning mr-1">
                                        <i class="ft-x"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check-square-o"></i> Send
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

</script>
@endsection