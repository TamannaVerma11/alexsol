@extends('front.user.layouts.app')

@section('content')
<div class="card">
    <div class="card-body p-3">
        <div class="col-12 category">
            <div class="row user-content-row">
                <div id="category_card_ctn" class="col-12">
                    @forelse ($report_formats as $report_format)
                        @php
                            $category_info = \App\Models\MlreportFormatContent::where([['report_format_id', $report_format->id], ['language_id', $language->id]])->first()
                        @endphp
                        <div class="category-card text-gray-700" id="cat_{{ $report_format->id }}">
                            {{ !empty($category_info->report_title) ? $category_info->report_title : '' }}
                            <a href="{{ route('report.mlreport.composer', [app()->getLocale(), $report_format->id]) }}"
                                class="btn btn-primary btn-sm report_format_composer-card-btn">
                                <i class="fas fa-stream"></i>
                            </a>
                            <a href="{{ route('report.mlreport.edit', [app()->getLocale(), $report_format->id]) }}"
                                class="btn btn-primary btn-sm category-card-btn">
                                <i class="fas fa-edit"></i>
                            </a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['report.mlreport.destroy', [app()->getLocale(), $report_format->id]], 'class' => 'form-inline']) !!}
                            {!! Form::button('<i class="fas fa-trash"></i>', [
                                'type' => 'submit',
                                'class' => 'report_delete question-card-btn btn btn-danger del_ delete',
                                'id' => route('report.mlreport.destroy', [app()->getLocale(), $report_format->id]),
                                'data-toggle' => 'modal',
                                'data-target' => '#myModalDelete',
                            ]) !!}
                            {!! Form::close() !!}
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div class="row user-content-row new-category-ctn">
                <div class="new-category">
                    <form class="form-inline" action="{{ route('report.mlreport.store', ['lang' => app()->getLocale()]) }}"
                        method="POST" id="addMlReportAjax">
                        @csrf
                        <div class="input-group mb-1 ml-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text text-gray-600">{{ trans("index.report_new") }}
                                </div>
                            </div>
                            <input type="text" id="new_report_name" name="report_title" class="form-control">
                            <span class="text-danger validation_errors report_title_err"></span>
                        </div>
                        <input type="hidden" id="" name="language_id" value="{{ $language->id }}">
                        <button type="submit" id="" class="btn btn-info mb-1 ml-1">
                            <i class="fas fa-plus"></i> {{ trans("index.user_category_phrase5") }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
