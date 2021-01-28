<div class="form-group{{ $errors->has('code', $data->code) ? ' has-error' : '' }}">
    <label for="code" class="control-label col-sm-3">Code:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $data->code) }}">

        @if ($errors->has('code'))
            <span class="help-block"><strong>{{ $errors->first('code') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('name', $data->name) ? ' has-error' : '' }}">
    <label for="name" class="control-label col-sm-3 required">Name:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $data->name) }}" required>

        @if ($errors->has('name'))
            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('phone', $data->phone) ? ' has-error' : '' }}">
    <label for="phone" class="control-label col-sm-3">Phone:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $data->phone) }}">

        @if ($errors->has('phone'))
            <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email', $data->email) ? ' has-error' : '' }}">
    <label for="email" class="control-label col-sm-3">Email:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="email" id="email" value="{{ old('email', $data->email) }}">

        @if ($errors->has('email'))
            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
    <label for="address" class="control-label col-sm-3">Address:</label>
    <div class="col-sm-9">
        <textarea class="form-control" name="address" id="address" rows="5">{{ old('address', $data->address) }}</textarea>

        @if ($errors->has('address'))
            <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
        @endif
    </div>
</div>
