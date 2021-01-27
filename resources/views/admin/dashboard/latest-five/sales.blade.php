<table class="table table-bordered table-striped">
    <caption class="hidden"><h3>{{ $pageTitle }} List</h3></caption>
    <thead>
    <tr>
        <th>SL.</th>
        <th>Sale Code</th>
        <th>Sale Date</th>
        <th>Net Total</th>
        <th>Net Discount</th>
        <th>Payment Status</th>
        <th>Due Date</th>
        <th>Issue Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($latestFive['sales'] as $key => $record)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td><a href="{{ route('admin.sales.show', $record->id) }}">{{$record->sale_code}}</a></td>
            <td>{{formatDate($record->date)}}</td>
            <td>{{$record->net_total}}</td>
            <td>{{$record->net_discount}}</td>
            <td>{{$record->payment_status}}</td>
            <td>{{formatDate($record->due_date)}}</td>
            <td>{{formatDateTime($record->created_at)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
