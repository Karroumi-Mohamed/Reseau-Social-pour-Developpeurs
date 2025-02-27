<!-- Profile Picture Form Component -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        {{ __('Profile Picture') }}
    </label>
    <div class="flex flex-col items-center space-y-4">
        <div class="flex-shrink-0">
            @if($user->profile_picture)
                <img class="h-32 w-32 rounded-full object-cover" src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}">
            @else
            <img class="h-32 w-32 rounded-full object-cover" src="{{ asset('/storage/profile-pictures/default.jpg') }}" alt="{{ $user->name }}">
            @endif
        </div>
        <div class="flex-1 w-full">
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