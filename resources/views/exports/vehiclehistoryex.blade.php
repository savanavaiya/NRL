<table>
    <thead>
        <tr>
            <th>S.NO.</th>
            <th>DATE</th>
            <th>TIME</th>
            <th>AUDIT ID</th>
            <th>TYPE OF ENTRY</th>
            <th>AUDIT SUMM.</th>
            <th>ACCEP. NO.</th>
            <th>CRITICAL(REJECTED NO.)</th>
            <th>NON-CRITICAL(REJECTED NO.)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($response_data as $res_data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ date('d-m-Y', strtotime($res_data['AuditStartDate'])) }}</td>
                <td>{{  date('h:i A', strtotime($res_data['AuditStartDate'])) }} - {{ date('h:i A', strtotime($res_data['AuditEndDate'])) }}</td>
                <td>{{ $res_data['Id'] }}</td>
                <td></td>
                <td>{{ $res_data['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}</td>
                <td>{{ $res_data['OkCount'] }}</td>
                <td>{{ $res_data['NotOkIsCriticalCount'] }}</td>
                <td>{{ $res_data['NotOkCount'] - $res_data['NotOkIsCriticalCount'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>