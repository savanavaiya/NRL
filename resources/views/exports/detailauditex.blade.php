<table>
    <thead>
        <tr>
            <th>S.NO.</th>
            <th>DATE</th>
            <th>START TIME</th>
            <th>END TIME</th>
            <th>AUDIT ID</th>
            <th>VEHICLE TYPE</th>
            <th>REGN. NO.</th>
            <th>AUDITOR</th>
            <th>AUDIT SUMM.</th>
            <th>ACCEP. NO.</th>
            <th>CRITICAL(REJ. NO.)</th>
            <th>NON-CRITICAL(REJ. NO.)</th>
            <th>OMC</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($response_data as $res_data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{  date('d m Y', strtotime($res_data['AuditStartDate'])) }}</td>
                <td>{{ $res_data['AuditStartDate'] }}</td>
                <td>{{ $res_data['AuditEndDate'] }}</td>
                <td>{{ $res_data['Id'] }}</td>
                <td>
                    {{ $res_data['AuditType'] }}
                </td>
                <td>{{ $res_data['VehicleNumber'] }}</td>
                <td>{{ $res_data['OperatorName'] }}</td>
                <td>{{ $res_data['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}</td>
                <td>{{ $res_data['OkCount'] }}</td>
                <td class="label-light-danger">{{ $res_data['NotOkIsCriticalCount'] }}</td>
                <td class="label-light-warning">{{ $res_data['NotOkCount'] - $res_data['NotOkIsCriticalCount'] }}</td>
                <td>{{ $res_data['TtransporterName'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>