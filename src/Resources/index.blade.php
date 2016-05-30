<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $name }} <?php print_r($current); ?>| Anbu2</title>
    <link rel="stylesheet" href="{{ url('/anbu/default.css') }}"/>
</head>
<body>
<header>
    <img src="{{ url('/anbu/img/profiler_logo.png') }}" alt="Laravel" class="logo">
    <?php $date = new Carbon\Carbon($created_at); ?>
    <span class="request"><span class="request-time"><span
                    class="uri">{{ $uri }}</span> - {{ $date->format('d/m/y H:i:s') }} - <span class="duration">
                ms</span></span><a href="{{ url('/anbu') }}" class="request-reset" title="Back to latest."><i
                    class="fa fa-reply"></i></a></span>
    <span class="version">Laravel {{ $version }}</span>
</header>
<nav>
    <ul>
        @foreach($menu as $item)
            <li>
                <a href="{{ array_get($item, 'url') }}" @if(array_get($item, 'title') == $name)class="active"@endif>
                    @if(array_get($item, 'title') != $name)
                    <span class="label">
                        {{ array_get($item, 'title') }} <i class="arrow"></i>
                    </span>
                    @endif
                    <i class="fa fa-{{ array_get($item, 'icon') }}"></i>
                    @if (array_get($item, 'badge') > 0)
                    <span class="badge">
                        <i class="badge-inner">{{ array_get($item, 'badge') > 9 ? '+' : array_get($item, 'badge')  }}</i>
                    </span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</nav>
<div class="container">
    <div class="content">{!! $current !!}</div>
</div>
</body>
</html>
