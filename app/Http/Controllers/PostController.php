<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_image' => 'nullable|image|max:5120', // 5MB max
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->user_id = $request->user()->id;

        // Handle image upload if present
        if ($request->hasFile('post_image')) {
            $path = $request->file('post_image')->store('post-images', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    public function renderContent($content)
    {
        try {
            $data = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($data['blocks'])) {
                return $this->parseEditorJsBlocks($data['blocks']);
            }
            
            // Fallback for plain text content
            return nl2br(e($content));
        } catch (\Exception $e) {
            return nl2br(e($content));
        }
    }
    
    private function parseEditorJsBlocks($blocks) 
    {
        $html = '';
        
        foreach ($blocks as $block) {
            switch ($block['type']) {
                case 'header':
                    $level = $block['data']['level'];
                    $text = e($block['data']['text']);
                    $html .= "<h{$level} class='text-{$level}xl font-semibold mb-3'>{$text}</h{$level}>";
                    break;
                
                case 'paragraph':
                    $text = e($block['data']['text']);
                    $html .= "<p class='mb-3'>{$text}</p>";
                    break;
                    
                case 'list':
                    $style = $block['data']['style'] === 'ordered' ? 'ol' : 'ul';
                    $html .= "<{$style} class='list-" . ($style === 'ol' ? 'decimal' : 'disc') . " pl-5 mb-3'>";
                    foreach ($block['data']['items'] as $item) {
                        $html .= "<li>" . e($item) . "</li>";
                    }
                    $html .= "</{$style}>";
                    break;
                    
                case 'code':
                    $code = e($block['data']['code']);
                    $html .= "<pre class='bg-gray-100 p-3 rounded mb-3 overflow-x-auto'><code>{$code}</code></pre>";
                    break;
                    
                case 'quote':
                    $text = e($block['data']['text']);
                    $caption = isset($block['data']['caption']) ? e($block['data']['caption']) : '';
                    $html .= "<blockquote class='border-l-4 border-gray-300 pl-4 italic mb-3'>";
                    $html .= "<p>{$text}</p>";
                    if (!empty($caption)) {
                        $html .= "<cite class='text-sm text-gray-600'>— {$caption}</cite>";
                    }
                    $html .= "</blockquote>";
                    break;
                
                case 'checklist':
                    $html .= "<div class='mb-3'>";
                    foreach ($block['data']['items'] as $item) {
                        $checked = $item['checked'] ? 'checked' : '';
                        $html .= "<div class='flex items-center'>";
                        $html .= "<div class='mr-2 w-5 h-5 rounded border " . ($checked ? 'bg-blue-500 border-blue-500' : 'border-gray-300') . "'></div>";
                        $html .= "<span>" . e($item['text']) . "</span>";
                        $html .= "</div>";
                    }
                    $html .= "</div>";
                    break;
                    
                case 'delimiter':
                    $html .= "<hr class='my-5 border-t border-gray-300'>";
                    break;
                    
                case 'warning':
                    $title = isset($block['data']['title']) ? e($block['data']['title']) : '';
                    $message = e($block['data']['message']);
                    $html .= "<div class='bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-3'>";
                    if (!empty($title)) {
                        $html .= "<h3 class='text-lg font-medium text-yellow-700'>{$title}</h3>";
                    }
                    $html .= "<p class='text-yellow-700'>{$message}</p>";
                    $html .= "</div>";
                    break;
                    
                default:
                    // For unsupported block types
                    if (isset($block['data']['text'])) {
                        $html .= "<p class='mb-3'>" . e($block['data']['text']) . "</p>";
                    }
                    break;
            }
        }
        
        return $html;
    }
}
