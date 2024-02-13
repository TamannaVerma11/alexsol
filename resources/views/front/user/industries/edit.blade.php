@extends('front.user.layouts.app')

@section('content')

<div class="card">
    <div class="card-body p-3">
    <div class="col-12 industry">
        <form action="{{ route('industry.update', ['lang'=>app()->getLocale(), $industry->id]) }}" method="POST" id="updateIndustryAjax">
            @csrf
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
                    $industry_data = \App\Models\IndustryContent::where([['industry_id', $industry->id], ['language_id', $lang->id]])->first();
                @endphp
                <span class="form language language_{{$lang->id}}" style="{{ ($lang->id != $language->id) ? 'display: none' : ''}}">
                    <input type='hidden' value="{{$lang->id}}" name='language_ids[]'>
                    <div class="row user-content-row">
                        <div class="col-12">
                            <div class="industry-single-ctn">
                                <div class="tos-editor-title">{{  $lang->name }} {{ trans("index.user_industry_phrase7") }}</div>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text text-gray-600">{{ trans("index.user_industry_phrase8") }}</div>
                                    </div>
                                    <input type="text" name="name[]" class="form-control industry-name" value="{{ ($industry_data) ? $industry_data->name: '' }}">
                                    <span class="text-danger  validation_errors name_{{$key}}_err"></span>
                                </div>
                                <div class="form-group">
                                    <label for="industry_details_{{ $lang->language_code }}"> {{ trans("index.user_industry_phrase9") }} </label>
                                    <textarea name="details[]" id="industry_details_{{ $lang->language_code }}" class="form-control industry-details">{!! ($industry_data) ? htmlspecialchars_decode( $industry_data->details, ENT_QUOTES): '' !!}</textarea>
                                    <span class="text-danger  validation_errors details_{{$key}}_err"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>
            @empty
            @endforelse
            <button class="btn btn-success industry-translation-save">
                <i class="fas fa-save"></i> {{ trans("index.user_industry_phrase10") }}
            </button>
        </form>
    </div>
@endsection
