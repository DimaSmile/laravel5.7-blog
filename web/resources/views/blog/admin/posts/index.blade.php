@extends('layouts.app')

@section('content')
    <div class="container">
        <nav class="navbar navbar-expand navbar-light bg-light">
            <div class="nav navbar-nav">
                <a name="" id="" class="btn btn-primary" href="{{ route('blog.admin.posts.create')}}" role="button">Add category</a>
            </div>
        </nav>
        <table class="table table-light">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Автор</th>
                    <th>Категория</th>
                    <th>Заголовок</th>
                    <th>Дата публикации</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paginator as $post)
                @php /** @var \App\Models\BlogPost post */ @endphp
                    <tr @if(!$post->is_published) style="background-color: #ccc;" @endif>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->category->title }}</td>
                        <td>
                            <a href="{{ route('blog.admin.posts.edit', $post->id)}}">{{ $post->title }}</a>
                        </td>
                        <td>{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d.M H:i') : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($paginator->total() > $paginator->count())
            {{ $paginator->links() }}
        @endif
    </div>

@endsection