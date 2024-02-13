@extends('front.user.layouts.app')

@section('content')

@if(app()->getLocale() == 'en')
    @include('front.user.faqs.faqen')
@elseif(app()->getLocale() == 'da')
    @include('front.user.faqs.faqdan')
@elseif(app()->getLocale() == 'de')
    @include('front.user.faqs.faqgen')
@elseif(app()->getLocale() == 'nb')
    @include('front.user.faqs.faqnor')
@elseif(app()->getLocale() == 'sv')
    @include('front.user.faqs.faqswe')
@endif

@endsection

