<table>
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Date</th>
            <th>Total No.of TTs</th>
            <th>Accepted</th>
            <th>Rejected</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($response_data as $key => $res_data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ date('d m Y', strtotime($key)) }}</td>
                <td>{{ count($res_data) }}</td>
                @php
                    $acc = count($res_data->where('ManualApproved','=','1') );
                    $rej = count($res_data->where('ManualApproved','=','0') );
                @endphp
                <td>{{ $acc }}</td>
                <td>{{ $rej }}</td>
            </tr>
        @endforeach
    </tbody>
</table>