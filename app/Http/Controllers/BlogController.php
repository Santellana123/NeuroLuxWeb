<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Muestra la página principal del blog con los posts.
     */
    public function index()
    {
        // Se cargan los posts junto con los usuarios, comentarios y likes para evitar N+1
        $posts = Post::with('user', 'comments.user', 'likes')
            ->latest()
            ->paginate(10);

        return view('blog', compact('posts'));
    }

    /**
     * Almacena un nuevo post en la base de datos.
     */
    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $path,
        ]);

        return redirect()->route('blog.index')->with('success', 'Post creado correctamente.');
    }
    
    /**
     * Actualiza un post existente.
     */
    public function updatePost(Request $request, Post $post)
    {
        // Se asegura de que solo el dueño del post pueda editarlo
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('blog.index')->with('success', 'Post actualizado correctamente.');
    }

    /**
     * Almacena un nuevo comentario en la base de datos.
     */
    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('blog.index')->with('success', 'Comentario agregado.');
    }
    
    /**
     * Maneja la acción de dar "me gusta" a un post.
     */
    public function toggleLike(Post $post)
    {
        $user = Auth::user();
        
        // Busca si el usuario ya le dio "me gusta" al post
        $like = Like::where('post_id', $post->id)
                    ->where('user_id', $user->id)
                    ->first();

        if ($like) {
            // Si ya existe el "me gusta", lo elimina (un-like)
            $like->delete();
            return response()->json(['status' => 'unliked', 'likes_count' => $post->likes()->count()]);
        } else {
            // Si no existe, lo crea (like)
            $post->likes()->create(['user_id' => $user->id]);
            return response()->json(['status' => 'liked', 'likes_count' => $post->likes()->count()]);
        }
    }
}