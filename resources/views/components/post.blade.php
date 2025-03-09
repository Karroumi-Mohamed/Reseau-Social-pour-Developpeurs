@props(['post'])

<div class="bg-white overflow-hidden shadow-sm rounded-lg">
    <div class="p-6">
        <div class="flex items-center space-x-4 mb-4">
            @if ($post->user->profile_picture)
                <a href="{{ route('profile.show', $post->user) }}">
                    <img class="h-10 w-10 rounded-full object-cover"
                        src="{{ Storage::url($post->user->profile_picture) }}"
                        alt="{{ $post->user->name }}">
                </a>
            @else
                <a href="{{ route('profile.show', $post->user) }}">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                    </div>
                </a>
            @endif
            <div>
                <a href="{{ route('profile.show', $post->user) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                    {{ $post->user->name }}
                </a>
                <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ $post->title }}</h2>
        <div class="prose max-w-none mb-6 post-content" data-content="{{ $post->content }}">
        </div>
        @if ($post->image)
            <div class="mt-4 mb-6">
                <img src="{{ Storage::url($post->image) }}" alt="Post image"
                    class="rounded-lg max-h-96 w-auto">
            </div>
        @endif
        @if($post->hashtags->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($post->hashtags as $hashtag)
                    <a href="{{ route('posts.hashtag', $hashtag->name) }}" 
                       class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors">
                        #{{ $hashtag->name }}
                    </a>
                @endforeach
            </div>
        @endif
        <div class="flex items-center space-x-6 text-sm text-gray-500">
            <button onclick="toggleLike({{$post->id}})"
                class="like-button flex items-center space-x-2 hover:text-blue-600"
                data-post-id="{{ $post->id }}">
                <svg class="h-5 w-5 like-icon" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span class="likes-count">{{ $post->likes->count() }}</span>
                <span>likes</span>
            </button>
            <button onclick="toggleComments({{$post->id}})" class="flex items-center space-x-2 hover:text-blue-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span class="comments-count">{{ $post->comments->count() }}</span>
                <span>comments</span>
            </button>
            
            @if($post->user_id === Auth::id())
            <div class="flex items-center space-x-4 ml-auto">
                <button onclick="editPost({{$post->id}})" class="text-blue-500 hover:text-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </button>
                <button onclick="deletePost({{$post->id}})" class="text-red-500 hover:text-red-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
            @endif
        </div>
        <div id="comments-section-{{$post->id}}" class="mt-6 pt-6 border-t border-gray-200 hidden">
            <form class="mb-4" onsubmit="submitComment(event, {{$post->id}})">
                <div class="flex space-x-4">
                    <input type="text" class="comment-input flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                        placeholder="Write a comment...">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Comment
                    </button>
                </div>
            </form>
            <div class="space-y-4 comments-container">
                @foreach($post->comments()->orderBy('created_at', 'desc')->get() as $comment)
                    <x-comment :comment="$comment" />
                @endforeach
            </div>
        </div>
    </div>
</div>