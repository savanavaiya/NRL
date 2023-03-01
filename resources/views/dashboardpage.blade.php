@extends('common.com')

@section('content')
    <!-- Page wrapper  -->

    <div class="page-wrapper">
        <!-- Container fluid  -->
        <div class="container-fluid">

            <!-- Bread crumb and right sidebar toggle -->
            <div class="row page-titles">
                <div class="col-md-4 col-8 align-self-center">
                    <div class="d-flex align-items-center">
                        <div class="mr-2 icon-main">
                            <i class="isax isax-home"></i>
                        </div>
                        <div>
                            <h3 class="m-b-0 m-t-0">Dashboard</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted" href="javascript:void(0)">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active text-muted">Overview</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <form action="{{ route('dashfiltsub') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            @if (isset($response_data2))
                                <div class="date-range mr-3">
                                    <span class="nowrap">Date Range</span>
                                    <input type="text" name="daterange" value="{{ date('m/d/Y',strtotime($startdate)) }} - {{ date('m/d/Y',strtotime($enddate)) }}" />
                                    <input type="hidden" name="startdate" id="startdate" value="{{date('m/d/Y H:i:s',strtotime($startdate)) }}">
                                    <input type="hidden" name="enddate" id="enddate" value="{{ date('m/d/Y H:i:s',strtotime($enddate)) }}">
                                    <i class="isax isax-calendar"></i>
                                </div>
                            @else
                                <div class="date-range mr-3">
                                    <span class="nowrap">Date Range</span>
                                    <input type="text" name="daterange" value="{{ date('m/01/Y',strtotime("-1 days")) }} - {{ date('m/d/Y') }}" />
                                    <input type="hidden" name="startdate" id="startdate" value="{{ date('m/01/Y 00:00:00',strtotime("-1 days")) }}">
                                    <input type="hidden" name="enddate" id="enddate" value="{{ date('m/d/Y 23:59:59') }}">
                                    <i class="isax isax-calendar"></i>
                                </div>
                            @endif
                            <div class="mr-3">
                                <button class="btn btn-primary waves-effect" type="submit" id="applyfilt">Apply Filters</button>
                            </div>
                            <div>
                                <span data-toggle="modal" data-target="#exportpopup" class="btn btn-primary waves-effect">Export</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->

            <!-- Start Page Content -->
            @if (session()->has('ERROR'))
                <div class="alert alert-danger">
                    {{ session()->get('ERROR') }}
                </div>
            @endif

            @if (isset($response_data))
                <div class="section-card p-3">
                    <div class="row m-0">
                        <div class="col-12">
                            <h5>By OMC</h5>
                            <div class="row">
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-primary dashcard">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-info"><i
                                                        class="isax isax-tick-circle"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ session()->get('TOTALCHECK') }}</h2>
                                                    <h5 class="text-right m-b-0">Total Checked</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-warning dashcard">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-warning"><i
                                                        class="isax isax-truck-tick"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ session()->get('APPROVE') }}</h2>
                                                    <h5 class="text-right m-b-0">Approved</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-danger dashcard">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-danger"><i
                                                        class="isax isax-truck-remove"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ session()->get('REJECT') }}</h2>
                                                    <h5 class="text-right m-b-0">Rejected</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table tablemain">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>OMC</th>
                                            <th>Vehicle type</th>
                                            <th>Total</th>
                                            <th>Approved</th>
                                            <th>REJECTED</th>
                                            <th>Action</th>
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
                                                    <td class="actionstd"><a data-toggle="modal" data-target="#viewDetails{{ $m++ }}"><span>View</span><i class="isax isax-eye"></i></a></td>
                                                </tr>
                                            @endforeach        
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- View Details Popup  -->
                                @foreach ($response_data as $key => $res_data)
                                    @foreach($res_data as $keyy => $r_data)
                                        <div class="modal fade viewdetailspopup" id="viewDetails{{ $c++ }}">
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
                                                                                    <th>S.NO.</th>
                                                                                    <th>DATE</th>
                                                                                    <th>START & END TIME <br/> DURATION</th>
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
                                                                                @foreach ($r_data as $val)
                                                                                    <tr>
                                                                                        <td>{{ $a++ }}</td>
                                                                                        <td>{{  date('d-m-Y', strtotime($val['AuditStartDate'])) }}</td>
                                                                                        <td>{{  date('h:i A', strtotime($val['AuditStartDate'])) }} - {{ date('h:i A', strtotime($val['AuditEndDate'])) }} <small class="text-muted">{{ date('G:i', strtotime($val['AuditEndDate']) - strtotime($val['AuditStartDate'])) }}</small></td>
                                                                                        <td>{{ $val['Id'] }}</td>
                                                                                        <td>
                                                                                            {{ $val['AuditType'] }}
                                                                                        </td>
                                                                                        <td>{{ $val['VehicleNumber'] }}</td>
                                                                                        <td>{{ $val['OperatorName'] }}</td>
                                                                                        <td>{{ $val['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}</td>
                                                                                        <td>{{ $val['OkCount'] }}</td>
                                                                                        <td class="p-0">
                                                                                            <table class="table table-inner">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class="label-light-danger">{{ $val['NotOkIsCriticalCount'] }}</td>
                                                                                                        <td class="label-light-warning">{{ $val['NotOkCount'] - $val['NotOkIsCriticalCount'] }}</td>
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
                                    
                                @endforeach
                                <!-- End View Details Popup  -->


                            </div>
                        </div>
                    </div>
                </div>
            @elseif (isset($response_data2))

                <div class="row">
                    <div class="col-md-2 text-center">
                        <h5>APPLIED FILTERS :-</h5>
                    </div>
                    <div class="col-md-10">
                        <span>DATE RANGE : </span>
                        @if (isset($daterange))
                            {{ $daterange }}
                        @endif
                    </div>
                </div>
                
                <div class="section-card p-3">
                    <div class="row m-0">
                        <div class="col-12">
                            <h5>By OMC</h5>
                            <div class="row">
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-primary dashcard">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-info"><i
                                                        class="isax isax-tick-circle"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ session()->get('TOTCHE') }}</h2>
                                                    <h5 class="text-right m-b-0">Total Checked</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-warning dashcard">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-warning"><i
                                                        class="isax isax-truck-tick"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ session()->get('APPR') }}</h2>
                                                    <h5 class="text-right m-b-0">Approved</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-danger dashcard">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-danger"><i
                                                        class="isax isax-truck-remove"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ session()->get('REJE') }}</h2>
                                                    <h5 class="text-right m-b-0">Rejected</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table tablemain">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>OMC</th>
                                            <th>Vehicle type</th>
                                            <th>Total</th>
                                            <th>Approved</th>
                                            <th>REJECTED</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response_data2 as $key => $res_data)
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
                                                    <td class="actionstd"><a data-toggle="modal" data-target="#viewDetails{{ $m++ }}"><span>View</span><i class="isax isax-eye"></i></a></td>
                                                </tr>
                                            @endforeach        
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- View Details Popup  -->
                                @foreach ($response_data2 as $key => $res_data)
                                    @foreach($res_data as $keyy => $r_data)
                                        <div class="modal fade viewdetailspopup" id="viewDetails{{ $c++ }}">
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
                                                                                    <th>S.NO.</th>
                                                                                    <th>DATE</th>
                                                                                    <th>START & END TIME <br/> DURATION</th>
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
                                                                                @foreach ($r_data as $val)
                                                                                    <tr>
                                                                                        <td>{{ $a++ }}</td>
                                                                                        <td>{{  date('d-m-Y', strtotime($val['AuditStartDate'])) }}</td>
                                                                                        <td>{{  date('h:i A', strtotime($val['AuditStartDate'])) }} - {{ date('h:i A', strtotime($val['AuditEndDate'])) }} <small class="text-muted">{{ date('G:i', strtotime($val['AuditEndDate']) - strtotime($val['AuditStartDate'])) }}</small></td>
                                                                                        <td>{{ $val['Id'] }}</td>
                                                                                        <td>
                                                                                            {{ $val['AuditType'] }}
                                                                                        </td>
                                                                                        <td>{{ $val['VehicleNumber'] }}</td>
                                                                                        <td>{{ $val['OperatorName'] }}</td>
                                                                                        <td>{{ $val['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}</td>
                                                                                        <td>{{ $val['OkCount'] }}</td>
                                                                                        <td class="p-0">
                                                                                            <table class="table table-inner">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td class="label-light-danger">{{ $val['NotOkIsCriticalCount'] }}</td>
                                                                                                        <td class="label-light-warning">{{ $val['NotOkCount'] - $val['NotOkIsCriticalCount'] }}</td>
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
                                    
                                @endforeach
                                <!-- End View Details Popup  -->


                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>


    <!-- View Details Popup  -->
    <div class="modal fade viewdetailspopup" id="exportpopup">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-header">
                <h3 class="modal-title">Export Report</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-4">
                <div class="transaction-info">
                    <ul>
                        <li>
                        <div class="row mb-5">
                            <div class="col-md-4">
                                <div class="infcard align-items-start">
                                    <div class="cardicon"><i class="isax isax-export"></i></div>
                                    <div class="infodetails">
                                        <small class="text-muted">.xls</small>
                                        <h5>Export to Excel</h5>
                                        <a href="{{ route('dashboardexportxls') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="infcard align-items-start">
                                    <div class="cardicon"><i class="isax isax-export"></i></div>
                                    <div class="infodetails">
                                        <small class="text-muted">.csv</small>
                                        <h5>Export to CSV</h5>
                                        <a href="{{ route('dashboardexport') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="infcard align-items-start">
                                    <div class="cardicon"><i class="isax isax-export"></i></div>
                                    <div class="infodetails">
                                        <small class="text-muted">.pdf</small>
                                        <h5>Export to Pdf</h5>
                                        <a href="{{ route('dashboardexportpdf') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="infcard align-items-start">
                                    <div class="cardicon"><i class="isax isax-export"></i></div>
                                    <div class="infodetails">
                                        <small class="text-muted">Mail</small>
                                        <h5>Send Mail With Attach File</h5>
                                        <form action="{{ route('dashboardmailsub') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group mb-3 col-md-6">
                                                    <input type="text" name="emailid" class="form-control" placeholder="Enter Mail ID" value="" autocomplete="off">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" name="checkbox1[]" class="checkbox" id="checkbox1" value="pdf">
                                                    <label for="checkbox1">.PDF</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" name="checkbox1[]" class="checkbox" id="checkbox2" value="csv">
                                                    <label for="checkbox2">.CSV</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" name="checkbox1[]" class="checkbox" id="checkbox3" value="xls">
                                                    <label for="checkbox3">.XLS</label>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-primary waves-effect mt-2" id="sendmail">Send Mail</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- End View Details Popup  -->


    <!-- End Page wrapper  -->

    </div>



    <!-- End Wrapper -->
@endsection