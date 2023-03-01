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
                            <h3 class="m-b-0 m-t-0">Vehicle History</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted" href="javascript:void(0)">Reports</a></li>
                                <li class="breadcrumb-item active text-muted">Vehicle History</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <form action="{{ route('vehiclehisfilsub') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            <div class="selectlist">
                                <div class="dropdown">
                                    <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                        <span>Vehicle Number : Select from list</span> <i
                                            class="isax isax-arrow-down-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="form-group mb-2 mt-2 d-flex justify-content-between">
                                            <span>Filter by Vehicle Number</span>
                                            <span class="text-primary" style="cursor: pointer" id="clearallvehinumb">Clear all</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="search" class="form-control" placeholder="Search" id="searchboxvehinum" />
                                        </div>
                                        <div class="form-group checklistss">
                                            
                                            <div class="display-data2">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="selectlist mx-3">
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
                            <div class="mr-3">
                                <button class="btn btn-primary waves-effect" type="submit" id="applyfilt">Apply Filters</button>
                            </div>
                            <div>
                                @if (isset($response_data))
                                    {{-- <span class="btn btn-primary waves-effect">Export</span> --}}
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
                        <span>VEHICLE NUMBER : </span>
                        @if (isset($restcheckvehiclenum))
                            @foreach ($restcheckvehiclenum as $val)
                                <span class="pr-1">{{ $val }}</span>
                            @endforeach
                        @endif
                        <span>||</span>
                        <span>OMC : </span>
                        @if (isset($restcheckomc))
                            @foreach ($restcheckomc as $val2)
                                <span class="pr-1">{{ $val2 }}</span>
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
                                    <div class="card bg-light-success dashcard border border-success">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-success"><i
                                                        class="isax isax-truck-tick"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ $status }}</h2>
                                                    <h5 class="text-right m-b-0">Current Status</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-info dashcard border border-info">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-info"><i
                                                        class="isax isax-search-normal-1"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ $lastcheckedon }}</h2>
                                                    <h5 class="text-right m-b-0">Last Checked On</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card bg-light-info dashcard border border-info">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <div class="round round-lg align-self-center round-info"><i
                                                        class="isax isax-calendar-1"></i></div>
                                                <div class="ml-auto text-right align-self-end">
                                                    <h2 class="m-b-0">{{ $nextdueondate }}</h2>
                                                    <h5 class="text-right m-b-0">Next Due On</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered tablemain auditable">
                                    <thead>
                                        <tr>
                                            <th>S.NO.</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th>AUDIT ID</th>
                                            <th>TYPE OF ENTRY</th>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response_data as $res_data)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ date('d-m-Y', strtotime($res_data['AuditStartDate'])) }}</td>
                                                <td>{{  date('h:i A', strtotime($res_data['AuditStartDate'])) }} - {{ date('h:i A', strtotime($res_data['AuditEndDate'])) }}</td>
                                                <td>{{ $res_data['Id'] }}</td>
                                                <td>{{ $res_data['AuditType'] }}</td>
                                                <td>{{ $res_data['ManualApproved'] == '1' ? 'Approved' : 'Rejected' }}</td>
                                                <td>{{ $res_data['OkCount'] }}</td>
                                                <td class="p-0">
                                                    <table class="table table-inner">
                                                        <tbody>
                                                            <tr>
                                                                <td class="label-light-danger">
                                                                    {{ $res_data['NotOkIsCriticalCount'] }}</td>
                                                                <td class="label-light-warning">
                                                                    {{ $res_data['NotOkCount'] - $res_data['NotOkIsCriticalCount'] }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
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
                        <img src="{{ asset('assets/images/locationvehi.svg') }}" alt="search" />
                        <h3>Select a Vehicle to see data</h3>
                        <p>please select a vehicle from top dropdown</p>
                    </div>
                </div>
            @endif
            <!-- End Page Content -->


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
                                        <a href="{{ route('exportvehiclhistxls') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="infcard align-items-start">
                                    <div class="cardicon"><i class="isax isax-export"></i></div>
                                    <div class="infodetails">
                                        <small class="text-muted">.csv</small>
                                        <h5>Export to CSV</h5>
                                        <a href="{{ route('exportvehiclhist') }}" class="btn btn-primary waves-effect mt-2">Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="infcard align-items-start">
                                    <div class="cardicon"><i class="isax isax-export"></i></div>
                                    <div class="infodetails">
                                        <small class="text-muted">.pdf</small>
                                        <h5>Export to Pdf</h5>
                                        <a href="{{ route('exportvehiclhistpdf') }}" class="btn btn-primary waves-effect mt-2">Export</a>
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
                                        <form action="{{ route('vehiclehistmailsub') }}" method="POST">
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
        var search2 = '';
        $(document).ready(function(){
            load_data2();
        })

        function load_data2() {
            $.ajax({
                url: "{{ route('filtervehiclenum') }}",
                method: 'GET',
                data: {
                    search2 : search2,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // alert();
                    $('.display-data2').html(data.data2);
                }
            })
        }       

        //Search
        $(document).on('keyup', '#searchboxvehinum', function() {
            search2 = $(this).val();
            load_data2();
        });
    </script>
@endsection