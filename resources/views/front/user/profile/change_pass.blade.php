@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="service-area style-two">
                <div class="container-fluid">
                    <div class="row user-row row-50">
                        <div class="col-12 user-password change-password-container">
                            <span class="user-label pass_label">{{ trans('index.user_profile_phrase6') }} </span>
                            <div id="user_pass_editor" data-user="{{  $user->id }}" class="editor">
                                <form action="{{ route('user.password.update', ['lang'=>app()->getLocale()]) }}" method="POST" id="updatePasswordAjax">
                                    @csrf
                                    <input type='password' name='current_pass' id='user_pass_editor_old' class="col-sm-12 form-fields"
                                        placeholder='{{ trans('index.user_js_phrase1') }}'>
                                    <span class="text-danger  validation_errors current_pass_err"></span>
                                    <input type='password' name='new_password' id='user_pass_editor_new' class="col-sm-12 form-fields"
                                        placeholder='{{ trans('index.user_js_phrase2') }}'>
                                    <span class="text-danger  validation_errors new_password_err"></span>
                                    <input type='password' name='new_password_confirmation' id='user_pass_editor_confirm' class="col-sm-12 form-fields"
                                        placeholder='{{ trans('index.user_js_phrase3') }}'>
                                    <span class="text-danger  validation_errors new_password_confirmation_err"></span>
                                    <div class="mybutton col-sm-12">
                                        <button id='user_pass_save' class='btn btn-success btn-sm form-button'>
                                            {{ trans('index.save_btn') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
