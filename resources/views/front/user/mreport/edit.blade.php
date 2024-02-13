@extends('front.user.layouts.app')

@section('content')
<div class="card">
    <div class="card-body p-3">
        <div class="col-12 category">
            <form method="post" action="{{ route('report.mlreport.update', ['lang' => app()->getLocale(), $report_format->id]) }}"
                id="updMlReportAjax" enctype="multipart/form-data">
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
                        $report_format_data = \App\Models\MlreportFormatContent::where([['report_format_id', $report_format->id], ['language_id', $lang->id]])->first();
                    @endphp
                    <span class="form language language_{{$lang->id}}" style="{{ ($lang->id != $language->id) ? 'display: none' : ''}}">
                        <input type='hidden' value="{{$lang->id}}" name='language_ids[]'>
                        <div class="row user-content-row">
                            <div class="col-12">
                                <div class="category-single-ctn">
                                    <div class="tos-editor-title">{{ $language->name }}
                                        {{ trans("index.user_category_phrase8") }}</div>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text text-gray-700"> {{ trans("index.report_format_title") }}
                                            </div>
                                        </div>
                                        <input type="text" name="report_title[]" class="form-control report-name"
                                            value="{{ ($report_format_data) ? htmlspecialchars_decode( $report_format_data->report_title, ENT_QUOTES): '' }}">
                                        <span class="text-danger validation_errors report_title_{{ $key }}_err"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_details_{{ $lang->language_code }}">
                                            {{ trans("index.report_format_desc") }} </label>
                                        <textarea id="category_details_{{ $lang->language_code }}" name="report_desc[]"
                                            class="form-control category-details">{!! ($report_format_data) ? htmlspecialchars_decode( $report_format_data->report_desc, ENT_QUOTES): '' !!}</textarea>
                                        <span class="text-danger validation_errors report_desc_{{ $key }}_err"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="file"> {{ trans("index.report_format_image") }}:</label>
                                        <input type="file" name="report_image[]" accept="image/*" class="form-control report_image_upload" id="file"/>
                                        <span class="text-danger validation_errors report_image_{{ $key }}_err"></span>
                                    </div>
                                    <div class="col-6" id="preview">
                                        <img src="{{ url($report_format_data->report_image) }}" alt="Report logo" style="width: 250px;height: 229px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </span>
                @empty
                @endforelse
                <button type="submit" class="btn btn-success reportformat-translation-save"
                    data-report_format_id="{{ $report_format->id }}">
                    <i class="fas fa-save"></i> {{ trans("index.user_category_phrase11") }}
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
