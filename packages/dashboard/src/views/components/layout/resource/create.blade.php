@extends('admin::layouts.app')

@section('content')

    @include('admin.components.flash-message')

    <div class="card card-lightblue card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                @include('admin::components.nav.create')
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{ route($pageResource.'.store') }}" class="form-horizontal" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6">

                                    {{ $slot }}

                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-success btn-flat btn-lg">Create</button>
                                        <button type="reset" class="btn btn-warning btn-flat btn-lg">Clear</button>
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
