@extends('layouts.app')
@section('header_extends')


@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">company offers</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">company offers</a>
                </li>
            </ol>
        </div>
    </div>
</div>
<div class="page-content-wrapper">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="page-content p-t-0" style="min-height:239px">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{ Session::get('success') }}</strong>
                </div>
                @endif
                <div>
                   
                    <button class="btn btn-success md-2"  data-toggle="modal" data-target="#createcompanyOffres">Add company offers</button>
                @include('company_offers.create_drivers')
                </div>
                
                <div class="portlet box blue-hoki">
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <p id="sample"></p>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th> Name </th>
                                        <th> offres </th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->offres }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit{{ $row->id }}"><i class="fa fa-edit"></i></button>
                                            <button  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleted{{ $row->id }}"><i class="fa fa-trash"></i></button>
                                        </td>
                                        @include('company_offers.edit_companyOffres')
                                        @include('company_offers.delete')
                                    </tr>
                                    @endforeach
                                    
                                </tbody>

                            </table>
                            {!! $data->onEachSide(5)->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer_extends')

@endsection