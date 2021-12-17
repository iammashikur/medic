<?php

namespace App\Http\Controllers;

use App\DataTables\TestSubcategoriesDataTable;
use App\Models\TestCategory;
use App\Models\TestSubcategory;
use Illuminate\Http\Request;

class TestSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TestSubcategoriesDataTable $dataTables)
    {
        return $dataTables->render('admin.test_subcategory_all');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = TestCategory::where(['hospital_id' => auth()->user()->hospital_id ])->get();
        return view('admin.test_subcategory_create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new TestSubCategory();
        $category->name = $request->name;
        $category->category_id = $request->category_id;
        $category->hospital_id = auth()->user()->hospital_id;
        $category->save();
        toast('Category Created!', 'success')->width('300px')->padding('10px');
        return redirect()->route('test-subcategory.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}