@extends('common.com')

@section('content')
    <!-- Page wrapper  -->

    <div class="page-wrapper">
        <!-- Container fluid  -->
        <div class="container-fluid">

            <!-- Bread crumb and right sidebar toggle -->
            <div class="row page-titles mb-2">
                <div class="col-md-4 col-8 align-self-center">
                    <div class="d-flex align-items-center">
                        <div class="mr-2 icon-main">
                            <i class="isax isax-home"></i>
                        </div>
                        <div>
                            <h3 class="m-b-0 m-t-0">Vehicle Wise Summary</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted" href="javascript:void(0)">Reports</a></li>
                                <li class="breadcrumb-item active text-muted">Vehicle Wise Summary</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-12 p-0">
                    <form id="formsub">
                        @csrf
                        <div class="d-flex justify-content-end align-items-center">
                            <div class="date-range mr-1">
                                <span class="nowrap">Date Range</span>
                                <input type="text" name="daterange"
                                    value="{{ date('m/01/Y', strtotime('-1 days')) }} - {{ date('m/d/Y') }}" />
                                <input type="hidden" name="startdate" id="startdate"
                                    value="{{ date('m/01/Y 00:00:00', strtotime('-1 days')) }}">
                                <input type="hidden" name="enddate" id="enddate" value="{{ date('m/d/Y 23:59:59') }}">
                                <i class="isax isax-calendar"></i>
                            </div>
                            <div class="selectlist mr-1">
                                <div class="dropdown">
                                    <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                        <span>Vehicle Number : Select from list</span> <i
                                            class="isax isax-arrow-down-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="form-group mb-2 mt-2 d-flex justify-content-between">
                                            <span>Filter by Vehicle Number</span>
                                            <span class="text-primary" style="cursor: pointer" id="clearallvehinumb">Clear
                                                all</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="search" class="form-control" placeholder="Search"
                                                id="searchboxvehinum" />
                                        </div>
                                        <div class="form-group checklistss">

                                            <div class="display-data2">
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
                                            <span class="text-primary" style="cursor: pointer" id="clearalltypeofvehi">Clear
                                                all</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="search" class="form-control" placeholder="Search"
                                                id="searchboxtypevehi" />
                                        </div>
                                        <div class="form-group checklistss">

                                            <div class="display-data3">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="selectlist mr-1">
                                <div class="dropdown">
                                    <a type="button" class="dropdownbtn" data-toggle="dropdown">
                                        <span>OMC : Select from list</span> <i class="isax isax-arrow-down-1"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="form-group mb-2 mt-2 d-flex justify-content-between">
                                            <span>Filter by OMC</span>
                                            <span class="text-primary" style="cursor: pointer" id="clearallomc">Clear
                                                all</span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="search" class="form-control" placeholder="Search"
                                                id="searchbox" />
                                        </div>
                                        <div class="form-group checklistss">

                                            <div class="display-data">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mr-1">
                                <button class="btn btn-primary waves-effect" type="submit">Apply Filters</button>
                            </div>
                            <div>
                                <span data-toggle="modal" data-target="#exportpopup"
                                    class="btn btn-primary waves-effect">Export</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->

            <!-- Start Page Content -->
            @if (session()->has('ERROR'))
                <div class="alert alert-danger">{{ session()->get('ERROR') }}</div>
            @endif

            <div class="display-datares">

            </div>


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
                                                <a href="{{ route('vehiclewisesummexportxls') }}"
                                                    class="btn btn-primary waves-effect mt-2">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="infcard align-items-start">
                                            <div class="cardicon"><i class="isax isax-export"></i></div>
                                            <div class="infodetails">
                                                <small class="text-muted">.csv</small>
                                                <h5>Export to CSV</h5>
                                                <a href="{{ route('vehiclewisesummexport') }}"
                                                    class="btn btn-primary waves-effect mt-2">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="infcard align-items-start">
                                            <div class="cardicon"><i class="isax isax-export"></i></div>
                                            <div class="infodetails">
                                                <small class="text-muted">.pdf</small>
                                                <h5>Export to Pdf</h5>
                                                <a href="{{ route('vehiclewisesummexportpdf') }}"
                                                    class="btn btn-primary waves-effect mt-2">Export</a>
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
                                                <form action="{{ route('vehiclewisesummailsub') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group mb-3 col-md-6">
                                                            <input type="text" name="emailid" class="form-control"
                                                                placeholder="Enter Mail ID" value="" autocomplete="off">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="checkbox" name="checkbox1[]" class="checkbox"
                                                                id="checkbox1" value="pdf">
                                                            <label for="checkbox1">.PDF</label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="checkbox" name="checkbox1[]" class="checkbox"
                                                                id="checkbox2" value="csv">
                                                            <label for="checkbox2">.CSV</label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="checkbox" name="checkbox1[]" class="checkbox"
                                                                id="checkbox3" value="xls">
                                                            <label for="checkbox3">.XLS</label>
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button class="btn btn-primary waves-effect mt-2" id="sendmail">Send
                                                            Mail</button>
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
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('vehiclewisesumajax') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(datares) {
                    $('.preloader').hide();
                    console.log(datares);
                    $('.display-datares').html(datares.datares);
                }
            });
        })
        
        window.setTimeout(function () {
        $('.preloader').show();
        }, 500 );
    </script>

    <script>
        var search = '';
        $(document).ready(function() {
            load_data();
        })

        function load_data() {
            $.ajax({
                url: "{{ route('filteromc') }}",
                method: 'GET',
                data: {
                    search: search,
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
        $(document).ready(function() {
            load_data2();
        })

        function load_data2() {
            $.ajax({
                url: "{{ route('filtervehiclenum') }}",
                method: 'GET',
                data: {
                    search2: search2,
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

    <script>
        var search3 = '';
        $(document).ready(function() {
            load_data3();
        })

        function load_data3() {
            $.ajax({
                url: "{{ route('filtertypevehi') }}",
                method: 'GET',
                data: {
                    search3: search3,
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

    <script>
        $("form#formsub").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $('.preloader').show();
            $.ajax({
                url: "{{ route('vehiclewisesummfilsub') }}",
                type: 'POST',
                data: formData,
                success: function(datares) {
                    console.log(datares);
                    // alert();
                    $('.preloader').hide();
                    $('.display-datares').html(datares.datares);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>

    <script>
        function Ascvehicleno() {
            $('.preloader').show();
            $.ajax({
                url: "{{ route('vehwisesumasc','vehicleno') }}",
                method: 'GET',
                dataType: 'json',
                success: function(datares) {
                    // alert(result.d);
                    $('.preloader').hide();
                    console.log(datares);
                    $('.display-datares').html(datares.datares);
                }
            })
        }

        function Descvehicleno() {
            $('.preloader').show();
            $.ajax({
                url: "{{ route('vehwisesumdesc','vehicleno') }}",
                method: 'GET',
                dataType: 'json',
                success: function(datares) {
                    // alert(result.d);
                    $('.preloader').hide();
                    console.log(datares);
                    $('.display-datares').html(datares.datares);
                }
            })
        }


        function Ascomc() {
            $('.preloader').show();
            $.ajax({
                url: "{{ route('vehwisesumasc','omc') }}",
                method: 'GET',
                dataType: 'json',
                success: function(datares) {
                    // alert(result.d);
                    $('.preloader').hide();
                    console.log(datares);
                    $('.display-datares').html(datares.datares);
                }
            })
        }

        function Descomc() {
            $('.preloader').show();
            $.ajax({
                url: "{{ route('vehwisesumdesc','omc') }}",
                method: 'GET',
                dataType: 'json',
                success: function(datares) {
                    // alert(result.d);
                    $('.preloader').hide();
                    console.log(datares);
                    $('.display-datares').html(datares.datares);
                }
            })
        }


        function Asctypeofvehicle() {
            $('.preloader').show();
            $.ajax({
                url: "{{ route('vehwisesumasc','typeofvehicle') }}",
                method: 'GET',
                dataType: 'json',
                success: function(datares) {
                    // alert(result.d);
                    $('.preloader').hide();
                    console.log(datares);
                    $('.display-datares').html(datares.datares);
                }
            })
        }

        function Desctypeofvehicle() {
            $('.preloader').show();
            $.ajax({
                url: "{{ route('vehwisesumdesc','typeofvehicle') }}",
                method: 'GET',
                dataType: 'json',
                success: function(datares) {
                    // alert(result.d);
                    $('.preloader').hide();
                    console.log(datares);
                    $('.display-datares').html(datares.datares);
                }
            })
        }
    </script>
@endsection
