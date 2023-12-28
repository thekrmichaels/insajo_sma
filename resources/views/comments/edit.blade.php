@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{ Form::model($comment, ['route' => ['comments.comment_update', $comment->id], 'method' => 'PUT']) }}

            {{ Form::label('content', 'Comentario:') }}
            {{ Form::textarea('content', null, ['class' => 'form-control']) }}

            {{ Form::submit('Actualizar Comentario', ['class' => 'btn btn-primary', 'style' => 'margin-top: 15px;']) }}

            {{ Form::close() }}
        </div>
    </div>
@endsection
