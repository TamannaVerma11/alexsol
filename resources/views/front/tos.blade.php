@extends('front._layouts.app')

@section('content')
    <div class="main-tos-ctn">
        <div class="tos-title">{{ trans('index.main_tos_phrase1')}}
        </div>

        <div class="tos-data">
            {!! html_entity_decode($tos_content->content) !!}
        </div>
        <div class="w3-button-holder">
            <a href="javascript:void(0)" onclick="history.go(-1);" class="btn btn-info btn-small mt-2 mb-2">
                {{ trans('index.main_tos_phrase2')}}
            </a>
        </div>
    </div>
@endsection
