@extends('front._layouts.app')

@section('content')
    <div class="row login-parent">
        <div class="col-12">
            <div class="row login-ctn" style="color: white">
                <div class="col-12 col-sm-7 pass-reset-form" id="pass_reset_form">
                    <form action="
                    @if ($usr == 'user')
                        {{ route('updatePassword.post', ['lang' => app()->getLocale()]) }}
                    @elseif($usr == 'admin')
                        {{ route('adminUpdatePassword.post', ['lang' => app()->getLocale()]) }}
                    @endif
                    " method="POST"
                        id="updatePassAjax">
                        @csrf

                        <div id="updatePass_errors-list"></div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <input type="email" name="email" id=""
                                class="form-control pass-reset-input" placeholder="{{ trans('index.index_phrase1') }}">
                        </div>
                        <span class="text-danger validation_errors email_err"></span>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <input type="text" name="verification_code" id="new_pass"
                                class="form-control pass-reset-input" placeholder="Verification Code">
                        </div>
                        <span class="text-danger validation_errors verification_code_err"></span>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <input type="password" name="password" id="new_pass" class="form-control pass-reset-input"
                                placeholder="{{ trans('index.password_reset_phrase2') }}">
                        </div>
                        <span class="text-danger validation_errors password_err"></span>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <input type="password" id="confirm_pass" name="password_confirmation"
                                class="form-control pass-reset-input"
                                placeholder="{{ trans('index.password_reset_phrase3') }}">
                        </div>
                        <span class="text-danger validation_errors password_confirmation_err"></span>

                        <div class="pass-reset-buttons">
                            <button type="submit" id="pass_reset_button"
                                class="pass-reset-button btn btn-dark btn-sm">{{ trans('index.password_reset_phrase4') }}</button>
                        </div>
                    </form>
                    <div id="pass_reset_status" class="status"></div>
                </div>
                <div class="col-12 col-sm-5 login-logo">
                    <img src="{{ url('images/logo-transparent.png') }}" class="img-fluid" title="Main Logo">
                </div>
            </div>
        </div>
    </div>
@endsection
