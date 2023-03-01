<h5 style="text-align:center;margin-top:0px;">{{ $daterange }}</h5>
<table border="1">
    <thead>
        <tr>
            <th>S.NO.</th>
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
                <td>{{ $res_data['VehicleNumber'] }}</td>
                <td>{{ $res_data['AuditType'] }}</td>
                <td>
                    @foreach ($res_data['RejectedQuestions'] as $val)
                        <p style="font-size:12px;pading:0px;margin:0px;">{{ $val['Question'] }} - {{ $val['Answer'] }} {{ ($val['IsCritical'] == true) ? '*' : '' }}</p>
                    @endforeach
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
<script type="text/php">
    if (isset($pdf)) {
        $x = 380;
        $y = 560;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 14;
        $color = array(255,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>