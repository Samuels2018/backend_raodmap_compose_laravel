<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\products\Product;
use Validator;

class ProductController extends Controller {
	/*public function __construct() {
			$this->middleware('auth:api', ['except' => ['index', 'show', 'search']]);
			$this->middleware('admin', ['except' => ['index', 'show', 'search']]);
	}*/

	public function index() {
		$products = Product::all();
		return response()->json($products);
	}

	public function show($id) {
		$product = Product::find($id);
		if (!$product) {
			return response()->json(['message' => 'Product not found'], 404);
		}
		return response()->json($product);
	}

	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'description' => 'required|string',
			'price' => 'required|numeric|min:0',
			'stock' => 'required|integer|min:0',
			'image' => 'nullable|string'
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$product = Product::create($validator->validated());
		return response()->json($product, 201);
	}

	public function update(Request $request, $id) {
		$product = Product::find($id);
		if (!$product) {
			return response()->json(['message' => 'Product not found'], 404);
		}

		$validator = Validator::make($request->all(), [
			'name' => 'sometimes|string|max:255',
			'description' => 'sometimes|string',
			'price' => 'sometimes|numeric|min:0',
			'stock' => 'sometimes|integer|min:0',
			'image' => 'nullable|string'
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		}

		$product->update($validator->validated());
		return response()->json($product);
	}

	public function destroy($id) {
		$product = Product::find($id);
		if (!$product) {
			return response()->json(['message' => 'Product not found'], 404);
		}

		$product->delete();
		return response()->json(['message' => 'Product deleted successfully']);
	}

	public function search(Request $request) {
		$query = $request->input('query');
		$products = Product::where('name', 'like', "%$query%")
			->orWhere('description', 'like', "%$query%")
			->get();
		
		return response()->json($products);
	}
}