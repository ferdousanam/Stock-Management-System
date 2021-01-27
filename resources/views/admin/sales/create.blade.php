@extends('admin.layouts.app')

@php
    $pageTitle = 'Sales';
    $pageResource = 'admin.sales';
@endphp

@section('content')

    @if (session('message'))
        <section class="content-header">
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session('message') }}
            </div>
        </section>
    @endif

    <div class="card card-lightblue card-outline card-outline-tabs" id="sale_item">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @if (Route::has($pageResource.'.index'))
                    <li class="nav-item">
                        <a href="{{ route($pageResource.'.index') . qString() }}" class="nav-link">
                            <i class="fa fa-list" aria-hidden="true"></i> {{ $pageTitle }} List
                        </a>
                    </li>
                @endif

                @if (Route::has($pageResource.'.create'))
                    <li class="nav-item">
                        <a href="{{ route($pageResource.'.create') . qString() }}" class="nav-link active">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add {{ $pageTitle }}
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
                                <div class="col-sm-12">

                                    @include('admin.sales.form')

                                    <div class="form-group px-2">
                                        <button type="submit" class="btn btn-success btn-flat">Submit</button>
                                        <button type="reset" class="btn btn-warning btn-flat">Reset</button>
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

@push('scripts')
    @include('admin.sales.script')
@endpush

