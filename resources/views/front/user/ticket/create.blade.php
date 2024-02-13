@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <form action="{{ route('ticket.store', ['lang' => app()->getLocale(), request()->req_id]) }}"
                method="POST" id="createTicketAjax">
                @csrf
                <div class="row user-content-row">
                    <div class="col-12">
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase23') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ trans('index.user_ticket_phrase1') }}</div>
                            </div>
                            <input type="text" id="ticket_name" name="name" class="form-control">
                            <span class="text-danger  validation_errors name_err"></span>
                        </div>
                    </div>
                </div>
                <div class="row user-content-row">
                    <div class="col-12">
                        <label class="ticket-label">{{ trans('index.user_ticket_phrase25') }}</label>
                        <textarea id="ticket_summary" name="summary"></textarea>
                        <span class="text-danger  validation_errors summary_err"></span>
                    </div>
                </div>
                <div class="row user-content-row">
                    <button id="" type="submit" class="btn btn-success mb-3 ml-3" data-ticket_id="">
                        {{ trans('index.user_ticket_phrase24') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
