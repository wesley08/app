<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' =>'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);
  
        $email = $request->input('email');
        $name = $request->input('name');
        $password = Hash::make($request->input('password'));
  
        $user = User::create([
            'email' => $email,
            'name' => $name,
            'password' => $password
        ]);
  
        return response()->json(['message' => 'Data added successfully'], 201);
    }

    public function login(Request $request)
  {
      $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required|min:6'
      ]);

      $email = $request->input('email');
      $password = $request->input('password');

      $user = User::where('email', $email)->first();
      if (!$user) {
          return response()->json(['message' => 'Login failed'], 401);
      }

      $isValidPassword = Hash::check($password, $user->password);
      if (!$isValidPassword) {
        return response()->json(['message' => 'Login failed'], 401);
      }

      $generateToken = bin2hex(random_bytes(40));
      $user->update([
          'remember_token' => $generateToken
      ]);

      return response()->json($user);
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
