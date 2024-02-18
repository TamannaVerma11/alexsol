<!doctype html>
<html id="html" lang="{{ app()->getLocale() }}" data-layout="main" data-theme="main">
<link rel="stylesheet" href="{{ asset('/vendor/translation/css/main.css') }}">
<head>
    @include('front.user.layouts.partials.head')
</head>

<body id="translation" data-{{@$language->id}}="{{@ $language->language_code}}">
<div id="app">
    <div id="translation">
        <div class="header_logo">
            <a href="javascipt:void(0);" class="logo">
                <img src="{{ url('/images/logo-transparent.png') }}" alt="Logo">
            </a>
        </div>
        <div class="main-body">
            <div class="container-fluid">

                <div class="row no-gutters">

                    <div class="col-sm-4 col-md-3 col-xl-2 mp">

                        <header class="main-header my-header test">
                            @include('front.user.layouts.partials.sidebar')
                        </header>
                    </div>

                    <div class="col-sm-12 col-md-9 col-xl-10 edit-profile">
                        @include('front.user.layouts.partials.header')
                        <div id="user-full-screen-content"></div>
                        @yield('content')
                    </div>

                </div>
            </div>
        </div>

        @include('front.user.layouts.partials.footer')

        @include('front.user.layouts.partials.scripts')
    </div>

    @include('front.user.layouts.partials.messages')

    <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-body">
                    Do you want to delete it?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                        id="cancel">Cancel</button>
                    <a href="" id="deleteLink" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<script src="{{ asset('/vendor/translation/js/app.js') }}"></script>

</html>
