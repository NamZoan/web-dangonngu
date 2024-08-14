@extends('admin.layouts.index')
@section('css')
    <style type="text/css">
        body {
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Chỉnh Sửa Ngôn Ngữ</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        
                        <div class="x_content">
                            <br/>
                            <form method="POST" action="{{ route('admin_language_update_post',['id' => $language->id]) }}" id="demo-form2"
                                data-parsley-validate class="form-horizontal form-label-left">
                                @csrf
                                @foreach ($languages as $lang)
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">{{ $lang->getTranslation('name', 'vi') }}</label>
                                    <div class="col-md-3 col-sm-3 ">
                                        <input type="text" id="last-name" name="language_{{$lang->abbr}}" required="required" value="{{ $language->getTranslation('name', $lang->abbr) }}"
                                            class="form-control">
                                    </div>
                                </div>
                                @endforeach
                                
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
