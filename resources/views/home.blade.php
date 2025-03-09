<x-app-layout>
    <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-1/4">
            <x-profile-sidebar :user="Auth::user()" />
        </div>
        <div class="w-full md:w-3/4 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <button type="button" onclick="openCreatePostModal()"
                        class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-green-500 text-white rounded-md hover:from-blue-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
                        Create a New Post
                    </button>
                </div>
            </div>
            @foreach ($posts as $post)
                <x-post :post="$post" />
            @endforeach
        </div>
    </div>

    <x-post-modal />
</x-app-layout>
