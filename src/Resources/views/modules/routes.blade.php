<h1>Current Route</h1>
<table class="anbu-table">
    <thead>
        <tr>
            <th>Method</th>
            <th>Path</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span class="method-tag method-tag-{{ strtolower($current['methods'][0]) }}">{{ $current['methods'][0] }}</span></td>
            <td class="code">{{ $current['path'] }}</td>
            <td class="code">{{ $current['action'] }}</td>
        </tr>
    </tbody>
</table>

<h1>Routing Table</h1>
@if (isset($routes) && count($routes))
<div class="routes">
    <ul>
        @foreach(array_reverse($routes) as $route)
        <li>
            <div class="name">
                <span class="code">{!! $route['path'] !!}</span>
            </div>
            <div class="action">
                <span class="code">{{ $route['action'] }}</span>
                <span class="method">
                    @foreach ($route['methods'] as $method)
                        <span class="method-tag method-tag-{{ strtolower($method) }}">{{ $method }}</span>
                    @endforeach
                </span>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@else
    <div class="empty">There are no defined routes for this request.</div>
@endif


