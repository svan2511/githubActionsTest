@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Posts</span>
                    @auth
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
                    @endauth
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse ($posts as $post)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
                                </h6>
                                <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>
                                
                                @can('update', $post)
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">Edit</a>
                                @endcan
                                
                                @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @empty
                        <p>No posts found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 