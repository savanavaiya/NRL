<table>
    <thead>
        <tr>
            <th>S.NO.</th>
            <th>VEHICLE NO.</th>
            <th>OMC</th>
            <th>TYPE OF VEHICLE</th>
            <th>TOTAL AUDITS</th>
            <th>ACCEPTED</th>
            <th>REJECTED</th>
        </tr>
    </thead>
    <tbody>
       
        @foreach ($response_data as $res_data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $res_data['VehicleNumber'] }}</td>
                <td>{{ $res_data['TtransporterName'] }}</td>
                <td>{{ $res_data['AuditType'] }}</td>
                <td>{{ $res->where('VehicleNumber','=',$res_data['VehicleNumber'])->count() }}</td>
                <td>{{ $res->where('VehicleNumber','=',$res_data['VehicleNumber'])->where('ManualApproved','=','1')->count() }}</td>
                <td>{{ $res->where('VehicleNumber','=',$res_data['VehicleNumber'])->where('ManualApproved','=','0')->count() }}</td>
            </tr>
        @endforeach

    </tbody>
</table>