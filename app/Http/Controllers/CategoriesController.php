<?php

namespace App\Http\Controllers;

use Session;
use App\Category;
use App\Poll;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::orderBy('created_at', 'desc')->paginate(3)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category'  => 'required|unique:categories'
        ]);

        $category = new Category;

        $category->category = $request->category;
        $category->slug = str_slug($category->category);

        $category->save();

        Session::flash('success', 'Category created successfully');

        return redirect()->route('categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        $in_progress = Poll::where('category_id', $id)->where('voting_status', 'in-progress')->get();
        $concluded  = Poll::where('category_id', $id)->where('voting_status', 'concluded')->get();
        $suspended = Poll::where('category_id', $id)->where('voting_status', 'suspended')->get();

        return view('admin.categories.show', compact(['category', 'in_progress', 'concluded', 'suspended']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.categories.edit')->with('category', Category::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $this->validate($request, [
            'category' => 'required|unique:categories',
        ]);

        $category->category = $request->category;
        $category->slug = str_slug($category->category);
        $category->save();

        Session::flash('success', 'Category successfully updated');

        return redirect()->route('categories');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        Session::flash('success', 'category successfully deleted');

        return redirect()->back();
    }
}
