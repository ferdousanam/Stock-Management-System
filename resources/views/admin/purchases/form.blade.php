<div class="row">
    <div class="col-md-4 form-group{{ $errors->has('date', $data->date) ? ' has-error' : '' }}">
        <label for="date" class="control-label col-sm-12 required">Purchase Date:</label>
        <div class="col-sm-12">
            <input type="text" class="form-control datepicker" name="date" id="date" value="{{ formatDate(old('date', $data->date)) }}" required>

            @if ($errors->has('date'))
                <span class="help-block"><strong>{{ $errors->first('date') }}</strong></span>
            @endif
        </div>
    </div>

    <div class="col-md-4 form-group{{ $errors->has('due_date', $data->due_date) ? ' has-error' : '' }}">
        <label for="due_date" class="control-label col-sm-12 required">Due Date:</label>
        <div class="col-sm-12">
            <input type="text" class="form-control datepicker" name="due_date" id="due_date" value="{{ formatDate(old('due_date', $data->due_date)) }}" required>

            @if ($errors->has('due_date'))
                <span class="help-block"><strong>{{ $errors->first('due_date') }}</strong></span>
            @endif
        </div>
    </div>

    <div class="col-md-4 form-group{{ $errors->has('payment_status') ? ' has-error' : '' }}">
        <label for="payment_status" class="control-label col-sm-12 required">Payment Status:</label>
        <div class="col-sm-12">
            @php($payment_status = old('payment_status', $data->payment_status))
            <select class="form-control" name="payment_status" id="payment_status" required>
                <option value="">Select Payment Status</option>
                <option value="pending" {{$payment_status=='pending'?'selected':''}}>Pending</option>
                <option value="paid" {{$payment_status=='paid'?'selected':''}}>Paid</option>
            </select>

            @if ($errors->has('payment_status'))
                <span class="help-block"><strong>{{ $errors->first('payment_status') }}</strong></span>
            @endif
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
                            @{{ item.title }} (@{{ item.product_code }})
                        </td>
                        <td>
                            <input name="product_id[]" type="hidden" :value="item.product_id">
                            <input class="form-control expiry_date" name="expiry_date[]" type="text" :value="formatDate(item.expiry_date)" :data-id="item.product_id">
                        </td>
                        <td class="text-right">
                            <span class="text-right">@{{ item.price }}</span>
                        </td>
                        <td class="text-center">
                            <input v-model="item.quantity" @input="handleChangeQty" class="form-control text-center" name="quantity[]" type="number" min="1" value="1">
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
                            <i @click="remove_product_item(item.id)" class="fa fa-times tip" title="Remove" style="cursor:pointer;"></i>
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
