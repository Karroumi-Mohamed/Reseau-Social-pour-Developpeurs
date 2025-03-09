@props(['user'])

<div class="bg-white overflow-hidden shadow-sm rounded-lg">
    <div class="p-6">
        <div class="flex items-center space-x-4 mb-6">
            @if ($user->profile_picture)
                <img class="h-16 w-16 rounded-full object-cover"
                    src="{{ Storage::url($user->profile_picture) }}"
                    alt="{{ $user->name }}">
            @else
                <div
                    class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $user->bio ?? 'No bio available' }}</p>
            </div>
        </div>
        <div class="space-y-4">
            @if ($user->github_link)
                <a href="{{ $user->github_link }}" target="_blank"
                    class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 transition duration-150">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.48 0-.237-.009-.866-.013-1.7-2.782.604-3.369-1.34-3.369-1.34-.454-1.155-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12c0-5.523-4.477-10-10-10z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>GitHub Profile</span>
                </a>
            @endif
            @if ($user->gitlab_link)
                <a href="{{ $user->gitlab_link }}" target="_blank"
                    class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 transition duration-150">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 0 1-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 0 1 4.82 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0 1 18.6 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.51L23 13.45a.84.84 0 0 1-.35.94z" />
                    </svg>
                    <span>GitLab Profile</span>
                </a>
            @endif
        </div>
        @if ($user->skills->isNotEmpty())
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Skills</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($user->skills as $skill)
                        <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-full">
                            {{ $skill->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
        @if ($user->languages->isNotEmpty())
            <div class="mt-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Languages</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($user->languages as $language)
                        <span class="px-2 py-1 bg-green-50 text-green-700 text-xs rounded-full">
                            {{ $language->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('profile.show', $user) }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                <span>View Full Profile</span>
                <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</div>