@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="row user-content-row">
                <div class="col-12">
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ trans('index.user_ticket_phrase1') }}
                                </div>
                            </div>
                            <input type="text" id="ticket_name" value="{{ $ticket ? $ticket->name : '' }}" class="form-control" disabled>
                        </div>
                    </form>
                </div>
            </div>

            <?php

            $rating = json_decode($ticket->rating, true);

            $rating_check_1 = 0;
            $rating_check_2 = 0;
            $rating_check_3 = 0;
            $rating_check_4 = 0;

            $rating_text_1 = '';
            $rating_text_2 = '';

            if (isset($rating)) {
                $rating_check_1 = $rating['rating_check_1'];
                $rating_check_2 = $rating['rating_check_2'];
                $rating_check_3 = $rating['rating_check_3'];
                $rating_check_4 = $rating['rating_check_4'];

                $rating_text_1 = $rating['rating_text_1'];
                $rating_text_2 = $rating['rating_text_2'];
            }

            $ratingStatus = '0';
            if (!$user_permission) {
                $ratingStatus = '1';
            } else {
                $ratingStatus = $ticket->rating_status;
            }

            ?>
            <div class="row user-content-row">
                <input type="hidden" id="rating_status_value" name="rating_status_value" value="{{ $ratingStatus }}" />
                <div class="col-12">
                    <form>
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase47') }}</label><br>
                        <div id="rating_check_1" class="smiley-check">
                            <i class="far fa-frown <?php if ($rating_check_1 == 1) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-frown-open <?php if ($rating_check_1 == 2) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-meh <?php if ($rating_check_1 == 3) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-smile <?php if ($rating_check_1 == 4) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-grin <?php if ($rating_check_1 == 5) {
                                echo 'active';
                            } ?>"></i>
                        </div>
                        <br>
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase48') }}</label><br>
                        <div id="rating_check_2" class="smiley-check">
                            <i class="far fa-frown <?php if ($rating_check_2 == 1) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-frown-open <?php if ($rating_check_2 == 2) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-meh <?php if ($rating_check_2 == 3) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-smile <?php if ($rating_check_2 == 4) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-grin <?php if ($rating_check_2 == 5) {
                                echo 'active';
                            } ?>"></i>
                        </div><br>
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase49') }}</label><br>
                        <div id="rating_check_3" class="smiley-check">
                            <i class="far fa-frown <?php if ($rating_check_3 == 1) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-frown-open <?php if ($rating_check_3 == 2) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-meh <?php if ($rating_check_3 == 3) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-smile <?php if ($rating_check_3 == 4) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-grin <?php if ($rating_check_3 == 5) {
                                echo 'active';
                            } ?>"></i>
                        </div><br>
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase50') }}</label><br>
                        <div id="rating_check_4" class="smiley-check">
                            <i class="far fa-frown <?php if ($rating_check_4 == 1) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-frown-open <?php if ($rating_check_4 == 2) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-meh <?php if ($rating_check_4 == 3) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-smile <?php if ($rating_check_4 == 4) {
                                echo 'active';
                            } ?>"></i>
                            <i class="far fa-grin <?php if ($rating_check_4 == 5) {
                                echo 'active';
                            } ?>"></i>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row user-content-row">
                <div class="col-12">
                    <form>
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase51') }}</label>
                        <textarea id="rating_text_1">
            </textarea>
                    </form>
                </div>
            </div>
            <div class="row user-content-row">
                <div class="col-12">
                    <form>
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase52') }}</label>
                        <textarea id="rating_text_2">
            </textarea>
                    </form>
                </div>
            </div>

            <div class="row col-12">
                <div class="col-3">
                </div>
                <div class="row col-6">
                    <div class="col-3 d-flex flex-row-reverse">
                        <a href="{{ route('ticket.review', [app()->getLocale(), $ticket->id]) }}"
                            role="button" class="btn btn-info btn-sm ml-1 mr-1 table-page-next">
                            &nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;
                        </a>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-info btn-sm table-page-number" style="width:100%">
                            <span>{{ trans('index.text_rating') }}</span>
                        </button>
                    </div>
                </div>
                <div class="col-3">
                </div>
            </div>
            <div class="row user-content-row" style="margin-top:1%">
                <?php
                if($ticket->rating_status !='1'
                        && $user_permission) {
                    if($ticket->ticket_status=='closed') {
                ?>
                        <button id="rating_submit" data-action="{{route('ticket.ratingSubmit', [app()->getLocale(), $ticket->id])}}"  class="btn btn-success" data-ticket_id="{{ $ticket->id }}"
                            data-ticket_rating_status="1">
                            {{ trans('index.user_ticket_phrase44') }}
                        </button>
                        <?php
                    }
                    else {
                        ?>
                        <button id="rating_submit" data-action="{{route('ticket.ratingSubmit', [app()->getLocale(), $ticket->id])}}" class="btn btn-success" data-ticket_id="{{ $ticket->id }}"
                            data-ticket_ratingstatus="0">
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
