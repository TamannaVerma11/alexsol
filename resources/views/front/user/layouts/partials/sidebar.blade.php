<div class="top-content">

    <nav class="navbar navbar-dark side-profile m-menu">

        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="offcanvas offcanvas-start text-bg-dark my-sidebar" tabindex="-1"
                id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <span class="proavtpic">
                        <a href="javascipt:void(0);" class="logo">
                            <img src="{{ url('/images/logo-transparent.png') }}" alt="Logo">
                        </a>
                    </span>
                    <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <div class="d-flex flex-column flex-shrink-0 text-white">

                        <ul class="nav nav-pills flex-column mb-auto">
                            <li class="nav-item"><a
                                    href="{{ route('home.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('home.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-home"></i>
                                    {{ trans('index.dashboard_text') }}</a></li>
                            <li class="nav-item"><a
                                    href="{{ route('ticket.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('ticket.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-ticket-alt"></i>
                                    {{ trans('index.user_sidebar_phrase2') }}
                                </a>
                            </li>
                            <li class="nav-item"><a
                                href="{{ route('report.request', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('report.request')) active @endif"
                                aria-current="page"> <i class="fas fa-home"></i>
                                {{ trans('index.request_report_all') }}

                            <!-- Special Company menu -->
                            @if (auth()->user()->user_type == 'company_owner')
                                <li class="nav-item"><a href="#" class="nav-link"
                                        aria-current="page"> <i class="fas fa-building"></i>
                                        {{ trans('index.user_sidebar_phrase3') }}
                                    </a>
                                    <ul class="text-small shadow">
                                        <li class="nav-item"><a
                                                href="{{ route('user.company', app()->getLocale()) }}"
                                                class="nav-link @if (Request::routeIs('user.company')) active @endif"
                                                aria-current="page"> <i
                                                    class="fas fa-building"></i>{{ trans('index.user_profile_phrase13') }}
                                            </a></li>
                                        <li class="nav-item"><a
                                                href="{{ route('user.changePass', app()->getLocale()) }}"
                                                class="nav-link @if (Request::routeIs('user.changePass')) active @endif"
                                                aria-current="page"> <i
                                                    class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase19') }}
                                            </a></li>
                                        <li class="nav-item"><a
                                                href="{{ route('user.create', app()->getLocale()) }}"
                                                class="nav-link @if (Request::routeIs('user.create')) active @endif"
                                                aria-current="page"> <i
                                                    class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase20') }}
                                            </a></li>
                                </li>
                                <li class="nav-item"><a
                                        href="{{ route('user.create', app()->getLocale()) }}"
                                        class="nav-link @if (Request::routeIs('user.create')) active @endif"
                                        aria-current="page"> <i
                                            class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase23') }}
                                    </a></li>
                                <li class="nav-item"><a
                                        href="{{ route('tfa.index', app()->getLocale()) }}"
                                        class="nav-link @if (Request::routeIs('tfa.index')) active @endif"
                                        aria-current="page"> <i
                                            class="fas fa-building"></i>{{ trans('index.index_phrase29') }}
                                    </a>
                                </li>

                                </ul>
                                </li>

                                <li class="nav-item"><a
                                        href="{{ route('company.users', app()->getLocale()) }}"
                                        class="nav-link @if (Request::routeIs('company.users')) active @endif"
                                        aria-current="page"> <i class="fas fa-users"></i>
                                        {{ trans('index.user_sidebar_phrase18') }}
                                    </a></li>
                                @endif

                        <!-- Special User menu -->
                        @if (auth()->user()->user_type == 'user')
                            <li class="nav-item"><a
                                    href="{{ route('ticket.summarize', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('ticket.summarize')) active @endif"
                                    aria-current="page"> <i class="fas fa-plus-square"></i>
                                    {{ trans('index.user_sidebar_phrase4') }}
                                </a></li>

                            <li class="nav-item"><a href="#" class="nav-link"
                                    aria-current="page">
                                    <i class="fas fa-user"></i>
                                    {{ trans('index.user_sidebar_phrase5') }}
                                </a>
                                <ul class="text-small shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('user.profile', app()->getLocale()) }}"
                                            class="nav-link 22 @if (Request::routeIs('user.profile')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_profile_phrase13') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('user.changePass', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('user.changePass')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase19') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('tfa.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('tfa.index')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.index_phrase29') }}
                                        </a></li>
                                </ul>
                            </li>
                        @endif

                        <!-- General Admin menu -->
                        @if (auth()->user()->user_type == 'admin_super' || auth()->user()->user_type == 'admin_support')
                            <li class="nav-item"><a
                                href="{{ route('report.request', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('report.request')) active @endif"
                                aria-current="page"> <i class="fas fa-home"></i>
                                {{ trans('index.request_report_all') }}

                            <li class="nav-item"><a href="#" class="nav-link"
                                    aria-current="page"> <i class="fas fa-user-shield"></i>
                                    {{ trans('index.user_sidebar_phrase6') }}
                                </a>
                                <ul class="text-small shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('user.profile', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('user.profile')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_profile_phrase13') }}
                                        </a>
                                    </li>
                                    <li class="nav-item"><a
                                            href="{{ route('user.changePass', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('user.changePass')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase19') }}
                                        </a>
                                    </li>
                                    <li class="nav-item"><a
                                            href="{{ route('tfa.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('tfa.index')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.index_phrase29') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item"><a
                                    href="{{ route('company.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('company.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-building"></i>
                                    {{ trans('index.user_sidebar_phrase7') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('user.consultant', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('user.consultant')) active @endif"
                                    aria-current="page"> <i class="fas fa-building"></i>
                                    {{ trans('index.user_sidebar_phrase22') }}
                                </a></li>
                        @endif

                        <!-- Special Super Admin menu -->

                        @if (auth()->user()->user_type == 'admin_super')
                            <li class="nav-item"><a
                                    href="{{ route('method.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('method.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-star-of-david"></i>
                                    {{ trans('index.user_sidebar_phrase8') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('category.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('category.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i>
                                    {{ trans('index.user_sidebar_phrase17') }}
                                </a></li>
                            <li class="nav-item"><a
                                    href="{{ route('report.format', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.format')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i> Main
                                    Report<?php //echo $trans->phrase("user_sidebar_phrase17");
                                    ?>
                                </a></li>
                            <li class="nav-item"><a
                                    href="{{ route('report.format', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.format')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i>
                                    {{ trans('index.multi_lang_report') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('question.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('question.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-question"></i>
                                    {{ trans('index.user_sidebar_phrase9') }}
                                </a></li>

                            <!-- Lukman code -->
                            <li class="nav-item"><a href="#"
                                    class="nav-link"
                                    aria-current="page"> <i class="fas fa-user-shield"></i>
                                    {{ trans('index.user_sidebar_phrase9') }}
                                </a>
                                <ul class="submenu text-small shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('question.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('question.index')) active @endif"
                                            aria-current="page"> <i class="fas fa-question"></i>
                                            {{ trans('index.user_sidebar_phrase9') }}
                                        </a></li>

                                    <li class="nav-item"><a
                                            href="{{ route('question.responder.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('question.responder.index')) active @endif"
                                            aria-current="page"> <i class="fas fa-question"></i>
                                            {{ trans('index.responder_text') }}
                                        </a></li>
                                </ul>
                            </li>

                            <li class="nav-item"><a
                                    href="{{ route('industry.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('industry.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-industry"></i>
                                    {{ trans('index.user_sidebar_phrase16') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('language.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('language.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-language"></i>
                                    {{ trans('index.user_sidebar_phrase10') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('package.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('package.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-cubes"></i>
                                    {{ trans('index.user_sidebar_phrase14') }}
                                </a></li>
                        @endif

                        <!-- Consultant menu -->

                        @if (auth()->user()->user_type == 'consultant')
                            <li class="nav-item"><a
                                href="{{ route('report.request', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('report.request')) active @endif"
                                aria-current="page"> <i class="fas fa-home"></i>
                                {{ trans('index.request_report_all') }}
                            <li class="nav-item"><a
                                    href="{{ route('report.format', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.format')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i> Main
                                    Report<?php //echo $trans->phrase("user_sidebar_phrase17");
                                    ?>
                                </a></li>
                            <li class="nav-item"><a href="#" class="nav-link"
                                    aria-current="page"> <i class="fas fa-user-shield"></i>
                                    {{ trans('index.user_sidebar_phrase21') }}
                                </a>
                                <ul class="text-small shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('user.profile', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('user.profile')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_profile_phrase13') }}
                                        </a>
                                    </li>
                                    <li class="nav-item"><a
                                            href="{{ route('user.changePass', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('user.changePass')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase19') }}
                                        </a>
                                    </li>

                                    <li class="nav-item"><a
                                            href="{{ route('tfa.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('tfa.index')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.index_phrase29') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item"><a
                                    href="{{ route('consultant.companies', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('consultant.companies')) active @endif"
                                    aria-current="page"> <i class="fas fa-building"></i>
                                    {{ trans('index.user_sidebar_phrase7') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('method.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('method.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-star-of-david"></i>
                                    {{ trans('index.user_sidebar_phrase8') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('category.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('category.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i>
                                    {{ trans('index.user_sidebar_phrase17') }}
                                </a></li>

                            <!-- Lukman code -->
                            <li class="nav-item"><a href="#"
                                    class="nav-link"
                                    aria-current="page"> <i class="fas fa-user-shield"></i>
                                    {{ trans('index.user_sidebar_phrase9') }}
                                </a>
                                <ul class="submenu text-small shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('question.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('question.index')) active @endif"
                                            aria-current="page"> <i class="fas fa-question"></i>
                                            {{ trans('index.user_sidebar_phrase9') }}
                                        </a></li>

                                    <li class="nav-item"><a
                                            href="{{ route('question.responder.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('question.responder.index')) active @endif"
                                            aria-current="page"> <i class="fas fa-question"></i>
                                            {{ trans('index.responder_text') }}
                                        </a></li>
                                </ul>
                            </li>

                            <li class="nav-item"><a
                                    href="{{ route('user.consultant', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('user.consultant')) active @endif"
                                    aria-current="page"> <i class="fas fa-question"></i>
                                    Consultant
                                </a></li>

                            <!-- Lukman code -->

                            <li class="nav-item"><a
                                    href="{{ route('industry.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('industry.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-industry"></i>
                                    {{ trans('index.user_sidebar_phrase16') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('language.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('language.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-language"></i>
                                    {{ trans('index.user_sidebar_phrase10') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('package.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('package.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-cubes"></i>
                                    {{ trans('index.user_sidebar_phrase14') }}
                                </a></li>
                        @endif

                        <li class="nav-item"><a
                                href="{{ route('tos.index', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('tos.index')) active @endif"
                                aria-current="page"> <i class="fas fa-info-circle"></i>
                                {{ trans('index.user_sidebar_phrase11') }}
                            </a></li>

                        <li class="nav-item"><a
                                href="{{ route('support.index', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('support.index')) active @endif"
                                aria-current="page"> <i class="fas fa-headset"></i>
                                {{ trans('index.user_sidebar_phrase13') }}
                            </a></li>

                        <li class="nav-item"><a
                                href="{{ route('faq.index', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('faq.index')) active @endif"
                                aria-current="page"> <i class="fas fa-hands-helping"></i>
                                {{ trans('index.text_faq') }}</a>
                        </li>

                        <li class="nav-item navbar_signout"><a href="{{ route('user.logout', app()->getLocale())}}"
                                class="nav-link" aria-current="page"> <i
                                    class="fas fa-sign-out-alt"></i>
                                {{ trans('index.user_sidebar_phrase12') }}
                            </a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </nav>

    <nav class="side-profile h-sticky">

        <div class="my-sidebar">
            <div class="offcanvas-header">
                <span class="proavtpic">
                    <a href="javascipt:void(0);" class="logo">
                        <img src="{{ url('/images/logo-transparent.png') }}" alt="Logo">
                    </a>
                </span>
            </div>

            <div class="offcanvas-body">

                <div class="d-flex flex-column flex-shrink-0 text-white">

                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item"><a
                                href="{{ route('home.index', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('home.index')) active @endif"
                                aria-current="page"> <i class="fas fa-home"></i>
                                {{ trans('index.dashboard_text') }}</a></li>
                        <li class="nav-item"><a
                                href="{{ route('ticket.index', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('ticket.index')) active @endif"
                                aria-current="page"> <i class="fas fa-ticket-alt"></i>
                                {{ trans('index.user_sidebar_phrase2') }}
                            </a></li>


                        <!-- Special Company menu -->

                        @if (auth()->user()->user_type == 'company_owner')
                            <li class="nav-item"><!---user/index.php?route=ticket&page=naticket--><a
                                    href="{{ route('ticket.company', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('ticket.company')) active @endif"
                                    aria-current="page"> <i class="fas fa-plus-square"></i>
                                    {{ trans('index.company_add_ticket_text') }}
                                </a></li>
                            <li class="nav-item"><a
                                    href="{{ route('report.format', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.format')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i> Main
                                    Report<?php //echo $trans->phrase("user_sidebar_phrase17");
                                    ?>
                                </a></li>
                            <li class="nav-item"><a
                                    href="{{ route('report.request', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.request')) active @endif"
                                    aria-current="page"> <i class="fas fa-home"></i>
                                    {{ trans('index.request_report_all') }}</a>
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link"
                                    aria-current="page"> <i class="fas fa-building"></i>
                                    {{ trans('index.user_sidebar_phrase3') }}
                                </a>
                                <ul class="submenu shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('company.profile', app()->getLocale()) }}"
                                            class="nav-link " aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_profile_phrase13') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('user.changePass', app()->getLocale()) }}"
                                            class="nav-link " aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase19') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('tfa.index', app()->getLocale()) }}"
                                            class="nav-link " aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.index_phrase29') }}
                                        </a></li>
                                </ul>
                            </li>

                            <li class="nav-item"><a href="#"
                                    class="nav-link"
                                    aria-current="page"> <i class="fas fa-users"></i>
                                    {{ trans('index.user_sidebar_phrase18') }}
                                </a>
                                <ul class="submenu shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('company.users', app()->getLocale()) }}"
                                            class="nav-link " aria-current="page"> <i
                                                class="fas fa-users"></i>{{ trans('index.all_user_text') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('company.users.add', app()->getLocale()) }}"
                                            class="nav-link" aria-current="page"> <i
                                                class="fas fa-users"></i>{{ trans('index.user_sidebar_phrase20') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('company.users.invite', app()->getLocale()) }}"
                                            class="nav-link" aria-current="page"> <i
                                                class="fas fa-users"></i>
                                            {{ trans('index.user_invite') }}
                                        </a></li>
                                </ul>
                            </li>
                        @endif


                        <!-- Special User menu -->

                        @if (auth()->user()->user_type == 'user')

                            @if (auth()->user()->approve_per == 1)
                                <li class="nav-item"><!-- user/index.php?route=ticket&page=nticket--><a
                                        href="{{ route('ticket.user', app()->getLocale()) }}"
                                        class="nav-link @if (Request::routeIs('ticket.user')) active @endif"
                                        aria-current="page"> <i class="fas fa-plus-square"></i>
                                        {{ trans('index.user_sidebar_phrase4') }}
                                    </a></li>
                            @else
                                <li class="nav-item"><!-- user/index.php?route=ticket&page=naticket--><a
                                        href="{{ route('ticket.newAnalyse', app()->getLocale()) }}"
                                        class="nav-link @if (Request::routeIs('ticket.newAnalyse')) active @endif"
                                        aria-current="page"> <i class="fas fa-plus-square"></i>
                                        {{ trans('index.user_sidebar_phrase4') }}
                                    </a></li>
                            @endif

                            <li class="nav-item"><!-- user/index.php?route=ticket&page=rtickets--><a
                                    href="{{ route('ticket.pending', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('ticket.pending')) active @endif"
                                    aria-current="page"> <i class="fas fa-ticket-alt"></i>
                                    {{ trans('index.ticket_request') }}
                                </a></li>
                            <li class="nav-item"><a
                                    href="{{ route('report.format', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.format')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i> Main
                                    Report<?php //echo $trans->phrase("user_sidebar_phrase17");
                                    ?>
                                </a></li>

                            <li class="nav-item"><a href="#" class="nav-link "
                                    aria-current="page"> <i class="fas fa-user"></i>
                                    {{ trans('index.user_sidebar_phrase5') }}
                                </a>
                                <ul
                                    class="submenu text-small shadow @if (Request::routeIs('user.profile') || Request::routeIs('user.changePass') || Request::routeIs('tfa.index')) myown @endif">
                                    <li class="nav-item"><a
                                            href="{{ route('user.profile', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('user.profile')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_profile_phrase13') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('user.changePass', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('user.changePass')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase19') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('tfa.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('tfa.index')) active @endif"
                                            aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.index_phrase29') }}
                                        </a></li>
                                </ul>
                            </li>

                        @endif


                        <!-- General Admin menu -->

                        @if (auth()->user()->user_type == 'admin_super' || auth()->user()->user_type == 'admin_support')
                            <li class="nav-item"><a
                                    href="{{ route('report.request', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.request')) active @endif"
                                    aria-current="page"> <i class="fas fa-home"></i>
                                    {{ trans('index.request_report_all') }}

                            <li class="nav-item"><a href="#"
                                    class="nav-link"
                                    aria-current="page"> <i class="fas fa-user-shield"></i>
                                    {{ trans('index.user_sidebar_phrase6') }}
                                </a>
                                <ul class="submenu text-small shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('user.profile', app()->getLocale()) }}"
                                            class="nav-link" aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_profile_phrase13') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('user.changePass', app()->getLocale()) }}"
                                            class="nav-link" aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase19') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('tfa.index', app()->getLocale()) }}"
                                            class="nav-link" aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.index_phrase29') }}
                                        </a></li>
                                </ul>
                            </li>

                            <li class="nav-item"><a
                                    href="{{ route('company.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('company.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-building"></i>
                                    {{ trans('index.user_sidebar_phrase7') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('user.consultant', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('user.consultant')) active @endif"
                                    aria-current="page"> <i class="fas fa-building"></i>
                                    {{ trans('index.user_sidebar_phrase22') }}
                                </a></li>
                        @endif


                        <!-- Special Super Admin menu -->

                        @if (auth()->user()->user_type == 'admin_super')
                            <li class="nav-item"><a
                                    href="{{ route('method.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('method.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-star-of-david"></i>
                                    {{ trans('index.user_sidebar_phrase8') }}
                                </a></li>


                            <li class="nav-item"><a
                                    href="{{ route('category.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('category.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i>
                                    {{ trans('index.user_sidebar_phrase17') }}
                                </a></li>
                            <li class="nav-item"><a
                                    href="{{ route('report.format', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.format')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i>Main report
                                </a></li>
                            <li class="nav-item"><!--user/index.php?route=mreport_format--><a
                                    href="{{ route('report.mlreport.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.mlreport.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i>
                                    {{ trans('index.multi_lang_report') }}
                                </a></li>

                            <!-- Lukman code -->
                            <li class="nav-item"><a href="#"
                                    class="nav-link"
                                    aria-current="page"> <i class="fas fa-user-shield"></i>
                                    {{ trans('index.user_sidebar_phrase9') }}
                                </a>
                                <ul class="submenu text-small shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('question.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('question.index')) active @endif"
                                            aria-current="page"> <i class="fas fa-question"></i>
                                            {{ trans('index.user_sidebar_phrase9') }}
                                        </a></li>

                                    <li class="nav-item"><a
                                            href="{{ route('question.responder.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('question.responder.index')) active @endif"
                                            aria-current="page"> <i class="fas fa-question"></i>
                                            {{ trans('index.responder_text') }}
                                        </a></li>
                                </ul>
                            </li>

                            <!-- Lukman code -->

                            <li class="nav-item"><a
                                    href="{{ route('industry.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('industry.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-industry"></i>
                                    {{ trans('index.user_sidebar_phrase16') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('language.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('language.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-language"></i>
                                    {{ trans('index.user_sidebar_phrase10') }}
                                </a></li>

                            <li class="nav-item"><a
                                    href="{{ route('package.index', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('package.index')) active @endif"
                                    aria-current="page"> <i class="fas fa-cubes"></i>
                                    {{ trans('index.user_sidebar_phrase14') }}
                                </a></li>
                        @endif

                        <!-- Consultant menu -->

                        @if (auth()->user()->user_type == 'consultant')
                            <li class="nav-item"><a
                                href="{{ route('report.request', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('report.request')) active @endif"
                                aria-current="page"> <i class="fas fa-home"></i>
                                {{ trans('index.request_report_all') }}
                            <li class="nav-item"><a
                                    href="{{ route('report.format', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('report.format')) active @endif"
                                    aria-current="page"> <i class="fas fa-stream"></i> Main
                                    Report<?php //echo $trans->phrase("user_sidebar_phrase17");
                                    ?>
                                </a></li>
                            <li class="nav-item"><a href="#"
                                    class="nav-link"
                                    aria-current="page"> <i class="fas fa-user-shield"></i>
                                    {{ trans('index.user_sidebar_phrase21') }}
                                </a>
                                <ul class="submenu text-small shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('user.profile', app()->getLocale()) }}"
                                            class="nav-link" aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_profile_phrase13') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('user.changePass', app()->getLocale()) }}"
                                            class="nav-link" aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.user_sidebar_phrase19') }}
                                        </a></li>
                                    <li class="nav-item"><a
                                            href="{{ route('tfa.index', app()->getLocale()) }}"
                                            class="nav-link" aria-current="page"> <i
                                                class="fas fa-building"></i>{{ trans('index.index_phrase29') }}
                                        </a></li>
                                </ul>
                            </li>

                            <li class="nav-item"><a
                                    href="{{ route('consultant.companies', app()->getLocale()) }}"
                                    class="nav-link @if (Request::routeIs('consultant.companies')) active @endif"
                                    aria-current="page"> <i class="fas fa-building"></i>
                                    {{ trans('index.user_sidebar_phrase7') }}
                                </a></li>

                            <!-- Lukman code -->
                            <li class="nav-item"><a href="#"
                                    class="nav-link"
                                    aria-current="page"> <i class="fas fa-user-shield"></i>
                                    {{ trans('index.user_sidebar_phrase9') }}
                                </a>
                                <ul class="submenu text-small shadow">
                                    <li class="nav-item"><a
                                            href="{{ route('question.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('question.index')) active @endif"
                                            aria-current="page"> <i class="fas fa-question"></i>
                                            {{ trans('index.user_sidebar_phrase9') }}
                                        </a></li>

                                    <li class="nav-item"><a
                                            href="{{ route('question.responder.index', app()->getLocale()) }}"
                                            class="nav-link @if (Request::routeIs('question.responder.index')) active @endif"
                                            aria-current="page"> <i class="fas fa-question"></i>
                                            {{ trans('index.responder_text') }}
                                        </a></li>
                                </ul>
                            </li>

                            <!-- Lukman code -->
                        @endif

                        <li class="nav-item"><a
                                href="{{ route('tos.index', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('tos.index')) active @endif"
                                aria-current="page"> <i class="fas fa-info-circle"></i>
                                {{ trans('index.user_sidebar_phrase11') }}
                            </a></li>

                        <li class="nav-item"><a
                                href="{{ route('support.index', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('support.index')) active @endif"
                                aria-current="page"> <i class="fas fa-headset"></i>
                                {{ trans('index.user_sidebar_phrase13') }}
                            </a></li>

                        <li class="nav-item"><a
                                href="{{ route('faq.index', app()->getLocale()) }}"
                                class="nav-link @if (Request::routeIs('faq.index')) active @endif"
                                aria-current="page"> <i class="fas fa-hands-helping"></i>
                                {{ trans('index.text_faq') }}</a>
                        </li>

                        <li class="nav-item navbar_signout"><a href="{{ route('user.logout', app()->getLocale()) }}" class="nav-link"
                                aria-current="page"> <i class="fas fa-sign-out-alt"></i>
                                {{ trans('index.user_sidebar_phrase12') }}
                            </a></li>
                    </ul>

                </div>


            </div>
        </div>
    </nav>

</div>
