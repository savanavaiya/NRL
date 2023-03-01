<table>
    <thead>
        <tr>
            <th>S. No.</th>
            <th>OMC</th>
            <th>Vehicle type</th>
            <th>Total</th>
            <th>Approved</th>
            <th>REJECTED</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($response_data as $key => $res_data)
            @foreach($res_data as $keyy => $r_data)
                <tr>
                    <td>{{ $s++ }}</td>
                    @php 
                        $tname = $r_data->unique('TtransporterName');
                    @endphp
                    @foreach ($tname as $ke => $tn)
                        <td>{{ $tn['TtransporterName'] }}</td>
                    @endforeach
                    <td>{{ $keyy }}</td>
                    <td>{{ count($r_data) }}</td>
                    @php
                        $acc = count($r_data->where('ManualApproved','=','1') );
                        $rej = count($r_data->where('ManualApproved','=','0') );
                    @endphp
                    <td>{{ $acc }}</td>
                    <td>{{ $rej }}</td>
                </tr>
            @endforeach        
        @endforeach
    </tbody>
</table>