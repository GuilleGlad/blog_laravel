<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        #Obtener Articulos Publicados
        $articles = Article::where('status', 1)
            ->orderBy('id', 'DESC')
            ->simplePaginate(10);
            
        #Obtener Categorias para el Menu
        $navbar = Category::where(['status' => 1, 'is_featured' => 1])
            ->paginate(3);

        return view('home.index',compact('articles','navbar'));
    }

    public function all(){
        $categories = Category::where('status',1)
            ->simplePaginate(20);

        #Obtener Categorias para el Menu
        $navbar = Category::where(['status' => 1, 'is_featured' => 1])
            ->paginate(3);       
        
        return view('home.all-categories', compact('categories', 'navbar'));
    }

}
