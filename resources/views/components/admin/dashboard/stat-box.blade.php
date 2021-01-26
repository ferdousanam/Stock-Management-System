<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box {{isset($class) ? $class : 'bg-info'}}">
        <div class="inner">
            <h3>{{ isset($count) ? $count : 0 }}</h3>
            <p>{{ isset($label) ? $label : '' }}</p>
        </div>
        <div class="icon">
            {{ isset($icon) ? $icon : null }}
        </div>
        <a href="{{ isset($route) ? $route : '#' }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- ./col -->
