@extends('admin::layouts.app')

@php
    $pageTitle = 'Purchase';
    $pageResource = 'admin.purchases';
@endphp

@section('content')

    @include('admin.components.flash-message')

    <div class="card card-lightblue card-outline card-outline-tabs" id="purchase_item">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @include('admin.components.nav.create')
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

                                    @include('admin.purchases.form')

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
    @include('admin.purchases.script')
@endpush
