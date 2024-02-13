@extends('front.user.layouts.app')

@section('content')
<div class="card-body">
    <form method="POST" action="/user/two-factor-authentication">
        @csrf

        @if (!empty(auth()->user()->two_factor_secret))
            @method('DElETE')

            <div class="pb-5">
                {!! auth()->user()->twoFactorQrCodeSvg() !!}
            </div>

            <div>
                <h3>Recovery Codes:</h3>

                <ul>
                    @forelse (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                        <li>{{ $code }}</li>
                    @empty
                    @endforelse
                </ul>
            </div>

            <button class="btn btn-danger">Disable</button>
        @else
            <button class="btn btn-primary">Enable</button>
        @endif
    </form>
</div>
@endsection
