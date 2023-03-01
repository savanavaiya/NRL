@if (isset($daterange) || isset($rescheckvehinum) || isset($reschecktypevehi) || isset($rescheckomc))

    <div class="row mt-4">
        <div class="col-md-2 text-center">
            <h5>APPLIED FILTERS :-</h5>
        </div>
        <div class="col-md-10">
            <span>DATE RANGE : </span>
            @if (isset($daterange))
                {{ $daterange }}
            @endif
            <span>||</span>
            <span>VEHICLE NUMBER : </span>
            @if (isset($rescheckvehinum))
                @foreach ($rescheckvehinum as $val)
                    <span class="pr-1">{{ $val }}</span>
                @endforeach
            @endif
            <span>||</span>
            <span>TYPE OF VEHICLE : </span>
            @if (isset($reschecktypevehi))
                @foreach ($reschecktypevehi as $val1)
                    <span class="pr-1">{{ $val1 }}</span>
                @endforeach
            @endif
            <span>||</span>
            <span>OMC : </span>
            @if (isset($rescheckomc))
                @foreach ($rescheckomc as $val2)
                    <span class="pr-1">{{ $val2 }}</span>
                @endforeach
            @endif
        </div>
    </div>

@endif


@if (isset($response_data2))
    <div class="section-card">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table tablemain">
                        <thead>
                            <tr>
                                <th>S.NO.</th>
                                <th>
                                    <div class="dropdown">
                                        <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                            <span>VEHICLE NO.</span> <i class="isax isax-arrow-down-1"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <h6><span onclick="Ascvehicleno()" class="ml-5"
                                                    style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-az.png') }}" height="30px"
                                                        width="30px">A to
                                                    Z</span></h6>
                                            <h6><span onclick="Descvehicleno()" class="ml-5"
                                                    style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-za.png') }}" height="30px"
                                                        width="30px">Z to
                                                    A</span></h6>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="dropdown">
                                        <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                            <span>OMC</span> <i class="isax isax-arrow-down-1"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <h6><span onclick="Ascomc()" class="ml-5" style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-az.png') }}" height="30px"
                                                        width="30px">A to
                                                    Z</span></h6>
                                            <h6><span onclick="Descomc()" class="ml-5" style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-za.png') }}" height="30px"
                                                        width="30px">Z to
                                                    A</span></h6>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="dropdown">
                                        <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                            <span>TYPE OF VEHICLE</span> <i class="isax isax-arrow-down-1"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <h6><span onclick="Asctypeofvehicle()" class="ml-5"
                                                    style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-az.png') }}" height="30px"
                                                        width="30px">A to
                                                    Z</span></h6>
                                            <h6><span onclick="Desctypeofvehicle()" class="ml-5"
                                                    style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-za.png') }}" height="30px"
                                                        width="30px">Z to
                                                    A</span></h6>
                                        </div>
                                    </div>
                                </th>
                                <th>TOTAL AUDITS</th>
                                <th>ACCEPTED</th>
                                <th>REJECTED</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($response_data2 as $res_data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $res_data['VehicleNumber'] }}</td>
                                    <td>{{ $res_data['TtransporterName'] }}</td>
                                    <td>{{ $res_data['AuditType'] }}</td>
                                    <td>{{ $res->where('VehicleNumber', '=', $res_data['VehicleNumber'])->count() }}
                                    </td>
                                    <td>{{ $res->where('VehicleNumber', '=', $res_data['VehicleNumber'])->where('ManualApproved', '=', '1')->count() }}
                                    </td>
                                    <td>{{ $res->where('VehicleNumber', '=', $res_data['VehicleNumber'])->where('ManualApproved', '=', '0')->count() }}
                                    </td>
                                    <td class="actionstd"><a data-toggle="modal"
                                            data-target="#viewDetails{{ $res_data['Id'] }}"><span>View</span><i
                                                class="isax isax-eye"></i></a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- View Details Popup  -->
    @foreach ($response_data2 as $res_data)
        <div class="modal fade viewdetailspopup" id="viewDetails{{ $res_data['Id'] }}">
            <div class="modal-dialog modal-custom modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="section-card">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered tablemain auditable">
                                            <thead>
                                                <tr>
                                                    <th>DATE</th>
                                                    <th>START & END TIME <br /> DURATION</th>
                                                    <th>AUDIT ID</th>
                                                    <th>VEHICLE TYPE</th>
                                                    <th>REGN. NO.</th>
                                                    <th>AUDITOR</th>
                                                    <th>AUDIT SUMM.</th>
                                                    <th>ACCEP. NO.</th>
                                                    <th class="p-0">
                                                        <div class="mb-2 mt-2">REJECTED NO.</div>
                                                        <table class="table table-inner headertable">
                                                            <thead>
                                                                <tr>
                                                                    <th>CRITICAL</th>
                                                                    <th>NON-CRITICAL</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </th>
                                                    <th>OMC</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $r_data = $res->where('VehicleNumber', '=', $res_data['VehicleNumber']);
                                                @endphp
                                                @foreach ($r_data as $val)
                                                    <tr>
                                                        <td>{{ date('d-m-Y', strtotime($val['AuditStartDate'])) }}</td>
                                                        <td>{{ date('h:i A', strtotime($val['AuditStartDate'])) }} -
                                                            {{ date('h:i A', strtotime($val['AuditEndDate'])) }} <small
                                                                class="text-muted">{{ date('G:i', strtotime($val['AuditEndDate']) - strtotime($val['AuditStartDate'])) }}</small>
                                                        </td>
                                                        <td>{{ $val['Id'] }}</td>
                                                        <td>
                                                            {{ $val['AuditType'] }}
                                                        </td>
                                                        <td>{{ $val['VehicleNumber'] }}</td>
                                                        <td>{{ $val['OperatorName'] }}</td>
                                                        <td>{{ $val['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}
                                                        </td>
                                                        <td>{{ $val['OkCount'] }}</td>
                                                        <td class="p-0">
                                                            <table class="table table-inner">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="label-light-danger">
                                                                            {{ $val['NotOkIsCriticalCount'] }}</td>
                                                                        <td class="label-light-warning">
                                                                            {{ $val['NotOkCount'] - $val['NotOkIsCriticalCount'] }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>{{ $val['TtransporterName'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End View Details Popup  -->
@elseif ($response_data)
    <div class="section-card">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table tablemain">
                        <thead>
                            <tr>
                                <th>S.NO.</th>
                                <th>
                                    <div class="dropdown">
                                        <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                            <span>VEHICLE NO.</span> <i class="isax isax-arrow-down-1"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <h6><span onclick="Ascvehicleno()" class="ml-5"
                                                    style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-az.png') }}" height="30px"
                                                        width="30px">A to
                                                    Z</span></h6>
                                            <h6><span onclick="Descvehicleno()" class="ml-5"
                                                    style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-za.png') }}" height="30px"
                                                        width="30px">Z to
                                                    A</span></h6>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="dropdown">
                                        <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                            <span>OMC</span> <i class="isax isax-arrow-down-1"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <h6><span onclick="Ascomc()" class="ml-5" style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-az.png') }}" height="30px"
                                                        width="30px">A to
                                                    Z</span></h6>
                                            <h6><span onclick="Descomc()" class="ml-5" style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-za.png') }}" height="30px"
                                                        width="30px">Z to
                                                    A</span></h6>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="dropdown">
                                        <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                            <span>TYPE OF VEHICLE</span> <i class="isax isax-arrow-down-1"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <h6><span onclick="Asctypeofvehicle()" class="ml-5"
                                                    style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-az.png') }}" height="30px"
                                                        width="30px">A to
                                                    Z</span></h6>
                                            <h6><span onclick="Desctypeofvehicle()" class="ml-5"
                                                    style="cursor: pointer"><img
                                                        src="{{ asset('assets/images/sort-za.png') }}" height="30px"
                                                        width="30px">Z to
                                                    A</span></h6>
                                        </div>
                                    </div>
                                </th>
                                <th>TOTAL AUDITS</th>
                                <th>ACCEPTED</th>
                                <th>REJECTED</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($response_data as $res_data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $res_data['VehicleNumber'] }}</td>
                                    <td>{{ $res_data['TtransporterName'] }}</td>
                                    <td>{{ $res_data['AuditType'] }}</td>
                                    <td>{{ $res->where('VehicleNumber', '=', $res_data['VehicleNumber'])->count() }}
                                    </td>
                                    <td>{{ $res->where('VehicleNumber', '=', $res_data['VehicleNumber'])->where('ManualApproved', '=', '1')->count() }}
                                    </td>
                                    <td>{{ $res->where('VehicleNumber', '=', $res_data['VehicleNumber'])->where('ManualApproved', '=', '0')->count() }}
                                    </td>
                                    <td class="actionstd"><a data-toggle="modal"
                                            data-target="#viewDetails{{ $res_data['Id'] }}"><span>View</span><i
                                                class="isax isax-eye"></i></a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- View Details Popup  -->
    @foreach ($response_data as $res_data)
        <div class="modal fade viewdetailspopup" id="viewDetails{{ $res_data['Id'] }}">
            <div class="modal-dialog modal-custom modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="section-card">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered tablemain auditable">
                                            <thead>
                                                <tr>
                                                    <th>DATE</th>
                                                    <th>START & END TIME <br /> DURATION</th>
                                                    <th>AUDIT ID</th>
                                                    <th>VEHICLE TYPE</th>
                                                    <th>REGN. NO.</th>
                                                    <th>AUDITOR</th>
                                                    <th>AUDIT SUMM.</th>
                                                    <th>ACCEP. NO.</th>
                                                    <th class="p-0">
                                                        <div class="mb-2 mt-2">REJECTED NO.</div>
                                                        <table class="table table-inner headertable">
                                                            <thead>
                                                                <tr>
                                                                    <th>CRITICAL</th>
                                                                    <th>NON-CRITICAL</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </th>
                                                    <th>OMC</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $r_data = $res->where('VehicleNumber', '=', $res_data['VehicleNumber']);
                                                @endphp
                                                @foreach ($r_data as $val)
                                                    <tr>
                                                        <td>{{ date('d-m-Y', strtotime($val['AuditStartDate'])) }}</td>
                                                        <td>{{ date('h:i A', strtotime($val['AuditStartDate'])) }} -
                                                            {{ date('h:i A', strtotime($val['AuditEndDate'])) }} <small
                                                                class="text-muted">{{ date('G:i', strtotime($val['AuditEndDate']) - strtotime($val['AuditStartDate'])) }}</small>
                                                        </td>
                                                        <td>{{ $val['Id'] }}</td>
                                                        <td>
                                                            {{ $val['AuditType'] }}
                                                        </td>
                                                        <td>{{ $val['VehicleNumber'] }}</td>
                                                        <td>{{ $val['OperatorName'] }}</td>
                                                        <td>{{ $val['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}
                                                        </td>
                                                        <td>{{ $val['OkCount'] }}</td>
                                                        <td class="p-0">
                                                            <table class="table table-inner">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="label-light-danger">
                                                                            {{ $val['NotOkIsCriticalCount'] }}</td>
                                                                        <td class="label-light-warning">
                                                                            {{ $val['NotOkCount'] - $val['NotOkIsCriticalCount'] }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td>{{ $val['TtransporterName'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- End View Details Popup  -->
@endif
