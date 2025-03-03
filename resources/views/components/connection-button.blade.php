<!-- filepath: \\wsl.localhost\Ubuntu-24.04\home\mohamed\Briefs\Brief16\resources\views\components\connection-button.blade.php -->
@props(['user'])

@php
    $currentUser = Auth::user();
    $connection = null;
    
    if ($currentUser->id !== $user->id) {
        $connection = App\Models\Connection::where(function($query) use ($currentUser, $user) {
            $query->where('sender_id', $currentUser->id)
                ->where('receiver_id', $user->id);
        })->orWhere(function($query) use ($currentUser, $user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $currentUser->id);
        })->first();
    }
@endphp

@if($currentUser->id !== $user->id)
    @if(!$connection)
        <form action="{{ route('connections.send', $user) }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                Connect
            </button>
        </form>
    @elseif($connection->status === 'pending' && $connection->sender_id === $currentUser->id)
        <span class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">Request Sent</span>
    @elseif($connection->status === 'pending' && $connection->receiver_id === $currentUser->id)
        <div class="flex space-x-2">
            <form action="{{ route('connections.accept', $connection) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                    Accept
                </button>
            </form>
            <form action="{{ route('connections.reject', $connection) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">
                    Reject
                </button>
            </form>
        </div>
    @elseif($connection->status === 'accepted')
        <div class="flex items-center">
            <span class="text-green-500 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </span>
            <span class="font-medium">Connected</span>
            <form action="{{ route('connections.remove', $connection) }}" method="POST" class="ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline text-sm">
                    Remove
                </button>
            </form>
        </div>
    @endif
@endif