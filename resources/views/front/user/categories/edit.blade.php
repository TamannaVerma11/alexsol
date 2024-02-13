@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="col-12 category">
                <form method="POST" action="{{ route('category.update', ['lang' => app()->getLocale(), $category->id]) }}"
                    id="updCategoryAjax">
                   @csrf
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
                            $category_data = \App\Models\CategoryContent::where([['category_id', $category->id], ['language_id', $lang->id]])->first();
                        @endphp
                        <span class="form language language_{{$lang->id}}" style="{{ ($lang->id != $language->id) ? 'display: none' : ''}}">
                            <input type='hidden' value="{{$lang->id}}" name='language_ids[]'>
                            <div class="row user-content-row">
                                <div class="col-12">
                                    <div class="category-single-ctn">
                                        <div class="tos-editor-title">{{ $lang->name }}
                                            {{ trans('index.user_category_phrase8') }}</div>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text text-gray-700">{{ trans('index.user_category_phrase9') }}
                                                </div>
                                            </div>
                                            <input type="text" name="name[]" class="form-control category-name" value="{{ $category_data ? htmlspecialchars_decode($category_data->name, ENT_QUOTES) : '' }}">
                                            <span class="text-danger validation_errors name_{{$key}}_err"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_details_{{ $lang->language_code }}">
                                                {{ trans('index.user_category_phrase10') }} </label>
                                            <textarea id="category_details_{{ $lang->language_code }}" name="details[]" class="form-control category-details">{{ $category_data ? htmlspecialchars_decode($category_data->details, ENT_QUOTES) : '' }}</textarea>
                                            <span class="text-danger validation_errors details_{{$key}}_err"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>
                    @empty
                    @endforelse
                    <button class="btn btn-success" type="submit"
                        data-category_id="{{ $category->id }}">
                        <i class="fas fa-save"></i> {{ trans('index.user_category_phrase11') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
