@extends('front.user.layouts.app')

@section('content')
<div class="card">
    <div class="card-body p-3">
        <div class="col-12 category">
            <div class="row user-content-row">
                <div id="category_card_ctn" class="col-12">
                    @forelse ($report_formats as $report_format)
                        <div class="category-card text-gray-700" id="rf_{{  $report_format->id }}">
                            {{  $report_format->name }}
                            <br>
                            {{  $report_format->description }}
                            <a href="{{ route('report.format.show', [app()->getLocale(), $report_format->id]) }}"
                                class="btn btn-primary btn-sm category-card-btn">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('report.composer', [app()->getLocale(), $report_format->id]) }}"
                                class="btn btn-primary btn-sm report_format_composer-card-btn">
                                <i class="fas fa-stream"></i>
                            </a>
                            {!! Form::open(['method' => 'DELETE','route' => ['report.format.destroy', [app()->getLocale(), $report_format->id]],'style'=>'display:inline;margin-top: -37px;']) !!}
                            {!! Form::submit( 'Del', ['class' => 'category_delete btn btn-danger btn-sm  del_ delete', 'id' => route('report.format.destroy', [app()->getLocale(), $report_format->id]), 'data-toggle' => 'modal', 'data-target' => '#myModalDelete']) !!}
                            {!! Form::close() !!}
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div class="row user-content-row new-report_format-ctn">
                <div class="new-report_format">
                    <form class='form-inline' action="{{ route('report.format.store', ['lang'=>app()->getLocale()]) }}" method="POST" id="addReportFormatAjax">
                        @csrf
                        <div class="input-group mb-1 ml-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text text-gray-600">Report Format Name
                                </div>
                            </div>
                            <input type="text" id="new_report_format_name" name='name' class="form-control">
                            <span class="text-danger  validation_errors name_err"></span>
                        </div>
                        <br>
                        <div class="input-group mb-1 ml-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text text-gray-600">Report Format Description
                                </div>
                            </div>
                            <input type="text" id="new_report_format_description" name='description' class="form-control">
                            <span class="text-danger  validation_errors description_err"></span>
                        </div>
                        <button type="submit" id="" class="btn btn-info mb-1 ml-1">
                            <i class="fas fa-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
