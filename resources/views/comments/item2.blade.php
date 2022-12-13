<div class="p-4 border-left my-3">
    <p class="font-weight-bold">{{ $comment->user->name }}:</p>
    <p>{{ $comment->content }}</p>

    <p> Enviado a las: {{ $comment->created_at }}</p>

    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#reply-{{ $comment->id }}"
        aria-expanded="false" aria-controls="reply-{{ $comment->id }}">
        Responder
    </button>

    @if (auth()->id() == $comment->user->id)
        <td width="120">
            {!! Form::open(['route' => ['comments.comment_destroy', $comment->id], 'method' => 'delete']) !!}
            <div class='btn-group'>

                <a href="{{ route('comments.comment_edit', [$comment->id]) }}" class='btn btn-default btn-xs'>
                    <i class="far fa-edit"></i>
                </a>

                {!! Form::button('<i class="far fa-trash-alt"></i>', [
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-xs',
                    'onclick' => "return confirm('Está seguro?')",
                ]) !!}
            </div>
            {!! Form::close() !!}
        </td>
    @endif

    <div class="collapse my-3" id="reply-{{ $comment->id }}">
        <div class="card card-body">
            @include('comments.form2', ['comment' => $comment])
        </div>
    </div>

    @if ($comment->replies)
        @include('comments.list2', ['comments' => $comment->replies])
    @endif
</div>
