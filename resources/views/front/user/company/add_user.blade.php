@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="container-fluid">
                <div class="row user-content-row">
                    <div class="col-12 company">
                        <div class="company-widget-title">{{ trans('index.user_company_profile_phrase19') }}</div>
                        <div class="company-user-ctn">
                            <div class="row company-row" style="margin: 15px 0px;">
                                <!--  <div class="col-12 company-action">
                                    <span>{{ trans('index.user_company_profile_phrase14') }} </span>
                                    <button id="company_add_user" onclick="add_company_user()" class="btn btn-light-primary btn-sm" data-company="{{ $company['company_id'] }}">
                                        <i class="fas fa-edit"></i> Add User</button>
                                </div> -->
                            </div>
                            <div style="">
                                <div class="w3-modal" style="margin: 15px 0px;" id="delete_user_content">
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
                                                    <button class="btn btn-primary" id="">Add
                                                    </button>&nbsp;
                                                    <button id="btn-close" onclick="add_company_user()"
                                                        class="btn btn-info">Close
                                                    </button>
                                                    <div></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
