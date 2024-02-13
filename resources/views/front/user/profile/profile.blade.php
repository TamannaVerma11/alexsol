@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="service-area style-two">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ab-title text-left">
                                <h3>Edit Profile</h3>
                                <h4></h4>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="ab-content">

                                <!--<form id="myuserprofilecustom" enctype="multipart/form-data">
                                            <div class="row clearfix">
                                                <div class="statusMsg"></div>
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <span>{{ trans('index.user_profile_phrase2') }}</span>
                                                    <input type="text" id="user_name_editor_input" name="user_name_editor_input"
                                                           value="{{  $user->name }}">
                                                </div>
                                                <div class="clearfix"></div>
                                                <input type="hidden" id="user_email_editor_old"
                                                       value="{{  $user->email }}" name="user_email_editor_old">

                                                <input type="hidden" id="user_id_input"
                                                       value="{{  $user->id }}" name="user_id_input">
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <span>{{ trans('index.user_profile_phrase4') }}</span>
                                                    <input type="email" id="user_email_editor_input"
                                                           value="{{  $user->email }}">
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-6 col-sm-12 form-group">
                                                    <span>{{ trans('index.user_profile_phrase5') }}</span>
                                                    <input type="text" id="user_company_name_input"
                                                           value="{{ !empty($company->name) ? $company->name : '' }}" name="user_company_name_input" disabled >
                                                </div>
                                                <input type="hidden" id="update_user_data"
                                                           name="sign" value="update_user_data">
                                                <div class="clearfix"></div>
                                                 <div class="col-md-6 col-sm-12 form-group">
                                                        <span>Profile Picture</span>
                                                        <input type="file" class="form-control" name="user_profile" id="user_profile"><br><p style="color:red" id="prouploadtext"></p>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                    <input type="submit" name="submit" id="user_update_btn_submit" class="theme-btn btn-style-two view-button" value="Save"/>
                                                    <button class="theme-btn btn-style-two view-button" id="user_update_btn_submit"><span class="txt">Save</span></button>
                                                </div>

                                            </div>
                                        </form>-->
                                <!--<form id="fupForm" enctype="multipart/form-data">-->
                                <form action="{{ route('user.profile.update', ['lang'=>app()->getLocale()]) }}" enctype="multipart/form-data" method="POST" id="updateProfilAjax">
                                    @csrf
                                    <div class="statusMsg"></div>
                                    <div class="form-group">
                                        <span>{{ trans('index.user_profile_phrase2') }}</span>
                                        <input type="text" id="user_name_editor_input" name="name"
                                            value="{{  $user->name }}">
                                        <span class="text-danger  validation_errors name_err"></span>
                                    </div>
                                    <div class="form-group">
                                        <span>{{ trans('index.user_profile_phrase4') }}</span>
                                        <input type="email" id="user_email_editor_input" name="email"
                                            value="{{  $user->email }}">
                                        <span class="text-danger  validation_errors email_err"></span>
                                    </div>
                                    <div class="form-group">
                                        <span>{{ trans('index.user_profile_phrase5') }}</span>
                                        <input type="text" id="user_company_name_input" value="{{  !empty($company->name) ? $company->name : '' }}"
                                            name="company_name" disabled>
                                        <span class="text-danger  validation_errors company_name_err"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">Profile picture:</label>
                                        <input type="file" class="form-control" accept="image/*" id="file" name="profile_img" />
                                        @if(!empty($user->profile_img))
                                            <div class="col-6" id="preview">
                                                <img src="{{  url($user->profile_img) }}"
                                                    alt="Profile logo" style="width: 100%;">
                                            </div>
                                        @else
                                            <div class="col-6" id="preview">
                                            </div>
                                        <p class="alert alert-danger">{{ trans('index.no_profile') }}</p>
                                        @endif
                                    </div>
                                    <input type="hidden" id="user_id_input" name='user' value="{{  $user->id }}"
                                        name="user_id_input">

                                    <input type="submit" name="submit" class="btn btn-primary submitBtn"
                                        value="SUBMIT" />
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
