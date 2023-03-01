<table>
    <thead>
        <tr>
            <th>S. No.</th>
            <th>AUDITOR</th>
            <th>DATE</th>
            <th>AUDIT ID</th>
            <th>TYPE OF VEHICLE</th>
            <th>REGISTRATION NO.</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($response_data as $res_data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $res_data['OperatorName'] }}</td>
                <td>{{ date('d m Y', strtotime($res_data['AuditStartDate'])) }}</td>
                <td>{{ $res_data['Id'] }}</td>
                <td>{{ $res_data['AuditType'] }}</td>
                <td>{{ $res_data['VehicleNumber'] }}</td>
                <td>{{ $res_data['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>