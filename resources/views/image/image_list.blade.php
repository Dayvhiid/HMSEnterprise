<!DOCTYPE html>
<html>
<head>
    <title>Image List</title>
</head>
<body>
@include('partials.session-bar')

@foreach($images as $image)
    <h2>{{ $image->title }}</h2>
    @if($image->path || $image->file_path)
        <img src="{{ route('images.file', $image) }}" alt="{{ $image->title }}" width="300">
    @else
        <img src="data:image/jpeg;base64,{{ base64_encode($image->image_data) }}" alt="{{ $image->title }}" width="300">
    @endif
@endforeach

</body>
</html>