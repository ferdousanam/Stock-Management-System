@extends('admin::layouts.app')

@php
    $pageTitle = 'Stock Management';
    $pageResource = 'admin.stock-management';
@endphp

@section('content')

    @include('admin.components.flash-message')

    <div class="card card-lightblue card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @include('admin.components.nav.edit')
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="row">
                    <div class="col-sm-12">
                        @if (isset($data))
                            <form method="POST" action="{{ route($pageResource.'.update', $data->id) }}" class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-sm-6">

                                        @include('admin.stock-management.form')

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-success btn-flat btn-lg">Update
                                            </button>
                                            <a href="{{ route($pageResource.'.index') }}" class="btn btn-warning btn-flat btn-lg">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
