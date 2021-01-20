<div class="form-group{{ $errors->has('title', $data->title) ? ' has-error' : '' }}">
    <label for="title" class="control-label col-sm-3 required">Product Title:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $data->title) }}" required>

        @if ($errors->has('title'))
            <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('product_brand_id') ? ' has-error' : '' }}">
    <label for="product_brand_id" class="control-label col-sm-3 required">Brand:</label>
    <div class="col-sm-9">
        @php($product_brand_id = old('product_brand_id', $data->product_brand_id))
        <select class="form-control" name="product_brand_id" id="product_brand_id" required>
            <option value="">Select Brand</option>
            @if (!empty($brands))
                @foreach ($brands as $brand)
                    <option value="{{$brand->id}}" {{ ($product_brand_id==$brand->id)?'selected':'' }}>{{ $brand->title }}</option>
                @endforeach
            @endif
        </select>

        @if ($errors->has('product_brand_id'))
            <span class="help-block"><strong>{{ $errors->first('product_brand_id') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('product_category_id') ? ' has-error' : '' }}">
    <label for="product_category_id" class="control-label col-sm-3 required">Brand:</label>
    <div class="col-sm-9">
        @php($product_category_id = old('product_category_id', $data->product_category_id))
        <select class="form-control" name="product_category_id" id="product_category_id" required>
            <option value="">Select Brand</option>
            @if (!empty($categories))
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{ ($product_category_id==$category->id)?'selected':'' }}>{{ $category->title }}</option>
                @endforeach
            @endif
        </select>

        @if ($errors->has('product_category_id'))
            <span class="help-block"><strong>{{ $errors->first('product_category_id') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('price', $data->price) ? ' has-error' : '' }}">
    <label for="price" class="control-label col-sm-3 required">Price:</label>
    <div class="col-sm-9">
        <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $data->price) }}" required>

        @if ($errors->has('price'))
            <span class="help-block"><strong>{{ $errors->first('price') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('alert_quantity', $data->alert_quantity) ? ' has-error' : '' }}">
    <label for="alert_quantity" class="control-label col-sm-3">Alert Quantity:</label>
    <div class="col-sm-9">
        <input type="number" class="form-control" name="alert_quantity" id="alert_quantity" value="{{ old('alert_quantity', $data->alert_quantity) }}">

        @if ($errors->has('alert_quantity'))
            <span class="help-block"><strong>{{ $errors->first('alert_quantity') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="description" class="control-label col-sm-3">Description:</label>
    <div class="col-sm-9">
        <textarea class="form-control" name="description" id="description" rows="5">{{ old('description', $data->description) }}</textarea>

        @if ($errors->has('description'))
            <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
        @endif
    </div>
</div>
