<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CPEN PROJECT</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{!!url('/images/images.png') !!}">
	<link rel="stylesheet" href="{!!url('/vendor/chartist/css/chartist.min.css') !!}">
    <link href="{!!url('/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') !!}" rel="stylesheet">
    <link href="{!!url('/css/style.css') !!}" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link href="{!! url('/vendor/datatables/css/jquery.dataTables.min.css') !!}" rel="stylesheet">

    <script src="{!! url('moment.min.js') !!}"></script>


    {{--    chart.js--}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>


    {{--    SweetAlert--}}
    <script src="{!! url('sweetalert2.all.min.js') !!}"></script>
    <link href="{!! url('sweetalert2.min.css') !!}" rel="stylesheet">

    {{-- date picker --}}
    <link rel="stylesheet" href="{!!url('/vendor/pickadate/themes/default.css')!!}">
    <link rel="stylesheet" href="{!!url('/vendor/pickadate/themes/default.date.css')!!}">


</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    {{-- <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div> --}}
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
@include('layouts.navheader')
        <!--**********************************
            Nav header end
        ***********************************-->

				<!--**********************************
            Chat box start
        ***********************************-->

		<!--**********************************
            Chat box End
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
@include('layouts.headerstart')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
@include('layouts.sidestart')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
@yield('contents')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
@include('layouts.footer')
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>

<div id="pnt-loading" style="display:none; width: 100%;height: 100%;top: 0;left: 0;position: fixed;opacity: 0.7;background-color: #fff;z-index: 3500;text-align: center;">
    <img src="{!! url('images/loading.gif') !!}" alt="Loading..."style="position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%); z-index: 3501;"/>
</div>

    {{--modal reset password--}}
    <div class="modal fade gear-modal-reset-password" id="exampleModalCenter">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password User</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="password">Password
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control gear-reset-password" value="12345678">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="password_confirmation">Confirm Password <span
                                class="text-danger">*</span>
                        </label>
                        <div class="col-lg-6">
                            <input type="password" class="form-control gear-reset-password_confirmation"
                                   id="password_confirmation" name="password_confirmation" value="12345678">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary pnt-btn-modal-reset-password-save">Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{--modal reset password--}}

    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{!!url('/vendor/global/global.min.js') !!}"></script>
	<script src="{!!url('/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') !!}"></script>
    <script src="{!!url('/vendor/chart.js/Chart.bundle.min.js') !!}"></script>
    <script src="{!!url('/js/custom.min.js') !!}"></script>
	<!-- Apex Chart -->
	<script src="{!!url('/vendor/apexchart/apexchart.js') !!}"></script>

    <!-- Vectormap -->
	<!-- Chart piety plugin files -->
    <script src="{!!url('/vendor/peity/jquery.peity.min.js') !!}"></script>

    <!-- Chartist -->
    <script src="{!!url('/vendor/chartist/js/chartist.min.js') !!}"></script>

	<!-- Dashboard 1 -->
	<script src="{!!url('/js/dashboard/dashboard-1.js') !!}"></script>
	<!-- Svganimation scripts -->
	<script src="{!!url('/vendor/svganimation/vivus.min.js') !!}"></script>
    <script src="{!!url('/vendor/svganimation/svg.animation.js') !!}"></script>

    <!-- Datatable -->
    <script src="{!! url('/vendor/datatables/js/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! url('/js/plugins-init/datatables.init.js') !!}"></script>

    {{-- date picker --}}
    <script src="{!!url('/vendor/moment/moment.min.js')!!}"></script>
    <script src="{!!url('/vendor/bootstrap-daterangepicker/daterangepicker.js')!!}"></script>
    <script src="{!!url('/vendor/pickadate/picker.js')!!}"></script>
    <script src="{!!url('/vendor/pickadate/picker.time.js')!!}"></script>
    <script src="{!!url('/vendor/pickadate/picker.date.js')!!}"></script>
    <script src="{!!url('/js/plugins-init/pickadate-init.js')!!}"></script>

	<script>
	(function($) {
		"use strict"

		var direction =  getUrlParams('dir');
		if(direction != 'rtl')
		{direction = 'ltr'; }

		new dezSettings({
			typography: "roboto",
			version: "dark",
			layout: "vertical",
			headerBg: "color_1",
			navheaderBg: "color_1",
			sidebarBg: "color_1",
			sidebarStyle: "full",
			sidebarPosition: "fixed",
			headerPosition: "fixed",
			containerLayout: "wide",
			direction: direction
		});

	})(jQuery);

    var token = $('meta[name="csrf-token"]').attr('content');

    function sweetAlert(icon , title)
    {
        Swal.fire({
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 1500
            })
    }




    $(document).off('click', '.only-reset-password').on('click', '.only-reset-password', (e) => {
        window.id = $('.only-reset-pass-value').val();
        $('.gear-modal-reset-password').modal('show');
    });

    $(document).off('click', '.pnt-btn-modal-reset-password-save').on('click', '.pnt-btn-modal-reset-password-save', (e) => {
        console.log($('.gear-reset-password').val())
        console.log($('.gear-reset-password_confirmation').val())
        console.log(window.id)
        if($('.gear-reset-password').val() == $('.gear-reset-password_confirmation').val())
        {
            $.ajax({
                type: "post",
                url: "{!! url('user/resetPassword') !!}/" + window.id,
                data: {
                    password: $('.gear-reset-password').val(),
                    '_token': window.token,
                },
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    console.log(data)
                    if (data.status == "only")
                    {
                        sweetAlert('success' , 'Please Login..')
                        location.reload();
                    }
                    else if (data.status == "other") {
                        sweetAlert('success' , 'Reset Password Success fully')
                    }
                    else{
                        sweetAlert('error' , 'Something went wrong!')
                    }
                    $('.gear-modal-reset-password').modal('hide');
                    $('#pnt-loading').hide();
                },
                error: function (jqXHR, exception) {
                    if (jqXHR.status !== 200) {
                        $('#pnt-loading').hide();
                        sweetAlert('error' , 'Something went wrong!')
                    }
                },
            });
        }
        else
        {
            sweetAlert('error' , 'Password and confirmation do not match')
        }
    });

    </script>

    @yield('script')

</body>
</html>
