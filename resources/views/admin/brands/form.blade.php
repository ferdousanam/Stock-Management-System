<div class="form-group{{ $errors->has('title', $data->title) ? ' has-error' : '' }}">
    <label for="title" class="control-label col-sm-3 required">Title:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $data->title) }}" required>

        @if ($errors->has('title'))
            <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
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
