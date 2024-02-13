
@extends('front.user.layouts.app')

@section('content')
<style>
  .company_module {
    flex-direction: column;
  }
</style>
<div class="card">
  <div class="card-body p-3">
    <div class="row user-content-row">
      <div class="col-12 company">
        <div class="company-widget-title">{{ trans("index.user_company_profile_phrase10") }}</div>
        <div class="company-ctn">
          <div class="row company-row">
            <div class="col-12 company-size">
              <label class="company-label">{{ trans("index.user_company_profile_phrase10") }} </label>
              <div id="company_plan_editor1" data-admin="1" data-site_currency="{{ config('app.SITE_CURRENCY') }}" data-site_currency_symbol="{{ config('app.SITE_CURRENCY_SYMBOL') }}" data-company="{{ $company->id }}" class="editor">
                <form class='form-inline'>
                  <select id='company_plan_editor_classes' data-action="{{route('company.package_updater', app()->getLocale())}}"
                        data-phrase32="{{trans('index.user_js_phrase32')}}" data-phrase34="{{trans('index.user_js_phrase34')}}"
                        data-phrase33="{{trans('index.user_js_phrase33')}}" class='form-control form-control-sm ml-2 mt-1'>
                    <option disabled value=''>{{ trans("index.user_js_phrase26") }}</option>
                    @foreach (json_decode($package_classes) as $key=>$value)
                        <option value='{"min":"{{$value->size_min}}","max":"{{$value->size_max}}"}'>
                            {{ $value->size_min }} - {{ $value->size_max }} {{ trans("index.user_js_phrase28") }}
                        </option>
                    @endforeach
                  </select>
                  <button id='company_plan_editor_save' data-action="{{ route('company.package_save', app()->getLocale()) }}" class='btn btn-success btn-sm ml-2 mt-1' {{ (!$user->user_type == 'company_owner' || !$user->user_type == 'admin_super') ? "disabled" : '' }}><i class='fas fa-save'></i></button>
                </form>
              </div>
            </div>
            <div class="col-12 company-size">
              <div></div>
              <div id="company_plan_editor" data-admin="1" data-site_currency="{{ config('app.SITE_CURRENCY') }}" data-site_currency_symbol="{{ config('app.SITE_CURRENCY_SYMBOL') }}" data-company="{{ $company->id }}"></div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
