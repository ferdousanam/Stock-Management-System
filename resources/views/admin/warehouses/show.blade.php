@extends('admin.layouts.app')

@php
    $pageTitle = 'Warehouses';
    $pageResource = 'admin.warehouses';
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
                        <i class="far fa-file-alt" aria-hidden="true"></i> {{ $pageTitle }} Details
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="row">
                    <div class="col-sm-12">
                        @if (isset($data))
                            <table class="table table-bordered">
                                <caption class="hidden"><h3>{{ $pageTitle }} Details</h3></caption>
                                <thead>
                                <tr class="hide">
                                    <th style="width:230px;"></th>
                                    <th style="width:10px;"></th>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th style="width:230px;">Name</th>
                                    <th style="width:10px;">:</th>
                                    <td>{{$data->name}}</td>
                                </tr>
                                <tr>
                                    <th>Code</th>
                                    <th>:</th>
                                    <td>{{ $data->code }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <th>:</th>
                                    <td>{{ $data->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th>:</th>
                                    <td>{{ $data->email }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <th>:</th>
                                    <td>{{ $data->address }}</td>
                                </tr>

                                </tbody>
                            </table>
                        @else
                            <div class="box-body">
                                {!! notFoundText() !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
