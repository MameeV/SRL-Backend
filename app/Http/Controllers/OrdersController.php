<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Auth;
use JWTAuth;

class OrdersController extends Controller
{
  {
    public function __construct()
    {
      $this->middleware("jwt.auth", ["only" => ["index", "store", "update", "show", "destroy"]]);
    }

    public function index()
    {
      $order = Order::all();

      $user = Auth::user();
      if($user->roleID ! = 1 || $user->id ! = $order->userID)
      {
        return Response::json(["error" => "Not Allowed!"]);
      }

      return Response::json($order);
    }

    public function store(Request $request);
    {
      $rules = [
        'usersID' => 'required',
        'productID' => 'required',
        'quantity' => 'required',
        'subtotal' => 'required',
        'total' => 'required',
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);
        if($validator->fails())
        {
          return Response::json(['error'=>"Error. Please Fill Out All Fields!"]);
        }

        $user = Auth::user();
        if($user->roleID ! = 1 || $user->id ! = $order->userID)
        {
          return Response::json(["error" => "Not Allowed!"]);
        }

      $Product=Product::find($request->input("productID"));
      if(empty($product))
      {
        return Response::json(["error" => "Product not found."]);
      }

      if($product->stock==0)

      {
        return Response::json(["error" => "Sorry, product is not available at this time."])
      }

      $order = new Order;

      $order->userID = Auth::user()->id;
      $order->productID = $request->input('productID');
      $order->quantity = $request->input('quantity');

      $subtotal = $request->input('quantity')*$product->price;
      $order->subtotal = $subtotal;


      $discount = 0;
      if($request->input('promoCode') == '10Off')
      {
        $order->promoCode = $request->input('promoCode');
        $discount = 0.10;
      }

      $totalAfterPromo = $subtotal * $discount;
      $subtotal = $subtotal - $totalAfterPromo;

//Richmond Co tax is 8%; need DB for each county/State to determine tax!
      $totalAfterTax = $subtotal * 0.08;
      $subtotal = $subtotal + $totalAfterTax;

//standard $10 shipping charge - Need DB for each zip code to determine charge!
      $total = $subtotal + 10.00;

      $order->total=$total;

      $order->comment = $request->input('comment');

      $order->save();

      return Response::json(["success" => "Thank you for your order!"]);
    }

    public function update($id, Request $request)
    {
      $rules = [
        'usersID' => 'required',
        'productID' => 'required',
        'quantity' => 'required',
        'subtotal' => 'required',
        'total' => 'required',

      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);
      if($validator->fails())
      {
        return Response::json(['error'=>"ERROR! Please fill out all fields."]);
      }

      $user = Auth::user();
      if($user->roleID ! = 1 || $user->id ! = $order->userID)
      {
        return Response::json(["error" => "Not Allowed!"]);
      }

      $Product=Product::find($request->input("productID"));
      if(empty($product))
      {
        return Response::json(["error" => "Product not found."]);
      }

      if($product->stock==0)

      {
        return Response::json(["error" => "Sorry, product is not available at this time."]);
      }

      $order = new Order;

      $order->userID = Auth::user()->id;
      $order->productID = $request->input('productID');
      $order->quantity = $request->input('quantity');

      $subtotal = $request->input('quantity')*$product->price;
      $order->subtotal = $subtotal;


      $discount = 0;
      if($request->input('promoCode') == 'US')
      {
        $order->promoCode = $request->input('promoCode');
        $discount = 0.10;
      }
//Would need DB for possible promoCodes!

      $totalAfterPromo = $subtotal * $discount;
      $subtotal = $subtotal - $totalAfterPromo;

//Richmond Co tax is 8%; need DB for each county/State to determine tax!
      $totalAfterTax = $subtotal * 0.08;
      $subtotal = $subtotal + $totalAfterTax;
      //Tax figured for shipping to Richmond County (Augusta, GA). Please call, or email, to place your order if you do not live in Richmond County!

//standard $10 shipping charge - Need DB for each zip code to determine charge!
      $total = $subtotal + 10.00;

      $order->total=$total;

      $order->comment = $request->input('comment');

      $order->save();

      return Response::json(['success' => "Order Has Been Updated!"]);
    }

    public function show($id)
    {
      $order = Order::find($id);

      return Response::json($order);

      $user=Auth::user();
      if($user->roleID ! = 1)
      {
        return Response::json(["error" => "Not Allowed!"]);
      }
    }

    public function destroy($id)
    {
      $order = Order::find($id);
      $user = Auth::user();
      if($user->roleID ! = 1 || $user->id ! = $order->userID)
      {
        return Response::json(["error" => "Not Allowed!"]);
      }

      $order->delete();

      return Response::json(['success' => "Order Deleted!"]);
    }
}
//On the Frontend, tell the Orderer that they must email their "non-profit paperwork" before their order will be processed (?putting their Order Number in the Subject Line of their Email)! OR have a spot to download the PDF during the ordering process (will need to be able to upload and save the file)
