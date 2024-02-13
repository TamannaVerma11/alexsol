@extends('front.user.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body p-3">
            <div class="col-12 category">
                <div class="row user-content-row">
                    <div id="category_card_ctn" class="col-12" data-action="{{route('category.sortable', app()->getLocale())}}">
                        @forelse ($categories as $category)
                            @php
                                $category_info = \App\Models\CategoryContent::where([['language_id', $language->id], ['category_id', $category->id]])->first();
                            @endphp
                            <div class="category-card text-gray-700" id="{{ $category->id }}">
                                {{ $category_info->name }}
                                <a href="{{ route('category.edit', [app()->getLocale(), $category->id]) }}"
                                    class="btn btn-primary btn-sm category-card-btn">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['category.destroy', [app()->getLocale(), $category->id]], 'class' => 'form-inline']) !!}
                                {!! Form::button('<i class="fas fa-trash"></i>', [
                                    'type' => 'submit',
                                    'class' => 'category_delete category-card-btn btn btn-danger del_ delete',
                                    'id' => route('category.destroy', [app()->getLocale(), $category->id]),
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
                        <form class="form-inline" action="{{ route('category.store', ['lang'=>app()->getLocale()]) }}" method="POST" id="addCategoryAjax">
                            @csrf
                            <div class="input-group mb-1 ml-1">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-gray-600">{{ trans('index.user_category_phrase4') }}
                                    </div>
                                </div>
                                <input type="text" id="new_category_name" name="name" class="form-control">
                                <span class="text-danger validation_errors name_err"></span>
                                <input type="hidden" id="" name="language_id" value="{{ $language->id }}">
                            </div>
                            <button type="submit" id="" class="btn btn-info mb-1 ml-1">
                                <i class="fas fa-plus"></i> {{ trans('index.user_category_phrase5') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
