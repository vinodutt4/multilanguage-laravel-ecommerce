<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            @foreach ($crumbs = Theme::breadcrumb()->getCrumbs() as $i => $crumb)
                @if ($i != (count($crumbs) - 1))
                    <div class="breadcrumb-item d-inline-block">
                        <a href="{{ $crumb['url'] }}" title="{{ $crumb['label'] }}">
                            {!! BaseHelper::clean($crumb['label']) !!}
                        </a>
                    </div>
                    <span></span>
                @else
                    <div class="breadcrumb-item d-inline-block active">
                        <span>
                            {!! BaseHelper::clean($crumb['label']) !!}
                        </span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
