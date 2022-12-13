@foreach ($comments as $comment)
    @include('comments.item2', ['comment' => $comment])
@endforeach
