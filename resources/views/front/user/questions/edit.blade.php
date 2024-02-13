@extends('front.user.layouts.app')

@section('content')

<div class="card">
    <div class="card-body p-3">
        <div class="row user-content-row">
            <form method="POST" action="{{ route('question.update', ['lang' => app()->getLocale(), $question->id]) }}"
                 id="updQuestionAjax">
                @csrf
                <div class="col-12 question">
                    <div class="row user-content-row">
                        <div class="col-12">
                            <div class="question-single-ctn">
                                <div class="question-single-title"> {{ trans('index.user_questions_phrase22') }} </div>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <label for="question_type" class="question-title">Type: </label>
                                        <select class="form-control form-control-sm" name="type" id="question_type"
                                            data-question_id="{{ $question->id }}">
                                            <option value="yes-no" {{ (!empty(request()->type && request()->type=='yes-no')) || (empty(request()->type) && $question->type == 'yes-no') ? 'selected' : '' }}>
                                                {{ trans('index.user_yes_no') }}
                                            </option>
                                            <option value="mcq" {{ (!empty(request()->type && request()->type=='mcq')) || (empty(request()->type) && $question->type == 'mcq') ? 'selected' : '' }}>
                                                {{ trans('index.user_mcq') }}
                                            </option>
                                        </select>
                                        <span class="text-danger validation_errors type_err"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="question_type" class="question-title"> {{ trans('index.user_que_follow') }}: </label>
                                        <select class="form-control form-control-sm" name="follow_up" id="question_follow_up"
                                            data-question_id="{{ $question->id }}">
                                            <option value="0" {{ !$question->follow_up ? 'selected' : '' }}>
                                                {{ trans('index.user_ticket_phrase13') }}</option>
                                            <option value="1" {{ $question->follow_up ? 'selected' : '' }}>
                                                {{ trans('index.user_ticket_phrase12') }}
                                            </option>
                                        </select>
                                        <span class="text-danger validation_errors follow_up_err"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row user-content-row">
                        <div class="col-12">
                            <div class="question-single-ctn">
                                <div class="question-single-title"> {{ trans('index.user_questions_phrase2') }} </div>
                                <!-- Question category -->
                                @if (!$question->follow_up)
                                    <div class="form-group mt-1 ml-1">
                                        <label class="question-title"> {{ trans('index.user_questions_phrase20') }} </label>
                                        <select id="question_category" name="category_id" class="form-control form-control-sm">
                                            <option value="">{{ trans('index.user_questions_phrase21') }}</option>
                                            @forelse ($categories as $category)
                                                @php
                                                    $category_data = \App\Models\CategoryContent::where([['category_id', $category->id], ['language_id', $language->id]])->first();
                                                @endphp
                                                <option value="{{ $category->id }}"
                                                    {{ $question->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category_data->name }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        <span class="text-danger validation_errors category_id_err"></span>
                                    </div>
                                @endif
                                <!-- Methods assignment for yes respons -->
                                <div class="form-group mt-1 ml-1">
                                    <label class="question-title"> {{ trans('index.user_questions_phrase3') }} </label>
                                    <select id="question_methods_yes" name="yes_access[]" class="form-control form-control-sm" multiple>
                                        @forelse ($methods as $key=>$method)
                                            @php
                                                $method_data = \App\Models\MethodContent::where([['method_id', $method->id], ['language_id', $language->id]])->first();
                                            @endphp
                                            <option value="{{$method->id}}"
                                                {{ ($yes_access && is_array($yes_access) && in_array($method->id, $yes_access)) ? 'selected' : ''}}> Method {{ $key+1 }}: {{ $method_data->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <span class="text-danger validation_errors yes_access_err"></span>
                                </div>
                                <!--Methods assignment for no response-->
                                <div class="form-group mt-1 ml-1">
                                    <label class="question-title"> {{ trans('index.user_questions_phrase4') }} </label>
                                    <select id="question_methods_no" name="no_access[]" class="form-control form-control-sm" multiple>
                                        @forelse ($methods as $key=>$method)
                                            @php
                                                $method_data = \App\Models\MethodContent::where([['method_id', $method->id], ['language_id', $language->id]])->first();
                                            @endphp
                                            <option value="{{$method->id}}"
                                                {{ ($no_access && is_array($no_access) && in_array($method->id, $no_access)) ? 'selected' : ''}}> Method {{ $key+1 }}: {{ $method_data->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <span class="text-danger validation_errors no_access_err"></span>
                                </div>
                                <!--Tipbox option-->
                                <div class="form-row">
                                    <div class="col-9">
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tips" value="yes"
                                                    id="question_activate_tip_yes" {{ $question->tip_on_yes ? 'checked' : '' }}>
                                                <span class="text-danger validation_errors tip_on_yes_err"></span>
                                                <label class="form-check-label" for="question_activate_tip_yes">
                                                    {{ trans('index.user_questions_phrase5') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tips" value="no"
                                                    id="question_activate_tip_no" {{ $question->tip_on_no ? 'checked' : '' }}>
                                                <span class="text-danger validation_errors tip_on_no_err"></span>
                                                <label class="form-check-label" for="question_activate_tip_no">
                                                    {{ trans('index.user_questions_phrase6') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Follow-up question -->
                                @if (!$question->follow_up)
                                    @php
                                        $f_questions = [['question_id' => '', 'question_name' => trans('index.user_questions_phrase25')]];
                                    @endphp
                                    @forelse ($follow_up_questions as $follow_up_question)
                                        @php
                                            $fq_id = $follow_up_question->id;
                                            $fq_data = \App\Models\QuestionContent::where([['question_id', $follow_up_question->id], ['language_id', $language->id]])->first();
                                        @endphp
                                        @php
                                            $fq_name = $fq_data->name;
                                            array_push($f_questions, ['question_id' => $fq_id, 'question_name' => $fq_name]);
                                        @endphp
                                    @empty
                                    @endforelse
                                    <div class="form-row">
                                        <div class="col-auto"
                                            style="margin-top: 12px; display: grid; grid-template-columns: 1fr 3fr">
                                            <label class="question-title"> {{ trans('index.user_questions_phrase23') }} </label>
                                            <select id="question_follow_up_yes" name="yes_follow_up" class="form-control form-control-sm">
                                                @forelse ($f_questions as $follow_up_question)
                                                    <option value="{{ $follow_up_question['question_id'] }}"
                                                        {{ ($question->yes_follow_up == $follow_up_question['question_id']) ? 'selected' : '' }}>
                                                        {{ $follow_up_question['question_name'] }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            <span class="text-danger validation_errors yes_follow_up_err"></span>
                                        </div>
                                        <div class="col-auto"
                                            style="margin-top: 12px; display: grid; grid-template-columns: 1fr 3fr">
                                            <label class="question-title"> {{ trans('index.user_questions_phrase24') }} </label>
                                            <select id="question_follow_up_no" name="no_follow_up" class="form-control form-control-sm">
                                                @forelse ($f_questions as $follow_up_question)
                                                    <option value="{{ $follow_up_question['question_id'] }}"
                                                        {{ ($question->no_follow_up == $follow_up_question['question_id']) ? 'selected' : '' }}>
                                                        {{ $follow_up_question['question_name'] }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            <span class="text-danger validation_errors no_follow_up_err"></span>
                                        </div>
                                        <div class="col-auto"
                                            style="margin-top: 12px;margin-bottom: 12px; display: grid; grid-template-columns: 3fr 1fr 3fr 3fr 1fr 4fr">
                                            <label class="question-title"> {{ trans('index.user_questions_titleJA') }}</label>
                                            <div><input style="width: 24px;" name="weight_yes" type="text" value="{{ $question->weight_yes }}"
                                                    disabled>
                                                    <span class="text-danger validation_errors weight_yes_err"></span>
                                                </div>
                                            <div></div>
                                            <label class="question-title"> {{ trans('index.user_questions_titleNEI') }}</label>
                                            <div><input style="width: 24px;" name="weight_no" type="text" value="{{ $question->weight_no }}"
                                                    disabled>
                                                    <span class="text-danger validation_errors weight_no_err"></span>
                                            </div>
                                            <div></div>
                                        </div>

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="language_select_box">{{ trans('index.user_package_phrase15') }}</label>
                        <select id="language_select_box" class="form-control" onchange="editLanguage(this.value)">
                            @forelse ($languages as $language_)
                                <option value="{{$language_->id}}" {{ ($language_->id == $language->id) ? "selected": "" }}>{{ $language_->name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    @forelse ($languages as $key=>$lang)
                        @php
                            $question_data = \App\Models\QuestionContent::where([['question_id', $question->id], ['language_id', $lang->id]])->first();
                        @endphp
                        <span class="form language language_{{$lang->id}}" style="{{ ($lang->id != $language->id) ? 'display: none' : ''}}">
                            <input type='hidden' value="{{$lang->id}}" name='language_ids[]'>

                            <div class="row user-content-row">
                                <div class="col-12">
                                    <div class="question-single-ctn">
                                        <div class="tos-editor-title">{{$lang->name}}{{ trans('index.user_questions_phrase9') }}</div>
                                            <div class="input-group mb-1">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text text-gray-600">{{ trans('index.user_questions_phrase10') }}</div>
                                            </div>
                                            <input type="text" class="form-control question-name" name="name[]" value="{{ $question_data ? $question_data->name : '' }}">
                                        </div>
                                        <span class="text-danger  validation_errors name_{{ $key }}_err"></span>
                                        @if ( (empty(request()->type) && $question->type == 'mcq') || (!empty(request()->type) && request()->type == 'mcq'))
                                            <div class="form-row mb-3">
                                                <div class="col-auto">
                                                    <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-gray-600">{{ trans('index.user_option1') }}</div>
                                                        </div>
                                                        <input type="text" name="option1[]" class="form-control form-control-sm question_option1"
                                                            value="{{ $question_data ? htmlspecialchars_decode($question_data->option1, ENT_QUOTES) : '' }}">
                                                        <span class="text-danger  validation_errors option1{{ $key }}_err"></span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-gray-600">{{ trans('index.user_option2') }}</div>
                                                        </div>
                                                        <input type="text" name="option2[]" class="form-control form-control-sm question_option2"
                                                            value="{{ $question_data ? htmlspecialchars_decode($question_data->option2, ENT_QUOTES) : '' }}">
                                                        <span class="text-danger  validation_errors option2{{ $key }}_err"></span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-gray-600">{{ trans('index.user_option3') }}</div>
                                                        </div>
                                                        <input type="text" name="option3[]" class="form-control form-control-sm question_option3"
                                                            value="{{ $question_data ? htmlspecialchars_decode($question_data->option3, ENT_QUOTES) : '' }}">
                                                        <span class="text-danger  validation_errors option3{{ $key }}_err"></span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-gray-600">{{ trans('index.user_option4') }}</div>
                                                        </div>
                                                        <input type="text" name="option4[]" class="form-control form-control-sm question_option4"
                                                            value="{{ $question_data ? htmlspecialchars_decode($question_data->option4, ENT_QUOTES) : '' }}">
                                                        <span class="text-danger  validation_errors option4{{ $key }}_err"></span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-gray-600">{{ trans('index.user_option5') }}</div>
                                                        </div>
                                                        <input type="text" name="option5[]" class="form-control form-control-sm question_option5"
                                                            value="{{ $question_data ? htmlspecialchars_decode($question_data->option5, ENT_QUOTES) : '' }}">
                                                        <span class="text-danger  validation_errors option5{{ $key }}_err"></span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text text-gray-600">{{ trans('index.user_option6') }}</div>
                                                        </div>
                                                        <input type="text" name="option6[]" class="form-control form-control-sm question_option6"
                                                            value="{{ $question_data ? htmlspecialchars_decode($question_data->option6, ENT_QUOTES) : '' }}">
                                                        <span class="text-danger  validation_errors option6{{ $key }}_err"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="question_tip_yes_{{ $lang->language_code }}"> {{ trans('index.user_questions_phrase11') }} </label>
                                            <textarea name="tips_yes[]" id="question_tip_yes_{{ $lang->language_code }}" class="form-control question-tips-yes">{{ $question_data ? htmlspecialchars_decode($question_data->tips_yes, ENT_QUOTES) : '' }}</textarea>
                                        </div>
                                        <span class="text-danger  validation_errors tips_yes{{ $key }}_err"></span>
                                        <div class="form-group">
                                            <label for="question_tip_no_{{ $lang->language_code }}"> {{ trans('index.user_questions_phrase12') }} </label>
                                            <textarea name="tips_no[]" id="question_tip_no_{{ $lang->language_code }}" class="form-control question-tips-no">{{ $question_data ? htmlspecialchars_decode($question_data->tips_no, ENT_QUOTES) : '' }}</textarea>
                                        </div>
                                        <span class="text-danger  validation_errors tips_no{{ $key }}_err"></span>
                                    </div>
                                </div>
                            </div>
                        </span>
                    @empty
                    @endforelse
                </div>
                <input type="hidden" id="" name="is_response" value="{{ $is_response }}">

                <button class="btn btn-success" type="submit">
                    <i class="fas fa-save"></i> {{ trans('index.user_questions_phrase13') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
