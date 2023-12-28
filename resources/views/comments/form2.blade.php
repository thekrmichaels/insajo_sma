<form action="{{ route('comments.schoolwork_store', $schoolwork) }}" method="POST">
    {{ csrf_field() }}

    @if (isset($comment->id))
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
    @endif

    <input type="hidden" name="user_id" value="{{ \auth()->id() }}">

    <div class="form-group">
        <label for="content">Comentar:</label>
        <textarea class="form-control" name="content" id="content"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>
