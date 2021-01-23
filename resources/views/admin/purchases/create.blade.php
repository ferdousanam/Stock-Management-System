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

    <div class="card card-lightblue card-outline card-outline-tabs" id="purchase_item">
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
                        <a href="{{ route($pageResource.'.create') . qString() }}" class="nav-link active">
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
    <script>
        vm = new Vue({
            el: '#purchase_item',
            data: {
                products: [],
            },
            computed: {
                totalQTy: function () {
                    let total = 0;
                    this.products.forEach(item => {
                        total += +item.qty;
                    });
                    return total;
                },
                totalSubtotal: function () {
                    let total = 0;
                    this.products.forEach(item => {
                        total += +item.subtotal;
                    });
                    return total.toFixed(2);
                },
            },
            mounted() {
                this.$nextTick(() => {
                    $("#add_item").autocomplete(productSuggestions((item) => {
                        this.add_product_item({...item, qty: 1, subtotal: item.price})
                    }));
                });
            },
            methods: {
                add_product_item(item) {
                    $('#add_item').val('');
                    this.products.push(item);

                    this.$nextTick(() => {
                        $('.datepicker').datetimepicker(datepickerConfig);
                        $('.quantity_balance_input').change(() => {
                            this.products = this.products.map(item => ({
                                ...item,
                                qty: +(this.$refs['quantity_balance-' + item.id][0].value),
                                subtotal: (item.price * +(this.$refs['quantity_balance-' + item.id][0].value)).toFixed(2)
                            }));
                        });
                    });
                },
                remove_product_item(id) {
                    this.products = this.products.filter(item => item.id !== id);
                }
            }
        });
    </script>
@endpush
