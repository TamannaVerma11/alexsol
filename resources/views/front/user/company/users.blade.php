@extends('front.user.layouts.app')

@section('content')
    <div class="p-4 rounded">

        <table class="table table-striped">
            <thead class="bg-primary">
                <tr>
                    <th scope="col">
                        <h4 style="color:white; margin-left: 20px;">{{ trans('index.user_sidebar_phrase18') }} </h4>
                    </th>
                    <th scope="col">
                        <h4 style="color:white; margin-left: 20px;"> {{ 'Total ' . $company_users->count() . ' user(s)' }}</h4>
                    </th>
                    <th scope="col" colspan="4" style="text-align:right;">
                        <h5 style="color:white; margin-right: 20px">
                            {{ !empty($company->name) ? trans('index.index_phrase17') . ' : ' . $company->name : '' }}
                        </h5>
                    </th>
                </tr>
            </thead>
            <thead>
                <th scope="col">{{ trans('index.user_composer_phrase13') }}</th>
                <th scope="col">{{ trans('index.index_phrase1') }}</th>
                <th scope="col">Account Type</th>
                <th scope="col">{{ trans('index.index_phrase12') }}</th>
                <th width="3%" colspan="3">Action</th>
            </thead>
            @forelse ($company_users as $key => $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->user_type }}</td>
                    <td>{{ $user->phone }}</td>

                    <td>
                        {!! Form::open(['method' => 'DELETE','route' => ['company.users.destroy', [app()->getLocale(), $user->id]],'style'=>'display:inline']) !!}
                        {!! Form::submit( 'delete', ['class' => 'btn btn-danger btn-sm del_ delete', 'id' => route('company.users.destroy', [app()->getLocale(), $user->id]), 'data-toggle' => 'modal', 'data-target' => '#myModalDelete']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @empty
            @endforelse

        </table>

        <div class="d-flex">
            {!! $company_users->links() !!}
        </div>

    </div>
@endsection
