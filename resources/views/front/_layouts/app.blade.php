<!doctype html>
<html id="html" lang="{{ app()->getLocale() }}" data-layout="main" data-theme="main">

<head>
    @include('front._layouts._partials.head')
</head>

<body>
    <div class='container-fluid super-container'>

        @yield('content')

        @include('front._layouts._partials.footer')

    </div>
    @include('front._layouts._partials.scripts')


</body>

</html>
