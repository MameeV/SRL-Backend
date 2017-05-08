<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Auth;

class OrdersController extends Controller
{
  {
    public function index()
    {
      $orders = Order::all();

      return Response::json($orders);
    }

    public function store(Request $request)
    {
      $rules = [
        'usersID' => 'required',
        'productID' => 'required',
        'subtotal' => 'required',
        'total' => 'required',


      ];
//can add comment: promocode...
//promo code
      $validator = Validator::make(Purifier::clean($request->all()), $rules);
        if($validator->fails())
        {
          return Response::json(['error'=>"Error. Please Fill Out All Fields!"]);
        }

      $order = new Order;
//Example:      $amount = $request->input('amount');
//Example:      $amount = $amount + 10;
//Example:      $order->amount=$amount;

      $subtotal = $request->input('subtotal');
      $total = $subtotal + 10.00;

      $order->usersID = $request->input('usersID');
      $order->productID = $request->input('productID');
      $order->subtotal = $subtotal;
      $order->total = $total;
      $order->save();

      return Response::json(["success" => "Congratulations, You Did It!"]);
    }
    public function update($id, Request $request)
    {
      $rules = [
        'usersID' => 'required',
        'productID' => 'required',
        'subtotal' => 'required',
        'total' => 'required',

      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);
      if($validator->fails())
      {
        return Response::json(['error'=>"ERROR! Order did not update!"])
      }

      $order = Order::find($id);

      $order->usersID = Auth::user()->id;
      $order->productID = $request->input('productID');
      $order->subtotal = $request->input('subtotal');
      $order->total = $request->input('total');

      return Response::json(['success' => "Order Has Been Updated!"])
    }

    public function show($id)
    {
      $order = Order::find($id);

      return Response::json($order);
    }

    public function destory($id)
    {
      $order = Order::find($id);

      $order->delete();

      return Response::json(['success' => "Order Deleted!"])
    }
}
