// Initialize Editor.js for post creation
import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import List from '@editorjs/list';
import Code from '@editorjs/code';
import Paragraph from '@editorjs/paragraph';
import Checklist from '@editorjs/checklist';
import Quote from '@editorjs/quote';
import Warning from '@editorjs/warning';
import Marker from '@editorjs/marker';
import Delimiter from '@editorjs/delimiter';
import ImageTool from '@editorjs/image';
import Prism from 'prismjs';

// Import Prism languages and theme
import 'prismjs/components/prism-javascript';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-python';
import 'prismjs/components/prism-java';
import 'prismjs/components/prism-cpp';
import 'prismjs/components/prism-csharp';
import 'prismjs/components/prism-ruby';
import 'prismjs/components/prism-css';
import 'prismjs/components/prism-sql';
import 'prismjs/components/prism-bash';
import 'prismjs/themes/prism-okaidia.css';

document.addEventListener('DOMContentLoaded', function() {
    // Post creation modal handling
    const postModal = document.getElementById('post-modal');
    const openPostModalBtn = document.getElementById('open-post-modal');
    const closePostModalBtn = document.getElementById('close-post-modal');
    const postForm = document.getElementById('post-form');
    const editorContainer = document.getElementById('editor-js');
    const contentInput = document.getElementById('content-input');
    const postImageInput = document.getElementById('post-image');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const imagePreview = document.getElementById('image-preview');
    const removeImageBtn = document.getElementById('remove-image');

    let editor = null;

    // Initialize Editor.js if editor container exists
    if (editorContainer) {
        editor = new EditorJS({
            holder: 'editor-js',
            placeholder: "What's on your mind?",
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
                checklist: {
                    class: Checklist,
                    inlineToolbar: true
                },
                quote: {
                    class: Quote,
                    inlineToolbar: true
                },
                warning: Warning,
                marker: Marker,
                delimiter: Delimiter,
            },
            minHeight: 200,
            onChange: () => {
                // Highlight all code blocks when content changes
                setTimeout(() => {
                    document.querySelectorAll('pre code').forEach((block) => {
                        Prism.highlightElement(block);
                    });
                }, 0);
            }
        });
    }

    function openModal() {
        if (postModal) {
            postModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeModal() {
        if (postModal) {
            postModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            if (editor) {
                editor.clear();
            }
            postForm.reset();
            imagePreviewContainer.classList.add('hidden');
            imagePreview.src = '';
        }
    }

    // Event Listeners
    if (openPostModalBtn) {
        openPostModalBtn.addEventListener('click', openModal);
    }

    if (closePostModalBtn) {
        closePostModalBtn.addEventListener('click', closeModal);
    }

    // Close modal when clicking outside
    if (postModal) {
        postModal.addEventListener('click', (event) => {
            if (event.target === postModal) {
                closeModal();
            }
        });
    }

    // Handle image upload preview
    if (postImageInput) {
        postImageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Remove uploaded image
    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', () => {
            postImageInput.value = '';
            imagePreviewContainer.classList.add('hidden');
            imagePreview.src = '';
        });
    }

    if (postForm) {
        postForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            // Save Editor.js data
            if (editor) {
                try {
                    const editorData = await editor.save();
                    contentInput.value = JSON.stringify(editorData);

                    // Submit the form
                    postForm.submit();
                } catch (error) {
                    console.error('Error saving editor content', error);
                    alert('Error saving your post. Please try again.');
                }
            } else {
                postForm.submit();
            }
        });
    }

    document.querySelectorAll('pre code').forEach((block) => {
        Prism.highlightElement(block);
    });
});
