<div class="profile style-two">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!--@if (Request::routeIs('home.index'))
                    <h2>{{ trans("index.user_company_profile_phrase1") }}</h2>
                @endif-->

                @if (Request::routeIs('ticket.show'))
                    <h2>{{ trans("index.user_sidebar_phrase4") }}</h2>
                @endif

                @if (Request::routeIs('ticket.summary'))
                    <h2>{{ trans("index.user_sidebar_phrase4") }}</h2>
                @endif

                @if (Request::routeIs('ticket.index'))
                    <h2>{{ trans("index.user_sidebar_phrase2") }}</h2>
                @endif

                @if (Request::routeIs('user.profile') && $user->user_type == 'user')
                    <h2>{{ trans("index.user_pro_text") }}</h2>
                @endif

                @if (Request::routeIs('user.profile') && ($user->user_type == 'admin_super' ||$user->user_type == 'admin_support' ) )
                    <h2>{{ trans("index.admin_pro_text") }}</h2>
                @endif

                @if (Request::routeIs('user.profile') && $user->user_type == 'consultant')
                    <h2>{{ trans("index.consult_pro_text") }}</h2>
                @endif

                @if (Request::routeIs('tos.index'))
                    <h2>{{ trans("index.user_sidebar_phrase11") }}</h2>
                @endif

                @if (Request::routeIs('company.index'))
                    <h2>{{ trans("index.user_sidebar_phrase7") }}</h2>
                @endif

                @if (Request::routeIs('user.consultants'))
                    <h2>{{ trans("index.user_sidebar_phrase22") }}</h2>
                @endif

                @if (Request::routeIs('user.profile') && $user->user_type == 'company_owner')
                    @if (Request::routeIs('user.create'))
                        <h2>{{ trans("index.user_company_profile_phrase19") }}</h2>
                    @elseif(Request::routeIs('user.changePass'))
                        <h2>Change Password</h2>
                    @else
                        <h2>{{ trans("index.user_sidebar_phrase3") }}</h2>
                    @endif
                @endif

                @if (Request::routeIs('company.module'))
                    <h2>{{ trans("index.user_company_profile_phrase1") }}</h2>
                @endif

                @if (Request::routeIs('language.index'))
                    <h2>{{ trans("index.user_sidebar_phrase10") }}</h2>
                @endif

                @if (Request::routeIs('method.index'))
                    <h2>{{ trans("index.user_sidebar_phrase8") }}</h2>
                @endif

                @if (Request::routeIs('category.index'))
                    <h2>{{ trans("index.user_sidebar_phrase17") }}</h2>
                @endif

                @if (Request::routeIs('report.format'))
                    <h2>Report Formats</h2>
                @endif

                @if (Request::routeIs('question.index'))
                    <h2>{{ trans("index.user_sidebar_phrase9") }}</h2>
                @endif

                @if (Request::routeIs('industry.index'))
                    <h2>{{ trans("index.user_sidebar_phrase16") }}</h2>
                @endif

                @if (Request::routeIs('support.index'))
                    <h2>{{ trans("index.user_sidebar_phrase13") }}</h2>
                @endif

                @if (Request::routeIs('package.index'))
                    <h2>{{ trans("index.user_sidebar_phrase14") }}</h2>
                @endif

                @if (Request::routeIs('tracker.index'))
                    <h2>{{ trans("index.user_sidebar_phrase15") }}</h2>
                @endif

                @if (Request::routeIs('report.composer'))
                    <h2>{{ trans("index.user_company_profile_phrase1") }}</h2>
                @endif

                @if (Request::routeIs('feedback.index'))
                    <h2>{{ trans("index.user_tickets_phrase9") }}</h2>
                @endif

                @if (Request::routeIs('user.index'))
                    <h2>{{ trans("index.user_sidebar_phrase18") }}</h2>
                @endif

                @if (Request::routeIs('faq.index'))
                    <h2>{{ trans("index.text_faq") }}</h2>
                @endif

                @if (Request::routeIs('ticket.add'))
                    <h2>{{ trans("index.user_sidebar_phrase4") }}</h2>
                @endif



            </div>
            <div class="col pppropic">
                @if (auth()->check() && @$user->user_type == 'company_owner')
                    <div class="propic">
                        <span class="notification"><i class="fa-solid fa-bell"></i> <span
                                class="badge badge-warning">{{ $data_pedning_tickets->count() }}</span></span>
                        <span class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            </span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                @if ($data_pedning_tickets)
                                    @foreach ($data_pedning_tickets as $data_pedning_ticket)
                                        @php
                                            $user_id = $data_pedning_ticket->user_id;
                                            $user_data = \App\Models\User::find($user_id);
                                        @endphp
                                        <li class="nav-item"><a
                                            href="{{ route('report.request', app()->getLocale()).'?status=0' }}"
                                            target="_blank" class="nav-link dropdown-item"> <i class="fas fa-stream"></i>
                                            {{ $user_data->name }} sent a request!</a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="nav-item">{{ trans("index.no_pending_requests") }} </li>
                                @endif
                            </ul>
                        </span>

                        @if (!empty($user_profile))
                            <img src="{{ url($user_profile) }}">
                        @else
                            <i class="fas fa-user"></i>
                        @endif

                        <span class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            </span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <li class="nav-item"><a
                                        href="{{ route('user.profile', app()->getLocale()) }}"
                                        class="nav-link dropdown-item"> <i class="fas fa-building"></i>
                                        {{ trans("index.user_profile_phrase13") }}</a></li>
                                <li class="nav-item"><a
                                        href="{{ route('user.changePass', app()->getLocale()) }}"
                                        class="nav-link dropdown-item"> <i
                                            class="fas fa-building"></i>{{ trans("index.user_sidebar_phrase19") }}</a>
                                </li>
                                <li class="nav-item"><a
                                        href="{{ route('user.create', app()->getLocale()) }}"
                                        class="nav-link dropdown-item"> <i
                                            class="fas fa-building"></i>{{ trans("index.user_sidebar_phrase20") }}</a>
                                </li>
                                <li class="nav-item navbar_signout"><a href="{{ route('user.logout', app()->getLocale()) }}" class="nav-link dropdown-item"> <i
                                            class="fas fa-sign-out-alt"></i>
                                        {{ trans("index.user_sidebar_phrase12") }}</a></li>
                            </ul>
                        </span>
                    </div>
                    <div class="propic terms-language">
                        <div class="input-group footer-lang">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-language"></i></div>
                            </div>
                            <select id="" class="form-control form-control-sm" onchange="changeLanguage(this.value)">
                                @forelse ($languages as $language)
                                    <option
                                        {{ app()->getLocale() ? (app()->getLocale() == $language->language_code ? 'selected' : '') : '' }}
                                        value="{{ $language->language_code }}">{{ $language->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                    </div>
                    <div class="propic terms-language">
                        <div class="footer-menu">
                            <ul>
                                <a href="{{ route('tos.index', app()->getLocale()) }}">
                                    <li>{{ trans('index.footer_phrase1') }}</li>
                                </a>
                            </ul>
                        </div>
                    </div>
                @elseif( auth()->check() && (
                            @$user->user_type == 'admin_super' ||
                            @$user->user_type == 'admin_support') )
                    <div class="propic">
                        <span class="notification"><i class="fa-solid fa-bell"></i> <span
                                class="badge badge-warning">{{ $data_pedning_tickets->count() }}</span></span>
                        <span class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            </span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                @if ($data_pedning_tickets)
                                    @foreach ($data_pedning_tickets as $data_pedning_ticket)
                                        @php
                                            $user_id = $data_pedning_ticket->user_id;
                                            $user_data = \App\Models\User::find($user_id);
                                        @endphp
                                        <li class="nav-item"><a
                                            href="{{ route('report.request', app()->getLocale()). '?status=0' }}"
                                            target="_blank" class="nav-link dropdown-item"> <i class="fas fa-stream"></i>
                                            {{ $user_data->name }} sent a request!</a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="nav-item">{{ trans("index.no_pending_requests") }} </li>
                                @endif
                            </ul>
                        </span>

                        @if (!empty($user_profile))
                            <img src="{{ url($user_profile) }}">
                        @else
                            <i class="fas fa-user"></i>
                        @endif

                        <span class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            </span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <li class="nav-item"><a href="{{ route('user.profile', app()->getLocale()) }}"
                                        class="nav-link dropdown-item"> <i class="fas fa-building"></i>
                                        {{ trans("index.user_profile_phrase13") }}</a></li>
                                <li class="nav-item"><a
                                        href="{{ route('user.changePass', app()->getLocale()) }}"
                                        class="nav-link dropdown-item"> <i
                                            class="fas fa-building"></i>{{ trans("index.user_sidebar_phrase19") }}</a>
                                </li>
                                <li class="nav-item navbar_signout"><a href="{{ route('user.logout', app()->getLocale()) }}" class="nav-link dropdown-item"> <i
                                            class="fas fa-sign-out-alt"></i>
                                        {{ trans("index.user_sidebar_phrase12") }}</a></li>
                            </ul>
                        </span>
                    </div>

                    <div class="propic terms-language">
                        <div class="input-group footer-lang">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-language"></i></div>
                            </div>
                            <select id="" class="form-control form-control-sm" onchange="changeLanguage(this.value)">
                                @forelse ($languages as $language)
                                    <option
                                        {{ app()->getLocale() ? (app()->getLocale() == $language->language_code ? 'selected' : '') : '' }}
                                        value="{{ $language->language_code }}">{{ $language->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="propic terms-language">
                        <div class="footer-menu">
                            <ul>
                                <a href="{{ route('tos.index', app()->getLocale()) }}">
                                <li>{{ trans('index.footer_phrase1') }}</li></a>
                            </ul>
                        </div>
                    </div>
                @elseif (@$user && @$user->user_type == 'consultant')
                    <div class="propic">
                        <span class="notification"><i class="fa-solid fa-bell"></i> <span class="badge badge-warning">{{ $data_pedning_tickets->count() }}</span></span>
                        <span class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false"></span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                @if ($data_pedning_tickets)
                                    @foreach ($data_pedning_tickets as $data_pedning_ticket)
                                        @php
                                            $user_id = $data_pedning_ticket->user_id;
                                            $user_data = \App\Models\User::find($user_id);
                                        @endphp
                                        <li class="nav-item"><a
                                            href="{{ route('report.request', app()->getLocale()). '?status=0' }}"
                                            target="_blank" class="nav-link dropdown-item"> <i class="fas fa-stream"></i>
                                            {{ $user_data->name }} sent a request!</a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="nav-item">{{ trans("index.no_pending_requests") }} </li>
                                @endif
                            </ul>
                        </span>

                        @if (!empty($user_profile))
                            <img src="{{ url($user_profile) }}">
                        @else
                            <i class="fas fa-user"></i>
                        @endif

                        <span class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false"></span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li class="nav-item"><a href="{{ route('user.profile', app()->getLocale()) }}" class="nav-link dropdown-item"> <i class="fas fa-building"></i>  {{ trans("index.user_profile_phrase13") }}</a></li>
                                    <li class="nav-item"><a href="{{ route('user.changePass', app()->getLocale()) }}" class="nav-link dropdown-item"> <i class="fas fa-building"></i>{{ trans("index.user_sidebar_phrase19") }}</a></li>
                                <li  class="nav-item navbar_signout"><a href="{{ route('user.logout', app()->getLocale()) }}" class="nav-link dropdown-item"> <i class="fas fa-sign-out-alt"></i>  {{ trans("index.user_sidebar_phrase12") }}</a></li>
                            </ul>
                        </span>

                    </div>
                    <div class="propic terms-language">
                        <div class="input-group footer-lang">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-language"></i></div>
                            </div>
                            <select id="" class="form-control form-control-sm" onchange="changeLanguage(this.value)">
                                @forelse ($languages as $language)
                                    <option
                                        {{ app()->getLocale() ? (app()->getLocale() == $language->language_code ? 'selected' : '') : '' }}
                                        value="{{ $language->language_code }}">{{ $language->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="propic terms-language">
                        <div class="footer-menu">
                            <ul>
                                <a href="{{ route('tos.index', app()->getLocale()) }}"><li>{{ trans('index.footer_phrase1') }}</li>
                                </a>
                            </ul>
                        </div>
                    </div>

                @elseif (@$user && @$user->user_type == 'user')
                    <div class="propic">
                        <span class="notification"><i class="fa-solid fa-bell"></i> <span
                            class="badge badge-warning">{{ $data_pedning_tickets->count() }}</span></span>
                        <span class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            </span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                @if ($data_pedning_tickets)
                                    @foreach ($data_pedning_tickets as $data_pedning_ticket)
                                        @php
                                            $user_id = $data_pedning_ticket->user_id;
                                            $user_data = \App\Models\User::find($user_id);
                                        @endphp
                                        <li class="nav-item"><a
                                            href="{{ route('ticket.create', [app()->getLocale(), $data_pedning_ticket->id]) }}"
                                            target="_blank" class="nav-link dropdown-item"> <i class="fas fa-stream"></i>
                                            {{ $data_pedning_ticket->permisson_ticket_title }} Approved! Please
                                            start !</a>
                                        </li>
                                    @endforeach
                                @else
                                <li class="nav-item">{{ trans("index.no_pending_requests") }}</li>
                                @endif

                            </ul>
                        </span>

                        @if (!empty($user_profile))
                            <img src="{{ url($user_profile) }}">
                        @else
                            <i class="fas fa-user"></i>
                        @endif

                        <span class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            </span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <li class="nav-item"><a href="{{ route('user.profile', app()->getLocale()) }}"
                                        class="nav-link dropdown-item"> <i class="fas fa-building"></i>
                                        {{ trans("index.user_profile_phrase13") }}</a></li>
                                <li class="nav-item"><a
                                        href="{{ route('user.changePass', app()->getLocale()) }}"
                                        class="nav-link dropdown-item"> <i
                                            class="fas fa-building"></i>{{ trans("index.user_sidebar_phrase19") }}</a>
                                </li>
                                <li class="nav-item navbar_signout"><a href="{{ route('user.logout', app()->getLocale()) }}" class="nav-link dropdown-item"> <i
                                            class="fas fa-sign-out-alt"></i>
                                        {{ trans("index.user_sidebar_phrase12") }}</a></li>
                            </ul>
                        </span>
                    </div>

                    <div class="propic terms-language">
                        <div class="input-group footer-lang">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-language"></i></div>
                            </div>
                            <select id="" class="form-control form-control-sm" onchange="changeLanguage(this.value)">
                                @forelse ($languages as $language)
                                    <option
                                        {{ app()->getLocale() ? (app()->getLocale() == $language->language_code ? 'selected' : '') : '' }}
                                        value="{{ $language->language_code }}">{{ $language->name }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="propic terms-language">
                        <div class="footer-menu">
                            <ul>
                                <a href="{{ route('tos.index', app()->getLocale()) }}">
                                    <li>{{ trans('index.footer_phrase1') }}</li>
                                </a>
                            </ul>
                        </div>
                    </div>

                @endif
            </div>
        </div>
        <div class="terms-language-mobile row">
            <div class="propic terms-language terms-block">
                <div class="footer-menu">
                    <ul>
                        <a href="{{ route('tos.index', app()->getLocale()) }}">
                            <li>{{ trans('index.footer_phrase1') }}</li>
                        </a>
                    </ul>
                </div>
            </div>
            <div class="propic terms-language lang-block">
                <div class="input-group footer-lang">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-language"></i></div>
                    </div>
                    <select id="" class="form-control form-control-sm" onchange="changeLanguage(this.value)">
                        @forelse ($languages as $language)
                            <option
                                {{ app()->getLocale() ? (app()->getLocale() == @$language->language_code ? 'selected' : '') : '' }}
                                value="{{ @$language->language_code }}">{{ @$language->name }}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
        </div>

    </div>
</div>

