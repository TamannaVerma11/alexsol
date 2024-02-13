@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <form class='form-inline' action="{{ route('ticket.newAnalyseStore', ['lang' => app()->getLocale()]) }}"
                method="POST" id="request_na_ticketAjax">
                @csrf
                <div class="row user-content-row request_form">
                    <div class="col-12">
                        <input type="hidden" name="request_form_id" id="request_form_id" value="1">
                        <div class="input-group">
                            <div style="display: contents;">
                                @forelse ($report_data as $i=>$report_format)
                                    <!-- section 1 start -->
                                    <div class="col-xs-3 click_select_report {{ $i == 1 ? 'select_report' : '' }}"
                                        attr-val="{{ $report_format->report_format_id }}" style="cursor: pointer;">
                                        @if ($i == 0)
                                            <script>
                                                $('#request_form_id').val('{{ $report_format->id }}');
                                            </script>
                                        @endif
                                        <div class="data-section col-xs-12">
                                            <div class="image-section col-xs-12" style="padding: 10px;padding-bottom: 1px;">
                                                <img src="{{ url(''.$report_format->report_image) }}"
                                                    style="height: 317px;width: 230px;">
                                            </div>
                                            <div class="text-section col-xs-12"
                                                style="font-size: 23px;text-align: center;font-weight:bold;border: 1px solid;height: 40px;margin: 0px 11px;">
                                                {{ $report_format->report_title }}<button data-bs-toggle="modal"
                                                    onclick="return false;"
                                                    data-bs-target="#exampleModalPen_{{ $report_format->report_format_id }}"
                                                    class="btn"><i class="fas fa-info-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="exampleModalPen_{{ $report_format->report_format_id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" style="margin: 0px auto;"
                                                        id="exampleModalLabel">
                                                        {{ trans('index.report_type_name_text') }}
                                                        {{ $report_format->report_title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="">
                                                    {{ htmlspecialchars_decode($report_format->report_desc) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <button id="" type="submit" class="btn btn-success mb-3 ml-3" data-ticket_id="">
                        {{ trans('index.start_ticket_text') }}
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
