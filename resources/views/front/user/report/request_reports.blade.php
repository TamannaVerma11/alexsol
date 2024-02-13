@extends('front.user.layouts.app')

@section('content')

    <div class="card">
        <div class="tabledata">
            <div class="col-12 r-t-col-12" style="display: flex; justify-content: space-between;">
                <div class="col-6 r-t-col-6">
                    <span class="sort-text">{{ trans('index.user_tickets_phrase2') }}</span>
                    <a href="{{ route('report.request', app()->getLocale()) }}"
                        class="btn btn-sm btn-light-primary">{{ trans('index.user_tickets_phrase3') }}</a>
                    <a href="?status=0"
                        class="btn btn-sm btn-light-warning">Pending</a>
                    <a href="?status=1"
                        class="btn btn-sm btn-light-warning">Approval</a>
                    <a href="?status=2"
                        class="btn btn-sm btn-light-success">{{ trans('index.user_tickets_phrase5') }}</a>
                </div>

            </div>
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="ticket-list">
                <thead>
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th scope="col">Report Id - Name</th>
                        <th scope="col">Permission By</th>
                        <th scope="col">{{ trans('index.user_composer_phrase14') }}</th>
                        <th scope="col">{{ trans('index.user_composer_phrase13') }}</th>
                        <th scope="col">Date</th>
                        <th scope="col">{{ trans('index.user_language_phrase4') }}</th>
                    </tr>
                </thead>
                <tbody class="fw-bold text-gray-600">
                    @if ($tickets != null)
                        @forelse($tickets as $ticket)
                        @php
                            $view_process = true;
                            $view_closed = true;
                            if(isset(request()->status) && request()->status == '0'){
                                $view_closed = false;
                            }
                            if(isset(request()->status) && request()->status == '2'){
                                $view_process = false;
                            }
                        @endphp
                        <tr>
                            <td>
                                @if($user->user_type == 'admin_super' || $user->user_type == 'admin_support')
                                <a class="text-gray-600 text-hover-primary mb-1"
                                            href="{{ route('ticket.question', [app()->getLocale(), $ticket->id]) }}">
                                            {{ $ticket->report_id .' - '.
                                \App\Models\MlreportFormatContent::where([['report_format_id', $ticket->report_id],['language_id', $language->id]])->first()->report_title }}
                                        </a>
                                @else
                                    @if ($user->user_type == 'company_owner' && $ticket->permission_by =='1' )
                                    {{ $ticket->report_id .' - '.
                                    \App\Models\MlreportFormatContent::where([['report_format_id', $ticket->report_id],['language_id', $language->id]])->first()->report_title }}
                                    @else
                                        <a class="text-gray-600 text-hover-primary mb-1"
                                            href="{{ route('report.request.edit', [app()->getLocale(), $ticket->id]) }}">
                                            {{ $ticket->report_id .' - '.
                                \App\Models\MlreportFormatContent::where([['report_format_id', $ticket->report_id],['language_id', $language->id]])->first()->report_title }}
                                        </a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <?php
                                if ($ticket->permission_by == '1') {
                                    $consultancy_id = $ticket->consultancy_id;
                                    $name = \App\Models\User::find($consultancy_id)->name;
                                    echo '<b>By Consultancy </b>' . $name;
                                } else {
                                    $cId = $ticket->company_id;
                                    $company = \App\Models\Company::find($cId);
                                    if(!empty($company->name))
                                        echo '<b>By Company </b>' . $company->name;
                                }
                                ?>
                            </td>
                            <td>
                                {{ !empty($company_name) ? $company_name: '' }}
                            </td>
                            <td>
                                {{ !empty($ticket->user_id) && !empty(\App\Models\User::find($ticket->user_id)->name) ? \App\Models\User::find($ticket->user_id)->name : '' }}
                            </td>

                            <td>
                                {{ $ticket->request_date_time }}
                            </td>
                            <td>
                                @if($ticket->status == '0')
                                <div class="inline_td">
                                    <span class="badge badge-light-warning">Pending</span>
                                </div>
                                @elseif($ticket->status == '1')
                                <div class="inline_td">
                                    <span class="badge badge-light-warning">Approval</span>
                                </div>
                                @elseif($ticket->status == '2')
                                <div class="inline_td">
                                    <span class="badge badge-light-warning">Closed</span>
                                </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
