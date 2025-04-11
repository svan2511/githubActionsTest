@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ $post->title }}</span>
                        <div>
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
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h6 class="text-muted">
                            By {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}
                        </h6>
                    </div>

                    <div class="post-content">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
            </div>
        </div>
    </div>
</div>
@endsection 