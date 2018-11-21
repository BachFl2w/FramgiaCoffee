@extends('layouts.app2')

@section('page-title')
    <li><a href="{{route('admin.user.index')}}">Dashboard</a></li>
    <li><a href="{{route('admin.user.index')}}">{{ __('message.category') }}</a></li>
    <li class="active">{{ __('message.create') }}</li>
@endsection

@section('content')
    <div class="card">
            {!! Form::open(['route' => ['admin.category.update', $category->id], 'method' => 'post']) !!}
            <div class="card-header">{{ __('message.category_action.update') }}</div>
            
            <div class="card-body">
                @csrf
                <div class="form-group">
                    {!! Form::label('id', __('message.id'), ['class' => 'form-control-label', 'id' => 'id']) !!}
                    {!! Form::text('id', $category->id, ['class' => 'form-control', 'id' => 'id', 'readonly']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('name', __('message.name'), ['class' => 'form-control-label']) !!}
                    {!! Form::text('name', $category->name, ['class' => 'form-control', 'id' => 'id']) !!}
                </div>
            </div>
            <div class="card-footer">
                {!! Form::submit(__('message.update'), ['class' => 'btn btn-info']) !!}
                {!! Form::reset(__('message.reset'), ['class' => 'btn btn-warning']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection