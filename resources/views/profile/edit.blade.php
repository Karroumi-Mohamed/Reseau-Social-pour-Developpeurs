<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Dev Community</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }

        .font-header {
            font-family: 'Space Grotesk', sans-serif;
        }

        .blob-profile {
            background: linear-gradient(135deg, #A78BFA, #FCD34D, #86EFAC);
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.6;
            position: absolute;
            animation: moveBlobsProfile 8s infinite alternate;
        }

        @keyframes moveBlobsProfile {
            0% {
                transform: translateY(0) translateX(0);
            }

            100% {
                transform: translateY(-10px) translateX(-10px);
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="blob-profile top-0 left-1/4 w-64 h-64"></div>
    <div class="blob-profile bottom-1/4 right-1/4 w-72 h-72"></div>

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-header text-3xl font-bold text-gray-900">{{ __('Profile Settings') }}</h2>
                <a href="{{ route('profile.show', Auth::user()) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                    {{ __('Back to Profile') }}
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <x-profile.picture-form :user="$user" />

                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 mb-2">{{ __('Name') }}</label>
                                <input id="name" name="name" type="text" required
                                    class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                    value="{{ old('name', $user->name) }}" autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- GitHub Link -->
                            <div>
                                <label for="github_link"
                                    class="block text-sm font-medium text-gray-700 mb-2">{{ __('GitHub Profile URL') }}</label>
                                <div class="mt-1 relative rounded-md shadow-sm group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <input type="url" name="github_link" id="github_link"
                                        class="appearance-none block w-full pl-10 py-2 pr-10 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"
                                        value="{{ old('github_link', $user->github_link) }}"
                                        placeholder="https://github.com/your-username"
                                        pattern="https://github\.com/.*"
                                    />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" onclick="validateGitHubUrl(this)" class="text-gray-400 hover:text-gray-600">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Enter your full GitHub profile URL (e.g., https://github.com/username)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('github_link')" />
                            </div>

                            <div>
                                <label for="gitlab_link"
                                    class="block text-sm font-medium text-gray-700 mb-2">{{ __('GitLab Profile URL') }}</label>
                                <div class="mt-1 relative rounded-md shadow-sm group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M22.65 14.39L12 22.13 1.35 14.39a.84.84 0 0 1-.3-.94l1.22-3.78 2.44-7.51A.42.42 0 0 1 4.82 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.49h8.1l2.44-7.51A.42.42 0 0 1 18.6 2a.43.43 0 0 1 .58 0 .42.42 0 0 1 .11.18l2.44 7.51L23 13.45a.84.84 0 0 1-.35.94z"/>
                                        </svg>
                                    </div>
                                    <input type="url" name="gitlab_link" id="gitlab_link"
                                        class="appearance-none block w-full pl-10 py-2 pr-10 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"
                                        value="{{ old('gitlab_link', $user->gitlab_link) }}"
                                        placeholder="https://gitlab.com/your-username"
                                        pattern="https://gitlab\.com/.*"
                                    />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" onclick="validateGitLabUrl(this)" class="text-gray-400 hover:text-gray-600">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Enter your full GitLab profile URL (e.g., https://gitlab.com/username)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('gitlab_link')" />
                            </div>

                            <script>
                                function validateGitHubUrl(button) {
                                    const input = document.getElementById('github_link');
                                    const url = input.value.trim();
                                    if (url && !url.startsWith('https://github.com/')) {
                                        input.value = 'https://github.com/' + url.split('/').pop();
                                    }
                                    button.classList.add('text-green-500');
                                    setTimeout(() => button.classList.remove('text-green-500'), 1000);
                                }

                                function validateGitLabUrl(button) {
                                    const input = document.getElementById('gitlab_link');
                                    const url = input.value.trim();
                                    if (url && !url.startsWith('https://gitlab.com/')) {
                                        input.value = 'https://gitlab.com/' + url.split('/').pop();
                                    }
                                    button.classList.add('text-green-500');
                                    setTimeout(() => button.classList.remove('text-green-500'), 1000);
                                }

                                document.getElementById('github_link').addEventListener('input', function(e) {
                                    const url = e.target.value.trim();
                                    if (url && !url.startsWith('https://')) {
                                        e.target.value = 'https://github.com/' + url.replace(/^[\/]*/, '');
                                    }
                                });

                                document.getElementById('gitlab_link').addEventListener('input', function(e) {
                                    const url = e.target.value.trim();
                                    if (url && !url.startsWith('https://')) {
                                        e.target.value = 'https://gitlab.com/' + url.replace(/^[\/]*/, '');
                                    }
                                });
                            </script>

                            <x-profile.bio-form :user="$user" />

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-400 to-blue-500 hover:from-green-500 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                                    {{ __('Save Changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">

                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <h3 class="text-xl font-header font-bold text-gray-900 mb-6">{{ __('Skills & Languages') }}</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="font-medium text-gray-900">{{ __('Skills') }}</h4>
                                    <button type="button" data-modal-target="skillsModal"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        {{ __('Add Skill') }}
                                    </button>
                                </div>
                                @if ($user->skills->isNotEmpty())
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($user->skills as $skill)
                                            <div class="group relative">
                                                <div
                                                    class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm font-medium flex items-center">
                                                    {{ $skill->name }}
                                                    <form method="POST" action="{{ route('skills.remove', $skill) }}"
                                                        class="ml-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-blue-400 hover:text-blue-600">
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                                            <svg class="h-full w-full" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">{{ __('No skills added yet') }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ __('Add your professional skills to showcase your expertise.') }}</p>
                                        <button type="button" data-modal-target="skillsModal"
                                            class="mt-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            {{ __('Add Your First Skill') }}
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="font-medium text-gray-900">{{ __('Languages') }}</h4>
                                    <button type="button" data-modal-target="languagesModal"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        {{ __('Add Language') }}
                                    </button>
                                </div>
                                @if ($user->languages->isNotEmpty())
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($user->languages as $language)
                                            <div class="group relative">
                                                <div
                                                    class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-medium flex items-center">
                                                    {{ $language->name }}
                                                    <form method="POST"
                                                        action="{{ route('languages.remove', $language) }}"
                                                        class="ml-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-green-400 hover:text-green-600">
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                                            <svg class="h-full w-full" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900">
                                            {{ __('No languages added yet') }}</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ __('Add languages you can communicate in.') }}</p>
                                        <button type="button" data-modal-target="languagesModal"
                                            class="mt-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            {{ __('Add Your First Language') }}
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <h3 class="text-xl font-header font-bold text-gray-900 mb-6">{{ __('Projects') }}</h3>
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-medium text-gray-900">{{ __('Projects') }}</h4>
                            <button type="button" data-modal-target="projectsModal"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('Add Project') }}
                            </button>
                        </div>

                        @if ($user->projects->isNotEmpty())
                            <div class="grid grid-cols-1 gap-6">
                                @foreach ($user->projects as $project)
                                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-bold text-gray-900">{{ $project->name }}</h3>
                                                <p class="mt-2 text-sm text-gray-600">{{ $project->description }}</p>
                                                @if ($project->url)
                                                    <a href="{{ $project->url }}" target="_blank"
                                                        class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                                        View Project
                                                        <svg class="ml-1 h-4 w-4" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                            <form method="POST" action="{{ route('projects.remove', $project) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-lg p-6 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                                    <svg class="h-full w-full" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-gray-900">{{ __('No projects added yet') }}</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ __('Showcase your work by adding your projects.') }}</p>
                                <button type="button" data-modal-target="projectsModal"
                                    class="mt-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Add Your First Project') }}
                                </button>
                            </div>
                        @endif

                    </div>

                    <!-- Certificates Section -->
                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <h3 class="text-xl font-header font-bold text-gray-900 mb-6">{{ __('Certificates') }}</h3>
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-medium text-gray-900">{{ __('Certificates') }}</h4>
                                <button type="button" data-modal-target="certificatesModal"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    {{ __('Add Certificate') }}
                                </button>
                            </div>

                            @if ($user->certificates->isNotEmpty())
                                <div class="grid grid-cols-1 gap-6">
                                    @foreach ($user->certificates as $certificate)
                                        <div class="bg-white rounded-lg border border-gray-200 p-6">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="font-bold text-gray-900">{{ $certificate->name }}</h3>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $certificate->issuing_organization }}</p>
                                                    <p class="text-sm text-gray-500">
                                                        {{ \Carbon\Carbon::parse($certificate->issue_date)->format('F Y') }}
                                                    </p>
                                                    @if ($certificate->url)
                                                        <a href="{{ $certificate->url }}" target="_blank"
                                                            class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                                            View Certificate
                                                            <svg class="ml-1 h-4 w-4" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('certificates.remove', $certificate) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-500">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-gray-50 rounded-lg p-6 text-center">
                                    <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                                        <svg class="h-full w-full" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19.364 8.464l-7.071-7.071a2 2 0 00-2.828 0L2.393 8.464a2 2 0 000 2.828l7.071 7.071a2 2 0 002.828 0l7.071-7.071a2 2 0 000-2.828z M12 6v6m0 0v6m0-6h6m-6 0H6">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900">
                                        {{ __('No certificates added yet') }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ __('Add your certifications and achievements.') }}</p>
                                    <button type="button" data-modal-target="certificatesModal"
                                        class="mt-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Add Your First Certificate') }}
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-lg space-y-8">
                        <div>
                            <h3 class="text-xl font-header font-bold text-gray-900 mb-4">{{ __('Email Settings') }}</h3>
                            <form method="post" action="{{ route('profile.email.update') }}" class="space-y-6">
                                @csrf
                                @method('patch')

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Email Address') }}</label>
                                    <input id="email" name="email" type="email" required
                                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                        value="{{ old('email', $user->email) }}" autocomplete="username" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-400 to-blue-500 hover:from-green-500 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                                        {{ __('Update Email') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div>
                            <h3 class="text-xl font-header font-bold text-gray-900 mb-4">{{ __('Update Password') }}
                            </h3>
                            @include('profile.partials.update-password-form')
                        </div>

                        <div>
                            <h3 class="text-xl font-header font-bold text-gray-900 mb-4">{{ __('Delete Account') }}
                            </h3>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2">
            {{ __('Profile updated successfully') }}
        </div>
    @endif

    <!-- Modal Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal handling functions
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            
            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            
            // Set up modal triggers
            document.querySelectorAll('[data-modal-target]').forEach(button => {
                button.addEventListener('click', () => {
                    const modalId = button.getAttribute('data-modal-target');
                    openModal(modalId);
                });
            });
            
            // Set up modal close buttons
            document.querySelectorAll('[data-modal-close]').forEach(button => {
                button.addEventListener('click', () => {
                    const modalId = button.closest('.modal').getAttribute('id');
                    closeModal(modalId);
                });
            });
            
            // Close modals when clicking overlay
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        closeModal(modal.id);
                    }
                });
            });
        });
    </script>

    <!-- Skills Modal -->
    <div id="skillsModal" class="modal fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl max-w-md w-full p-6 transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Add New Skill') }}</h3>
                <button type="button" data-modal-close class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('skills.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="skill_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Skill Name') }}</label>
                    <input type="text" name="name" id="skill_name" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-close class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                        {{ __('Add Skill') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Languages Modal -->
    <div id="languagesModal" class="modal fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl max-w-md w-full p-6 transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Add New Language') }}</h3>
                <button type="button" data-modal-close class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('languages.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="language_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Language Name') }}</label>
                    <input type="text" name="name" id="language_name" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-close class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                        {{ __('Add Language') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Projects Modal -->
    <div id="projectsModal" class="modal fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl max-w-md w-full p-6 transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Add New Project') }}</h3>
                <button type="button" data-modal-close class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('projects.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="project_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Project Title') }}</label>
                    <input type="text" name="name" id="project_name" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="project_description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Description') }}</label>
                    <textarea name="description" id="project_description" rows="3" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"></textarea>
                </div>
                <div>
                    <label for="project_url" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Project URL') }} ({{ __('Optional') }})</label>
                    <input type="url" name="url" id="project_url"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-close class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        {{ __('Add Project') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Certificates Modal -->
    <div id="certificatesModal" class="modal fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl max-w-md w-full p-6 transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Add New Certificate') }}</h3>
                <button type="button" data-modal-close class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('certificates.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="certificate_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Certificate Name') }}</label>
                    <input type="text" name="name" id="certificate_name" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="issuing_organization" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Issuing Organization') }}</label>
                    <input type="text" name="issuing_organization" id="issuing_organization" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Issue Date') }}</label>
                    <input type="month" name="issue_date" id="issue_date" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="certificate_url" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Certificate URL') }} ({{ __('Optional') }})</label>
                    <input type="url" name="url" id="certificate_url"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-close class="mr-3 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        {{ __('Add Certificate') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
