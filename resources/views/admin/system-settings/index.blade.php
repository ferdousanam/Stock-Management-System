@extends('admin::layouts.app')

<?php
$pageTitle='System Settings';
$pageResource='admin.system-settings';
$activeNavParentSelector="#settings-mm.nav-item";
$activeNavSelector="#system-settings-sm .nav-link";
?>

@section('content')

    @include('admin.components.flash-message')

    <div class="card card-lightblue card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @if (Route::has($pageResource.'.index'))
                    <li class="nav-item">
                        <a href="{{ route($pageResource.'.index') }}" class="nav-link active">
                            <i class="fa fa-list" aria-hidden="true"></i> {{ $pageTitle }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{ route($pageResource.'.store') }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group{{ $errors->has('app_name', $data->app_name) ? ' has-error' : '' }}">
                                        <label for="app_name" class="control-label col-sm-3 required">App Name:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="app_name" id="app_name" value="{{ old('app_name', $data->app_name) }}" required>

                                            @if ($errors->has('app_name'))
                                                <span class="help-block"><strong>{{ $errors->first('app_name') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('app_email', $data->app_email) ? ' has-error' : '' }}">
                                        <label for="app_email" class="control-label col-sm-3 required">Email:</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="app_email" id="app_email" value="{{ old('app_email', $data->app_email) }}">

                                            @if ($errors->has('app_email'))
                                                <span class="help-block"><strong>{{ $errors->first('app_email') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('app_mobile', $data->app_mobile) ? ' has-error' : '' }}">
                                        <label for="app_mobile" class="control-label col-sm-3 required">Mobile:</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="app_mobile" id="app_mobile" value="{{ old('app_mobile', $data->app_mobile) }}">

                                            @if ($errors->has('app_mobile'))
                                                <span class="help-block"><strong>{{ $errors->first('app_mobile') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-success btn-flat btn-lg">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
