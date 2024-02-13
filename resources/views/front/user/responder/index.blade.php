@extends('front._layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ url('css/table.css') }}">
    <link rel="stylesheet" href="{{ url('css/custom-datatable.css') }}">
    <link rel="stylesheet" href="{{ url('css/user_header.css') }}">
    <link rel="stylesheet" href="{{ url('css/user.css') }}">
    <link rel="stylesheet" href="{{ url('css/custom-new.css') }}">
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ url('vendor/jquery-3.4.1/jquery.min.js') }}"></script>
    <script>
        var changeLocale = '{{route('changeLocale', app()->getLocale())}}';
        var tosWithCompURL = '{{route('tos.index_with_comp', app()->getLocale())}}';
        var optionURL    = '{{ route('support.option.update', ['lang'=>app()->getLocale()]) }}';
        var csrfToken = '{{ csrf_token() }}';
        var user_tickets_phrase10 = '{{ trans('index.user_tickets_phrase10') }}';
        var message_no_of_rec = '{{ trans('index.message_no_of_rec') }}';
        var text_previous = '{{ trans('index.text_previous') }}';
        var text_next = '{{ trans('index.text_next') }}';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript" src="{{ url('js/custom-datatable.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/toastr/toastr.min.js') }}"></script>
    <script src="{{ url('assets/js/custom.js') }}"></script>
    <script src="{{ url('js/user.js') }}"></script>
    <div style="margin:10px;width:100%;text-align:right;">
        <a role="button" href="#" style="margin-right:20px;" onclick="unAnseredQuestionFocus()">
            {{ trans('index.text_unansered_qeustion') }}
        </a>
    </div>

    <div>
        {{ trans('index.pdf_report_phrase2') }}
        <span id="pageNumber"></span>
        {{ trans('index.text_of') }}
        <span id="totalPages"></span>
    </div>

    <!-- Page: Question -->
    <div>
        <div> {{ trans('index.user_ticket_phrase55') }}</div>
        <div class="progress">
            <div id="progressbar" class="progress-bar bg-success" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                aria-valuemax="100" style="width:0%">
                <span id="label-progressbar"></span>
            </div>
        </div>
        <div style="display:none;text-align: center;font-size: 17px;" id="alertSectionsuccess2"></div>
        <input type="hidden" name="pageNum" id="pageNum" value="{{ $pageNum }}" />
        <div class="row user-content-row">
            <div class="col-12">
                <div class="table-fixed-header">
                    <table class="table table-bordered question-table">
                        <thead>
                            <tr>
                                <th class="quesiton_id" width="1%">{{ trans('index.user_ticket_phrase10') }}</th>
                                <th class="quesiton" width="60%">{{ trans('index.user_ticket_phrase11') }}</th>
                                <td class="answer" colspan="5" style="text-align:center;">{{ trans('index.user_ticket_phrase27') }}</td>
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

                    <input name="questionIds" id="questionIds" type="hidden"
                        value="{{ $questionIds }}">
                    <input name="answersIds" id="answerIds" type="hidden"
                            value="{{ $answerIds }}">

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
                            <button id="btnNextQgroup" onclick="nextCategory()"
                                class="btn btn-info btn-sm table-page-next">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
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
                <button id="save_responder_ticket" data-action="{{route('responder.update', [app()->getLocale(), $ticket->id, request()->responder])}}" class="btn btn-success mb-3 ml-3" data-ticket_id="{{  $ticket ? $ticket->id : '' }}">
                    {{ trans('index.user_ticket_phrase15') }}
                </button>
            @endif
        </div>

        <script>
            let responder_id = '{{ request()->responder }}';
            //Save ticket
            $('#save_responder_ticket').click(function(event) {
                let response = {};
                let ticket_id = $(this).data('ticket_id');
                let validation = true;
                $('.question-row').each(function () {
                    let question_id = $(this).data('question_id');
                    let answer;
                    let q_type = $(this).data('question_type');
                    let q_follow_up = $(this).data('question_follow_up');
                    let q_yes_follow_up = $(this).data('question_yes_follow_up');
                    let q_no_follow_up = $(this).data('question_no_follow_up');
                    let q_notes = $('#txtnotes' + question_id).val();

                    if ($(this).data('question_type') == 'mcq') {
                        if ($(this).find('.check_1').is(':checked')) answer = 1;
                        else if ($(this).find('.check_2').is(':checked')) answer = 2;
                        else if ($(this).find('.check_3').is(':checked')) answer = 3;
                        else if ($(this).find('.check_4').is(':checked')) answer = 4;
                        else if ($(this).find('.check_5').is(':checked')) answer = 5;
                        else if ($(this).find('.check_6').is(':checked')) answer = 6;
                        else answer = 0;
                    } else if ($(this).data('question_type') == 'yes-no') {
                        if ($(this).find('.yes-check').is(':checked')) answer = 2;
                        else if ($(this).find('.no-check').is(':checked')) answer = 1;
                        else answer = 0;
                    }

                    response[question_id] = {
                        "answer": answer,
                        "type": q_type,
                        "follow-up": q_follow_up,
                        "yes-follow-up": q_yes_follow_up,
                        "no-follow-up": q_no_follow_up,
                        "notes": q_notes
                    }

                });

                response = JSON.stringify(response);

                $.ajax({
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: $(this).data('action'),
                    type: 'POST',
                    data: {'response': response, 'ticket_id': ticket_id, 'responder_id': responder_id},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status == 'success') {
                            var shortCutFunction = "success"; //success, error, warning, info
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                positionClass: 'toast-top-center',
                            };
                            toastr.options.timeOut = "10000";
                            var $toast = toastr[shortCutFunction]("Success");

                            window.location = data.redirect;
                        }
                        else{
                            message = data.message;
                            var shortCutFunction = "error"; //success, error, warning, info
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                positionClass: 'toast-top-center',
                            };
                            toastr.options.timeOut = "10000";
                            var $toast = toastr[shortCutFunction](message);
                        }
                    },
                    error: function (data) {
                        message = '';
                        if($.inArray('message'), data.responseJSON){
                            message = data.responseJSON.message;
                            var shortCutFunction = "error"; //success, error, warning, info
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                positionClass: 'toast-top-center',
                            };
                            toastr.options.timeOut = "10000";
                            var $toast = toastr[shortCutFunction](message);
                        }
                    },
                });

                return false;
            });
        </script>
        <!-- Modal -->
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
@endsection
