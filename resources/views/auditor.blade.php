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
                            <h3 class="m-b-0 m-t-0">Auditor Reports</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted" href="javascript:void(0)">Reports</a></li>
                                <li class="breadcrumb-item active text-muted">Auditor</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <form action="{{ route('auditorfiltsub') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            @if (isset($response_data))
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
                            <div class="selectlist mr-3">
                                <div class="dropdown">
                                    <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                        <span>Auditor: Select</span> <i class="isax isax-arrow-down-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="form-group mb-2 mt-2 d-flex justify-content-between">
                                            <span>Filter by Auditor</span>
                                            <span class="text-primary" style="cursor: pointer" id="clearallauditor">Clear all</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="search" class="form-control" placeholder="Search" id="searchboxauditor" />
                                        </div>
                                        <div class="form-group checklistss">
                                            
                                            <div class="display-data4">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mr-3">
                                <button class="btn btn-primary waves-effect" type="submit" id="applyfilt">Apply Filters</button>
                            </div>
                            <div>
                                @if (isset($response_data))
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
                        @if (isset($daterange))
                            {{ $daterange }}
                        @endif
                        <span>||</span>
                        <span>AUDITOR : </span>
                        @if (isset($rescheckauditor))
                            @foreach ($rescheckauditor as $val)
                                <span class="pr-1">{{ $val }}</span>
                            @endforeach
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
                                                        class="isax isax-tick-circle"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ count($response_data) }}</h2>
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
                                                    <h2 class="m-b-0">{{ $response_data->where('ManualApproved','=','1')->count() }}</h2>
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
                                                    <h2 class="m-b-0">{{ $response_data->where('ManualApproved','=','0')->count() }}</h2>
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
                                                <td>{{ date('d-m-Y', strtotime($res_data['AuditStartDate'])) }}</td>
                                                <td>{{ $res_data['Id'] }}</td>
                                                <td>{{ $res_data['AuditType'] }}</td>
                                                <td>{{ $res_data['VehicleNumber'] }}</td>
                                                <td>{{ $res_data['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            @else

            @if (session()->has('ERROR'))
                <div class="alert alert-danger">{{ session()->get('ERROR') }}</div>
            @endif

                <div class="search-omc text-center">
                    <div>
                        <img src="{{ asset('assets/images/search-data.png') }}" alt="search" />
                        <h3>Select date & OMC to see data</h3>
                        <p>Please Select A Auditor From Top Dropdown</p>
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
                                                <a href="{{ route('auditorexportxls') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="infcard align-items-start">
                                            <div class="cardicon"><i class="isax isax-export"></i></div>
                                            <div class="infodetails">
                                                <small class="text-muted">.csv</small>
                                                <h5>Export to CSV</h5>
                                                <a href="{{ route('auditorexport') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="infcard align-items-start">
                                            <div class="cardicon"><i class="isax isax-export"></i></div>
                                            <div class="infodetails">
                                                <small class="text-muted">.pdf</small>
                                                <h5>Export to Pdf</h5>
                                                <a href="{{ route('auditorexportpdf') }}" class="btn btn-primary waves-effect mt-2">Export</a>
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
                                                <form action="{{ route('auditormailsub') }}" method="POST">
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
        var search4 = '';
        $(document).ready(function(){
            load_data4();
        })

        function load_data4() {
            $.ajax({
                url: "{{ route('filterauditor') }}",
                method: 'GET',
                data: {
                    search4 : search4,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // alert();
                    $('.display-data4').html(data.data4);
                }
            })
        }       

        //Search
        $(document).on('keyup', '#searchboxauditor', function() {  
            search4 = $(this).val();
            load_data4();
        });
    </script>
@endsection