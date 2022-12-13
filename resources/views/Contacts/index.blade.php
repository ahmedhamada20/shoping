@extends('layouts.app')
@section('header_extends')


@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Contacts List</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">List of Contacts</a>
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
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>{{ Session::get('message') }}</strong>
                </div>
                @endif
                <!-- search box -->
                <div class="form-inline" id="search-box">
                    <label for="search">Search Box : </label>
                    <input style="margin-left: 10px;" type="text" class="form-control" placeholder="Search Contacts Here." id="search" name="search"></input>
                </div>
                <div class="portlet box blue-hoki">
                    <!-- <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Registered Users
                        </div>
                        <div class="addbtntable">
                            <a href="" class="btn btn-danger">Export CSV</a>
                        </div>
                    </div> -->
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <div class="registered-users">Total Contacts : <span id="totaluser"></span></div>
                            <p id="sample"></p>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th> Fullname </th>
                                        <th> Email </th>
                                        <!-- <th> Subject</th> -->
                                        <th> Action</th>
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

<div class="modal" tabindex="-1" id="contacts-Modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: transparent linear-gradient(167deg, #25365c 0%, #1c5997 100%) 0% 0% no-repeat padding-box !important;">
                <h4 class="modal-title" style="color: #fff;font-weight: bold;">Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="label-control" for="fullname" style="color: #000;font-weight: bold;">Fullname :</label>
                <p id="fullname" name="fullname" class="fullname" style="color: #000;"></p>

                <label class="label-control" for="email" style="color: #000;font-weight: bold;">Email :</label>
                <p id="email" name="email" class="email" style="color: #000;"></p>

                <label class="label-control" for="description" style="color: #000;font-weight: bold;">Description :</label>
                <p id="description" name="description" class="description" style="color: #000;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary ok" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_extends')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.min.js"></script> -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#contacts-Modal').modal('hide');
        // event.preventDefault();
        fetch_registered_users();

        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });



        function fetch_registered_users(query = '') {
            $.ajax({
                url: "{{route('live_search.Contact')}}",
                method: 'GET',
                data: {
                    query: query
                },
                dataType: 'json',
                success: function(data) {
                    $('tbody').html(data.table_data);
                    $('#sample').text(data.totaluser);
                }
            });
        }

        $(document).on('keyup', '#search', function() {
            var query = $(this).val();
            fetch_registered_users(query);
        });





    });
    $('.ok-btn').click(function(){
        $('#contacts-Modal').toggle();
    });

    function contactDetails(id) {
        $.ajax({
            url: "{{route('Contact.detail')}}",
            type: 'GET',
            data: {
                "id": id
            },
            success: function(data) {
                console.log(data);
                // $('#subject').html(data.subject);
                $('#description').html(data.description);
                $('#email').html(data.email);
                $('#fullname').html(data.name);
            }
        })
    }
</script>
@endsection