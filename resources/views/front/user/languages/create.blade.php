@extends('back.layouts.app')

@section('content')
    <div class="p-4 rounded">
        <div class="d-xl-flex justify-content-between align-items-start">
            <h2 class="text-dark font-weight-bold mb-2">{{ trans('back.newLang') }}</h2>
        </div>

        <div class="container mt-4">
 
            <form method="POST" action="{{ route('back.languages.store', [app()->getLocale()]) }}">
                @csrf

                <div class="container">

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ trans('back.name') }}</label>
                        <input value="{{ old('name') }}"
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name"
                            placeholder="{{ trans('back.name') }}" required>

                        @error ('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="language_code" class="form-label">{{ trans('back.language_code') }}</label>
                        <input value="{{ old('language_code') }}"
                            type="text"
                            class="form-control @error('language_code') is-invalid @enderror"
                            name="language_code"
                            placeholder="{{ trans('back.language_code') }}" required>

                        @error ('language_code')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">{{ trans('back.save') }}</button>
                <a href="{{ route('back.languages.index', app()->getLocale()) }}" class="btn btn-default">{{ trans('back.goback') }}</a>
            </form>
        </div>

    </div>
@endsection
