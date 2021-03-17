@if (Route::has($pageResource.'.index'))
    <li class="nav-item">
        <a href="{{ route($pageResource.'.index') }}" class="nav-link">
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

<li class="nav-item">
    <a href="#" class="nav-link active">
        <i class="far fa-file-alt" aria-hidden="true"></i> {{ $pageTitle }} Details
    </a>
</li>
