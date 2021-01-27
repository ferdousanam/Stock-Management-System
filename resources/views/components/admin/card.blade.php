<div class="card card-lightblue card-outline card-outline-tabs">
    @if (isset($header))
        <div class="card-header">
            <h3 class="card-title text-bold">{{ $header }}</h3>
        </div>
    @endif
    <div class="card-body">{{ $slot }}</div>
</div>
