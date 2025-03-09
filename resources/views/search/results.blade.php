<x-app-layout>
    <div x-data="{ loading: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <form @submit="loading = true" action="{{ route('search') }}" method="GET" class="flex gap-4">
                <input type="text" 
                    name="q" 
                    value="{{ $query }}" 
                    placeholder="Search for users or posts..."
                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="loading">
                    <span x-show="!loading">Search</span>
                    <span x-show="loading" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Searching...
                    </span>
                </button>
            </form>
        </div>

        @if($query)
            <div class="space-y-8">
                <!-- Users Section -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Users</h2>
                    @if($users->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($users as $user)
                                <div class="bg-white rounded-lg shadow p-6 flex items-center space-x-4">
                                    @if($user->profile_picture)
                                        <img src="{{ Storage::url($user->profile_picture) }}" 
                                            alt="{{ $user->name }}" 
                                            class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center text-white text-lg font-bold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('profile.show', $user) }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                                            {{ $user->name }}
                                        </a>
                                        @if($user->bio)
                                            <p class="text-sm text-gray-600 line-clamp-2">{{ $user->bio }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No users found matching "{{ $query }}"</p>
                    @endif
                </div>

                <!-- Posts Section -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Posts</h2>
                    @if($posts->isNotEmpty())
                        <div class="space-y-6">
                            @foreach($posts as $post)
                                <x-post :post="$post" />
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No posts found matching "{{ $query }}"</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>