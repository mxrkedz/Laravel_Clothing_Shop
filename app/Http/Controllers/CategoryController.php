<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
Use View;
Use Storage;
Use DB;
Use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        //dd(compact('categories'));
        return View::make('categorys.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('categorys.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'category_name' => 'required|min:3',
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'category_name.required' => 'The :attribute field is required.',
            'category_name.min' => 'Minimum of 3 characters please',
        ])->validate();

        $categories = new Category;

        $categories->category_name = $request->category_name;

        $categories->save();
        return redirect()->route('category.index')->with('added','Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories =  Category::find($id);
        return view('categorys.edit', compact('categories'));
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
        $rules = [
            'category_name' => 'required|max:255|min:3',
        ];
        $messages = [
            'category_name.required' => 'Please enter category name.',
            
        ];

        try {
            $validatedData = $request->validate($rules, $messages);
            $categories = Category::find($id);

        $categories->category_name = $request->category_name;
 
        $categories->save();
            
            
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->with('alert', 'Please fix the errors below.')->withInput();
        }
        
                return redirect()->route('category.index')->with('updated','Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
       return back()->with('deleted','Deleted!');
    }
}
