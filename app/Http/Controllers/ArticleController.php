<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ArticleRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ArticleController extends Controller
{

    public function __construct()
    {
        //Proteger rutas segun la autorizacion de los permisos
        $this->middleware('can:articles.index')->only('index');
        $this->middleware('can:articles.create')->only('create','store');
        $this->middleware('can:articles.edit')->only('edit','update');
        $this->middleware('can:articles.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch articles for the authenticated user
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->simplePaginate(10);
        
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch categories for the dropdown
        $categories = Category::select('id', 'name')
            ->where('status', 1)
            ->get();
        
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        // 
        $request->merge([
            'user_id' => Auth::user()->id,
        ]); // Add the authenticated user's ID to the request data

        $article = $request->all(); // Validate and create the article

        if($request->hasFile('image')){ // Check if an image file is uploaded
            // $article['image'] = $request->file('image')->store('articles');
            $article['image'] = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'Articles',
            ])->getSecurePath();
        }

        Article::create($article); // Create the article in the database
        
        return redirect()->action([ArticleController::class, 'index'])
            ->with('success-create', 'Articulo creado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        // 
        $this->authorize('published', $article); // Check if the article is published

        $comments = $article->comments()->simplePaginate(5); // Fetch comments for the article

        return view('subscriber.articles.show', compact('article', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('view', $article);
        //
        $categories = Category::select('id', 'name')
            ->where('status', 1)
            ->get(); // Fetch categories for the dropdown

        return view('admin.articles.edit', compact('article', 'categories'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);
        //
        $current_image = $article->image;

        $split_url = explode("/",$current_image);

        $public_id = explode(".", $split_url[sizeof($split_url)-1]);


        if($request->hasFile('image')){
            // Eliminar la imagen anterior si existe
            // File::delete(public_path('storage/' . $article->image));
            Cloudinary::destroy("Articles/".$public_id[0]);
            // Subir la nueva imagen
            // $article->image = $request->file('image')->store('articles');
            $article['image'] = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'Articles',
            ])->getSecurePath();
        }
        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'introduction' => $request->introduction,
            'body' => $request->body,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
        ]);
        
        return redirect()->action([ArticleController::class, 'index'])
            ->with('success-update', 'Articulo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $current_image = $article->image;

        $split_url = explode("/",$current_image);

        $public_id = explode(".", $split_url[sizeof($split_url)-1]);

        //
        if($article->image) { // Check if the article has an image
            // File::delete(public_path('storage/' . $article->image)); // Delete the article image
            Cloudinary::destroy("Articles/".$public_id[0]);
        }
        $article->delete(); // Delete the article from the database

        return redirect()->action([ArticleController::class, 'index'])
            ->with('success-delete', 'Articulo eliminado correctamente');
    }
}
