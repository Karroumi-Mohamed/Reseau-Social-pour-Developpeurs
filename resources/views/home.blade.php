<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DevCommunity') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Editor.js and plugins -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@1.8.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
    
    <!-- Highlight.js for code syntax highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Custom Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="font-header text-xl font-bold bg-gradient-to-r from-blue-600 to-green-500 text-transparent bg-clip-text">
                            DevCommunity
                        </a>
                    </div>
                </div>

                <!-- Right Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    @auth
                        <!-- Create Post Button -->
                        <button type="button" 
                                onclick="openCreatePostModal()"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-green-500 hover:from-blue-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Post
                        </button>

                        <!-- Navigation Links -->
                        <div class="flex space-x-4 items-center">
                            <a href="{{ route('profile.show', Auth::user()) }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                My Profile
                            </a>

                            <!-- Profile Dropdown -->
                            <div class="ml-3 relative" x-data="{ open: false }">
                                <div>
                                    <button @click="open = !open" type="button" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        @if(Auth::user()->profile_picture)
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center text-white text-sm font-bold">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </button>
                                </div>

                                <!-- Dropdown menu -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                     role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95">
                                    <span class="block px-4 py-2 text-xs text-gray-400">
                                        {{ Auth::user()->name }}
                                    </span>
                                    
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Edit Profile
                                    </a>
                                    
                                    <!-- Logout Form -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-green-500 hover:from-blue-700 hover:to-green-600">
                            Register
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false" x-data="{ open: false }" @click="open = !open">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" x-show="!open">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" x-show="open">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="sm:hidden" id="mobile-menu" x-data="{ open: false }" x-show="open">
            <div class="pt-2 pb-3 space-y-1">
                @auth
                    <a href="{{ route('profile.show', Auth::user()) }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                        My Profile
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                        Edit Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Left Sidebar - Profile Summary -->
                <div class="w-full md:w-1/4">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center space-x-4 mb-6">
                                @if(Auth::user()->profile_picture)
                                    <img class="h-16 w-16 rounded-full object-cover" src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center text-white text-xl font-bold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->bio ?? 'No bio available' }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                @if(Auth::user()->github_link)
                                    <a href="{{ Auth::user()->github_link }}" target="_blank" 
                                       class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 transition duration-150">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.48 0-.237-.009-.866-.013-1.7-2.782.604-3.369-1.34-3.369-1.34-.454-1.155-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12c0-5.523-4.477-10-10-10z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>GitHub Profile</span>
                                    </a>
                                @endif
                                
                                @if(Auth::user()->gitlab_link)
                                    <a href="{{ Auth::user()->gitlab_link }}" target="_blank"
                                       class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 transition duration-150">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 0 1-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 0 1 4.82 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0 1 18.6 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.51L23 13.45a.84.84 0 0 1-.35.94z"/>
                                        </svg>
                                        <span>GitLab Profile</span>
                                    </a>
                                @endif
                            </div>

                            @if(Auth::user()->skills->isNotEmpty())
                                <div class="mt-6">
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Skills</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(Auth::user()->skills as $skill)
                                            <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-full">
                                                {{ $skill->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(Auth::user()->languages->isNotEmpty())
                                <div class="mt-4">
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Languages</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(Auth::user()->languages as $language)
                                            <span class="px-2 py-1 bg-green-50 text-green-700 text-xs rounded-full">
                                                {{ $language->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <a href="{{ route('profile.show', Auth::user()) }}" 
                                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                                    <span>View Full Profile</span>
                                    <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Posts -->
                <div class="w-full md:w-3/4 space-y-6">
                    <!-- Create Post Button -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <button type="button" 
                                    onclick="openCreatePostModal()"
                                    class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-green-500 text-white rounded-md hover:from-blue-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                                Create a New Post
                            </button>
                        </div>
                    </div>

                    <!-- Posts List -->
                    @foreach($posts as $post)
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    @if($post->user->profile_picture)
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ Storage::url($post->user->profile_picture) }}" 
                                             alt="{{ $post->user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-green-500 flex items-center justify-center text-white text-sm font-bold">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">{{ $post->user->name }}</h3>
                                        <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ $post->title }}</h2>
                                
                                <!-- Post Content -->
                                <div class="prose max-w-none mb-6 post-content" data-content="{{ $post->content }}"></div>
                                
                                @if($post->image)
                                    <div class="mt-4 mb-6">
                                        <img src="{{ Storage::url($post->image) }}" alt="Post image" class="rounded-lg max-h-96 w-auto">
                                    </div>
                                @endif
                                
                                <div class="flex items-center space-x-6 text-sm text-gray-500">
                                    <button onclick="toggleLike({{ $post->id }})" 
                                            class="like-button flex items-center space-x-2 hover:text-blue-600" 
                                            data-post-id="{{ $post->id }}">
                                        <svg class="h-5 w-5 like-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        <span class="likes-count">{{ $post->likes->count() }}</span>
                                        <span>likes</span>
                                    </button>
                                    <button class="flex items-center space-x-2 hover:text-blue-600">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <span>{{ $post->comments->count() }} comments</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Create Post Modal -->
    <div id="createPostModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <form id="createPostForm" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                    Create New Post
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <input type="text" 
                                               name="title" 
                                               id="post_title"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                                               placeholder="Post title">
                                    </div>
                                    <div>
                                        <div id="editorjs" class="border border-gray-300 rounded-md min-h-[300px] p-4"></div>
                                        <input type="hidden" name="content" id="content">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Image (optional)
                                        </label>
                                        <input type="file" 
                                               name="post_image" 
                                               accept="image/*"
                                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Publish Post
                        </button>
                        <button type="button" 
                                onclick="closeCreatePostModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    <script>
        // Initialize Editor.js
        const editor = new EditorJS({
            holder: 'editorjs',
            tools: {
                header: {
                    class: Header,
                    inlineToolbar: ['link'],
                    config: {
                        placeholder: 'Enter a header',
                        levels: [2, 3, 4],
                        defaultLevel: 3
                    }
                },
                list: {
                    class: List,
                    inlineToolbar: true
                },
                code: {
                    class: CodeTool,
                    config: {
                        placeholder: 'Enter code here'
                    }
                }
            },
            placeholder: "What's on your mind?"
        });

        // Modal functions
        function openCreatePostModal() {
            document.getElementById('createPostModal').classList.remove('hidden');
        }

        function closeCreatePostModal() {
            document.getElementById('createPostModal').classList.add('hidden');
        }

        // Handle form submission
        document.getElementById('createPostForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Save Editor.js content
            const outputData = await editor.save();
            document.getElementById('content').value = JSON.stringify(outputData);
            
            // Submit the form
            this.submit();
        });

        // Render post content
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.post-content').forEach(async function(element) {
                const content = JSON.parse(element.dataset.content);
                
                if (content && content.blocks) {
                    let html = '';
                    
                    for (const block of content.blocks) {
                        switch (block.type) {
                            case 'header':
                                html += `<h${block.data.level} class="text-xl font-bold mb-4">${block.data.text}</h${block.data.level}>`;
                                break;
                            case 'paragraph':
                                html += `<p class="mb-4">${block.data.text}</p>`;
                                break;
                            case 'list':
                                const listType = block.data.style === 'ordered' ? 'ol' : 'ul';
                                html += `<${listType} class="list-${block.data.style} pl-6 mb-4">`;
                                block.data.items.forEach(item => {
                                    html += `<li>${item}</li>`;
                                });
                                html += `</${listType}>`;
                                break;
                            case 'code':
                                html += `<pre><code class="language-${block.data.language || 'plaintext'}">${block.data.code}</code></pre>`;
                                break;
                        }
                    }
                    
                    element.innerHTML = html;
                    
                    // Initialize syntax highlighting
                    element.querySelectorAll('pre code').forEach((block) => {
                        hljs.highlightElement(block);
                    });
                }
            });
        });

        // Initialize likes on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize likes state for all posts
            document.querySelectorAll('.like-button').forEach(button => {
                const postId = button.dataset.postId;
                checkLikeStatus(postId);
            });
        });

        // Function to toggle like status
        async function toggleLike(postId) {
            try {
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
                    const icon = button.querySelector('.like-icon');
                    const count = button.querySelector('.likes-count');
                    
                    // Update like count
                    count.textContent = data.likesCount;
                    
                    // Update icon state
                    if (data.isLiked) {
                        icon.style.fill = 'currentColor';
                    } else {
                        icon.style.fill = 'none';
                    }
                }
            } catch (error) {
                console.error('Error toggling like:', error);
            }
        }

        // Function to check initial like status
        async function checkLikeStatus(postId) {
            try {
                const response = await fetch(`/posts/${postId}/check-like`);
                const data = await response.json();
                
                const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
                const icon = button.querySelector('.like-icon');
                
                if (data.isLiked) {
                    icon.style.fill = 'currentColor';
                }
            } catch (error) {
                console.error('Error checking like status:', error);
            }
        }
    </script>
</body>
</html>