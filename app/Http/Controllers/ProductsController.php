<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;

class ProductsController extends Controller
{
  public function index()
  {
    $products = Product::all();

    return Response::json($products);
  }

  public function store(Request $request)
  {
    $rules = [
      'productName' => 'required',
      'categoryID' => 'required',
      'image' => 'required',
      'description' => 'required',
      'price' => 'required',
      'stock' => 'required',
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);
      if($validator->fails())
      {
        return Response::json(['error'=>"Error. Please Fill Out All Fields!"]);
      }

    $product = new Product;

    $product->productName = $request->input('productName');
    $product->categoryID = $request->input('categoryID');
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->stock = $request->input('stock');

    $image = $request->('image');
    $imageName = $image->getClientOriginalName();
    $image->move('storage/', $imageName);
    $product->image = $request->root()."/storage/".$imageName;

    $product->save();

    return Response::json(["success" => "Congratulations, You Did It!"]);
  }

  public function update($id, Request $request)
  {
    $rules = [
      'productName' => 'required',
      'categoryID' => 'required',
      'image' => 'required',
      'description' => 'required',
      'price' => 'required',
      'stock' => 'required',

    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);
    if($validator->fails())
    {
      return Response::json(['error'=>"ERROR! Product did not update!"])
    }

    $product = Product::find($id);

    $product->productName = $request->input('productName');
    $product->categoryID = $request->input('categoryID');
    $product->description = $request->input('description');
    $product->price = $request->('price');
    $product->stock = $request->('stock');

    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image->move("storage/", $imageName);
    $product->image = $request->root()."storage/".$imageName;

    $product->save();

    return Response::json(['success' => "Product Has Been Updated!"])
  }

  public function show($id)
  {
    $product = Product::find($id);

    return Response::json($product);
  }

  public function destory($id)
  {
    $product = Product::find($id);

    $product->delete();

    return Response::json(['success' => "Product Deleted!"])
  }
}
