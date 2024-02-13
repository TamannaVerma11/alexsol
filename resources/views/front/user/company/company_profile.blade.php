@extends('front.user.layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ url('js/sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ url('js/sweetalert2/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ url('js/toastr/toastr.min.css') }}">

    <style>
        body.swal2-height-auto {
            height: 100% !important;
        }

        .form-row {
            align-items: center;
            margin-top: 10px;
            margin-bottom: 5px;
        }
    </style>

    @if (($user->user_type == 'admin_super' || $user->user_type == 'admin_support' || $user->user_type == 'company_owner')  && isset($company->id))
        <div class="card">
            <div class="card-body p-3">
                <div class="row user-content-row">
                    <div class="col-lg-12">
                        <div class="ab-title text-left">
                            <h3>Edit Profile</h3>
                            <h4></h4>
                        </div>
                    </div>
                    <div class="col-12 company">
                        <div class="d-flex justify-content-center">
                            <img src="{{ url(''.$company->upload_company_img) }}" style="max-width: 220px; border-radius: 150px" alt="Company logo">
                        </div>
                        <div class="company-ctn">
                            <form action="
                                {{ Request::routeIs('company.profile') ?
                                    route('company.profile.update', ['lang' => app()->getLocale()]):
                                    route('company.update', ['lang' => app()->getLocale(), $company->id])
                                }}
                                " method="POST"
                                id="updateCompanyProfileAjax" enctype='multipart/form-data'>
                                @csrf
                                <div class="row company-row">
                                    <div class="col-12 company-id">
                                        <span>{{ trans('index.user_company_profile_phrase9') }} </span>
                                        {{  $company->id }}
                                    </div>
                                </div>
                                <div class="row company-row">
                                    <div class="col-12 company-status">
                                        <span>{{ trans('index.user_company_profile_phrase2') }} </span>
                                        @if ($company->status == 'pending')
                                            <button class="btn btn-light-warning btn-sm disabled">{{ trans('index.user_company_profile_phrase3') }}</button>
                                        @elseif ($company->status == 'active')
                                            <button class="btn btn-light-success btn-sm disabled">{{ trans('index.user_company_profile_phrase4') }}</button>
                                        @elseif ($company->status == 'suspended')
                                            <button class="btn btn-light-secondary btn-sm disabled">{{ trans('index.user_company_profile_phrase5') }}</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="row company-row">
                                    <div class="col-12 company-status">
                                        <span>Company logo </span>
                                        <input type="file" name="upload_company_img" class="company_logo_input form-control" data-company="{{ $company->id }}"
                                            accept=".jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-12">
                                        <span></span>
                                        <span class="text-danger validation_errors upload_company_img_err"></span>
                                    </div>
                                </div>
                                <div class="row company-row comp-nameimp">
                                    <div class="col-12 company-name">
                                        <span>{{ trans('index.user_company_profile_phrase6') }} </span>
                                        <div id="company_name_editor" data-company="{{  $company->id }}" class="editor">
                                            <input type="text" name="name" class="form-control" value="{{  $company->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span></span>
                                        <span class="text-danger validation_errors name_err"></span>
                                    </div>
                                </div>
                                <div class="row company-row">
                                    <div class="col-12 company-industry-type">
                                        <span>{{ trans('index.user_company_profile_phrase37') }} </span>
                                        <div id="company_industry_type_editor" data-company="{{  $company->id }}"
                                            class="editor">
                                            <select name="industry_type" class="form-control register-company-input">
                                                <option value="0" >{{ trans('index.index_phrase28') }}</option>
                                                @forelse ($industry_types as $type)
                                                    <option {{  ( $company->industry_type == $type->id) ? 'selected' : '' }}
                                                        value="{{$type->id}}">{{$type->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span></span>
                                        <span class="text-danger validation_errors industry_type_err"></span>
                                    </div>
                                </div>
                                <div class="row company-row">
                                    <div class="col-12 company-email">
                                        <span>{{ trans('index.user_company_profile_phrase8') }} </span>
                                        <div id="company_email_editor" data-company="{{  $company->id }}" class="editor">
                                            <input type="text" name="email" class="form-control" value="{{  $company_owner->email }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span></span>
                                        <span class="text-danger validation_errors email_err"></span>
                                    </div>
                                </div>
                                <div class="row company-row">
                                    <div class="col-12 company-billing">
                                        <span>{{ trans('index.user_company_profile_phrase12') }} </span>
                                        <div id="company_payment_cycle_editor" data-company="{{  $company->id }}"
                                            class="editor">
                                            <select name="payment_cycle" class="form-control register-company-input" required>
                                                <option value="0">Not selected</option>
                                                <option {{ ($company->payment_cycle == 3) ? 'selected': '' }} value='3'>{{ trans('index.user_js_phrase4') }}</option>
                                                <option {{ ($company->payment_cycle == 6) ? 'selected': '' }} value='6'>{{ trans('index.user_js_phrase5') }}</option>
                                                <option {{ ($company->payment_cycle == 12) ? 'selected': '' }} value='12'>{{ trans('index.user_js_phrase6') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span></span>
                                        <span class="text-danger validation_errors payment_cycle_err"></span>
                                    </div>
                                </div>
                                <div class="row company-row">
                                    <div class="col-12 company-ticket-view">
                                        <span>{{ trans('index.user_company_profile_phrase28') }} </span>
                                        <div id="company_ticket_view_editor" data-company="{{  $company->id }}" class="editor">
                                            <select id='company_ticket_view_editor_input' {{ ($user->user_type == 'company_owner' ? 'disabled' : '')}} name="show_tickets" class='form-control form-control-sm'>
                                                <option {{ ($company->show_tickets == 1) ? 'selected' : '' }} value='1'>{{ trans('index.user_js_phrase20') }}</option>
                                                <option {{ ($company->show_tickets == 0) ? 'selected' : '' }} value='0'>{{ trans('index.user_js_phrase21')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <span></span>
                                        <span class="text-danger validation_errors show_tickets_err"></span>
                                    </div>
                                </div>
                                @if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support')
                                    <div class="row company-row">
                                        <div class="col-12 company-password">
                                            <span>{{ trans('index.user_company_profile_phrase13') }} </span>
                                            <div id="company_password_editor" data-company="{{  $company->id }}" class="editor">
                                                <button id="company_password_editor_button_admin"
                                                        class="btn btn-light-primary  btn-sm"><i
                                                            class="fas fa-key"></i> {{ trans("index.user_company_profile_phrase11") }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <span></span>
                                            <span class="text-danger validation_errors password_err"></span>
                                        </div>
                                    </div>
                                @endif
                                <div class="row company-row">
                                    <div class="col-12 company-renewal">
                                        <span>{{ trans('index.user_company_profile_phrase31') }} </span>
                                        {{  $company->expire }}
                                    </div>
                                </div>
                                <div class="row company-row">
                                    <div class="col-12 company-size">
                                        <span>{{ trans('index.user_company_profile_phrase10') }} </span>
                                        <div id="company_plan_editor" data-admin="1" data-site_currency="{{  config('app.SITE_CURRENCY_SYMBOL') }}"
                                            data-site_currency_symbol="{{ config('app.SITE_CURRENCY_SYMBOL') }}" data-company="{{  $company->id }}"
                                            class="editor">
                                            @if (!$company->package_id )
                                                {{ trans('index.user_company_profile_phrase32') }}
                                                <a href="{{route('company.module', [app()->getLocale(), $company->id])}}"
                                                    class="btn btn-light-primary  btn-sm">
                                                    <i class="fas fa-edit"></i> {{ trans('index.user_company_profile_phrase11') }}
                                                </a>
                                            @else
                                                <a href="{{route('company.module', [app()->getLocale(), $company->id])}}"
                                                    class="btn btn-light-primary  btn-sm">
                                                    <i class="fas fa-edit"></i> {{ trans('index.user_company_profile_phrase11') }}
                                                </a>
                                                <div class="company-package-ctn">
                                                    <div class="company-single-package" data-package_id="{{  $company->package_id }}">
                                                        <div class="price">
                                                            <br> <span class="value">{{  config('app.SITE_CURRENCY_SYMBOL'). !empty($package_data) ? $package_data->price : '' }}</span><br>
                                                            <span class="currency">{{  config('app.SITE_CURRENCY_SYMBOL') }} /
                                                                {{ trans('index.user_company_profile_phrase34') }}</span>
                                                        </div>
                                                        <div class="name">
                                                            <label>{{ trans('index.user_company_profile_phrase6') }} </span>
                                                                <span class="value">{{  $package_content->name }}</span>
                                                        </div>
                                                        <div class="user">
                                                            <label>{{ trans('index.user_company_profile_phrase33') }} </span>
                                                                <span class="value">{{  $package_data->user }}</span>
                                                        </div>
                                                        <div class="details">
                                                            {{  $package_content->details }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row company-row">
                                    <div class="col-8 company-report-text">
                                        <label class="company-label" style="float: none;">{{ trans('index.user_company_profile_phrase35') }} </label>
                                        <div id="company_report_text_editor" data-company_id="{{  $company->id }}">
                                            <textarea id="company_report_text_input" name="report_content" rows="4" class="form-control">{{  !empty($report_content->content) ? $report_content->content: '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="company-label" style="float: none;">Text Language </label>
                                        <select id="company_report_text_lang" name="language_id" class="form-control mt-1">
                                            @forelse ($languages as $language_)
                                                <option value="{{$language_->id}}" {{ ($language_->id == $language->id) ? "selected": "" }}>{{ $language_->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <span></span>
                                    <span class="text-danger validation_errors report_content_err"></span>
                                </div>
                                <div class="row company-row">
                                    <div class="col-12 company-action">
                                        <input type="hidden" name="user" value="{{$company_owner->id}}">
                                        <span>{{ trans('index.user_company_profile_phrase14') }} </span>
                                        <button id="company_report_text_save" type="submit"
                                            class="btn btn-success btn-sm mb-1 mt-1 mr-1"><i class="fas fa-save"></i>
                                            {{ trans('index.user_company_profile_phrase36') }}
                                        </button>
                                        @if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support')
                                            @if ($company->status == 'pending' || $company->status == 'suspended')
                                                <a id="company_activate" class="btn btn-light-success btn-sm" data-company="{{ route('company.activate', [app()->getLocale(), $company->id]) }}">
                                                    <i class="fas fa-edit"></i> {{ trans('index.user_company_profile_phrase15') }}
                                                </a>
                                            @elseif ($company->status == 'active')
                                                <a id="company_suspend" class="btn btn-light-warning btn-sm" data-company="{{ route('company.suspend', [app()->getLocale(), $company->id]) }}">
                                                    <i class="fas fa-pause"></i> {{ trans('index.user_company_profile_phrase16') }}
                                                </a>
                                            @endif
                                            @if (time() > strtotime($company->expire . " - " . config('app.COMPANY_RENEW_TIME')))
                                                <a id="company_renew" class="btn btn-light-dark btn-sm" data-company="{{ route('company.renew', [app()->getLocale(), $company->id]) }}">
                                                    <i class="fas fa-redo"></i> {{ trans('index.user_company_profile_phrase17') }}
                                                </a>
                                            @endif

                                            @php
                                                $currentDate = \Carbon\Carbon::now();
                                                $expiryDate = \Carbon\Carbon::parse($company->expire);
                                                $diff = $expiryDate->diffInDays($currentDate);
                                            @endphp

                                            @if ($diff > 90)
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['company.destroy', [app()->getLocale(), $company->id]]]) !!}
                                                {!! Form::button('<i class="fas fa-trash"></i> '.trans('index.user_company_profile_phrase18'), [
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-sm del_ delete',
                                                    'id' => route('company.destroy', [app()->getLocale(), $company->id]),
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#myModalDelete',
                                                ]) !!}
                                                {!! Form::close() !!}
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support')
                    <div class="row user-content-row">
                        <div class="col-12 company">
                            <div class="company-widget-title">{{ trans('index.user_company_profile_phrase19') }}</div>
                            <div class="company-user-ctn">
                                @forelse ($company_users as $company_user)
                                    <div class="user-card">
                                        <div class="row">
                                            <div class="col-8">
                                                <label class="user-card-title">{{ trans('index.user_company_profile_phrase20') }} </span>
                                                    <a
                                                        href="/user/index.php?route=profile&id={{  $company_user->id }}">
                                                        <div class="user-card-name"> {{  $company_user->name }} </div>
                                                    </a>
                                            </div>
                                            <div class="col-4">
                                                <label class="user-card-title">{{ trans('index.user_company_profile_phrase21') }} </span>
                                                    <div class="user-card-id"> {{  $company_user->id }} </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if ($user->user_type == 'admin_super' && $company_user->id != $company_owner->id)
                                                <div class="col-8">
                                                    <label class="user-card-title">{{ trans('index.user_company_profile_phrase22') }} </span>
                                                        <div class="user-card-email"> {{  $company_user->email }} </div>
                                                </div>
                                                <div class="col-4">
                                                    {!! Form::open(['method' => 'DELETE','route' => ['company.users.destroy', [app()->getLocale(), $company_user->id]],'style'=>'display:inline']) !!}
                                                    {!! Form::submit( 'delete', ['class' => 'btn btn-danger btn-sm del_ delete', 'id' => route('company.users.destroy', [app()->getLocale(), $company_user->id]), 'data-toggle' => 'modal', 'data-target' => '#myModalDelete']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            @else
                                                <div class="col-12">
                                                    <label class="user-card-title">{{ trans('index.user_company_profile_phrase22') }} </span>
                                                        <div class="user-card-email"> {{  $company_user->email }} </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                                <div class="row company-row" style="margin: 15px 0px;">
                                    <div class="col-12 company-action">
                                        <span>{{ trans('index.user_company_profile_phrase14') }} </span>
                                        <button id="company_add_user" onclick="add_company_user()"
                                            class="btn btn-light-primary btn-sm" data-company="{{  $company->id }}">
                                            <i class="fas fa-edit"></i> {{ trans('index.user_add_test') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div style="">
                                <div class="w3-modal" style="margin: 15px 0px; display:none" id="delete_user_content">
                                    <div class="modal-content">
                                        <div class="container">
                                            <form action="{{ route('company.users.add.post', ['lang'=>app()->getLocale()]) }}" method="POST" id="regCompAjax">
                                                @csrf
                                                <div class="form-group form-row">
                                                    <!-- <label>Name</span> -->
                                                    <input type="text" class="form-control" name="name"
                                                        id="" placeholder="{{ trans('index.index_phrase9') }}">
                                                    <span class="text-danger validation_errors name_err"></span>
                                                </div>
                                                <div class=" form-group form-row">
                                                    <!-- <label>Email address</span> -->
                                                    <input type="email" class="form-control" name="email" id=""
                                                        placeholder="{{ trans('index.index_phrase10') }}">
                                                    <span class="text-danger validation_errors email_err"></span>
                                                </div>
                                                <div class=" form-group form-row">
                                                    <!-- <label>Telephone</span> -->
                                                    <input type="tel" class="form-control" name="phone"
                                                        id="" placeholder="{{ trans('index.index_phrase12') }}">
                                                    <span class="text-danger validation_errors phone_err"></span>
                                                </div>
                                                <div class=" form-group form-row">
                                                    <label class="radio-inline">Need approval?</label>
                                                    <label class="radio-inline"><input class="ml-2" type="radio" name="approve_per"
                                                            value="1">Yes</label>
                                                    <label class="radio-inline"><input class="ml-2" type="radio" name="approve_per"
                                                            value="0">No</label>
                                                    <span class="text-danger validation_errors approve_per_err"></span>
                                                </div>
                                                <div class=" form-group form-row">
                                                    <!-- <label>Password</span> -->
                                                    <input type="password" class="form-control" name="password"
                                                        id="" placeholder="{{ trans('index.index_phrase11') }}">
                                                    <span class="text-danger validation_errors password_err"></span>
                                                </div>
                                                <div class=" form-group form-row">
                                                    <!-- <label>Cirform Password</span> -->
                                                    <input type="password" class="form-control" name="password_confirmation"
                                                        id=""
                                                        placeholder="{{ trans('index.index_phrase19') }}">
                                                    <span class="text-danger validation_errors password_confirmation_err"></span>
                                                </div>
                                                <input type="hidden" class="form-control" name="company_id"
                                                        id=""
                                                        placeholder="" value="{{ $company->id }}">
                                                <div class="button-holder">
                                                    <button type="submit" class="btn btn-primary" id="">Add
                                                    </button>&nbsp;
                                                    <input id="btn-close" type="button" onclick="add_company_user()"
                                                        class="btn btn-info" value="Close">
                                                    <div></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @elseif ($user->user_type == 'company_owner')

    @else
        {{ trans->phrase("index.user_company_profile_phrase23") }}
    @endif
@endsection
