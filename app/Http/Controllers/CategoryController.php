<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CategoryController extends Controller
{

    public function __construct()
    {
        //Proteger rutas segun la autorizacion de los permisos
        $this->middleware('can:categories.index')->only('index');
        $this->middleware('can:categories.create')->only('create','store');
        $this->middleware('can:categories.edit')->only('edit','update');
        $this->middleware('can:categories.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::orderBy('id','desc')
            ->simplePaginate(5);

        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {

        $category = $request->all();

        $current_image = $category['image'];

        $split_url = explode("/",$current_image);

        $public_id = explode(".", $split_url[sizeof($split_url)-1]);

        //

        if($request->hasFile('image')){
            // $category['image'] = $request->file('image')->store('categories');
            $category['image'] = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'Categories',
            ])->getSecurePath();
        }
        Category::create($category);

        return redirect()->action([CategoryController::class,'index'])
            ->with('success-create','Categoría creada con éxito');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //

        $current_image = $category->image;

        $split_url = explode("/",$current_image);

        $public_id = explode(".", $split_url[sizeof($split_url)-1]);
        
        if($request->hasFile('image')){ // Check if an image file is uploaded
            // Delete the previous image if it exists
            // File::delete(public_path('storage/' . $category->image));
            Cloudinary::destroy("Categories/".$public_id[0]);
            // Upload the new image
            // $category->image = $request->file('image')->store('categories');
            $category->image = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'Categories',
            ])->getSecurePath();
        }
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'is_featured' => $request->is_featured,
            'status' => $request->status,
        ]);

        return redirect()->action([CategoryController::class,'index'])
            ->with('success-update','Categoría actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $current_image = $category->image;

        $split_url = explode("/",$current_image);

        $public_id = explode(".", $split_url[sizeof($split_url)-1]);        

        if($category->image) { // Check if the category has an image
            // File::delete(public_path('storage/' . $category->image)); // Delete the category image
            Cloudinary::destroy("Categories/".$public_id[0]);
        }
        $category->delete(); // Delete the category record

        return redirect()->action([CategoryController::class,'index'])
            ->with('success-delete','Categoría eliminada con éxito');
    }

    public function detail(Category $category){

        $this->authorize('published', $category);

        $articles = Article::where([
            ['category_id', $category->id],
            ['status', '1']
        ])
            ->orderBy('id', 'DESC')
            ->simplePaginate(5);

        $navbar = Category::where(['status' => 1, 'is_featured' => 1])
            ->paginate(3);

        return view('subscriber.categories.detail',compact('category', 'articles', 'navbar'));
    }
}
