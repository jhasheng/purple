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
            <td><span class="method-tag method-tag-{{ strtolower('a') }}"></span></td>
            <td class="code"></td>
            <td class="code"></td>
        </tr>
    </tbody>
</table>

<h1>Routing Table</h1>
@if (isset($routes) && count($routes))
<table class="anbu-table">
    <thead>
        <tr>
            <th>Method</th>
            <th>Path</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach(array_reverse($routes) as $route)
        <tr>
            <td>
            @foreach ($route[0] as $method)
            <span class="method-tag method-tag-{{ strtolower($method) }}">{{ $method }}</span>
            @endforeach
            </td>
            <td class="code">{!! $route[1] !!}</td>
            <td class="code">{{ $route[2] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="empty">There are no defined routes for this request.</div>
@endif
