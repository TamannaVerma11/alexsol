@extends('front.user.layouts.app')

@section('content')

<div class="card">
    <div class="card-body p-3">
        <div class="row user-content-row">
            <div class="col-12 tos">
                <div class="tos-ctn">
                    @if (auth()->check() && (auth()->user()->user_type == 'admin_support' || auth()->user()->user_type == 'admin_super'))
                        <form action="{{ route('tos.create', ['lang'=>app()->getLocale()]) }}" method="POST" id="addTosAjax">
                            @csrf
                            <div class="form-group">
                                <label for="tos_selection" class="tos-section-title">
                                    {{ trans('index.user_tos_phrase3') }}
                                </Label>
                                <select id="tos_selection" name="company_id" class="form-control">
                                    <option value="">{{ trans('index.user_tos_phrase4') }}</option>
                                    @forelse ($companies as $company)
                                        @if(!empty($tos_company) && !empty($tos_company->id) && $tos_company->id == $company->id)
                                            <option selected value="{{ $company->id }}">{{ $company->name }}</option>
                                        @else
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endif
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tos_selection" class="form-control">
                                    {{ trans('index.text_notify_user_to_accept') }} :
                                    <input type="checkbox" checked="checked" value="1" id="chkNotifyUser"
                                        name="chkNotifyUser" />
                                </Label>
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
                            @forelse ($languages as $lang)
                                <span class="form language language_{{$lang->id}}" style="{{ ($lang->id != $language->id) ? 'display: none' : ''}}">
                                    <input type='hidden' value="{{$lang->id}}" name='language_ids[]'>
                                    @forelse ($tos_data_array as $tos_data)
                                        @if ($tos_data->language_id == $lang->id)
                                            <div class="tos-editor-ctn">
                                                <div class="tos-editor-title">{{$lang->name}}</div>
                                                <textarea id="tos_editor_{{$lang->language_code}}" name="content[]" class="tos-editor">
                                                    {!! ($tos_data && !empty($tos_data->id)) ? htmlspecialchars_decode( $tos_data->content, ENT_QUOTES) : '' !!}
                                                </textarea>
                                                <span class="text-danger  validation_errors content_{{$lang->language_code}}_err"></span>
                                            </div>
                                        @else
                                        @endif
                                    @empty
                                    @endforelse
                                </span>
                            @empty
                            @endforelse

                            <button class="btn btn-primary btn-sm mb-2 mt-2"
                                data-lang_code="{{$language->language_code}}">
                                <i class="fas fa-save"></i> {{ trans('index.user_tos_phrase2') }}
                            </button>
                        </form>
                    @else
                        {!! ($tos_data && !empty($tos_data->id)) ? htmlspecialchars_decode( $tos_data->content, ENT_QUOTES) : '' !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
