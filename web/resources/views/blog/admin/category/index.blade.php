@extends('layouts.app')

@section('content')
    <div class="container">
        <nav class="navbar navbar-expand navbar-light bg-light">
            <div class="nav navbar-nav">
                <a name="" id="" class="btn btn-primary" href="{{ route('blog.admin.categories.create')}}" role="button">Add category</a>
            </div>
        </nav>
        <table class="table table-light">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Parent category</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paginator as $category)
                @php /** @var \App\Models\BlogCategory $category */ @endphp
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            <a href="{{ route('blog.admin.categories.edit', $category->id)}}">{{ $category->title }}</a>
                        </td>
                        <td @if(in_array($category->parent_id, [0,1])) style="color: #ccc;" @endif>
                            {{ $category->parent_id}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($paginator->total() > $paginator->count())
            {{ $paginator->links() }}
        @endif
    </div>

@endsection