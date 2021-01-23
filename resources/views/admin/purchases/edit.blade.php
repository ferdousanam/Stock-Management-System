@extends('admin.layouts.app')

@php
    $pageTitle = 'Purchase';
    $pageResource = 'admin.purchases';
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

    <div class="card card-lightblue card-outline card-outline-tabs">
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
                        <a href="{{ route($pageResource.'.create') . qString() }}" class="nav-link">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add {{ $pageTitle }}
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fa fa-plus" aria-hidden="true"></i> Edit {{ $pageTitle }}
                    </a>
                </li>
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

                                        @include('admin.purchases.form')

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
