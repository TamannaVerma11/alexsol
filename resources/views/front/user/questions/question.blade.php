@extends('front.user.layouts.app')

@section('content')

<div class="card">
    <div class="card-body p-3">
        <div class="row user-content-row">
            <div class="col-12 question">
                @if (auth()->user()->user_type == 'admin_super')
                    <div class="row user-content-row">
                        <div class="col-12">
                            <form action="{{ route('question.index', ['lang' => app()->getLocale()]) }}" class="form-inline">
                                <label class="question-title"> {{ trans('index.user_questions_phrase14') }} </label>
                                <select id="method_view" class="form-control form-control-sm">
                                    <option value="" selected>{{ trans('index.user_questions_phrase15') }}</option>
                                    @forelse ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ isset(request()->company) && $company->id == request()->company ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </form>
                        </div>
                    </div>
                @endif
                <div class="row user-content-row">
                    <div id="question_card_ctn" class="col-12">
                        @forelse ($questions as $key=>$question)
                            @php
                                $question_info = \App\Models\QuestionContent::where([['question_id', $question->id],['language_id', $language->id]])->first();
                            @endphp
                            <div class="question-card text-gray-700 category" style="width:100%;display: flex;gap: 40px;min-height:unset">
                                <div style="width:75%;">
                                    <label class="question-title text-gray-600">{{ trans('index.user_questions_phrase16') }} {{ $key+1 }}
                                        :
                                        {{ !empty($question_info->name) ? $question_info->name : '' }} </label>
                                </div>
                                <div style="width:25%;margin-bottom: 10px;" class="category-card">
                                    @if (auth()->user()->user_type == 'admin_super')
                                        @if (isset(request()->company) && !empty(request()->company))
                                            <a href="/user/index.php?route=questions&id={{ $question->id }}&company={{ $_GET['company'] }}"
                                                class="btn btn-primary btn-sm question-card-btn">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('question.edit', [app()->getLocale(), $question->id]) }}"
                                                class="btn btn-primary btn-sm question-card-btn">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif

                                        {!! Form::open(['method' => 'DELETE', 'route' => ['question.destroy', [app()->getLocale(), $question->id]], 'class' => 'form-inline']) !!}
                                        {!! Form::button('<i class="fas fa-trash"></i>', [
                                            'type' => 'submit',
                                            'class' => 'category_delete question-card-btn btn btn-danger del_ delete',
                                            'id' => route('question.destroy', [app()->getLocale(), $question->id]),
                                            'data-toggle' => 'modal',
                                            'data-target' => '#myModalDelete',
                                        ]) !!}
                                        {!! Form::close() !!}
                                    @endif
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                @if (auth()->user()->user_type == 'admin_super')
                    <div class="row user-content-row new-question-ctn">
                        <div class="new-question">
                            <form class="form-inline" action="{{ route('question.store', ['lang' => app()->getLocale()]) }}"
                                method="POST" id="addQuestionAjax">
                                @csrf
                                <div class="input-group mb-1 ml-1">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text text-gray-600">{{ trans('index.user_questions_phrase16') }}</div>
                                    </div>
                                    <input type="text" id="new_question_name" name="name" class="form-control">
                                    <span class="text-danger validation_errors name_err"></span>
                                    <input type="hidden" id="" name="language_id" value="{{ $language->id }}">
                                    <input type="hidden" id="" name="is_response" value="{{ $is_response }}">
                                </div>
                                <button type="submit" id="" class="btn btn-info mb-1 ml-1">
                                    <i class="fas fa-plus"></i> {{ trans('index.user_questions_phrase18') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
