@extends('admin.layouts.app')

@php
    $pageTitle = 'Brands';
    $pageResource = 'admin.brands';
    $activeNavSelector = '#brands-mm .nav-link';
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

    <livewire:admin.categories.create/>
    <livewire:admin.categories.edit/>

    <div class="card card-lightblue card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @if (Route::has($pageResource.'.index'))
                    <li class="nav-item">
                        <a href="{{ route($pageResource.'.index') }}" class="nav-link active">
                            <i class="fa fa-list" aria-hidden="true"></i> {{ $pageTitle }} List
                        </a>
                    </li>
                @endif

                @if (Route::has($pageResource.'.create'))
                    <li class="nav-item">
                        <a href="{{ route($pageResource.'.create') }}" class="nav-link">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add {{ $pageTitle }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="GET" action="{{ route($pageResource.'.index') }}">
                            <div class="d-flex justify-content-end">
                                <div class="filter-input-box">
                                    <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Search">
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
                                            <th>Code</th>
                                            <th>Title</th>
                                            <th>Created at</th>
                                            <th class="text-center not-export-col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $key => $record)
                                            <tr>
                                                <td>{{$serial++}}</td>
                                                <td>{{$record->code}}</td>
                                                <td>{{$record->title}}</td>
                                                <td>{{formatDateTime($record->created_at)}}</td>
                                                <td class="text-center">
                                                    @php
                                                        $access = 1;
                                                        listAction([
                                                            actionLi(route($pageResource.'.show', $record->id), 'show', $access),
                                                            actionLi(route($pageResource.'.edit', $record->id), 'edit', $access),
                                                            actionLi(route($pageResource.'.destroy', $record->id), 'delete', $access),
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

@push('scripts')
    <script>
        function editCategory(id) {
            ;
        }

        window.addEventListener('showAddModal', evt => {
            $('#add-modal').modal('show');
        })
        window.addEventListener('hideAddModal', evt => {
            $('#add-modal').modal('hide');
            window.location.reload();
        })
        window.addEventListener('showEditModal', evt => {
            $('#edit-modal').modal('show');
        })
        window.addEventListener('hideEditModal', evt => {
            $('#edit-modal').modal('hide');
            window.location.reload();
        })
    </script>
@endpush
