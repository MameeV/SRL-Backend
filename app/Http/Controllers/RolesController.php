<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;
use App\Role;

class RolesController extends Controller
{
    public function index ()
    {
      $role = Role::all();

      return Response::json($role);
    }

    public function store(Request $request)
    {
      $rules=[
        'name' => 'required',
      ];
      $validator = Validator::make(Purifier::clean($request->all()), $rules);
      if($validator->fails())
      {
        return Response::json(["error" => "Please fill out all fields."]);
      }

      $role = new Role;
      $role->name = $request->input("name");
      $role->save();

      return Response::json(["success"=>"Role has been assigned!"]);
    }

    public function update($id, Request $request)
    {
      $rules=[
        'name' => 'required',
      ];

      $validator = Validator::make(Purifier::clean($request->all()), $rules);
      if($validator->fails())
      {
        return Response::json(["error" => "Please fill out all fields"]);
      }

      $role = Role::find($id);
      $role->name = $reequest->input('name');
      $role->save();

      return Response::json(["success" => "Role Updated!"]);
    }

    public function show($id)
    {
      $role = Role::find($role->$id);
      return Response::json($role);
    }

    public function destroy($id)
    {
      $role = Role::find($id);

      $role->delete();
      return Response::json(["success" => "Role Deleted!"]);
    }
}
