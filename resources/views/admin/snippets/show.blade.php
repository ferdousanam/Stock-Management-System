@extends('admin::layouts.app')

@php
    $pageTitle = '<?php print $pageTitle ?>';
    $pageResource = '<?php print $pageResource ?>';
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
                                    <th style="width:230px;">ID</th>
                                    <th style="width:10px;">:</th>
                                    <td>{{ $data->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>:</th>
                                    <td>{{ $data->name }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <th>:</th>
                                    <td>{{ $data->created_at }}</td>
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
