<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>NRL</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- date rang picker  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" />
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <style>
        .callapsable {
            position: relative;
            padding-right: 40px;
        }
        .callapsable.show .collapsecontent {height: auto;}
        .collapsecontent {height: 24px; transition: all 0.3s ease-in-out 0s; overflow: hidden; text-overflow: ellipsis;  max-width: 310px;}
        .expandpanel {position: absolute; top: -3px; right: 5px; font-size: 21px; cursor: pointer;}
    </style>
</head>

<body class="fix-header fix-sidebar card-no-border">

    <!-- Preloader-->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- Main wrapper -->

    <div id="main-wrapper">

        <!-- Topbar header -->

        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        <!-- Logo icon -->
                        <b><img src="{{ asset('assets/images/logo-icon.svg') }}" alt="homepage"
                                class="light-logo" /></b>
                        <!-- Logo text -->
                        <span><img src="{{ asset('assets/images/text-logo.svg') }}" alt="homepage"
                                class="dark-logo" /><img src="{{ asset('assets/images/text-logo.png') }}" class="light-logo"
                                alt="homepage" /></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0 align-items-center">
                        <!-- This is  -->
                        <li class="nav-item"> <a
                                class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                                href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a
                                class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark"
                                href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto ml-50 mt-md-0 align-items-center">
                        <!-- Search -->
                        {{-- <li class="nav-item">
                            <form class="app-search">
                                <div class="serchboxs">
                                    <input type="text" class="form-control" placeholder="Search resources">
                                    <i class="ti-search"></i>
                                </div>
                            </form>
                        </li> --}}
                    </ul>

                    <!-- User profile and search -->

                    <ul class="navbar-nav my-lg-0">

                        <!-- Comment -->

                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark"
                                href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="isax isax-notification"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new
                                                        admin!</span> <span class="time">9:30 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-success btn-circle"><i class="ti-calendar"></i>
                                                </div>
                                                <div class="mail-contnet">
                                                    <h5>Event today</h5> <span class="mail-desc">Just a reminder that
                                                        you have event</span> <span class="time">9:10 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Settings</h5> <span class="mail-desc">You can customize this
                                                        template as you want</span> <span class="time">9:08 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my
                                                        admin!</span> <span class="time">9:02 AM</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all
                                                notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}

                        <!-- End Comment -->

                        <!-- Messages -->

                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#"
                                id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="isax isax-messages-2"></i>
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right scale-up" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">You have 4 new messages</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img
                                                        src="{{ asset('assets/images/user.png') }}" alt="user"
                                                        class="img-circle"> <span
                                                        class="profile-status online pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my
                                                        admin!</span> <span class="time">9:30 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img
                                                        src="{{ asset('assets/images/user.png') }}" alt="user"
                                                        class="img-circle"> <span
                                                        class="profile-status busy pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See
                                                        you at</span> <span class="time">9:10 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img
                                                        src="{{ asset('assets/images/user.png') }}" alt="user"
                                                        class="img-circle"> <span
                                                        class="profile-status away pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span>
                                                    <span class="time">9:08 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img
                                                        src="{{ asset('assets/images/user.png') }}" alt="user"
                                                        class="img-circle"> <span
                                                        class="profile-status offline pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my
                                                        admin!</span> <span class="time">9:02 AM</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all
                                                e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                        <!-- End Messages -->

                        <!-- Profile -->
                        <li class="nav-item dropdown usersettings">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('assets/images/'.auth()->user()->image) }}" alt="user"
                                    class="profile-pic" />
                                <i class="ti-menu"></i></a>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{ asset('assets/images/'.auth()->user()->image) }}"
                                                    alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{ auth()->user()->name }}</h4>
                                                <p class="text-muted">{{ auth()->user()->email }}</p>
                                                {{-- <a
                                                    href="profile.html"
                                                    class="btn btn-rounded btn-primary btn-sm">View Profile</a> --}}
                                            </div>
                                        </div>
                                    </li>
                                    {{-- <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li> --}}
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('logout') }}" id="logoutsub"><i class="fa fa-power-off"></i> Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>

        <!-- End Topbar header -->


        <!-- Left Sidebar - style you can find in sidebar.scss  -->

        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">

                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li><a class="waves-effect waves-dark {{ (Request::is('dashboard') || Request::is('dashboard/applyfilters')) ? 'menuhighlight' : '' }}" href="{{ route('dashboard') }}">
                                <i class="isax isax-home {{ (Request::is('dashboard') || Request::is('dashboard/applyfilters')) ? 'menuhighlight' : '' }}"></i> <span class="hide-menu">Dashboard</span></a></li>
                        <li class="nav-small-cap">Reports</li>
                        <li class="dropdownli active"> <a class="has-arrow waves-effect waves-dark" href="#"
                                aria-expanded="false">
                                <i class="isax isax-chart-success"></i><span class="hide-menu">Reports</span></a>
                            <ul aria-expanded="false" class="collapse in">
                                <li><a href="{{ route('anomalyreport') }}" class="{{ (Request::is('dashboard/anomaly-report') || Request::is('dashboard/anomaly-report/applyfilters')) ? 'menuhighlight' : '' }}"><i class="isax isax-clipboard-text"></i>
                                        Anomaly</a></li>
                                <li><a href="{{ route('monthlybilling') }}" class="{{ (Request::is('dashboard/monthly-billing') || Request::is('dashboard/monthly-billing/applyfilters')) ? 'menuhighlight' : '' }}"><i class="isax isax-bill"></i> Monthly Billing</a></li>
                                <li><a href="{{ route('auditor') }}" class="{{ (Request::is('dashboard/auditor') || Request::is('dashboard/auditor/applyfilters')) ? 'menuhighlight' : '' }}"><i class="isax isax-clipboard-tick"></i> Auditor</a></li>
                                <li><a href="{{ route('detailedaudit') }}" class="{{ (Request::is('dashboard/detailed-audit-report') || Request::is('dashboard/detailed-audit-report/applyfilters')) ? 'menuhighlight' : '' }}"><i class="isax isax-stickynote"></i> Detailed Audit</a></li>
                                <li><a href="{{ route('vehiclehistory') }}" class="{{ (Request::is('dashboard/vehicle-history') || Request::is('dashboard/vehicle-history/applyfilters')) ? 'menuhighlight' : '' }}"><i class="isax isax-truck"></i> Vehicle History</a></li>
                                <li><a href="{{ route('vehiclewisesum') }}" class="{{ (Request::is('dashboard/vehicle-wise-summury') || Request::is('dashboard/vehicle-wise-summury/applyfilters')) ? 'menuhighlight' : '' }}"><i class="isax isax-task"></i> Vehicle Wise Summary</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
                <p>Version 1.0</p>
            </div>
            <!-- End Bottom points-->
        </aside>
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->


        @yield('content')


        <!-- All Jquery -->
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <!--Wave Effects -->
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <!--Menu sidebar -->
        <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
        <!--stickey kit -->
        <script src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <!-- Date Picker Plugin JavaScript -->
        <script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!--Custom JavaScript -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        <script>
            $(document).ready(function(){
                $('.expandpanel').click(function(){
                    $(this).parent('.callapsable').toggleClass('show');
                });
            });
        </script>
        

        <script>
            $('#clearallomc').click(function(){
                // alert();
                $("input[type='checkbox'][id='omcdata']").each(function(){
                    $(this).prop('checked', false);
                });
            });

            $('#clearalltypeofvehi').click(function(){
                // alert();
                $("input[type='checkbox'][id='typeofveh']").each(function(){
                    $(this).prop('checked', false);
                });
            })

            $('#clearallauditor').click(function(){
                // alert();
                $("input[type='checkbox'][id='auditortyp']").each(function(){
                    $(this).prop('checked', false);
                });
            })

            $('#clearallvehinumb').click(function(){
                // alert();
                $("input[type='checkbox'][id='vehinumb']").each(function(){
                    $(this).prop('checked', false);
                });
            })
        </script>

        @yield('js')

        <script>
            $('.checkbox').click(function(){
                $('.checkbox').each(function(){
                    $(this).prop('checked', false);
                }); 
                $(this).prop('checked', true);
            });
        </script>

        <script>
            $(document).on('click', '.dropdown-menu', function (e) {
                e.stopPropagation();
            });
        </script>

        <script>
            $('#logoutsub').click(function(){
                $('.preloader').show(); 
            });

            $('#applyfilt').click(function(){
                $('.preloader').show();
            });

            $('#sendmail').click(function(){
                $('.preloader').show(); 
            });
        </script>
</body>

</html>
