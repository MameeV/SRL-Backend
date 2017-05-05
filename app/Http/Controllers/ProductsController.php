<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
      'name' => 'required',
      //add more!
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);
      if($validator->fails())
      {
        return Response::json(['error'=>"Error. Please Fill Out All Fields!"]);
      }

    $product = new Product;

    $product->name= $request->input('name');
    //add more!

    $product->save();

    return Response::json(["success" => "Congratulations, You Did It!"]);
  }
  public function update($id, Request $request)
  {
    $rules = [
      'name' => 'required',
      //add more!
    ];

    $validator = Validator::make(Purifier::clean($request->all()), $rules);
    if($validator->fails())
    {
      return Response::json(['error'=>"ERROR! Product did not update!"])
    }

    $product = Product::find($id);

    $product->name = $request->input('name');
    //add more!
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
