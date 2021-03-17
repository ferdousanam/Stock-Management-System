@extends('admin::layouts.app')

@php
    $pageTitle = 'Transfers';
    $pageResource = 'admin.transfers';
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
                                    <th>Transfer Code</th>
                                    <th>:</th>
                                    <td>{{ $data->transfer_code }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <th>:</th>
                                    <td>{{ formatDate($data->date) }}</td>
                                </tr>
                                <tr>
                                    <th>Warehouse (From)</th>
                                    <th>:</th>
                                    <td>{{ $data->fromWarehouse->name }}</td>
                                </tr>
                                <tr>
                                    <th>Warehouse (To)</th>
                                    <th>:</th>
                                    <td>{{ $data->toWarehouse->name }}</td>
                                </tr>
                                <tr>
                                    <th>Net Total</th>
                                    <th>:</th>
                                    <td>{{ $data->net_total }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <th>:</th>
                                    <td>{{ $data->status }}</td>
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
    @if (isset($data))
        <div class="card card-lightblue card-outline card-outline-tabs">
            <div class="card-header">
                <h3 class="card-title text-bold">Transfer Items</h3>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>Product Title</th>
                                    <th class="text-center">Product Code</th>
                                    <th>Unit Cost</th>
                                    <th>Net Cost</th>
                                    <th>Net Discount</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data->transferItems as $key => $record)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$record->product->title}}</td>
                                        <td class="text-center">{{$record->product->product_code}}</td>
                                        <td class="text-right">{{$record->unit_cost}}</td>
                                        <td class="text-right">{{$record->net_cost}}</td>
                                        <td class="text-right">{{$record->net_discount}}</td>
                                        <td class="text-center">{{$record->quantity}}</td>
                                        <td class="text-center">{{$record->status}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
