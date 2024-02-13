@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3" id="invite_form_holder" style="display: none">
            <div class="service-area style-two">
                <div class="container-fluid">
                    <div class="row company-row row-50">
                        <div class="col-12 company-password change-password-container">
                            <span class="company-label pass_label">Invite User</span>
                            <form action="{{ route('company.users.invite.post', ['lang'=>app()->getLocale()]) }}" method="POST" id="regInviteAjax">
                                @csrf

                                <input type='text' id='full_name_input_holder' name="name"
                                    class="col-sm-12 form-fields" placeholder='Full name'>
                                <span class="text-danger validation_errors name_err"></span>
                                <input type='email' id='email_input_holder' name="email" class="col-sm-12 form-fields"
                                    placeholder='Email'>
                                <span class="text-danger validation_errors email_err"></span>
                                <input type='tel' id='phone_input_holder' name="phone" class="col-sm-12 form-fields"
                                    placeholder='Phone number'>
                                <span class="text-danger validation_errors phone_err"></span>
                                <input type="hidden" class="form-control" name="company_id" value="{{ $company->id }}">
                                <div class="col-sm-12 d-flex">
                                    <input class='btn btn-success btn-sm form-button' id='' type="submit"
                                        value="invite" name="">
                                    <span onclick="add_show_invite()" class='btn btn-danger btn-sm form-button ms-3'>Cancel
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="fs-5 btn btn-primary px-4 ms-4 mt-3" style="width: fit-content" onclick="add_show_invite()">Add new
            Invitation</div>
        <div class="card-body p-3">
            <table class="table table-striped">
                <thead class="bg-primary">
                    <tr>
                        <th scope="col">
                            <h4 style="color:white; margin-left: 20px;">{{ trans('index.user_sidebar_phrase18') }} </h4>

                        </th>
                        <th scope="col" colspan="4" style="text-align:right;">
                            <h5 style="color:white; margin-right: 20px">
                                {{ !empty($company->name) ? trans('index.index_phrase17') . ' : ' . $company->name : '' }}
                            </h5>
                        </th>
                    </tr>
                </thead>
                <thead class="bg-secondary">
                    <tr style="margin-top:10px !important;">
                        <th scope="col">&nbsp; Invitation ID</th>
                        <th scope="col">{{ trans('index.user_composer_phrase13') }}</th>
                        <th scope="col">{{ trans('index.index_phrase1') }}</th>
                        <th scope="col">{{ trans('index.index_phrase12') }}</th>
                        <th scope="col">Invitation Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($invited_users as $invited_user)
                        <tr>
                            <th class="pull-right">{{ $invited_user->id }}</th>
                            <td>{{ $invited_user['name'] }}</td>
                            <td>{{ $invited_user['email'] }}</td>
                            <td>{{ $invited_user['phone'] }}</td>
                            <td>{{ $invited_user['status'] ? 'Accepted' : 'Not Accepted' }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex">
                {!! $invited_users->links() !!}
            </div>
        </div>
    </div>

@endsection
