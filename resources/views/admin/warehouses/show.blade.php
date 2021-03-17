@extends('admin::layouts.app')

@php
    $pageTitle = 'Warehouses';
    $pageResource = 'admin.warehouses';
@endphp

@section('content')

    @include('admin.components.flash-message')

    <div class="card card-lightblue card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @include('admin.components.nav.show')
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
