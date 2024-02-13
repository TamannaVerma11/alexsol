@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="row user-content-row">
                <div class="col-12">
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ trans('index.user_ticket_phrase2') }}</div>
                            </div>
                            <input type="text" id="ticket_name" value="{{ $ticket ? $ticket->name : '' }}" class="form-control" disabled>
                        </div>
                    </form>
                </div>
            </div>
            @php

            $review = json_decode($ticket->review, true);

            if (isset($review['review_status'])) {
                $reviewStatus = $review['review_status'];
                $reviewOptions = explode(',', $reviewStatus);
            }
            if (isset($review['review_text'])) {
                $ticketReview = $review['review_text'];
            }

            $disabledStatus = '';

            if ($ticket->review_status == '1') {
                $disabledStatus = 'disabled';
            }

            if (!$user_permission) {
                $disabledStatus = 'disabled';
            }

            @endphp
            <div class="row user-content-row">
                <div class="col-12">
                    <form class="r-f-form">
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase30') }}</label><br>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Anger" {{ (isset($reviewOptions) && in_array('Anger', $reviewOptions) == 1) ? 'checked' : '' }}
                                id="review_check_1" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_1">
                                {{ trans('index.user_ticket_phrase31') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Fear" {{ (isset($reviewOptions) && in_array('Fear', $reviewOptions) == 1) ? 'checked' : '' }}
                                id="review_check_2" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_2">
                                {{ trans('index.user_ticket_phrase32') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Anxiety"
                            {{ (isset($reviewOptions) && in_array('Anxiety', $reviewOptions) == 1) ? 'checked' : '' }} id="review_check_3" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_3">
                                {{ trans('index.user_ticket_phrase33') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Loss" {{ (isset($reviewOptions) && in_array('Loss', $reviewOptions) == 1) ? 'checked' : '' }} id="review_check_3" {{ $disabledStatus }}
                                id="review_check_4" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_4">
                                {{ trans('index.user_ticket_phrase34') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Sadness"
                            {{ (isset($reviewOptions) && in_array('Sadness', $reviewOptions) == 1) ? 'checked' : '' }} id="review_check_3" {{ $disabledStatus }} id="review_check_5" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_5">
                                {{ trans('index.user_ticket_phrase35') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Resignation"
                            {{ (isset($reviewOptions) && in_array('Resignation', $reviewOptions) == 1) ? 'checked' : '' }} id="review_check_3" {{ $disabledStatus }} id="review_check_6" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_6">
                                {{ trans('index.user_ticket_phrase36') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Guilt" {{ (isset($reviewOptions) && in_array('Guilt', $reviewOptions) == 1) ? 'checked' : '' }}
                                id="review_check_7" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_7">
                                {{ trans('index.user_ticket_phrase37') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Shame" {{ (isset($reviewOptions) && in_array('Shame', $reviewOptions) == 1) ? 'checked' : '' }}
                                id="review_check_8" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_8">
                                {{ trans('index.user_ticket_phrase38') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Jealousy"
                            {{ (isset($reviewOptions) && in_array('Jealousy', $reviewOptions) == 1) ? 'checked' : '' }} id="review_check_9" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_9">
                                {{ trans('index.user_ticket_phrase39') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Enthusiasm"
                            {{ (isset($reviewOptions) && in_array('Enthusiasm', $reviewOptions) == 1) ? 'checked' : '' }} id="review_check_9" {{ $disabledStatus }} id="review_check_10" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_10">
                                {{ trans('index.user_ticket_phrase40') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Tenderness"
                            {{ (isset($reviewOptions) && in_array('Tenderness', $reviewOptions) == 1) ? 'checked' : '' }} id="review_check_9" {{ $disabledStatus }} id="review_check_11" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_11">
                                {{ trans('index.user_ticket_phrase41') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input review-check" type="checkbox" value="Hope"  {{ (isset($reviewOptions) && in_array('Hope', $reviewOptions) == 1) ? 'checked' : '' }} id="review_check_9" {{ $disabledStatus }}
                                id="review_check_12" {{ $disabledStatus }}>
                            <label class="form-check-label" for="review_check_12">
                                {{ trans('index.user_ticket_phrase42') }}
                            </label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row user-content-row">
                <div class="col-12">
                    <form>
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase43') }}</label>
                        <textarea id="ticket_review">
                     {!! (isset($ticketReview)) ? $ticketReview : '' !!}
                </textarea>
                    </form>
                </div>
            </div>

            <div class="row col-12">
                <div class="col-3">
                </div>
                <div class="row col-6">
                    <div class="col-3 d-flex flex-row-reverse">
                        <a href="{{ route('ticket.question', [app()->getLocale(), $ticket->id]). '?pageNum=7'}}"
                            role="button" class="btn btn-info btn-sm ml-1 mr-1 table-page-prev">
                            &nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;
                        </a>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-info btn-sm table-page-number" style="width:100%">
                            <span>{{ trans('index.text_review') }}</span>
                        </button>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('ticket.rating', [app()->getLocale(), $ticket->id]) }}"
                            role="button" class="btn btn-info btn-sm ml-1 mr-1 table-page-next">
                            &nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-right"></i>&nbsp;&nbsp;&nbsp;
                        </a>
                    </div>
                </div>
                <div class="col-3">
                </div>
            </div>

            <div class="row user-content-row" style="margin-top:1%">
                <?php
                if($ticket->review_status !='1'
                        && $user_permission) {
                    if($ticket->ticket_status=='closed') {
                ?>
                        <button id="review_submit" data-action="{{route('ticket.reviewSubmit', [app()->getLocale(), $ticket->id])}}" class="btn btn-success" data-ticket_id="{{ $ticket->id }}"
                            data-ticket_review_status="1">
                            {{ trans('index.user_ticket_phrase44') }}
                        </button>
                        <?php
                    }
                    else {
                        ?>
                        <button id="review_submit" data-action="{{route('ticket.reviewSubmit', [app()->getLocale(), $ticket->id])}}" class="btn btn-success" data-ticket_id="{{ $ticket->id }}"
                            data-ticket_review_status="0">
                            {{ trans('index.user_ticket_phrase15') }}
                        </button>
                        <?php
                    }
                }
                ?>
            </div>

        </div>
    </div>
@endsection
