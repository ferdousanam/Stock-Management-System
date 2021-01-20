<div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
    <label for="role_id" class="control-label col-sm-3 required">Role:</label>
    <div class="col-sm-9">
        @php($role_id = old('role_id', $data->role_id))
        <select class="form-control" name="role_id" id="role_id" required>
            <option value="">Select Role</option>
            @if (!empty($roles))
                @foreach ($roles as $role)
                    <option value="{{$role->id}}" {{ ($role_id==$role->id)?'selected':'' }}>{{ $role->title }}</option>
                @endforeach
            @endif
        </select>

        @if ($errors->has('role_id'))
            <span class="help-block"><strong>{{ $errors->first('role_id') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('full_name', $data->full_name) ? ' has-error' : '' }}">
    <label for="full_name" class="control-label col-sm-3 required">Name:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="full_name" id="full_name" value="{{ old('full_name', $data->full_name) }}" required>

        @if ($errors->has('full_name'))
            <span class="help-block"><strong>{{ $errors->first('full_name') }}</strong></span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
    <label for="note" class="control-label col-sm-3">Address:</label>
    <div class="col-sm-9">
        <textarea class="form-control" name="note" id="note" rows="5">{{ old('note', $data->address) }}</textarea>

        @if ($errors->has('note'))
            <span class="help-block"><strong>{{ $errors->first('note') }}</strong></span>
        @endif
    </div>
</div>
