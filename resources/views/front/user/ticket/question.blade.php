@extends('front.user.layouts.app')

@section('content')

    <div class="card">
        <div class="card-body p-3">
            <input type="hidden" name="pageNum" id="pageNum" value="{{  $pageNum }}" />
            <div class="row user-content-row">
                <div class="col-12">
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ trans('index.user_ticket_phrase1') }}
                                </div>
                            </div>
                            <input type="text" style="height: 44px;" id="ticket_name" value="{{  $ticket ? $ticket->name : '' }}"
                                class="form-control" {{  !$user_edit_permission ? 'disabled' : '' }}>
                        </div>
                        <div class="">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    {{ trans('index.user_ticket_phrase25') }}
                                </div>
                            </div>
                            @if ($user_edit_permission && $ticket->status != 'closed')
                                <textarea class="form-control" id="ticket_summary">{!! $ticket ? $ticket->summary : '' !!}</textarea>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="row user-content-row">
                <div class="col-12">
                    @if($user->user_type == 'user')
                        <div class="ticket-information">
                            <div class="row user-content-row">
                                <div class="col-12">
                                    <form>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">{{ trans('index.user_ticket_invite_responder') }}</div>
                                            </div>
                                            <input type="text" id="res" style="height: 44px;"
                                                placeholder="{{ trans('index.user_ticket_responder_placeholder') }}" class="form-control" {{ (!$user_edit_permission) ? 'disabled' : '' }}>
                                            <input type="hidden" id="res_ticket_id" value="{{ $ticket->id }}"
                                                class="form-control">
                                            <div class="input-group-prepend">
                                                <button id="btn_res1" data-action="{{ route('ticket.invite', app()->getLocale()) }}" class="btn btn-success" {{ (!$user_edit_permission) ? 'disabled' : '' }}>
                                                    {{ trans('index.user_ticket_invite_text') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div style="display:none;" id="alertSectionsuccess1"><span id="alertSection"
                                            style="color: green;">{{ trans('index.user_ticket_email_sucess') }}</span></div>
                                    <div style="display:none;text-align: center;font-size: 17px;" id="alertSectionsuccess2">
                                    </div>
                                    <div style="display:none;" id="alertSectionempty1"><span id="alertSection"
                                            style="color: red;">{{ trans('index.user_ticket_add_email') }}</span></div>
                                </div>
                            </div>
                        </div>

                    @endif

                    @if ($user->user_type == 'user' || $user->user_type == 'admin_super')
                        @forelse ($respond_tickets as $respond_count=>$respond_ticket)
                            <div> Responders </div>

                            @php
                                $respond_ticket_data = \App\Models\ResponderTicketData::where('responder_id', $respond_ticket->id)->first();
                            @endphp
                            @php
                                $question_response_test = json_decode($respond_ticket->ticket_response, true);

                                $count = 0;
                                $countNotFollowUpQuestion = 0;
                                $questionIds_test = '';
                                $answerIds_test = '';
                                $unAnswerIds = '';
                                foreach ($questions as $question){
                                    $count++;
                                    if ($question->follow_up == 0) {
                                        $countNotFollowUpQuestion++;
                                        if ($countNotFollowUpQuestion == 1) {
                                            $questionIds_test = $question->id;
                                        } else {
                                            $questionIds_test = $questionIds_test . ',' . $question->id;
                                        }
                                    }
                                    //Getting question data
                                    $question_data = \App\Models\QuestionContent::where([['question_id', $question->id], ['language_id', $language->id]])->get();
                                    if ($question_data->count() < 1) {
                                        $question_data = false;
                                    }

                                    //Question response
                                    $yes_check = false;
                                    $no_check = false;
                                    $check_1 = false;
                                    $check_2 = false;
                                    $check_3 = false;
                                    $check_4 = false;
                                    $check_5 = false;
                                    $check_6 = false;

                                    if (isset($question_response_test)) {
                                        if ($question->type == 'yes-no') {
                                            if ($question_response_test[$question->id]['answer'] == 2) {
                                                $yes_check = true;
                                            } elseif ($question_response_test[$question->id]['answer'] == 1) {
                                                $no_check = true;
                                            }
                                        }
                                        if ($question->type == 'mcq') {
                                            if ($question_response_test[$question->id]['answer'] == 1) {
                                                $check_1 = true;
                                            } elseif ($question_response_test[$question->id]['answer'] == 2) {
                                                $check_2 = true;
                                            } elseif ($question_response_test[$question->id]['answer'] == 3) {
                                                $check_3 = true;
                                            } elseif ($question_response_test[$question->id]['answer'] == 4) {
                                                $check_4 = true;
                                            } elseif ($question_response_test[$question->id]['answer'] == 5) {
                                                $check_5 = true;
                                            } elseif ($question_response_test[$question->id]['answer'] == 6) {
                                                $check_6 = true;
                                            }
                                        }
                                    }

                                    if ($question->follow_up == 0) {
                                        if ($yes_check || $no_check || $check_1 || $check_2 || $check_3 || $check_4 || $check_5 || $check_6) {
                                            if (strlen($answerIds_test) <= 0) {
                                                $answerIds_test = $question->id;
                                            } else {
                                                $answerIds_test = $answerIds_test . ',' . $question->id;
                                            }
                                        } else {
                                            if (strlen($unAnswerIds) <= 0) {
                                                $unAnswerIds = $question->id;
                                            } else {
                                                $unAnswerIds = $unAnswerIds . ',' . $question->id;
                                            }
                                        }
                                    }
                                }
                            @endphp
                            <div>
                                <div> {{  'Responder ' . $respond_count }}</div>
                            </div>

                            <div>
                                <div> {{ trans('index.user_ticket_phrase55') }}</div>
                                <div class="progress" id="progres_check_{{  $respond_count }}">
                                    <div id="progressbar_{{  $respond_count }}" class="progress-bar bg-success" role="progressbar"
                                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                        <span id="label-progressbar_{{  $respond_count }}"></span>
                                    </div>
                                </div>
                            </div>

                            <input name="" id="questionIds_{{  $respond_count }}" type="hidden" value="{{  $questionIds_test }}">
                            <input name="" id="answerIds_{{  $respond_count }}" type="hidden" value="{{  $answerIds_test }}">
                            <script src="{{ url('assets/libs/jquery/jquery.min.js') }}"></script>
                            <script>
                                let progressbar_test_{{  $respond_count }} = $('#progressbar_{{  $respond_count }}');
                                let questionIds_test_{{  $respond_count }} = $('#questionIds_{{  $respond_count }}').val();
                                let answerIds_test_{{  $respond_count }} = $('#answerIds_{{  $respond_count }}').val();
                                let questionNo_test_{{  $respond_count }} = {{ ($respond_ticket_data) ? $respond_ticket_data->id : '' }};

                                let numberOfQuestion_test_{{  $respond_count }} = 0;
                                let numberOfAnswer_test_{{  $respond_count }} = 0;
                                let percent_test_{{  $respond_count }} = 0;

                                if (questionIds_test_{{  $respond_count }}.length >= 1) {
                                    var questionIdArr_test_{{  $respond_count }} = questionIds_test_{{  $respond_count }}.split(',');
                                    numberOfQuestion_test_{{  $respond_count }} = questionIdArr_test_{{  $respond_count }}.length;
                                }

                                if (answerIds_test_{{  $respond_count }}.length >= 1) {
                                    var totalAnswerIdsArr_test_{{  $respond_count }} = answerIds_test_{{  $respond_count }}.split(',');
                                    numberOfAnswer_test_{{  $respond_count }} = totalAnswerIdsArr_test_{{  $respond_count }}.length;

                                    if (questionNo_test_{{  $respond_count }} != 0) {
                                        if (!totalAnswerIdsArr_test_{{  $respond_count }}.includes(questionNo_test_{{  $respond_count }})) {
                                            numberOfAnswer_test_{{  $respond_count }} = numberOfAnswer_test_{{  $respond_count }};
                                            answerIds_test_{{  $respond_count }} = answerIds_test_{{  $respond_count }} + "," +
                                                questionNo_test_{{  $respond_count }};
                                            $('#answerIds_{{  $respond_count }}').val(answerIds_test_{{  $respond_count }});
                                        }
                                    }
                                } else {
                                    if (questionNo_test_{{  $respond_count }} != 0) {
                                        $('#answerIds_{{  $respond_count }}').val(questionNo_test_{{  $respond_count }});
                                        numberOfAnswer_test_{{  $respond_count }} = numberOfAnswer_test_{{  $respond_count }};
                                    }
                                }

                                percent_test_{{  $respond_count }} = Math.floor((numberOfAnswer_test_{{  $respond_count }} * 100) /
                                    numberOfQuestion_test_{{  $respond_count }});
                                progressbar_test_{{  $respond_count }}.css({
                                    "width": percent_test_{{  $respond_count }} + "%"
                                });

                                $('#label-progressbar_{{  $respond_count }}').html(percent_test_{{  $respond_count }} + '% (' +
                                    numberOfAnswer_test_{{  $respond_count }} + '/' + numberOfQuestion_test_{{  $respond_count }} + ')');
                            </script>
                        @empty
                        @endforelse
                    @endif

                    <div class="ticket-information">
                        <div class="row">
                            <div class="col-6">
                                <div class="ticket-information-group">
                                    <label class="ticket-information-title">{{ trans('index.user_ticket_phrase2') }} </label>
                                    {{ $ticket->id }}
                                </div>
                                <div class="ticket-information-group">
                                    <label class="ticket-information-title">{{ trans('index.user_ticket_phrase3') }} </label>
                                    @if($ticket->status == 'process')
                                    <button disabled class="btn btn-warning btn-sm">
                                        {{ trans('index.user_ticket_phrase4') }}
                                    </button>
                                    @elseif($ticket->status == 'closed')
                                    <button disabled class="btn btn-secondary btn-sm">
                                        {{ trans('index.user_ticket_phrase5') }}
                                    </button>
                                    @endif
                                </div>
                                <div class="ticket-information-group">
                                    <label class="ticket-information-title">
                                        {{ trans('index.text_open_date') }} :
                                    </label>
                                    {{  date('Y-m-d', strtotime($ticket->time)) }}
                                </div>

                                @if($ticket->status =='closed')
                                    <div class="ticket-information-group">
                                        <label class="ticket-information-title">
                                            {{ trans('index.text_close_date') }} :
                                        </label>

                                        @if (isset($ticket->close_time))
                                            {{ date('Y-m-d', strtotime($ticket->close_time)) }}
                                        @endif
                                    </div>
                                @endif


                                @if($user->user_type == 'admin_support' || $user->user_type == 'admin_super'):
                                    <div class="ticket-information-group">
                                        @if (!$report &&
                                            ($user->user_type == 'admin_support' || $user->user_type == 'admin_super') &&
                                            $ticket->status == 'closed')
                                            <label class="ticket-information-title">
                                                {{ trans('index.user_ticket_phrase21') }}
                                            </label>
                                        @endif

                                        <label>Select report type</label>
                                        <select class="form-control" id="report_format">
                                            <option value="0">Please select</option>
                                            @forelse($report_formats as $report_format)
                                                @if($report_format->id == $report_format_id )
                                                    <option value="{{  $report_format->report_format_id }}" selected="selected">{{  $report_format->report_title }}
                                                    </option>
                                                @else
                                                    <option value="{{  $report_format->report_format_id }}">{{  $report_format->report_title }}</option>
                                                @endif
                                            @empty
                                            @endforelse
                                        </select>
                                        <br>
                                        <input type="button" value="Update report format" class="btn btn-info"
                                            id="add_report_format" /><br><br>
                                        <input type="hidden" value="{{ $ticket->id }}" id="report_ticket_id" />



                                        <label class="ticket-information-title">{{ trans('index.user_ticket_phrase21') }} </label>
                                        @if($report_format_id && $report_format_id == $report->report_format_id)
                                            <a href="/report_types/mlc_pdf_report_{{  str_replace(' ', '%20', $report->title) }}.php?id={{  $ticket->id }}"
                                                class="btn btn-success btn-sm mb-1">
                                                <i class="fas fa-download"></i>
                                                {{ trans('index.user_ticket_phrase22') }}
                                            </a>
                                        @endif



                                        <!-- Report composer, only for admins -->
                                        @if($user->user_type == 'admin_support' || $user->user_type == 'admin_super')

                                        @endif
                                        @if(($user->user_type == 'admin_support' || $user->user_type == 'admin_super') && $ticket->status == 'closed'): ?>
                                            <a href="/user/index.php?route=report_composer&id={{ $ticket->id }}"
                                                class="btn btn-success btn-sm mb-1">
                                                <i class="fas fa-pen-alt"></i>
                                                {{ trans('index.user_ticket_phrase54') }}
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                <a target="_blank"
                                    href="{{ route('ticket.report_main_chart', [app()->getLocale(),$ticket->id]) }}"
                                    class="btn btn-success btn-sm mb-1">
                                    <i class="fas fa-download"></i>
                                    Main report download
                                </a>

                                <input type='text' id='question_input' hidden readonly value="{{ json_encode($questions) }}">
                                <input type='text' id='response_input' hidden readonly value="{{ $ticket->response }}">

                                <button data-bs-toggle="modal" onclick="return false;" data-bs-target="#graphModal"
                                    class="btn btn-primary">{{ trans('index.add_graph') }}</button>

                                <div class="modal fade" id="graphModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="exampleModalLabel">
                                                    {{ trans('index.graph_text') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" id="">
                                                <div class="card text-center mb-2">
                                                    <div class="card-body radar-graph" id="radar_graph_1">
                                                        <h4 class="text-center" id="success_message"></h4><br>
                                                        @forelse($categories as $category)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input graph-label" type="checkbox"
                                                                    id="radar1_category_{{ $category['category_id'] }}"
                                                                    data-category="{{ $category['category_id'] }}"
                                                                    value="{{ $category['category_name'] }}" checked>
                                                                <label class="form-check-label"
                                                                    for="radar1_category_{{ $category['category_id'] }}">{{ $category['category_name'] }}</label>
                                                            </div>
                                                        @empty
                                                        @endforelse

                                                        <br><br>
                                                        <!--<?php
                                                        /*if (!isset($_SESSION['trans'])) {
                                                            $Database = new Database();
                                                            $default_language = $Database->get_data('lang_default', 1, 'language', true);
                                                            if ($default_language) {
                                                                $_SESSION['trans'] = $default_language['lang_code'];
                                                            } else {
                                                                $_SESSION['trans'] = 'en';
                                                            }
                                                        }*/
                                                        ?>-->
                                                        <input type="hidden" value="{{  $ticket->id }}"
                                                            id="ticket_id_data" />
                                                        <input type="hidden" value="{{  app()->getLocale() }}"
                                                            id="lang_code" />
                                                        <button type="button" id="draw_graph_1"
                                                            class="btn btn-primary btn-sm">{{ trans('index.user_composer_phrase27') }}</button>
                                                        <button type="button" id="save_graph_report"
                                                            class="btn btn-primary btn-sm">Save graph</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ticket-information-group">
                                    <label class="ticket-information-title">{{ trans('index.user_ticket_phrase7') }} </label>

                                    @if($ticket_deadline)
                                        {{ (!empty($ticket_deadline->end_date)) ? $ticket_deadline->end_date : '' }}
                                    @else
                                        {{ trans('index.user_questions_phrase25') }}
                                    @endif

                                    @if(($user->user_type == 'admin_super' || $user->user_type == 'consultant') &&
                                        $ticket->status == 'process')
                                        <button id="ticket_deadline_update" data-action="{{ route('ticket.update.deadline', app()->getLocale()) }}" class="btn btn-success btn-sm"
                                            data-ticket_id="{{ $ticket->id }}" data-end_date="{{ (!empty($ticket_deadline->end_date)) ? $ticket_deadline->end_date : '' }}"
                                            data-summary="{{ $ticket_deadline->summary }}" data-description="{{ $ticket_deadline->description }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        @if($ticket_deadline && !empty($ticket_user->google_auth_code))
                                            <button class="btn btn-info btn-sm calendar_event_reminder"
                                                title="{{ trans('index.user_ticket_phrase18') }}" data-ticket_id="{{  $ticket->ticket_id }}"
                                                data-end_date="{{ (!empty($ticket_deadline->end_date)) ? $ticket_deadline->end_date : '' }}" data-summary="{{  $ticket_deadline->summary }}"
                                                data-description="{{ $ticket_deadline->description }}">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        @endif
                                    @endif
                                </div>

                                @if($user->user_type == 'admin_super' && $ticket->status == 'closed')
                                    <div class="ticket-information-group">
                                        <label class="ticket-information-title">{{ trans('index.user_ticket_phrase19') }}</label>
                                        <button type="button" id="send_report_email" data-user_email="{{  $ticket_user->email }}"
                                            data-ticket_id="{{ $ticket->ticket_id }}"
                                            class="btn btn-success btn-sm">{{ trans('index.user_ticket_phrase20') }}</button>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <div class="ticket-information-group">
                                    <div class="ticket-information-logo">
                                        @php
                                            $logo_image = !empty($ticket_company->upload_company_img) ? $ticket_company->upload_company_img : '';
                                        @endphp
                                        <img src="{{ $logo_image }}" alt="Company logo">
                                    </div>
                                </div>
                                <div class="ticket-information-group">
                                    <label class="ticket-information-title" style="width:100px">{{ trans('index.user_ticket_phrase8') }}
                                    </label>
                                    <span>{{ !empty($ticket_company->name) ? $ticket_company->name : '' }}</span>
                                </div>
                                <div class="ticket-information-group">
                                    <label class="ticket-information-title" style="width:100px">{{ trans('index.user_ticket_phrase9') }}
                                    </label>
                                    <span>{{ !empty($ticket_user->name) ? $ticket_user->name : '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div> {{ trans('index.user_ticket_phrase55') }}</div>
                <div class="progress">
                    <div id="progressbar" class="progress-bar bg-success" role="progressbar" aria-valuenow="70"
                        aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        <span id="label-progressbar"></span>
                    </div>
                </div>
            </div>


            <div style="margin:10px;width:100%;text-align:right;">
                @if($user_permission
                    && (isset($ticket) && $ticket->ticket_status != 'closed'))
                        <a role="button" href="#" style="margin-right:20px;" onclick="unAnseredQuestionFocus()">
                            {{ trans('index.text_unansered_qeustion') }}
                        </a>
                @endif
            </div>

            <div>
                {{ trans('index.pdf_report_phrase2') }}
                <span id="pageNumber"></span>
                {{ trans('index.text_of') }}
                <span id="totalPages"></span>
            </div>

            <div class="row user-content-row">
                <div class="col-12">
                    <div class="table-fixed-header">
                        <table class="table table-bordered question-table">
                            <thead>
                                <tr>
                                    <th class="quesiton_id">{{ trans('index.user_ticket_phrase10') }}</th>
                                    <th class="quesiton">{{ trans('index.user_ticket_phrase11') }}</th>
                                    <td class="answer" colspan="6">{{ trans('index.user_ticket_phrase27') }}</td>
                                </tr>
                            </thead>
                            <tbody class="question-table-data">
                                @if($questions && $available_categories)
                                    <input type='text' id='available_categories' value="{{ json_encode($available_categories) }}" hidden>
                                @endif

                                @if($questions)
                                <?php
                                    $count = 0;
                                    $countNotFollowUpQuestion = 0;
                                    $questionIds = "";
                                    $answerIds = "";
                                    $unAnswerIds = "";
                                    ?>
                                    @foreach($questions as $key=>$question)
                                        <?php
                                        //Skip new question for closed ticket
                                        if($ticket->status == 'closed'
                                            && !isset($question_response[$question->id])){
                                            continue;
                                        }

                                        //Increment question number
                                        $count++;
                                        if($question->follow_up == 0) {
                                            $countNotFollowUpQuestion++;
                                            if($countNotFollowUpQuestion==1) {
                                                $questionIds = $question->id;
                                            }
                                            else {
                                                $questionIds = $questionIds.",".$question->id;
                                            }
                                        }

                                        //Getting question data
                                        $question_data = \App\Models\QuestionContent::where([['question_id', $question->id], ['language_id', $language->id]])->first();

                                        //Finding deadline
                                        $q_deadline = null;
                                        if($question_deadline){
                                            foreach($question_deadline as $deadline){
                                                if($deadline->id == $question->id){
                                                    $q_deadline = $deadline;
                                                }
                                            }
                                        }

                                        //Question response
                                        $yes_check = false;
                                        $no_check = false;
                                        $check_1 = false;
                                        $check_2 = false;
                                        $check_3 = false;
                                        $check_4 = false;
                                        $check_5 = false;
                                        $check_6 = false;

                                        if(isset($question_response[$question->id])){
                                            if($question->type == 'yes-no'){
                                                if($question_response[$question->id]['answer'] == 2) {
                                                    $yes_check = true;
                                                }
                                                else if($question_response[$question->id]['answer'] == 1) {
                                                    $no_check = true;
                                                }
                                            }
                                            if($question->type == 'mcq'){
                                                if($question_response[$question->id]['answer'] == 1) $check_1 = true;
                                                else if($question_response[$question->id]['answer'] == 2) $check_2 = true;
                                                else if($question_response[$question->id]['answer'] == 3) $check_3 = true;
                                                else if($question_response[$question->id]['answer'] == 4) $check_4 = true;
                                                else if($question_response[$question->id]['answer'] == 5) $check_5 = true;
                                                else if($question_response[$question->id]['answer'] == 6) $check_6 = true;
                                            }
                                        }

                                        if($question->follow_up == 0 )
                                        {
                                            if($yes_check
                                                ||$no_check
                                                ||$check_1
                                                ||$check_2
                                                ||$check_3
                                                ||$check_4
                                                ||$check_5
                                                ||$check_6) {
                                                if(strlen($answerIds)<=0) {
                                                    $answerIds = $question->id;
                                                }
                                                else {
                                                    $answerIds = $answerIds.",".$question->id;
                                                }
                                            }
                                            else {
                                                if(strlen($unAnswerIds)<=0) {
                                                    $unAnswerIds = $question->id;
                                                }
                                                else {
                                                    $unAnswerIds = $unAnswerIds.",".$question->id;
                                                }
                                            }
                                        }

                                        if(isset($question_response[$question->id]['notes']))
                                        {
                                            $notes = $question_response[$question->id]['notes'];
                                        }
                                        else {
                                            $notes = "";
                                        }


                                        ?>
                                            <tr id="question-{{  $question->id }}" class="question-row {{  $question->follow_up ? 'follow-up' : '' }}"
                                                data-question_id="{{ $question->id }}" data-category_id="{{ $question->category_id }}"
                                                data-question_type="{{ $question->type }}"
                                                data-question_follow_up="{{ $question->follow_up }}"
                                                data-question_yes_follow_up="{{ $question->yes_follow_up }}"
                                                data-question_no_follow_up="{{ $question->no_follow_up }}">
                                                <td class="question-number">{{ $count }}</td>
                                                <td>
                                                    {{  $question_data && !empty($question_data->name) ? $question_data->name : '' }}
                                                    <?php if($question->follow_up != 0) { ?>
                                                    <a href="#" title="{{ trans('index.user_ticket_phrase58') }}"
                                                        onclick="showNotes('notes{{  $count }}')">
                                                        <i class="fas fa-comment"></i>
                                                    </a>
                                                    <?php
                                                        }
                                                    ?>
                                                    <div id="notes{{  $count }}" style="display:none;">
                                                        <input type="text" id="txtnotes{{  $question->id }}"
                                                            name="txtnotes{{  $question->id }}" value="{{  $notes }}"
                                                            style="width: 100%;" placeholder="{{ trans('index.user_ticket_phrase58') }}" />
                                                    </div>
                                                    <div class="btn-group dropright tb-drop">
                                                        <select class="form-select" @if($user_edit_permission) onchange="setProgBar({{$question->id}})" @endif >
                                                            @if($question->type == 'mcq')
                                                                <option value="0">{{ trans('index.please_select_ticket') }}</option>
                                                                <option value="1" {{ ($check_1) ?
                                                                     'selected' : '' }}{{
                                                                    (!$user_edit_permission) ?
                                                                    'disabled' : ''
                                                                }}>
                                                                    {{ !empty($question_data->option1) ? $question_data->option1 : '' }}
                                                                </option>
                                                                <option value="2" {{ ($check_2) ?
                                                                    'selected' : '' }}{{
                                                                (!$user_edit_permission) ?
                                                                    'disabled' : ''
                                                                }}>
                                                                    {{ !empty($question_data->option2) ? $question_data->option2 : '' }}
                                                                </option>
                                                                <option value="3" {{ ($check_3) ?
                                                                    'selected' : '' }}{{
                                                                 (!$user_edit_permission) ?
                                                                    'disabled' : ''
                                                                }}>
                                                                    {{ !empty($question_data->option3) ? $question_data->option3 : '' }}
                                                                </option>
                                                                <option value="4" {{ ($check_4) ?
                                                                    'selected' : '' }}{{
                                                                 (!$user_edit_permission) ?
                                                                    'disabled' : ''
                                                                }}>
                                                                    {{ !empty($question_data->option4) ? $question_data->option4 : '' }}
                                                                <option value="5" {{ ($check_5) ?
                                                                    'selected' : '' }}{{
                                                                 (!$user_edit_permission) ?
                                                                    'disabled' : ''
                                                                }}>
                                                                    {{ !empty($question_data->option5) ? $question_data->option5 : '' }}
                                                                <option value="6" {{ ($check_6) ?
                                                                    'selected' : '' }}{{
                                                                 (!$user_edit_permission) ?
                                                                    'disabled' : ''
                                                                }}>
                                                                    {{ !empty($question_data->option6) ? $question_data->option6 : '' }}</option>
                                                            @elseif($question->type=='yes-no')
                                                                <option value="0">{{ trans('index.please_select_ticket') }}</option>
                                                                <option value="1" {{ ($yes_check) ?
                                                                    'selected' : '' }}{{
                                                                 (!$user_edit_permission) ?
                                                                    'disabled' : ''
                                                                }}>
                                                                    {{ trans('index.user_ticket_phrase12') }}</option>
                                                                <option value="1" {{ ($no_check) ?
                                                                    'selected' : '' }}{{
                                                                (!$user_edit_permission) ?
                                                                    'disabled' : ''
                                                                }}>
                                                                    {{ trans('index.user_ticket_phrase13') }}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </td>

                                                @if($question->type == 'mcq')
                                                    <td class="checkbox-td">
                                                        <div class="form-check">
                                                            <label for="check_{{ $key.'_'.$question->id }}" class="form-check-label">
                                                                <input type="radio" id="check_{{ $key.'_'.$question->id }}" name="check_{{ $question->id }}"
                                                                    class="form-check-input mcq-check check_1" @if($question->follow_up == 0) onchange="setProgBar({{$question->id}})" @endif
                                                                    data-tip="no" data-tip_enabled="{{ $question->tip_on_no }}"
                                                                    {{  $check_1 ? 'checked' : '' }} {{  !$user_edit_permission ? 'disabled' : '' }}>
                                                                {{ !empty($question_data->option1) ? $question_data->option1 : '' }}
                                                            </label>
                                                        </div>

                                                        <div class="tip-view-ctn">
                                                            <div class="tip-view yes-tip">
                                                                {!! !empty($question_data->tips_yes) ? htmlspecialchars_decode($question_data->tips_yes, ENT_QUOTES) : '' !!}
                                                            </div>
                                                            <div class="tip-view no-tip">
                                                                {!! !empty($question_data->tips_no) ? htmlspecialchars_decode($question_data->tips_no, ENT_QUOTES):'' !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="checkbox-td">
                                                        <div class="form-check">
                                                            <label for="check_{{  ($key+1).'_'.$question->id }}" class="form-check-label">
                                                                <input type="radio" id="check_{{ ($key+1).'_'.$question->id }}" name="check_{{  $question->id }}"
                                                                    class="form-check-input mcq-check check_2" @if($question->follow_up == 0) onchange="setProgBar({{$question->id}})" @endif
                                                                    data-tip="no" data-tip_enabled="{{  $question->tip_on_no }}"
                                                                    {{  $check_2 ? 'checked' : '' }} {{  !$user_edit_permission ? 'disabled' : '' }}>
                                                                {{ !empty($question_data->option2) ? $question_data->option2 : '' }}
                                                            </label>
                                                        </div>

                                                        <div class="tip-view-ctn">
                                                            <div class="tip-view yes-tip">
                                                                {!! !empty($question_data->tips_yes) ? htmlspecialchars_decode($question_data->tips_yes, ENT_QUOTES) : '' !!}
                                                            </div>
                                                            <div class="tip-view no-tip">
                                                                {!! !empty($question_data->tips_no) ? htmlspecialchars_decode($question_data->tips_no, ENT_QUOTES):'' !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="checkbox-td">
                                                        <div class="form-check">
                                                            <label for="check_{{ ($key+2).'_'.$question->id }}" class="form-check-label">
                                                                <input type="radio" id="check_{{  ($key+2).'_'.$question->id }}" name="check_{{  $question->id }}"
                                                                    class="form-check-input mcq-check check_3" @if($question->follow_up == 0) onchange="setProgBar({{$question->id}})" @endif
                                                                    data-tip="" data-tip_enabled="0" {{  $check_3 ? 'checked' : '' }}
                                                                    {{  !$user_edit_permission ? 'disabled' : '' }}>
                                                                    {{ !empty($question_data->option3) ? $question_data->option3 : '' }}
                                                            </label>
                                                        </div>

                                                        <div class="tip-view-ctn">
                                                            <div class="tip-view yes-tip">
                                                                {!! !empty($question_data->tips_yes) ? htmlspecialchars_decode($question_data->tips_yes, ENT_QUOTES) : '' !!}
                                                            </div>
                                                            <div class="tip-view no-tip">
                                                                {!! !empty($question_data->tips_no) ? htmlspecialchars_decode($question_data->tips_no, ENT_QUOTES):'' !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="checkbox-td">
                                                        <div class="form-check">
                                                            <label for="check_{{  ($key+3).'_'.$question->id }}" class="form-check-label">
                                                                <input type="radio" id="check_{{  ($key+3).'_'.$question->id }}" name="check_{{  $question->id }}"
                                                                    class="form-check-input mcq-check check_4" @if($question->follow_up == 0) onchange="setProgBar({{$question->id}})" @endif
                                                                    data-tip="yes" data-tip_enabled="{{  $question->tip_on_yes }}"
                                                                    {{  $check_4 ? 'checked' : '' }} {{  !$user_edit_permission ? 'disabled' : '' }}>
                                                                    {{ !empty($question_data->option4) ? $question_data->option4 : '' }}
                                                            </label>
                                                        </div>

                                                        <div class="tip-view-ctn">
                                                            <div class="tip-view yes-tip">
                                                                {!! !empty($question_data->tips_yes) ? htmlspecialchars_decode($question_data->tips_yes, ENT_QUOTES) : '' !!}
                                                            </div>
                                                            <div class="tip-view no-tip">
                                                                {!! !empty($question_data->tips_no) ? htmlspecialchars_decode($question_data->tips_no, ENT_QUOTES):'' !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="checkbox-td">
                                                        <div class="form-check">
                                                            <label for="check_{{  ($key+4).'_'.$question->id }}" class="form-check-label">
                                                                <input type="radio" id="check_{{  ($key+4).'_'.$question->id }}" name="check_{{  $question->id }}"
                                                                    class="form-check-input mcq-check check_5" @if($question->follow_up == 0) onchange="setProgBar({{$question->id}})" @endif
                                                                    data-tip="yes" data-tip_enabled="{{  $question->tip_on_yes }}"
                                                                    {{  $check_5 ? 'checked' : '' }} {{  !$user_edit_permission ? 'disabled' : '' }}>
                                                                    {{ !empty($question_data->option5) ? $question_data->option5 : '' }}
                                                            </label>
                                                        </div>

                                                        <div class="tip-view-ctn">
                                                            <div class="tip-view yes-tip">
                                                                {!! !empty($question_data->tips_yes) ? htmlspecialchars_decode($question_data->tips_yes, ENT_QUOTES) : '' !!}
                                                            </div>
                                                            <div class="tip-view no-tip">
                                                                {!! !empty($question_data->tips_no) ? htmlspecialchars_decode($question_data->tips_no, ENT_QUOTES):'' !!}
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="checkbox-td">
                                                        <div class="form-check">
                                                            <label for="check_{{  ($key+5).'_'.$question->id }}" class="form-check-label">
                                                                <input id="check_{{  ($key+5).'_'.$question->id }}" type="radio" name="check_{{  $question->id }}"
                                                                    class="form-check-input mcq-check check_6" @if($question->follow_up == 0) onchange="setProgBar({{$question->id}})" @endif
                                                                    data-tip="yes" data-tip_enabled="{{  $question->tip_on_yes }}"
                                                                    {{  $check_6 ? 'checked' : '' }} {{  !$user_edit_permission ? 'disabled' : '' }}>
                                                                    {{ !empty($question_data->option6) ? $question_data->option6 : '' }}
                                                            </label>
                                                        </div>

                                                        <div class="tip-view-ctn">
                                                            <div class="tip-view yes-tip">
                                                                {!! !empty($question_data->tips_yes) ? htmlspecialchars_decode($question_data->tips_yes, ENT_QUOTES) : '' !!}
                                                            </div>
                                                            <div class="tip-view no-tip">
                                                                {!! !empty($question_data->tips_no) ? htmlspecialchars_decode($question_data->tips_no, ENT_QUOTES):'' !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                @elseif($question->type == 'yes-no')
                                                    <td class="checkbox-td" colspan="2" style="text-align:center;">
                                                        <div class="form-check">
                                                            <label for="check_{{  ($key+6).'_'.$question->id }}" class="form-check-label">
                                                                <input type="radio" id="check_{{  ($key+6).'_'.$question->id }}" name="check_{{  $question->id }}"
                                                                    class="form-check-input yes-check" @if($question->follow_up == 0) onchange="setProgBar({{$question->id}})" @endif
                                                                    data-tip_enabled="{{  $question->tip_on_yes }}" {{  $yes_check ? 'checked' : '' }}
                                                                    {{  !$user_edit_permission ? 'disabled' : '' }}>
                                                                {{ trans('index.user_ticket_phrase12') }}
                                                            </label>
                                                        </div>
                                                        <div class="tip-view-ctn">
                                                            <div class="tip-view">
                                                                {!! !empty($question_data->tips_yes) ? htmlspecialchars_decode($question_data->tips_yes, ENT_QUOTES) : ''!!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="checkbox-td" colspan="3" style="text-align:center;">
                                                        <div class="form-check">
                                                            <label for="check_{{  ($key+7).'_'.$question->id }}" class="form-check-label">
                                                                <input type="radio" id="check_{{  ($key+7).'_'.$question->id }}" name="check_{{  $question->id }}"
                                                                    class="form-check-input no-check" @if($question->follow_up == 0) onchange="setProgBar({{$question->id}})" @endif
                                                                    data-tip_enabled="{{  $question->tip_on_no }}" {{  $no_check ? 'checked' : '' }}
                                                                    {{  !$user_edit_permission ? 'disabled' : '' }}>
                                                                {{ trans('index.user_ticket_phrase13') }}
                                                            </label>
                                                        </div>
                                                        <div class="tip-view-ctn">
                                                            <div class="tip-view">
                                                                {!! !empty($question_data->tips_yes) ? htmlspecialchars_decode($question_data->tips_no, ENT_QUOTES) : '' !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <input name="questionIds" id="questionIds" type="hidden" value="{{ $questionIds }}">
                        <input name="questionIdData" id="questionIdData" type="hidden" value="{{  json_encode($questionIds) }}">
                        <input name="answersIds" id="answerIds" type="hidden" value="{{ $answerIds }}">
                    </div>
                </div>
                <div class="text-center pb-3 pt-3">
                    <div class="d-inline" style="text-align: center;">
                        <button onclick="nextCategory()" class="btn btn-info btn-sm table-page-prev" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </div>
                    <div class="d-inline" style="text-align: center;">
                        <button data-bs-toggle="modal" data-bs-target="#exampleModalPen"
                            class="btn btn-info btn-sm table-page-number" style="width:60%;">1</button>
                    </div>
                    <div class="d-inline" style="text-align: center;">
                        <button id="btnNextQgroup" onclick="nextCategory()" class="btn btn-info btn-sm table-page-next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModalPen" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Category details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="category_text_custom">

                    </div>
                </div>
            </div>
        </div>
        <div id="unanseredCatQues" class="w3-modal" style="display:none">
            <div class="w3-modal-content">
                <div class="w3-container">
                    <span class="w3-button w3-display-topright"></span>
                    <table id="unanswerd-qtable">
                        <tr>
                            <th>{{ trans('index.user_questions_phrase20') }}</th>
                            <th>{{ trans('index.user_sidebar_phrase9') }}</th>
                        </tr>

                        @foreach($available_categories as $category)
                            <tr>
                                <td>
                                    {{  $category['category_name'] }}
                                </td>
                                <td style="padding:5px;">
                                    @php
                                        $unAnswerIdArr = explode(",", $unAnswerIds);
                                        $qNoInCat =  0;
                                    @endphp
                                    @foreach($questions as $question)
                                        @if($question->category_id == $category['category_id'])
                                            @php
                                                $qNoInCat++;
                                            @endphp
                                            @if(in_array($question->id, $unAnswerIdArr))
                                                @php
                                                    $tableRowId = 'question-'.$question->id;
                                                @endphp

                                                <span class="unansered-question-no">
                                                    {{  $qNoInCat }}
                                                </span>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="w3-button-holder">
                        <button id="close-unanseredCatQues" class="btn btn-info">
                            {{ trans('index.text_close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div style="width:100%;text-align:center;">
            @if($user_edit_permission)
                <button id="save_ticket" data-action="{{route('ticket.update', [app()->getLocale(), $ticket->id])}}" class="btn btn-success mb-3 ml-3" data-ticket_id="{{  $ticket ? $ticket->id : '' }}">
                    {{ trans('index.user_ticket_phrase15') }}
                </button>
                @if($answer_count >= $countNotFollowUpQuestion)
                    <button id="submit_ticket" data-action="{{route('ticket.submit', [app()->getLocale(), $ticket->id])}}" class="btn btn-info  mb-3 ml-3" data-ticket_id="{{  $ticket ? $ticket->id : '' }}">
                        {{ trans('index.user_ticket_phrase16') }}
                    </button>
                @endif
            @endif
        </div>

        @if($answer_count >= $countNotFollowUpQuestion && $admin_permission)
            <div class="row user-content-row">
                <div class="col-12">
                    <div class="ticket-method-ctn">
                        <label class="ticket-method-title">
                            {{ trans('index.user_ticket_phrase17') }}
                        </label>
                        @if($answer_count >= $countNotFollowUpQuestion)
                            @if($active_methods)
                                @php
                                    $count = 0;
                                @endphp
                                @foreach($active_methods as $method_key => $method_priority)
                                    @if($method_priority > 0)
                                        @php
                                            $count++;
                                            $method_data = \App\Models\MethodContent::where([['method-id',$method_key],['language_id', $language->id]])->get();
                                        @endphp
                                        <div class="ticket-method-card">
                                            <div class="row">
                                                <div class="col-2 method-card-number">
                                                    {{  $count }}
                                                </div>
                                                <div class="col-7 method-card-title">
                                                    {{  $method_data->name }}
                                                </div>
                                                <div class="col-3 method-card-readmore">
                                                    <button class="btn btn-light btn-sm method-card-btn ticket-method-card-readmore"><i
                                                            class="fas fa-chevron-down"></i></button>
                                                    <button class="btn btn-dark btn-sm method-card-btn method-percent-btn mr-1">
                                                        {{  ((int) (($method_priority / $total_selection) * 100)) . '%' }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 method-card-details ticket-method-card-details">
                                                    {!! !empty($method_data->details) ? htmlspecialchars_decode($method_data->details, ENT_QUOTES) :'' !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @else
                            {{ trans("index.user_ticket_phrase29") }}
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
