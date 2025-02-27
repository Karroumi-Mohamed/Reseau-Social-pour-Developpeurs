<section>
    <header>
        <h2 class="font-header text-2xl font-bold text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Picture -->
        <div>
            <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('Profile Picture') }}
            </label>
            <div class="flex items-center space-x-6">
                <div class="flex-shrink-0">
                    @if($user->profile_picture)
                        <img class="h-16 w-16 rounded-full object-cover" src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-16 w-16 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center text-white text-xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                    @if($user->profile_picture)
                        <label for="remove_picture" class="inline-flex items-center mt-2">
                            <input type="checkbox" id="remove_picture" name="remove_picture" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remove current picture') }}</span>
                        </label>
                    @endif
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="sr-only">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" required
                   class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                   placeholder="Name"
                   value="{{ old('name', $user->name) }}"
                   autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Bio -->
        <div>
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Bio') }}</label>
            <textarea id="bio" name="bio" rows="4"
                      class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                      placeholder="{{ __('Write a short bio about yourself...') }}">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="sr-only">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" required
                   class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                   placeholder="Email address"
                   value="{{ old('email', $user->email) }}"  
                   autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="text-sm text-purple-500 hover:text-purple-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex justify-end items-center">
            <a href="{{ route('profile.show', Auth::user()) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md mr-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                {{ __('Back to Profile') }}
            </a>
            <button type="submit" class="group relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-400 to-blue-500 hover:from-green-500 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 ml-3 self-center"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
