@extends('front.user.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row dashboard-body">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Velkommen tilbake!</h5>
                                    <p>Nøgd Dashboard</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ url('assets/images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    @if (auth()->check() &&
                            ($user->user_type == 'admin_super' || $user->user_type == 'admin_support'))
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="pt-4">
                                        <div class="row">
                                            <div class="col-4">
                                                <p class="text-muted mb-0">Name</p>
                                            </div>
                                            <div class="col-8">
                                                <h5>{{ $admin->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <p class="text-muted mb-0">Mail</p>
                                            </div>
                                            <div class="col-8">
                                                <h5>{{ $admin->email }}</h5>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('user.profile', app()->getLocale()) }}"
                                                class="btn btn-primary waves-effect waves-light btn-sm">{{ trans('index.user_sidebar_phrase6') }}
                                                <i class="mdi mdi-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-xl-8">
                <div class="row">
                    @if ($user && $user->user_type == 'company_owner')
                        <div class="col-md-4">
                            <a href="{{ route('ticket.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">
                                                    {{ trans('index.user_sidebar_phrase2') }}</p>
                                                        <h4 class="mb-0">{{ (!empty($company_tickets)) ? $company_tickets->count() : 'Not defined' }}</h4>
                                            </div>

                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="col-md-4">
                            <a href="{{ route('ticket.index', app()->getLocale()).'?view=process' }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Analyses in Progress</p>
                                                <h4 class="mb-0">{{ (!empty($data_process)) ? $data_process->count() : 'Not defined' }}</h4>
                                            </div>

                                            <div
                                                class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('support.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Support</p>
                                                <h4 class="mb-0">{{ $support_process->count() }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('report.request', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Analysis requestes</p>
                                                <h4 class="mb-0">{{ $report_request_process->count() }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('user.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Users</p>
                                                <h4 class="mb-0">{{ $com_user_process->count() }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @elseif($user && $user->user_type == 'user')
                        <div class="col-md-4">
                            <a href="{{ route('ticket.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">
                                                    {{ trans('index.user_sidebar_phrase2') }}</p>
                                                <h4 class="mb-0">{{ (!empty($company_tickets)) ? $company_tickets->count() : 'Not defined'}}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('ticket.index', app()->getLocale()).'?view=process' }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Analyses in Progress</p>
                                                <h4 class="mb-0">{{ (!empty($data_process)) ? $data_process->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div
                                                class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('support.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Support</p>
                                                <h4 class="mb-0">{{ (!empty($support_process)) ? $support_process->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    @elseif($user && $user->user_type == 'consultant')
                        <div class="col-md-4">
                            <a href="{{ route('company.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Companies</p>
                                                <h4 class="mb-0">{{ (!empty($companies)) ? $companies->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('support.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Support</p>
                                                <h4 class="mb-0">{{ (!empty($support_process)) ? $support_process->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('report.request', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Analysis requestes</p>
                                                <h4 class="mb-0">{{ (!empty($report_request_process)) ? $report_request_process->count() : 'Not defined' }} </h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    @elseif (auth()->check() && $user->user_type == 'admin_super')
                        <div class="col-md-4">
                            <a href="{{ route('ticket.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium"> {{ trans('index.user_sidebar_phrase2') }}</p>
                                                <h4 class="mb-0">{{ (!empty($company_tickets)) ? $company_tickets->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('ticket.index', app()->getLocale()).'?view=process' }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Analyses in Progress</p>
                                                <h4 class="mb-0">{{ (!empty($data_process)) ? $data_process->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('support.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Support</p>
                                                <h4 class="mb-0">{{ (!empty($support_process)) ? $support_process->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('report.request', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Analysis requestes</p>
                                                <h4 class="mb-0">{{ (!empty($report_request_process)) ? $report_request_process->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('company.index', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Companies</p>
                                                <h4 class="mb-0">{{ (!empty($com_process)) ? $com_process->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('user.consultant', app()->getLocale()) }}">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted fw-medium">Consultants</p>
                                                <h4 class="mb-0">{{ (!empty($con_process)) ? $con_process->count() : 'Not defined' }}</h4>
                                            </div>


                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-cubes font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
