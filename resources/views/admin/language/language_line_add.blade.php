@extends('admin.layouts.index')
@section('css')
    <style type="text/css">
        body {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_content">
                            <br />
                            <form method="POST" action="{{ route('admin_language_line_add_post') }}" id="demo-form2"
                                data-parsley-validate class="form-horizontal form-label-left">
                                @csrf
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Group
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="last-name" name="group" required="required"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Key
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="last-name" name="key" required="required"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label for="middle-name"
                                        class="col-form-label col-md-3 col-sm-3 label-align">Text</label>
                                    <div class="col-md-3 col-sm-3 ">
                                        <input id="middle-name" placeholder="vietnam" class="form-control" type="text"
                                            name="text-vi">
                                    </div>
                                    <div class="col-md-3 col-sm-3 ">
                                        <input id="middle-name" placeholder="english" class="form-control" type="text"
                                            name="text-en">
                                    </div>
                                    <div class="col-md-3 col-sm-3 ">
                                        <input id="middle-name" placeholder="French" class="form-control" type="text"
                                            name="text-fr">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <button class="btn btn-primary" type="button">Cancel</button>
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
