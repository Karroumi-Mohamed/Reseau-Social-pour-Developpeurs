// Initialize the editor when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Only initialize editor if the container exists
    if (document.getElementById('editorjs')) {
        window.editor = new EditorJS({
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
    }

    // Initialize post form submission
    const createPostForm = document.getElementById('createPostForm');
    if (createPostForm) {
        createPostForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const outputData = await window.editor.save();
            document.getElementById('content').value = JSON.stringify(outputData);
            this.submit();
        });
    }

    // Render post content
    document.querySelectorAll('.post-content').forEach(async function(element) {
        try {
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
                            html +=
                                `<pre><code class="language-${block.data.language || 'plaintext'}">${block.data.code}</code></pre>`;
                            break;
                    }
                }
                element.innerHTML = html;
                element.querySelectorAll('pre code').forEach((block) => {
                    hljs.highlightElement(block);
                });
            }
        } catch (error) {
            console.error('Error parsing post content:', error);
            element.innerHTML = '<p class="text-gray-500">Error displaying content</p>';
        }
    });

    // Check if posts are liked by current user
    document.querySelectorAll('.like-button').forEach(button => {
        checkLiked(button.dataset.postId);
    });
});

// Make functions available globally
window.openCreatePostModal = function() {
    document.getElementById('createPostModal').classList.remove('hidden');
};

window.closeCreatePostModal = function() {
    document.getElementById('createPostModal').classList.add('hidden');
};

window.toggleLike = async function(postId) {
    try {
        const response = await fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
        const icon = button.querySelector('.like-icon');
        const count = button.querySelector('.likes-count')
        
        count.textContent = data.likesCount;
        if (data.isLiked) {
            icon.style.fill = 'currentColor'
        } else {
            icon.style.fill = 'none'
        }
    } catch (error) {
        console.error('error toggling like:', error);
    }
};

window.checkLiked = async function(postId) {
    try {
        const response = await fetch(`/posts/${postId}/check-like`);
        const data = await response.json();
        const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
        if (button) {
            const icon = button.querySelector('.like-icon');
            if (data.isLiked) {
                icon.style.fill = 'currentColor'
            }
        }
    } catch (error) {
        console.error('error checking if liked:', error);
    }
};

window.toggleComments = function(postId) {
    const commentsSection = document.getElementById(`comments-section-${postId}`);
    commentsSection.classList.toggle('hidden');
};

window.submitComment = async function(event, postId) {
    event.preventDefault();
    const form = event.target;
    const input = form.querySelector('.comment-input');
    const content = input.value.trim();
    
    if (!content) return;
    try {
        const response = await fetch(`/posts/${postId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ content })
        });
        if (response.ok) {
            const data = await response.json();
            const commentsContainer = form.closest('#comments-section-' + postId).querySelector('.comments-container');
            
            commentsContainer.insertAdjacentHTML('afterbegin', data.commentHtml);
            
            const commentsCountElement = document.querySelector(`button[onclick="toggleComments(${postId})"] .comments-count`);
            commentsCountElement.textContent = data.commentsCount;
            
            input.value = '';
        }
    } catch (error) {
        console.error('Error submitting comment:', error);
    }
};

window.deleteComment = async function(commentId, postId) {
    if (!confirm('Are you sure you want to delete this comment?')) return;
    try {
        const response = await fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        if (response.ok) {
            const data = await response.json();
            // Remove the comment element
            document.getElementById(`comment-${commentId}`).remove();
            
            // Update comments count
            const commentsCountElement = document.querySelector(`button[onclick="toggleComments(${postId})"] .comments-count`);
            commentsCountElement.textContent = data.commentsCount;
        }
    } catch (error) {
        console.error('Error deleting comment:', error);
    }
};

window.editPost = function(postId) {
    window.location.href = `/posts/${postId}/edit`;
};

window.deletePost = async function(postId) {
    if (!confirm('Are you sure you want to delete this post?')) return;
    try {
        const response = await fetch(`/posts/${postId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        if (response.ok) {
            location.reload();
        }
    } catch (error) {
        console.error('Error deleting post:', error);
    }
};