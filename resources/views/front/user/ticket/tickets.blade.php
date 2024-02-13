@extends('front.user.layouts.app')

@section('content')
<div class="card">
    <div class="tabledata">
        <div class="col-12 r-t-col-12" style="display: flex; justify-content: space-between;">
            <div class="col-6 r-t-col-6">
                <span class="sort-text">{{ trans('index.user_tickets_phrase2') }}</span>
                <a href="{{ route('ticket.index', app()->getLocale()) }}"
                    class="btn btn-sm btn-light-primary">{{ trans('index.user_tickets_phrase3') }}</a>
                <a href="{{ route('ticket.index', app()->getLocale()). '?view=process' }}"
                    class="btn btn-sm btn-light-warning">{{ trans('index.user_tickets_phrase4') }}</a>
                <a href="{{ route('ticket.index', app()->getLocale()). '?view=closed' }}"
                    class="btn btn-sm btn-light-success">{{ trans('index.user_tickets_phrase5') }}</a>
            </div>
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1 r-t-my-1">
                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                            transform="rotate(45 17.0365 15.1223)" fill="black" />
                        <path
                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                            fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
                <input type="text" data-kt-customer-table-filter="search"
                    class="form-control form-control-solid w-250px ps-15" placeholder="{{ trans('index.search_ticket_text')}}" />
            </div>
            <!--end::Search-->
        </div>
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="ticket-list">
            <thead>
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th scope="col">{{ trans('index.user_tickets_phrase7') }}</th>
                    <th scope="col">{{ trans('index.user_tickets_phrase6') }}</th>
                    <th scope="col">{{ trans('index.user_composer_phrase14') }}</th>
                    <th scope="col">{{ trans('index.user_composer_phrase13') }}</th>

                    <th scope="col">Date</th>
                    <th scope="col">{{ trans('index.user_language_phrase4') }}</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody class="fw-bold text-gray-600">
                @if ($tickets)
                @forelse ($tickets as $ticket)
                    @if ( ($ticket->status == 'process' && $view_process) ||
                        ($ticket->status == 'closed' && $view_closed))
                        <tr>
                            <td>
                                <a class="text-gray-600 text-hover-primary mb-1"
                                    href="{{ route('ticket.question', [app()->getLocale(), $ticket->id]) }}">
                                    {{ $ticket->id }}
                                </a>
                            </td>
                            <td>
                                <a class="text-gray-800 text-hover-primary mb-1"
                                    href="{{ route('ticket.question', [app()->getLocale(), $ticket->id]) }}">
                                    {{ $ticket->name }}
                                </a>
                            </td>
                            <td>
                                @php
                                    $cId = isset($ticket->company_id) ? $ticket->company_id : 0;
                                @endphp
                                {{!empty(\App\Models\Company::find($cId)->name) ? \App\Models\Company::find($cId)->name : '' }}
                            </td>
                            <td>
                                @php
                                    $uId = isset($ticket->user_id) ? $ticket->user_id : 0;
                                @endphp
                                {{!empty(\App\Models\User::find($uId)->name) ? \App\Models\User::find($uId)->name : '' }}
                            </td>

                            <td>
                                @php
                                    $dateMName = date('n', strtotime($ticket->created_at));
                                @endphp
                                @if ($dateMName == '01')
                                    @php
                                        $dateMName = trans('index.text_jan');
                                    @endphp
                                @elseif ($dateMName == '02')
                                    @php
                                        $dateMName = trans('index.text_feb');
                                    @endphp
                                @elseif ($dateMName == '03')
                                    @php
                                        $dateMName = trans('index.text_mar');
                                    @endphp
                                @elseif ($dateMName == '04')
                                    @php
                                        $dateMName = trans('index.text_apr');
                                    @endphp
                                @elseif ($dateMName == '05')
                                    @php
                                        $dateMName = trans('index.text_may');
                                    @endphp
                                @elseif ($dateMName == '06')
                                    @php
                                        $dateMName = trans('index.text_jun');
                                    @endphp
                                @elseif ($dateMName == '07')
                                    @php
                                        $dateMName = trans('index.text_jul');
                                    @endphp
                                @elseif ($dateMName == '08')
                                    @php
                                        $dateMName = trans('index.text_aug');
                                    @endphp
                                @elseif ($dateMName == '09')
                                    @php
                                        $dateMName = trans('index.text_sep');
                                    @endphp
                                @elseif ($dateMName == '10')
                                    @php
                                        $dateMName = trans('index.text_oct');
                                    @endphp
                                @elseif ($dateMName == '11')
                                    @php
                                        $dateMName = trans('index.text_nov');
                                    @endphp
                                @elseif ($dateMName == '12')
                                    @php
                                        $dateMName = trans('index.text_dec');
                                    @endphp
                                @endif
                                @php
                                    $day = date('d', strtotime($ticket->created_at));
                                @endphp
                                @if (app()->getLocale() == 'en')
                                    {{ $day . 'th ' . $dateMName . ' ' . date('y', strtotime($ticket->created_at)) }}
                                @else
                                    {{ $day . '. ' . $dateMName . ' ' . date('y', strtotime($ticket->created_at)) }}
                                @endif
                            </td>
                            <td>
                                @if ($ticket->status == 'process')
                                    <div class="inline_td">
                                        <span class="badge badge-light-warning">{{ trans('index.user_tickets_phrase4') }}</span><span
                                            class="iconify prosess" data-icon="bx:bxs-time"></span>
                                    </div>
                                @else
                                    <div class="inline_td">
                                        <span class="badge badge-light-success">{{ trans('index.user_tickets_phrase5') }}</span><span
                                            class="iconify check" data-icon="akar-icons:circle-check-fill"></span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $reportGenDate = new DateTime($ticket->report_gen_time ?? '');
                                    $dateDiff  = $currentDate->diff($reportGenDate);
                                    $no_days_report_generated = $dateDiff->format('%a');
                                @endphp
                                @if ($no_days_report_generated >= 30)
                                    @if (($user->user_type == 'admin_super' || $user->user_type == 'admin_support' || $user->user_type == 'company_owner')
                                        && $ticket->review_status == 1 && $ticket->status == 'closed')
                                        <a class="btn btn-primary btn-sm" role="button"
                                            href="{{ route('ticket.review', [app()->getLocale(), $ticket->id]) }}">
                                            {{ trans('index.user_tickets_phrase9') }}
                                        </a>
                                    @elseif ($user->user_type == 'user'  && $ticket->status =='closed')
                                        <a class="btn btn-primary btn-sm" role="button"
                                            href="{{ route('ticket.review', [app()->getLocale(), $ticket->id]) }}">
                                            {{ trans('index.user_tickets_phrase9') }}
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endif
                @empty
                @endforelse
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
