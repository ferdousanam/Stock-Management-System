@extends('admin.layouts.app')

@php
    $pageTitle = "Dashboard";
    $activeNavSelector = '#dashboard-mm .nav-link';
@endphp

@section('content')
    <x-admin.card>
        <div class="row">
            <x-admin.dashboard.stat-box :count="$totalProducts" label="Products" :route="route('admin.products.index')" class="bg-teal">
                <x-slot name="icon">
                    <i class="ion ion-bag"></i>
                </x-slot>
            </x-admin.dashboard.stat-box>

            <x-admin.dashboard.stat-box :count="$totalSales" label="Sales Total" :route="route('admin.sales.index')" class="bg-red">
                <x-slot name="icon">
                    <i class="fas fa-heart"></i>
                </x-slot>
            </x-admin.dashboard.stat-box>

            <x-admin.dashboard.stat-box :count="$totalStocks" label="Purchased Total" :route="route('admin.purchases.index')" class="bg-fuchsia">
                <x-slot name="icon">
                    <i class="fas fa-star"></i>
                </x-slot>
            </x-admin.dashboard.stat-box>
        </div>
    </x-admin.card>

    <!--  Latest Five Start  -->
    <x-admin.card header="Latest Five">
        <ul class="nav nav-tabs" id="latest-five-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="sale-content-tab" data-toggle="pill" href="#sale-content" role="tab" aria-controls="sale-content" aria-selected="true">Sale</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="purchase-content-tab" data-toggle="pill" href="#purchase-content" role="tab" aria-controls="purchase-content" aria-selected="false">Purchase</a>
            </li>
        </ul>
        <div class="tab-content" id="latest-five-tabContent">
            <div class="tab-pane fade show active" id="sale-content" role="tabpanel" aria-labelledby="sale-content-tab">
                @include('admin.dashboard.latest-five.sales')
            </div>
            <div class="tab-pane fade" id="purchase-content" role="tabpanel" aria-labelledby="purchase-content-tab">
                @include('admin.dashboard.latest-five.purchase')
            </div>
        </div>
    </x-admin.card>
    <!--  Latest Five End  -->
@endsection
