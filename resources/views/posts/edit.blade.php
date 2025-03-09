<x-app-layout>
    <x-slot name="title">Edit Post - Dev Community</x-slot>
    
    @push('scripts-head')
    <!-- Editor.js and plugins -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@1.8.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/code@latest"></script>
    @endpush

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-header font-bold text-gray-900">Edit Post</h1>
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Feed
                    </a>
                </div>
                <form id="editPostForm" action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Post Title</label>
                            <input type="text" name="title" id="title" value="{{ $post->title }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label for="editorjs" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                            <div id="editorjs" class="border border-gray-300 rounded-md min-h-[300px] p-4"></div>
                            <input type="hidden" name="content" id="content">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                            @if($post->image)
                                <img src="{{ Storage::url($post->image) }}" alt="Current post image" class="max-h-48 rounded-lg mb-2">
                            @else
                                <p class="text-sm text-gray-500">No image attached</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Update Image (optional)
                            </label>
                            <input type="file" name="post_image" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('home') }}" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Post
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
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
            data: @json($post->content)
        });

        document.getElementById('editPostForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const outputData = await editor.save();
            document.getElementById('content').value = JSON.stringify(outputData);
            this.submit();
        });
    </script>
    @endpush
</x-app-layout>