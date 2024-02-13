@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="col-12 method">
                <form action="{{ route('method.update', ['lang' => app()->getLocale(), $method->id]) }}" method="POST"
                    id="updateMethodAjax">
                    @csrf
                    <div class="row user-content-row">
                        <div class="col-12">
                            <div class="method-single-ctn">
                                <div class="method-single-title"> {{ trans('index.user_methods_phrase1') }} </div>
                                <div class="form-group form-group-sm mt-1 ml-1">
                                    <label class="method-title"> {{ trans('index.user_methods_phrase19') }}
                                    </label>
                                    <input type="color" name="color" id="method_color" value="{{ $method->color }}">
                                    <span class="text-danger validation_errors color_err"></span>
                                </div>
                                <div class="form-group form-group-sm mt-1 ml-1">
                                    <label class="method-title"> {{ trans('index.user_methods_phrase2') }}
                                    </label>
                                    <select id="method_for" name="company_id" class="form-control form-control-sm">
                                        <option value="" {{ !$method->id ? 'selected' : '' }}>
                                            {{ trans('index.user_methods_phrase3') }}</option>
                                        @forelse ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ $method->company_id == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <span class="text-danger validation_errors company_id_err"></span>
                                </div>
                                <div class="form-group form-group-sm ml-1 mt-1">
                                    <label for="company_restriction"
                                        class="method-title">{{ trans('index.user_methods_phrase4') }} </label>
                                    <select id="company_restriction" name="restriction[]" multiple="multiple" class="form-control form-control-sm">
                                        @forelse ($companies as $company)
                                            @php
                                                $restriction_array = json_decode($method->restriction);
                                            @endphp

                                            <option value="{{ $company->id }}"
                                                {{ (is_array($restriction_array) && in_array($company->id, $restriction_array)) ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <span class="text-danger validation_errors restriction_err"></span>
                                </div>
                                <!--<button type="submit" id="method_basic" class="btn btn-success btn-sm ml-1 mt-1"
                                        data-method_id="{{ $method->id }}"><i class="fas fa-save">
                                        </i> {{ trans('index.user_methods_phrase6') }}
                                    </button>-->
                            </div>
                        </div>
                    </div>

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
                            $method_data = \App\Models\MethodContent::where([['method_id', $method->id], ['language_id', $lang->id]])->first();
                        @endphp
                        <span class="form language language_{{$lang->id}}" style="{{ ($lang->id != $language->id) ? 'display: none' : ''}}">
                            <input type='hidden' value="{{$lang->id}}" name='language_ids[]'>
                            <div class="row user-content-row">
                                <div class="col-12">
                                    <div class="method-single-ctn">
                                        <div class="tos-editor-title">{{ $lang->name }}
                                            {{ trans('index.user_methods_phrase8') }}</div>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text text-gray-600">
                                                    {{ trans('index.user_methods_phrase9') }}</div>
                                            </div>
                                            <input type="text" name="name[]" class="form-control method-name"
                                                value="{{ $method_data ? $method_data->name : '' }}">
                                            <span class="text-danger  validation_errors name_{{$key}}_err"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="method_details_{{ $lang->language_code }}">
                                                {{ trans('index.user_methods_phrase10') }} </label>
                                            <textarea name="details[]" id="method_details_{{ $lang->language_code }}" class="form-control method-details">{!! $method_data ? htmlspecialchars_decode($method_data->details, ENT_QUOTES) : '' !!}</textarea>
                                            <span
                                                class="text-danger  validation_errors details_{{$key}}_err"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>
                    @empty
                    @endforelse
                    <button class="btn btn-success method-translation-save">
                        <i class="fas fa-save"></i> {{ trans('index.user_methods_phrase11') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
