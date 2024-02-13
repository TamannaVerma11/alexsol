@extends('front.user.layouts.app')

@section('content')

<div class="card">
    <div class="card-body p-3">
        <div class="row user-content-row">
            <div class="col-12 support">
                <div class="support-widget-title">
                    {{ trans("index.user_support_phrase1") }}
                </div>
                <div class="support-info-ctn">
                    <div class="row support-row">
                        <div class="col-12 support-email">
                            <label class="support-label">{{ trans("index.user_support_phrase2") }} </label>
                            <div id="support_email_editor" class="support-editor">
                                {{ ($support_info['support_email']) ? $support_info['support_email']: '' }}
                                @if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support')
                                    <button id="support_email_editor_button" class="btn btn-light-primary btn-sm">
                                        <i class="fas fa-edit"></i> {{ trans("index.user_support_phrase3") }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row support-row">
                        <div class="col-12 support-phone">
                            <label class="support-label">{{ trans("index.user_support_phrase4") }} </label>
                            <div id="support_phone_editor" class="support-editor">
                                {{ ($support_info['support_phone']) ? $support_info['support_phone']: '' }}
                                @if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support')
                                    <button id="support_phone_editor_button" class="btn btn-light-primary btn-sm">
                                        <i class="fas fa-edit"></i> {{ trans("index.user_support_phrase3") }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row support-row">
                        <div class="col-12 profile-address">
                            <label class="support-label">{{ trans("index.user_support_phrase5") }} </label>
                            <div id="support_address_editor" class="support-editor">
                                {{ ($support_info['support_address']) ? $support_info['support_address']: '' }}
                                @if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support')
                                    <button id="support_address_editor_button" class="btn btn-light-primary btn-sm">
                                        <i class="fas fa-edit"></i> {{ trans("index.user_support_phrase3") }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($user->user_type == 'user' || $user->user_type == 'company_owner')
                    <div class="row support-row">
                        <div class="col-12 support-message">
                            <div class="support-message-title">{{ trans('index.user_support_phrase6') }}
                            </div>
                            <form action="{{ route('support.store', ['lang'=>app()->getLocale()]) }}" method="POST" id="addSupAjax">
                                @csrf
                                <div class="form-group">
                                    <label
                                        for="support_message_subject">{{ trans('index.user_support_phrase7') }}</label>
                                    <input type="text" id="support_message_subject" name="subject" class="form-control">
                                    <span class="text-danger  validation_errors subject_err"></span>
                                </div>
                                <div class="form-group">
                                    <label
                                        class="support_message_content">{{ trans('index.user_support_phrase8') }}</label>
                                    <textarea id="support_message_content" name="message" class="form-control"></textarea>
                                    <span class="text-danger  validation_errors message_err"></span>
                                </div>
                                <button type="submit" id="" class="btn btn-info">
                                    <i class="fas fa-paper-plane"></i>
                                    {{ trans('index.user_support_phrase9') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row user-content-row">
            <div class="col-12 support">
                <div class="support-widget-title">
                    {{ trans("index.user_support_phrase10") }}
                </div>
                @forelse ($support_request as $support)
                    @php
                        $user_data = \App\Models\User::find($support->user_id);
                    @endphp
                    <div class="support-card">
                        <div class="row">
                            <div class="col-12 support-card-subject">
                                <label class="support-card-title">{{ trans('index.user_support_phrase11') }}
                                </label>
                                <a href="{{ route('support.show', [app()->getLocale(), $support->id ]) }}">
                                    {{ $support->subject }}
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 support-card-text">
                                @php
                                    $support_content = '';
                                    $decode_support_message = htmlspecialchars_decode( $support->message, ENT_QUOTES);
                                @endphp
                                @if(strlen($decode_support_message) > 100)
                                    {{ substr(strip_tags($decode_support_message), 0, 100)."..." }}
                                @else
                                    {{ strip_tags($decode_support_message) }}
                                @endif
                            </div>
                        </div>
                        <div class="row support-card-info">
                            <div class="col-5">
                                <i class="fas fa-user"></i>
                                {{ (!empty($user_data->name)) ? $user_data->name : '' }}
                            </div>
                            <div class="col-4">
                                <i class="fas fa-clock"></i>
                                {{ date("d-m-Y", strtotime($support->created_at)) }}
                            </div>
                            <div class="col-3">
                                <i class="fas fa-hashtag"></i>
                                {{ $support->id }}
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
