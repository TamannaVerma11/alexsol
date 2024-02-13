@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="table-resposive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="ticket-list">
                    <thead>
                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                            <th scope="col">{{ trans('index.per_title') }}</th>
                            <th scope="col">{{ trans('index.report_id') }}</th>
                            <th scope="col">{{ trans('index.date_request') }}</th>
                            <th scope="col">{{ trans('index.report_status') }}</th>
                            <th scope="col">{{ trans('index.report_per_by') }} </th>
                            <th scope="col">{{ trans('index.date_approval') }}</th>
                            <th scope="col">{{ trans('index.report_action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                        @forelse ($requests as $request)
                            <tr class="text-start fw-bolder fs-7 gs-0">
                                <td>{{ !empty($request->permisson_ticket_title) ? $request->permisson_ticket_title: '' }}</td>
                                <td>
                                    @php
                                        $report_format_title = \App\Models\MlreportFormatContent::where([['report_format_id', $request->report_id], ['language_id', $language->id]])->first();
                                    @endphp
                                    @if ($report_format_title && !empty($report_format_title->id))
                                        {{$report_format_title->report_title  }}
                                    @endif

                                </td>
                                <td>
                                    {{ $request->request_date_time }}
                                </td>
                                <td>
                                    @if($request->status == 0)
                                        {{ trans('index.report_pen') }}
                                    @else
                                        {{ trans('index.report_approve') }}
                                    @endif
                                </td>
                                <td>
                                    @if($request->permission_by == 0)
                                        {{ trans('index.company_report_text') }}
                                    @else
                                        {{ trans('index.consultancy_report_text') }}
                                    @endif
                                </td>
                                <td>
                                    {{ $request->approval_date_time }}
                                </td>
                                <td>
                                    @if($request->status == 0)
                                        <a class="btn btn-primary btn-sm" style="pointer-events: none;" role="button"
                                            href="#">
                                            {{ trans('index.start_ticket_text') }}
                                        </a>
                                    @else
                                        <a class="btn btn-primary btn-sm" role="button"
                                            href="{{ route('ticket.create', [app()->getLocale(), $request->id]) }}">
                                            {{ trans('index.start_ticket_text') }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
