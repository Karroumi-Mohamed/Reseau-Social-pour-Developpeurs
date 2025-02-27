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
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { 
            display: none !important; 
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }
        .font-header {
            font-family: 'Space Grotesk', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
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
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        <!-- Create Post Button -->
                        <button id="open-post-modal" class="mr-4 px-4 py-2 bg-gradient-to-r from-blue-600 to-green-500 text-white rounded-md hover:from-blue-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                            Create Post
                        </button>

                        <!-- Navigation Links -->
                        <div class="flex space-x-4 items-center">
                            <a href="{{ route('profile.show', Auth::user()) }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                My Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                    Log Out
                                </button>
                            </form>
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
                <div class="-mr-2 flex items-center sm:hidden" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed -->
                        <svg :class="{'hidden': open, 'block': !open }" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when menu is open -->
                        <svg :class="{'block': open, 'hidden': !open }" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="sm:hidden" x-show="open" @click.away="open = false">
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
                @auth
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
                                    <h2 class="text-xl font-header font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
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
                @endauth

                <!-- Right Content - Posts -->
                <div class="w-full {{ Auth::check() ? 'md:w-3/4' : 'md:w-2/3 mx-auto' }} space-y-6">
                    <!-- Posts List -->
                    @forelse($posts as $post)
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
                                
                                <h2 class="text-xl font-header font-semibold text-gray-900 mb-2">{{ $post->title }}</h2>
                                <div class="prose max-w-none mb-4">
                                    {!! app(\App\Http\Controllers\PostController::class)->renderContent($post->content) !!}
                                </div>
                                
                                @if($post->image)
                                    <div class="mt-4 mb-4">
                                        <img src="{{ Storage::url($post->image) }}" alt="Post image" class="rounded-lg max-h-96 w-full object-cover">
                                    </div>
                                @endif
                                
                                <div class="flex items-center space-x-6 text-sm text-gray-500">
                                    <button class="flex items-center space-x-2 hover:text-blue-600 transition duration-150">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        <span>{{ $post->likes->count() }} likes</span>
                                    </button>
                                    <button class="flex items-center space-x-2 hover:text-blue-600 transition duration-150">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <span>{{ $post->comments->count() }} comments</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 text-center">
                            <p class="text-gray-500">No posts yet. Be the first to share something!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Create Post Modal -->
    <div id="post-modal" 
        class="fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto hidden" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true">
        <div class="flex min-h-screen items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl">
                <form id="post-form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white">
                    @csrf
                    <div class="px-4 py-5 sm:p-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-header font-semibold text-gray-900">Create a Post</h3>
                            <p class="mt-1 text-sm text-gray-600">Share your thoughts, code snippets, or insights with the community.</p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" id="title" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                                <div id="editor-js" class="mt-1 block w-full min-h-[200px] border border-gray-300 rounded-md"></div>
                                <input type="hidden" name="content" id="content-input">
                            </div>

                            <div>
                                <label for="post-image" class="block text-sm font-medium text-gray-700">Image (optional)</label>
                                <input type="file" name="post_image" id="post-image" accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-medium
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100">
                            </div>

                            <div id="image-preview-container" class="hidden mt-4">
                                <div class="relative">
                                    <img id="image-preview" class="max-h-48 rounded-lg">
                                    <button type="button" id="remove-image"
                                        class="absolute top-2 right-2 p-1 rounded-full bg-gray-900 bg-opacity-50 text-white hover:bg-opacity-75">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 bg-gray-50">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-gradient-to-r from-blue-600 to-green-500 px-3 py-2 text-sm font-medium text-white shadow-sm hover:from-blue-700 hover:to-green-600 sm:ml-3 sm:w-auto">
                            Post
                        </button>
                        <button type="button" id="close-post-modal"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
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
        let editor = null;

        function initEditor() {
            if (editor) {
                editor.destroy();
            }

            editor = new EditorJS({
                holder: 'editor-js',
                placeholder: 'What\'s on your mind?',
                tools: {
                    header: {
                        class: Header,
                        config: {
                            levels: [2, 3, 4],
                            defaultLevel: 2
                        }
                    },
                    list: {
                        class: List,
                        inlineToolbar: true
                    },
                    code: {
                        class: Code,
                        config: {
                            placeholder: 'Enter code here...',
                            languages: {
                                javascript: 'JavaScript',
                                php: 'PHP',
                                python: 'Python',
                                java: 'Java',
                                cpp: 'C++',
                                csharp: 'C#',
                                ruby: 'Ruby',
                                css: 'CSS',
                                sql: 'SQL',
                                bash: 'Bash'
                            }
                        }
                    },
                    paragraph: {
                        class: Paragraph,
                        inlineToolbar: true
                    },
                    checklist: Checklist,
                    quote: Quote,
                    warning: Warning,
                    marker: Marker,
                    delimiter: Delimiter
                }
            });
        }

        document.getElementById('open-post-modal').addEventListener('click', function() {
            document.getElementById('post-modal').classList.remove('hidden');
            // Initialize editor when modal opens
            setTimeout(() => {
                initEditor();
            }, 100);
        });

        document.getElementById('close-post-modal').addEventListener('click', function() {
            document.getElementById('post-modal').classList.add('hidden');
            if (editor) {
                editor.clear();
            }
        });

        // Handle clicking outside modal
        document.getElementById('post-modal').addEventListener('click', function(event) {
            if (event.target === this) {
                this.classList.add('hidden');
                if (editor) {
                    editor.clear();
                }
            }
        });

        document.getElementById('post-image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview-container').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('remove-image').addEventListener('click', function() {
            document.getElementById('image-preview').src = '';
            document.getElementById('image-preview-container').classList.add('hidden');
            document.getElementById('post-image').value = '';
        });

        document.getElementById('post-form').addEventListener('submit', async function(event) {
            event.preventDefault();
            
            if (editor) {
                try {
                    const data = await editor.save();
                    document.getElementById('content-input').value = JSON.stringify(data);
                    this.submit();
                } catch (error) {
                    console.error('Error saving post:', error);
                    alert('Error saving your post. Please try again.');
                }
            }
        });
    </script>
</body>
</html>