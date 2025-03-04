<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile - Dev Community</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }
        .font-header {
            font-family: 'Space Grotesk', sans-serif;
        }
        .gradient-border {
            position: relative;
            border-radius: 0.75rem;
        }
        .gradient-border::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 0.875rem;
            background: linear-gradient(to right, #3b82f6, #10b981);
            z-index: -1;
            pointer-events: none;
        }
        .content-fade {
            position: relative;
            max-height: 100px;
            overflow: hidden;
        }
        .content-fade::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background: linear-gradient(to bottom, rgba(249, 250, 251, 0), rgba(249, 250, 251, 1));
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium flex items-center transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Back to Home') }}
                        </a>
                        <span class="text-xl font-header font-bold bg-gradient-to-r from-blue-600 to-green-500 text-transparent bg-clip-text">Dev Community</span>
                    </div>
                    @auth
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('connections.index') }}"
                                class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium flex items-center gap-2 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="sr-only">Connections</span>
                            </a>
                            @if(Auth::id() === $user->id)
                                <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Edit Profile
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Profile Content -->
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-white rounded-xl shadow-sm gradient-border p-8 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:space-x-8">
                    <div class="flex-shrink-0 mb-6 md:mb-0">
                        @if($user->profile_picture)
                            <img class="h-32 w-32 rounded-full object-cover ring-4 ring-blue-100" src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}">
                        @else
                            <div class="h-32 w-32 rounded-full bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center text-white text-4xl font-bold ring-4 ring-blue-100">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <h1 class="text-3xl font-header font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="mt-2 text-lg text-gray-600">{{ $user->bio ?? 'No bio available' }}</p>
                            </div>
                            <div class="mt-4 md:mt-0 flex space-x-4">
                                @if(Auth::id() !== $user->id)
                                    <x-connection-button :user="$user" />
                                @endif
                                @if($user->github_link)
                                    <a href="{{ $user->github_link }}" target="_blank" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-700 transition duration-150">
                                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.48 0-.237-.009-.866-.013-1.7-2.782.604-3.369-1.34-3.369-1.34-.454-1.155-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd"/>
                                        </svg>
                                        GitHub
                                    </a>
                                @endif
                                @if($user->gitlab_link)
                                    <a href="{{ $user->gitlab_link }}" target="_blank" class="inline-flex items-center px-4 py-2 rounded-lg bg-orange-600 text-white hover:bg-orange-500 transition duration-150">
                                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 0 1-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 0 1 4.82 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0 1 18.6 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.51L23 13.45a.84.84 0 0 1-.35.94z"/>
                                        </svg>
                                        GitLab
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-3 gap-4 md:w-96">
                            <div class="text-center p-4 rounded-lg bg-blue-50">
                                <span class="block text-2xl font-bold text-blue-600">{{ $connectionCount }}</span>
                                <span class="text-sm text-gray-600">Connections</span>
                            </div>
                            <div class="text-center p-4 rounded-lg bg-green-50">
                                <span class="block text-2xl font-bold text-green-600">{{ $postsCount }}</span>
                                <span class="text-sm text-gray-600">Posts</span>
                            </div>
                            <div class="text-center p-4 rounded-lg bg-purple-50">
                                <span class="block text-2xl font-bold text-purple-600">{{ $projectsCount }}</span>
                                <span class="text-sm text-gray-600">Projects</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills & Languages -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-header font-bold text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Skills
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($user->skills as $skill)
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium border border-blue-100">
                                {{ $skill->name }}
                            </span>
                        @empty
                            <p class="text-gray-500 italic">No skills added yet</p>
                        @endforelse
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-xl font-header font-bold text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                        </svg>
                        Languages
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($user->languages as $language)
                            <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-medium border border-green-100">
                                {{ $language->name }}
                            </span>
                        @empty
                            <p class="text-gray-500 italic">No languages added yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Projects -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h2 class="text-xl font-header font-bold text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Projects
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($user->projects as $project)
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-100 hover:border-purple-200 transition duration-150">
                            <h3 class="font-bold text-gray-900 mb-2">{{ $project->name }}</h3>
                            <p class="text-sm text-gray-600 mb-4">{{ $project->description }}</p>
                            @if($project->url)
                                <a href="{{ $project->url }}" target="_blank" 
                                   class="inline-flex items-center text-sm text-purple-600 hover:text-purple-700 transition duration-150">
                                    <span>View Project</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 italic col-span-full">No projects added yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Certificates -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h2 class="text-xl font-header font-bold text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    Certificates
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($user->certificates as $certificate)
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-100 hover:border-yellow-200 transition duration-150">
                            <h3 class="font-bold text-gray-900 mb-1">{{ $certificate->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $certificate->issuing_organization }}</p>
                            <p class="text-sm text-gray-500 mb-4">{{ $certificate->issue_date->format('M Y') }}</p>
                            @if($certificate->url)
                                <a href="{{ $certificate->url }}" target="_blank" 
                                   class="inline-flex items-center text-sm text-yellow-600 hover:text-yellow-700 transition duration-150">
                                    <span>View Certificate</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 italic col-span-full">No certificates added yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-header font-bold text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Recent Posts
                </h2>
                <div class="space-y-6">
                    @forelse($user->posts as $post)
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                            <div class="content-fade prose max-w-none text-gray-600 mb-4 post-content-preview" data-content="{{ $post->content }}"></div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-6 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $post->created_at->diffForHumans() }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        {{ $post->likes->count() }} likes
                                    </span>
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        {{ $post->comments->count() }} comments
                                    </span>
                                </div>
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium transition duration-150 flex items-center">
                                    Read More
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">No posts yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.post-content-preview').forEach(async function(element) {
                try {
                    const content = JSON.parse(element.dataset.content);
                    if (content && content.blocks) {
                        let html = '';
                        let textCount = 0;
                        const maxChars = 150; // Maximum characters to show
                        
                        // Process only a few blocks to keep it short
                        for (const block of content.blocks) {
                            if (textCount >= maxChars) break;
                            
                            switch (block.type) {
                                case 'paragraph':
                                    const text = block.data.text;
                                    const remainingChars = maxChars - textCount;
                                    const displayText = text.length > remainingChars 
                                        ? text.substring(0, remainingChars) + '...' 
                                        : text;
                                    
                                    html += `<p>${displayText}</p>`;
                                    textCount += text.length;
                                    break;
                                    
                                case 'header':
                                    if (textCount < maxChars) {
                                        const headerText = block.data.text;
                                        html += `<h${block.data.level} class="font-bold mb-2">${headerText}</h${block.data.level}>`;
                                        textCount += headerText.length;
                                    }
                                    break;
                            }
                        }
                        
                        element.innerHTML = html || '<p class="text-gray-500">No content available</p>';
                    } else {
                        element.innerHTML = '<p class="text-gray-500">No content available</p>';
                    }
                } catch (error) {
                    console.error('Error parsing post content:', error);
                    element.innerHTML = '<p class="text-gray-500">Error displaying content</p>';
                }
            });
        });
    </script>
</body>
</html>