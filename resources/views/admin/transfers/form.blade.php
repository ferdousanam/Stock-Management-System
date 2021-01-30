<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-4 form-group{{ $errors->has('date', $data->date) ? ' has-error' : '' }}">
                <label for="date" class="control-label col-sm-12 required">Transfer Date:</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control datepicker" name="date" id="date" value="{{ formatDate(old('date', $data->date)) }}" required>

                    @if ($errors->has('date'))
                        <span class="help-block"><strong>{{ $errors->first('date') }}</strong></span>
                    @endif
                </div>
            </div>

            <div class="col-md-4 form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                <label for="status" class="control-label col-sm-12 required">Status:</label>
                <div class="col-sm-12">
                    @php($status = old('status', $data->status))
                    <select class="form-control" name="status" id="status" required>
                        <option value="">Select Status</option>
                        <option value="pending" {{$status=='pending'?'selected':''}}>Pending</option>
                        <option value="paid" {{$status=='paid'?'selected':''}}>Paid</option>
                    </select>

                    @if ($errors->has('status'))
                        <span class="help-block"><strong>{{ $errors->first('status') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row">
            <div class="col-md-4 form-group{{ $errors->has('from_warehouse_id') ? ' has-error' : '' }}">
                <label for="from_warehouse_id" class="control-label col-sm-12 required">Warehouse (From):</label>
                <div class="col-sm-12">
                    @php($from_warehouse_id = old('from_warehouse_id', $data->from_warehouse_id))
                    <select class="form-control" name="from_warehouse_id" id="from_warehouse_id" required>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{$warehouse->id}}" {{($from_warehouse_id==$warehouse->id)?'selected':''}}>{{$warehouse->name}}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('from_warehouse_id'))
                        <span class="help-block"><strong>{{ $errors->first('from_warehouse_id') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="col-md-4 form-group{{ $errors->has('to_warehouse_id') ? ' has-error' : '' }}">
                <label for="to_warehouse_id" class="control-label col-sm-12 required">Warehouse (To):</label>
                <div class="col-sm-12">
                    @php($to_warehouse_id = old('to_warehouse_id', $data->to_warehouse_id))
                    <select class="form-control" name="to_warehouse_id" id="to_warehouse_id" required>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{$warehouse->id}}" {{($to_warehouse_id==$warehouse->id)?'selected':''}}>{{$warehouse->name}}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('to_warehouse_id'))
                        <span class="help-block"><strong>{{ $errors->first('to_warehouse_id') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 px-3">
        <input type="text" class="form-control p-4" name="add_item" id="add_item" placeholder="Please add products to order list">
    </div>
</div>

<div class="row mt-4">
    <div class="col-sm-12 px-3">
        <div>
            <label class="table-label">Order Items</label>
            <div>
                <table id="poTable" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="text-center">
                        <th>Product (Code - Name)</th>
                        <th>Expiry Date</th>
                        <th>Net Unit Cost</th>
                        <th class="text-center">Quantity</th>
                        <th>Discount</th>
                        <th>Product Tax</th>
                        <th>Subtotal (<span class="currency">BDT</span>)</th>
                        <th class="text-center">
                            <i class="fas fa-trash-alt" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in products">
                        <td>
                            <input name="product_id[]" type="hidden" :value="item.product_id">
                            @{{ item.title }} (@{{ item.product_code }})
                        </td>
                        <td>
                            <input v-if="item.transfer_item_id" :name="`transfer_items[${index}]['transfer_item_id']`" type="hidden" :value="item.transfer_item_id">
                            <input :name="`transfer_items[${index}][product_id]`" type="hidden" :value="item.product_id">
                            <input class="form-control expiry_date" :name="`transfer_items[${index}][expiry_date]`" type="text" autocomplete="off" :value="formatDate(item.expiry_date)" :data-id="item.product_id">
                        </td>
                        <td class="text-right">
                            <span class="text-right">@{{ item.price }}</span>
                        </td>
                        <td class="text-center">
                            <input v-model="item.quantity" @input="handleChangeQty" class="form-control text-center" :name="`transfer_items[${index}][quantity]`" type="number" min="1" value="1">
                        </td>
                        <td class="text-right">
                            <span class="text-right text-danger">0.00</span>
                        </td>
                        <td class="text-right">
                            <span class="text-right">0.00</span>
                        </td>
                        <td class="text-right">
                            <span class="text-right">@{{ item.net_cost }}</span>
                        </td>
                        <td class="text-center">
                            <i @click="remove_product_item(item.product_id)" class="fa fa-times tip" title="Remove" style="cursor:pointer;"></i>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot v-if="products.length > 0">
                    <tr class="active">
                        <th colspan="3">Total</th>
                        <th class="text-center">@{{ totalQTy }}</th>
                        <th class="text-right">0.00</th>
                        <th class="text-right">0.00</th>
                        <th class="text-right">@{{ totalSubtotal }}</th>
                        <th class="text-center">
                            <i class="fas fa-trash-alt" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .table > tbody > tr > td {
            vertical-align: middle;
        }
    </style>
@endpush
