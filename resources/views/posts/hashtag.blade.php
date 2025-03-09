<x-app-layout>
    <div class="mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-header font-bold text-gray-900 flex items-center gap-2">
                        <span class="text-blue-600">#{{ $hashtag->name }}</span>
                    </h1>
                    <p class="text-gray-600 mt-1">{{ $posts->total() }} posts with this hashtag</p>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @foreach($posts as $post)
            <x-post :post="$post" />
        @endforeach
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</x-app-layout>