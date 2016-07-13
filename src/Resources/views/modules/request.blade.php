<h1>Request&Response Information</h1>

<main>
    <input type="radio" name="tabs" id="requestData" checked>
    <label for="requestData">Request Data</label>

    <input type="radio" name="tabs" id="requestHeader" >
    <label for="requestHeader">Request Header</label>

    <input type="radio" name="tabs" id="responseHeader" >
    <label for="responseHeader">Response Header</label>

    <input type="radio" name="tabs" id="serverInfo" >
    <label for="serverInfo">Server Information</label>

    <section id="requestDataContent">
        @if (isset($request['data']) && count($request['data']))
            <table class="anbu-table">
                <thead>
                <tr>
                    <th class="key">Key</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach($request['data'] as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="empty"><i class="fa fa-exclamation-triangle"></i>No data has been provided with this request.</div>
        @endif
    </section>
    <section id="requestHeaderContent">
        @if (isset($request['headers']) && count($request['headers']))
            <table class="anbu-table">
                <thead>
                <tr>
                    <th class="key">Name</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach($request['headers'] as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td class="code">{{ str_limit($value[0]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">No headers are attached to this request.</div>
        @endif
    </section>
    <section id="responseHeaderContent">
        @if (isset($request['response']) && count($request['response']))
            <table class="anbu-table">
                <thead>
                <tr>
                    <th class="key">Name</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach($request['response'] as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td class="code">{{ str_limit($value[0]) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">No headers are attached to this request.</div>
        @endif
    </section>
    <section id="serverInfoContent">
        @if (isset($request['server']) && count($request['server']))
            <table class="anbu-table">
                <thead>
                <tr>
                    <th class="key">Key</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach($request['server'] as $key => $value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td class="code">{{ str_limit($value) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">No server variables are present within this request.</div>
        @endif
    </section>
</main>

