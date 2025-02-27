<!-- Bio Form Component -->
<div>
    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Bio') }}</label>
    <textarea id="bio" name="bio" rows="4"
              class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
              placeholder="{{ __('Write a short bio about yourself...') }}">{{ old('bio', $user->bio) }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('bio')" />
</div>