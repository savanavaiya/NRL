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
                            <h3 class="m-b-0 m-t-0">Monthly Billing</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted" href="javascript:void(0)">Reports</a></li>
                                <li class="breadcrumb-item active text-muted">Monthly Billing</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <form action="{{ route('monthbillfiltrsub') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            @if (isset($startdate) && isset($enddate))
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
                                {{-- <a href="{{ route('monthlybillingex') }}" class="btn btn-primary waves-effect">Export</a> --}}
                                <span data-toggle="modal" data-target="#exportpopup" class="btn btn-primary waves-effect">Export</span>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->
            @if (session()->has('ERROR'))
                <div class="alert alert-danger">{{ session()->get('ERROR') }}</div>
            @endif

            <!-- Start Page Content -->
            @if (isset($response_data))
                <div class="section-card p-3">
                    <div class="row m-0">
                        <div class="col-12">
                            <div class="row">
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-primary dashcard">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-info"><i
                                                        class="isax isax-truck-tick"></i></div>
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
                                                        class="isax isax-tick-circle"></i></div>
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
                                                        class="isax isax-close-circle"></i></div>
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
                                            <th>S.No.</th>
                                            <th>Date</th>
                                            <th>Total No.of TTs</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Accepted</th>
                                            <th>Rejected</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response_data as $key => $res_data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $key }}</td>
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
                            <div class="row">
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-primary dashcard">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-info"><i
                                                        class="isax isax-truck-tick"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ session()->get('TOTCHEMO') }}</h2>
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
                                                        class="isax isax-tick-circle"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ session()->get('APPRMO') }}</h2>
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
                                                        class="isax isax-close-circle"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ session()->get('REJEMO') }}</h2>
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
                                            <th>S.No.</th>
                                            <th>Date</th>
                                            <th>Total No.of TTs</th>
                                            {{-- <th>Status</th> --}}
                                            <th>Accepted</th>
                                            <th>Rejected</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response_data2 as $key => $res_data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $key }}</td>
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
                                        <a href="{{ route('monthlybillingexxls') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="infcard align-items-start">
                                    <div class="cardicon"><i class="isax isax-export"></i></div>
                                    <div class="infodetails">
                                        <small class="text-muted">.csv</small>
                                        <h5>Export to CSV</h5>
                                        <a href="{{ route('monthlybillingex') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="infcard align-items-start">
                                    <div class="cardicon"><i class="isax isax-export"></i></div>
                                    <div class="infodetails">
                                        <small class="text-muted">.pdf</small>
                                        <h5>Export to Pdf</h5>
                                        <a href="{{ route('monthlybillingexpdf') }}" class="btn btn-primary waves-effect mt-2">Export</a>
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
                                        <form action="{{ route('monthlybillingmailsub') }}" method="POST">
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
