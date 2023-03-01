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
</head>

<body>
    <!-- Preloader-->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- Main wrapper -->
    <section id="wrapper" class="login-register login-sidebar">
        <div class="logo-box">
            <img src="{{ asset('assets/images/nrl-logo.svg') }}" alt="nrl logo" />
        </div>
        <div class="login-box">
            <div class="login-body">
                <h2>Welcome</h2>
                <p class="text-muted">Kindly, use your email and password to sign in.</p>
                <form class="form-horizontal" id="loginform" action="{{ route('loginsub') }}" method="POST">
                    @csrf
                    <div class="form-group m-t-40">
                        <label>Email</label>
                        <div class="icon-icon-input">
                            <input class="form-control" type="text" name="email" required=""
                                placeholder="Enter email address" autocomplete="off">
                            <i class="isax isax-sms"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="icon-icon-input">
                            <input class="form-control password" type="password" name="password" required=""
                                placeholder="Password">
                            <i class="isax isax-eye pwicon"></i>
                        </div>
                    </div>
                    <div class="form-group text-center mt-5">
                        <div class="col-xs-12">
                            <!-- <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button> -->
                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit" id="loginsub">
                                <span>Login</span>
                                <i class="isax isax-login ml-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- End Wrapper -->

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
        $('.pwicon').hover(function() {
            $('.password').attr('type', 'text');
        }, function() {
            $('.password').attr('type', 'password');
        });

        // $("body").on('click', '.pwicon', function() {
        //     $(this).toggleClass("isax isax-eye");
        //     var input = $(".password");
        //     if (input.attr("type") === "password") {
        //         input.attr("type", "text");
        //     } else {
        //         input.attr("type", "password");
        //     }

        // });
    </script>

    <script>
        $('#loginsub').click(function(){
            $('.preloader').show(); 
        });
    </script>

</body>

</html>
