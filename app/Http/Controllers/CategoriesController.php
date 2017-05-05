<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;

class CategoriesController extends Controller
{
    //will get list
    public function index()
    {
      //create a query to get a list and receive on the Frontend
      $catergories = Category::all();

      return Response::json($catories);
    }

    //store - takes request param from Frontend
    public function store(Request $request)
    {
      $rules = [
        'name' => 'required',
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);
        if($validator->fails())
        {
          return Response::json(['error'=>"Error. Please add a Category."]);
        }

      $category = new Category;

      $category->name = $request->input('name');

      $category->save();

      //return a response from server to the frontend. Will get either a Success or Error
      return Response::json(["success" => "Congratulations, You Did It!"]);
    }
    //update function - 2 params id & request
    public function update($id, Request $request)
    {
      $rules = [
        'name' => 'required',

      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);
      if($validator->fails())
      {
        return Response::json(['error'=>"ERROR! Category did not update!"])
      }

      $category = Category::find($id);

      $category->name = $request->input('name');

      return Response::json(['success' => "Category Has Been Updated!"])
    }

    //shows individual article
    public function show($id)
    {
      $category = Category::find($id);

      return Response::json($category);
    }

    //delete function to delete a single category
    public function destory($id)
    {
      $category = Category::find($id);

      $category->delete();

      return Response::json(['success' => "Category Deleted!"])
    }

}
