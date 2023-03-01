@extends('common.com')

@section('content')
    <!-- Page wrapper  -->

    <div class="page-wrapper">
        <!-- Container fluid  -->
        <div class="container-fluid">

            <!-- Bread crumb and right sidebar toggle -->
            <div class="row page-titles">
                <div class="col-md-2 col-8 align-self-center">
                    <div class="d-flex align-items-center">
                        <div class="mr-2 icon-main">
                            <i class="isax isax-home"></i>
                        </div>
                        <div>
                            <h3 class="m-b-0 m-t-0">Anomaly Reports</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted" href="javascript:void(0)">Reports</a></li>
                                <li class="breadcrumb-item active text-muted">Anomaly</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <form action="{{ route('anomalyreportfiltsub') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            @if (isset($response_data))
                                <div class="date-range mr-1">
                                    <span class="nowrap">Date Range</span>
                                    <input type="text" name="daterange" value="{{ date('m/d/Y',strtotime($startdate)) }} - {{ date('m/d/Y',strtotime($enddate)) }}" />
                                    <input type="hidden" name="startdate" id="startdate" value="{{date('m/d/Y H:i:s',strtotime($startdate)) }}">
                                    <input type="hidden" name="enddate" id="enddate" value="{{ date('m/d/Y H:i:s',strtotime($enddate)) }}">
                                    <i class="isax isax-calendar"></i>
                                </div>
                            @else
                                <div class="date-range mr-1">
                                    <span class="nowrap">Date Range</span>
                                    <input type="text" name="daterange" value="{{ date('m/01/Y',strtotime("-1 days")) }} - {{ date('m/d/Y') }}" />
                                    <input type="hidden" name="startdate" id="startdate" value="{{ date('m/01/Y 00:00:00',strtotime("-1 days")) }}">
                                    <input type="hidden" name="enddate" id="enddate" value="{{ date('m/d/Y 23:59:59') }}">
                                    <i class="isax isax-calendar"></i>
                                </div>
                            @endif
                            <div class="selectlist mr-1">
                                <div class="dropdown">
                                    <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                        <span>OMC : Select from list</span> <i class="isax isax-arrow-down-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="form-group mb-2 mt-2 d-flex justify-content-between">
                                            <span>Filter by OMC</span>
                                            <span class="text-primary" style="cursor: pointer" id="clearallomc">Clear all</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="search" class="form-control" placeholder="Search" id="searchbox" />
                                        </div>
                                        <div class="form-group checklistss">
                                            
                                            <div class="display-data">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="selectlist mr-1">
                                <div class="dropdown">
                                    <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                        <span>Type of Vehicle : Select from list</span> <i
                                            class="isax isax-arrow-down-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="form-group mb-2 mt-2 d-flex justify-content-between">
                                            <span>Filter by Type of Vehicle</span>
                                            <span class="text-primary" style="cursor: pointer" id="clearalltypeofvehi">Clear all</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="search" class="form-control" placeholder="Search" id="searchboxtypevehi" />
                                        </div>
                                        <div class="form-group checklistss">
                                            
                                            <div class="display-data3">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mr-1">
                                <button class="btn btn-primary waves-effect" type="submit" id="applyfilt">Apply Filters</button>
                            </div>
                            <div>
                                @if (isset($response_data))
                                    {{-- <a href="{{ route('anomalyexport') }}" class="btn btn-primary waves-effect">Export</a> --}}
                                    <span data-toggle="modal" data-target="#exportpopup" class="btn btn-primary waves-effect">Export</span>
                                @else
                                
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->

            <!-- Start Page Content -->
            @if (isset($response_data))
                <div class="row">
                    <div class="col-md-2 text-center">
                        <h5>APPLIED FILTERS :-</h5>
                    </div>
                    <div class="col-md-10">
                        <span>DATE RANGE : </span>
                        @if (isset($DATERANGE))
                            {{ $DATERANGE }}
                        @endif
                        <span>||</span>
                        <span>OMC : </span>
                        @if (isset($rescheckomc))
                            @foreach ($rescheckomc as $val)
                                <span class="pr-1">{{ $val }}</span>
                            @endforeach
                        @endif
                        <span>||</span>
                        <span>TYPE OF VEHICLE : </span>
                        @if (isset($reschecktypevehi))
                            @foreach ($reschecktypevehi as $val2)
                                <span class="pr-1">{{ $val2 }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="section-card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered tablemain auditable">
                                    <thead>
                                        <tr>
                                            <th>S.NO.</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th>VEHICLE REGN. NO.</th>
                                            <th>OMC</th>
                                            <th>TYPE OF VEHICLE</th>
                                            <th>ANOMALIES OBSERVED</th>
                                            <th>CRITICAL</th>
                                            <th>NON-CRITICAL</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response_data as $res_data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ date('d-m-Y', strtotime($res_data['AuditStartDate'])) }}</td>
                                                <td>{{ date('h:i A', strtotime($res_data['AuditStartDate'])) }} - {{ date('h:i A', strtotime($res_data['AuditEndDate'])) }}</td>
                                                <td>{{ $res_data['VehicleNumber'] }}</td>
                                                <td>{{ $res_data['TtransporterName'] }}</td>
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
                                                <th class="actionstd"><a data-toggle="modal" data-target="#viewDetails{{ $res_data['Id'] }}"><span>View</span><i class="isax isax-eye"></i></a></th>
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
                                                                <th>START & END TIME <br/> DURATION</th>
                                                                <th>AUDIT ID</th>
                                                                <th>VEHICLE TYPE</th>
                                                                <th>REGN. NO.</th>
                                                                <th>AUDITOR</th>
                                                                <th>AUDIT SUMM.</th>
                                                                <th>ANOMALIES OBSERVED</th>
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
                                                            <tr>
                                                                <td>{{  date('d-m-Y', strtotime($res_data['AuditStartDate'])) }}</td>
                                                                <td>{{  date('h:i A', strtotime($res_data['AuditStartDate'])) }} - {{ date('h:i A', strtotime($res_data['AuditEndDate'])) }} <small class="text-muted">{{ date('G:i', strtotime($res_data['AuditEndDate']) - strtotime($res_data['AuditStartDate'])) }}</small></td>
                                                                <td>{{ $res_data['Id'] }}</td>
                                                                <td>
                                                                    {{ $res_data['AuditType'] }}
                                                                </td>
                                                                <td>{{ $res_data['VehicleNumber'] }}</td>
                                                                <td>{{ $res_data['OperatorName'] }}</td>
                                                                <td>{{ $res_data['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}</td>
                                                                <td>
                                                                    @foreach ($res_data['RejectedQuestions'] as $val)
                                                                        <p>{{ $val['Question'] }} - {{ $val['Answer'] }} {{ ($val['IsCritical'] == true) ? '*' : '' }}</p>
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    @foreach ($response_datamain as $res_datamain)
                                                                        @if ($res_data['Id'] == $res_datamain['Id'])
                                                                            {{ $res_datamain['OkCount'] }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td class="p-0">
                                                                    <table class="table table-inner">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="label-light-danger">
                                                                                    @foreach ($response_datamain as $res_datamain)
                                                                                        @if ($res_data['Id'] == $res_datamain['Id'])
                                                                                            {{ $res_datamain['NotOkIsCriticalCount'] }}
                                                                                        @endif
                                                                                    @endforeach
                                                                                </td>
                                                                                <td class="label-light-warning">
                                                                                    @foreach ($response_datamain as $res_datamain)
                                                                                        @if ($res_data['Id'] == $res_datamain['Id'])
                                                                                            {{ $res_datamain['NotOkCount'] - $res_datamain['NotOkIsCriticalCount'] }}
                                                                                        @endif
                                                                                    @endforeach
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                                <td>{{ $res_data['TtransporterName'] }}</td>
                                                            </tr>
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

            @else

                @if (session()->has('ERROR'))
                    <div class="alert alert-danger">{{ session()->get('ERROR') }}</div>
                @endif

                <div class="search-omc text-center">
                    <div>
                        <img src="{{ asset('assets/images/search-data.png') }}" alt="search" />
                        <h3>Select date & OMC to see data</h3>
                        <p>Please Select A Filters From Top</p>
                    </div>
                </div>

            @endif


            <!-- End Page Content -->

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
                                                <a href="{{ route('anomalyexportxls') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="infcard align-items-start">
                                            <div class="cardicon"><i class="isax isax-export"></i></div>
                                            <div class="infodetails">
                                                <small class="text-muted">.csv</small>
                                                <h5>Export to CSV</h5>
                                                <a href="{{ route('anomalyexport') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="infcard align-items-start">
                                            <div class="cardicon"><i class="isax isax-export"></i></div>
                                            <div class="infodetails">
                                                <small class="text-muted">.pdf</small>
                                                <h5>Export to Pdf</h5>
                                                <a href="{{ route('anomalyexportpdf') }}" class="btn btn-primary waves-effect mt-2">Export</a>
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
                                                <form action="{{ route('anomalymailsub') }}" method="POST">
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
        </div>

    </div>

    <!-- End Page wrapper  -->

    </div>

    <!-- End Wrapper -->
@endsection

@section('js')
    <script>
        var search = '';
        $(document).ready(function(){
            load_data();
        })

        function load_data() {
            $.ajax({
                url: "{{ route('filteromc') }}",
                method: 'GET',
                data: {
                    search : search,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // alert();
                    $('.display-data').html(data.data);
                }
            })
        }       

        //Search
        $(document).on('keyup', '#searchbox', function() {  
            search = $(this).val();
            load_data();
        });
    </script>

    <script>
        var search3 = '';
        $(document).ready(function(){
            load_data3();
        })

        function load_data3() {
            $.ajax({
                url: "{{ route('filtertypevehi') }}",
                method: 'GET',
                data: {
                    search3 : search3,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // alert();
                    $('.display-data3').html(data.data3);
                }
            })
        }       

        //Search
        $(document).on('keyup', '#searchboxtypevehi', function() {
            search3 = $(this).val();
            load_data3();
        });
    </script>
@endsection