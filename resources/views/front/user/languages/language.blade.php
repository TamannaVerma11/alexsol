@extends('front.user.layouts.app')

@section('content')

<div class="card">
    <div class="card-body p-3">
        <div class="row user-content-row">
            <div class="col-12 language">
                <div class="row user-content-row">
                    <table class="table language-table text-gray-700">
                        <thead>
                            <tr>
                                <th style="min-width: 100px" scope="col">
                                    {{ trans("index.user_language_phrase2") }}</th>
                                <th style="min-width: 300px" scope="col">
                                    {{ trans("index.user_language_phrase3") }}</th>
                                <th style="min-width: 200px" scope="col">
                                    {{ trans("index.user_language_phrase4") }}</th>
                                <th scope="col">{{ trans("index.user_language_phrase5") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($languages as $lang)
                                <tr>
                                    <td>
                                        <button class="btn btn-info btn-sm">{{ $lang->language_code }}</button>
                                    </td>
                                    <td scope="row">
                                        <div class="language-name">
                                            <div class="language-name-value">
                                                <form class="form-inline" action="{{ route('language.store', ['lang'=>app()->getLocale()]) }}" method="POST" id="editLanguageAjax">
                                                    @csrf
                                                    <input type='hidden' name="language_id" value="{{ $lang->id }}">
                                                    <input type='hidden' name="language_code" value="{{ $lang->language_code }}">
                                                    <input type="text" name="name" class="form-control form-control-sm" value="{{ $lang->name }}">
                                                    <button type="submit" class="button btn btn-sm btn-success ml-1 mr-1">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                    <span class="text-danger validation_errors name_err"></span>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if( $lang->active )

                                        <span class="language-status">{{ trans("index.user_language_phrase6") }}</span>
                                        @else
                                            <span class="language-status">{{ trans("index.user_language_phrase7") }}</span>
                                        @endif

                                        @if($lang->lang_default)
                                            <span class="language-status"> {{ trans("index.user_language_phrase8") }} </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lang->active)
                                            @if(!$lang->lang_default)
                                                <form class="form_" action="{{ route('language.store', ['lang'=>app()->getLocale()]) }}" method="POST" id="defaultLanguageAjax">
                                                    @csrf
                                                    <input type='hidden' name="language_id" value="{{ $lang->id }}">
                                                    <input type='hidden' name="language_code" value="{{ $lang->language_code }}">
                                                    <input type='hidden' name="name" value="{{ $lang->name }}">
                                                    <input type='hidden' name="lang_default" value="1">
                                                    <input type='hidden' name="active" value="1">
                                                    <button class="btn btn-info btn-sm mb-1 ml-1 default_language"
                                                        data-code="{{ $lang->language_code }}">
                                                        <i class="fas fa-check-square"></i>
                                                        {{ trans("index.user_language_phrase9") }}
                                                    </button>
                                                </form>
                                            @endif
                                            <form class="form_" action="{{ route('language.store', ['lang'=>app()->getLocale()]) }}" method="POST" id="deactivateLanguageAjax">
                                                @csrf
                                                <input type='hidden' name="language_id" value="{{ $lang->id }}">
                                                <input type='hidden' name="language_code" value="{{ $lang->language_code }}">
                                                <input type='hidden' name="name" value="{{ $lang->name }}">
                                                <input type='hidden' name="active" value="0">
                                                <input type='hidden' name="lang_default" value="0">
                                                <button class="btn btn-warning btn-sm mb-1 ml-1 deactivate_language"
                                                    data-code="{{ $lang->language_code }}"
                                                    {{ ($lang->lang_default) ? 'disabled': '' }}>
                                                    <i class="fas fa-pause"></i>
                                                    {{ trans("index.user_language_phrase10") }}
                                                </button>
                                            </form>
                                        @else
                                            <form class="form_" action="{{ route('language.store', ['lang'=>app()->getLocale()]) }}" method="POST" id="activateLanguageAjax">
                                                @csrf
                                                <input type='hidden' name="language_id" value="{{ $lang->id }}">
                                                <input type='hidden' name="language_code" value="{{ $lang->language_code }}">
                                                <input type='hidden' name="name" value="{{ $lang->name }}">
                                                <input type='hidden' name="active" value="1">
                                                <input type='hidden' name="lang_default" value="0">
                                                <button class="btn btn-success btn-sm mb-1 ml-1 activate_language"
                                                    data-code="{{ $lang->language_code }}">
                                                    <i class="fas fa-check"></i>
                                                    {{ trans("index.user_language_phrase11") }}
                                                </button>
                                            </form>
                                        @endif
                                        @if($lang->language_code != 'en')
                                            {!! Form::open(['method' => 'DELETE','route' => ['language.destroy', [app()->getLocale(), $lang->id]],'style'=>'display:inline']) !!}
                                            {!! Form::button( '<i class="fas fa-trash"></i>', ['type' => 'submit', 'class' => 'industry_delete btn btn-danger btn-sm language-card-btn del_ delete', 'id' => route('language.destroy', [app()->getLocale(), $lang->id]), 'data-toggle' => 'modal', 'data-target' => '#myModalDelete'] ) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row user-content-row new-language-ctn">
                    <div class="new-language">
                        <form class="form-inline" action="{{ route('language.store', ['lang'=>app()->getLocale()]) }}" method="POST" id="addLanguageAjax">
                                @csrf
                            <div class="input-group input-group-sm mb-1 ml-1">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ trans("index.user_language_phrase2") }}
                                    </div>
                                </div>
                                <input type="text" id="new_language_code" name="language_code" class="form-control">
                                <span class="text-danger validation_errors language_code_err"></span>
                            </div>
                            <div class="input-group input-group-sm mb-1 ml-1">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">{{ trans("index.user_language_phrase3") }}
                                    </div>
                                </div>
                                <input type="text" id="new_language_name" name="name" class="form-control">
                                <span class="text-danger validation_errors name_err"></span>
                            </div>
                            <button type="submit" id="" class="btn btn-info btn-sm mb-1 ml-1"><i
                                    class="fas fa-plus"></i>
                                {{ trans("index.user_language_phrase13") }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
