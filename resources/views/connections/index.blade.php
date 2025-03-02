<!-- filepath: \\wsl.localhost\Ubuntu-24.04\home\mohamed\Briefs\Brief16\resources\views\connections\index.blade.php -->
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Connection Requests</h2>
                    
                    @if($pendingRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($pendingRequests as $request)
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div class="flex items-center">
                                        <img src="{{ $request->sender->profile_photo_url }}" class="w-12 h-12 rounded-full mr-4">
                                        <div>
                                            <h3 class="font-semibold">{{ $request->sender->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $request->sender->headline ?? 'No headline' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('connections.accept', $request) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Accept</button>
                                        </form>
                                        <form action="{{ route('connections.reject', $request) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">Reject</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No pending connection requests</p>
                    @endif
                    
                    <h2 class="text-2xl font-bold mt-12 mb-6">My Connections</h2>
                    
                    @if($connections->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($connections as $connection)
                                <div class="p-4 border rounded-lg">
                                    <div class="flex items-center mb-4">
                                        <img src="{{ $connection['user']->profile_photo_url }}" class="w-16 h-16 rounded-full mr-4">
                                        <div>
                                            <h3 class="font-semibold text-lg">{{ $connection['user']->name }}</h3>
                                            <p class="text-gray-500">{{ $connection['user']->headline ?? 'No headline' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <a href="{{ route('profile.show', $connection['user']) }}" class="text-blue-500 hover:underline">View Profile</a>
                                        <form action="{{ route('connections.remove', $connection['connection']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No connections yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>