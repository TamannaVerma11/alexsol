<!-- Required meta tags -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{config('app.name')}}</title>

<!--Meta Tags -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="icon" href="{{ url('images/favicon.ico') }}">
<!-- Fonts -->
<link rel="stylesheet" href="{{config('app.FONT_PACIFICO')}}">

<!-- Style Sheets -->
<link rel="stylesheet" href="{{ url('vendor/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ url('vendor/fontawesome-free-5.8.2-web/css/all.min.css') }}">
<link rel="stylesheet" href="{{ url('css/header.css') }}">
<link rel="stylesheet" href="{{ url('css/main.css') }}">
<link rel="stylesheet" href="{{ url('css/custom.css') }}">
<link rel="stylesheet" href="{{ url('css/custom-new.css') }}">

<link rel="stylesheet" href="{{ url('css/toastr.css') }}" type="text/css" />

<style>
    input:focus::placeholder {
        color: transparent;
    }
</style>

