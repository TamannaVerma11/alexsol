@extends('front._layouts.app')

@section('content')
    <div class="row login-parent">
        <div class="col-12">
            <div class="row">
                <div class="col-12 login-logo">
                    <img src="{{ url('images/logo-transparent.png') }}" class="img-fluid" title="Main Logo">
                </div>
            </div>
            <div id="message_success">

            </div>
            <div class="row login-ctn-new">
                <div class="col-2"></div>
                <div class="col-8 login-form" id="login_form">
                    <form action="{{ route('login.post', ['lang'=>app()->getLocale()]) }}" method="POST" id="loginAjax">
                        @csrf

                        <div id="login_errors-list"></div>

                        <div class="form-group mb-3">
                            <input type="email" name="email" required autofocus id="login_email"
                                class="form-control login-input" placeholder="{{ trans('index.index_phrase1') }}">
                            <span class="text-danger validation_errors email_err"></span>
                        </div>

                        <div class="form-group">
                            <input type="password" id="login_password" required name="password" class="form-control login-input"
                                placeholder="{{ trans('index.index_phrase2') }}">
                            <span class="text-danger validation_errors password_err"></span>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label style="display: flex;margin-bottom: 0.5rem;align-items: center;gap: 1rem;"><input
                                        type="checkbox" id="as_consultant" name="as_consultant" value="">
                                    <font style="color: white;">Do you wanted to company login as consultant?</font>
                                </label>
                                <label style="margin-top: -12%;display: flex;margin-bottom: 0.5rem;align-items: center;gap: 1rem;">
                                    <input
                                        type="checkbox" name="remember" id="remember" value="">
                                    <font style="color: white;">Remember Me</font>
                                </label>
                            </div>
                        </div>

                        <div class="login-buttons" style="text-align:center;">
                            <a href="javascript:void(0)" class="login-rel-btn"
                                id="signup_consultant_now">{{ trans('index.index_phrase31') }}</a> | <a
                                href="javascript:void(0)" class="login-rel-btn"
                                id="signup_now">{{ trans('index.index_phrase4') }}</a>
                            <div>
                                <a href="javascript:void(0)" class="login-rel-btn"
                                    id="forgot_password">{{ trans('index.index_phrase3') }}</a>
                            </div>
                            <input type="submit" id="login_button" class="login-button btn btn-default btn-success"
                                value="{{ trans('index.index_phrase5') }}">
                            <a href="javascript:void(0)" id="pricing_list" class="login-rel-btn"
                                onclick="showPricing('{{ trans('index.text_close') }}')">
                                {{ trans('index.text_pricing') }}
                            </a>
                        </div>
                        <p class="support-text">Ring support på <a href="tel:62 94 90 00">62 94 90 00</a> om du har
                            spørsmål
                            eller trenger hjelp.</p>
                    </form>
                    <div id="login_status" class="status"></div>
                </div>

                <div class="col-8 forgot-pass-form" id="forgot_pass_form">
                    <form action="{{ route('forgotPassword.post', ['lang'=>app()->getLocale()]) }}" method="POST" id="forgotPassAjax">
                        @csrf

                        <div id="forgotPass_errors-list"></div>

                        <div class="">
                            <div class="text-white d-flex align-items-center">
                                <div class="d-flex align-items-center mr-2 mr-md-4 mr-lg-5">
                                    <input class="mr-1 mr-md-2" type="radio" name="tfa_type" id="tfa_email" value="email"
                                        checked oninput="checkTfaType()" />
                                    <label for="tfa_email">Email</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input class="mr-1 mr-md-2" type="radio" name="tfa_type" id="tfa_phone" value="phone"
                                        oninput="checkTfaType()" />
                                    <label for="tfa_phone">Phone</label>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="forgot_pass_email" class="form-control forgot-pass-input d-none"
                                placeholder="{{ trans('index.index_phrase6') }}">
                                <span class="text-danger validation_errors email_err"></span>
                            <input type="tel" name="phone" id="forgot_pass_phone" class="form-control forgot-pass-input d-none"
                                placeholder="{{ trans('index.index_phrase32') }}">
                                <span class="text-danger validation_errors phone_err"></span>
                        </div>
                        <div class="forgot-pass-buttons">
                            <a href="javascript:void(0)" id="forgot_pass_login">{{ trans('index.index_phrase7') }}</a>
                            <input type="submit" id="forgot_pass_button"
                                class="forgot-pass-button btn btn-default btn-danger">
                        </div>
                    </form>
                    <div id="forgot_pass_status" class="status"></div>
                </div>

                <div class="col-12 col-sm-7 signup-form" id="signup_form">
                    <form action="{{ route('userRegister.post', ['lang'=>app()->getLocale()]) }}" method="POST" id="regUserAjax">
                        @csrf

                        <div id="userReg-errors-list"></div>

                        <div class="form-group mb-3">
                            <input type="text" id="signup_username" name="name" class="form-control signup-input"
                                placeholder="{{ trans('index.index_phrase9') }}">
                            <span class="text-danger validation_errors name_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" name="email" id="signup_email" class="form-control signup-input"
                                placeholder="{{ trans('index.index_phrase10') }}">
                            <span class="text-danger validation_errors email_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" id="signup_phone" name="phone" class="form-control signup-input"
                                placeholder="{{ trans('index.index_phrase12') }}">
                            <span class="text-danger validation_errors phone_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" id="signup_password" name="password" class="form-control signup-input"
                                placeholder="{{ trans('index.index_phrase11') }}">
                            <span class="text-danger validation_errors password_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" id="signup_confirm_password" name="password_confirmation" class="form-control signup-input"
                                placeholder="{{ trans('index.index_phrase19') }}">
                            <span class="text-danger validation_errors password_confirmation_err"></span>
                        </div>

                        <div class="form-group">
                            <!--<input type="text" id="signup_company" class="form-control signup-input"
                                            placeholder="{{ trans('index.index_phrase13') }}">-->
                            <select id="signup_company" name="company_id" class="form-control signup-input">
                                <option value="" disabled>{{ trans('index.index_phrase13') }}</option>
                                @forelse ($companies as $company)
                                    <option value="{{$company->id}}">{{ $company->name}}</option>
                                @empty
                                @endforelse
                            </select>
                            <span class="text-danger validation_errors company_id_err"></span>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="signup_terms">
                            <label class="form-check-label signup-terms-label"
                                for="signup_terms">{{ trans('index.index_phrase25') }} <a
                                    href="{{route('tos', app()->getLocale())}}">{{ trans('index.index_phrase26') }}</a>.</label>
                        </div>
                        <div class="signup-buttons">
                            <a href="javascript:void(0)" id="login_to_account">{{ trans('index.index_phrase14') }}</a> |
                            <a href="javascript:void(0)" id="register_company">{{ trans('index.index_phrase15') }}</a>
                            <input type="submit" id="signup_button" class="signup-button btn btn-success" />
                        </div>
                    </form>
                    <div id="signup_status" class="status"></div>
                </div>

                <div class="col-12 col-sm-7 consultant-form" id="signup_consultant_form">
                    <form action="{{ route('consultantRegister.post', ['lang'=>app()->getLocale()]) }}" method="POST" id="regConsAjax">
                        @csrf

                        <div id="consultantReg-errors-list"></div>

                        <div class="form-group mb-3">
                            <input type="text" id="consultant_username" name="name" class="form-control consultant-input"
                                placeholder="{{ trans('index.index_phrase9') }}">
                            <span class="text-danger validation_errors name_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" name="email" id="consultant_email" class="form-control consultant-input"
                                placeholder="{{ trans('index.index_phrase10') }}">
                            <span class="text-danger validation_errors email_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" name="phone" id="consultant_phone" class="form-control consultant-input"
                                placeholder="{{ trans('index.index_phrase12') }}">
                            <span class="text-danger validation_errors phone_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password" id="consultant_password" class="form-control consultant-input"
                                placeholder="{{ trans('index.index_phrase11') }}">
                            <span class="text-danger validation_errors password_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password_confirmation" id="consultant_confirm_password" class="form-control consultant-input"
                                placeholder="{{ trans('index.index_phrase19') }}">
                            <span class="text-danger validation_errors password_confirmation_err"></span>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="consultant_terms">
                            <label class="form-check-label signup-terms-label"
                                for="consultant_terms">{{ trans('index.index_phrase25') }}
                                <a href="tos.php">{{ trans('index.index_phrase26') }}</a>.</label>
                        </div>
                        <div class="signup-buttons">
                            <a href="javascript:void(0)"
                                id="consultant_login_to_account">{{ trans('index.index_phrase14') }}</a> | <a
                                href="javascript:void(0)"
                                id="consultant_register_company">{{ trans('index.index_phrase15') }}</a>
                            <input type="submit" id="consultant_signup_button" class="signup-button btn btn-success" />
                        </div>
                    </form>
                    <div id="consultant_status" class="status"></div>
                </div>

                <div class="col-12 col-sm-7 register-company-form" id="register_company_form">
                    <form action="{{ route('companyRegister.post', ['lang'=>app()->getLocale()]) }}" method="POST" id="regCompAjax">
                        @csrf

                        <div id="companyReg-errors-list"></div>

                        <div class="form-group mb-3">
                            <input type="text" id="register_company_name" name="company_name" class="form-control register-company-input"
                                placeholder="{{ trans('index.index_phrase17') }}">
                            <span class="text-danger validation_errors company_name_err"></span>
                        </div>
                        <div class="checkbox">
                            <label style="display: flex;margin-bottom: 0.5rem;align-items: center;gap: 1rem;"><input
                                    type="checkbox" name="as_consultant" id="as_consultant" value="">
                                <font style="color: white;">As consultant</font>
                            </label>
                        </div>
                        <div class="form-group mb-3">
                            <select id="register_company_industry_type" name="industry_type" class="form-control register-company-input">
                                <option value="" disabled>{{ trans('index.index_phrase28') }}</option>
                                @forelse ($industry_types as $industry_type)
                                    <option value="{{$industry_type->id}}">{{$industry_type->name}}</option>
                                @empty
                                @endforelse
                            </select>
                            <span class="text-danger validation_errors industry_type_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" id="register_company_email" name="email" class="form-control register-company-input"
                                placeholder="{{ trans('index.index_phrase18') }}">
                            <span class="text-danger validation_errors email_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" id="register_company_phone" name="phone" class="form-control register-company-input"
                                placeholder="{{ trans('index.index_phrase20') }}">
                            <span class="text-danger validation_errors phone_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password" id="register_company_password"
                                class="form-control register-company-input"
                                placeholder="{{ trans('index.index_phrase11') }}">
                            <span class="text-danger validation_errors password_err"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" id="register_company_confirm_password"
                                class="form-control register-company-input"
                                placeholder="{{ trans('index.index_phrase19') }}">
                            <span class="text-danger validation_errors password_confirmation_err"></span>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="register_company_terms">
                            <label class="form-check-label register-company-terms-label"
                                for="register_company_terms">{{ trans('index.index_phrase25') }} <a
                                    href="tos.php">{{ trans('index.index_phrase26') }}</a>.</label>
                        </div>
                        <div class="register-company-buttons">
                            <a href="javascript:void(0)"
                                id="company_login_to_account">{{ trans('index.index_phrase22') }}</a> | <a
                                href="javascript:void(0)" id="company_signup_now">{{ trans('index.index_phrase23') }}</a>
                            <input type="submit" id="register_company_button" class="signup-button btn btn-success" />
                        </div>
                    </form>
                    <div id="register_company_status" class="status"></div>
                </div>

                <div class="col-8 pin-code-form" id="pin_code_form">
                    <form>
                        <div class="form-group">
                            <input type="hidden" id="user_type_logged_in" value="<?php /*aysenur burak $_SESSION['user_type_logged_in']*/ ?>">
                            <input type="hidden" id="user_id_logged_in" value="<?php /* aysenur burak $_SESSION['user_id_logged_in']*/ ?>">
                            <input type="text" id="pin_code" class="form-control pin-code-input"
                                placeholder="{{ trans('index.index_phrase30') }}">
                        </div>
                        <div class="pin-code-buttons">
                            <a href="javascript:void(0)" id="forgot_pass_login">{{ trans('index.index_phrase7') }}</a>
                            <input type="submit" id="submit_pin_code_button" class="pin-code-button btn btn-success">
                        </div>
                    </form>
                    <div id="code_pin_status" class="status"></div>
                </div>

                <div class="col-2"></div>
            </div>
        </div>
    </div>


    <div id="divPricing" class="w3-modal">
    </div>

    <div id="cookieConsent">
        <div id="closeCookieConsent">
            <span style="margin-right:10px"><i class="fa fa-times"></i></span>
        </div>
        <div>&nbsp;</div>
        <div>
            Ved å akseptere godtar du at denne nettsiden bruker informasjonskapsler (cookies) for å forbedre din
            brukeropplevelse på siden.
        </div>
        <div>&nbsp;</div>
        <div>
            <a href="javascript:void(0)" id="cookieAccept" class="btn btn-primary">Aksepter</a>
            <a href="javascript:void(0)" id="noThanks" class="btn btn-danger">Nei takk</a>
        </div>


    </div>
@endsection
