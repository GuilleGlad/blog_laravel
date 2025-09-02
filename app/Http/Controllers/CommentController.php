<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Http\Controllers\ArticleController;


class CommentController extends Controller
{

    public function __construct()
    {
        //Proteger rutas segun la autorizacion de los permisos
        $this->middleware('can:comments.index')->only('index');
        $this->middleware('can:comments.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener los comentarios de cada articulo incluyendo su usuario
        $user = Auth::user();
        $comments = DB::table('comments')
            ->join('articles', 'comments.article_id', '=', 'articles.id')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select('comments.id', 'comments.value', 'comments.description',
             'articles.title as article_title', 'users.full_name as user_name')
            ->where('articles.user_id', $user->id)
            ->orderBy('articles.id', 'DESC')
            ->get();

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        // 
        $user = Auth::user();
        $result = Comment::where('user_id', $user->id)
            ->where('article_id', $request->article_id)
            ->exists();
        
        $article = Article::select('status','slug')
            ->find($request->article_id);

        if(!$result && $article->status == 1){
            Comment::create([
                'value' => $request->value,
                'description' => $request->description,
                'user_id' => $user->id,
                'article_id' => $request->article_id,
            ]);

            return redirect()->action([ArticleController::class, 'show'], $article->slug);
        } else {
            return redirect()->action([ArticleController::class, 'show'], $article->slug)
                ->with('success-error', 'Solo puedes comentar una vez.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
        $comment->delete();
        // return redirect()->action([CommentController::class, 'index'])
        //     ->with('success-delete', 'Comentario eliminado correctamente');

        return redirect()->route('comments.index')->with('success-delete','Comentario eliminado correctamente');
    }
}
