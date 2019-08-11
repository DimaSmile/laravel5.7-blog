@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Models\BlogCategory $item */
    @endphp
    <form action="{{ route('blog.admin.categories.update', $item->id) }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="container">

            @if ($errors->any())
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <div class="alert alert-danger" role="alert">
                            <button class="alert-dismissible close fade show" data-dismiss="alert"><span aria-hidden="true">x</span></button>
                            <strong>{{ $errors->first() }}</strong>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <div class="alert alert-success" role="alert">
                            <button class="alert-dismissible close fade show" data-dismiss="alert"><span aria-hidden="true">x</span></button>
                            <strong>{{ session()->get('success') }}</strong>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-8">
                    @include('blog.admin.categories.includes.item_edit_main_col')
                </div>
                <div class="col-md-3">
                    @include('blog.admin.categories.includes.item_edit_add_col')
                </div>
            </div>
        </div>
    </form>

@endsection