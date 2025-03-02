<div class="flex space-x-3 comment-item" id="comment-{{$comment->id}}">
    @if($comment->user->profile_picture)
        <img src="{{ Storage::url($comment->user->profile_picture) }}" 
            alt="{{ $comment->user->name }}" 
            class="h-8 w-8 rounded-full">
    @else
        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center text-white text-sm font-bold">
            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
        </div>
    @endif
    <div class="flex-1">
        <div class="bg-gray-50 rounded-lg px-4 py-2">
            <div class="flex justify-between items-center">
                <span class="font-medium text-sm text-gray-900">{{ $comment->user->name }}</span>
                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-sm text-gray-700 mt-1">{{ $comment->content }}</p>
        </div>
        @if($comment->user_id === Auth::id())
            <div class="flex space-x-2 mt-1">
                <button onclick="deleteComment({{$comment->id}}, {{$comment->post_id}})" class="text-xs text-red-500 hover:text-red-600">Delete</button>
            </div>
        @endif
    </div>
</div>