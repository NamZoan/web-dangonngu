@extends('admin.layouts.index')
@section('css')
    <style type="text/css">
        body {
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="col" role="main">
        <div class="container">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="container">
                            <div class="row flex-lg-nowrap">
                                <div class="col">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="e-profile">
                                                        <div class="tab-content pt-3">
                                                            <div class="tab-pane active">
                                                                <form class="form" method="POST"
                                                                    action="{{ route('admin_change_password') }}"
                                                                    novalidate>
                                                                    @csrf

                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 mb-3">
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    @if ($errors->has('error'))
                                                                                        <div class="alert alert-danger">
                                                                                            {{ $errors->first('error') }}
                                                                                        </div>
                                                                                    @endif
                                                                                    @if ($errors->has('success'))
                                                                                        <div class="alert alert-success">
                                                                                            {{ $errors->first('success') }}
                                                                                        </div>
                                                                                    @endif
                                                                                    <div class="form-group">
                                                                                        <label>Email</label>
                                                                                        <h4>{{ $user->email }}</h4>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>Tên</label>
                                                                                        <input name="name"
                                                                                            class="form-control"
                                                                                            type="text"
                                                                                            value="{{ $user->name }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>Xác Nhận Mật Khẩu</label>
                                                                                        <input name="password"
                                                                                            class="form-control"
                                                                                            type="password">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>Mật Khẩu Mới</label>
                                                                                        <input name="newPass"
                                                                                            class="form-control"
                                                                                            type="password">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <div class="form-group">
                                                                                        <label>Xác Nhận Mật Khẩu Mới
                                                                                        </label>
                                                                                        <input name="confirmNewPass"
                                                                                            class="form-control"
                                                                                            type="password">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col d-flex justify-content-end">
                                                                            <button class="btn btn-primary"
                                                                                type="submit">Save
                                                                                Changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- page content -->
