@extends('front.user.layouts.app')

@section('content')
<div class="card">
    <div class="card-body p-3">
        <div class="col-12 category">
            <div class="row user-content-row">
                <div class="col-12">
                    <div class="category-single-ctn">
                        <form action="{{ route('report.format.update', ['lang'=>app()->getLocale(), $report_format->id]) }}" enctype="multipart/form-data" method="POST" id="updateReportFormatAjax">
                            @csrf
                            <div class="category-single-title">{{ $language->name }}
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-gray-700">Report Format Name
                                    </div>
                                </div>
                                <input type="text" name='name' class="form-control category-name"
                                    value="{{ ($report_format) ? htmlspecialchars_decode( $report_format->name, ENT_QUOTES): '' }}">
                                <span class="text-danger  validation_errors name_err"></span>
                            </div>
                            <div class="form-group">
                                <label for="category_details_{{ $language->language_code }}">
                                    Report Format Description </label>
                                <input type="text" name='description' class="form-control category-name"
                                value="{{ ($report_format) ? htmlspecialchars_decode( $report_format->description, ENT_QUOTES): '' }}">
                                <span class="text-danger  validation_errors description_err"></span>
                            </div>
                            <div class="form-group">
                                <label for="category_details_{{ $language->language_code }}">
                                    Report Format Content </label>
                                <textarea name='content' id="category_details_{{ $language->language_code }}"
                                    class="form-control category-details">{{ ($report_format) ? htmlspecialchars_decode( $report_format->content, ENT_QUOTES): '' }}</textarea>
                                <span class="text-danger  validation_errors content_err"></span>
                            </div>
                            <div class="form-group">
                                <label for="file">Picture:</label>
                                <input type="file" accept="image/*" class="form-control" id="file" name="image_url" />
                                <span class="text-danger  validation_errors image_url_err"></span>
                                @if(!empty($report_format->image_url))
                                    <div class="col-12" id="preview">
                                        <img class="form-control" src="{{  url($report_format->image_url) }}"
                                            alt="Picture" style="width: 100%;">
                                    </div>
                                @else
                                    <div class="col-12" id="preview">
                                    </div>
                                @endif
                            </div>
                            <button class="btn btn-success category-translation-save"
                                data-lang_code="{{ $language->language_code }}"
                                data-category_id="{{ $report_format->id }}">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
