
@extends('front._layouts.app')

@section('content')

    <div class="row login-parent">
        <div class="col-12">
            <div class="row">
                <div class="col-12 login-logo">
                    <img src="{{url('/images/logo-transparent.png')}}" class="img-fluid" title="Main Logo">
                </div>
            </div>
            <div class="row login-ctn-new">
                <div class="col-2"></div>
                <div class="col-8 login-form">
                    <form action="{{ route('company.users.invite_accepted.post', ['lang'=>app()->getLocale()]) }}" method="POST" id="inviteAcceptAjax">
                        @csrf

                        <div class="form-group mb-3">
                            <input type="text" class="form-control login-input"
                                   name="code"
                                   placeholder="Invitation Code"/>
                            <span class="text-danger validation_errors code_err"></span>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control login-input"
                                   name="password"
                                   placeholder="Password">
                            <span class="text-danger validation_errors password_err"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control login-input"
                                   name="password_confirmation"
                                   placeholder="Confirm Password">
                            <span class="text-danger validation_errors password_confirmation_err"></span>
                        </div>
                        <input type="hidden" class="form-control" name="invite_id" value="{{ $invitation->id }}">
                        <div class="login-buttons mt-4" style="text-align:center;">
                            <input type="submit" class="login-button btn btn-default btn-success" name=""
                                   value="Login">
                        </div>
                    </form>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </div>
@endsection
