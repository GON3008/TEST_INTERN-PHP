<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class CategoryController extends Controller {
    public function index() {
        try {
            $data = Category::query()->latest()->paginate(5);

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Exception', [$e]);

            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function store() {

        $validator = \Validator::make(\request()->all(), [
            'name' => 'required | max:100 | unique:lists',
            'price' => 'required | numeric ',
            'img' => ' image | nullable',
            'description' => 'nullable',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        Category::create(\request()->all());

        return response()->json([], Response::HTTP_CREATED);
    }


    public function update(Category $category) {
        $validator = \Validator::make(\request()->all(), [
            'name' => 'required | max:100 | unique:categories',
            'price' => 'required | numeric ',
            'img' => 'required | image | nullable',
            'description' => 'nullable',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->update(\request()->all());

        return \response()->json([], Response::HTTP_OK);
    }

    public function destroy(Category $category) {
        $category->delete();

        return \response()->json([], Response::HTTP_OK);
    }
}
