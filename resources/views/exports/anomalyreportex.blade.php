<table>
    <thead>
        <tr>
            <th>S.NO.</th>
            <th>DATE</th>
            <th>TIME</th>
            <th>VEHICLE REGN. NO.</th>
            <th>TYPE OF VEHICLE</th>
            <th>ANOMALIES OBSERVED</th>
            <th>CRITICAL</th>
            <th>NON-CRITICAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($response_data as $res_data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ date('d-m-Y', strtotime($res_data['AuditStartDate'])) }}</td>
                <td>{{ date('h:i A', strtotime($res_data['AuditStartDate'])) }} -
                    {{ date('h:i A', strtotime($res_data['AuditEndDate'])) }}</td>
                <td>{{ $res_data['VehicleNumber'] }}</td>
                <td>{{ $res_data['AuditType'] }}</td>
                <td>
                    <div class="callapsable">
                        <a class="expandpanel"><i class="isax isax-arrow-circle-down"></i></a>
                        <div class="collapsecontent">
                            @foreach ($res_data['RejectedQuestions'] as $val)
                                <p>{{ $val['Question'] }} - {{ $val['Answer'] }} {{ ($val['IsCritical'] == true) ? '*' : '' }}</p>
                            @endforeach
                        </div>
                    </div>
                </td>
                <td>
                    @foreach ($response_datamain as $res_datamain)
                        @if ($res_data['Id'] == $res_datamain['Id'])
                            {{ $res_datamain['NotOkIsCriticalCount'] }}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($response_datamain as $res_datamain)
                        @if ($res_data['Id'] == $res_datamain['Id'])
                            {{ $res_datamain['NotOkCount'] - $res_datamain['NotOkIsCriticalCount'] }}
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>