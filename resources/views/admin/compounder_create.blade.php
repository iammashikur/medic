@php
$page_type = 'Admin';
$page_title = 'Add Compounder';
@endphp
@extends('admin.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ url('assets/admin/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ url('assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/admin/css/components.css') }}">
    <style>
        .col-form-label.text-md-right.col-12.col-md-3.col-lg-3 {
            font-size: 15px;
        }

    </style>
@endpush

@section('content')
    <div class="main-content">
        <div class="section">
            @include('admin.partials.error')

            <div class="card card-primary">
                <div class="card-header" style="border-bottom-color: #d0d0d0">
                    <h4>Add Compounder</h4>
                    <div class="card-header-action">
                        <a href="{{ route('compounder.index') }}" class="btn btn-warning">Go Back</a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('compounder.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Profile Picture</label>
                            <div class="col-sm-12 col-md-7">
                                <div id="image-preview" class="image-preview"
                                    style="background-image: url(); background-size: cover; background-position: center center;">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="avatar" id="image-upload" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gender</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="gender" required>
                                    <option value="">select gender</option>
                                    @foreach ($gender as $genders)
                                        <option value="{{ $genders->id }}">{{ $genders->gender }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mobile</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="password" class="form-control" required>
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">District</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="district" id="">
                                    <option value="">---District---</option>
                                    @foreach (App\Models\District::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thana</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="thana" id="">
                                    <option value="">---Thana---</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Doctors</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="doctors[]" multiple="multiple">
                                    @foreach (App\Models\Doctor::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Hospital</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="hospitals">
                                    <option value="">None</option>
                                    @foreach (App\Models\Hospital::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Add Compounder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ url('assets/admin/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ url('assets/admin/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ url('assets/admin/bundles/ckeditor/ckeditor.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ url('assets/admin/js/page/create-post.js') }}"></script>
    <script src="{{ url('assets/admin/js/page/ckeditor.js') }}"></script>

    <script>
        $('select[name="district"]').on('change', function() {
            var districtID = $(this).val();
            if (districtID) {
                $.ajax({
                    url: '{{ url('thana-by-district') }}/' + districtID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        console.log(data);

                        $('select[name="thana"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="thana"]').append('<option value="' + value.id +
                                '">' +
                                value.name + '</option>');
                        });


                    }
                });
            } else {
                $('select[name="thana"]').empty();
            }
        });
    </script>
@endpush
