@foreach (preg_split('/\R{2,}/', trim($text)) as $paragraph)
    <p>{!! nl2br(e($paragraph)) !!}</p>
@endforeach
