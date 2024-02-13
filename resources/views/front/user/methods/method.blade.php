@extends('front.user.layouts.app')

@section('content')

    <div class="card">
        <div class="card-body p-3">
            <div class="col-12 method">
                <div class="row user-content-row">
                    <div class="col-12">
                        <form action="{{ route('method.index', ['lang' => app()->getLocale()]) }}" class="form-inline">
                            <label class="method-title">{{ trans('index.user_methods_phrase12') }} </label>
                            <select id="method_view" name="company_id" class="form-control form-control-sm">
                                <option value="0">
                                    {{ trans('index.user_methods_phrase3') }}</option>
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
                <div class="row user-content-row">
                    <div id="method_card_ctn" class="col-12">
                        @if (isset(request()->company) && !empty(request()->company))
                            @php
                                $company = \App\Models\Company::find(request()->company);
                            @endphp
                            @if ($company && !empty($company->id))
                                @php
                                    $methods = \App\Models\Method::where('company_id', request()->company)->get();
                                @endphp
                            @endif
                        @endif
                        @forelse ($methods as $key=>$method)
                            @php
                                $method_info = \App\Models\MethodContent::where([['method_id', $method->id], ['language_id', $language->id]])->first();
                            @endphp
                            <div class="method-card text-gray-700 industry-card">
                                <label class="method-title text-gray-500">{{ trans('index.user_methods_phrase13') }}
                                    {{ $key + 1 }}: </label>
                                {{ !empty($method_info->name) ? $method_info->name : '' }}
                                <a href="{{ route('method.edit', [app()->getLocale(), $method->id]) }}"
                                    class="btn btn-primary btn-sm method-card-btn" style="right: 10%!important;">
                                    <i class="fas fa-edit"></i> {{ trans('index.user_methods_phrase14') }}
                                </a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['method.destroy', [app()->getLocale(), $method->id]], 'class' => 'form-inline']) !!}
                                {!! Form::button('<i class="fas fa-trash"></i> Delete', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-sm method-card-btn del_ delete',
                                    'id' => route('method.destroy', [app()->getLocale(), $method->id]),
                                    'data-toggle' => 'modal',
                                    'data-target' => '#myModalDelete',
                                ]) !!}
                                {!! Form::close() !!}
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="row user-content-row new-method-ctn">
                    <div class="new-method">
                        <form class="form-inline" action="{{ route('method.store', ['lang' => app()->getLocale()]) }}"
                            method="POST" id="addMethodAjax">
                            @csrf
                            <div class="input-group mb-1 ml-1">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-gray-600">{{ trans('index.user_methods_phrase13') }}
                                    </div>
                                </div>
                                <input type="text" name="name" id="new_method_name" class="form-control">
                                <span class="text-danger validation_errors name_err"></span>
                                <input type="hidden" id="" name="language_id" value="{{ $language->id }}"
                                    class="form-control">
                            </div>
                            <button type="submit" id="" class="btn btn-info mb-1 ml-1">
                                <i class="fas fa-plus"></i> {{ trans('index.user_methods_phrase15') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
