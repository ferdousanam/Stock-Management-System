@extends('admin::layouts.app')

@php
    $pageTitle = 'Products';
    $pageResource = 'admin.products';
    $activeNavSelector = '#products-mm .nav-link';
@endphp

@section('content')

    @include('admin.components.flash-message')

    <div class="card card-lightblue card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @include('admin.components.nav.index')
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="GET" action="{{ route($pageResource.'.index') }}">
                            <div class="d-flex justify-content-end">
                                <div class="filter-input-box">
                                    <select class="form-control select2" name="product_brand_id">
                                        <option value="">Brand</option>
                                        @if (!empty($brands))
                                            @foreach ($brands as $brand)
                                                <option value="{{$brand->id}}" {{(request('product_brand_id')==$brand->id)?'selected':''}}>{{$brand->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="filter-input-box">
                                    <select class="form-control select2" name="product_category_id">
                                        <option value="">Category</option>
                                        @if (!empty($categories))
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}" {{(request('product_category_id')==$category->id)?'selected':''}}>{{$category->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="filter-input-box">
                                    <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Search">
                                </div>

                                <div class="">
                                    <button type="submit" class="btn btn-primary btn-flat">Search</button>
                                    <a class="btn btn-warning btn-flat" href="{{ route($pageResource.'.index') }}">X</a>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box-body table-responsive">
                                    <span class="text-muted">Showing {{$records->currentPage()*$records->perPage()-$records->perPage()+1}} to {{ ($records->currentPage()*$records->perPage()>$records->total())?$records->total():$records->currentPage()*$records->perPage()}} of {{$records->total()}} data(s)</span>
                                    <table class="table table-bordered table-striped applyDataTable">
                                        <caption class="hidden"><h3>{{ $pageTitle }} List</h3></caption>
                                        <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Title</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Alert Quantity</th>
                                            <th>Created at</th>
                                            <th class="text-center not-export-col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $key => $record)
                                            <tr>
                                                <td>{{$serial++}}</td>
                                                <td>{{$record->title}}</td>
                                                <td>{{$record->product_brand_title}}</td>
                                                <td>{{$record->product_category_title}}</td>
                                                <td>{{$record->price}}</td>
                                                <td class="text-right">{{$record->remaining_quantity}}</td>
                                                <td class="text-right">{{$record->alert_quantity}}</td>
                                                <td>{{formatDateTime($record->created_at)}}</td>
                                                <td class="text-center">
                                                    @php
                                                        $access = 1;
                                                        listAction([
                                                            actionLi(route($pageResource.'.show', $record->id).qString(), 'show', $access),
                                                            actionLi(route($pageResource.'.edit', $record->id).qString(), 'edit', $access),
                                                            actionLi(route($pageResource.'.destroy', $record->id).qString(), 'delete', $access),
                                                        ]);
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
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
@endsection
