<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Front/front.invoice-system') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/css/fontawesome/all.min.css') }}">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @if(config('app.locale')=='ar'){
   <link rel="stylesheet" href="{{asset('front/css/bootstrap-rtl.css')}}">
    }
   @endif

    @yield('style')
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                @if(session('message'))
                <div class="alert alert-{{session('alert-type')}} alert-dismissible fade show" role="alert" id="session-alert">
                    {{session('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               @endif
            @yield('content')
            </div>
        </main>
    </div>
    <!-- Scripts -->
    <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('front/js/fontawesome/all.min.js')}}"></script>
    <script>
    $(function () {
        $('#session-alert').fadeTo(2000,500).slideUp(500, function () {
            $('#session-alert').slideUp(500);
        })
    })
    </script>
    @yield('script')



</body>
</html>
