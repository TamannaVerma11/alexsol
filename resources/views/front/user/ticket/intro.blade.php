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
                            <input type="text" id="ticket_name" value="{{ $ticket ? $ticket->name : ''; }}" class="form-control" disabled>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row user-content-row">
                <div class="col-12">
                    {!! trans('index.user_ticket_phrase28') !!}
                </div>
            </div>
            <div class="row user-content-row">
                <div class="col-12">
                    <a href="{{ route('ticket.question', [app()->getLocale(), $ticket->id]) }}">
                        <button class="btn btn-success btn-lg mb-3">
                            {{ trans('index.user_ticket_phrase26') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
