<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $current->getName() }} | Anbu2</title>
    <link rel="stylesheet" href="{{ asset('/purple/default.css') }}"/>
</head>
<body>
<header>
    <img src="{{ url('/purple/img/laravel.svg') }}" alt="Laravel" class="logo">
    <?php $date = new Carbon\Carbon('2016-06-01'); ?>
    <span class="request">
        <span class="request-method"><span class="method">GET</span></span><span class="request-uri"><span
                    class="uri">{{ $uri }}</span></span><span class="request-status"><span
                    class="status">200</span></span>
    </span>
</header>
<div class="middle">
    <div class="extension">
        <div class="time"><i class="fa fa-clock-o"></i><span>{{ $date->format('d/m/y H:i:s') }}</span></div>
        <div class="memory"><i class="fa fa-database"></i><span>1.23M</span></div>
        <div class="date"><i class="fa fa-calendar-o"></i><span>7th May 2016 10:25:40</span></div>
        <div class="env"><i class="fa fa-bullseye"></i><span>local (Laravel: {{ $version }} - PHP: 7.0.3)</span></div>
    </div>
</div>
<nav>
    <ul>
        @foreach($menus as $item)
        <li>
            <a href="{{ $item['url'] }}" @if(array_get($item, 'name') == $current->getName())class="active"@endif>
                <span class="label">
                    {{ array_get($item, 'name') }}
                </span>
                <i class="fa fa-{{ array_get($item, 'icon') }}"></i>
                @if (array_get($item, 'badge') > 0)
                <span class="badge">{{ array_get($item, 'badge') }}</span>
                @endif
            </a>
        </li>
        @endforeach
    </ul>
</nav>
<div class="container">
    <div class="content">{!! $child !!}</div>
</div>
</body>
</html>
