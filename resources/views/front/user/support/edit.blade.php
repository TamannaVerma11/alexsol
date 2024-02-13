@extends('front.user.layouts.app')

@section('content')

<div class="card">
    <div class="card-body p-3">
        <div class="row user-content-row">
            <div class="col-12 support">
                <div class="support-widget-title">
                    {{ trans('index.user_support_phrase13') . ' ' . $support->id }}
                </div>
                <div class="single-support">
                    <div class="row">
                        <div class="col-12 single-support-subject">
                            <b>
                            {{ trans('index.user_support_phrase11') }}
                            </b>
                            {{ $support->subject }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 single-support-content">
                            {!! htmlspecialchars_decode( $support->message, ENT_QUOTES) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="support-section-title">{{ trans('index.user_support_phrase15') }}
                            </div>
                            @forelse ($replies as $reply)
                                @php
                                    $user_data = \App\Models\User::find($reply->user_id);
                                @endphp
                                <div class="support-reply-card
                                    {{($user->user_type == 'admin_super' || $user->user_type == 'admin_support') ?
                                        'support-reply-card-admin' : '' }}">
                                    <div class="row">
                                        <div class="col-12 support-reply-card-text">
                                            {!! htmlspecialchars_decode( $reply->message, ENT_QUOTES) !!}
                                        </div>
                                    </div>
                                    <div class="row support-reply-card-info">
                                        <div class="col-5">
                                            <i class="fas fa-user"></i>
                                            {{ (!empty($user->name)) ? $user->name : '' }}
                                        </div>
                                        <div class="col-4">
                                            <i class="fas fa-clock"></i>
                                            {{ date("d-m-Y", strtotime($reply->created_at)) }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="single-support-reply">
                                <div class="support-reply-title">{{ trans('index.user_support_phrase14') }}
                                </div>
                                <form action="{{ route('support.reply', ['lang'=>app()->getLocale()]) }}" method="POST" id="addSupReplyAjax">
                                    @csrf
                                    <div class="form-group">
                                        <label
                                            for="support_reply_text">{{ trans('index.user_support_phrase8') }}</label>
                                        <textarea id="support_reply_text" name='message' class="form-control"></textarea>
                                        <input type='hidden' name='support_id' value="{{ $support->id }}">
                                        <span class="text-danger  validation_errors message_err"></span>
                                    </div>
                                    <button type="submit" id="support_reply_submit" class="btn btn-success"
                                        data-support_id="{{ $support->id }}">
                                        <i class="fas fa-reply"></i>
                                        {{ trans('index.user_support_phrase14') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
