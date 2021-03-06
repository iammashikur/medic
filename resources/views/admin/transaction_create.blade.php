@php
$page_type = 'Admin';
$page_title = 'Create Transaction';
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
                    <h4>Create Transaction</h4>
                    <div class="card-header-action">
                        <a href="{{ route('transaction.index') }}" class="btn btn-warning">Go Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('transaction.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">User Type</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="user_type" required>

                                    <option> -- select -- </option>
                                    <option value="agent"> Agent </option>
                                    <option value="patient"> Patient </option>
                                    <option value="doctor"> Doctor </option>
                                    <option value="hospital"> Hospital </option>
                                    <option value="medic"> Medic </option>

                                </select>
                            </div>
                        </div>



                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">User </label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="user_id" required>
                                    <option> -- select -- </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Transaction Type</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="transaction_type" required>
                                    <option> -- select -- </option>

                                    <option value="-"> Debit </option>
                                    <option value="+"> Credit </option>

                                </select>
                            </div>
                        </div>


                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Amount</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="form-group">
                                    <input type="number"
                                    class="form-control" name="amount" required>
                                </div>
                            </div>
                        </div>








                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary">Create Transaction</button>
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
        $('select[name="user_type"]').on('change', function() {
            var userType = $(this).val();
            if (userType) {
                $.ajax({
                    url: '{{ url('user-by-type') }}/' + userType,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        console.log(data);

                        $('select[name="user_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="user_id"]').append('<option value="' + value.id +
                                '">' +
                                value.name + '</option>');
                        });

                    }
                });
            } else {
                $('select[name="user_id"]').empty();
            }
        });
    </script>
@endpush
