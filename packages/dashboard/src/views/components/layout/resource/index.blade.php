@props([
    'noFilter' => false,
    'activeNavSelector' => null,
    'activeNavParentSelector' => null,
    'pageTitle',
    'pageResource',
    'records',
])

@extends('admin::layouts.app')

@section('content')

    @include('admin.components.flash-message')

    {{ $top ?? null }}

    <div class="card card-lightblue card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @include('admin::components.nav.index')
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="row">
                    <div class="col-sm-12">
                        @if (!$noFilter)
                            <form method="GET" action="{{ route($pageResource.'.index') }}">
                                <div class="d-flex justify-content-end">

                                    {{ $filter }}

                                    <div class="filter-input-box">
                                        <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Search">
                                    </div>

                                    <div class="">
                                        <button type="submit" class="btn btn-primary btn-flat">Search</button>
                                        <a class="btn btn-warning btn-flat" href="{{ route($pageResource.'.index') }}">X</a>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box-body table-responsive">
                                    <span class="text-muted">Showing {{$records->currentPage()*$records->perPage()-$records->perPage()+1}} to {{ ($records->currentPage()*$records->perPage()>$records->total())?$records->total():$records->currentPage()*$records->perPage()}} of {{$records->total()}} data(s)</span>
                                    <table class="table table-bordered table-striped applyDataTable">
                                        <caption class="hidden"><h3>{{ $pageTitle }} List</h3></caption>

                                        {{ $slot }}

                                    </table>
                                    <div class="float-right">
                                        {{ $records->appends(Request::except('page'))->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

    {{ $bottom ?? null }}

@endsection

@push('styles')
    {{ $styles ?? null }}
@endpush

@push('scripts')
    {{ $scripts ?? null }}
@endpush
