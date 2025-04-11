<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create New Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Your Posts</h3>
                    
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @forelse ($posts as $post)
                        <div class="border-b border-gray-200 py-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-lg font-semibold">{{ $post->title }}</h4>
                                    <p class="text-gray-600 text-sm">Created on {{ $post->created_at->format('M d, Y') }}</p>
                                    <p class="mt-2">{{ Str::limit($post->content, 200) }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">You haven't created any posts yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 