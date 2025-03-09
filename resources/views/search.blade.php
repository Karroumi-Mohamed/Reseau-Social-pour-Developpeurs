<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($query)
                <h2 class="text-2xl font-semibold mb-6">Search results for "{{ $query }}"</h2>
            @endif

            @if($users->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Users</h3>
                        <div class="divide-y divide-gray-200">
                            @foreach($users as $user)
                                <div class="py-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        @if($user->profile_picture)
                                            <img src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}" 
                                                class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 text-lg">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <a href="{{ route('profile.show', $user) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                {{ $user->name }}
                                            </a>
                                            @if($user->bio)
                                                <p class="text-sm text-gray-500">{{ Str::limit($user->bio, 100) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if(Auth::id() !== $user->id)
                                        <a href="{{ route('profile.show', $user) }}" 
                                            class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-green-500 hover:from-blue-700 hover:to-green-600">
                                            View Profile
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($posts->isNotEmpty())
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold">Posts</h3>
                    @foreach($posts as $post)
                        <x-post :post="$post" />
                    @endforeach
                </div>
            @endif

            @if($users->isEmpty() && $posts->isEmpty() && $query)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        No results found for "{{ $query }}"
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>