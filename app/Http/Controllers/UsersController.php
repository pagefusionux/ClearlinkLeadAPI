<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
  public function __construct()
  {
    $this->middleware('oauth', ['except' => ['index', 'show']]);
    //$this->middleware('authorize:' . __CLASS__, ['except' => ['index', 'show']]);
  }

  public function index()
  {
    $users = User::all();
    return $this->success($users, 200);
  }

  public function store(Request $request)
  {
    //$this->validateRequest($request);
    $user = User::create([
      'name' => $request->get('name'),
      'email' => $request->get('email'),
      'password' => Hash::make($request->get('password')),
      'notes' => $request->get('notes'),
      'user_type_id' => $request->get('user_type_id')
    ]);
    //return $this->success("The user with with id {$user->id} has been created with the default password of 'secret'", 201);
    return response()->json(['success' => true, 'last_insert_id' => $user->id], 200);
  }

  public function me()
  {
    $id = $this->getUserId();
    $user = User::find($id);

    if (!$user) {
      return $this->error("The user with {$id} doesn't exist", 404);
    }
    return $this->success($user, 200);
  }

  public function show($id)
  {
    $user = User::find($id);
    if (!$user) {
      return $this->error("The user with {$id} doesn't exist", 404);
    }
    return $this->success($user, 200);
  }

  public function update(Request $request, $id)
  {
    $user = User::find($id);
    if (!$user) {
      return $this->error("The user with {$id} doesn't exist", 404);
    }

    //$input = $request->all();

    //$this->validateUpdate($request);
    if ($request->get('name')) {
      $user->name = $request->get('name');
    }

    if ($request->get('email')) {
      $user->email = $request->get('email');
    }

    if ($request->get('password')) {
      $user->password = Hash::make($request->get('password'));
    }

    if ($request->get('notes')) {
      $user->notes = $request->get('notes');
    }

    if ($request->get('user_type_id')) {
      $user->user_type_id = $request->get('user_type_id');
    }

    $user->save();
    return $this->success("The user with with id {$id} has been updated", 200);
  }

  public function destroy($id)
  {
    $user = User::find($id);
    if (!$user) {
      return $this->error("The user with {$id} doesn't exist", 404);
    }
    $user->delete();
    return $this->success("The user with with id {$id} has been deleted", 200);
  }

  public function validateRequest(Request $request)
  {
    $rules = [
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6'
    ];
    $this->validate($request, $rules);
  }

  public function validateUpdate(Request $request)
  {
    $rules = [
      'id' => 'required|id|unique:users'
    ];
    $this->validate($request, $rules);
  }

  public function isAuthorized(Request $request)
  {
    $resource = "users";
    // $user     = User::find($this->getArgs($request)["user_id"]);
    return $this->authorizeUser($request, $resource);
  }
}
