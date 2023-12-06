<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller {

    const PATH_VIEW = 'categories.';

    const PATH_UPLOAD = 'categories';
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = Category::query()
            ->latest()
            ->paginate(5);

        return view(self::PATH_VIEW.__FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view(self::PATH_VIEW.__FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'name' => ['required', 'unique:categories', 'max:100'],
            'img' => ['required', 'image', 'nullable'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $data = $request->except('img');

        if($request->hasFile('img')) {
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        Category::query()->create($data);

        return back()->with('msg', 'Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category) {
        return view(self::PATH_VIEW.__FUNCTION__, compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category) {
        $request->validate([
            'name' => ['required', 'max:100', Rule::unique('categories')->ignore($category->id)],
            'img' => ['nullable', 'image'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $data = $request->except('img');

        if($request->hasFile('img')) {
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        $category->update($data);

        return back()->with('msg', 'Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category) {
        $category->delete();

        if(Storage::exists($category->img)) {
            Storage::delete($category->img);
        }

        return back()->with('msg', 'Deleted successfully');
    }
}
