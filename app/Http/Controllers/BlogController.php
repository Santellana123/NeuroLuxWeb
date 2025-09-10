<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Muestra la página principal del blog con todas las publicaciones.
     */
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->paginate(10);
        return view('blog', compact('posts'));
    }

    /**
     * Almacena una nueva publicación en la base de datos.
     */
    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
        }

        Auth::user()->posts()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'tags' => $validated['tags'],
            'image_path' => $path,
        ]);

        return redirect()->route('blog.index')->with('success', 'Publicación creada con éxito.');
    }

    /**
     * Actualiza una publicación existente.
     */
    public function updatePost(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = $post->image_path;
        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $path = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'tags' => $validated['tags'],
            'image_path' => $path,
        ]);

        return redirect()->route('blog.index')->with('success', 'Post actualizado correctamente.');
    }

    /**
     * Almacena un nuevo comentario y lo devuelve como JSON.
     */public function storeComment(Request $request, Post $post)
{
    $validated = $request->validate(['content' => 'required|string']);

    $comment = $post->comments()->create([
        'user_id' => Auth::id(),
        'content' => $validated['content'],
    ]);

    return $comment->load('user');
}

public function getComments(Post $post)
{
    $comments = $post->comments()->with('user')->latest()->get();
    return response()->json($comments);
}

    /**
     * Maneja el "like" o "unlike" de una publicación.
     */
    public function toggleLike(Post $post)
{
    $user = Auth::user();

    $like = $post->likes()->where('user_id', $user->id)->first();

    if ($like) {
        $like->delete();
        return response()->json([
            'status' => 'unliked',
            'likes_count' => $post->likes()->count()
        ]);
    } else {
        $post->likes()->create(['user_id' => $user->id]);
        return response()->json([
            'status' => 'liked',
            'likes_count' => $post->likes()->count()
        ]);
    }
}

}
