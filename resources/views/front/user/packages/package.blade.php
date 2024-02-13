@extends('front.user.layouts.app')

@section('content')

<div class="card">
    <div class="card-body p-3">
<div class="row user-content-row">
    <div class="col-12 package">
        <div class="package-ctn">
            <div class="package-row">
                <div class="col-12">
                    @if ($packages)
                        <div class="package-card">
                            <table class="table table-striped table-bordered">
                                <thead class="text-gray-500">
                                <tr>
                                    <th scope="col">{{ trans("index.user_package_phrase3") }}</th>
                                    <th scope="col">{{ trans("index.user_package_phrase4") }} ({{ config('app.SITE_CURRENCY') }})</th>
                                    <th scope="col">{{ trans("index.user_package_phrase12") }}</th>
                                    <th scope="col">{{ trans("index.user_package_phrase13") }}</th>
                                    <th scope="col">{{ trans("index.user_package_phrase14") }}</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @forelse ($packages as $package)
                                        @php
                                            $package_name = array();
                                            $package_details = array();
                                            $package_data = \App\Models\PackageContent::where([['package_id', $package->id], ['language_id', $language->id]])->first();
                                            $packagecontents = \App\Models\PackageContent::where('package_id', $package->id)->get();
                                        @endphp
                                        @forelse ($packagecontents as $key => $packagecontent)
                                            @php
                                                array_push($package_name, $packagecontent->name);
                                                array_push($package_details, $packagecontent->details);
                                            @endphp
                                        @empty
                                        @endforelse
                                        <tr>
                                            <td>{{ $package_data->name }}</td>
                                            <td>{{ config('app.SITE_CURRENCY_SYMBOL').' '.$package->price }}</td>
                                            <td>{{ $package->user }}</td>
                                            <td>{{ $package->size_min." - ".$package->size_max }}</td>
                                            <td>
                                                {!! Form::open(['method' => 'DELETE','route' => ['package.destroy', [app()->getLocale(), $package->id]],'style'=>'display:inline']) !!}
                                                {!! Form::submit( 'Delete', ['class' => 'btn btn-danger btn-sm del_ delete', 'id' => route('package.destroy', [app()->getLocale(), $package->id]), 'data-toggle' => 'modal', 'data-target' => '#myModalDelete']) !!}
                                                {!! Form::close() !!}

                                                <button type="button" class="btn btn-success btn-sm package-edit-btn" data-package_id="{{ $package->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                            <td class="package-info" hidden="true">
                                                @php
                                                    $package_info = array(
                                                        "package_name" => $package_name,
                                                        "package_price" => $package->price,
                                                        "package_user" => $package->user,
                                                        "package_size_min" => $package->size_min,
                                                        "package_size_max" => $package->size_max,
                                                        "package_details" => $package_details
                                                    );
                                                @endphp
                                                <input type="hidden" value='{{ json_encode($package_info) }}'>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="package-editor-ctn">
                        <button class="btn btn-lg btn-info package-add-new">{{ trans('index.user_package_phrase16') }}</button>
                    </div>
                    <div class="package-editor-sample">
                        <div class="package-new-title">{{ trans('index.user_package_phrase11') }}</div>
                        <form class="text-gray-600" action="{{ route('package.store', ['lang'=>app()->getLocale()]) }}" method="POST" id="addPackageAjax">
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

                            @forelse ($languages as $key=>$language_)
                            <span class="form language language_{{$language_->id}}" style="display: none">
                                <input type='hidden' value="{{$language_->id}}" name='language_ids[]'>
                                <div class="form-group">
                                    <label for="package_new_name">{{ trans('index.user_package_phrase3') }}</label>
                                    <input type="text" id="package_new_name" name="name[]" class="form-control package_new_name">
                                    <span class="text-danger validation_errors name_{{$key}}_err"></span>
                                </div>

                                <div class="form-group">
                                    <label for="package_new_details">{{ trans('index.user_package_phrase9') }}</label>
                                    <textarea id="package_new_details" name="details[]" class="form-control package_new_details"></textarea>
                                    <span class="text-danger validation_errors details_{{$key}}_err"></span>
                                </div>
                            </span>
                            @empty
                            @endforelse


                            <div class="form-group">
                                <label for="package_new_price">{{ trans('index.user_package_phrase4') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            {{ config('app.SITE_CURRENCY_SYMBOL') }}
                                        </div>
                                    </div>
                                    <input type="number" name="price" step="0.01" min="0" id="package_new_price" class="form-control">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            {{ config('app.SITE_CURRENCY') }}
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger validation_errors price_err"></span>
                            </div>
                            <div class="form-group">
                                <label for="package_new_user">{{ trans('index.user_package_phrase6') }}</label>
                                <input type="number" name="user" step="1" min="0" id="package_new_user" class="form-control">
                                <span class="text-danger validation_errors user_err"></span>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="package_new_size_min">{{ trans('index.user_package_phrase7') }}</label>
                                    <input type="number" name="size_min" step="1" min="0" id="package_new_size_min" class="form-control">
                                    <span class="text-danger validation_errors size_min_err"></span>
                                </div>
                                <div class="col-6">
                                    <label for="package_new_size_max">{{ trans('index.user_package_phrase8') }}</label>
                                    <input type="number" name="size_max" step="1" min="0" id="package_new_size_max" class="form-control">
                                    <span class="text-danger validation_errors size_max_err"></span>
                                </div>
                            </div>

                            <input type="hidden" id="package_id" name="package_id" value="0">
                            <button type="submit" id="package_new_submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                                {{ trans('index.user_package_phrase10') }}
                            </button>
                            <button type="button" id="package_new_cancel" class="btn btn-danger">
                                <i class="fas fa-times"></i>
                                {{ trans('index.user_package_phrase17') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

