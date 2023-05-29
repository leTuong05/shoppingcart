<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @stack('title')
    </title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>​

    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/normalize.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/cs-skin-elastic.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <style>
        #weatherWidget .currentDesc {
            color: #ffffff!important;
        }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
            height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }
    </style>
</head>

<body>
    @include('backend.layouts.header')
    @yield('content')
    <div class="clearfix"></div>
    @include('backend.layouts.footer')
    <div class="clearfix"></div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="{{ asset('/backend/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('/backend/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/backend/assets/js/main.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('/backend/assets/js/jquery.matchHeight.min.js') }}"></script>
    <script src="{{ asset('/backend/assets/js/toastr.js') }}"></script>
    <script src="{{ asset('/backend/assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>    
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('js')
    {{-- Broadcast --}}
    <script>
        $(document).ready(function(){
            $notificationCount = $('.notification-count').text();

            @if(Auth::guard('admin')->check())
                Echo.channel('orderNotification')
                    .listen('MessageNotification', (e) => {
                        $notificationCount = $('.notification-count').text();

                        if ($notificationCount == 0) {
                            $notificationCount = '0';
                            $('#dropdownNotification').empty();
                        }

                        $notificationCount = parseInt($notificationCount) + 1;
                        $('.notification-count').text($notificationCount);
                        $('.notification-count').show();
                        $('#dropdownNotification').prepend(`
                        <a class="dropdown-item media" href="`+e.link+`">
                            <span class="photo media-left"><img alt="avatar" src="`+e.image+`"></span>
                            <div class="message media-body">
                                <span class="name float-left">`+e.message+`</span>
                                <span class="time float-right">
                                    0 giây trước
                                </span>
                            </div>
                        </a>
                        `)
                    })
            @endif
        })
    </script>
</body>
</html>
