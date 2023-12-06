<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        try {
            $data = Product::query()->latest()->paginate(5);

            return response()->json($data);

        } catch (\Exception $e) {
            
            Log::error('Exception', [$e]);

            return response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function store() {

        $validator = \Validator::make(\request()->all(), [
            'name' => 'required | max:100 | unique:products',
            'price' => 'required | numeric ',
            'img' => ' image | nullable',
            'description' => 'nullable',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        Product::create(\request()->all());

        return response()->json([], Response::HTTP_CREATED);
    }


    public function update(Product $product) {
        $validator = \Validator::make(\request()->all(), [
            'name' => 'required | max:100 | unique:products',
            'price' => 'required | numeric ',
            'img' => ' image | nullable',
            'description' => 'nullable',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product->update(\request()->all());

        return \response()->json([], Response::HTTP_OK);
    }

    public function destroy(Product $product) {
        $product->delete();

        return \response()->json([], Response::HTTP_OK);
    }
}
