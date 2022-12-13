@extends('layouts.app')
@section('header_extends')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />

@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Promo Code Form</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">Promo Code Form</a>
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
                    <h4 class="card-title" id="horz-layout-colored-controls">Promo Code</h4>
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
                <div class="card-content collpase show" id="create-form">
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
                        <form class="form form-horizontal" action="{{ route('promocode.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="code">Promo Code :</label>
                                            <div class="col-md-9">
                                                <input type="text" id="code" class="form-control border-primary" placeholder="Promo Code" name="code" value="{{ old('code') }}" autocomplete="off">
                                                @if ($errors->has('code'))
                                                <span class="text-danger">{{ $errors->first('code') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                     <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="code">Discount (Percent Value):</label>
                                            <div class="col-md-9">
                                                <input type="number" id="discount" class="form-control border-primary" placeholder="Discount Percentage" name="discount" value="{{ old('discount') }}" autocomplete="off">
                                                @if ($errors->has('discount'))
                                                <span class="text-danger">{{ $errors->first('discount') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="form-actions right">
                                <a href="{{ route('home') }}" type="button" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check-square-o"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-content collpase show" id="edit-form">
                    <div class="card-body">
                        @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                            Session::forget('success');
                            @endphp
                        </div>
                        @endif
                        <form class="form form-horizontal" action="{{ route('promocode.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="editCode">Promo Code :</label>
                                            <div class="col-md-9">
                                                <input type="text" id="editCode" class="form-control border-primary" placeholder="URL" name="editCode" value="" autocomplete="off">
                                                <input type="hidden" id="codeID" name="codeID" class="form-control border-primary" value="">
                                                @if ($errors->has('url'))
                                                <span class="text-danger">{{ $errors->first('url') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                     <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="editDiscount">Discount (Percentage Value) :</label>
                                            <div class="col-md-9">
                                                <input type="text" id="editDiscount" class="form-control border-primary" placeholder="Discount Percentage" name="editDiscount" value="" autocomplete="off">
                                               
                                                @if ($errors->has('url'))
                                                <span class="text-danger">{{ $errors->first('url') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="form-actions right">
                                <a href="{{ route('home') }}" type="button" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Cancel
                                </a>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collpase show ">
                    <div class="card-body">
                        <div class="col-sm-12">
                            <!-- Kick start -->
                            <div id="kick-start" class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Existing Code</h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                                        </ul>
                                    </div>

                                </div>
                             <?php   /* <div class="card-content collapse show">
                                    <div class="row">
                                        <div class="col-md-12 text-center">

                                            <div class="panel panel-default " style="margin: 0px 0px 20px 0px;">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"></h3>
                                                </div>
                                                <div class="panel-body" id="uploaded_image">
                                                    <!-- uploaded images goes here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> */ ?>
								
								 <div class="portlet box blue-hoki">
									<div class="portlet-body">
										<div class="table-responsive">
											<table class="table table-bordered">
											<thead>
												<tr>
													<th> No </th>
													<th> Promo Code </th>
													<th> Discount (Percent Value)</th>
													<!-- <th> Action</th> -->
												</tr>
											</thead>
											<tbody>

											</tbody>

                            </table>
										</div>
									</div>
									
								 </div>
								
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('footer_extends')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // load images
    load_data();

    // hide edit form
    $('#edit-form').hide();

    function load_data() {
        $.ajax({
            url: "{{ route('promocode.fetch') }}",
			dataType: 'json',
			success: function(data) {
				$('tbody').html(data.table_data);
				
			}
            /* success: function(data) {
                $('#uploaded_image').html(data);
            } */
        })
    }

    $(document).on('click', '.remove_image', function() {
        var id = $(this).attr('id');
        $.ajax({
            url: "{{ route('banner.delete') }}",
            data: {
                id: id
            },
            success: function(data) {
                load_images();
            }
        })
    });

    $(document).on('click', '.edit_image', function() {
        // alert('hi');
        $('#create-form').hide();
        $('#edit-form').show();

        var id = $(this).attr('id');
        // alert(id);
        $.ajax({
            url: "{{ route('banner.edit') }}",
            method: 'GET',
            data: {
                id: id
            },
            success: function(data) {
                console.log(data.url)
                // $('#url').val(data.url);
                document.getElementById("editURL").value = data.url;
                document.getElementById("bannerID").value = id;
            }
        })
    });
    // $(document).on('click', '.edit_image', function() {
    //     var id = $(this).attr('id');
    //     var url = $("editURL").val();

    //     $.ajax({
    //         url: "{{ route('banner.store') }}",
    //         method: 'POST',
    //         data: {
    //             id: id
    //             url: 
    //         },
    //         success: function(data) {
    //             console.log(data.url)
    //             // $('#url').val(data.url);
    //             document.getElementById("editURL").value = data.url;
    //             document.getElementById("bannerID").value = id;
    //         }
    //     })

    // });
</script>
@endsection