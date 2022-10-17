<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $categoriesChildes = Category::with('children')->whereNull('haveSub')->whereNotNull('parent_id')->get();
        return view('admin.category.index',compact('categories','categoriesChildes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::whereNull('parent_id')->orderby('name', 'asc')->get();
        return view('admin.category.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'      => 'required',
            'parent_id' => 'nullable|numeric',
            'haveSub' => 'sometimes'
        ]);

        Category::create([
            'name' => $request->name,
            'parent_id' =>$request->parent_id,
            'haveSub' =>$request->haveSub
        ]);

        return redirect()->back()->with('success', 'Category has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $validatedData = $this->validate($request, [
            'name'  => 'required|min:3|max:255|string'
        ]);

        $category->update($validatedData);

        return redirect()->route('categories.index')->withSuccess('You have successfully updated a Category!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->children) {
            foreach ($category->children()->with('products')->get() as $child) {
                foreach ($child->products as $post) {
                    $post->update(['category_id' => NULL]);
                }
            }

            $category->children()->delete();
        }

        foreach ($category->products as $product) {
            $product->update(['category_id' => NULL]);
        }

        $category->delete();

        return redirect()->route('categories.index')->withSuccess('You have successfully deleted a Category!');
    }
    }
