@extends('front.user.layouts.app')

@section('content')
<div class="card">
    <div class="card-body p-3">
        <div class="col-12 all-companies">
            @forelse ($companies as $company)
                <div class="company-ctn fw-bold text-gray-600">
                    <div class="company-logo">
                        <img src="{{ !empty($company->upload_company_img) ? url($company->upload_company_img) : '' }}" alt="Company logo">
                    </div>
                    <div class="row company-row">
                        <div class="col-9">
                            <span class="company-label ">{{ trans("index.user_companies_phrase6") }} </span>
                            @if ($user->user_type == 'admin_super' || $user->user_type == 'admin_support')
                                <a class="fw-bolder"
                                href="{{ route('company.edit', [app()->getLocale(), $company->id]) }}">
                                    {{ $company->name }}
                                </a>
                            @elseif ($user->user_type == 'consultant')
                                <a class="fw-bolder"
                                   href="{{ route('ticket.compTicket', [app()->getLocale(), $company->id]) }}">
                                    {{ $company->name }}
                                </a>
                            @endif
                        </div>
                        <div class="col-3">
                            @if ($company->status == 'pending')
                                <button
                                        class="btn btn-light-warning btn-sm disabled">{{ trans("index.user_companies_phrase3") }}</button>
                            @elseif ($company->status == 'active')
                                <button
                                        class="btn btn-light-success btn-sm disabled">{{ trans("index.user_companies_phrase5") }}</button>
                            @elseif ($company->status == 'suspended')
                                <button
                                        class="btn btn-light-secondary btn-sm disabled">{{ trans("index.user_companies_phrase4") }}</button>
                            @endif
                        </div>
                    </div>
                    <div class="row company-row">
                        <div class="col-6">
                            <span class="company-label">{{ trans("index.user_companies_phrase7") }} </span>
                            <a class="btn btn-light-primary btn-sm company-id">{{ $company->id }}</a>
                        </div>
                        <div class="col-6 company-size">
                            <span class="company-label">{{ trans("index.user_companies_phrase8") }} </span>
                            {{ $company->size }}
                        </div>
                    </div>

                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>

@endsection
