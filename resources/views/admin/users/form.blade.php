<div class="form-group{{ $errors->has('name', $data->name) ? ' has-error' : '' }}">
    <label for="name" class="control-label col-sm-12 required">Name:</label>
    <div class="col-sm-12">
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $data->name) }}" required>

        @if ($errors->has('name'))
            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email', $data->email) ? ' has-error' : '' }}">
    <label for="email" class="control-label col-sm-12 required">Email:</label>
    <div class="col-sm-12">
        <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $data->email) }}" required>

        @if ($errors->has('email'))
            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('password', $data->password) ? ' has-error' : '' }}">
    <label for="password" class="control-label col-sm-12 {{$data->password ? '' : 'required'}}">
        Password: <small>(Leave Empty to remain unchanged)</small>
    </label>
    <div class="col-sm-12">
        <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}"  {{$data->password ? '' : 'required'}}>

        @if ($errors->has('password'))
            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
        @endif
    </div>
</div>
