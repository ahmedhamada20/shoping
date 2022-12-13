@extends('layouts.app')
@section('header_extends')
    <style>
        .error-print {
            color: red;
            font-size: 11px;
        }
    </style>
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-1">
            <h3 class="content-header-title">Special Cities</h3>
        </div>
        {{-- <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                    </li>
                    <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                    </li> -->
                    <li class="breadcrumb-item active"><a href="#">List of Registered Companies</a>
                    </li>
                </ol>
            </div>
        </div> --}}
    </div>
    <div class="page-content-wrapper">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <div class="page-content p-t-0" style="min-height:239px">
            <div class="row">
                <div class="col-md-12">
                    <form class="form form-horizontal" id="city_create" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h4 class="form-section"> Create Cities</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="company_name">Arabic <span
                                                class="required" style="color:red;">*</span>:</label>
                                        <div class="col-md-9">
                                            <input type="text" id="arabic" class="form-control border-primary"
                                                placeholder="Arabic" name="arabic"  autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control" for="company_name">English <span
                                                class="required" style="color:red;">*</span>:</label>
                                        <div class="col-md-9">
                                            <div class="col-md-9">
                                                <input type="text" id="english" class="form-control border-primary"
                                                    placeholder="English" name="english"  autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions right">
                            <button class="btn btn-primary">
                                <i class="fa fa-check-square-o"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <span id="message">
                    </span>
                    <!-- search box -->
                    <div class="form-inline mb-1" id="search-box">
                        <label for="search">Search Box : </label>
                        <input style="margin-left: 10px;" type="text" class="form-control"
                            placeholder="Search Users Here." id="search" name="search"></input>
                    </div>
                    <div class="portlet box blue-hoki">
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th> No </th>
                                            <th> Arabic </th>
                                            <th> English </th>
                                            <th> Status </th>
                                            <th> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($data) && $data->count())
                                            @php $i = 0; @endphp
                                            @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ $value->arabic }}</td>
                                                    <td>{{ $value->english }}</td>
                                                    <td>
                                                        @if ($value->status == 1)
                                                            <a data-id="{{ $value->id }}" data-value="0"
                                                                class="btn btn-danger disable-city"
                                                                style="padding: 5px !important;"
                                                                onclick="updateStatus({{ $value->id }}, 0)">
                                                                <i class="ft-x-circle"></i> Disable</a>
                                                        @else
                                                            <a data-id="{{ $value->id }}" data-value="1"
                                                                class="btn btn-success disable-city"
                                                                style="padding: 5px !important;"
                                                                onclick="updateStatus({{ $value->id }}, 1)"><i
                                                                    class="ft-check-circle"></i> Enable</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a data-id="{{ $value->id }}" class="btn btn-danger delete-city"
                                                            style="padding: 5px !important;"
                                                            onclick="deleteCity({{ $value->id }})"><i
                                                                class="ft-delete"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10">There are no data.</td>
                                            </tr>
                                        @endif
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.min.js"></script>
    <script type="text/javascript">
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });

        function fetchAllSpecialCities(query = '') {
            $.ajax({
                url: "{{ route('search-plus-load-data.special-city') }}",
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json',
                success: function(data) {
                    $('tbody').html(data.table_data);
                }
            });
        }

        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            fetchAllSpecialCities(query);
        });

        function updateStatus(id, value) {
            $.ajax({
                url: "{{ route('special-city.update') }}",
                method: 'GET',
                data: {
                    id: id,
                    status: value
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        fetchAllSpecialCities('');
                        printSuccessMessage(data.message);
                    } else {
                        printErrorMessage(data.message);
                    }
                }
            });
        }

        function deleteCity(id) {
            $.ajax({
                url: "{{ route('special-city.delete') }}",
                method: 'GET',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        fetchAllSpecialCities('');
                        printSuccessMessage(data.message);
                    } else {
                        printErrorMessage(data.message);
                    }
                }
            });
        }

        function printSuccessMessage(msg) {
            var message =
                "<div class='alert alert-success alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>" +
                msg + "</strong></div>";
            $("#message").html(message);
        }

        function printErrorMessage(msg) {
            var message =
                "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>" +
                msg + "</strong></div>";
            $("#message").html(message);
        }
        $("#city_create").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $(".error-print").remove();
            $.ajax({
                url: "{{ route('special-city.store') }}",
                method: 'POST',
                data: $('#city_create').serialize(),
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'success') {
                        fetchAllSpecialCities('');
                        printSuccessMessage(data.message);
                    } else {
                        printErrorMessage(data.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        printValidationErrorMsg(form, xhr.responseJSON.errors);
                    }
                }
            });
        })

        function printValidationErrorMsg(form, msg) {
            $(".help-block").remove('');
            var errors = '';
            $.each(msg, function(key, value) {
                $(form).find("[name='" + key + "']").after("<span class='error-print' >" + value[0] + "</span>");
            });
        }
    </script>
@endsection
