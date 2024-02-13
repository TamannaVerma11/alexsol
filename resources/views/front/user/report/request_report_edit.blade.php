@extends('front.user.layouts.app')

@section('content')
    <form action="{{ route('report.request.update', ['lang' => app()->getLocale(), $item->id]) }}"
        method="POST" id="updateReportRequestAjax">
        @csrf
        <div class="card">
            <div class="card-body p-3">
                <div class="row user-content-row">
                    <div class="col-12">
                        <input type="hidden" id="request_id" name="request_id" value="{{ $item->id }}">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ 'User Name' }}
                                </div>
                                <input type="text" id="ticket_name" value="{{ $userName }}" class="form-control"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row user-content-row">
                    <div class="col-12">
                        <div class="ticket-information">
                            <div class="row">
                                <div class="col-6">
                                    <div class="ticket-information-group">
                                        <label class="ticket-information-title">{{ 'Report Id' }} </label>
                                        {{ $ticket->report_id }}
                                    </div>
                                    <div class="ticket-information-group">
                                        <label class="ticket-information-title">{{ 'Status' }} </label>
                                        @if($ticket->status == '2')
                                        <button class="btn btn-secondary btn-sm">
                                            {{ 'Close' }}
                                        </button>
                                        @elseif($ticket->status == '0' || $ticket->status == '1')
                                        <select id="report_status" name="status">
                                            <option value="0" {{ ($ticket->status == '0') ?
                                                'selected' : '' }}
                                            > Pending</option>
                                            <option value="1" {{ ($ticket->status == '1') ?
                                                'selected' :'' }}
                                            > Approval</option>
                                        </select>
                                        @endif
                                    </div>
                                    <div class="ticket-information-group">
                                        <label class="ticket-information-title">
                                            {{ 'Date' }} :
                                        </label>
                                        {{ date('Y-m-d', strtotime($ticket->request_date_time)) }}
                                    </div>

                                    <div class="ticket-information-group">
                                        <a href="{{ route('report.request', app()->getLocale()) }}"
                                            style="background-color: grey;" class="btn btn-success btn-sm"> Back</a>
                                        @if($ticket->status != '2')
                                            <button type="submit" id="updateRequestForm"
                                                class="btn btn-success btn-sm">{{ 'Update' }}</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
