@extends('admin.layouts.app')

@php
    $pageTitle = "Dashboard";
    $activeNavSelector = '#dashboard-mm .nav-link';
@endphp

@section('content')
    <div class="row">
        <x-admin.dashboard.stat-box :count="$totalProducts" label="Products" :route="route('admin.products.index')" class="bg-teal">
            <x-slot name="icon">
                <i class="ion ion-bag"></i>
            </x-slot>
        </x-admin.dashboard.stat-box>

        <x-admin.dashboard.stat-box :count="$totalStocks" label="Purchased Total" :route="route('admin.purchases.index')" class="bg-red">
            <x-slot name="icon">
                <i class="fas fa-star"></i>
            </x-slot>
        </x-admin.dashboard.stat-box>
    </div>
@endsection
