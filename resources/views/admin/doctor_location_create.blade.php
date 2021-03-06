@php
$page_type = 'Admin';
$page_title = 'Add Location';
@endphp
@extends('admin.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ url('assets/admin/bundles/jquery-selectric/selectric.css') }}">
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
                    <h4>Add Location</h4>
                    <div class="card-header-action">
                        <a href="{{ route('doctor.index') }}" class="btn btn-warning">Go Back</a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('doctor-location.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Doctor</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="doctor_id" id="">
                                    <option> -- select -- </option>
                                    @foreach (App\Models\Doctor::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} </option>
                                    @endforeach
                                </select>
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
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Address</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea type="text" name="address" class="form-control" required></textarea>
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start Time</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">End Time</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Consultation Fee</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" name="consultation_fee" class="form-control" required>
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Add Doctor Location</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ url('assets/admin/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
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
