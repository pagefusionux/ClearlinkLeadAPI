<?php

namespace App\Http\Controllers;

use App\UserType;
use Illuminate\Http\Request;

class UserTypesController extends Controller {
  public function __construct() {
    $this->middleware('oauth', ['except' => ['index', 'show']]);
    // to use the following, we must differentiate between an admin and user (how? I dunno)
    //$this->middleware('authorize:' . __CLASS__, ['except' => ['index', 'show', 'store']]);
  }

  public function index() {
    $user_types = UserType::all();
    return $this->success($user_types, 200);
  }

  public function store(Request $request) {
    //$this->validateRequest($request);
    $user_type = UserType::create([
      'title' => $request->get('title')
    ]);
    return response()->json(['success' => true, 'last_insert_id' => $user_type->id], 200);
    //return $this->success("The user_type with with id {$user_type->id} has been created", 201);
  }

  public function show($id) {
    $user_type = UserType::find($id);
    if (!$user_type) {
      return $this->error("The user_type with {$id} doesn't exist", 404);
    }
    return $this->success($user_type, 200);
  }

  public function update(Request $request, $id) {
    $user_type = UserType::find($id);
    if (!$user_type) {
      return $this->error("The user_type with {$id} doesn't exist", 404);
    }
    $this->validateRequest($request);
    $user_type->title = $request->get('title');
    $user_type->save();
    return $this->success("The user_type with with id {$user_type->id} has been updated", 200);
  }

  public function destroy($id) {
    $user_type = UserType::find($id);
    if (!$user_type) {
      return $this->error("The user_type with {$id} doesn't exist", 404);
    }

    $user_type->delete();
    return $this->success("The user_type with with id {$id} has been deleted", 200);
  }

  public function validateRequest(Request $request) {
    $rules = [
      'title' => 'required'
    ];
    $this->validate($request, $rules);
  }

  public function isAuthorized(Request $request) {
    $resource = "user_types";
    $user_type = UserTypes::find($this->getArgs($request)["id"]);
    return $this->authorizeUser($request, $resource, $user_type);
  }
}
