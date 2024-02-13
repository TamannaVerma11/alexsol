@extends('back.layouts.app')

@section('content')
    <div class="p-4 rounded">
        <div class="d-xl-flex justify-content-between align-items-start">
            <h2 class="text-dark font-weight-bold mb-2">{{ trans('back.languages') }}</h2>
        </div>

	 <div class="lead">
            <a href="{{ route('back.languages.create', app()->getLocale()) }}" class="btn btn-primary btn-sm float-right">{{ trans('back.newLang') }}</a>
        </div>


        <table class="table table-striped">
          <thead>
             <th width="1%">#</th>
             <th>{{ trans('back.name') }}</th>
             <th>{{ trans('back.language_code') }}</th>
             <th>{{ trans('back.status') }}</th>
             <th width="3%" colspan="3">{{ trans('back.action') }}</th>
          </thead>
            @foreach ($languages as $key => $language)
            <tr>
                <td>{{ $language->id }}</td>
                <td>{{ $language->name }}</td>
		<td>{{ $language->language_code }}</td>                
		<td>
		    <label class="comments_switch">
		    <input data-id="{{$language->id}}" class="language-status-toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="{{ trans('back.active') }}" data-off="{{ trans('back.passive') }}" {{ $language->active == 1 ? 'checked' : '' }}>
		    <span class="slider round"></span>
		    </label> 
		</td>
		<td>
                    {!! Form::open(['method' => 'DELETE','route' => ['back.languages.destroy', [app()->getLocale(), $language->id]],'style'=>'display:inline']) !!}
                    {!! Form::submit(trans('back.delete'), ['class' => 'btn btn-danger btn-sm del_ delete', 'id' => route('back.languages.destroy', [app()->getLocale(), $language->id]), 'data-toggle' => 'modal', 'data-target' => '#myModalDelete']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $languages->links() !!}
        </div>

    </div>

@endsection
