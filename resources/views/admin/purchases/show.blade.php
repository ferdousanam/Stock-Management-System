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
                        <i class="fa fa-th-list" aria-hidden="true"></i> {{ $pageTitle }} Details
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
                                    <th style="width:230px;">Purchase Code</th>
                                    <th style="width:10px;">:</th>
                                    <td>{{$data->purchase_code}}</td>
                                </tr>
                                <tr>
                                    <th>Purchase Date</th>
                                    <th>:</th>
                                    <td>{{formatDate($data->date)}}</td>
                                </tr>
                                <tr>
                                    <th>Net Total</th>
                                    <th>:</th>
                                    <td>{{$data->net_total}}</td>
                                </tr>
                                <tr>
                                    <th>Net Discount</th>
                                    <th>:</th>
                                    <td>{{$data->net_discount}}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <th>:</th>
                                    <td>{{$data->payment_status}}</td>
                                </tr>
                                <tr>
                                    <th>Due Date</th>
                                    <th>:</th>
                                    <td>{{formatDate($data->due_date)}}</td>
                                </tr>
                                <tr>
                                    <th>Issue Date</th>
                                    <th>:</th>
                                    <td>{{formatDateTime($data->created_at)}}</td>
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
                <h3 class="card-title text-bold">Purchase Items</h3>
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
                                @foreach($data->purchaseItems as $key => $record)
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
