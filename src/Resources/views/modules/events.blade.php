<h1>Events</h1>
<?php
//        dd($events);
?>
@if (isset($events) && count($events))
<table class="anbu-table">
    <thead>
        <tr>
            <th>Type</th>
            <th>Class</th>
            <th>Fired</th>
        </tr>
    </thead>
    <tbody>
        @foreach($events as $event)
        <tr>
            <td class="code">{{ $event['name'] }}</td>
            <td class="code">{{ $event['class'] }}</td>
            <td>{{ number_format($event['time'], 3) }}ms</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="empty">No events were fired during this request.</div>
@endif
