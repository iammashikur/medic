@php
$page_type = 'Admin';
$page_title = 'Add Agent';
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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="main-content">
        <div class="section">
            @include('admin.partials.error')

            <div class="card card-primary">
                <div class="card-header" style="border-bottom-color: #d0d0d0">
                    <h4>Add Agent</h4>
                    <div class="card-header-action">
                        <a href="{{ route('agent.index') }}" class="btn btn-warning">Go Back</a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('agent.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Billing Address</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="billing_address" class="form-control" required>
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
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bkash</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="bkash" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nagad</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="nagad" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bank Details</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control h-100" name="bank_details" cols="3" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Commission (<span
                                    id="commission">0</span>%)</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="range" name="commission" class="form-control" min="0" max="{{@App\Models\AgentSetting::first()->default_commission ? @App\Models\AgentSetting::first()->default_commission : '100'}}" value="0"
                                    onInput="$('#commission').html($(this).val())" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="status" required>


                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>


                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Add Agent</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.location').select2();
        });
    </script>

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
