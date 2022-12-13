@extends('layouts.app')
@section('header_extends')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />

@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Banner upload</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top
            col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Form Layouts</a>
                </li> -->
                <li class="breadcrumb-item active"><a href="#">Banner</a>
                </li>
            </ol>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <h4 class="card-title">Select & Upload Images</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                </ul>
            </div>

        </div>
        <div class="card-content collapse show">
            <div class="row">
                <div class="col-md-12 text-center">


                    <div class="panel panel-default" style="margin: 0px 20px 20px 20px;">
                        <div class="panel-heading">
                            <h3 class="panel-title"></h3>
                        </div>
                        <div class="panel-body">
                            <form id="dropzoneForm" class="dropzone" action="{{ route('banner.upload') }}">
                                @csrf
                            </form>
                            <div align="center" style="margin: 20px 0px 20px 0px;">
                                <button type="button" class="btn btn-info" id="submit-all">Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <!-- Kick start -->
    <div id="kick-start" class="card">
        <div class="card-header">
            <h4 class="card-title">Uploaded Images</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <!-- <li><a data-action="close"><i class="ft-x"></i></a></li> -->
                </ul>
            </div>

        </div>
        <div class="card-content collapse show">
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
        </div>
    </div>
</div>
@endsection
@section('footer_extends')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

<script type="text/javascript">
    Dropzone.options.dropzoneForm = {
        autoProcessQueue: false,
        acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
        maxFilesize: 256,

        init: function() {
            var submitButton = document.querySelector("#submit-all");
            myDropzone = this;

            submitButton.addEventListener('click', function() {
                myDropzone.processQueue();
            });

            this.on("complete", function() {
                if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                    var _this = this;
                    _this.removeAllFiles();
                }
                load_images();
            });

        }

    };

    load_images();

    function load_images() {
        $.ajax({
            url: "{{ route('banner.fetch') }}",
            success: function(data) {
                $('#uploaded_image').html(data);
            }
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
</script>

@endsection