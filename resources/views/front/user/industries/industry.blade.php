@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="col-12 industry">
                <div class="row user-content-row text-gray-700">
                    <div id="industry_card_ctn" class="col-12">
                        @forelse ($industries as $industry)
                            @php
                                $industry_info = \App\Models\IndustryContent::where([['industry_id', $industry->id], ['language_id', $language->id]])->first();
                            @endphp
                            <div class="industry-card">
                                {{ !empty($industry_info->name) ? $industry_info->name : '' }}
                                <a href="{{ route('industry.edit', [app()->getLocale(), $industry->id]) }}"
                                    class="btn btn-primary btn-sm industry-card-btn">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['industry.destroy', [app()->getLocale(), $industry->id]],
                                    'class' => 'form-inline',
                                ]) !!}
                                {!! Form::button('<i class="fas fa-trash"></i>', [
                                    'type' => 'submit',
                                    'class' => 'industry_delete btn btn-danger btn-sm industry-card-btn del_ delete',
                                    'id' => route('industry.destroy', [app()->getLocale(), $industry->id]),
                                    'data-toggle' => 'modal',
                                    'data-target' => '#myModalDelete',
                                ]) !!}
                                {!! Form::close() !!}
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="row user-content-row new-industry-ctn">
                    <div class="new-industry">
                        <form class="form-inline" action="{{ route('industry.store', ['lang' => app()->getLocale()]) }}"
                            method="POST" id="addIndustryAjax">
                            @csrf
                            <div class="input-group mb-1 ml-1">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-gray-600">{{ trans('index.user_industry_phrase3') }}
                                    </div>
                                </div>
                                <input type="text" id="new_industry_name" name="name" class="form-control">
                                <span class="text-danger validation_errors name_err"></span>
                                <input type="hidden" id="" name="language_id" value="{{ $language->id }}"
                                    class="form-control">
                            </div>
                            <button type="submit" id="" class="btn btn-info mb-1 ml-1">
                                <i class="fas fa-plus"></i> {{ trans('index.user_industry_phrase4') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endsection
